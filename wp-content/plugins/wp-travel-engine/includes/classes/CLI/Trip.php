<?php
/**
 * CLI Class to handle trips.
 *
 * @package WPTravelEngine\CLI
 * @since 6.0.0
 */

namespace WPTravelEngine\CLI;

use WP_CLI_Command;
use WP_CLI;
use WP_Query;

/**
 * Class Trip
 *
 * @since 6.0.0
 */
class Trip extends WP_CLI_Command {

	/**
	 * List all trips.
	 *
	 * ## OPTIONS
	 *
	 * [--fields=<fields>]
	 * : Limit the output to specific fields. Defaults to all fields.
	 *
	 * [--format=<format>]
	 * : Render output in a particular format.
	 * ---
	 * default: table
	 * options:
	 *   - table
	 *   - csv
	 *   - json
	 *   - yaml
	 * ---
	 *
	 * ## EXAMPLES
	 *
	 *     wp wp-travel-engine trip list
	 *
	 * @when after_wp_load
	 */
	public function list( $args, $assoc_args ) {
		$trips = new WP_Query( array(
			'post_type'      => 'trip',
			'posts_per_page' => - 1,
		) );

		$items = array();
		foreach ( $trips->posts as $trip ) {
			$item                 = array();
			$item[ 'ID' ]         = $trip->ID;
			$item[ 'post_title' ] = $trip->post_title;
			$item[ 'post_date' ]  = $trip->post_date;
			$items[]              = $item;
		}

		$formatter = new WP_CLI\Formatter( $assoc_args, array( 'ID', 'post_title', 'post_date' ) );
		$formatter->display_items( $items );
	}

	/**
	 * Create a new trip.
	 *
	 * ## OPTIONS
	 *
	 * --post_title=<post_title>
	 * : The title of the new trip.
	 *
	 * [--post_content=<post_content>]
	 * : The content of the new trip. Default is empty.
	 *
	 * [--post_status=<post_status>]
	 * : The status of the new trip. Default is 'publish'.
	 *
	 * [--post_author=<post_author>]
	 * : The author of the new trip. Default is the current user.
	 *
	 * ## EXAMPLES
	 *
	 *     wp wp-travel-engine trip create --post_title="New Trip" --post_content="This is a new trip." --post_status="draft"
	 *
	 * @when after_wp_load
	 */
	public function create( $args, $assoc_args ) {
		$post_title   = WP_CLI\Utils\get_flag_value( $assoc_args, 'post_title' );
		$post_content = WP_CLI\Utils\get_flag_value( $assoc_args, 'post_content', '' );
		$post_status  = WP_CLI\Utils\get_flag_value( $assoc_args, 'post_status', 'publish' );
		$post_author  = WP_CLI\Utils\get_flag_value( $assoc_args, 'post_author', get_current_user_id() );

		$post_id = \wp_insert_post( array(
			'post_type'    => WP_TRAVEL_ENGINE_POST_TYPE,
			'post_title'   => $post_title,
			'post_content' => $post_content,
			'post_status'  => $post_status,
			'post_author'  => $post_author,
		) );

		if ( $post_id ) {
			WP_CLI::success( "Created trip $post_id." );
		} else {
			WP_CLI::error( "Error creating trip." );
		}
	}

	/**
	 * Delete a trip.
	 *
	 * ## OPTIONS
	 *
	 * <id>
	 * : The ID of the trip to delete.
	 *
	 * ## EXAMPLES
	 *
	 *     wp wp-travel-engine trip delete 123
	 *
	 * @when after_wp_load
	 */
	public function delete( $args, $assoc_args ) {
		$trip_id = $args[ 0 ];

		$result = wp_delete_post( $trip_id, true );

		if ( $result ) {
			WP_CLI::success( "Deleted trip $trip_id." );
		} else {
			WP_CLI::error( "Error deleting trip $trip_id." );
		}
	}

	protected function insert_pricing_catgories() {
		$terms = array( 'Adult', 'Child', 'Infant' );

		foreach ( $terms as $term ) {
			$term_exists = term_exists( $term, 'trip-packages-categories' );

			if ( $term_exists ) {
				continue;
			}

			$inserted_term = wp_insert_term( $term, 'trip-packages-categories' );

			if ( is_wp_error( $inserted_term ) ) {
				WP_CLI::error( "Error inserting term $term: " . $inserted_term->get_error_message() );
			} else {
				if ( 'Adult' === $term ) {
					update_option( 'primary_pricing_category', $inserted_term[ 'term_id' ] );
				}
				WP_CLI::log( "Inserted term $term with ID " . $inserted_term[ 'term_id' ] );
			}
		}
	}

