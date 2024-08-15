<?php

namespace WPTravelEngine\Core\Cart;


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

	public function __construct( $trip_id, $attrs ) {

		$this->attrs              = $attrs;
		$this->trip_price         = (float) $attrs[ 'trip_price' ];
		$this->trip_price_partial = (float) $attrs[ 'trip_price_partial' ];
		$this->pax                = $attrs[ 'pax' ];
		$this->price_key          = $attrs[ 'price_key' ];
		$this->trip_date          = $attrs[ 'trip_date' ];
		$this->trip_time          = $attrs[ 'trip_time' ];
		$this->trip_id            = $trip_id;

	}

	/**
	 * Return cart item id as per $trip_id.
	 *
	 * @return string Cart item id.
	 *
	 * @since   2.2.6
	 */
	public function id(): string {

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

	public function data(): array {
		$data = $this->attrs;

		$data[ 'trip_id' ] = $this->trip_id;
		if ( ! is_array( $this->pax ) ) {
			unset( $data[ 'trip_price' ] );
			unset( $data[ 'trip_price_partial' ] );
		}

		return $data;
	}

	public function price(): float {
		return (float) $this->trip_price;
	}

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

		if ( ! $trip_id || ! wp_travel_engine_is_trip_partially_payable( $trip_id ) || ! in_array( $type, $valid_partial_types, ! 0 ) ) {
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

	public function calculate_down_payment( $total ): float {
		$partial_payment_data = $this->down_payment_settings();

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

	public function get_partial_total() {
		return $this->calculate_down_payment( $this->totals() );
	}

	public function totals(): float {
		return $this->price() + $this->trip_extras_totals();
	}

	public function __get( $name ) {
		return $this->attrs[ $name ] ?? null;
	}
}
