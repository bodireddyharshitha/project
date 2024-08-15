<?php
/**
 * Traveler Category Model.
 *
 * @package WPTravelEngine
 * @since 6.0.0
 */

namespace WPTravelEngine\Core\Models\Post;

#[\AllowDynamicProperties]
/**
 * Class TravelerCategory.
 * This class represents a traveler category to the WP Travel Engine plugin.
 *
 * @since 6.0.0
 */
class TravelerCategory {

	/**
	 * The trip object.
	 *
	 * @var Trip
	 */
	protected Trip $trip;

	/**
	 * The package object.
	 *
	 * @var TripPackage
	 */
	protected TripPackage $package;

	/**
	 * Traveler Category Model Constructor.
	 *
	 * @param Trip $trip The trip object.
	 * @param TripPackage $package The trip package object.
	 * @param array $package_category_data The package category data.
	 */
	public function __construct( Trip $trip, TripPackage $package, array $package_category_data ) {
		$this->trip    = $trip;
		$this->package = $package;

		$key_mapping = array(
			'c_ids'         => 'id',
			'labels'        => 'label',
			'prices'        => 'price',
			'pricing_types' => 'pricing_type',
			'sale_prices'   => 'sale_price',
			'min_paxes'     => 'min_pax',
			'max_paxes'     => 'max_pax',
			'enabled_sale'  => 'has_sale',
		);

		foreach ( $package_category_data as $property => $value ) {
			if ( isset( $key_mapping[ $property ] ) ) {
				$property = $key_mapping[ $property ];
			}
			$this->{$property} = $value;
		}
	}

	/**
	 * Get category value.
	 *
	 * @param mixed $key The key to get.
	 * @param mixed $default The default value to return if the key is not set.
	 *
	 * @return mixed
	 */
	public function get( $key, $default = null ) {
//		$key_mapping = array(
//			'id'           => 'c_ids',
//			'label'        => 'labels',
//			'price'        => 'prices',
//			'pricing_type' => 'pricing_types',
//			'sale_price'   => 'sale_prices',
//			'min_pax'      => 'min_paxes',
//			'max_pax'      => 'max_paxes',
//			'has_sale'     => 'enabled_sale',
//		);

		if ( isset( $key_mapping[ $key ] ) ) {
			$value = $this->{$key_mapping[ $key ]} ?? $default;
		} else {
			$value = $this->{$key} ?? $default;
		}

		switch ( $key ) {
			case 'sale_price':
				$value = empty( $value ) ? $this->get( 'price', $default ) : $value;
				break;
			case 'group_pricing':
				$value = $this->package->get_group_pricing()[ $this->{'id'} ] ?? [];
				break;
		}

		return $value;
	}

	/**
	 * Calculate Sale Percentage.
	 *
	 * @return void
	 */
	public function sale_percentage() {
		$prices      = floatval( $this->prices );
		$sale_prices = floatval( $this->sale_prices );

		return ( $prices - $sale_prices ) / $prices * 100;
	}
}
