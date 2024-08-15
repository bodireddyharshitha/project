<?php
/**
 * Filter Trip Html Controller.
 *
 * @package @WPTravelEngine/Core/Controllers
 * @since 6.0.0
 */

namespace WPTravelEngine\Core\Controllers\Ajax;

use WPTravelEngine\Abstracts\AjaxController;
use WPTravelEngine\Core\Models\Settings\Options;

/**
 * Filters the trips html.
 */
class FilterTripsHtml extends AjaxController {

	const NONCE_KEY    = 'nonce';
	const NONCE_ACTION = 'wte_show_ajax_result';
	const ACTION       = 'wte_show_ajax_result';

	/**
	 * Post data.
	 *
	 * @var array
	 * @access protected
	 */
	protected array $post_data;

	/**
	 * Post per pages.
	 *
	 * @var int
	 * @access protected
	 */
	protected int $posts_per_page;

	/**
	 * Process Request.
	 * Filters Trips Html.
	 */
	protected function process_request() {
		$this->post_data      = $this->request->get_params();
		$this->posts_per_page = ( new Options() )->get( 'posts_per_page', 10 );
		$query_args           = self::get_query_args( true );

		$query = new \WP_Query( $query_args );

		if ( ! $query->have_posts() ) {
			return wp_send_json_success(
				array(
					'foundposts' => apply_filters( 'no_result_found_message', __( 'No results found!', 'wp-travel-engine' ) ),
					'data'       => '',
				)
			);
		}

		ob_start();

		$view_mode  = ! empty( $this->post_data['mode'] ) ? wte_clean( wp_unslash( $this->post_data['mode'] ) ) : wp_travel_engine_get_archive_view_mode(); // phpcs:ignore
		$view_class = 'grid' === $view_mode ? 'col-2 category-grid' : 'category-list';

		echo '<div class="category-main-wrap ' . esc_attr( $view_class ) . '">';

		$user_wishlists = wptravelengine_user_wishlists();

		while ( $query->have_posts() ) :
			$query->the_post();
			$details                   = wte_get_trip_details( get_the_ID() );
			$details['user_wishlists'] = $user_wishlists;

			wte_get_template( 'content-' . $view_mode . '.php', $details );
		endwhile;
		wp_reset_postdata();
		echo '</div>';

		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
		if ( $query->found_posts > $this->posts_per_page ) {
			echo '<span data-id="' . esc_attr( $query->found_posts ) . '" class="wte-search-load-more"><a data-query-vars="' . esc_attr( wp_json_encode( $query->query_vars ) ) . '" data-current-page="' . esc_attr( $paged ) . '" data-max-page="' . esc_attr( $query->max_num_pages ) . '" href="#" class="load-more-search" data-nonce="' . esc_attr( wp_create_nonce( 'wte_show_ajax_result_load' ) ) . '">' . esc_html__( 'Load More', 'wp-travel-engine' ) . '</a></span>';
		}

		$foundposts = sprintf(
			_nx(
				'%1$s Trip Found',
				'%1$s Trips found',
				$query->found_posts,
				'number of trips',
				'wp-travel-engine'
			),
			'<strong>' . number_format_i18n( $query->found_posts ) . '</strong>'
		);
		return wp_send_json_success(
			array(
				'foundposts' => $foundposts,
				'data'       => ob_get_clean(),
			)
		);
		// Remove the exit statement.
	}

