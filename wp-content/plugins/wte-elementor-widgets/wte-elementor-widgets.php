<?php
/**
 * Plugin Name: WP Travel Engine - Elementor Widgets
 * Plugin URI: http://wordpress.org/plugins/wte-elementor-widgets
 * Description: The plugin helps you to use Elementor to create a travel booking website. It seamlessly works with WP Travel Engine, the most popular travel booking plugin, to display trips/tours, destinations, activities, trip types and advanced search.
 * Version: 1.3.4
 * Author: WP Travel Engine
 * Author URI: http://wptravelengine.com
 * Requires at least: 5.0
 * Requires PHP: 7.0
 * Tested up to: 6.6
 * WTE requires at least: 5.2
 * WTE tested up to: 6.0
 *
 * Text Domain: wptravelengine-elementor-widgets
 * Domain Path: /languages/
 *
 * @package wptravelengine-elementor-blocks
 * @category Addon
 * @author WP Travel Engine
 */

defined( 'ABSPATH' ) || exit;

define( 'WPTRAVELENGINEEB_FILE__', __FILE__ );
define( 'WPTRAVELENGINEEB_PATH', plugin_dir_path( WPTRAVELENGINEEB_FILE__ ) );
define( 'WPTRAVELENGINEEB_VERSION', '1.3.4' );
define( 'WPTRAVELENGINEEB_REQUIRES_AT_LEAST', '5.2.0' );
define( 'WPTRAVELENGINEEB_NEWCONTROL', '<span class="wte-elementor-new-control"> New</span>' );
register_activation_hook( __FILE__, 'wptravelengineeb_activation' );
/**
 * Activation hook.
 *
 * @since 1.0.0
 */
function wptravelengineeb_activation() {
	require WPTRAVELENGINEEB_PATH . 'includes/class-activator.php';
	\WPTRAVELENGINEEB\Activation::init();
}

register_deactivation_hook( __FILE__, 'wptravelengineeb_deactivation' );
/**
 * Deactivation hook.
 *
 * @since 1.0.0
 */
function wptravelengineeb_deactivation() {

}

/**
 * Load Plugin
 *
 * @since 1.0.0
 */
add_action(
	'plugins_loaded',
	function() {
		if ( ! defined( 'WP_TRAVEL_ENGINE_VERSION' ) || version_compare( WP_TRAVEL_ENGINE_VERSION, WPTRAVELENGINEEB_REQUIRES_AT_LEAST, '<' ) ) {
			$dependencies[] = '<a class="thickbox open-plugin-details-modal" href="' . admin_url( 'plugin-install.php' ) . '?tab=plugin-information&plugin=wp-travel-engine&TB_iframe=true&width=640&height=500" target="__blank">WP Travel Engine</a>';
		}

		if ( ! class_exists( '\Elementor\Plugin' ) ) {
			$dependencies[] = '<a class="thickbox open-plugin-details-modal" href="' . admin_url( 'plugin-install.php' ) . '?tab=plugin-information&plugin=elementor&TB_iframe=true&width=640&height=500" target="__blank">Elementor</a>';
		}

		if ( ! empty( $dependencies ) ) {
			add_action(
				'admin_notices',
				function() use ( $dependencies ) {
					echo wp_kses_post(
						sprintf(
							'<div class="error"><p>'
							// translators: 1. WTE Extension Name 2. Link to WTE Plugin.
							. sprintf(
								__( '%1$s requires the %2$s plugin to work. Please install and activate the latest version of all plugins first.', 'wptravelengine-elementor-widgets' ),
								'<strong>WP Travel Engine - Elementor Widgets</strong>',
								implode( ' and ', $dependencies )
							)
							. '</p></div>'
						)
					);
				}
			);
			return;
		}

		require WPTRAVELENGINEEB_PATH . 'includes/class-plugin.php';
	}
);
