<?php

namespace WPTravelEngine\Core\Controllers;

use WPTravelEngine\Core\Cart\Cart;
use WPTravelEngine\Core\Cart\Item;

class Checkout {

	protected Cart $cart;
	/**
	 * @var mixed|null
	 */
	protected $form_fields = null;

	public function __construct( Cart $cart ) {
		$this->cart = $cart;
	}

	protected function add_class_to_form_fields( $field ) {
		$field[ 'wrapper_class' ] = 'wpte-bf-field wpte-cf-' . $field[ 'type' ];

		return $field;
	}

	protected function form_fields(): Checkout {
		if ( ! is_null( $this->form_fields ) ) {
			return $this;
		}
		$checkout_fields = apply_filters( 'wp_travel_engine_booking_fields_display', \WTE_Default_Form_Fields::booking() );

		$this->form_fields = array_map( array( $this, 'add_class_to_form_fields' ), $checkout_fields );

		return $this;
	}

	public function has_form_fields(): bool {
		return ! empty( $this->form_fields()->form_fields );
	}

	public function render_form_fields() {
		wptravelengine_render_form_fields( $this->form_fields );
	}

	protected function privacy_from_fields(): array {
		$options = get_option( 'wp_travel_engine_settings', array() );

		$privacy_policy_form_field = array();
		if ( function_exists( 'get_privacy_policy_url' ) ) {
			$privacy_policy_form_field[ 'privacy_policy_info' ] = array(
				'type'              => 'checkbox',
				'options'           => array(
					'0' => sprintf(
						__( 'Check the box to confirm you\'ve read and agree to our <a href="%1$s" id="terms-and-conditions" target="_blank"> Terms and Conditions</a> and <a href="%2$s" id="privacy-policy" target="_blank">Privacy Policy</a>.', 'wp-travel-engine' ),
						esc_url( get_permalink( $options[ 'pages' ][ 'wp_travel_engine_terms_and_conditions' ] ?? '' ) ),
						esc_url( get_privacy_policy_url() )
					),
				),
				'name'              => 'wp_travel_engine_booking_setting[terms_conditions]',
				'wrapper_class'     => 'wp-travel-engine-terms',
				'id'                => 'wp_travel_engine_booking_setting[terms_conditions]',
				'default'           => '',
				'validations'       => array(
					'required' => true,
				),
				'option_attributes' => array(
					'required'                      => true,
					'data-msg'                      => __( 'Please make sure to check the privacy policy checkbox', 'wp-travel-engine' ),
					'data-parsley-required-message' => __( 'Please make sure to check the privacy policy checkbox', 'wp-travel-engine' ),
				),
				'priority'          => 70,
			);

		}

		return apply_filters( 'wte_booking_privacy_fields', $privacy_policy_form_field );
	}

	public function render_privacy_form_fields() {
		wptravelengine_render_form_fields( $this->privacy_from_fields() );
	}

	public function get_active_payments(): array {
		return wp_travel_engine_get_active_payment_gateways();
	}

	public function template_mini_cart() {
		$mini_cart = new MiniCart( $this );
		$mini_cart->render();
	}

	public function submit_button() {
		$attributes = array(
			'type'                => 'submit',
			'disabled'            => 'disabled',
			"data-checkout-label" => __( 'Pay %s', 'wp-travel-engine' ),
			'name'                => 'wp_travel_engine_nw_bkg_submit',
			'value'               => wte_default_labels( 'checkout.submitButtonText' ),
		);

		$attributes = array_map( function ( $key, $value ) {
			return sprintf( '%s="%s"', $key, $value );
		}, array_keys( $attributes ), $attributes );

		$attributes = implode( ' ', $attributes );

		do_action( 'wte_booking_before_submit_button' );
		echo apply_filters( 'wptravelengine_checkout_submit_button', "<div class=\"wpte-bf-field wpte-bf-submit\"><input {$attributes}></div>", $attributes );
		do_action( 'wte_booking_after_submit_button' );
	}

	public function full_payment_label( $full_payment, $settings ) {
		// translators: %s: Full payment Amount/Percentage.
		$label = apply_filters( 'wte_checkout_full_pay_label', __( 'Full payment(%s)', 'wp-travel-engine' ) );
		$value = ( $settings[ 'type' ] ?? '' ) === 'amount' ? wptravelengine_the_price( $full_payment ) : '100%';

		/**
		 * Filters the full payment label.
		 * @todo to remove below code once placeholder is passed from theme.
		 */
		if ( strpos( $label, '%s') !== false ) {
			// If the label contains a placeholder, replace it with the value.
			return wp_kses_post( sprintf( $label, $value ) );
		} else {
			// If the label doesn't contain a placeholder, just return it as is.
			return wp_kses_post( $label );
		}
	}

	public function down_payment_label( $settings ) {
		$is_amount = ( $settings[ 'type' ] ?? '' ) === 'amount';
		$value     = $settings[ 'value' ] ?? 0;
		$label     = $is_amount ? wptravelengine_the_price( $value, false, false ) : "{$value}%";

		// translators: %s: Down payment Amount/Percentage.
		return  sprintf( apply_filters( 'wte_checkout_down_pay_label',__( 'Down payment(%s)', 'wp-travel-engine' ), $settings ), $label);
	}

}
