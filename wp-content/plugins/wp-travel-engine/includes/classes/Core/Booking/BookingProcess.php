<?php
/**
 * This file contains the BookingProcess class.
 *
 * @package WPTravelEngine\Core\Controllers
 * @since 6.0.0
 */

namespace WPTravelEngine\Core\Booking;

use WPTravelEngine\Abstracts\PaymentGateway;
use WPTravelEngine\Core\Cart\Cart;
use WPTravelEngine\Core\Cart\Item;
use WPTravelEngine\Core\Models\Post\Booking;
use WPTravelEngine\Core\Models\Post\Customer;
use WPTravelEngine\Core\Models\Post\Payment;
use WPTravelEngine\Core\Models\Post\Trip;
use WPTravelEngine\Modules\CouponCode;
use WPTravelEngine\PaymentGateways\PaymentGateways;
use WPTravelEngine\Utilities\RequestParser;
use WPTravelEngine\Validator\Checkout as CheckoutValidator;

class BookingProcess {

	/**
	 * Nonce key.
	 *
	 * @var string
	 */
	const NONCE_KEY = 'wp_travel_engine_new_booking_process_nonce';

	/**
	 * Nonce action.
	 *
	 * @var string
	 */
	const NONCE_ACTION = 'wp_travel_engine_new_booking_process_nonce_action';

	/**
	 * @var RequestParser
	 */
	protected RequestParser $request;

	/**
	 * @var Cart
	 */
	protected Cart $cart;

	/**
	 * Current Booking Payment Method.
	 *
	 * @var string
	 */
	protected string $payment_method;

	/**
	 * Payment Model.
	 *
	 * @var Payment
	 */
	protected Payment $payment;

	/**
	 * Booking Model.
	 *
	 * @var Booking
	 */
	protected Booking $booking;

	/**
	 * Customer Model.
	 *
	 * @var Customer
	 */
	protected Customer $customer;

	/**
	 * @var CheckoutValidator
	 */
	protected CheckoutValidator $validator;

	/**
	 * Billing Info.
	 *
	 * @var array
	 */
	protected array $billing_info;

	/**
	 * @var string full_payment|partial|due
	 */
	protected string $payment_type;

	/**
	 * BookingProcess constructor.
	 *
	 * @param RequestParser $request Request parser.
	 * @param Cart $cart Cart.
	 */
	public function __construct( RequestParser $request, Cart $cart ) {
		if ( empty( $cart->getItems( true ) ) ) {
			return;
		}

		$this->request = $request;
		$this->cart    = $cart;

		$this->validator = new CheckoutValidator();
		$is_valid_form   = $this->validate_form_data();
		WTE()->session->set( 'checkout_billing_info', $this->validator->sanitized() );
		if ( $is_valid_form ) {

			$payment_type       = $this->request->get_param( 'wp_travel_engine_payment_mode' ) ?? 'full_payment';
			$this->payment_type = 'remaining_payment' === $payment_type ? 'due' : $payment_type;

			$this->booking = $this->process_booking();

			$this->update_coupon_usage();

			$this->customer = $this->process_customer();
			$this->customer->update_customer_bookings( $this->booking->get_id() );

			$this->payment = $this->create_payment();

			$this->booking->add_payment( $this->payment->get_id() );

			$this->booking->save();
			$this->customer->save();
			$this->payment->save();

			$this->update_session();
			$this->payment_gateway_process();
			$this->send_notification_emails();

			if ( $this->payment_type === 'due' ) {
				do_action( 'wp_travel_engine_after_remaining_payment_process_completed', $this->booking->get_id() );
			} else {
				/**
				 * Hook to handle a payment process.
				 *
				 * @since 2.2.8
				 * @TODO: Remove on later update.
				 */
				do_action( 'wp_travel_engine_after_booking_process_completed', $this->booking->get_id() );
				do_action( 'wp_travel_engine_booking_completed_with_post_parameter', $request->get_params() ); // phpcs:ignore
			}

			// Redirect if not redirected till this point.
			$this->maybe_redirect();
		} else {
			wp_send_json_error( $this->validator->get_errors() );
		}
	}

