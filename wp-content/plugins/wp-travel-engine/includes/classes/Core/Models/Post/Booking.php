<?php
/**
 * Booking Model.
 *
 * @package WPTravelEngine/Core/Models
 * @since 6.0.0
 */

namespace WPTravelEngine\Core\Models\Post;

use WP_POST;
use WPTravelEngine\Abstracts\PostModel;
use WPTravelEngine\Core\Booking\Inventory;
use WPTravelEngine\Helpers\Functions;

/**
 * Class Booking.
 * This class represents a trip booking to the WP Travel Engine plugin.
 *
 * @since 6.0.0
 */
#[\AllowDynamicProperties]
class Booking extends PostModel {

	/**
	 * Post type name.
	 *
	 * @var string
	 */
	protected string $post_type = 'booking';

	/**
	 * @var null|Payment[] $payments Payments made for this booking.
	 */
	protected ?array $payments = null;

	/**
	 * Retrieves booking status.
	 *
	 * @return string Booking status
	 */
	public function get_booking_status() {
		return $this->get_meta( 'wp_travel_engine_booking_status' ) ?? 'pending';
	}

	/**
	 * Retrieves order trip.
	 *
	 * @return object|null Order trip.
	 */
	public function get_order_trip() {
		$order_trips = $this->get_meta( 'order_trips' ) ?? array();

		if ( ! is_array( $order_trips ) || empty( $order_trips ) ) {
			return null;
		}

		$order_trip_object = new \stdClass();

		$order_trip_object->cart_id = key( $order_trips );

		foreach ( current( $order_trips ) as $key => $value ) {
			$order_trip_object->$key = $value;
		}

		return $order_trip_object;
	}

	/**
	 * Get Booked Trip ID.
	 *
	 * @return int Booked Trip ID
	 */
	public function get_trip_id() {
		$order_trips = $this->get_order_items();

		return $order_trips['trip_id'] ?? 0;
	}

	/**
	 * Get Booked Trip Title.
	 *
	 * @return string Booked Trip Title
	 */
	public function get_trip_title() {
		$trip_id = $this->get_trip_id();

		return get_the_title( $trip_id ) ?? '';
	}

	/**
	 * Get Trip Cost.
	 *
	 * @return float Trip Cost
	 */
	public function get_trip_cost() {
		$order_trips = $this->get_order_items();

		return $order_trips['cost'] ?? 0;
	}

	/**
	 * Get Trip Partial Cost.
	 *
	 * @return float Trip Partial Cost
	 */
	public function get_partial_cost() {
		$order_trips = $this->get_order_items();

		return $order_trips['partial_cost'] ?? 0;
	}

	/**
	 * Get Trip DateTime.
	 *
	 * @return string Trip DateTime
	 */
	public function get_trip_datetime() {
		$order_trips = $this->get_order_items();

		return $order_trips['datetime'] ?? gmdate( 'Y-m-d' );
	}

	/**
	 * Get Trip Pax.
	 *
	 * @return array Trip Pax
	 */
	public function get_trip_pax() {
		$order_trips = $this->get_order_items();

		return $order_trips['pax'] ?? array();
	}

	/**
	 * Get Trip Pax Cost.
	 *
	 * @return array Trip Pax Cost
	 */
	public function get_trip_pax_cost() {
		$order_trips = $this->get_order_items();

		return $order_trips['pax_cost'] ?? array();
	}

	/**
	 * Get Trip Extras.
	 *
	 * @return array Trip Extras
	 */
	public function get_trip_extras() {
		$order_trips = $this->get_order_items();

		return $order_trips['trip_extras'] ?? array();
	}

	/**
	 * Get Trip Package name.
	 *
	 * @return string Trip Package name
	 */
	public function get_trip_package_name() {
		$order_trips = $this->get_order_items();

		return $order_trips['package_name'] ?? '';
	}

	/**
	 * Get Trip has time.
	 *
	 * @return bool Trip has time
	 */
	public function get_trip_has_time() {
		$order_trips = $this->get_order_items();

		return $order_trips['has_time'] ?? false;
	}

	/**
	 * Retrieves due amount.
	 *
	 * @return array Due Amount.
	 */
	public function get_due_amount() {
		return $this->get_meta( 'due_amount' ) ?? 0;
	}

