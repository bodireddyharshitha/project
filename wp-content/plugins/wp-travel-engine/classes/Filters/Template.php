<?php

namespace WPTravelEngine\Filters;

use WP_Block_Template;

class Template {

	/**
	 * Initializes hooks for template inclusion and excerpt modification.
	 */
	public function hooks() {
		add_filter( 'template_include', array( $this, 'include_trip_template' ) );
		// add_filter( 'get_the_excerpt', array( $this, 'get_the_excerpt' ), 11, 2 );

		$fse_templates = new FSE_Template();
		$fse_templates->hooks();
	}

	/**
	 * Includes the appropriate template based on the post type and context.
	 *
	 * @param string $template_path The current template path.
	 *
	 * @return string The modified template path.
	 */
	public function include_trip_template( string $template_path ): string {
		$wp_travel_engine_settings = get_option( 'wp_travel_engine_settings', array() );
		$is_enabled_fse_template   = $wp_travel_engine_settings['enable_fse_template'] ?? 'no';
		if ( current_theme_supports( 'wptravelengine-templates' ) || ( wp_is_block_theme() && $is_enabled_fse_template == 'yes' ) ) {
			return $template_path;
		}
		if ( get_post_type() === \WP_TRAVEL_ENGINE_POST_TYPE ) {
			if ( is_single() ) {
				$template_path = wte_locate_template( 'single-trip.php' );
			}
			if ( is_archive() ) {
				$template_path = wte_locate_template( 'archive-trip.php' );
			}
			$taxonomies = array( 'trip_types', 'destination', 'activities' );
			foreach ( $taxonomies as $tax ) {
				if ( is_tax( $tax ) ) {
					$template_path = wte_locate_template( 'taxonomy-' . $tax . '.php' );
				}
			}
		}

		return $template_path;
	}
}
