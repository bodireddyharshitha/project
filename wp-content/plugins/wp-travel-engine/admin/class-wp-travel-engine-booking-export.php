<?php
/**
 * WP Travel Engine - Export Booking Data
 *
 * @package WP_Travel_Engine
 */

/**
 * WP Travel Engine Booking Export
 *
 * @since 5.7.4
 */
class WP_Travel_Engine_Booking_Export {

	/**
	 * Initialize export procedure.
	 *
	 * @return void
	 */
	public function init() {
		if ( isset( $_POST[ 'booking_export_submit' ] ) && wp_verify_nonce( $_POST[ 'booking_export_nonce' ], 'booking_export_nonce_action' ) ) {

			$date_range = isset( $_POST[ 'wte_booking_range' ] ) ? sanitize_text_field( $_POST[ 'wte_booking_range' ] ) : '';
			$dates      = explode( ' to ', $date_range );

			// Store the dates in separate variables.
			$start_date = isset( $dates[ 0 ] ) ? $dates[ 0 ] : '';
			$end_date   = isset( $dates[ 1 ] ) ? $dates[ 1 ] : '';

			$queries_data = self::export_query( $start_date, $end_date );

			self::data_export( $queries_data );
			exit;
		}
	}

	/**
	 * Query to retrieve data based on start date and end date.
	 *
	 * @param string $start_date Start Date.
	 * @param string $end_date End Date.
	 *
	 * @since 5.7.4
	 */
	public function export_query( $start_date, $end_date ) {
		global $wpdb;
		$meta_keys = [
			'wp_travel_engine_booking_status',
			'wp_travel_engine_booking_setting',
			'billing_info',
			'paid_amount',
			'wp_travel_engine_booking_payment_gateway',
			'_wte_wc_order_id',
			'due_amount',
		];

		$post_status = [ 'publish', 'draft' ];

		$sql = "
		    SELECT
		        p.ID AS BookingID,
		        (
		         SELECT pm1.meta_value
		         FROM $wpdb->postmeta pm1
		         WHERE pm1.post_id = p.ID AND pm1.meta_key = %s
		         LIMIT 1
		        ) AS BookingStatus,

		        (
		         SELECT pm2.meta_value
		         FROM $wpdb->postmeta pm2
		         WHERE pm2.post_id = p.ID AND pm2.meta_key = %s
		         LIMIT 1
		        ) AS placeorder,

		        (
		         SELECT pm3.meta_value
		         FROM $wpdb->postmeta pm3
		         WHERE pm3.post_id = p.ID AND pm3.meta_key = %s
		         LIMIT 1
		        ) AS billinginfo,

		        SUM(pm.meta_value) AS TotalCost,
		        SUM(
		            CASE
		             WHEN pm.meta_key = %s THEN pm.meta_value
		             ELSE 0
		            END
		        ) AS TotalPaid,

		        (
		         SELECT pm4.meta_value
		         FROM $wpdb->postmeta pm4
		         WHERE pm4.post_id = p.ID AND pm4.meta_key = %s
		         LIMIT 1
		        ) AS PaymentGateway,

		        (
		         SELECT pm5.meta_value
		         FROM $wpdb->postmeta pm5
		         WHERE pm5.post_id = p.ID AND pm5.meta_key = %s
		         LIMIT 1
		        ) AS wc_id,

		        p.post_date AS BookingDate

		    FROM
		        $wpdb->postmeta pm
		    INNER JOIN
		        $wpdb->posts p ON pm.post_id = p.ID

		    WHERE
		        pm.meta_key IN ('" . implode( "', '", $meta_keys ) . "')
		    AND
		        p.post_type = %s
		    AND
		        p.post_status IN ('" . implode( "', '", $post_status ) . "')
		";

		array_pop( $meta_keys );
		$meta_keys[] = 'booking';

		if ( ! empty( $start_date ) ) {
			$sql         .= ' AND p.post_date >= %s';
			$meta_keys[] = $start_date;
		}

		if ( ! empty( $end_date ) ) {
			$sql         .= ' AND p.post_date <= %s';
			$meta_keys[] = $end_date;
		}

		$sql .= ' GROUP BY BookingID, BookingDate, BookingStatus ORDER BY BookingID DESC';

		return $wpdb->get_results( $wpdb->prepare( $sql, $meta_keys ) );

	}