	/**
	 * Retrieves paid amount.
	 *
	 * @return array Paid Amount
	 */
	public function get_paid_amount() {
		return $this->get_meta( 'paid_amount' ) ?? 0;
	}

	/**
	 * Retrieves booking cart info.
	 *
	 * @return mixed Booking cart info
	 */
	public function get_cart_info( $key = null ) {
		$cart_info = $this->get_meta( 'cart_info' ) ?? array();

		if ( ! is_null( $key ) ) {
			return $cart_info[ $key ] ?? null;
		}

		return $cart_info;
	}

	/**
	 * Retrieves booking cart info - Currency.
	 *
	 * @return string Currency
	 */
	public function get_currency() {
		$cart_info = $this->get_cart_info();

		return $cart_info['currency'] ?? '';
	}

	/**
	 * Retrieves booking cart info - Subtotal.
	 *
	 * @return float Subtotal
	 */
	public function get_subtotal() {
		$cart_info = $this->get_cart_info();

		return $cart_info['subtotal'] ?? 0;
	}

	/**
	 * Retrieves booking cart info - Total.
	 *
	 * @return float Total
	 */
	public function get_total() {
		$cart_info = $this->get_cart_info();

		return $cart_info['total'] ?? 0;
	}

	/**
	 * Retrieves booking cart info - Cart Partial.
	 *
	 * @return float Cart Partial
	 */
	public function get_cart_partial() {
		$cart_info = $this->get_cart_info();

		return $cart_info['cart_partial'] ?? 0;
	}

	/**
	 * Retrieves booking cart info - Discounts.
	 *
	 * @return array Discounts
	 */
	public function get_discounts() {
		$cart_info = $this->get_cart_info();

		return $cart_info['discounts'] ?? array();
	}

	/**
	 * Retrieves booking cart info - Tax Amount.
	 *
	 * @return float Tax Amount
	 */
	public function get_tax_amount() {
		$cart_info = $this->get_cart_info();

		return $cart_info['tax_amount'] ?? 0;
	}

	/**
	 * Retrieves payment details.
	 *
	 * @return array payment details
	 */
	public function get_payment_detail() {
		return $this->get_meta( 'payments' ) ?? array();
	}

	/**
	 * Retrives Payment Details - Payment Status.
	 *
	 * @return string Payment Status
	 */
	public function get_payment_status() {
		return $this->get_meta( 'wp_travel_engine_booking_payment_status' );
	}

	/**
	 * Retrives Payment Details - Payment Gateway.
	 *
	 * @return string Payment Gateway
	 */
	public function get_payment_gateway() {
		return $this->get_meta( 'wp_travel_engine_booking_payment_gateway' );
	}

	/**
	 * Retrives Payment Details - Payment Method.
	 *
	 * @return string Payment Method
	 */
	public function get_payment_method() {
		return $this->get_meta( 'wp_travel_engine_booking_payment_method' );
	}

	/**
	 * Retries Billing Info Data.
	 *
	 * @return string|array Billing Info Data
	 */
	public function get_billing_info( ?string $key = null ) {
		$billing_info = $this->get_meta( 'billing_info' ) ?? array();

		if ( ! is_null( $key ) ) {
			return $billing_info[ $key ] ?? '';
		}

		return $billing_info;
	}

	/**
	 * Get Billing Info - First Name.
	 *
	 * @return string First Name
	 */
	public function get_billing_fname() {
		$billing_info = $this->get_billing_info();

		return $billing_info['fname'] ?? '';
	}

	/**
	 * Get Billing Info - Last Name.
	 *
	 * @return string Last Name
	 */
	public function get_billing_lname() {
		$billing_info = $this->get_billing_info();

		return $billing_info['lname'] ?? '';
	}

	/**
	 * Get Order Items.
	 *
	 * @return array
	 */
	public function get_order_items(): array {
		$order_trips = $this->get_meta( 'order_trips' );

		return is_array( $order_trips ) ? array_values( $order_trips ) : array();
	}

	/**
	 * Get Payments Object.
	 *
	 * @return Payment[]
	 */
	public function get_payments(): array {
		if ( is_null( $this->payments ) ) {
			$payments = $this->get_meta( 'payments' ) ?? array();

			$this->payments = array_map(
				function ( $payment ) {
					return wptravelengine_get_payment( $payment );
				},
				$payments
			);
		}

		return array_filter( $this->payments );
	}

