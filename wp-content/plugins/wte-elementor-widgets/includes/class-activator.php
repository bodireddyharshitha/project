<?php
namespace WPTRAVELENGINEEB;

/**
 * Activation Class.
 *
 * @package wptravelengine-elementor-blocks
 */
class Activation {
	/**
	 * Runs on plugin activation.
	 *
	 * @since 1.0.0
	 */
	public static function init() {
		$instance = new self();

		$instance->filter_sale_trips();
	}

	/**
	 * Update meta for trips on sale.
	 *
	 * @since 1.0.0
	 */
	private function filter_sale_trips() {
		global $wpdb;
		$flagged_trips = get_option( '_wte_flagged_trips_on_sale', '' );

		if ( 'yes' !== $flagged_trips ) {
			$where  = $wpdb->prepare( "{$wpdb->posts}.post_type = %s", WP_TRAVEL_ENGINE_POST_TYPE );
			$where .= " AND {$wpdb->posts}.post_status IN ( 'publish','draft' )";

			$trip_ids = $wpdb->get_col( "SELECT ID FROM {$wpdb->posts} WHERE {$where}" );

			if ( $trip_ids ) {
				global $wp_query;
				$wp_query->in_the_lopp = true;
				while ( $next_trips = array_splice( $trip_ids, 0, 20 ) ) { // phpcs:ignore WordPress.CodeAnalysis.AssignmentInCondition.FoundInWhileCondition
					foreach ( $next_trips as $trip_id ) {
						$trip = \wte_get_trip( $trip_id );

						if ( $trip instanceof \WPTravelEngine\Posttype\Trip && $trip->has_sale ) {
							update_post_meta( $trip_id, '_s_has_sale', 'yes' );
							\wp_cache_delete( $trip_id, 'trips' );
						}
					}
				}
				update_option( '_wte_flagged_trips_on_sale', 'yes', true );
			}
		}
	}

}
