<?php
/**
 * Customer Model.
 *
 * @package WPTravelEngine/Core/Models
 * @since 6.0.0
 */

namespace WPTravelEngine\Core\Models\Post;

use WP_Error;
use WPTravelEngine\Abstracts\PostModel;
use WPTravelEngine\Core\Models\Settings\PluginSettings;

/**
 * Class Customer.
 * This class represents a customer to the WP Travel Engine plugin.
 *
 * @since 6.0.0
 */
class Customer extends PostModel {

	/**
	 * User Role.
	 */
	const USER_ROLE = 'wp-travel-engine-customer';

	/**
	 * Post type name.
	 *
	 * @var string
	 */
	protected string $post_type = 'customer';

	/**
	 * Retrieves customer meta.
	 *
	 * @return array Customer meta
	 */
	public function get_customer_meta() {
		return $this->get_meta( 'wp_travel_engine_booking_setting' ) ?? array();
	}

	/**
	 * Retrieves customer details.
	 *
	 * @return array Customer details
	 */
	public function get_customer_details() {
		$customer_meta    = $this->get_customer_meta();
		$customer_details = $customer_meta[ 'place_order' ][ 'booking' ] ?? array();

		return $customer_details;
	}

	/**
	 * Retrieves customer first name.
	 *
	 * @return string Customer First Name
	 */
	public function get_customer_fname() {
		$customer_details = $this->get_customer_details();

		return $customer_details[ 'fname' ] ?? '';
	}

	/**
	 * Retrieves customer last name.
	 *
	 * @return string Customer Last Name
	 */
	public function get_customer_lname() {
		$customer_details = $this->get_customer_details();

		return $customer_details[ 'lname' ] ?? '';
	}

	/**
	 * Retrieves customer email.
	 *
	 * @return string Customer Email
	 */
	public function get_customer_email() {
		$customer_details = $this->get_customer_details();

		return $customer_details[ 'email' ] ?? '';
	}

	/**
	 * Retrieves customer address.
	 *
	 * @return string Customer Address
	 */
	public function get_customer_address() {
		$customer_details = $this->get_customer_details();

		return $customer_details[ 'address' ] ?? '';
	}

	/**
	 * Retrieves customer city.
	 *
	 * @return string Customer City
	 */
	public function get_customer_city() {
		$customer_details = $this->get_customer_details();

		return $customer_details[ 'city' ] ?? '';
	}

	/**
	 * Retrives customer country.
	 */
	public function get_customer_country() {
		$customer_details = $this->get_customer_details();

		return $customer_details[ 'country' ] ?? '';
	}

	/**
	 * Retrieves customer post code.
	 *
	 * @return string Customer Post Code
	 */
	public function get_customer_postcode() {
		$customer_details = $this->get_customer_details();

		return $customer_details[ 'postcode' ] ?? '';
	}

	/**
	 * Retrieves the IDs of the customer's booked trip.
	 *
	 * @return array Customer Booked Trip IDs
	 */
	public function get_customer_bookings() {
		return $this->get_meta( 'wp_travel_engine_bookings' ) ?? array();
	}

	/**
	 * Retrieves customer booked trip details.
	 *
	 * @return array Customer Booked Trip Details
	 */
	public function get_customer_booked_trip_settings() {
		return $this->get_meta( 'wp_travel_engine_booked_trip_setting' ) ?? array();
	}

	/**
	 * Customer detail fields.
	 *
	 * @return array Customer Detail Fields
	 */
	public function customer_detail_fields() {
		$customer_email          = $this->get_customer_email();
		$customer_details_fields = array(
			'fname'    => array(
				'label' => __( 'First Name', 'wp-travel-engine' ),
			),
			'lname'    => array(
				'label' => __( 'Last Name', 'wp-travel-engine' ),
			),
			'email'    => array(
				'label'      => __( 'Email', 'wp-travel-engine' ),
				'field_type' => 'email',
				'readonly'   => isset( $customer_email ) && ! empty( $customer_email ),
			),
			'address'  => array(
				'label' => __( 'Address', 'wp-travel-engine' ),
			),
			'city'     => array(
				'label' => __( 'City', 'wp-travel-engine' ),
			),
			'country'  => array(
				'label' => __( 'Country', 'wp-travel-engine' ),
			),
			'postcode' => array(
				'label' => __( 'Post Code', 'wp-travel-engine' ),
			),
		);

		return $customer_details_fields;
	}

	/**
	 * @return void
	 */
	public function maybe_register_as_user() {
		if ( wptravelengine_settings()->is( 'generate_user_account', 'yes' ) ) {
			$email_address = trim( $this->get_title() );

			if ( is_email( trim( $email_address ) ) && ! email_exists( $email_address ) ) {
				$userdata = apply_filters(
					'wp_travel_engine_new_customer_data',
					array(
						'user_login' => $email_address,
						'user_pass'  => wp_generate_password(),
						'user_email' => $email_address,
						'role'       => static::USER_ROLE,
					)
				);

				$user_id = wp_insert_user( $userdata );
				update_user_meta( $user_id, 'customer_id', $this->get_id() );
				do_action( 'wp_travel_engine_created_customer', $user_id, $userdata, true, 'emails/customer-new-account.php' );
			}
		}
	}

	/**
	 * Create a new post for this post-type.
	 *
	 * @return $this
	 */
	public static function create_post( array $postarr ): Customer {
		/* @var $model Customer */
		$model = parent::create_post( $postarr );
		return $model;
	}

	/**
	 * Update customer bookings.
	 *
	 * @param int $booking_id
	 *
	 * @return $this
	 */
	public function update_customer_bookings( int $booking_id ): Customer {
		$customer_bookings   = $this->get_meta( 'wp_travel_engine_bookings' );
		$customer_bookings   = ! is_array( $customer_bookings ) ? array() : $customer_bookings;
		$customer_bookings[] = $booking_id;

		return $this->set_meta( 'wp_travel_engine_bookings', array_unique( $customer_bookings ) );
	}

	/**
	 * Save the post-metadata.
	 *
	 * @return object
	 */
	public function save(): object {
		$meta_mappings = [
			'wp_travel_engine_bookings' => 'wp_travel_engine_user_bookings',
		];

		if ( is_user_logged_in() ) {
			$user = wp_get_current_user();
		} else {
			$user = get_user_by( 'email', $this->get_customer_email() );
		}

		if ( $user instanceof \WP_User ) {
			foreach ( $this->data[ '__changes' ] as $meta_key => $meta_value ) {
				if ( isset( $meta_mappings[ $meta_key ] ) ) {
					update_user_meta( $user->ID, $meta_mappings[ $meta_key ], $meta_value );
				}
			}
		}

		return parent::save();
	}

	/**
	 * Checks if customer exists
	 *
	 * @return int|false
	 */
	public static function is_exists( string $email ) {
		global $wpdb;

		if ( empty( $email ) ) {
			return false;
		}

		$prepared_statement = $wpdb->prepare( "SELECT `ID` FROM {$wpdb->posts} WHERE `post_title` LIKE %s", '%' . $wpdb->esc_like( sanitize_email( $email ) ) . '%' );

		return $wpdb->get_row( $prepared_statement )->ID ?? false;
	}
}
