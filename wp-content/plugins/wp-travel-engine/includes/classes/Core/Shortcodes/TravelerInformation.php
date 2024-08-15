<?php
/**
 * Shortcode Trip.
 *
 * @package WPTravelEngine
 * @subpackage WPTravelEngine\Core\Shortcodes
 * @since 6.0.0
 */

namespace WPTravelEngine\Core\Shortcodes;

use WPTravelEngine\Abstracts\Shortcode;

/**
 * Class Conformation.
 *
 * Responsible for creating shortcodes for trip conformaion and maintain it.
 *
 * @since 6.0.0
 */
class TravelerInformation extends Shortcode {

	/**
	 * Shortcode tag.
	 *
	 * @var string
	 */
	const TAG = 'WP_TRAVEL_ENGINE_BOOK_CONFIRMATION';

	/**
	 * @return string
	 */
	public function output(): string {
		$confirmation = new \Wp_Travel_Engine_Order_Confirmation();

		return $confirmation->wp_travel_engine_confirmation_shortcodes_callback();
	}
}