	/**
	 * @return void
	 */
	public function add_payment( int $payment_id ) {
		$payments = $this->get_meta( 'payments' );

		if ( ! is_array( $payments ) ) {
			$payments = array();
		}

		$payments[] = $payment_id;

		$this->set_meta( 'payments', array_unique( $payments ) );
	}

	/**
	 * Get Billing Info - Email.
	 *
	 * @return string Email
	 */
	public function get_billing_email() {
		$billing_info = $this->get_billing_info();

		return $billing_info['email'] ?? '';
	}

	/**
	 * Get Billing Info - Address.
	 *
	 * @return string Address
	 */
	public function get_billing_address() {
		$billing_info = $this->get_billing_info();

		return $billing_info['address'] ?? '';
	}

	/**
	 * Get Billing Info - City.
	 *
	 * @return string City
	 */
	public function get_billing_city() {
		$billing_info = $this->get_billing_info();

		return $billing_info['city'] ?? '';
	}

	/**
	 * Get Billing Info - Country.
	 *
	 * @return string Country
	 */
	public function get_billing_country() {
		$billing_info = $this->get_billing_info();

		return $billing_info['country'] ?? '';
	}

	/**
	 * Retrives Additional Fields Data.
	 *
	 * @return array Additional Fields Data
	 */
	public function get_additional_fields() {
		return $this->get_meta( 'additional_fields' ) ?? array();
	}

	/**
	 * Retrieves Traveler Info Data.
	 *
	 * @return string|array Traveler Info Data
	 */
	public function get_traveler_info() {
		return $this->get_meta( 'wp_travel_engine_placeorder_setting' ) ?? array();
	}

	/**
	 * Retrieves Traveler Info Data - Travelers.
	 *
	 * @return array Travelers
	 */
	public function get_travelers() {
		$traveler_info = $this->get_traveler_info();

		return $traveler_info['place_order']['travelers'] ?? array();
	}

	/**
	 * Retrives Traveler Info Data - Emergency Contact Details.
	 *
	 * @return array Emergency Contact Details
	 */
	public function get_emergency_contact() {
		$traveler_info = $this->get_traveler_info();

		return $traveler_info['place_order']['relation'] ?? array();
	}

	/**
	 * Set Billing Info.
	 *
	 * @return void
	 */
	public function set_billing_info( array $billing_info ) {
		$this->set_meta( 'billing_info', $billing_info );
	}

	/**
	 * Set Order Items.
	 *
	 * @return void
	 */
	public function set_order_items( array $items ) {
		$this->set_meta( 'order_trips', $items );
	}

	/**
	 * Set Cart Information.
	 *
	 * @return $this
	 */
	public function set_cart_info( array $data ): Booking {
		return $this->set_meta( 'cart_info', $data );
	}

	/**
	 * Update Booking Status.
	 *
	 * @return $this
	 */
	public function update_status( $status ): Booking {
		$this->update_meta( '_prev_booking_status', $this->get_booking_status() );

		$this->update_meta( 'wp_travel_engine_booking_status', $status );

		return $this;
	}

	/**
	 * Update Paid Amount.
	 * If parameter `$update` is false will replace the current meta-value.
	 *
	 * @return $this
	 */
	public function update_paid_amount( $amount, bool $update = true ): Booking {
		$previous_amount = $this->get_paid_amount();

		$amount = $update ? $previous_amount + $amount : $amount;
		$this->update_meta( 'paid_amount', $amount );

		return $this;
	}

	/**
	 * Update Due Amount.
	 *
	 * @return $this
	 */
	public function update_due_amount( $amount, bool $update = true ): Booking {
		$previous_amount = $this->get_due_amount();

		$amount = $update ? max( $previous_amount - $amount, 0 ) : $amount;
		$this->update_meta( 'due_amount', $amount );

		return $this;
	}

	/**
	 * Last Payment.
	 *
	 * @return  false|Payment
	 */
	public function get_last_payment() {
		$payments = $this->get_payments();

		return end( $payments );
	}