	protected function generate_random_paragraph( $num_words = 50 ) {
		$words = array(
			'lorem',
			'ipsum',
			'dolor',
			'sit',
			'amet',
			'consectetur',
			'adipiscing',
			'elit',
			'curabitur',
			'vel',
			'hendrerit',
			'libero',
			'integer',
			'sem',
			'et',
			'malesuada',
			'fames',
			'ac',
			'turpis',
			'egestas',
			'duis',
			'autem',
			'vel',
			'eum',
			'iriure',
			'dolor',
			'in',
			'hendrerit',
			'in',
			'vulputate',
			'velit',
			'esse',
			'molestie',
			'consequat',
			'vel',
			'illum',
			'dolore',
			'eu',
			'feugiat',
			'nulla',
			'facilisis',
			'at',
			'vero',
			'eros',
			'et',
			'accumsan',
			'et',
			'iusto',
			'odio',
			'dignissim',
			'qui',
			'blandit',
			'praesent',
			'luptatum',
			'zzril',
			'delenit',
			'augue',
			'duis',
			'dolore',
			'te',
			'feugait',
			'nulla',
			'facilisi',
			'nam',
			'liber',
			'tempor',
			'cum',
			'soluta',
			'nobis',
			'eleifend',
			'option',
			'congue',
			'nihil',
			'imperdiet',
			'doming',
			'id',
			'quod',
			'mazim',
			'placerat',
			'facer',
			'possim',
			'assum',
			'lorem',
			'ipsum',
			'dolor',
			'sit',
			'amet',
			'consectetur',
			'adipiscing',
			'elit',
			'sed',
			'do',
			'eiusmod',
			'tempor',
			'incididunt',
			'ut',
			'labore',
			'et',
			'dolore',
			'magna',
			'aliqua',
			'ut',
			'enim',
			'ad',
			'minim',
			'veniam',
			'quis',
			'nostrud',
			'exercitation',
			'ullamco',
			'laboris',
			'nisi',
			'ut',
			'aliquip',
			'ex',
			'ea',
			'commodo',
			'consequat',
			'duis',
			'aute',
			'irure',
			'dolor',
			'in',
			'reprehenderit',
			'in',
			'voluptate',
			'velit',
			'esse',
			'cillum',
			'dolore',
			'eu',
			'fugiat',
			'nulla',
			'pariatur',
			'excepteur',
			'sint',
			'occaecat',
			'cupidatat',
			'non',
			'proident',
			'sunt',
			'in',
			'culpa',
			'qui',
			'officia',
			'deserunt',
			'mollit',
			'anim',
			'id',
			'est',
			'laborum',
			'et',
			'dolore',
			'magna',
			'aliqua',
			'ut',
			'enim',
			'ad',
			'minim',
			'veniam',
			'quis',
			'nostrud',
			'exercitation',
			'ullamco',
			'laboris',
			'nisi',
			'ut',
			'aliquip',
			'ex',
			'ea',
			'commodo',
			'consequat',
			'duis',
			'aute',
			'irure',
			'dolor',
			'in',
			'reprehenderit',
			'in',
			'voluptate',
			'velit',
			'esse',
			'cillum',
			'dolore',
			'eu',
			'fugiat',
			'nulla',
			'pariatur',
			'excepteur',
			'sint',
			'occaecat',
			'cupidatat',
			'non',
			'proident',
			'sunt',
			'in',
			'culpa',
			'qui',
			'officia',
			'deserunt',
			'mollit',
			'anim',
			'id',
			'est',
			'laborum',
		);

		$paragraph = '';

		for ( $i = 0; $i < $num_words; $i ++ ) {
			$paragraph .= $words[ array_rand( $words ) ] . ' ';
		}

		return $paragraph;
	}

