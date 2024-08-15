<?php
/**
 * Highlights Widget.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

namespace WPTRAVELENGINEEB\Trip;

use WPTRAVELENGINEEB\Widget;
use WPTRAVELENGINEEB;

/**
 * Class Highlights.
 *
 * @since 1.3.0
 */
class HighlightsWidget extends Widget {

	/**
	 * Widget name.
	 *
	 * @since 1.3.0
	 *
	 * @var string
	 */
	protected $widget_name = 'wte-highlights';

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
	protected $keywords = array( 'highlights', 'wp travel engine', 'wte' );

	/**
	 * Set Widget Title.
	 *
	 * @since 1.3.0
	 */
	public function get_title() {
		return __( 'Trip - Highlights', 'wptravelengine-elementor-widgets' );
	}

	/**
	 * Set Widget Icon.
	 *
	 * @since 1.3.0
	 */
	public function get_icon() {
		return 'eicon-code-highlight';
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

		$controls = include WPTRAVELENGINEEB_PATH . 'includes/trip-widgets/highlights/controls.php';

		$this->_wte_add_controls( $controls );
	}

	/**
	 * Renders Widget.
	 *
	 * @since 1.3.0
	 */
	protected function render() {
		$attributes = $this->get_settings_for_display();
		global $post;
		$highlights               = array();
		$demo_trip_highlights     = array(
			'0' => array(
				'highlight_text' => __( 'Spectacular views of Everest, Lhotse, Nuptse, and other towering peaks', 'wptravelengine-elementor-widgets' ),
			),
			'1' => array(
				'highlight_text' => __( 'Exploring vibrant Sherpa culture and monasteries in Namche Bazaar', 'wptravelengine-elementor-widgets' ),
			),
			'2' => array(
				'highlight_text' => __( 'Passing through the stunning Sagarmatha National Park', 'wptravelengine-elementor-widgets' ),
			),
			'3' => array(
				'highlight_text' => __( 'Reaching Everest Base Camp at an altitude of about 5,364 meters (17,598 feet)', 'wptravelengine-elementor-widgets' ),
			),
			'4' => array(
				'highlight_text' => __( 'Visiting the vantage point of Kala Patthar for sunrise views', 'wptravelengine-elementor-widgets' ),
			),
			'5' => array(
				'highlight_text' => __( 'Immersing yourself in the warmth of local Sherpa hospitality', 'wptravelengine-elementor-widgets' ),
			),
		);
		$trip_settings            = get_post_meta( $post->ID, 'wp_travel_engine_setting', true );
		$trip_highlights          = $trip_settings['trip_highlights'] ?? '';
		$is_elementor_editor_page = $this->is_elementor_editor_page();
		if ( $is_elementor_editor_page && empty( $trip_highlights ) ) {
			$trip_highlights = $demo_trip_highlights;
		}
		$highlights = '';
		if ( ! empty( $trip_highlights ) ) {
			foreach ( $trip_highlights as $highlight_content ) {
				$highlights .= '<li>' . esc_html( $highlight_content['highlight_text'] ) . '</li>';
			}
		}

		?>
		<div id="wte-highlights" class="highlights-content">
			<ul class="wpte-trip-highlights">
				<?php echo wp_kses_post( $highlights ); ?>
			</ul>
		</div>
		<?php
	}
}