	/**
	 * Redirect to thank you or travelers information page.
	 *
	 * @return void
	 */
	protected function maybe_redirect() {

		$this->cart->clear();
		// Redirect if not redirected till this point.
		if ( apply_filters( 'wptravelengine_redirect_after_booking', true ) ) {
			$redirect_url = wp_travel_engine_get_booking_confirm_url();

			$get_key = $this->payment->get_payment_key();

			set_transient( 'payment_key_' . $get_key, $this->payment->get_id(), 60 * 5 );

			wp_safe_redirect( add_query_arg( array( 'payment_key' => $get_key ), $redirect_url ) );
			exit;
		}
	}

	/**
	 * Triggers Payment Gateway.
	 *
	 * @return void
	 */
	protected function payment_gateway_process() {

		set_transient( "payment_key_{$this->payment->get_payment_key()}", $this->payment->get_id(), 60 * 10 );

		$payment_gateway = PaymentGateways::instance()->get_payment_gateway( $this->payment_method );

		if ( $payment_gateway instanceof PaymentGateway ) {
			$payment_gateway->process_payment( $this->booking, $this->payment, $this );
		} else {
			/**
			 * Recommended for WTE Payment Addons.
			 *
			 * @since 4.3.0
			 */
			do_action(
				"wte_payment_gateway_{$this->payment_method}",
				$this->payment->get_id(),
				$this->payment_type,
				$this->payment_method
			);
		}
	}

