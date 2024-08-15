<?php
/**
 * User Wishlist Controller.
 *
 * @package WPTravelEngine/Core/Controllers
 * @since 6.0.0
 */

namespace WPTravelEngine\Core\Controllers\Ajax;

use WPTravelEngine\Abstracts\AjaxController;

/**
 * Handles the user wishlist ajax request.
 */
class UserWishlist extends AjaxController {

	const NONCE_KEY    = '_nonce';
	const NONCE_ACTION = 'wp_xhr';
	const ACTION       = 'wte_user_wishlist';

	/**
	 * Process Request.
	 * Update user wishlist.
	 *
	 * @since 5.5.7
	 */
	public function process_request() {
		$request        = $this->request->get_params();
		$request_method = $this->get_current_request_method();
		$user_wishlists = array_values( (array) wptravelengine_user_wishlists() );
		$message        = __( 'Wishlist fetched successfully.', 'wp-travel-engine' );

		if ( 'GET' === $request_method ) {
			wp_send_json_success( compact( 'message', 'user_wishlists' ) );
			wp_die();
		}

		if ( 'POST' === $request_method ) {
			$user_wishlists[] = (int) $request['wishlist'];
			$message          = __( 'Trip is added to wishlists.', 'wp-travel-engine' );
		} elseif ( 'DELETE' === $request_method ) {
			if ( 'all' === $request['wishlist'] ) {
				$user_wishlists = array();
			} else {
				$user_wishlists = array_diff( $user_wishlists, explode( ',', $request['wishlist'] ) );
			}
			$message = __( 'Trip is removed from wishlists.', 'wp-travel-engine' );
		}

		if ( is_user_logged_in() ) {
			$user_id = get_current_user_id();
			update_user_meta( $user_id, 'wptravelengine_wishlists', $user_wishlists );
		} else {
			WTE()->session->set( 'user_wishlists', $user_wishlists );
		}

		$message        = __( '<strong>0</strong> item in wishlist', 'wp-travel-engine' );
		$user_wishlists = wptravelengine_user_wishlists();
		wp_send_json_success(
			array(
				'message'        => $message,
				'user_wishlists' => $user_wishlists,
				'refresh'        => 'all' === $request['wishlist'],
				'partials'       => array(
					/* Translators: %d is the number of items in the wishlist. */
					'[data-wptravelengine-wishlist-count]' => ! empty( $user_wishlists ) ? sprintf( _n( '<strong>%d</strong> item in the wishlist', '<strong>%d</strong> items in the wishlist', count( $user_wishlists ), 'wp-travel-engine' ), count( $user_wishlists ) ) : '',
				),
			)
		);
		wp_die();
	}

	/**
	 * Get request method.
	 *
	 * @since 5.5.7
	 * @return string
	 */
	public static function get_current_request_method() {
		return sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ?? 'GET' ) );
	}
}
