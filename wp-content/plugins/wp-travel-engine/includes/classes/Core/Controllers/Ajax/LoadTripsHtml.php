<?php
/**
 * Load Trip Html Controller.
 *
 * @package @WPTravelEngine/Core/Controllers
 * @since 6.0.0
 */

namespace WPTravelEngine\Core\Controllers\Ajax;

use WPTravelEngine\Abstracts\AjaxController;

/**
 * Loads the trips html.
 */
class LoadTripsHtml extends AjaxController {

	const NONCE_KEY    = 'nonce';
	const NONCE_ACTION = 'wte_show_ajax_result_load';
	const ACTION       = 'wte_show_ajax_result_load';

	/**
	 * Process Request.
	 * Load Trips Html.
	 */
	protected function process_request() {
		$post = $this->request->get_params();
		// phpcs:disable
		$args                = json_decode( wp_unslash( $post['query'] ), true );
		$args['paged']       = wte_clean( wp_unslash( $post['page'] ) ) + 1; // we need next page to be loaded
		$args['post_status'] = 'publish';

		$query = new \WP_Query( $args );
		ob_start();

		$view_mode  = wte_clean( wp_unslash( $post['mode'] ) );

		$user_wishlists = wptravelengine_user_wishlists();

		// phpcs:enable
		while ( $query->have_posts() ) :
			$query->the_post();
			$details                   = \wte_get_trip_details( get_the_ID() );
			$details['user_wishlists'] = $user_wishlists;
			\wte_get_template( 'content-' . $view_mode . '.php', $details );
		endwhile;
		\wp_reset_postdata();

		$html = ob_get_clean();
		wp_send_json_success(
			array(
				'data' => $html,
			)
		);
		exit();
	}
}
