<?php
/**
 * WP Travel Engine Core Cart.
 *
 * @package WP Travel Engine
 */

namespace WPTravelEngine\Core\Cart;
// Exit if accessed directly.
use WPTravelEngine\Core\Tax;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Travel Engine Cart Shortcode Class.
 */
class Cart {

	/**
	 * Cart id/ name.
	 *
	 * @var string
	 */
	private $cart_id;

	/**
	 * Limit of item in cart.
	 *
	 * @var integer
	 */
	private $item_limit = 0;

	/**
	 * Limit of quantity per item.
	 *
	 * @var integer
	 */
	private $quantity_limit = 99;

	/**
	 * Holds the Item objects in the cart.
	 *
	 * @var Item[] $items An array of Item objects.
	 */
	protected array $items = array();

	/**
	 * Cart Discounts.
	 *Î
	 *
	 * @var array
	 */
	private $discounts = array();

	/**
	 * Cart item attributes.
	 *
	 * @var array
	 */
	private $attributes = array();

	/**
	 * Cart errors.
	 *
	 * @var array
	 */
	private $errors = array();

	protected Tax $tax;

	/**
	 * Initialize shopping cart.
	 *
	 * @return void
	 */
	function __construct() {
		$this->tax = new Tax();

		$this->cart_id = 'wpte_trip_cart';

		// Read cart data on load.
		add_action( 'plugins_loaded', array( $this, 'read_cart_onload' ), 1 );
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
	 * @param mixed $trip_id Trip ID.
	 * @param array $attrs Item Attributes.
	 *
	 * @return bool
	 */
	public function add( $trip_id, array $attrs = array() ): bool {

		$item = new Item( $trip_id, $attrs );

		$this->items[ $item->id() ] = $item;

		$this->write();

		return true;
	}

	/**
	 * Write changes to cart session.
	 */
	private function write() {

		$cart_attributes_session_name = $this->cart_id . '_attributes';
		$items                        = array();

		foreach ( $this->items as $id => $item ) :
			if ( ! $id ) {
				continue;
			}
			$items[ $id ] = $item->data();
		endforeach;

		$cart[ 'cart_items' ] = $items;
		$cart[ 'discounts' ]  = $this->discounts;
		$cart[ 'attributes' ] = $this->attributes;

		$cart_items = WTE()->session->set( $this->cart_id, $cart );

		// Cookie data to enable data info in js.
		ob_start();
		setcookie( 'wpte_trip_cart', wp_json_encode( $cart ), time() + 604800, '/SameSite=Lax' );
		ob_end_flush();

	}

	/**
	 * Read items from cart session.
	 *
	 * @return void
	 */
	private function read() {

		$cart = WTE()->session->get( $this->cart_id );

		// Bail if no cart components are set.
		if ( ! $cart ) {
			return;
		}

		$cart_items       = $cart[ 'cart_items' ];
		$this->discounts  = isset( $cart[ 'discounts' ] ) ? $cart[ 'discounts' ] : array();
		$this->attributes = isset( $cart[ 'attributes' ] ) ? $cart[ 'attributes' ] : array();

		if ( ! empty( $cart_items ) ) :
			foreach ( $cart_items as $id => $item ) :
				// continue loop if item is empty.
				if ( empty( $item ) ) {
					continue;
				}
				$this->items[ $id ] = new Item( $item[ 'trip_id' ], $item );
			endforeach;
		endif;
	}

	/**
	 * Update item quantity.
	 *
	 * @param int $cart_item_id ID of targed item.
	 * @param int $qty Quantity.
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

				$trip_id    = $this->items[ $cart_item_id ][ 'trip_id' ];
				$trip_price = $this->items[ $cart_item_id ][ 'trip_price' ];
				$cart_trip  = $this->items[ $cart_item_id ][ 'trip' ];

				$trip_price         = 0;
				$trip_price_partial = 0;

				$this->items[ $cart_item_id ][ 'trip_price' ]         = $trip_price;
				$this->items[ $cart_item_id ][ 'trip_price_partial' ] = $trip_price_partial;
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

		$this->discounts[ $discount_id ][ 'name' ]  = $discount_name;
		$this->discounts[ $discount_id ][ 'type' ]  = $discount_type;
		$this->discounts[ $discount_id ][ 'value' ] = $discount_value;

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
			esc_html__( 'Your cart is empty please %s click here %s to add trips.', 'wp-travel-engine' ),
			'<a href="' . esc_url( $url ) . '">',
			'</a>'
		);
	}

	/**
	 * Clear all items in the cart.
	 */
	public function clear() {

		$this->items      = array();
		$this->attributes = array();
		$this->discounts  = array();

		$this->write();
	}

	/**
	 * Get all attributes.
	 *
	 * @access public
	 * @return mixed Attributes
	 * @since 3.0.5
	 *
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
	 * @param mixed $value Attribute value.
	 *
	 * @return void
	 */
	public function set_attribute( $key, $value ) {
		$this->attributes[ $key ] = $value;
		$this->write();
	}


	/**
	 * Read cart items on load.
	 *
	 * @return void
	 */
	function read_cart_onload() {

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
				$discount_value = $discount[ 'value' ];
				switch ( $discount[ 'type' ] ) {
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
		return (float) array_reduce( $this->items, function ( $carry, $item ) {
			return $carry + $item->trip_extras_totals();
		}, 0 );
	}

	/**
	 * @param bool $with_discount
	 * @param bool $with_tax
	 *
	 * @return float
	 * @since 5.7.4
	 */
	public function get_totals( bool $with_discount = true, bool $with_tax = true ): float {
		$total = (float) array_reduce( $this->items, function ( $carry, $item ) {
			return $carry + $item->totals();
		}, 0 );

		if ( $with_discount ) {
			$total = $this->apply_discounts( $total );
		}

		if ( $with_tax ) {
			$total = $this->apply_tax( $total );
		}

//		dd($total, false);

		return round( $total, 2 );
	}

	/**
	 * @return float
	 * @since 5.7.4
	 */
	protected function calculate_partial_totals(): float {
		if ( count( $this->items ) === 1 ) {
			$item = reset( $this->items );

			return $item->calculate_down_payment( $this->get_totals() );
		}

		return (float) array_reduce( $this->items, function ( $carry, $item ) {
			return $carry + $item->get_partial_total();
		}, 0 );
	}

	/**
	 * @return float
	 * @since 5.7.4
	 */
	public function get_subtotal(): float {
		return apply_filters( 'wptravelengine_cart_sub_total', round( $this->get_totals( false, false ), 2 ) );
	}

	/**
	 * @return float
	 * @since 5.7.4
	 */
	public function get_discount_amount(): float {
		return apply_filters( 'wptravelengine_cart_discount_amount', round( $this->calculate_discount( $this->get_subtotal() ), 2 ) );
	}

	/**
	 * @return float
	 * @since 5.7.4
	 */
	public function get_total_partial(): float {
		return round( $this->calculate_partial_totals(), 2 );
	}

	/**
	 * @return float
	 * @since 5.7.4
	 */
	public function get_due_total(): float {
		return $this->get_totals( true, true ) - $this->get_total_partial();
	}

	/**
	 * Get the total values of the shopping cart.
	 *
	 * @param bool $with_discount (Optional) Whether to include discounts in the total. Default is true.
	 *
	 * @return array An array containing the following total values:
	 *     - 'sub_total' (float) The cart total without discounts and tax.
	 *     - 'cart_total' (float) The cart total after discounts and with tax (deprecated, use 'total' instead).
	 *     - 'discount' (float) The calculated discount against the cart total.
	 *     - 'total' (float) The cart total after discount and with tax.
	 *     - 'trip_extras_total' (float) The total cost of trip extras.
	 *     - 'cart_total_partial' (float) The cart total after discounts and without tax (deprecated, use 'total_partial' instead).
	 *     - 'total_partial' (float) The calculated down payment amount for the cart.
	 *     - 'tax_amount' (float) The tax percentage, applicable if tax is enabled and exclusive.
	 */
	public function get_total( bool $with_discount = true ): array {

		/**
		 * Represents the total value of the shopping cart.
		 */
		$cart_total = $sub_total = $this->get_subtotal();

		/**
		 * Represents the amount of discount applied to a purchase.
		 */
		$discount_amount = $this->get_discount_amount();

		/**
		 * Calculate the total cost of trip extras.
		 */
		$trip_extras_total = $this->get_extra_services_totals();

		$total_with_discount = $cart_total - $discount_amount;
		/**
		 * The total variable represents the sum of all values.
		 */
		$total = round( $this->apply_tax( $total_with_discount ), 2 );

		/**
		 * Represents the partials of the cart total.
		 *
		 * @var array $cart_total_partial An array of partial values that make up the cart total.
		 */
		$cart_total_partial = $total_partial = $this->get_total_partial();

		/**
		 * Represents the amount of tax to be applied.
		 *
		 * @var float $tax_amount The value of the tax amount.
		 */
		$tax_amount = $this->tax->is_taxable() && $this->tax->is_exclusive() ? $this->tax->get_tax_percentage() : 0;

		$cart_totals = compact( 'cart_total', 'sub_total', 'discount_amount', 'total', 'trip_extras_total', 'cart_total_partial', 'total_partial', 'tax_amount' );

		return apply_filters( 'wp_travel_engine_cart_get_total_fields', $cart_totals );
	}

	/**
	 * Return cart item id as per $trip_id.
	 *
	 * @param   $trip_id    post id of trip.
	 * @param   $price_key  String  Pricing Key [ unused ]
	 *
	 * @return  String  cart item id.
	 *
	 * @since   2.2.6
	 */
	public static function get_cart_item_id( $trip_id, $package_id = '', $start_date = '', $time = '' ) {
		if ( ! empty( $time ) ) {
			$suffix = ( new \DateTime( $time ) )->format( 'Y-m-d_H-i' );
		} else {
			$suffix = ( new \DateTime( $start_date ) )->format( 'Y-m-d_H-i' );
		}
		$cart_item_id = "cart_{$trip_id}";

		foreach ( array( 'package_id' ) as $param ) {
			if ( ! empty( $$param ) ) {
				$cart_item_id .= '_' . $$param;
			}
		}
		$cart_item_id .= "_{$suffix}";

		return apply_filters( 'wp_travel_engine_filter_cart_item_id', $cart_item_id, $trip_id );
	}

	/**
	 * Return cart trip id.
	 *
	 * @return  String  trip id.
	 *
	 * @since   2.2.6
	 */
	public function get_cart_trip_ids() {
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
		$coupon_return = isset( $coupon_array[ 0 ] ) && ! empty( $coupon_array[ 0 ] ) ? esc_attr( $coupon_array[ 0 ] ) : '';

		return $coupon_return;
	}

	public function get_cart_coupon_type() {
		$coupon_array  = array_column( $this->discounts, 'type' );
		$coupon_return = isset( $coupon_array[ 0 ] ) && ! empty( $coupon_array[ 0 ] ) ? esc_attr( $coupon_array[ 0 ] ) : '';

		return $coupon_return;
	}

	public function get_cart_coupon_value() {
		$coupon_array  = array_column( $this->discounts, 'value' );
		$coupon_return = isset( $coupon_array[ 0 ] ) && ! empty( $coupon_array[ 0 ] ) ? esc_attr( $coupon_array[ 0 ] ) : '';

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

}
