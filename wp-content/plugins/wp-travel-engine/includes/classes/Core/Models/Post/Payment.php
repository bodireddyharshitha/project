<?php
/**
 * Payment Model.
 *
 * @package WPTravelEngine/Core/Models
 * @since 6.0.0
 */

namespace WPTravelEngine\Core\Models\Post;

use WPTravelEngine\Abstracts\PostModel;

/**
 * Class Payment.
 * This class represents a payment to the WP Travel Engine plugin.
 *
 * @since 6.0.0
 */
class Payment extends PostModel {
	/**
	 * Post type name.
	 *
	 * @var string
	 */
	protected string $post_type = 'wte-payments';

	/**
	 * Get Payment Amount.
	 *
	 * @return float
	 */
	public function get_amount(): float {
		return (float) ( $this->get_meta( 'payment_amount' )['value'] ?? 0 );
	}

	/**
	 * Get Payment Currency.
	 *
	 * @return string
	 */
	public function get_currency(): string {
		return $this->get_meta( 'payment_amount' )['currency'] ?? '';
	}

	/**
	 * Get Payment Status.
	 *
	 * @return string
	 */
	public function get_payment_status(): string {
		return $this->get_meta( 'payment_status' ) ?? 'pending';
	}

	/**
	 * Get Payment Gateway Response.
	 *
	 * @return string|array
	 */
	public function get_gateway_response() {
		return $this->get_meta( 'gateway_response' );
	}

	/**
	 * Get Payment Gateway.
	 *
	 * @return string
	 */
	public function get_payment_gateway(): string {
		return $this->get_meta( 'payment_gateway' ) ?? '';
	}

	/**
	 * Get Billing Information.
	 *
	 * @return array
	 */
	public function get_billing_info(): array {
		return $this->get_meta( 'billing_info' ) ?? array();
	}

	/**
	 * Get Payable Amount.
	 *
	 * @return string
	 */
	public function get_payable_amount(): float {
		return (float) ( $this->get_meta( 'payable' )['amount'] ?? 0 );
	}

	/**
	 * Get Payable Currency.
	 *
	 * @return string
	 */
	public function get_payable_currency(): string {
		return $this->get_meta( 'payable' )['currency'] ?? '';
	}

	/**
	 * @return bool
	 */
	public function is_completed(): bool {
		return in_array( $this->get_payment_status(), array( 'completed', 'success', 'captured', 'complete', 'succeed' ) );
	}

	/**
	 * Update Payment Status.
	 *
	 * @return void
	 */
	public function update_status( $status ) {
		update_post_meta( $this->get_id(), 'payment_status', $status );
	}

	/**
	 * Generates Payment Key.
	 *
	 * @return string
	 */
	public function get_payment_key(): string {
		return wptravelengine_generate_key( $this->get_id() );
	}

	/**
	 * Get Booking.
	 *
	 * @return Booking
	 */
	public function get_booking(): Booking {
		return wptravelengine_get_booking( $this->get_meta( 'booking_id' ) );
	}

	/**
	 * Set Payment Status.
	 *
	 * @param string $status Payment Status.
	 */
	public function set_status( string $status ) {
		$this->set_meta( 'payment_status', $status );
	}

	/**
	 * Set Payment Gateway.
	 *
	 * @param string $gateway Payment Gateway.
	 */
	public function set_payment_gateway( string $gateway ) {
		$this->set_meta( 'payment_gateway', $gateway );
	}
}