	/**
	 * Process Booking - create booking and update metas.
	 *
	 * @return Booking
	 */
	protected function process_booking(): Booking {
		if ( $booking_id = $this->get_booking_ref() ) {
			/* @var $booking Booking */
			$booking = Booking::make( $booking_id );
		} else {
			$booking = $this->create_booking();

			$this->set_booking_ref( $booking );
			/**
			 * @action_hook wte_created_user_booking
			 *
			 * @since 2.2.0
			 */
			do_action( 'wte_after_booking_created', $booking->get_id() );
		}

		$this->billing_info = $this->set_billing_info( $booking, $this->validator->sanitized()[ 'booking' ] );

		$this->set_order_items( $booking );

		$booking_title = implode(
			' ',
			array(
				$this->billing_info[ 'fname' ] ?? '',
				$this->billing_info[ 'lname' ] ?? '',
				"#{$booking->get_id()}",
			)
		);

		$booking->update_post(
			array(
				'post_title'  => $booking_title,
				'post_status' => 'publish',
			)
		);

		$this->payment_method = apply_filters(
			'wptravelengine_checkout_payment_method',
			$this->request->get_param( 'wpte_checkout_paymnet_method' ) ?? 'N/A',
			$booking->get_id()
		);

		if ( $ref = $this->request->get_param( "wte_pg_{$this->payment_method}_ref" ) ) {
			$booking->set_meta( "wte_pg_{$this->payment_method}_ref", (string) $ref );
		}

		// Sets booking meta for wp_travel_engine_booking_settings meta_key to retrieve data in booking details page and analytics.
		$items  = $this->cart->getItems( true );
		$_items = array();

		foreach ( $items as $cart_item ) {
			$data                 = $cart_item->data();
			$trip                 = new Trip( $data[ 'trip_id' ] ?? null );
			$cart_pricing_options = (array) $cart_item->pricing_options;
			$package              = get_post( $cart_item->price_key ?? null );

			$_items[ 'place_order' ] = array(
				'traveler'     => esc_attr( array_sum( $data[ 'pax' ] ?? array() ) ),
				'cost'         => esc_attr( $data[ 'trip_price' ] ?? '' ),
				'due'          => esc_attr( $this->cart->get_cart_total() - (float) ( $booking->get_meta( 'paid_amount' ) ?? 0 ) ),
				'tid'          => esc_attr( $trip->get_id() ?? '' ),
				'tname'        => esc_attr( $trip->get_title() ?? '' ),
				'datetime'     => ! empty( $data[ 'trip_date' ] ) ? $data[ 'trip_date' ] : '',
				'datewithtime' => ! empty( $data[ 'trip_time' ] ) ? $data[ 'trip_time' ] : '',
				'booking'      => $this->billing_info,
				'tax'          => esc_attr( $data[ 'tax' ] ?? '' ),
				'tduration'    => esc_attr( ( $trip->get_trip_duration() ?? '' ) . ' ' . ( $trip->get_trip_duration_unit() ?? '' ) ),
				'tenddate'     => ( $trip->get_trip_duration_unit() ?? '' ) == 'days' ? date( 'Y-m-d', strtotime( ( $data[ 'trip_date' ] ?? '' ) . '+' . ( $trip->get_trip_duration() ?? '' ) . ( $trip->get_trip_duration_unit() ?? '' ) ) ) : '',
				'trip_package' => esc_attr( $package->post_title ?? '' ),
			);

			// foreach ( $cart_pricing_options as $pricing_detail ) {
			// $_items['place_order'][ $pricing_detail['categoryInfo']['label'] ?? '' ] = esc_attr( $pricing_detail['pax'] ?? '' );
			// }

			if ( isset( $cart_item->trip_extras ) ) {
				$cart_extra_services                         = $cart_item->trip_extras;
				$_items[ 'place_order' ][ 'extra_services' ] = $cart_extra_services;
			}
		}

		return $booking->set_meta( 'wp_travel_engine_booking_payment_method', $this->payment_method )
					   ->set_meta( 'wp_travel_engine_booking_payment_gateway', $this->payment_method )
					   ->set_meta( 'paid_amount', (float) $booking->get_meta( 'paid_amount' ) )
					   ->set_meta( 'due_amount', $this->cart->get_cart_total() - (float) $booking->get_meta( 'paid_amount' ) ?? 0 )
					   ->set_cart_info(
						   array(
							   'currency'     => wptravelengine_settings()->get( 'currency_code', 'USD' ),
							   'subtotal'     => $this->cart->get_subtotal(),
							   'totals'       => $this->cart->get_totals(),
							   'total'        => $this->cart->get_cart_total(),
							   'cart_partial' => $this->cart->get_total_partial(),
							   'discounts'    => $this->cart->get_discounts(),
							   'tax_amount'   => $this->cart->tax()->is_taxable() && $this->cart->tax()->is_exclusive() ? $this->cart->tax()->get_tax_percentage() : 0,
						   )
					   )
					   ->set_meta( 'wp_travel_engine_booking_setting', $_items )->save();
	}

	/**
	 * Process customer insert and update customer meta.
	 *
	 * @return Customer
	 */
	protected function process_customer(): Customer {

		if ( $customer_id = Customer::is_exists( $this->billing_info[ 'email' ] ) ) {
			try {
				$customer_model = new Customer( $customer_id );
			} catch ( \Exception $e ) {
				$customer_model = Customer::create_post(
					array(
						'post_status' => 'publish',
						'post_type'   => 'customer',
						'post_title'  => $this->billing_info[ 'email' ],
					)
				);
			}

		} else {
			$customer_model = Customer::create_post(
				array(
					'post_status' => 'publish',
					'post_type'   => 'customer',
					'post_title'  => $this->billing_info[ 'email' ],
				)
			);
		}

		$customer_model->maybe_register_as_user();

		return $customer_model;
	}

