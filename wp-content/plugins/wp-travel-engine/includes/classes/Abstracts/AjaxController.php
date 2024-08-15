<?php
/**
 * Abstract Ajax Controller.
 *
 * @package WPTravelEngine/Core/Controllers
 * @since 6.0.0
 */

namespace WPTravelEngine\Abstracts;

/**
 * Handles add to cart ajax request.
 */
abstract class AjaxController {

	/**
	 * Nonce key.
	 *
	 * @var string
	 */
	const NONCE_KEY = '';

	/**
	 * Nonce action.
	 *
	 * @var string
	 */
	const NONCE_ACTION = '';

	/**
	 * Post REST Request.
	 *
	 * @var \WP_REST_Request $request
	 */
	protected \WP_REST_Request $request;

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'wp_ajax_' . static::ACTION, array( static::class, 'handle' ) );
		add_action( 'wp_ajax_nopriv_' . static::ACTION, array( static::class, 'handle' ) );
	}

	/**
	 * Handle request.
	 *
	 * @return void
	 */
	public static function handle() {

		$instance = new static();

		if ( $instance->authorize_request() ) {
			$instance->process_request();
		}
	}

	/**
	 * Process request.
	 */
	abstract protected function process_request();

	/**
	 * Authorize request.
	 *
	 * @return bool|void
	 */
	protected function authorize_request() {
		if ( check_ajax_referer( static::NONCE_ACTION, static::NONCE_KEY, false ) === false ) {
//			wp_send_json_error( new \WP_Error( 'invalid_request', __( 'Invalid request.', 'wp-travel-engine' ) ) );
		}

		$request = new \WP_REST_Request( 'POST' );

		$request->set_body( file_get_contents( 'php://input' ) );
		$request->set_query_params( $_GET );
		$request->set_header( 'Content-Type', 'application/json' );
		$request->set_body_params( array_merge( $_POST, array( '__files' => $_FILES ) ) );

		$this->request = $request;

		return true;
	}
}
