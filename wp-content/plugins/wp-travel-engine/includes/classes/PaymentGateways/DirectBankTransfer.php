<?php
/**
 * Direct Bank Transfer Payment Gateway
 *
 * @package WPTravelEngine\PaymentGateways
 * @since 6.0.0
 */

namespace WPTravelEngine\PaymentGateways;

use WPTravelEngine\Core\Models\Post\Booking;
use WPTravelEngine\Core\Models\Post\Payment;

/**
 * Direct Bank Transfer Payment Gateway
 *
 * @since 6.0.0
 */
class DirectBankTransfer extends BaseGateway {

	/**
	 * Get gateway id.
	 *
	 * @return string
	 */
	public function get_gateway_id(): string {
		return 'direct_bank_transfer';
	}

	/**
	 * Get label
	 *
	 * @return string
	 */
	public function get_label(): string {
		return __( 'Direct Bank Transfer', 'wp-travel-engine' );
	}

	/**
	 * Get public label.
	 *
	 * @return string
	 */
	public function get_public_label(): string {
		return __( 'Direct Bank Transfer', 'wp-travel-engine' );
	}

	/**
	 * Get info.
	 *
	 * @return string
	 */
	public function get_info(): string {
		return __( 'Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.', 'wp-travel-engine' );
	}

	/**
	 * @inheritDoc
	 */
	public function process_payment( Booking $booking, Payment $payment, $booking_instance ): void {
		$payment->set_status( 'voucher-awaiting' );
		$payment->set_payment_gateway( $this->get_gateway_id() );
	}
}