	/**
	 * Process Payment.
	 *
	 * @return Payment
	 */
	protected function create_payment(): Payment {

		$amounts = array(
			'partial'      => $this->cart->get_total_partial(),
			'full_payment' => $this->cart->get_cart_total(),
			'due'          => $this->booking->get_due_amount(),
		);

		$payable_amount = $amounts[ $this->payment_type ];
		if ( $payment_id = $this->get_payment_ref() ) {
			$payment_model  = wptravelengine_get_payment( $payment_id );
			$payable_amount = $payment_model->get_payable_amount();
		} else {
			$last_payment = $this->booking->get_last_payment();
			if ( $last_payment && 'booking_only' === $last_payment->get_payment_gateway() && 'pending' === $last_payment->get_payment_status() ) {
				$payment_model  = $last_payment;
				$payable_amount = $last_payment->get_payable_amount();
			} else {
				$payment_model = Payment::create_post(
					array(
						'post_type'   => 'wte-payments',
						'post_status' => 'publish',
						'post_title'  => 'Payment',
					)
				);
			}
			$this->set_payment_ref( $payment_model );
		}

		$payment_model->set_meta(
			'payable',
			array(
				'currency' => wptravelengine_settings()->get( 'currency_code', 'USD' ),
				'amount'   => $payable_amount,
			)
		);

		$payment_model->set_meta( 'booking_id', $this->booking->get_id() )
					  ->set_meta( 'payment_gateway', $this->payment_method )
					  ->set_meta( 'payment_status', 'pending' )
					  ->set_meta( 'billing_info', $this->billing_info );

		$payment_types = apply_filters(
			'wte_payment_modes_and_titles',
			array(
				'full_payment' => 'Payment for booking #%s',
				'partial'      => 'Partial payment of booking #%s',
				'due'          => 'Due payment of booking #%s',
				'installment'  => 'Payment of booking #%s - #1',
			)
		);

		$payment_model->update_post(
			array(
				'post_title'  => sprintf( $payment_types[ $this->payment_type ] ?? 'Payment for booking #%s', $this->booking->get_id() ),
				'post_status' => 'publish',
			)
		);

		return $payment_model;
	}

	/**
	 * Update Coupon Usage.
	 *
	 * @return void
	 */
	protected function update_coupon_usage() {
		$discounts = $this->cart->get_discounts();
		if ( is_array( $discounts ) ) {
			foreach ( $discounts as $discount ) {
				$coupon_id = CouponCode::coupon_id_by_code( $discount[ 'name' ] );
				if ( $coupon_id ) {
					CouponCode::update_usage_count( $coupon_id );
				}
			}
		}
	}

	/**
	 * Set order items.
	 *
	 * @param Booking $booking Booking.
	 *
	 * @return void
	 */
	protected function set_order_items( Booking $booking ): void {
		$items = $this->cart->getItems( true );

		$_items = array();
		/* @var Item $item */
		foreach ( $items as $cart_item ) {
			$data         = $cart_item->data();
			$trip         = new Trip( $data[ 'trip_id' ] );
			$cart_item_id = $cart_item->id();

			$_items[ $cart_item_id ] = array(
				'ID'                 => $trip->get_id(),
				'title'              => $trip->get_title(),
				'cost'               => $data[ 'trip_price' ],
				'pax'                => $data[ 'pax' ],
				'pax_cost'           => $data[ 'pax_cost' ],
				// 'partial_cost'       => $data[ 'trip_price_partial' ], // TODO
				'multi_pricing_used' => $data[ 'multi_pricing_used' ],
				'trip_extras'        => $data[ 'trip_extras' ],
				'datetime'           => ! empty( $data[ 'trip_time' ] ) ? $data[ 'trip_time' ] : $data[ 'trip_date' ],
				'_prev_cart_key'     => $cart_item_id,
				'has_time'           => ! empty( $data[ 'trip_time' ] ),
				'_cart_item_object'  => $data,
				'package_name'       => get_the_title( $data[ 'price_key' ] ),
			);

			if ( isset( $data[ 'trip_time_range' ][ 1 ] ) ) {
				$_items[ $cart_item_id ][ 'end_datetime' ] = $data[ 'trip_time_range' ][ 1 ];
			}
		}

		$booking->set_order_items( $_items );
		$booking->save();
		$booking->maybe_update_inventory();
	}

