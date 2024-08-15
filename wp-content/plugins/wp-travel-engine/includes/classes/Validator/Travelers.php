<?php
/**
 * Class Travellers
 *
 * This class is responsible for validating travellers data.
 *
 * @package WPTravelEngine\Validator
 * @since 5.8.0
 */

namespace WPTravelEngine\Validator;

/**
 * Class Travellers
 *
 * This class is responsible for validating travellers data.
 */
class Travelers extends Validator {
	/**
	 * Validates the input data.
	 *
	 * @param mixed $data The input data.
	 *
	 * @return void
	 */
	public function validate( $data ) {
		$this->raw_data = $data;

		$traveler_fields = apply_filters( 'wp_travel_engine_traveller_info_fields_display', \WTE_Default_Form_Fields::traveller_information() );

		$traveler_data = $data[ 'wp_travel_engine_placeorder_setting' ][ 'place_order' ][ 'travelers' ] ?? array();

		$field_name_mapping = array(
			'traveler_title'           => 'title',
			'traveler_first_name'      => 'fname',
			'traveler_last_name'       => 'lname',
			'traveler_passport_number' => 'passport',
			'traveler_email'           => 'email',
			'traveler_address'         => 'address',
			'traveler_city'            => 'country',
			'traveler_postcode'        => 'postcode',
			'traveler_phone'           => 'phone',
			'traveler_dob'             => 'dob',
		);

		foreach ( $traveler_fields as $field_key => $field ) {
			$field[ 'required_field' ] = $field[ 'required_field' ] ?? $field[ 'validations' ][ 'required' ] ?? false;

			if ( method_exists( $this, $field_key ) ) {
				$value = $traveler_data[ $field_name_mapping[ $field_key ] ] ?? '';
				if ( empty( $value ) && $field[ 'required_field' ] ) {
					$this->errors[ $field_key ] = self::REQUIRED;
					continue;
				}

				$this->$field_key( $value, $field );
			} else {
				$this->default( $data, $field );
			}
		}
	}

	/**
	 * Sets the title for a traveler.
	 *
	 * Validates the given title and stores it in the data array if it passes validation.
	 *
	 * @param string $value The title to be set for the traveler.
	 *
	 * @return void
	 */
	protected function traveler_title( string $value ) {
		$this->data[ 'travelers' ][ 'title' ] = sanitize_text_field( $value );
	}

	/**
	 * Sets the first name for a traveler.
	 *
	 * Validates the given first name and stores it in the data array if it passes validation.
	 *
	 * @param string $value The first name to be set for the traveler.
	 *
	 * @return void
	 */
	protected function traveler_first_name( string $value ) {

		if ( ! $this->validate_name( $value ) ) {
			$this->errors[ 'traveler_first_name' ] = static::ILLEGAL_CHARACTERS;

			return;
		}

		$this->data[ 'travelers' ][ 'fname' ] = sanitize_text_field( $value );
	}

	/**
	 * Sets the last name for a traveler.
	 *
	 * Validates the given last name and stores it in the data array if it passes validation.
	 *
	 * @param string $value The last name to be set for the traveler.
	 *
	 * @return void
	 */
	protected function traveler_last_name( string $value ) {

		if ( ! $this->validate_name( $value ) ) {
			$this->errors[ 'traveler_last_name' ] = self::ILLEGAL_CHARACTERS;

			return;
		}

		$this->data[ 'travelers' ][ 'lname' ] = sanitize_text_field( $value );
	}

	/**
	 * Sets the value of the phone number for the traveler.
	 *
	 * @param mixed $value The phone number value to be set for the traveler.
	 *
	 * @return void
	 */
	protected function traveler_passport_number( $value ) {
		$this->data[ 'travelers' ][ 'passport' ] = sanitize_text_field( $value );
	}

	/**
	 * Sets the email address for a traveler.
	 *
	 * Validates the given email address and stores it in the data array if it passes validation.
	 *
	 * @param string $value The email address to be set for the traveler.
	 *
	 * @return void
	 */
	protected function traveler_email( string $value ) {
		if ( ! $this->validate_email( $value ) ) {
			$this->errors[ 'traveler_email' ] = static::INVALID_VALUE;

			return;
		}

		$this->data[ 'travelers' ][ 'email' ] = sanitize_email( $value );

	}

	/**
	 * Sets the address for the traveler.
	 *
	 * @param string $value The address value to be sanitized and stored.
	 *
	 * @return void
	 */
	protected function traveler_address( string $value ) {
		$this->data[ 'travelers' ][ 'address' ] = sanitize_text_field( $value );
	}

	/**
	 * Sets the city for the traveler.
	 *
	 * @param string $value The city value to be checked for illegal characters and stored.
	 *
	 * @return void
	 */
	protected function traveler_city( string $value ) {
		if ( ! $this->validate_name( $value ) ) {
			$this->errors[ 'traveler_city' ] = self::ILLEGAL_CHARACTERS;

			return;
		}
		$this->data[ 'travelers' ][ 'city' ] = sanitize_text_field( $value );
	}

	/**
	 * Sets the postcode for the traveler.
	 *
	 * @param string $value The postcode value to be checked.
	 *
	 * @return void
	 */
	protected function traveler_postcode( string $value ) {
		$this->data[ 'travelers' ][ 'postcode' ] = sanitize_text_field( $value );
	}

	/**
	 * Sets the value of the phone number for the traveler.
	 *
	 * @param mixed $value The phone number value to be set for the traveler.
	 *
	 * @return void
	 */
	protected function traveler_phone( $value ) {
		$this->data[ 'travelers' ][ 'phone' ] = $this->sanitize_phone( $value );
	}

	/**
	 * Sets the value of the date of birth for the traveler.
	 *
	 * @param mixed $value The date of birth to be set for the traveler.
	 *
	 * @return void
	 */
	protected function traveler_dob( $value ) {
		$this->data[ 'travelers' ][ 'dob' ] = sanitize_text_field( $value );
	}

	/**
	 * Sets the default value for a field in the travelers data.
	 *
	 * If the field value is empty and the field is marked as required,
	 * an error is added to the errors array. Otherwise, the field value
	 * is sanitized and stored in the traveler data.
	 *
	 * @param array $data The input data array.
	 * @param array $settings The field settings array.
	 *
	 * @return void
	 */
	protected function default( array $data, array $settings ) {
		$name = $settings[ 'name' ];

		if ( empty( $data[ $name ] ) && ( $settings[ 'required_field' ] !== 'false' ) ) {
			$this->errors[ $name ] = self::REQUIRED;

			return;
		}
		$this->data[ 'travelers' ][ $settings[ 'name' ] ] = sanitize_text_field( $data[ $settings[ 'name' ] ] ?? '' );
	}

}

