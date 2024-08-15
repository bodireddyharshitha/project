<?php
/**
 * Load More Destination Controller.
 *
 * @package WPTravelEngine/Core/Controllers
 * @since 6.0.0
 */

namespace WPTravelEngine\Core\Controllers\Ajax;

use WPTravelEngine\Abstracts\AjaxController;

/**
 * Handles load more destination ajax requests.
 */
class LoadMoreDestination extends AjaxController {

	const NONCE_KEY    = 'nonce';
	const NONCE_ACTION = 'wpte_ajax_load_more_destination';
	const ACTION       = 'wpte_ajax_load_more_destination';

	/**
	 * Process Request.
	 * AJAX Load More Destination
	 */
	public function process_request() {
		$post = $this->request->get_params();
		// prepare our arguments for the query
		// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated
		$args = json_decode( wte_clean( wp_unslash( $post( 'query' ) ) ), true );
		// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated
		$args['paged']       = wte_clean( wp_unslash( $post( 'page' ) ) ) + 1; // we need next page to be loaded
		$args['post_status'] = 'publish';

		$query = new \WP_Query( $args );
		ob_start();

		// $view_mode = $post( 'mode' );

		while ( $query->have_posts() ) :
			$query->the_post();
			$details = wte_get_trip_details( get_the_ID() );
			wte_get_template( 'content-grid.php', $details );
		endwhile;
		wp_reset_postdata();

		$output = ob_get_contents();
		ob_end_clean();
		echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		wp_reset_query();
		exit();
	}
}