	/**
	 * Set billing info.
	 *
	 * @param Booking $booking Booking model.
	 * @param array $form_data Form Data.
	 *
	 * @return array Billing Info.
	 */
	protected function set_billing_info( Booking $booking, $form_data ): array {
		$billing_info = array();
		foreach ( $form_data as $key => $value ) {
			$keys = explode( '.', $key );

			$billing_info[ array_pop( $keys ) ] = $value;
		}

		$booking->set_billing_info( $billing_info );

		return $billing_info;
	}

	/**
	 * Create a new booking.
	 *
	 * @return Booking
	 */
	protected function create_booking(): Booking {
		return Booking::create_post(
			array(
				'post_status' => 'publish',
				'post_type'   => 'booking',
				'post_title'  => 'booking',
				'meta_input'  => array(
					'wp_travel_engine_booking_payment_status' => 'pending',
					'wp_travel_engine_booking_payment_method' => __( 'N/A', 'wp-travel-engine' ),
					'billing_info'                            => array(),
					'cart_info'                               => array(
						'cart_total'   => 0,
						'cart_partial' => 0,
						'due'          => 0,
					),
					'payments'                                => array(),
					'paid_amount'                             => 0,
					'due_amount'                              => 0,
					'wp_travel_engine_booking_status'         => 'pending',
				),
			)
		);
	}

	/**
	 * Validate the booking request.
	 *
	 * @return bool
	 */
	public function validate_form_data(): bool {

		$result = $this->validator->validate( $this->request->get_body_params() );

		return ! $result->has_errors();
	}

	/**
	 * Get Payment Type.
	 *
	 * @return string
	 */
	public function get_payment_type(): string {
		return $this->payment_type;
	}

	/**
	 * Process Gateway Callback.
	 *
	 * @return void
	 */
	public static function process_gateway_callback() {
		if ( isset( $_REQUEST[ 'action' ], $_REQUEST[ '_gateway' ] ) ) {
			do_action( 'wte_callback_for_' . $_REQUEST[ '_gateway' ] . '_' . $_REQUEST[ 'action' ] );
		}

		if ( isset( $_REQUEST[ 'payment_key' ], $_REQUEST[ 'callback_type' ] ) ) {

			$payment_key = sanitize_text_field( $_REQUEST[ 'payment_key' ] );
			$payment_id  = get_transient( "payment_key_{$payment_key}" );

			if ( $payment_id ) {

				/* @var Payment $payment */
				$payment = Payment::make( $payment_id );

				$payment_gateway = $payment->get_payment_gateway();

				$instance = PaymentGateways::instance()->get_payment_gateway( $payment_gateway );

				$callback_type = sanitize_text_field( $_REQUEST[ 'callback_type' ] );
				$booking       = Booking::make( $payment->get_meta( 'booking_id' ) );
				if ( method_exists( $instance, "handle_{$callback_type}_request" ) ) {
					$instance->{"handle_{$callback_type}_request"}( $booking, $payment );
				}
			}
		}
	}

	/**
	 * Check if the request is a gateway callback.
	 *
	 * @return bool
	 */
	public static function is_gateway_callback(): bool {
		return isset( $_REQUEST[ 'action' ], $_REQUEST[ '_gateway' ] ) || isset( $_REQUEST[ 'payment_key' ], $_REQUEST[ 'callback_type' ] ) || isset( $_REQUEST[ '_action' ], $_REQUEST[ '_token' ] );
	}

	/**
	 * Check if the request is traveler information save request.
	 *
	 * @return bool
	 */
	public static function is_traveler_information_save_request(): bool {
		return check_ajax_referer( 'wp_travel_engine_final_confirmation_nonce', 'nonce', false );
	}

	/**
	 * Get Payment Method.
	 *
	 * @return string
	 */
	public function get_payment_method(): string {
		return $this->payment_method;
	}

	/**
	 * Check if the request is a due payment request.
	 *
	 * @return bool
	 */
	public static function is_due_payment_request(): bool {
		return check_ajax_referer( 'nonce_checkout_partial_payment_remaining_action', 'nonce_checkout_partial_payment_remaining_field', false ) !== false;
	}

