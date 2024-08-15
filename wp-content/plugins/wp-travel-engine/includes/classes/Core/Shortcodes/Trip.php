<?php
/**
 * Shortcode Trip.
 *
 * @package WPTravelEngine
 * @subpackage WPTravelEngine\Core\Shortcodes
 * @since 6.0.0
 */

namespace WPTravelEngine\Core\Shortcodes;

/**
 * Class Trip.
 *
 * Responsible for creating shortcodes for trip and maintain it.
 *
 * @since 6.0.0
 */
class Trip {

	/**
	 * Shortcode tag.
	 *
	 * @var string
	 */
	const TAG = 'wte_trip';

	/**
	 * Render the shortcode.
	 *
	 * @param array $attr Shortcode attributes.
	 */
	public function render( $attr ) {
		$attr = shortcode_atts(
			array(
				'ids'         => '',
				'layout'      => 'grid',
				'postsnumber' => get_option( 'posts_per_page' ),
			),
			$attr,
			'wte_trip'
		);

		if ( ! empty( $attr['ids'] ) ) {
			$ids         = array();
			$ids         = explode( ',', $attr['ids'] );
			$attr['ids'] = $ids;
		}

		ob_start();

		do_action_deprecated( 'wte_trip_content_action', $attr, '6.0.0', 'wptravelengine_trip_content_action' );
		do_action( 'wptravelengine_trip_content_action', $attr );

		$output = ob_get_contents();
		ob_end_clean();

		if ( '' !== $output ) {
			return $output;
		}
	}
}
