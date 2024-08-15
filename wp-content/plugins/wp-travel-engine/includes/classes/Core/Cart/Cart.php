<?php
/**
 * WP Travel Engine Core Cart.
 *
 * @package WP Travel Engine
 */

namespace WPTravelEngine\Core\Cart;

// Exit if accessed directly.
use WP_REST_Request;
use WPTravelEngine\Core\Tax;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Travel Engine Cart Shortcode Class.
 */
class Cart {

	/**
	 * Session key to hold cart data.
	 *
	 * @var string
	 */
	protected string $cart_id = 'wpte_trip_cart';

	/**
	 * Unique Cart Key for dirty cart.
	 *
	 * @var string
	 */
	protected string $cart_key = '';

	/**
	 * Limit of item in cart.
	 *
	 * @var integer
	 */
	protected int $item_limit = 0;

	/**
	 * Limit of quantity per item.
	 *
	 * @var integer
	 */
	protected int $quantity_limit = 99;

	/**
	 * Holds the Item objects in the cart.
	 *
	 * @var Item[] $items An array of Item objects.
	 */
	protected array $items = array();

	/**
	 * Cart Discounts.
	 *
	 * @var array
	 */
	protected array $discounts = array();

	/**
	 * Cart item attributes.
	 *
	 * @var array
	 */
	protected array $attributes = array();

	/**
	 * Cart errors.
	 *
	 * @var array
	 */
	protected array $errors = array();

	/**
	 * @var Tax $tax
	 */
	protected Tax $tax;

	/**
	 * @var string $payment_type Payment type. full|due|partial.
	 */
	protected string $payment_type = 'full';

	/**
	 * @var mixed|null
	 */
	protected $booking_ref = null;

	/**
	 * @var float[] $default_totals Default total values.
	 */
	protected array $default_totals = array(
		'subtotal'       => 0,
		'subtotal_tax'   => 0,
		'discount_total' => 0,
		'discount_tax'   => 0,
		'total'          => 0,
		'total_tax'      => 0,
		'partial_total'  => 0,
		'due_total'      => 0,
	);

	/**
	 * @var array $totals Total values of the cart.
	 */
	protected array $totals = array();

	/**
	 * Initialize shopping cart.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->tax = new Tax();
		// Read cart data on load.
		add_action( 'plugins_loaded', array( $this, 'read_cart_onload' ), 1 );
	}

	/**
	 * Get cart id.
	 *
	 * @return string
	 */
	public function get_cart_id(): string {
		return $this->cart_id;
	}

	/**
	 * Get cart key.
	 *
	 * @return string
	 * @since 6.0.0
	 */
	public function get_cart_key(): string {
		return $this->cart_key;
	}

	/**
	 * Output of cart shotcode.
	 *
	 * @since 2.2.3
	 */
	public static function output() {
		$wte = \wte_functions();
		wte_get_template( 'content-cart.php' );
	}

	/**
	 * @param mixed ...$args
	 *
	 * @return bool
	 */
	public function add( ...$args ): bool {

		if ( $args[0] instanceof WP_REST_Request ) {
			$request = $args[0];
		} else {
			$trip_id = $args[0];
			$attrs   = $args[1] ?? array();
			$request = $args[2] ?? null;
		}

		if ( ! $request instanceof WP_REST_Request ) {
			return false;
		}

		$cart_items = array();

		$this->cart_key = wptravelengine_generate_key( time() );

		if ( ! is_null( $request->get_param( 'booking_id' ) ) ) {
			$booking         = wptravelengine_get_booking( $request->get_param( 'booking_id' ) );
			$cart_info       = $booking->get_cart_info();
			$this->discounts = $cart_info['discounts'] ?? array();

			$order_items = $booking->get_order_items();
			foreach ( $order_items as $order_item ) {
				$cart_items[] = Item::from_order_item( $order_item, $booking, $this );
			}

			$this->set_payment_type( 'due' );
			WTE()->session->set( "__cart_{$this->cart_key}", array( 'booking_id' => $booking->get_id() ) );
			$this->set_booking_ref( $booking->get_id() );
		} else {
			$item       = Item::from_request( $request, $this );
			$attributes = $item->data();
			do_action( 'wte_before_add_to_cart', $item->trip_id, $attributes );

			$cart_items[] = $item;
			$this->set_booking_ref();
			$this->set_payment_type( 'full' );
		}

		foreach ( $cart_items as $item ) {
			$attributes = $item->data();
			do_action( 'wte_before_add_to_cart', $item->trip_id, $attributes );
			$this->items[ $item->id() ] = $item;
		}

		$this->calculate_totals();

		$this->write();

		/**
		 * TODO: Should deprecate this, this doesn't work if multi cart is implemented.
		 */
		do_action( 'wte_after_add_to_cart', $cart_items[0]->trip_id, $cart_items[0]->data() );

		return true;
	}

