<?php
namespace WPTRAVELENGINEEB;

use WPTRAVELENGINEEB\Widget;

/**
 * Trip Search Widget.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class Widgets.
 *
 * @since 1.0.0
 */
class Widget_Trip_Search extends Widget {

    /**
     *
     * @var $widget_name
     */
	public $widget_name = 'wptravelengine-trip-search';

    /**
	 * Widget Settings.
	 */
	protected function register_controls() {
		wp_enqueue_style( 'wte-fonts-style' );
		$settings = Widgets_Controller::instance()->get_core_widget_setting( $this->widget_name, 'controls' );
		$controls = isset( $settings['controls'] ) && is_array( $settings['controls'] ) ? $settings['controls'] : array();
		$this->_wte_add_controls( $settings );

		$controls = include WPTRAVELENGINEEB_PATH . 'includes/widgets/trip-search/controls.php';

		$this->_wte_add_controls( $controls );
	}
}
