<?php

namespace WPTravelEngine\Core;

class Tax {

	protected array $settings = array();

	public function __construct() {
		$this->settings = get_option( 'wp_travel_engine_settings', array() );
	}

	/**
	 * Get Tax label
	 *
	 * @param null $tax_percentage
	 *
	 * @return string
	 */
	public function get_tax_label( $tax_percentage = null ): string {
		$label_format = $this->settings[ 'tax_label' ] ?? __( 'Tax (%s%%)', 'wp-travel-engine' );

		if ( is_null( $tax_percentage ) ) {
			$tax_percentage = $this->settings[ 'tax_percentage' ] ?? 0;
		}

		return apply_filters( __FUNCTION__, sprintf( $label_format, $tax_percentage ), $tax_percentage );
	}

	/**
	 * Get Tax percentage
	 *
	 * @return float
	 */
	public function get_tax_percentage(): float {
		return (float) $this->settings[ 'tax_percentage' ] ?? 0;
	}

	/**
	 * Get Tax amount
	 *
	 * @param float $price
	 *
	 * @return float
	 */
	public function get_tax_amount( float $price ): float {
		$tax_percentage = $this->get_tax_percentage();

		return ( $price * $tax_percentage ) / 100;
	}

	public function is_inclusive(): bool {
		return ( $this->settings[ 'tax_type_option' ] ?? false ) === 'inclusive';
	}

	public function is_exclusive(): bool {
		return ( $this->settings[ 'tax_type_option' ] ?? false ) === 'exclusive';
	}

	public function is_taxable(): bool {
		return ( $this->settings[ 'tax_enable' ] ?? 'no' ) === 'yes';
	}

}