	protected function sample_trip_settings() {
		$duration_units     = [ 'days', 'hours' ];
		$boolean            = [ 'true', 'false' ];
		$trip_duration      = rand( 1, 20 );
		$minimum_pax        = rand( 0, 5 );
		$trip_duration_unit = $duration_units[ array_rand( $duration_units ) ];

		return [
			'trip_duration'          => $trip_duration,
			'trip_duration_unit'     => $trip_duration_unit,
			'trip_duration_nights'   => $trip_duration,
			'trip_cutoff_enable'     => $boolean[ array_rand( $boolean ) ],
			'trip_cut_off_time'      => rand( 1, $trip_duration ),
			'trip_cut_off_unit'      => $trip_duration_unit,
			'min_max_age_enable'     => $boolean[ array_rand( $boolean ) ],
			'trip_minimum_pax'       => $minimum_pax,
			'trip_maximum_pax'       => rand( $minimum_pax, 100 ),
			'overview_section_title' => 'Overview',
			'tab_content'            => [
				'1_wpeditor' => $this->generate_random_paragraph( rand( 50, 100 ) ),
			],
			'trip_highlights_title'  => 'Trip Highlights',
			'trip_highlights'        => array_map( function () {
				return [ 'highlight_text' => $this->generate_random_paragraph( rand( 5, 10 ) ) ];
			}, range( 1, rand( 5, 10 ) ) ),
			'trip_itinerary_title'   => 'Trip Itineraries',
			'itinerary'              => [
				'itinerary_title'   => array_map( function ( $day ) {
					return $this->generate_random_paragraph( rand( 5, 10 ) );
				}, 'hours' === $trip_duration_unit ? [ 0 ] : range( 0, $trip_duration ) ),
				'itinerary_content' => array_map( function ( $day ) {
					return $this->generate_random_paragraph( rand( 50, 100 ) );
				}, 'hours' === $trip_duration_unit ? [ 0 ] : range( 0, $trip_duration ) ),
			],
			'cost_tab_sec_title'     => 'Includes/Excludes',
			'cost'                   => [
				'includes_title' => 'Cost Includes',
				'cost_includes'  => implode( "\n", array_map( function () {
					return $this->generate_random_paragraph( rand( 5, 20 ) );
				}, range( 1, 10 ) ) ),
				'excludes_title' => 'Cost Excludes',
				'cost_excludes'  => implode( "\n", array_map( function () {
					return $this->generate_random_paragraph( rand( 5, 20 ) );
				}, range( 1, 10 ) ) ),
			],
			'trip_facts_title'       => 'Trip Info',
			'trip_facts'             => [
				'field_id'   => [ 'Accomodation', 'Admission Fee', 'Language', 'Guides' ],
				'field_type' => [ 'text', 'text', 'text', 'text' ],
				0            => [ 0 => '5 Star Hotel' ],
				1            => [ 1 => 'No' ],
				2            => [ 2 => 'English, Deustsch' ],
				3            => [ 3 => 'Yes' ],
			],
		];

	}

	function download_and_attach_image( $post_id, $image_url ) {
		// Download the image from the URL
		$image_data = file_get_contents( $image_url );

		// Generate a unique filename for the image
		$filename    = basename( $image_url );
		$filename    = wp_unique_filename( wp_upload_dir()[ 'path' ], $filename );
		$upload_dir  = wp_upload_dir();
		$upload_path = $upload_dir[ 'path' ] . '/' . $filename;

		// Write the image data to the file
		file_put_contents( $upload_path, $image_data );

		// Insert the attachment into the media library
		$attachment = array(
			'post_mime_type' => 'image/' . pathinfo( $filename, PATHINFO_EXTENSION ),
			'post_title'     => preg_replace( '/\.[^.]+$/', '', $filename ),
			'post_content'   => '',
			'post_status'    => 'inherit',
		);
		$attach_id  = wp_insert_attachment( $upload_path, $post_id, 'inherit' );
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		$attach_data = wp_generate_attachment_metadata( $attach_id, $upload_path );
		wp_update_attachment_metadata( $attach_id, $attach_data );

		return $attach_id;

		// Set the featured image for the post
	}

	protected function insert_package( $trip_id ) {

		$terms = get_terms( [
			'taxonomy'   => 'trip-packages-categories',
			'hide_empty' => false,
			'fields'     => 'id=>name',
		] );

		$package_categories = [];
		foreach ( $terms as $term_id => $term_name ) {
			$price                                             = rand( 100, 1000 );
			$package_categories[ 'c_ids' ][ $term_id ]         = $term_id;
			$package_categories[ 'labels' ][ $term_id ]        = $term_name;
			$package_categories[ 'prices' ][ $term_id ]        = $price;
			$package_categories[ 'pricing_types' ][ $term_id ] = 'fixed';
			$package_categories[ 'enabled_sale' ][ $term_id ]  = (bool) array_rand( [ 0, 1 ] );
			$package_categories[ 'sale_prices' ][ $term_id ]   = (int) $price * rand( 80, 90 ) / 100;
			$package_categories[ 'min_paxes' ][ $term_id ]     = rand( 0, 1 );
			$package_categories[ 'max_paxes' ][ $term_id ]     = rand( 6, 100 );
		}

		$package_id = wp_insert_post(
			array(
				'post_title'  => 'Default Package',
				'post_status' => 'publish',
				'post_type'   => 'trip-packages',
				'meta_input'  => [
					'trip_ID'            => $trip_id,
					'package-categories' => $package_categories,
				],
			)
		);

		update_post_meta( $trip_id, 'packages_ids', [ $package_id ] );

		return $package_id;
	}

