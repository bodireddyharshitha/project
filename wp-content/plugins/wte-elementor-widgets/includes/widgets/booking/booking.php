<?php
namespace WPTRAVELENGINEEB;

use WPTRAVELENGINEEB\Widget;

/**
 * booking Widgets.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class Widgets.
 *
 * @since 1.0.0
 */
class Widget_Bookingss extends Widget {

	/**
	 *
	 * @var $widget_name
	 */
	public $widget_name = 'wte-bookingss';

	/**
	 * Javascripts dependencies.
	 */
	public function get_script_depends() {
		return array( 'wptravelengineeeb-trips' );
	}

	/**
	 * Widget Settings.
	 */
	protected function register_controls() {
		wp_enqueue_style( 'wte-fonts-style' );
		$settings = Widgets_Controller::instance()->get_core_widget_setting( $this->widget_name, 'controls' );
		$controls = isset( $settings['controls'] ) && is_array( $settings['controls'] ) ? $settings['controls'] : array();
		$this->_wte_add_controls( $settings );

		$controls = include WPTRAVELENGINEEB_PATH . 'includes/widgets/trips/controls.php';

		$this->_wte_add_controls( $controls );
	}
}
