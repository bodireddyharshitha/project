<?php
/**
 * Class Checkout
 *
 * This class is responsible for validating checkout data.
 *
 * @package WPTravelEngine\Validator
 * @since 5.8.0
 */

namespace WPTravelEngine\Validator;

use \WPTravelEngine\Core\Functions;

/**
 * Class Checkout
 *
 * This class is responsible for validating checkout data.
 *
 */
class Checkout extends Validator {

	/**
	 * Validates the input data.
	 *
	 * @param mixed $data The input data.
	 *
	 * @return $this
	 */
	public function validate( $data ): Checkout {
		$this->raw_data = $data;

		$checkout_fields = apply_filters( 'wp_travel_engine_booking_fields_display', \WTE_Default_Form_Fields::booking() );

		$booking_data = $data[ 'wp_travel_engine_booking_setting' ][ 'place_order' ][ 'booking' ] ?? [];

		$field_name_mapping = [
			'booking_first_name' => 'fname',
			'booking_last_name'  => 'lname',
			'booking_email'      => 'email',
			'booking_phone'      => 'phone',
			'booking_address'    => 'address',
			'booking_city'       => 'city',
			'booking_country'    => 'country',
		];

		foreach ( $checkout_fields as $field_key => $field ) {
			$field[ 'required_field' ] = $field[ 'validations' ][ 'required' ] ?? $field[ 'required_field' ] ?? false;

			if ( method_exists( $this, $field_key ) ) {
				$value = $booking_data[ $field_name_mapping[ $field_key ] ] ?? $data[ $field[ 'name' ] ] ?? '';
				if ( empty( $value ) && ! in_array( $field[ 'required_field' ], array( 'false', false ) ) ) {
					$this->errors[ $field_key ] = self::REQUIRED;
					continue;
				}

				$this->$field_key( $value, $field );
			} else {
				$this->default( $data, $field );
			}
		}

		return $this;

	}

	/**
	 * Sets the first name for a booking.
	 *
	 * Validates the given first name and stores it in the data array if it passes validation.
	 *
	 * @param string $value The first name to be set for the booking.
	 *
	 * @return void
	 */
	protected function booking_first_name( string $value ) {

//		if ( ! $this->validate_name( $value ) ) {
//			$this->errors[ 'booking_first_name' ] = static::ILLEGAL_CHARACTERS;
//
//			return;
//		}

		$this->data[ 'booking' ][ 'fname' ] = sanitize_text_field( $value );
	}

	/**
	 * Sets the last name for a booking.
	 *
	 * Validates the given last name and stores it in the data array if it passes validation.
	 *
	 * @param string $value The last name to be set for the booking.
	 *
	 * @return void
	 */
	protected function booking_last_name( string $value ) {
		$this->data[ 'booking' ][ 'lname' ] = sanitize_text_field( $value );
	}

	/**
	 * Sets the email address for a booking.
	 *
	 * Validates the given email address and stores it in the data array if it passes validation.
	 *
	 * @param string $value The email address to be set for the booking.
	 *
	 * @return void
	 */
	protected function booking_email( string $value ) {
		if ( ! $this->validate_email( $value ) ) {
			$this->errors[ 'booking_email' ] = static::INVALID_VALUE;

			return;
		}

		$this->data[ 'booking' ][ 'email' ] = sanitize_email( $value );;
	}

	/**
	 * Sets the value of the phone number for the booking.
	 *
	 * @param mixed $value The phone number value to be set for the booking.
	 *
	 * @return void
	 */
	protected function booking_phone( $value ) {
		$this->data[ 'booking' ][ 'phone' ] = $this->sanitize_phone( $value );
	}

	/**
	 * Sets the address for the booking.
	 *
	 * @param string $value The address value to be sanitized and stored.
	 *
	 * @return void
	 */
	protected function booking_address( string $value ) {
		$this->data[ 'booking' ][ 'address' ] = sanitize_text_field( $value );
	}

	/**
	 * Sets the city for the booking.
	 *
	 * @param string $value The city value to be checked for illegal characters and stored.
	 *
	 * @return void
	 */
	protected function booking_city( string $value ) {
//		if ( ! $this->validate_name( $value ) ) {
//			$this->errors[ 'booking_city' ] = self::ILLEGAL_CHARACTERS;
//
//			return;
//		}

		$this->data[ 'booking' ][ 'city' ] = sanitize_text_field( $value );
	}

	/**
	 * Sets the country for the booking.
	 *
	 * @param string $value The country value to be sanitized and stored.
	 *
	 * @return void
	 */
	protected function booking_country( string $value ) {

		$value = $this->sanitize_country( $value );

		if ( empty( $value ) ) {
			$this->errors[ 'booking_country' ] = static::INVALID_VALUE;

			return;
		}

		$this->data[ 'booking' ][ 'country' ] = $value;
	}

	/**
	 * Sets the default value for a field in the booking data.
	 *
	 * If the field value is empty and the field is marked as required,
	 * an error is added to the errors array. Otherwise, the field value
	 * is sanitized and stored in the booking data.
	 *
	 * @param array $data The input data array.
	 * @param array $settings The field settings array.
	 *
	 * @return void
	 */
	protected function default( array $data, array $settings ) {
		$name = $settings[ 'name' ];

		if ( empty( $data[ $name ] ) && $settings[ 'required_field' ] !== 'false' ) {
			$this->errors[ $name ] = self::REQUIRED;

			return;
		}

		$this->data[ 'booking' ][ $settings[ 'name' ] ] = sanitize_text_field( $data[ $settings[ 'name' ] ] ?? '' );
	}

}
