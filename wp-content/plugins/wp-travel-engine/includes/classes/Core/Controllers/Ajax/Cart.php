<?php
/**
 * Add to cart controller.
 *
 * @package WPTravelEngine/Core/Controllers
 * @since 6.0.0
 */

namespace WPTravelEngine\Core\Controllers\Ajax;

use WP_Error;
use WPTravelEngine\Abstracts\AjaxController;
use WPTravelEngine\Core\Controllers\Checkout;

/**
 * Handles cart related requests.
 */
class Cart extends AjaxController {

	const NONCE_KEY = '_nonce';
	const NONCE_ACTION = 'wptravelengine_cart';
	const ACTION = 'wptravelengine_cart';

	/**
	 * Process Request.
	 */
	protected function process_request() {

		$cart_action = $this->request->get_param( 'cart_action' );

		switch ( $cart_action ) {
			case 'update_payment_type':
				$this->change_payment_type();
				break;
			default:
				wp_send_json_error( new WP_Error( 'INVALID_CART_ACTION', __( 'Invalid cart action.', 'wp-travel-engine' ) ) );
		}

	}

	/**
	 * Change a payment type.
	 */
	protected function change_payment_type() {
		global $wte_cart;

		$payment_type = $this->request->get_param( 'data' )[ 'payment_type' ] ?? false;
		$mappings     = [
			'full'              => 'full',
			'due'               => 'due',
			'partial'           => 'partial',
			'full_payment'      => 'full',
			'remaining_payment' => 'due',
		];
		$payment_type = $mappings[ $payment_type ] ?? false;
		if ( ! in_array( $payment_type, [ 'full', 'due', 'partial' ], true ) ) {
			wp_send_json_error( new WP_Error( 'INVALID_PAYMENT_TYPE', __( 'Invalid payment type.', 'wp-travel-engine' ) ) );
		}

		$wte_cart->payment_gateway = $this->request->get_param( 'data' )[ 'payment_gateway' ] ?? false;
		$wte_cart->set_payment_type( $payment_type );
		$wte_cart->update_cart();

		$checkout = new Checkout( $wte_cart );
		ob_start();
		$checkout->template_mini_cart();
		$mini_cart_contents = ob_get_clean();
		wp_send_json_success( [
			'message'   => __( 'Payment type updated successfully.', 'wp-travel-engine' ),
			'fragments' => [
				'.wpte-bf-book-summary' => $mini_cart_contents,
			],
		] );

	}

}