	/**
	 * Write changes to cart session.
	 */
	protected function write() {

		$cart_attributes_session_name = $this->cart_id . '_attributes';
		$items                        = array();

		foreach ( $this->items as $id => $item ) :
			if ( ! $id ) {
				continue;
			}
			$items[ $id ] = $item->data();
		endforeach;

		$cart['id']           = $this->cart_key;
		$cart['cart_items']   = $items;
		$cart['discounts']    = $this->discounts;
		$cart['attributes']   = $this->attributes;
		$cart['payment_type'] = $this->payment_type;
		$cart['booking_ref']  = $this->booking_ref;
		$cart['tax']          = $this->tax->get_tax_percentage();

		WTE()->session->set( $this->cart_id, $cart );

		// Cookie data to enable data info in js.
		// ob_start();
		// setcookie( 'wpte_trip_cart', wp_json_encode( $cart ), time() + 604800, '/SameSite=Lax' );
		// ob_end_flush();
	}

	/**
	 * Set Totals for current Cart.
	 *
	 * @return void
	 */
	public function calculate_totals() {
		$this->reset_totals();

		do_action( 'wptravelengine_before_calculate_totals', $this );

		foreach ( $this->items as $item ) {
			$this->totals['subtotal']       += $item->subtotal();
			$this->totals['subtotal_tax']   += $item->tax()['subtotal'] ?? 0;
			$this->totals['discount_total'] += $item->discount();
			$this->totals['discount_tax']   += $item->tax()['discount'] ?? 0;
			$this->totals['total_tax']      += $item->tax()['total'] ?? 0;
			$this->totals['total']          += $item->total();
			$this->totals['partial_total']  += $item->partial_total();
			$this->totals['due_total']      += $item->due_total();
		}

		do_action( 'wptravelengine_after_calculate_totals', $this );
	}

	/**
	 * Reset cart totals to the defaults.
	 */
	protected function reset_totals() {
		$this->totals = $this->default_totals;
	}

	/**
	 * Read items from cart session.
	 *
	 * @return void
	 */
	protected function read() {

		$cart = WTE()->session->get( $this->cart_id );

		// Bail if no cart components are set.
		if ( ! $cart ) {
			$this->reset_totals();

			return;
		}

		if ( $this->booking_ref ) {
			$booking = wptravelengine_get_booking( $this->booking_ref );

			if ( is_null( $booking ) ) {
				WTE()->session->delete( $this->cart_id );

				return;
			}

			$tax_amount = $booking->get_cart_info( 'tax_amount' );
			$this->tax->set_tax_percentage( $tax_amount ?? $this->tax->get_tax_percentage() );
		}

		$this->set_payment_type( $cart['payment_type'] ?? 'full' );
		$this->booking_ref = $cart['booking_ref'] ?? null;
		$this->discounts   = $cart['discounts'] ?? array();
		$this->attributes  = $cart['attributes'] ?? array();
		$this->cart_key    = $cart['id'] ?? '';

		$cart_items = $cart['cart_items'];

		if ( ! empty( $cart_items ) ) :
			foreach ( $cart_items as $id => $item ) :
				// Continue the loop if item is empty.
				if ( empty( $item ) ) {
					continue;
				}
				$this->items[ $id ] = new Item( $this, $item );
			endforeach;
		endif;

		$this->calculate_totals();
	}

