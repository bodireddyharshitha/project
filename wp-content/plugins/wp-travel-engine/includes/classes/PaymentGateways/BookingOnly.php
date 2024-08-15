<?php
/**
 * Booking Only Payment Gateway
 *
 * @package WPTravelEngine\PaymentGateways
 * @since 6.0.0
 */

namespace WPTravelEngine\PaymentGateways;

use WPTravelEngine\Core\Models\Post\Booking;
use WPTravelEngine\Core\Models\Post\Payment;

/**
 * Booking Only Payment Gateway
 *
 * @since 6.0.0
 */
class BookingOnly extends BaseGateway {

	/**
	 * Get gateway id.
	 *
	 * @return string
	 */
	public function get_gateway_id(): string {
		return 'booking_only';
	}

	/**
	 * Get label
	 *
	 * @return string
	 */
	public function get_label(): string {
		return __( 'Book Now Pay Later', 'wp-travel-engine' );
	}

	/**
	 * Get public label.
	 *
	 * @return string
	 */
	public function get_public_label(): string {
		return __( 'Book Now Pay Later', 'wp-travel-engine' );
	}

	/**
	 * Get Description.
	 */
	public function get_description(): string {
		return __( 'If checked, no payment gateways will be used in checkout. The booking process will be completed and booking will be saved without payment.', 'wp-travel-engine' );
	}

	/**
	 * @inheritDoc
	 */
	public function process_payment( Booking $booking, Payment $payment, $booking_instance ): void {
	}
}
