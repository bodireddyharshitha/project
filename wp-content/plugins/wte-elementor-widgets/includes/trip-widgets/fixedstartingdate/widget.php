<?php
/** Fixed Starting Date Widget.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

namespace WPTRAVELENGINEEB\Trip;

use WPTRAVELENGINEEB\Widget;
use WPTRAVELENGINEEB;

/**
 * Class FixedStartingDate.
 *
 * @since 1.3.0
 */
class FixedstartingdateWidget extends Widget {

	/**
	 * Widget name.
	 *
	 * @since 1.3.0
	 *
	 * @var string
	 */
	protected $widget_name = 'wte-fixed-starting-date';

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
	protected $keywords = array( 'fixed-starting-date', 'wp travel engine', 'wte' );

	/**
	 * Set Widget Title.
	 *
	 * @since 1.3.0
	 */
	public function get_title() {
		return __( 'Trip - Fixed Starting Date', 'wptravelengine-elementor-widgets' );
	}

	/**
	 * Set Widget Icon.
	 *
	 * @since 1.3.0
	 */
	public function get_icon() {
		return 'eicon-date';
	}

	/**
	 * Widget Settings.
	 *
	 * @since 1.3.0
	 */
	protected function register_controls() {
		if ( defined( 'WTE_FIXED_DEPARTURE_VERSION' ) ) {
			wp_enqueue_style( 'wte-fonts-style' );
			$settings = WPTRAVELENGINEEB\Widgets_Controller::instance()->get_core_widget_setting( $this->widget_name, 'controls' );
			$controls = isset( $settings['controls'] ) && is_array( $settings['controls'] ) ? $settings['controls'] : array();
			$this->_wte_add_controls( $settings );

			$controls = include WPTRAVELENGINEEB_PATH . 'includes/trip-widgets/fixedstartingdate/controls.php';

			$this->_wte_add_controls( $controls );
		}
	}

	/**
	 * Renders Widget.
	 *
	 * @since 1.3.0
	 */
	protected function render() {
		if ( defined( 'WTE_FIXED_DEPARTURE_VERSION' ) ) {
			$attributes = $this->get_settings_for_display();
			if ( file_exists( WPTRAVELENGINEEB_PATH . 'includes/trip-widgets/fixedstartingdate/fixedstartingdate.php' ) ) {
				include WPTRAVELENGINEEB_PATH . 'includes/trip-widgets/fixedstartingdate/fixedstartingdate.php';
			} else {
				echo esc_html__( '<p>Oops! No preview/output available for this widget.</p>', 'wptravelengine-elementor-widgets' );
			}
		} else {
			$is_elementor_editor_page = $this->is_elementor_editor_page();
			if( ! $is_elementor_editor_page ){
				return '';
			}
			?>
				<div class="wpte-info-block">
					<p>
						<?php
						echo wp_kses(
							sprintf(
								// translators: %1$s: opening anchor tag, %2$s: closing anchor tag.
								__( 'Trip - Fixed Starting Dates Widget requires WP Travel Engine - Trip Fixed Starting Dates Addon to work. %1$sGet Trip Fixed Starting Dates extension now%2$s.', 'wptravelengine-elementor-widgets' ),
								'<a target="_blank" href="https://wptravelengine.com/plugins/trip-fixed-starting-dates/?utm_source=setting&amp;utm_medium=customer_site&amp;utm_campaign=setting_addon">',
								'</a>'
							),
							array(
								'a' => array(
									'href'   => array(),
									'target' => array(),
								),
							)
						);
						?>
					</p>
				</div>
			<?php
		}
	}
}