	/**
	 * Set Payment Type.
	 *
	 * @param $payment_type
	 *
	 * @return void
	 * @since 6.0.0
	 */
	public function set_payment_type( $payment_type ) {
		$this->payment_type = $payment_type;
	}

	/**
	 * Set Booking Reference.
	 *
	 * @param int|null $booking_id Currently processing booking ID.
	 *
	 * @return void
	 */
	public function set_booking_ref( ?int $booking_id = null ) {
		$this->booking_ref = $booking_id;
	}

	/**
	 * @return void
	 */
	public function update_cart() {
		$this->write();
	}

	/**
	 * Update item quantity.
	 *
	 * @param int   $cart_item_id ID of target item.
	 * @param int   $qty Quantity.
	 * @param array $attr Attributes of item.
	 *
	 * @return boolean
	 */
	public function update( $cart_item_id, $pax, $trip_extras = false, $attr = array() ) {

		if ( is_array( $pax ) ) {

			if ( empty( $pax ) ) {

				return $this->remove( $cart_item_id );

			}
		}

		if ( isset( $this->items[ $cart_item_id ] ) ) {

			if ( is_array( $pax ) ) {

				$trip_id    = $this->items[ $cart_item_id ]['trip_id'];
				$trip_price = $this->items[ $cart_item_id ]['trip_price'];
				$cart_trip  = $this->items[ $cart_item_id ]['trip'];

				$trip_price         = 0;
				$trip_price_partial = 0;

				$this->items[ $cart_item_id ]['trip_price']         = $trip_price;
				$this->items[ $cart_item_id ]['trip_price_partial'] = $trip_price_partial;
			}

			$this->write();

			return true;
		}

		return false;
	}

	/**
	 * Add Discount Values
	 */
	public function add_discount_values( $discount_name, $discount_type, $discount_value ) {

		$discount_id = rand();

		$this->discounts[ $discount_id ]['name']  = $discount_name;
		$this->discounts[ $discount_id ]['type']  = $discount_type;
		$this->discounts[ $discount_id ]['value'] = $discount_value;

		$this->write();

		return true;
	}

	/**
	 * Check if cart has discounts.
	 *
	 * @return boolean
	 * @since 5.7.4
	 */
	public function has_discounts(): bool {
		return ! empty( $this->discounts );
	}

	/**
	 * Get discounts
	 */
	public function get_discounts() {
		return $this->discounts;
	}


	/**
	 * Return cart items for legacy support.
	 *
	 * @return array
	 * @since 5.7.4
	 */
	protected function get_formated_items(): array {
		$formated_items = array();
		foreach ( $this->items as $key => $item ) {
			$formated_items[ $key ] = $item->data();
		}

		return $formated_items;
	}

	/**
	 * Get list of items in cart.
	 *
	 * @return array An array of items in the cart.
	 * @since 5.7.4 Adds $return_item_objects parameter.
	 */
	public function getItems( $return_item_objects = false ) {
		return $return_item_objects ? $this->items : $this->get_formated_items();
	}

	public function cart_empty_message() {
		$url = get_post_type_archive_link( 'trip' );
		printf(
			esc_html__( 'Your cart is empty please %1$s click here %2$s to add trips.', 'wp-travel-engine' ),
			'<a href="' . esc_url( $url ) . '">',
			'</a>'
		);
	}

	/**
	 * Clear all items in the cart.
	 */
	public function clear() {

		$this->items        = array();
		$this->attributes   = array();
		$this->discounts    = array();
		$this->booking_ref  = null;
		$this->payment_type = 'full';
		$this->tax          = new Tax();

		$this->write();
	}

	/**
	 * Get all attributes.
	 *
	 * @access public
	 * @return mixed Attributes
	 * @since 3.0.5
	 */
	public function get_attributes() {
		return $this->attributes;
	}

	/**
	 * Set all attributes.
	 *
	 * @param mixed $attributes Atributes
	 *
	 * @return void
	 * @since 3.0.5
	 * @access public
	 */
	public function set_attributes( $attributes ) {
		$this->attributes = $attributes;
		$this->write();
	}

