<?php
/**
 * Itinerary Widget.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

namespace WPTRAVELENGINEEB\Trip;

use WPTRAVELENGINEEB\Widget;
use WPTRAVELENGINEEB;

/**
 * Class Itinerary.
 *
 * @since 1.3.0
 */
class ItineraryWidget extends Widget {
	/**
	 * Widget name.
	 *
	 * @since 1.3.0
	 *
	 * @var string
	 */
	protected $widget_name = 'wte-itinerary';

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
	protected $keywords = array( 'itinerary', 'wp travel engine', 'wte' );

	/**
	 * Set Widget Title.
	 *
	 * @since 1.3.0
	 */
	public function get_title() {
		return __( 'Trip - Itinerary', 'wptravelengine-elementor-widgets' );
	}

	/**
	 * Set Widget Icon.
	 *
	 * @since 1.3.0
	 */
	public function get_icon() {
		return 'eicon-post-list';
	}

	/**
	 * Javascripts dependencies.
	 *
	 * @since 1.3.0
	 */
	public function get_script_depends() {
		global $post;
		if ( defined( 'WTEAI_VERSION' ) ) {

			$itinerary                   = new \WTE_Advanced_Itinerary_Init();
			$settings                    = get_option( 'wp_travel_engine_settings', array() );
			$chart_settings              = isset( $settings['wte_advance_itinerary']['chart'] ) && is_array( $settings['wte_advance_itinerary']['chart'] ) ? $settings['wte_advance_itinerary']['chart'] : array();
			$chart_settings['chartData'] = get_post_meta( $post->ID, 'trip_itinerary_chart_data' );
			$chart_settings['unit']      = ! empty( $settings['wte_advance_itinerary']['chart']['alt_unit'] ) ? $settings['wte_advance_itinerary']['chart']['alt_unit'] : 'm';
			$options                     = wp_parse_args( $chart_settings, $itinerary->default_chart_settings() );
			wp_localize_script(
				'wte-editor',
				'chartData',
				apply_filters(
					'chartData',
					$options,
					$post->ID
				)
			);
			return array( 'wte-editor', 'wte-chart', 'wte-chart-datalabels' );
		} else {
			return array( 'wte-editor' );
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
		$controls = include WPTRAVELENGINEEB_PATH . 'includes/trip-widgets/itinerary/controls.php';
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
		if ( file_exists( WPTRAVELENGINEEB_PATH . 'includes/trip-widgets/itinerary/itinerary.php' ) ) {
			$tabs = get_post_meta( get_the_ID(), 'wp_travel_engine_setting', true );
			if ( empty( $tabs['itinerary'] ) && $is_elementor_editor_page ) {
				include_once WPTRAVELENGINEEB_PATH . 'includes/trip-widgets/itinerary/demo.php';
			} else {
				include_once WPTRAVELENGINEEB_PATH . 'includes/trip-widgets/itinerary/itinerary.php';
			}
		} else {
			echo esc_html__( 'Oops! No preview/output available for this widget.', 'wptravelengine-elementor-widgets' );
		}
	}
}
