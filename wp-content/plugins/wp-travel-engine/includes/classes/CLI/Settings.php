<?php
/**
 * CLI Class to handle trips.
 *
 * @package WPTravelEngine\CLI
 * @since 6.0.0
 */

namespace WPTravelEngine\CLI;

use WP_CLI;
use WP_CLI_Command;

/**
 * Class Trip
 *
 * @since 6.0.0
 */
class Settings extends WP_CLI_Command {

	/**
	 * List all settings.
	 *
	 * ## EXAMPLES
	 *
	 *     wp wp-travel-engine settings list
	 *
	 * @subcommand list
	 */
	public function list() {
		$settings = get_option( 'wp_travel_engine_settings', array() );
		WP_CLI::line( json_encode( $settings ) );
	}

	/**
	 * Get a setting.
	 *
	 * ## EXAMPLES
	 *
	 *     wp wp-travel-engine settings get <setting>
	 *
	 * @subcommand get
	 */
	public function get( $args ) {
		$setting  = $args[0];
		$settings = get_option( 'wp_travel_engine_settings', array() );
		if ( isset( $settings[ $setting ] ) ) {
			WP_CLI::line( json_encode( $settings[ $setting ] ) );
		} else {
			WP_CLI::error( 'Setting not found.' );
		}
	}

	/**
	 * Update a setting.
	 *
	 * ## EXAMPLES
	 *
	 *     wp wp-travel-engine settings update <setting> <value>
	 *
	 * @subcommand update
	 */
	public function update( $args ) {
		$setting              = $args[0];
		$value                = $args[1];
		$settings             = get_option( 'wp_travel_engine_settings', array() );
		$settings[ $setting ] = $value;
		update_option( 'wp_travel_engine_settings', $settings );
		WP_CLI::success( 'Setting updated.' );
	}
}
