<?php
/**
 * Carousel Widget.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

namespace WPTRAVELENGINEEB\Trip;

use WPTRAVELENGINEEB\Widget;
use WPTRAVELENGINEEB;

/**
 * Class Carousel.
 *
 * @since 1.3.0
 */
class CarouselWidget extends Widget {

	/**
	 * Widget name.
	 *
	 * @since 1.3.0
	 *
	 * @var string
	 */
	public $widget_name = 'wte-carousel';

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
	protected $keywords = array( 'carousel', 'wp travel engine', 'wte' );

	/**
	 * Set Widget Title.
	 *
	 * @since 1.3.0
	 */
	public function get_title() {
		return __( 'Trip - Carousel', 'wptravelengine-elementor-widgets' );
	}

	/**
	 * Set Widget Icon.
	 *
	 * @since 1.3.0
	 */
	public function get_icon() {
		return 'eicon-media-carousel';
	}

	/**
	 * Javascripts dependencies.
	 *
	 * @since 1.3.0
	 */
	public function get_script_depends() {
		if ( defined( 'WP_TRAVEL_ENGINE_VERSION' ) ) {
			return array( 'wp-travel-engine', 'wte-editor' );
		}
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
		$controls = include WPTRAVELENGINEEB_PATH . 'includes/trip-widgets/carousel/controls.php';
		$this->_wte_add_controls( $controls );
	}

	/**
	 * Renders Widget.
	 *
	 * @since 1.3.0
	 */
	protected function render() {
		$attributes               = $this->get_settings_for_display();
		$is_elementor_editor_page = $this->is_elementor_editor_page();
		if ( file_exists( WPTRAVELENGINEEB_PATH . 'includes/trip-widgets/carousel/carousel.php' ) ) {
			$wpte_trip_images = get_post_meta( get_the_ID(), 'wpte_gallery_id', true );
			if ( empty( $wpte_trip_images ) && $is_elementor_editor_page ) {
				include_once WPTRAVELENGINEEB_PATH . 'includes/trip-widgets/carousel/demo.php';
			} else {
				include WPTRAVELENGINEEB_PATH . 'includes/trip-widgets/carousel/carousel.php';
			}
		} else {
			echo esc_html__( '<p>Oops! No preview/output available for this widget.</p>', 'wptravelengine-elementor-widgets' );
		}
	}
}