	/**
	 * Check if the request is a booking request.
	 *
	 * @return bool
	 */
	public static function is_booking_request(): bool {
		if ( isset( $_REQUEST[ static::NONCE_KEY ] ) ) {
			if ( check_ajax_referer( static::NONCE_ACTION, static::NONCE_KEY, false ) !== false ) {
				return true;
			}
			wp_send_json_error( new \WP_Error( 'invalid_nonce', __( 'Nonce validation failed.', 'wp-travel-engine' ) ), 403 );
		}

		return false;
	}

	/**
	 * Send Booking Emails.
	 *
	 * @return void
	 */
	public function send_notification_emails() {
		if ( wptravelengine_settings()->get( 'email.disable_booking_notification', 'no' ) !== '1' ) {
			wptravelengine_send_booking_emails( $this->payment, 'order', 'admin' );
		}
		wptravelengine_send_booking_emails( $this->payment, 'order', 'customer' );
	}

	/**
	 * Update Session with current booking and payment ID for a further process.
	 *
	 * @return void
	 */
	protected function update_session() {
		WTE()->session->set( 'temp_tf_direction', "{$this->booking->ID}|{$this->payment->ID}|{$this->payment_method}" );
	}

	/**
	 * Update Booking State.
	 *
	 * @param string $key Key.
	 * @param mixed $value Value.
	 *
	 * @return void
	 */
	protected function update_booking_state( string $key, $value ) {
		$booking_state         = WTE()->session->get( '__cart_' . $this->cart->get_cart_key() ) ?? array();
		$booking_state[ $key ] = $value;
		WTE()->session->set( "__cart_{$this->cart->get_cart_key()}", $booking_state );
	}

	/**
	 * Get Booking Reference.
	 *
	 * @return int|false
	 */
	public function get_booking_ref() {
		return WTE()->session->get( '__cart_' . $this->cart->get_cart_key() )[ 'booking_id' ] ?? false;
	}

	/**
	 * Get Payment Reference.
	 *
	 * @return int|false
	 */
	public function get_payment_ref() {
		return WTE()->session->get( '__cart_' . $this->cart->get_cart_key() )[ 'payment_id' ] ?? false;
	}

	/**
	 * Set Booking Reference.
	 *
	 * @return void
	 */
	public function set_booking_ref( Booking $booking ) {
		$this->update_booking_state( 'booking_id', $booking->get_id() );
	}

	/**
	 * Set Payment Reference.
	 *
	 * @param Payment $payment Payment Object.
	 *
	 * @return void
	 */
	public function set_payment_ref( Payment $payment ) {
		$this->update_booking_state( 'payment_id', $payment->get_id() );
	}

