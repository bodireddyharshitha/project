<?php

namespace WPTravelEngine\Filters;

use WP_Block_Template;
use WPTravelEngine\Assets;
use Elementor\Plugin;

class Template {

	/**
	 * Initializes hooks for template inclusion and excerpt modification.
	 */
	public function hooks() {
		add_filter( 'template_include', array( $this, 'include_trip_template' ) );

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

		if ( current_theme_supports( 'wptravelengine-templates' ) || ( wp_is_block_theme() && 'yes' == wptravelengine_settings()->get("enable_fse_template", "no") ) ) {
			if ( is_single() ) {
                \WP_Travel_Engine_Template_Hooks::get_instance();
                Assets::instance()
                    ->enqueue_script( 'single-trip' )
                    ->enqueue_style( 'single-trip' )
                    ->enqueue_script( 'trip-booking-modal' )
                    ->dequeue_script( 'wp-travel-engine' )
                    ->dequeue_style( 'wp-travel-engine' );
            }
			return $template_path;
		}

		if ( is_singular( WP_TRAVEL_ENGINE_POST_TYPE ) ) {
			\WP_Travel_Engine_Template_Hooks::get_instance();
			Assets::instance()
					->enqueue_script( 'single-trip' )
					->enqueue_style( 'single-trip' )
					->enqueue_script( 'trip-booking-modal' )
					->dequeue_script( 'wp-travel-engine' )
					->dequeue_style( 'wp-travel-engine' )
					->dequeue_style( 'wte-extra-services' )
					->dequeue_script( 'wte-extra-services' )
					->dequeue_style( 'wp-travel-engine-group-discount' )
					->dequeue_script( 'wp-travel-engine-group-discount' );
			$template_path = wte_locate_template( 'single-trip.php' );
		} elseif ( is_post_type_archive( WP_TRAVEL_ENGINE_POST_TYPE ) ) {
			$template_path = wte_locate_template( 'archive-trip.php' );
		} else {
			foreach ( array( 'trip_types', 'destination', 'activities' ) as $tax ) {
				if ( is_tax( $tax ) ) {
					$template_path = wte_locate_template( 'taxonomy-' . $tax . '.php' );
					break;
				}
			}
		}



		$this->enqueue_elementor_assets();

		return $template_path;
	}

	/**
	 * Enqueue Elementor assets if the current page is built with Elementor.
	 */
	public function enqueue_elementor_assets() {
		global $post;
		if ( $post && class_exists( '\Elementor\Plugin' ) && defined( 'WPTRAVELENGINEEB_VERSION' ) ) {
			$elementor_page = \Elementor\Plugin::$instance->documents->get( $post->ID );
			if ( $elementor_page ) {
				$settings = $elementor_page->get_properties() ?? false;
				if ( $settings && $elementor_page->is_built_with_elementor() && isset( $settings['support_wp_page_templates'] ) ) {
					Assets::instance()->enqueue_script( 'wp-travel-engine' )->enqueue_style( 'wp-travel-engine' );
					wp_enqueue_style( 'wte-blocks-index' );
				}
			}
		}
	}
}
