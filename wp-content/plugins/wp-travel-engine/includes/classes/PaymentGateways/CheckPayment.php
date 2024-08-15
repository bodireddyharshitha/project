<?php
/**
 * Check Payment.
 *
 * @package WPTravelEngine\PaymentGateways
 * @since 6.0.0
 */

namespace WPTravelEngine\PaymentGateways;

use WPTravelEngine\Core\Models\Post\Booking;
use WPTravelEngine\Core\Models\Post\Payment;

/**
 * Check Payment Gateway
 *
 * @since 6.0.0
 */
class CheckPayment extends BaseGateway {
	/**
	 * Get gateway id.
	 *
	 * @return string
	 */
	public function get_gateway_id(): string {
		return 'check_payments';
	}

	/**
	 * Get label
	 *
	 * @return string
	 */
	public function get_label(): string {
		return __( 'Check Payments', 'wp-travel-engine' );
	}

	/**
	 * Get public label.
	 *
	 * @return string
	 */
	public function get_public_label(): string {
		return __( 'Check Payments', 'wp-travel-engine' );
	}

	/**
	 * Public info shows at the time of checkout.
	 *
	 * @return string
	 */
	public function get_info(): string {
		return __( 'Please send a check to Store Name, Store Street, Store Town, Store State / County, Store Postcode.', 'wp-travel-engine' );
	}

	/**
	 * @inheritDoc
	 */
	public function process_payment( Booking $booking, Payment $payment, $booking_instance ): void {
		update_post_meta( $booking->get_id(), 'wp_travel_engine_booking_payment_gateway', __( 'Check Payment', 'wp-travel-engine' ) );
		update_post_meta( $booking->get_id(), 'wp_travel_engine_booking_payment_status', 'check-waiting' );

		$payment->set_status( 'check-waiting' );
		$payment->set_payment_gateway( 'check_payments' );
		$payment->save();
	}
}
