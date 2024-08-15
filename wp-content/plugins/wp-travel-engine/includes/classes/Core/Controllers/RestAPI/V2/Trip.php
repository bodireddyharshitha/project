<?php
/**
 * WP Travel Engine Trip Post Controller class.
 *
 * @package WPTravelEngine
 * @since 6.0.0
 */

namespace WPTravelEngine\Core\Controllers\RestAPI\V2;

use WP_Error;
use WP_HTTP_Response;
use WP_REST_Posts_Controller;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;
use WPTravelEngine\Core\Models\Post;
use WPTravelEngine\Helpers\PackageDateParser;

/**
 * REST API: Trip Post Controller class
 *
 * @since 6.0.0
 * @see WP_REST_Posts_Controller
 */
class Trip extends WP_REST_Posts_Controller {

	/**
	 * Constructor.
	 *
	 * @param string $post_type Post type.
	 *
	 * @since 4.7.0
	 */
	public function __construct( $post_type ) {
		parent::__construct( $post_type );
		$this->rest_base = 'trips';
		$this->namespace = 'wptravelengine/v2';
	}

	/**
	 * Registers the routes for posts.
	 *
	 * @see register_rest_route()
	 */
	public function register_routes() {
		parent::register_routes();

		register_rest_route(
			$this->namespace,
			"/$this->rest_base/(?P<id>[\d]+)/services",
			array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_services' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
					'args'                => $this->get_collection_params(),
				),
			)
		);

		register_rest_route(
			$this->namespace,
			"/$this->rest_base/(?P<id>[\d]+)/packages",
			array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_packages' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
					'args'                => $this->get_collection_params(),
				),
			)
		);

		register_rest_route(
			$this->namespace,
			"/$this->rest_base/(?P<id>[\d]+)/dates",
			array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_dates' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
					'args'                => $this->get_collection_params(),
				),
			)
		);
	}

	/**
	 * Get single trip data.
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 *
	 * @return WP_Error|WP_HTTP_Response|WP_REST_Response
	 */
	public function get_item( $request ) {
		$data = parent::get_item( $request )->get_data();

		return rest_ensure_response( $data );
	}

	/**
	 * Get Trip Services.
	 *
	 * @param WP_REST_Request $request
	 *
	 * @return WP_Error|WP_HTTP_Response|WP_REST_Response
	 */
	public function get_services( \WP_REST_Request $request ) {
		$id = $request->get_param( 'id' );

		try {
			$trip = new Post\Trip( $id );

			$data = $trip->get_services();
		} catch ( \Exception $e ) {
			$data = array();
		}

		return rest_ensure_response( $data );
	}

	/**
	 * Get Trip Dates.
	 *
	 * @param WP_REST_Request $request Request Class.
	 *
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_dates( WP_REST_Request $request ) {
		$id = $request->get_param( 'id' );

		try {
			/* @var Post\Trip $trip */
			$trip = Post\Trip::make( $id );
		} catch ( \Exception $e ) {
			return new WP_Error( 'invalid_trip', $e->getMessage(), array( 'status' => 404 ) );
		}

		$trip_packages = new Post\TripPackages( $trip );

		$from = $request->get_param( 'from' ) ?? date( 'Y-m-d' );
		$to   = $request->get_param( 'to' ) ?? date( 'Y-m-d', strtotime( '+1 year' ) );

		$dates = array();
		foreach ( $trip_packages as $trip_package ) {
			/* @var Post\TripPackage $trip_package */
			$data = array(
				'package' => $this->prepare_package_data( $trip_package ),
				'dates'   => $trip_package->get_package_dates( compact( 'from', 'to' ) ),
			);

			$dates[] = $data;

		}

		return rest_ensure_response( $dates );
	}

	/**
	 * Prepare package data.
	 *
	 * @param Post\TripPackage $trip_package Trip package object.
	 *
	 * @return array
	 */
	public function prepare_package_data( Post\TripPackage $trip_package ): array {
		$data = array();
		/**
		 * @var Post\TripPackage $trip_package
		 * @var Post\Trip $trip
		 */
		$data[ 'id' ]          = $trip_package->get_id();
		$data[ 'name' ]        = $trip_package->get_title();
		$data[ 'description' ] = $trip_package->get_content();

		$package_categories = $trip_package->get_traveler_categories();
		/** @var Post\TravelerCategory $category */
		foreach ( $package_categories as $category ) {
			$min_pax = $category->get( 'min_pax', '' );
			$min_pax = is_numeric( $min_pax ) ? (int) $min_pax : 0;
			$max_pax = $category->get( 'max_pax', '' );
			$max_pax = is_numeric( $max_pax ) && ( + $max_pax >= $min_pax ) ? (int) $max_pax : '';

			$group_pricing = $category->get( 'group_pricing', array() );

			$group_pricing = array_map(
				function ( $gp ) {
					return array(
						'from' => is_numeric( $gp[ 'from' ] ) ? (int) $gp[ 'from' ] : 0,
						'to'   => is_numeric( $gp[ 'to' ] ) ? (int) $gp[ 'to' ] : '',
						'rate' => is_numeric( $gp[ 'price' ] ) ? (float) $gp[ 'price' ] : 0,
					);
				},
				$group_pricing
			);

			$pricing_label                   = apply_filters(
				'wptravelengine-packages-labels',
				array(
					'per-person' => __( 'Person', 'wp-travel-engine' ),
					'per-group'  => __( 'Group', 'wp-travel-engine' ),
				)
			);
			$get_pricing_type                = $category->get( 'pricing_type', 'per-person' );
			$data[ 'traveler_categories' ][] = array(
				'id'                => (int) $category->get( 'id', 0 ),
				'label'             => $category->get( 'label', '' ),
				'price'             => (float) $category->get( 'price', 0 ),
				'age_group'         => $category->get( 'age_group', '' ),
				'pricing_type' => array(
					'value' => $get_pricing_type,
					'label' => $pricing_label[ $get_pricing_type ],
				),
				'sale_price'        => (float) $category->get( 'sale_price', 0 ),
				'has_sale'          => (bool) $category->get( 'has_sale', false ),
				'has_group_pricing' => (bool) $category->get( 'enabled_group_discount', false ) && ! empty( $group_pricing ),
				'group_pricing'     => $group_pricing,
				'min_pax'           => $min_pax,
				'max_pax'           => $max_pax,
			);
		}

		return $data;
	}

	/**
	 * Get Trip packages.
	 *
	 * @param WP_REST_Request $request Request Class.
	 *
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_packages( WP_REST_Request $request ) {
		$id = $request->get_param( 'id' );

		$packages = array();

		try {
			/* @var Post\Trip $trip */
			$trip = Post\Trip::make( $id );
		} catch ( \Exception $e ) {
			return new WP_Error( 'invalid_trip', $e->getMessage(), array( 'status' => 404 ) );
		}
		$trip_packages = new Post\TripPackages( $trip );

		foreach ( $trip_packages as $trip_package ) {
			$packages[] = $this->prepare_package_data( $trip_package );
		}

		return rest_ensure_response( $packages );
	}
}
