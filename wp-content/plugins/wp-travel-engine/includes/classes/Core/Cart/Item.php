<?php
/**
 * Class Item
 *
 * @package WPTravelEngine\Core\Cart
 * @since 6.0.0
 */

namespace WPTravelEngine\Core\Cart;

use WP_REST_Request;
use WPTravelEngine\Core\Coupon;
use WPTravelEngine\Core\Models\Post\Booking;
use WPTravelEngine\Core\Models\Post\Trip;
use WPTravelEngine\Core\Models\Post\TripPackage;
use WPTravelEngine\Core\Tax;

#[AllowDynamicProperties]
/**
 * Class Item.
 */
class Item {

	/**
	 * @var mixed
	 */
	protected $trip_price;

	/**
	 * @var mixed
	 */
	protected $trip_price_partial;

	/**
	 * @var mixed
	 */
	protected $pax;

	/**
	 * @var mixed
	 */
	protected $price_key;

	/**
	 * @var mixed
	 */
	protected $trip_date;

	/**
	 * @var mixed
	 */
	protected $trip_time;

	/**
	 * @var mixed
	 */
	protected $trip_id;

	/**
	 * @var array
	 */
	protected array $attrs;

	/**
	 * Item ID.
	 *
	 * @var string Item ID.
	 */
	protected string $id;

	/**
	 * @var mixed
	 */
	protected $datetime;

	/**
	 * Cart object.
	 *
	 * @var Cart
	 */
	protected Cart $cart;

	/**
	 * If this item is loaded from booking.
	 *
	 * @var bool
	 */
	protected bool $is_order_item = false;

	/**
	 * Default totals for the item.
	 *
	 * @var array Totals for different types.
	 */
	protected array $default_totals = array(
		'total'    => 0,
		'subtotal' => 0,
		'discount' => 0,
		'tax'      => array(
			'subtotal' => 0,
			'total'    => 0,
			'discount' => 0,
		),
		'partial'  => 0,
	);

	/**
	 * Holds Calculated totals for the item.
	 *
	 * @var mixed
	 */
	protected array $totals = array();

	/**
	 * @param array $attrs Attributes.
	 * @param Cart $cart Cart.
	 */
	public function __construct( Cart $cart, array $attrs = array() ) {

		$this->attrs = $attrs;
		$this->cart  = $cart;

		foreach ( $this->attrs as $key => $value ) {
			$this->{$key} = $value;
		}

		$this->id = $this->generate_id();

		$this->calculate_totals();
	}

	/**
	 * Set item properties from booking.
	 *
	 * @param $order_item
	 * @param Booking $booking Booking Object.
	 * @param Cart $cart Cart Object.
	 *
	 * @return Item
	 */
	public static function from_order_item( $order_item, Booking $booking, Cart $cart ): Item {
		$order_item[ 'trip_id' ]    = $order_item[ 'ID' ];
		$order_item[ 'trip_price' ] = $order_item[ 'cost' ] ?? 0;

		if ( isset( $order_item[ '_cart_item_object' ] ) ) {
			$order_item = $order_item[ '_cart_item_object' ];
		}

		return new static( $cart, $order_item );
	}