	/**
	 * Get a single attribute value.
	 *
	 * @param string $key Attribute key.
	 *
	 * @return mixed|string Attribute value.
	 */
	public function get_attribute( $key ) {
		if ( ! isset( $this->attributes[ $key ] ) ) {
			return false;
		}

		return $this->attributes[ $key ];
	}

	/**
	 * Set a single attribute value.
	 *
	 * @param string $key Attribute key.
	 * @param mixed  $value Attribute value.
	 *
	 * @return void
	 */
	public function set_attribute( $key, $value ) {
		$this->attributes[ $key ] = $value;
		$this->write();
	}


	/**
	 * Read cart items while load.
	 *
	 * @return void
	 */
	public function read_cart_onload() {
		$this->read();
	}

	/**
	 * Remove item from cart.
	 *
	 * @param integer $id ID of targeted item.
	 */
	public function remove( $id ) {

		unset( $this->items[ $id ] );

		unset( $this->attributes[ $id ] );

		$this->write();
	}

	/**
	 * Apply tax to cart totals.
	 *
	 * @param float $totals Cart totals.
	 *
	 * @return float
	 * @since 5.7.4
	 */
	protected function apply_tax( float $totals ): float {
		if ( $this->tax->is_taxable() && $this->tax->is_exclusive() ) {
			$totals = $totals + $this->tax->get_tax_amount( (float) $totals );
		}

		return $totals;
	}

	/**
	 * @param float $total
	 *
	 * @return float
	 */
	protected function calculate_discount( float $total ) {
		$totals = 0;
		if ( ! empty( $this->discounts ) ) {
			foreach ( $this->discounts as $discount ) :
				$discount_value = $discount['value'];
				switch ( $discount['type'] ) {
					case 'fixed':
						if ( $total > $totals ) {
							$totals += $discount_value;
						}
						break;
					case 'percentage':
						$discount_amount = ( $total * $discount_value ) / 100;
						if ( $total > $totals ) {
							$totals += $discount_amount;
						}
						break;
				}
				break; // TODO: Should look in case of multiple discount feature applied.
			endforeach;
		}

		return $totals;
	}

	/**
	 * @param $totals
	 *
	 * @return float
	 * @since 5.7.4
	 */
	public function apply_discounts( $totals ) {
		return $totals - $this->calculate_discount( $totals );
	}

	/**
	 * @return float
	 * @since 5.7.4
	 */
	public function get_extra_services_totals(): float {
		return (float) array_reduce(
			$this->items,
			function ( $carry, $item ) {
				return $carry + $item->trip_extras_totals();
			},
			0
		);
	}

	/**
	 * Get the total values of the shopping cart.
	 *
	 * @return array An array containing the following total values.
	 * @since 6.0.0
	 */
	public function get_totals(): array {
		return empty( $this->totals ) ? $this->default_totals : $this->totals;
	}

	/**
	 * @return float
	 * @since 5.7.4
	 */
	public function get_subtotal(): float {
		return apply_filters( 'wptravelengine_cart_sub_total', $this->totals['subtotal'] );
	}

	/**
	 * @return float
	 * @since 5.7.4
	 */
	public function get_discount_amount(): float {
		return apply_filters( 'wptravelengine_cart_discount_amount', round( $this->calculate_discount( $this->get_subtotal() ), 2 ) );
	}

	/**
	 * Get Discount Total.
	 *
	 * @return float
	 * @since 6.0.0
	 */
	public function get_discount_total(): float {
		return apply_filters( 'wptravelengine_cart_discount_total', $this->totals['discount_total'] );
	}

	/**
	 * @return float
	 * @since 5.7.4
	 */
	public function get_total_partial(): float {
		return $this->totals['partial_total'];
	}

	/**
	 * @return float
	 * @since 5.7.4
	 */
	public function get_due_total(): float {
		return $this->totals['due_total'];
	}

	/**
	 * Get the cart total value.
	 *
	 * @param bool $with_discount
	 * @param bool $with_tax
	 *
	 * @return float
	 * @since 6.0.0
	 */
	public function get_cart_total(): float {
		return $this->totals['total'];
	}

