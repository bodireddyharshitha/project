<?php
/**
 * Post Type Customer.
 *
 * @package WPTravelEngine/Core/PostTypes
 * @since 6.0.0
 */

namespace WPTravelEngine\Core\PostTypes;

use WPTravelEngine\Abstracts\PostType;

/**
 * Class Customer
 * This class represents a customer to the WP Travel Engine plugin.
 *
 * @since 6.0.0
 */
class Customer extends PostType {

	/**
	 * Post type name.
	 *
	 * @var string
	 */
	protected string $post_type = 'customer';

	/**
	 * Retrieve the labels for the Customer post type.
	 *
	 * Returns an array containing the labels used for the Customer post type, including
	 * names for various elements such as the post type itself, singular and plural names,
	 * menu labels, and more.
	 *
	 * @return array An array containing the labels for the Customer post type.
	 */
	public function get_labels(): array {
		return array(
			'name'               => _x( 'Customers', 'post type general name', 'wp-travel-engine' ),
			'singular_name'      => _x( 'Customer', 'post type singular name', 'wp-travel-engine' ),
			'menu_name'          => _x( 'Customers', 'admin menu', 'wp-travel-engine' ),
			'name_admin_bar'     => _x( 'Customer', 'add new on admin bar', 'wp-travel-engine' ),
			'add_new'            => _x( 'Add New', 'Customer', 'wp-travel-engine' ),
			'add_new_item'       => esc_html__( 'Add New Customer', 'wp-travel-engine' ),
			'new_item'           => esc_html__( 'New Customer', 'wp-travel-engine' ),
			'edit_item'          => esc_html__( 'Edit Customer', 'wp-travel-engine' ),
			'view_item'          => esc_html__( 'View Customer', 'wp-travel-engine' ),
			'all_items'          => esc_html__( 'Customers', 'wp-travel-engine' ),
			'search_items'       => esc_html__( 'Search Customers', 'wp-travel-engine' ),
			'parent_item_colon'  => esc_html__( 'Parent Customers:', 'wp-travel-engine' ),
			'not_found'          => esc_html__( 'No Customers found.', 'wp-travel-engine' ),
			'not_found_in_trash' => esc_html__( 'No Customers found in Trash.', 'wp-travel-engine' ),
		);
	}

	/**
	 * Retrieve the icon for the Customer post type in the admin menu.
	 *
	 * Returns the icon URL or slug for the Customer post type to be displayed in the admin menu.
	 *
	 * @return string The icon URL or slug for the Customer post type.
	 */
	public function get_icon(): string {
		return 'dashicons-location-alt';
	}

	/**
	 * Retrieve the arguments for the Customer post type.
	 *
	 * Returns an array containing the arguments used to register the Customer post type.
	 *
	 * @return array An array containing the arguments for the Customer post type.
	 */
	public function get_args(): array {
		return array(
			'labels'             => $this->get_labels(),
			'description'        => esc_html__( 'Description.', 'wp-travel-engine' ),
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => 'edit.php?post_type=booking',
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'customer' ),
			'capability_type'    => 'post',
			'map_meta_cap'       => true,
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 50,
			'menu_icon'          => $this->get_icon(),
			'supports'           => array( 'title' ),
		);
	}
}
