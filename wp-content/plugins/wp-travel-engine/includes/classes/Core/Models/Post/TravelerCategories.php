<?php

/**
 * Traveler Categories Model.
 *
 * @package WPTravelEngine
 * @since 6.0.0
 */

namespace WPTravelEngine\Core\Models\Post;

use WPTravelEngine\Abstracts\Iterator;
use WPTravelEngine\Core\Models\Post\Trip;
use WPTravelEngine\Core\Models\Post\TripPackage;
use WPTravelEngine\Traits\Factory;
use WPTravelEngine\Core\Models\Settings\Options;

/**
 * Class TravelerCategories.
 * This class represents a traveler category to the WP Travel Engine plugin.
 *
 * @since 6.0.0
 */
class TravelerCategories extends Iterator {
	use Factory;

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
	 * Traveler Categories Model Constructor.
	 *
	 * @param Trip $trip The trip object.
	 * @param TripPackage $package The trip package object.
	 */
	public function __construct( Trip $trip, TripPackage $package ) {
		$this->trip    = $trip;
		$this->package = $package;

		$categories = $this->package->get_meta( 'package-categories' );

		$group_pricing = $this->package->get_meta( 'group-pricing', array() );

		$categories[ 'enabled_group_discount' ] = $categories[ 'enabled_group_discount' ] ?? array();
		$categories[ 'group_pricing' ]          = array_map( function ( $gp ) {
			return array_map( function ( $p ) {
				return [
					'from' => is_numeric( $p[ 'from' ] ) ? (int) $p[ 'from' ] : '',
					'to'   => is_numeric( $p[ 'to' ] ) ? (int) $p[ 'to' ] : '',
					'rate' => (float) $p[ 'price' ],
				];
			}, $gp );
		}, is_array( $group_pricing ) ? $group_pricing : array() );

		$_categories = array();

		foreach ( $categories[ 'c_ids' ] as $id ) {
			foreach ( $categories as $key => $values ) {
				if ( $key === 'enabled_group_discount' ) {
					$_categories[ $id ][ $key ] = (bool) ( $values[ $id ] ?? false );
					continue;
				}
				if ( $key === 'group_pricing' ) {
					$_categories[ $id ][ $key ] = $_categories[ $id ][ 'enabled_group_discount' ] ? $values[ $id ] : array();
					continue;
				}

				$_categories[ $id ][ $key ] = $values[ $id ] ?? '';
			}
			$_categories[$id]['age_group'] = (string) ( get_term_meta( $id )['age_group'][0] ?? '' );
		}

		$data = array_map(
			function ( $category ) {
				return new TravelerCategory( $this->trip, $this->package, $category );
			},
			$_categories
		);


		parent::__construct( array_values( $data ) );
	}

	/**
	 * Get category by id.
	 *
	 * @param $id
	 *
	 * @return mixed|null
	 */
	public function get( $id ) {
		return $this->data[ $id ] ?? null;
	}


	/**
	 * Get all categories.
	 *
	 * @return array
	 */
	public function get_categories() {
		return $this->data;
	}

	/**
	 * Get primary traveler category.
	 *
	 * @return array
	 */
	public function get_primary_traveler_category() {
		$category_id = Options::get( 'primary_pricing_category', 0 );
		foreach ( $this->data as $category ) {
			if ( isset( $category->id ) && $category->id === $category_id ) {
				return $category;
			}
		}

		return $this->data[ 0 ];
	}

	/**
	 * Check if price is set only for primary pricing category.
	 *
	 * @return bool
	 */
	public function is_single_pricing_category() {
		$category_id        = Options::get( 'primary_pricing_category', 0 );
		$pricing_categories = $this->data;
		$primary_cat_price  = null;

		foreach ( $pricing_categories as $category ) {
			if ( isset( $category->c_ids ) && $category->c_ids === $category_id ) {
				$primary_cat_price = $category->prices;
				break;
			}
		}

		if ( isset( $primary_cat_price ) && $primary_cat_price != '' ) {
			foreach ( $pricing_categories as $category ) {
				$price = $category->prices ?? '';
				if ( $price == '' ) {
					return true;
				}
			}
		}

		return false;
	}
}