	/**
	 * Get the total values of the shopping cart.
	 *
	 * @param bool $with_discount (Optional) Whether to include discounts in the total. Default is true.
	 *
	 * @return array|float The total value of the cart, or an array if the method call is deprecated.
	 * @deprecated 6.0.0 Use WPTravelEngine\Core\Cart\Cart::get_totals() instead.
	 */
	public function get_total( bool $with_discount = true ): array {
		_deprecated_function( __METHOD__, '6.0.0', 'WPTravelEngine\Core\Cart\Cart::get_totals' );

		/**
		 * Represents the total value of the shopping cart.
		 */
		$cart_total = $this->totals['total'];

		/**
		 * Represents the amount of discount applied to a purchase.
		 */
		$discount_amount = $this->totals['discount_total'];

		/**
		 * Calculate the total cost of trip extras.
		 */
		$trip_extras_total = $this->get_extra_services_totals();

		$total_with_discount = $cart_total - $discount_amount;
		/**
		 * The total variable represents the sum of all values.
		 */
		$total = $this->totals['total'];

		/**
		 * Represents the partials of the cart total.
		 *
		 * @var array $cart_total_partial An array of partial values that make up the cart total.
		 */
		$cart_total_partial = $total_partial = $this->totals['partial_total'];

		/**
		 * Represents the amount of tax to be applied.
		 *
		 * @var float $tax_amount The value of the tax amount.
		 */
		$tax_amount = $this->totals['total_tax'];

		$sub_total = $this->totals['subtotal'];

		$cart_totals = compact( 'cart_total', 'sub_total', 'discount_amount', 'total', 'trip_extras_total', 'cart_total_partial', 'total_partial', 'tax_amount' );

		return apply_filters( 'wp_travel_engine_cart_get_total_fields', $cart_totals );
	}

	/**
	 * Return cart trip id.
	 *
	 * @return  string[]  trip id.
	 *
	 * @since   2.2.6
	 */
	public function get_cart_trip_ids(): array {
		return array_column( $this->getItems(), 'trip_id' );
	}

	/**
	 * Return Coupon Name.
	 *
	 * @return  String Singular Coupon Name id.
	 *
	 * @since
	 */
	public function get_cart_coupon_name() {
		$coupon_array  = array_column( $this->discounts, 'name' );
		$coupon_return = isset( $coupon_array[0] ) && ! empty( $coupon_array[0] ) ? esc_attr( $coupon_array[0] ) : '';

		return $coupon_return;
	}

	public function get_cart_coupon_type() {
		$coupon_array  = array_column( $this->discounts, 'type' );
		$coupon_return = isset( $coupon_array[0] ) && ! empty( $coupon_array[0] ) ? esc_attr( $coupon_array[0] ) : '';

		return $coupon_return;
	}

	public function get_cart_coupon_value() {
		$coupon_array  = array_column( $this->discounts, 'value' );
		$coupon_return = isset( $coupon_array[0] ) && ! empty( $coupon_array[0] ) ? esc_attr( $coupon_array[0] ) : '';

		return $coupon_return;
	}

	public function discount_clear() {
		$this->discounts = array();
		$this->write();
	}

	/**
	 * Get the tax object.
	 *
	 * @return Tax The tax value.
	 */
	public function tax(): Tax {
		return $this->tax;
	}

	/**
	 * Provides a payment type to distinguish between initial checkout or checkout for remaining amount.
	 *
	 * @return string
	 * @since 6.0.0
	 */
	public function get_payment_type(): string {
		return $this->payment_type;
	}

	/**
	 * Holds booking reference in case of due payment.
	 *
	 * @return mixed|null
	 * @since 6.0.0
	 */
	public function get_booking_ref() {
		return $this->booking_ref;
	}

	/**
	 * Are current cart items are loaded from booking?
	 *
	 * @return bool
	 * @since 6.0.0
	 */
	public function is_loaded_from_booking(): bool {
		return ! is_null( $this->booking_ref );
	}
}
