<?php
/**
 * Enquiry Model.
 *
 * @package WPTravelEngine/Core/Models
 * @since 6.0.0
 */

namespace WPTravelEngine\Core\Models\Post;

use WPTravelEngine\Abstracts\PostModel;

/**
 * Class Enquiry.
 * This class represents an enquiry to the WP Travel Engine plugin.
 *
 * @since 6.0.0
 */
class Enquiry extends PostModel {

	/**
	 * Post type name.
	 *
	 * @var string
	 */
	protected string $post_type = 'enquiry';

	/**
	 * Retrieves enquiry data.
	 *
	 * @return array Enquiry data
	 */
	public function get_enquiry_data() {
		return $this->get_meta( 'wp_travel_engine_enquiry_formdata' ) ?? array();
	}

	/**
	 * Retrieves old enquiry data.
	 *
	 * @return array Old enquiry data
	 */
	public function get_old_enquiry_data() {
		$old_enquiry_data = $this->get_meta( 'wp_travel_engine_setting' );
		return $old_enquiry_data['enquiry'] ?? array();
	}

	/**
	 * Retrieves package name - Old Enquiry Data.
	 *
	 * @return string Package name
	 */
	public function get_package_name() {
		$old_enquiry_data = $this->get_old_enquiry_data();
		return $old_enquiry_data['pname'] ?? '';
	}

	/**
	 * Retrieves customer name - Old Enquiry Data.
	 *
	 * @return string Customer name
	 */
	public function get_customer_name() {
		$old_enquiry_data = $this->get_old_enquiry_data();
		return $old_enquiry_data['name'] ?? '';
	}

	/**
	 * Retrieves customer email - Old Enquiry Data.
	 *
	 * @return string Customer email
	 */
	public function get_customer_email() {
		$old_enquiry_data = $this->get_old_enquiry_data();
		return $old_enquiry_data['email'] ?? '';
	}

	/**
	 * Retrieves customer country - Old Enquiry Data.
	 *
	 * @return string Customer country
	 */
	public function get_customer_country() {
		$old_enquiry_data = $this->get_old_enquiry_data();
		return $old_enquiry_data['country'] ?? '';
	}

	/**
	 * Retrieves customer contact - Old Enquiry Data.
	 *
	 * @return string Customer contact
	 */
	public function get_customer_contact() {
		$old_enquiry_data = $this->get_old_enquiry_data();
		return $old_enquiry_data['contact'] ?? '';
	}

	/**
	 * Retrieves number of adults - Old Enquiry Data.
	 *
	 * @return int Number of adults
	 */
	public function get_adults() {
		$old_enquiry_data = $this->get_old_enquiry_data();
		return $old_enquiry_data['adults'] ?? '';
	}

	/**
	 * Retrieves number of children - Old Enquiry Data.
	 *
	 * @return int Number of children
	 */
	public function get_children() {
		$old_enquiry_data = $this->get_old_enquiry_data();
		return $old_enquiry_data['children'] ?? '';
	}

	/**
	 * Retrieves custome message - Old Enquiry Data.
	 *
	 * @return string Customer message
	 */
	public function get_customer_message() {
		$old_enquiry_data = $this->get_old_enquiry_data();
		return $old_enquiry_data['message'] ?? '';
	}
}