	/**
	 * Importing data to csv format..
	 *
	 * @param array $queries_data Queries Data.
	 *
	 * @since 5.7.4
	 */
	public function data_export( $queries_data ) {
		// Set HTTP headers for CSV file download
		header( 'Content-Type: text/csv' );
		header( 'Content-Disposition: attachment; filename="wptravelengine-booking-export.csv"' );
		header( 'Pragma: no-cache' );
		header( 'Expires: 0' );

		$file = fopen( 'php://output', 'w' );

		// Define CSV header row
		$header = array(
			__( 'Booking ID', 'wp-travel-engine' ),
			__( 'Booking Status', 'wp-travel-engine' ),
			__( 'Trip Name', 'wp-travel-engine' ),
			__( 'Total Cost', 'wp-travel-engine' ),
			__( 'Total Paid', 'wp-travel-engine' ),
			__( 'Payment Gateway', 'wp-travel-engine' ),
			__( 'No. of Travellers', 'wp-travel-engine' ),
			__( 'Booking Date', 'wp-travel-engine' ),
			__( 'First Name', 'wp-travel-engine' ),
			__( 'Last Name', 'wp-travel-engine' ),
			__( 'Email', 'wp-travel-engine' ),
			__( 'Address', 'wp-travel-engine' ),
			__( 'Trip Date', 'wp-travel-engine' ),
		);

		// Write the header row to the CSV file
		fputcsv( $file, $header );

		// Iterate over each data row and write to the CSV file
		foreach ( $queries_data as $data ) {

			$tripname         = '';
			$traveler         = '';
			$tripstartingdate = '';
			$paymentgateway   = '';
			$firstname        = '';
			$lastname         = '';
			$email            = '';
			$address          = '';
			if ( isset( $data->placeorder ) ) {
				// Unserialize the place order data.
				$unserializedOrderData = unserialize( $data->placeorder );

				// Accessing the values.
				$tripname         = isset( $unserializedOrderData[ 'place_order' ][ 'tname' ] ) ? $unserializedOrderData[ 'place_order' ][ 'tname' ] : '';
				$traveler         = isset( $unserializedOrderData[ 'place_order' ][ 'traveler' ] ) ? $unserializedOrderData[ 'place_order' ][ 'traveler' ] : '';
				$tripstartingdate = isset( $unserializedOrderData[ 'place_order' ][ 'datetime' ] ) ? $unserializedOrderData[ 'place_order' ][ 'datetime' ] : '';
			}
			if ( isset( $data->billinginfo ) ) {
				// Unserialize the billing data.
				$unserializedBillingData = unserialize( $data->billinginfo );

				// Accessing the values.
				$firstname = isset( $unserializedBillingData[ 'fname' ] ) ? $unserializedBillingData[ 'fname' ] : '';
				$lastname  = isset( $unserializedBillingData[ 'lname' ] ) ? $unserializedBillingData[ 'lname' ] : '';
				$email     = isset( $unserializedBillingData[ 'email' ] ) ? $unserializedBillingData[ 'email' ] : '';
				$address   = isset( $unserializedBillingData[ 'address' ] ) ? $unserializedBillingData[ 'address' ] : '';
			}
			if ( isset( $data->PaymentGateway ) ) {
				$paymentgateway = isset( $data->PaymentGateway ) && $data->PaymentGateway != 'N/A' ? $data->PaymentGateway : '';
			}
			if ( isset( $data->wc_id ) && $data->wc_id != '(NULL)' ) {
				$paymentgateway = 'woocommerce';
			}
			$booking_date = ( new DateTime( $data->BookingDate ) );
			fputcsv(
				$file,
				array(
					$data->BookingID,
					$data->BookingStatus,
					$tripname,
					$data->TotalCost,
					$data->TotalPaid,
					$paymentgateway,
					$traveler,
					$booking_date->format( 'Y-m-d' ),
					$firstname,
					$lastname,
					$email,
					$address,
					$tripstartingdate,
				)
			);
		}

		fclose( $file );
		exit;
	}
}