	/**
	 * Create sample trips.
	 *
	 * ## OPTIONS
	 *
	 * <count>
	 * : The number of sample trips to create.
	 *
	 * ## EXAMPLES
	 *
	 *     wp wp-travel-engine trip create-sample 10
	 *
	 * @when after_wp_load
	 */
	public function create_sample( $args, $assoc_args ) {
		$count = $args[ 0 ] ?? 1;

		$adjectives   = array( 'Adventure', 'Exciting', 'Relaxing', 'Thrilling', 'Scenic' );
		$destinations = array( 'Beach', 'Mountain', 'City', 'Wildlife', 'Island' );
		$actions      = array( 'Getaway', 'Tour', 'Exploration', 'Journey', 'Escape' );

		$this->insert_pricing_catgories();

		// Shuffle the arrays
		shuffle( $adjectives );
		shuffle( $destinations );
		shuffle( $actions );

		// Create sample trips
		for ( $i = 0; $i < $count; $i ++ ) {
			$destination = array_shift( $destinations );
			$trip_type   = array_shift( $adjectives );
			$activity    = array_shift( $actions );

			$post_title   = sprintf( '%s %s %s', $trip_type, $destination, $activity );
			$post_content = 'This is a sample trip created by WP-CLI.';
			$post_status  = 'publish';
			$post_author  = get_current_user_id();

			$trip_duration = rand( 1, 20 );

			$trip_settings = $this->sample_trip_settings();
			$post_id       = wp_insert_post( array(
				'post_type'    => 'trip',
				'post_title'   => wp_slash( $post_title ),
				'post_content' => wp_slash( $post_content ),
				'post_status'  => $post_status,
				'post_author'  => $post_author,
				'meta_input'   => [
					'trip_version'                           => '2.0.0',
					'wp_travel_engine_setting_trip_duration' => $trip_settings[ 'trip_duration' ],
					'_s_duration'                            => $trip_settings[ 'trip_duration' ] * 24,
					'wp_travel_engine_trip_min_age'          => rand( 1, 16 ),
					'wp_travel_engine_trip_max_age'          => rand( 40, 60 ),
				],
			) );

			$trip_settings[ 'trip_code' ] = "WTE-{$post_id}";

			update_post_meta( $post_id, 'wp_travel_engine_setting', $trip_settings );

			$destination_term = get_term_by( 'slug', lcfirst( $destination ), 'destination' );
			if ( false === $destination_term ) {
				$destination_term = (object) wp_insert_term( wp_slash( $destination ), 'destination' );
			}
			wp_set_object_terms( $post_id, $destination_term->term_id, 'destination' );

			$trip_type_term = get_term_by( 'slug', lcfirst( $trip_type ), 'trip_types' );
			if ( false === $trip_type_term ) {
				$trip_type_term = (object) wp_insert_term( wp_slash( $trip_type ), 'trip_types' );
			}
			wp_set_object_terms( $post_id, $trip_type_term->term_id, 'trip_types' );

			$activity_term = get_term_by( 'slug', lcfirst( $activity ), 'activities' );
			if ( false === $activity_term ) {
				$activity_term = (object) wp_insert_term( wp_slash( $activity ), 'activities' );
			}
			wp_set_object_terms( $post_id, $activity_term->term_id, 'activities' );

			$this->insert_package( $post_id );

			$gallery = array();
			foreach ( range( 0, rand( 1, 2 ) ) as $i ) {
				$background_color = sprintf( '%06X', mt_rand( 0, 0xFFFFFF ) );
				$text_color       = 'ffffff';

				$url = "https://placehold.co/1920x1080/$background_color/$text_color.jpeg/?font=roboto&text=" . str_replace( ' ', '+', $post_title );
				$attachment = media_sideload_image( $url, $post_id, null, 'id' );

				if ( ! is_wp_error( $attachment ) ) {
					$gallery[] = $attachment;
				} else {
					WP_CLI::log( $attachment->get_error_message() );
				}
			}

			set_post_thumbnail( $post_id, $gallery[ 0 ] );

			update_post_meta( $post_id, 'wpte_gallery_id', [
				'enable' => '1',
				...$gallery,
			] );

			if ( $post_id ) {
				WP_CLI::log( "Created sample trip $post_id." );
			} else {
				WP_CLI::error( "Error creating sample trip." );
			}
		}
	}
}