	/**
	 * Initialize legacy booking hooks.
	 *
	 * TODO:Should be handled properly.
	 *
	 * @return void
	 */
	public static function initialize_legacy_booking_hooks() {
		add_action(
			'wte_after_thankyou_booking_details_direct_bank_transfer',
			function ( $payment_id ) {
				$settings     = get_option( 'wp_travel_engine_settings', array() );
				$instructions = $settings[ 'bank_transfer' ][ 'instruction' ] ?? '';
				?>
				<div class="wte-bank-transfer-instructions">
					<?php echo wp_kses_post( $instructions ); ?>
				</div>
				<h4 class="bank-details"><?php echo esc_html__( 'Bank Details:', 'wp-travel-engine' ); ?></h4>
				<?php
				$bank_details = isset( $settings[ 'bank_transfer' ][ 'accounts' ] ) && is_array( $settings[ 'bank_transfer' ][ 'accounts' ] ) ? $settings[ 'bank_transfer' ][ 'accounts' ] : array();
				foreach ( $bank_details as $bank_detail ) :
					$details = array(
						'bank_name'      => array(
							'label' => __( 'Bank:', 'wp-travel-engine' ),
							'value' => $bank_detail[ 'bank_name' ],
						),
						'account_name'   => array(
							'label' => __( 'Account Name:', 'wp-travel-engine' ),
							'value' => $bank_detail[ 'account_name' ],
						),
						'account_number' => array(
							'label' => __( 'Account Number:', 'wp-travel-engine' ),
							'value' => $bank_detail[ 'account_number' ],
						),
						'sort_code'      => array(
							'label' => __( 'Sort Code:', 'wp-travel-engine' ),
							'value' => $bank_detail[ 'sort_code' ],
						),
						'iban'           => array(
							'label' => __( 'IBAN:', 'wp-travel-engine' ),
							'value' => $bank_detail[ 'iban' ],
						),
						'swift'          => array(
							'label' => __( 'BIC/SWIFT:', 'wp-travel-engine' ),
							'value' => $bank_detail[ 'swift' ],
						),
					);
					?>
					<div class="detail-container">
						<?php
						foreach ( $details as $detail ) :
							?>
							<div class="detail-item">
								<strong class="item-label"><?php echo esc_html( $detail[ 'label' ] ); ?></strong>
								<span class="value"><?php echo esc_html( $detail[ 'value' ] ); ?></span>
							</div>
						<?php endforeach; ?>
					</div>
				<?php
				endforeach;
			}
		);
		add_action(
			'wte_after_thankyou_booking_details_check_payments',
			function () {
				$settings     = get_option( 'wp_travel_engine_settings', array() );
				$instructions = wte_array_get( $settings, 'check_payment.instruction', '' );
				?>
				<div class="wte-bank-transfer-instructions">
					<?php echo wp_kses_post( $instructions ); ?>
				</div>
				<?php
			}
		);

		add_action(
			'restrict_manage_posts',
			function ( $post_type ) {
				if ( 'booking' !== $post_type ) {
					return;
				}

				// Booking status
				$status = wp_travel_engine_get_booking_status();

				$selected = isset( $_REQUEST[ 'booking_status' ] ) ? sanitize_text_field( wp_unslash( $_REQUEST[ 'booking_status' ] ) ) : 'all';
				?>
				<select id="booking_status_filter" name="booking_status">
					<option value="all"> <?php esc_html_e( 'Booking Status', 'wp-travel-engine' ); ?> </option>
					<?php
					foreach ( $status as $key => $value ) :
						?>
						<option value="<?php echo esc_html( $key ); ?>" <?php selected( $selected, $key ); ?>>
							<?php echo esc_html( $status[ $key ][ 'text' ] ); ?>
						</option>
					<?php endforeach; ?>
				</select>
				<?php
			}
		);

		add_action(
			'parse_query',
			function ( $query ) {
				// Modify the query only if it is admin and main query.
				if ( ! is_admin() || ! $query->is_main_query() ) {
					return $query;
				}

				$current_screen = get_current_screen();

				$booking_status = 'all';
				if ( isset( $_REQUEST[ 'booking_status' ] ) ) {
					$booking_status = sanitize_text_field( wp_unslash( $_REQUEST[ 'booking_status' ] ) );
				}

				// Modify the query for the targeted screen and filter option.
				if ( ( 'edit-booking' !== $current_screen->id ) || 'all' == $booking_status ) {
					return $query;
				}

				$query->set(
					'meta_query',
					array(
						array(
							'key'     => 'wp_travel_engine_booking_status',
							'compare' => '=',
							'value'   => $booking_status,
							'type'    => 'string',
						),
					)
				);

				return $query;
			}
		);

		add_action(
			'wte_booking_cleanup',
			function ( $payment_id, $action = '' ) {
				global $wte_cart;
				$wte_cart->clear();
				if ( $action ) {
					delete_transient( "wte_token_{$action}" );
				}
			},
			11,
			2
		);

		add_action(
			'wte_redirect_after_payment_success',
			array(
				\WPTravelEngine\Core\Booking::class,
				'redirect',
			),
			90
		);
		add_action( 'wte_redirect_after_payment_error', array( \WPTravelEngine\Core\Booking::class, 'error' ), 90 );
	}
}
