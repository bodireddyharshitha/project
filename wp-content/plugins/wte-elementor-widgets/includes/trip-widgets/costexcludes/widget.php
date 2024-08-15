<?php
/**
 * Cost Excludes Widget.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

namespace WPTRAVELENGINEEB\Trip;

use WPTRAVELENGINEEB\Widget;
use WPTRAVELENGINEEB;

/**
 * Class Cost Excludes.
 *
 * @since 1.3.0
 */
class CostExcludesWidget extends Widget {

	/**
	 * Widget name.
	 *
	 * @since 1.3.0
	 *
	 * @var string
	 */
	protected $widget_name = 'wte-costexcludes';

	/**
	 * Widget categories.
	 *
	 * @since 1.3.0
	 *
	 * @var array
	 */
	protected $categories = array( 'wptravelengine' );

	/**
	 * Widget keywords.
	 *
	 * @since 1.3.0
	 *
	 * @var array
	 */
	protected $keywords = array( 'costexcludes', 'wp travel engine', 'wte' );

	/**
	 * Set Widget Title.
	 *
	 * @since 1.3.0
	 */
	public function get_title() {
		return __( 'Trip - Cost Excludes', 'wptravelengine-elementor-widgets' );
	}

	/**
	 * Set Widget Icon.
	 *
	 * @since 1.3.0
	 */
	public function get_icon() {
		return 'eicon-minus-circle-o';
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

		$controls = include WPTRAVELENGINEEB_PATH . 'includes/trip-widgets/costexcludes/controls.php';

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
		if ( file_exists( WPTRAVELENGINEEB_PATH . 'includes/trip-widgets/costexcludes/costexcludes.php' ) ) {
			$post_meta             = get_post_meta( get_the_ID(), 'wp_travel_engine_setting', true );
			$cost_excludes_content = isset( $post_meta['cost']['cost_excludes'] ) ? $post_meta['cost']['cost_excludes'] : '';
			if ( empty( $cost_excludes_content ) && $is_elementor_editor_page ) {
				include WPTRAVELENGINEEB_PATH . 'includes/trip-widgets/costexcludes/demo.php';
			} else {
				include WPTRAVELENGINEEB_PATH . 'includes/trip-widgets/costexcludes/costexcludes.php';
			}
		} else {
			echo esc_html__( '<p>Oops! No preview/output available for this widget.</p>', 'wptravelengine-elementor-widgets' );
		}
	}
}
