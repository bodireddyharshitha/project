<?php
/**
 * Thank you Shortcode.
 *
 * @package WPTravelEngine
 * @since 6.0.0
 */

namespace WPTravelEngine\Core\Shortcodes;

use WPTravelEngine\Abstracts\Shortcode;

/**
 * Thank you Shortcode class.
 *
 * @since 6.0.0
 */
class ThankYou extends Shortcode {

	/**
	 * The shortcode tag.
	 *
	 * @var string $tag
	 */
	const TAG = 'WP_TRAVEL_ENGINE_THANK_YOU';

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_filter( 'body_class', array( $this, 'body_class' ) );
	}

	/**
	 * Add thank you body class.
	 */
	public function body_class( $classes ) {
		global $post;
		if ( is_object( $post ) ) {
			if ( has_shortcode( $post->post_content, 'WP_TRAVEL_ENGINE_THANK_YOU' ) ) {
				$classes[] = 'thank-you';
			}
		}

		return $classes;
	}

	public static function get_booking_details_html( $payment_id, $booking_id = null ) {
		if ( is_null( $booking_id ) ) {
			$booking_id = get_post_meta( $payment_id, 'booking_id', true );
		}
		do_action( 'wte_booking_cleanup', $payment_id, 'thankyou' );

		ob_start();
		wte_get_template(
			'thank-you/thank-you.php',
			array(
				'payment_id' => $payment_id,
				'booking_id' => $booking_id,
			)
		);

		return ob_get_clean();
	}

	/**
	 * Place order form shortcode callback function.
	 *
	 * @return string
	 */
	public function output(): string {
		if ( is_admin() ) {
			return '';
		}

		$booking_id = null;
		$payment_id = null;
		if ( isset( $_GET[ 'payment_key' ] ) ) {
			$payment_key = sanitize_text_field( wp_unslash( $_GET[ 'payment_key' ] ) );
			$payment_id  = get_transient( 'payment_key_' . $payment_key );
			$booking_id  = get_post_meta( $payment_id, 'booking_id', true );
		} else {
			$data = \WTE_Booking::get_callback_token_payload( 'thankyou' );
			if ( is_array( $data ) && isset( $data[ 'bid' ] ) ) {
				$booking_id = $data[ 'bid' ];
				$payment_id = $data[ 'pid' ];
			}
		}

		if ( ! $booking_id || ! $payment_id ) {
			return __( 'Thank you for booking the trip. Please check your email for confirmation.', 'wp-travel-engine' );
		}

		return self::get_booking_details_html( $payment_id, $booking_id );
	}
}
