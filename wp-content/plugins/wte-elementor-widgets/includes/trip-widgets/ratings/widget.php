<?php
/**
 * Ratings Widget.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

namespace WPTRAVELENGINEEB\Trip;

use WPTRAVELENGINEEB\Widget;
use WPTRAVELENGINEEB;
/**
 * Class Enquiry
 *
 * @since 1.3.0
 */
class RatingsWidget extends Widget {
	/**
	 * Widget name.
	 *
	 * @since 1.3.0
	 *
	 * @var string
	 */
	protected $widget_name = 'wte-trip-ratings';

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
	protected $keywords = array( 'wte', 'trip', 'ratings', 'wp travel engine' );

	/**
	 * Get Title.
	 *
	 * @since 1.3.0
	 */
	public function get_title() {
		return __( 'Trip - Ratings', 'wptravelengine-elementor-widgets' );
	}

	/**
	 * Set Widget Icon.
	 *
	 * @since 1.3.0
	 */
	public function get_icon() {
		return 'eicon-star-o';
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
		$controls = include WPTRAVELENGINEEB_PATH . 'includes/trip-widgets/ratings/controls.php';
		$this->_wte_add_controls( $controls );
	}

	/**
	 * Renders Widget.
	 *
	 * @since 1.3.0
	 */
	protected function render() {
		if ( defined( 'WTE_TRIP_REVIEW_VERSION' ) ) {
			$attributes = $this->get_settings_for_display();
			if ( file_exists( WPTRAVELENGINEEB_PATH . 'includes/trip-widgets/ratings/ratings.php' ) ) {
				$comments = get_comments(
					array(
						'post_id'     => get_the_ID(),
						'status'      => 'approve',
						'post_status' => 'publish',
					)
				);

				if ( $comments ) {
					include_once WPTRAVELENGINEEB_PATH . 'includes/trip-widgets/ratings/ratings.php';
				} else {
					include_once WPTRAVELENGINEEB_PATH . 'includes/trip-widgets/ratings/demo.php';
				}
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
								__( 'Trip - Ratings Widget requires WP Travel Engine - Trip Reviews to work. %1$sGet Trip Reviews extension now%2$s.', 'wptravelengine-elementor-widgets' ),
								'<a target="_blank" href="https://wptravelengine.com/plugins/trip-reviews/?utm_source=setting&amp;utm_medium=customer_site&amp;utm_campaign=setting_addon">',
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
