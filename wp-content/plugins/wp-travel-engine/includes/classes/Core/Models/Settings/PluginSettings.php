<?php
/**
 * Plugin Settings Model.
 *
 * @package WPTravelEngine/Core/Models
 * @since 6.0.0
 */

namespace WPTravelEngine\Core\Models\Settings;

use WPTravelEngine\Core\Models\Settings\BaseSetting;
use WPTravelEngine\Traits\Factory;

/**
 * Class PluginSettings.
 *
 * @since 6.0.0
 */
class PluginSettings extends BaseSetting {

	use Factory;

	/**
	 * Constructor to set the option name and optional default settings.
	 */
	public function __construct() {
		parent::__construct( 'wp_travel_engine_settings', array() );
	}
}
