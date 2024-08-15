<?php
/**
 * Booking Email.
 *
 * @since 6.0.0
 */

namespace WPTravelEngine\Email;

use WPTravelEngine\Core\Models\Post\Booking;
use WPTravelEngine\Core\Models\Post\Payment;

/**
 * Booking Email.
 *
 * @since 6.0.0
 */
class BookingEmail extends Email {

	/**
	 * Payment object.
	 *
	 * @var Payment|null Payment object.
	 */
	protected ?Payment $payment = null;

	/**
	 * Booking object.
	 *
	 * @var Booking|null Booking object.
	 */
	protected ?Booking $booking = null;

	/**
	 * @param mixed $payment Payment ID.
	 *
	 * @return $this
	 */
	public function prepare( $payment, $template = null ): BookingEmail {

		$this->payment = new Payment( $payment );
		if ( $booking = $this->payment->get_booking() ) {
			$this->booking = $booking;
		}

		$this->template = $template;

		return $this;
	}

	/**
	 * @param string|string[] $to Email address or 'admin|customer'
	 *
	 * @return $this
	 */
	public function to( string $to ): BookingEmail {

		if ( is_string( $to ) ) {
			$to = [ $to ];
		}

		foreach ( $to as $value ) {
			if ( is_email( $value ) ) {
				$this->to[] = $value;
				continue;
			}

			$settings = wptravelengine_settings();
			switch ( $value ) {
				case 'admin':
					$this->to[] = $settings->get( 'email.emails' );
					break;
				case 'customer':
					$this->to[] = $this->booking->get_billing_info( 'email' );
					break;
			}

		}

		return $this;

	}

	public function get_template() {
		$mapping = [
			'booking_notification_admin'    => 'booking_notification_admin',
			'booking_notification_customer' => 'booking_notification_customer',
		];

		return $this->template;
	}

	/**
	 * Email content.
	 *
	 * @return string
	 */
	public function get_body(): string {

		if ( ! $this->template ) {
			return $this->body;
		}

		$template = wptravelengine_get_email_template( 'booking_notification_admin' );

		return $template;

	}

	/**
	 * @return string
	 */
	public function get_subject(): string {
		return 'Booking Confirmation';
	}

}
