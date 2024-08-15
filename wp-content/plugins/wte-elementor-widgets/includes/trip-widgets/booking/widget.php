<?php
/**
 * Booking Widget.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

namespace WPTRAVELENGINEEB\Trip;

use WPTRAVELENGINEEB\Widget;
use WPTRAVELENGINEEB;

/**
 * Class Booking.
 *
 * @since 1.3.0
 */
class BookingWidget extends Widget {

	/**
	 * Widget name.
	 *
	 * @since 1.3.0
	 *
	 * @var string
	 */
	public $widget_name = 'wte-booking';

	/**
	 * Widget categories.
	 *
	 * @since 1.3.0
	 *
	 * @var array
	 */
	public $categories = array( 'wptravelengine' );

	/**
	 * Widget keywords.
	 *
	 * @since 1.3.0
	 *
	 * @var array
	 */
	protected $keywords = array( 'booking', 'wp travel engine', 'wte' );

	/**
	 * Set Widget Title.
	 *
	 * @since 1.3.0
	 */
	public function get_title() {
		return __( 'Trip - Booking', 'wptravelengine-elementor-widgets' );
	}

	/**
	 * Set Widget Icon.
	 *
	 * @since 1.3.0
	 */
	public function get_icon() {
		return 'eicon-product-add-to-cart';
	}

	/**
	 * Widget Settings.
	 *
	 * @since 1.3.0
	 */
	protected function register_controls() {
		wp_enqueue_style( 'wte-fonts-style' );
		$settings = WPTRAVELENGINEEB\Widgets_Controller::instance()->get_core_widget_setting( $this->widget_name, 'controls' );
		$controls = isset( $settings['controls'] ) && is_array( $settings['controls'] ) ? $settings['controls'] : array();
		$this->_wte_add_controls( $settings );
		$controls = include WPTRAVELENGINEEB_PATH . 'includes/trip-widgets/booking/controls.php';
		$this->_wte_add_controls( $controls );
	}

	/**
	 * Renders Widget.
	 *
	 * @since 1.3.0
	 */
	protected function render() {
		$attributes = $this->get_settings_for_display();
		$this->add_inline_editing_attributes( 'highlightContent', 'advanced' );
		$package_exists           = $this->render_condition();
		$is_elementor_editor_page = $this->is_elementor_editor_page();
		if ( ! $package_exists && $is_elementor_editor_page ) {
			include WPTRAVELENGINEEB_PATH . 'includes/trip-widgets/booking/demo.php';
		} elseif ( file_exists( WPTRAVELENGINEEB_PATH . 'includes/trip-widgets/booking/booking.php' ) ) {
			include WPTRAVELENGINEEB_PATH . 'includes/trip-widgets/booking/booking.php';
		} else {
			echo esc_html__( '<p>Oops! No preview/output available for this widget.</p>', 'wptravelengine-elementor-widgets' );
		}
	}

	/**
	 * Render Condition.
	 *
	 * @since 1.3.0
	 */
	protected function render_condition() {
		global $post;
		$trip_id = $post->ID;
		$wtetrip = \wte_get_trip( $trip_id );
		$package = $wtetrip->default_package;
		return isset( $package ) && $package;
	}
}