	/**
	 * Set Item properties from Request.
	 *
	 * @param WP_REST_Request $request
	 * @param Cart $cart
	 *
	 * @return Item
	 */
	public static function from_request( WP_REST_Request $request, Cart $cart ): Item {
		$cart_data = (object) $request->get_json_params();

		$package = new TripPackage( $cart_data->packageID, Trip::make( $cart_data->tripID ) );

		$trip_price = 0;
		$travelers  = array();

		if ( isset( $cart_data->{'travelers'} ) && is_array( $cart_data->{'travelers'} ) ) {
			$package_travelers    = $package->get_traveler_categories();
			$cart_pricing_options = $cart_data->{'travelers'};

			foreach ( $package_travelers as $package_traveler ) {
				$pax = $cart_pricing_options[ $package_traveler->id ] ?? 0;
				if ( $pax < 1 ) {
					continue;
				}
				if ( isset( $cart_pricing_options[ $package_traveler->id ] ) ) {
					$applicable_price = isset($package_traveler->has_sale) && $package_traveler->has_sale ? $package_traveler->sale_price : $package_traveler->price;

					$enable_group_discount = (bool) ( $package_traveler->enabled_group_discount ?? false );
					$group_pricing         = $package->get_group_pricing()[ $package_traveler->id ] ?? [];

					$travelers[ 'pax' ][ $package_traveler->id ] = $pax;

					if ( $enable_group_discount && ! empty( $group_pricing ) ) {
						foreach ( $group_pricing as $pricing ) {
							if ( $pricing[ 'from' ] <= $pax && ( empty( $pricing[ 'to' ] ) || ( $pricing[ 'to' ] >= $pax ) ) ) {
								$applicable_price = $pricing[ 'price' ];
								break;
							}
						}
					}

					$travelers[ 'info' ][ $package_traveler->id ] = [
						'label'                => $package_traveler->label,
						'price'                => $package_traveler->price,
						'enabledSale'          => $package_traveler->has_sale ?? false,
						'salePrice'            => $package_traveler->sale_price,
						'pricingType'          => $package_traveler->pricing_type,
						'minPax'               => $package_traveler->min_pax,
						'maxPax'               => $package_traveler->max_pax,
						'groupPricing'         => $group_pricing,
						'enabledGroupDiscount' => $enable_group_discount,
					];

					$travelers[ 'cost' ][ $package_traveler->id ] = $package_traveler->pricing_type === 'per-group' ? $applicable_price : (float) $applicable_price * $pax;

					$trip_price += $travelers[ 'cost' ][ $package_traveler->id ];
				}
			}
		}

		$tax   = $cart->tax();
		$attrs = apply_filters(
			'wp_travel_engine_cart_attributes',
			array(
				'trip_id'            => $cart_data->{'tripID'},
				'trip_price'         => $trip_price,
				'trip_date'          => $cart_data->{'tripDate'},
				'trip_time'          => $cart_data->{'tripTime'} ?? '',
				'trip_time_range'    => $cart_data->{'timeRange'} ?? array(),
				'price_key'          => $cart_data->{'packageID'},
				//				'pricing_options'    => $cart_data->{'pricingOptions'},
				'pax'                => $travelers[ 'pax' ] ?? array(),
				'pax_labels'         => array(),
				'category_info'      => $travelers[ 'info' ],
				'pax_cost'           => $travelers[ 'cost' ],
				'multi_pricing_used' => ! 0,
				'trip_extras'        => ! empty( $cart_data->{'extraServices'} ) ? (array) $cart_data->{'extraServices'} : array(),
				// Tax Percentage.
				'datetime'           => $cart_data->{'tripDate'},
				'tax_amount'         => $tax->get_tax_percentage(),
			)
		);

		return new static( $cart, $attrs );
	}

	/**
	 * Calculate totals.
	 *
	 * @return void
	 */
	public function calculate_totals() {
		$this->totals = $this->default_totals;

		$this->totals[ 'subtotal' ] = $this->calculate_subtotal();
		$this->totals[ 'discount' ] = $this->calculate_discount();
		$this->totals[ 'tax' ]      = $this->calculate_tax();
		$this->totals[ 'total' ]    = $this->calculate_total();
		$this->totals[ 'partial' ]  = $this->calculate_partial();
	}

	/**
	 * Calculate subtotal.
	 *
	 * @return float
	 */
	public function calculate_subtotal(): float {
		return $this->price() + $this->trip_extras_totals();
	}

	/**
	 * Calculate total.
	 *
	 * @return float
	 */
	public function calculate_total(): float {
		return $this->totals[ 'subtotal' ] - $this->totals[ 'discount' ] + ( $this->totals[ 'tax' ][ 'total' ] ?? 0 );
	}

	/**
	 * Calculate Tax for the Trip.
	 *
	 * @return array
	 */
	public function calculate_tax(): array {

		$tax = $this->cart->tax();

		$totals = array();
		if ( $tax->is_taxable() && $tax->is_exclusive() ) {
			$totals[ 'subtotal' ] = $tax->get_tax_amount( $this->totals[ 'subtotal' ] );
			$totals[ 'discount' ] = $tax->get_tax_amount( $this->totals[ 'discount' ] );
			$totals[ 'total' ]    = $tax->get_tax_amount( $this->totals[ 'subtotal' ] - $this->totals[ 'discount' ] );
		}

		return $totals;
	}

	/**
	 * Generates Item ID.
	 *
	 * @return string
	 */
	protected function generate_id(): string {
		if ( ! empty( $this->trip_time ) ) {
			$suffix = ( new \DateTime( $this->trip_time ) )->format( 'Y-m-d_H-i' );
		} else {
			$suffix = ( new \DateTime( $this->trip_date ) )->format( 'Y-m-d_H-i' );
		}

		$cart_item_id = "cart_{$this->trip_id}";

		if ( ! empty( $this->price_key ) ) {
			$cart_item_id .= '_' . $this->price_key;
		}

		$cart_item_id .= "_{$suffix}";

		return apply_filters( 'wp_travel_engine_filter_cart_item_id', $cart_item_id, $this->trip_id );
	}

	/**
	 * Get Item ID.
	 *
	 * @return string
	 */
	public function id(): string {
		return $this->id;
	}

	/**
	 * Get Item data.
	 *
	 * @return array
	 */
	public function data(): array {
		$data = $this->attrs;

		$data[ 'trip_id' ] = $this->trip_id;
		if ( ! is_array( $this->pax ) ) {
			unset( $data[ 'trip_price' ] );
			unset( $data[ 'trip_price_partial' ] );
		}

		return $data;
	}