	/**
	 * Save Booking.
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_POST $post Post Object.
	 * @param bool    $update Update Flag.
	 */
	public static function save_post_booking( int $post_id, WP_Post $post, bool $update = false ) {

		$request = Functions::create_request( 'POST' );
		$booking = new static( $post );

		if ( $booking_status = $request->get_param( 'wp_travel_engine_booking_status' ) ) {
			$booking->set_meta( 'wp_travel_engine_booking_status', sanitize_text_field( $booking_status ) );
		}

		// Sets Paid amount.
		if ( is_numeric( $paid_amount = $request->get_param( 'paid_amount' ) ) ) {
			$booking->set_meta( 'paid_amount', $paid_amount );
		}

		// Sets due amount.
		if ( is_numeric( $due_amount = $request->get_param( 'due_amount' ) ) ) {
			$booking->set_meta( 'due_amount', $due_amount );
		}

		// Billing Info.
		if ( $billing_info = $request->get_param( 'billing_info' ) ) {
			$current_billing_info = $booking->get_billing_info();
			if ( is_array( $billing_info ) ) {
				foreach ( $billing_info as $key => $value ) {
					$current_billing_info[ $key ] = sanitize_text_field( wp_unslash( $value ) );
				}
				$booking->set_billing_info( $current_billing_info );
			}
		}

		// Payments.
		if ( $payments = $request->get_param( 'payments' ) ) {
			if ( is_array( $payments ) ) {
				foreach ( $payments as $payment_id => $payment_meta ) {
					/* @var Payment $payment */
					$payment = wptravelengine_get_payment( $payment_id );
					if ( isset( $payment_meta['payment_status'] ) ) {
						$payment->set_status( sanitize_text_field( wp_unslash( $payment_meta['payment_status'] ) ) );
					}
					if ( isset( $payment_meta['payment_gateway'] ) ) {
						$payment->set_payment_gateway( sanitize_text_field( wp_unslash( $payment_meta['payment_gateway'] ) ) );
					}

					if ( isset( $payment_meta['payable'] ) ) {
						$payable = $payment->get_meta( 'payable' ) ?? array();
						if ( $payment_meta['payable']['amount'] ) {
							$payable['amount'] = sanitize_text_field( wp_unslash( $payment_meta['payable']['amount'] ) );
						}
						if ( $payment_meta['payable']['currency'] ) {
							$payable['currency'] = sanitize_text_field( wp_unslash( $payment_meta['payable']['currency'] ) );
						}
						$payment->set_meta( 'payable', $payable );
					}
					$payment->save();
				}
			}
		}

		// Order Trips.
		if ( $order_trips = $request->get_param( 'order_trips' ) ) {
			$current_order_trips = $booking->get_meta( 'order_trips' );
			$_data               = array();
			foreach ( array_keys( $current_order_trips ) as $cart_id ) {
				if ( ! isset( $order_trips[ $cart_id ] ) ) {
					$_data[ $cart_id ] = $current_order_trips[ $cart_id ];
					continue;
				}
				$cart_data = $order_trips[ $cart_id ];

				if ( isset( $cart_data['ID'] ) ) {
					$_data[ $cart_id ]['ID']    = sanitize_text_field( $cart_data['ID'] );
					$_data[ $cart_id ]['title'] = get_the_title( $_data[ $cart_id ]['ID'] );
				}
				if ( isset( $cart_data['datetime'] ) ) {
					$_data[ $cart_id ]['datetime'] = sanitize_text_field( $cart_data['datetime'] );
				}

				if ( isset( $cart_data['end_datetime'] ) ) {
					$_data[ $cart_id ]['end_datetime'] = sanitize_text_field( $cart_data['end_datetime'] );
				}

				if ( isset( $cart_data['pax'] ) ) {
					$_data[ $cart_id ]['pax'] = array_map( 'absint', $cart_data['pax'] );
				}

				if ( isset( $cart_data['pax_cost'] ) ) {
					foreach ( $cart_data['pax_cost'] as $_id => $pax_cost ) {
						if ( ! isset( $_data[ $cart_id ]['pax'][ $_id ] ) ) {
							continue;
						}
						$pax_count                             = (int) $_data[ $cart_id ]['pax'][ $_id ];
						$_data[ $cart_id ]['pax_cost'][ $_id ] = $pax_count * (float) $pax_cost;
					}
				}

				if ( isset( $cart_data['cost'] ) ) {
					$_data[ $cart_id ]['cost'] = sanitize_text_field( $cart_data['cost'] );
				}

				$_data[ $cart_id ] = wp_parse_args( $_data[ $cart_id ], $current_order_trips[ $cart_id ] );
			}

			$booking->set_order_items( $_data );
		}

		// Sets Cart Info.
		if ( $cart_info = $request->get_param( 'cart_info' ) ) {

			$current_cart_info = $booking->get_cart_info();
			if ( is_array( $cart_info ) ) {
				foreach ( $cart_info as $key => $value ) {
					$current_cart_info[ $key ] = sanitize_text_field( wp_unslash( $value ) );
				}
				$booking->set_cart_info( $current_cart_info );
			}
		}

		// Sets Traveler's Information.
		$traveler_info = $request->get_param( 'wp_travel_engine_placeorder_setting' )['place_order'] ?? false;
		if ( ! $traveler_info ) {
			$traveler_info = $request->get_param( 'wp_travel_engine_booking_setting' )['place_order'] ?? false;
		}

		if ( $traveler_info ) {
			if ( is_array( $traveler_info ) ) {
				$travelers = array();
				if ( isset( $traveler_info['travelers'] ) && is_array( $traveler_info['travelers'] ) ) {
					foreach ( $traveler_info['travelers'] as $key => $value ) {
						$travelers['travelers'][ $key ] = array_map( 'sanitize_text_field', wp_unslash( $value ) );
					}
				}
				if ( isset( $traveler_info['relation'] ) && is_array( $traveler_info['relation'] ) ) {
					foreach ( $traveler_info['relation'] as $key => $value ) {
						$travelers['relation'][ $key ] = array_map( 'sanitize_text_field', wp_unslash( $value ) );
					}
				}
				$booking->set_meta(
					'wp_travel_engine_placeorder_setting',
					array( 'place_order' => $travelers )
				);
			}
		}

		$booking->save();
		$booking->maybe_update_inventory();
	}

