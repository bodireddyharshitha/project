<?php
/**
 * ShortCode dashboard.
 *
 * @package    WPTravelEngine
 * @subpackage WPTravelEngine\Core\Shortcodes
 */

namespace WPTravelEngine\Core\Shortcodes;

use WPTravelEngine\Abstracts\Shortcode;
use WPTravelEngine\Core\Controllers\Shortcodes\UserAccountController;
use WPTravelEngine\Plugin;

/**
 * Class UserAccount.
 *
 * Responsible for creating shortcodes for user account displaying and maintaining it.
 *
 * @since 6.0.0
 */
class UserAccount extends Shortcode {
	/**
	 * Shortcode tag.
	 *
	 * @var string
	 */
	const TAG = 'wp_travel_engine_dashboard';

	/**
	 * Retrieves the UserAccount shortcode output.
	 *
	 * This function generates the HTML output for the user account shortcode based on the provided attributes.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string The generated HTML output.
	 */
	public function output( $atts ): string {

		Plugin::assets()
		->enqueue_style( 'my-account' )
		->enqueue_script( 'my-account' );

		$useraccount = new UserAccountController();
		return $useraccount->view( $this->parse_attributes( $atts ) );
	}
}