	/**
	 * Get a sum of trip price.
	 *
	 * @return float
	 */
	public function price(): float {
		return (float) $this->trip_price;
	}

	/**
	 * Calculates trip extras totals.
	 *
	 * @return float
	 */
	public function trip_extras_totals(): float {
		$totals = 0;
		if ( ! empty( $this->attrs[ 'trip_extras' ] ) && is_array( $this->attrs[ 'trip_extras' ] ) ) :
			foreach ( $this->attrs[ 'trip_extras' ] as $extra ) :
				$totals += (float) ( $extra[ 'price' ] * $extra[ 'qty' ] );
			endforeach;
		endif;

		return (float) $totals;
	}

	/**
	 * @param $string bool Whether to return string value or array.
	 *
	 * @return array|string
	 */
	public function down_payment_settings( bool $string = false ) {

		$trip_id         = $this->trip_id;
		$partial_payment = array();
		$global_settings = get_option( 'wp_travel_engine_settings', true );
		$trip_settings   = get_post_meta( $trip_id, 'wp_travel_engine_setting', true );

		$valid_partial_types = apply_filters( 'wptravelengine_partial_value_types', [ 'amount', 'percent', ] );

		$type = $global_settings[ 'partial_payment_option' ] ?? 'invalid';

		if ( ! $trip_id || ! wp_travel_engine_is_trip_partially_payable( $trip_id ) || ! in_array( $type, $valid_partial_types, true ) ) {
			return $partial_payment;
		}

		$trip_full_payment   = ( $trip_settings[ 'trip_full_payment_enabled' ] ?? 'yes' ) === 'yes';
		$global_full_payment = ( $global_settings[ 'full_payment_enable' ] ?? 'yes' ) === 'yes';

		$value = (float) $global_settings[ "partial_payment_{$type}" ] ?? 0;
		if ( ! empty( $trip_settings[ "partial_payment_{$type}" ] ) ) {
			$value = (float) $trip_settings[ "partial_payment_{$type}" ];
		}

		/**
		 * Send more data to disable full payment.
		 *
		 * @since 5.7.1
		 */
		$partial_payment = compact( 'trip_full_payment', 'global_full_payment', 'type', 'value' );

		$string_value = $type === 'percent' ? $value . '%' : $value;

		return $string ? $string_value : $partial_payment;
	}

	/**
	 * Calculates down payment with provided total.
	 *
	 * @return float
	 */
	public function calculate_partial(): float {
		$partial_payment_data = $this->down_payment_settings();

		$total = $this->totals[ 'total' ];

		if ( ! isset( $partial_payment_data[ 'type' ] )
		     || ! in_array( $partial_payment_data[ 'type' ], [ 'amount', 'percent', ], true )
		) {
			return $total;
		}

		if ( 'amount' === $partial_payment_data[ 'type' ] ) {
			return (float) $partial_payment_data[ 'value' ];
		}

		return $total * ( (float) $partial_payment_data[ 'value' ] / 100 );
	}

	/**
	 * Calculate the discount for the item.
	 *
	 * @return float
	 */
	public function calculate_discount(): float {
		$discounts = $this->cart->get_discounts();

		$discount_total = 0;
		foreach ( $discounts as $discount ) {
			$discount_total += Coupon::calculate_value( $this->totals[ 'subtotal' ], $discount[ 'type' ], $discount[ 'value' ] );
		}

		return $discount_total;
	}

	/**
	 * Calculate the subtotal for the item.
	 *
	 * @return float
	 */
	public function subtotal(): float {
		return $this->totals[ 'subtotal' ];
	}

	/**
	 * Get Discount Amount if applicable.
	 *
	 * @return float
	 */
	public function discount(): float {
		return $this->totals[ 'discount' ];
	}

	/**
	 * Calculate Tax for the Trip.
	 *
	 * @return array
	 */
	public function tax(): array {
		return $this->totals[ 'tax' ];
	}

	/**
	 * Total sum of cart item.
	 * This includes trip price and extras services.
	 *
	 * @return float
	 */
	public function total(): float {
		return $this->totals[ 'total' ];
	}

	/**
	 * Partial amount that can be paid as down payment.
	 * Calculated on item total.
	 *
	 * @return float
	 * @since 6.0.0
	 */
	public function partial_total(): float {
		return $this->totals[ 'partial' ];
	}

	/**
	 * @return float
	 */
	public function due_total(): float {
		return $this->calculate_total() - $this->calculate_partial();
	}

	/**
	 * Get Item attribute.
	 *
	 * @param string $name Attribute name.
	 *
	 * @return mixed
	 */
	public function __get( string $name ) {
		return $this->attrs[ $name ] ?? null;
	}
}