	/**
	 * Prepares query to get results.
	 *
	 * @param bool $ajax_request Whether the request is an ajax request or not.
	 */
	public function get_query_args( $ajax_request = false ) {
		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

		$query_args = array(
			'post_type'                => WP_TRAVEL_ENGINE_POST_TYPE,
			'post_status'              => 'publish',
			'posts_per_page'           => $this->posts_per_page,
			'wpse_search_or_tax_query' => true,
			'paged'                    => $paged,
		);

		$categories = apply_filters(
			'wte_filter_categories',
			array(
				'trip_types'  => array(
					'taxonomy'         => 'trip_types',
					'field'            => 'slug',
					'include_children' => true,
				),
				'cat'         => array(
					'taxonomy'         => 'trip_types',
					'field'            => 'slug',
					'include_children' => true,
				),
				'budget'      => array(
					'taxonomy'         => 'budget',
					'field'            => 'slug',
					'include_children' => false,
				),
				'activities'  => array(
					'taxonomy'         => 'activities',
					'field'            => 'slug',
					'include_children' => true,
				),
				'destination' => array(
					'taxonomy'         => 'destination',
					'field'            => 'slug',
					'include_children' => true,
				),
				'trip_tag'    => array(
					'taxonomy' => 'trip_tag',
					'field'    => 'slug',
				),
				'difficulty'  => array(
					'taxonomy' => 'difficulty',
					'field'    => 'slug',
				),
			)
		);
		// phpcs:disable
		$tax_query = array();
		$this->post_data 	= $this->request->get_params();
		foreach ( $categories as $cat => $term_args ) {
			if ( $ajax_request ) {
				$category = ! empty( $this->post_data['result'][ $cat ] ) && $this->post_data['result'][ $cat ] != '-1' ? $this->post_data['result'][ $cat ] : ''; // phpcs:ignore
			} else {
				$category = ! empty( $this->post_data[ $cat ] ) && $this->post_data[ $cat ] != -1 ? $this->post_data[ $cat ] : ''; // phpcs:ignore
			}

			if ( ! empty( $category ) ) {
				$term_args['terms'] = $category;
				$tax_query[]        = $term_args;
			}
		}

		if ( ! empty( $tax_query ) ) {
			$query_args['tax_query'] = $tax_query; // phpcs:ignore
			$query_args['tax_query']['relation'] = 'AND';
		}

		$meta_query = array();
		// Check Price.
		if ( $ajax_request && isset( $this->post_data['mincost'], $this->post_data['maxcost'] ) ) {
			$min_cost = intval( $this->post_data['mincost'] );
			$max_cost = intval( $this->post_data['maxcost'] );
		} else {
			$cost_range = (array) self::get_range( 'wte_price_range' );
			$min_cost   = intval( $this->post_data['min-cost'] ) ?? (int) $cost_range['min_value'];
			$max_cost   = intval( $this->post_data['max-cost'] ) ?? (int) $cost_range['max_value'];
		}

		if ( isset( $max_cost ) && $max_cost > 0 ) {
			$meta_query[] = array(
				'key'     => apply_filters( 'wpte_advance_search_price_filter', '_s_price' ),
				'value'   => array( $min_cost - 1, $max_cost + 1 ),
				'compare' => 'BETWEEN',
				'type'    => 'numeric',
			);
		}

		// Check Duration.
		if ( $ajax_request && isset( $this->post_data['mindur'], $this->post_data['maxdur'] ) ) {
			$min_duration = intval( $this->post_data['mindur'] );
			$max_duration = intval( $this->post_data['maxdur'] );
		} else {
			$range        = (array) self::get_range( 'wte_duration_range' );
			$min_duration = intval( $this->post_data['min-duration'] ) ?? (int) $range['min_value'];
			$max_duration = intval( $this->post_data['max-duration'] ) ?? (int) $range['max_value'];
		}
		if ( isset( $max_duration ) && 0 != $max_duration ) {
			array_push(
				$meta_query,
				array(
					'key'     => '_s_duration',
					'value'   => array( ($min_duration * 24) - 1, ($max_duration * 24) + 1 ),
					'compare' => 'BETWEEN',
					'type'    => 'numeric',
				)
			);
		}
		
		if ( ! empty( $this->post_data['trip-date-select'] ) || ! empty( $this->post_data['date'] ) ) {
			$date =  wte_clean( wp_unslash( $ajax_request ? $this->post_data['date'] : $this->post_data['trip-date-select'] ) );

			try {
				$min_date = new \DateTime( $date . '-01' );
				$date     = $min_date->format( 'ym' );
			} catch ( \Exception $e ) {
				$date = str_replace( '-', '', $date );
			}
			$meta_query[] = array(
				'key'     => 'trip_available_months',
				'value'   => $date,
				'compare' => 'LIKE',
			);
		}

		if ( ! empty( $meta_query ) ) {
			$query_args['meta_query'] = $meta_query; // phpcs:ignore
			$query_args['meta_query']['relation'] = 'AND'; // phpcs:ignore
		}

		if ( isset( $this->post_data['sort'] ) && ! empty( $this->post_data['sort'] ) ) {
			$sortby_val = isset( $this->post_data['sort'] ) && ! empty( $this->post_data['sort'] ) ? wte_clean( wp_unslash( $this->post_data['sort'] ) ) : 'menu_order';
			$sort_args  = wte_advanced_search_get_order_args( $sortby_val );
			$args       = array_merge( $query_args, $sort_args );
		}

		if ( ! empty( $this->post_data['wte_orderby'] ) || ! empty( $this->post_data['sort'] ) ) {
			$order_by   = $ajax_request ? $this->post_data['sort'] : wte_clean( wp_unslash( $this->post_data['wte_orderby'] ) );
			$sort_args = wte_advanced_search_get_order_args( $order_by ); // phpcs:ignore
			$query_args = array_merge( $query_args, $sort_args );
		}
		// phpcs:enable

		return apply_filters( 'query_args_for_trip_filters', $query_args );
	}

	/**
	 * Retrieves the duration range.
	 */
	public static function get_duration_range() {
		self::get_range( 'wte_duration_range' );
	}

	/**
	 * Retrieves the price range.
	 */
	public static function get_price_range() {
		self::get_range( 'wte_price_range' );
	}

	/**
	 * Retrieves the duration or price range.
	 *
	 * @param string $range_type The type of range to retrieve ('wte_duration_range' or 'wte_price_range').
	 * @return object The range object.
	 */
	public static function get_range( $range_type ) {
		global $wpdb;

		$range = wp_cache_get( $range_type, 'options' );

		if ( ! $range ) {
			$meta_key = 'wte_duration_range' === $range_type ? '_s_duration' : '_s_price';
			$where    = $wpdb->prepare( 'meta_key = %s', $meta_key );
			$query    = "SELECT MIN(meta_value * 1) as `min_value`, MAX(meta_value * 1) as `max_value` FROM {$wpdb->postmeta} WHERE {$where}";
			$results 	= $wpdb->get_row($query); // phpcs:ignore
			$range    = array(
				'min_value' => 0,
				'max_value' => 0,
			);
			if ( ! empty( $results ) ) {
				$range = $results;
				if ( 'wte_duration_range' === $range_type ) {
					$range->min_value = 0;
					$range->max_value = $range->max_value / 24;
				}
			}
			wp_cache_add( $range_type, $range, 'options' );
		}

		return (object) $range;
	}
}
