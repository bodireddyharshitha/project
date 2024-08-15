<?php
/**
 * Post Type Booking.
 *
 * @package WPTravelEngine/Core/PostTypes
 * @since 6.0.0
 */

namespace WPTravelEngine\Core\PostTypes;

use WPTravelEngine\Abstracts\PostType;

/**
 * Class Trip
 * This class represents a trip to the WP Travel Engine plugin.
 *
 * @since 6.0.0
 */
class Booking extends PostType {

	/**
	 * Post type name.
	 *
	 * @var string
	 */
	protected string $post_type = 'booking';

	/**
	 * Retrieve the labels for the Booking post type.
	 *
	 * Returns an array containing the labels used for the Booking post type, including
	 * names for various elements such as the post type itself, singular and plural names,
	 * menu labels, and more.
	 *
	 * @return array An array containing the labels for the Booking post type.
	 */
	public function get_labels(): array {
		return array(
			'name'               => _x( 'Bookings', 'post type general name', 'wp-travel-engine' ),
			'singular_name'      => _x( 'Booking', 'post type singular name', 'wp-travel-engine' ),
			'menu_name'          => _x( 'WP Travel Engine', 'admin menu', 'wp-travel-engine' ),
			'name_admin_bar'     => _x( 'Booking', 'add new on admin bar', 'wp-travel-engine' ),
			'add_new'            => _x( 'Add New', 'Booking', 'wp-travel-engine' ),
			'add_new_item'       => esc_html__( 'Add New Booking', 'wp-travel-engine' ),
			'new_item'           => esc_html__( 'New Booking', 'wp-travel-engine' ),
			'edit_item'          => esc_html__( 'Edit Booking', 'wp-travel-engine' ),
			'view_item'          => esc_html__( 'View Booking', 'wp-travel-engine' ),
			'all_items'          => esc_html__( 'Bookings', 'wp-travel-engine' ),
			'search_items'       => esc_html__( 'Search Bookings', 'wp-travel-engine' ),
			'parent_item_colon'  => esc_html__( 'Parent Bookings:', 'wp-travel-engine' ),
			'not_found'          => esc_html__( 'No Bookings found.', 'wp-travel-engine' ),
			'not_found_in_trash' => esc_html__( 'No Bookings found in Trash.', 'wp-travel-engine' ),
		);
	}

	/**
	 * Retrieve the post type name.
	 *
	 * Returns the name of the post type.
	 *
	 * @return string The name of the post type.
	 */
	public function get_post_type(): string {
		return $this->post_type;
	}

	/**
	 * Retrieve the icon for the Booking post type.
	 *
	 * Returns the icon for the Booking post type.
	 *
	 * @return string The icon for the Booking post type.
	 */
	public function get_icon(): string {
		return 'data:image/svg+xml;base64,' . base64_encode( '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_60_548)"><path d="M22.8963 12.1856C23.1956 11.7415 22.7501 11.3673 22.7501 11.3673C22.7501 11.3673 22.2301 11.1051 21.9322 11.5491C21.633 11.9932 20.8789 13.1159 20.8789 13.1159L17.8029 13.1871L17.287 13.954L19.8988 14.572L18.7272 15.9741C19.0916 16.1151 19.4014 16.3747 19.7525 16.5486L20.863 15.2085L22.4442 17.359L22.9602 16.5921L21.8418 13.7524C21.8431 13.7524 22.5984 12.6297 22.8963 12.1856Z" fill="white"></path><path d="M11.9222 11.5544C12.8513 11.5544 13.6045 10.8081 13.6045 9.88745C13.6045 8.96683 12.8513 8.22052 11.9222 8.22052C10.9931 8.22052 10.2399 8.96683 10.2399 9.88745C10.2399 10.8081 10.9931 11.5544 11.9222 11.5544Z" fill="white"></path><path d="M21.2379 13.4954C20.9587 13.3215 20.589 13.4045 20.4134 13.6825C18.7032 16.3733 16.9172 17.8439 15.2482 17.9335C13.1351 18.0495 11.744 16.011 10.5299 14.6498C9.8862 13.9276 9.30105 13.1568 8.79038 12.3371C8.3861 11.6901 7.93927 10.9166 7.93927 10.1339C7.93794 7.95699 9.72528 6.18596 11.9222 6.18596C14.1178 6.18596 15.9052 7.95699 15.9052 10.1339C15.9052 11.4371 14.3226 13.5244 12.9635 15.0477C12.7494 15.2875 12.7733 15.6525 13.0114 15.87C13.0154 15.8726 13.018 15.8766 13.022 15.8792C13.2641 16.1006 13.6444 16.0795 13.8625 15.8357C15.2668 14.2716 17.1034 11.8904 17.1034 10.1326C17.1021 7.30208 14.7788 5 11.9222 5C9.06567 5 6.74106 7.30208 6.74106 10.1339C6.74106 11.7876 8.36749 13.9935 9.73326 15.555L9.72927 15.5511C10.091 15.8897 10.4022 16.2996 10.744 16.6593C11.4076 17.3551 12.0858 18.0969 12.9382 18.5634C12.9396 18.5647 12.9422 18.5647 12.9475 18.5687C13.5181 18.877 14.2375 19.1235 15.0807 19.1235C15.1511 19.1235 15.223 19.1221 15.2961 19.1182C17.4039 19.0141 19.4666 17.3972 21.4255 14.3137C21.6023 14.037 21.5172 13.6707 21.2379 13.4954Z" fill="white"></path><path d="M10.6349 17.7979C10.4607 17.6345 10.2054 17.5937 9.98463 17.6859C9.58567 17.852 9.11889 17.9626 8.59625 17.9337C6.92727 17.844 5.14126 16.3735 3.4377 13.6919L2.11049 11.5137C1.94027 11.233 1.57189 11.1434 1.28996 11.312C1.0067 11.482 0.914938 11.8457 1.08649 12.1264L2.41902 14.3138C4.37791 17.3973 6.44054 19.0142 8.54838 19.1183C8.62152 19.1222 8.69333 19.1236 8.76381 19.1236C9.40082 19.1236 9.96867 18.9826 10.4541 18.7796C10.8544 18.6123 10.9528 18.0957 10.6376 17.7992L10.6349 17.7979Z" fill="white"></path></g></svg>' ); // phpcs:ignore WordPress.WP.EnsuredPHPCS.Base64Encode.FileWithoutSafety
	}

	/**
	 * Retrieve the arguments for the Booking post type.
	 *
	 * Returns an array containing the arguments used to register the Booing post type.
	 *
	 * @return array An array containing the arguments for the Booking post type.
	 */
	public function get_args(): array {

		return array(
			'labels'             => $this->get_labels(),
			'description'        => esc_html__( 'Description.', 'wp-travel-engine' ),
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'menu_icon'          => $this->get_icon(),
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'booking' ),
			'capability_type'    => 'post',
			'map_meta_cap'       => true, // Set to `false`, if users are not allowed to edit/delete existing posts.
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 31,
			'supports'           => array( 'title' ),
		);
	}
}