	/**
	 * Handle post when trashing if post-type is booking.
	 *
	 * @param int $post_id Post ID.
	 *
	 * @return void
	 */
	public static function trashing_booking( int $post_id ): void {
		try {
			$booking = new static( $post_id );

			$booking->set_meta( '_prev_booking_status', $booking->get_booking_status() );
			$booking->update_status( 'canceled' );

			$booking->trashed = true;
			$booking->maybe_update_inventory();
		} catch ( \Exception $e ) {
			// Do nothing.
		}
	}

	/**
	 * Handle post when untrashing if post-type is booking.
	 *
	 * @param int $post_id Post ID.
	 *
	 * @return void
	 */
	public static function untrashing_booking( int $post_id ): void {
		try {
			$booking = new static( $post_id );

			$booking->update_status( $booking->get_meta( '_prev_booking_status' ) );
			$booking->untrashed = true;

			$booking->maybe_update_inventory();
		} catch ( \Exception $e ) {
			// Do nothing.
		}
	}

	/**
	 * Save Traveler's Information from the POST Request.
	 *
	 * @return void
	 */
	public static function save_travellers_information( $booking_id ) {

		if ( $booking_id ) {
			do_action( 'wp_travel_engine_before_traveller_information_save', $booking_id );
			static::save_post_booking( $booking_id, get_post( $booking_id ), true );
			do_action( 'wp_travel_engine_after_traveller_information_save', $booking_id );
			WTE()->session->delete( 'temp_tf_direction' );
		}
	}

	/**
	 * Maybe Update Inventory.
	 *
	 * @return void
	 */
	public function maybe_update_inventory(): void {
		$order_trips = $this->get_meta( 'order_trips' );

		if ( is_array( $order_trips ) ) {
			foreach ( $order_trips as $cart_id => $order_trip ) {
				$inventory = new Inventory( $order_trip['ID'] );
				$pax       = 0;

				if ( $this->trashed === true || 'canceled' === $this->get_booking_status() ) {
					$inventory->update_pax( $cart_id, 0, $order_trip['ID'], $this->ID );
					continue;
				}
				if ( is_array( $order_trip['pax'] ) ) {
					$pax = array_sum( $order_trip['pax'] );
				}

				$records = $inventory->get_inventory_record();
				if ( isset( $records[ $cart_id ][ $this->ID ] ) ) {
					$recorded_pax = $records[ $cart_id ][ $this->ID ];
					if ( $recorded_pax !== $pax ) {
						$inventory->update_pax( $cart_id, $pax, $order_trip['ID'], $this->ID );
					}
				} else {
					$inventory->update_pax( $cart_id, $pax, $order_trip['ID'], $this->ID );
				}
			}
		}
	}
}
