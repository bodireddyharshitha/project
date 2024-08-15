<?php
/**
 * Trip Packages Model.
 *
 * @package WPTravelEngine/Core/Models
 * @since 6.0.0
 */

namespace WPTravelEngine\Core\Models\Post;

use WPTravelEngine\Core\Models\Settings\Options;
use WPTravelEngine\Traits\Factory;

/**
 * Class TripPackages.
 * This class represents a trip package to the WP Travel Engine plugin.
 *
 * @since 6.0.0
 */
class TripPackages extends TripPackageIterator {

	use Factory;

	/**
	 * The trip object.
	 *
	 * @var Trip
	 */
	protected Trip $trip;

	/**
	 * The data array.
	 *
	 * @var array
	 */
	protected array $packages = array();

	/**
	 * The default package of the trip.
	 *
	 * @var TripPackage|null
	 */
	protected ?TripPackage $default_package = null;

	/**
	 * The position of the current element in the data array.
	 *
	 * @var int
	 */
	protected int $position = 0;

	/**
	 * TripPackages Model Constructor.
	 *
	 * @param Trip $trip The trip object.
	 */
	public function __construct( Trip $trip ) {
		$this->trip = $trip;

		$package_ids = $this->trip->{'packages_ids'};

		if ( ! is_array( $package_ids ) ) {
			return array();
		}

		$trip_package_posts = get_posts(
			array(
				'post_type'        => 'trip-packages',
				'include'          => $package_ids,
				'suppress_filters' => true,
			)
		);
		foreach ( $trip_package_posts as $trip_package_post ) {
			$this->packages[] = new TripPackage( $trip_package_post, $trip );
		}

		parent::__construct( $this->packages );
	}

	/**
	 * Get the default package.
	 *
	 * @return TripPackage
	 */
	public function get_default_package(): ?TripPackage {
		if ( is_null( $this->default_package ) ) {
			$package = $this->get_package_with_low_price();
			if ( $package instanceof TripPackage ) {
				$this->default_package = $package;
			} else {
				$this->default_package = null;
			}
		}

		return $this->default_package;
	}

	/**
	 * Set the default package.
	 */
	protected function get_package_with_low_price() {
		$packages              = $this->packages;
		$lowest_priced_package = current( $packages );

		$primary_pricing_category = Options::get( 'primary_pricing_category', 0 );

		if ( ! $primary_pricing_category ) {
			return null;
		}

		$term = get_term( $primary_pricing_category, 'trip-packages-categories' );

		if ( ! ( $term instanceof \WP_Term ) ) {
			return $packages[ 0 ];
		}

		$lowest_price = 0;
		foreach ( $packages as $package ) {
			/* @var TripPackage $package */
			$primary_category = $package
				->get_traveler_categories()
				->get( $term->term_id );

			if ( null !== $primary_category ) {
				$enabled_sale = (int) $primary_category->get( 'enabled_sale', '' ) === 1;
				$sale_price   = $enabled_sale ? $primary_category->get( 'sale_price', 0 ) : $primary_category->get( 'price', 0 );

				if ( $lowest_price > 0 && $lowest_price <= $sale_price ) {
					continue;
				}

				$lowest_price          = $sale_price;
				$lowest_priced_package = $package;
			}
		}

		return $lowest_priced_package;
	}

}
