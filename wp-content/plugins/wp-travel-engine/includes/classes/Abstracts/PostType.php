<?php
/**
 * Class PostType.
 *
 * @package WPTravelEngine\Abstracts
 * @since 6.0.0
 */

namespace WPTravelEngine\Abstracts;

/**
 * Class PostType
 * This class represents a post type in the WP Travel Engine plugin.
 *
 * @since 6.0.0
 */
abstract class PostType {

	/**
	 * Post type name.
	 *
	 * @var string
	 */
	protected string $post_type;

	/**
	 * Retrieves the post type associated with the PostType class.
	 *
	 * @return string The post type.
	 */
	public function get_post_type(): string {
		return $this->post_type;
	}

	/**
	 * Retrieves the taxonomies associated with the Post-Type.
	 *
	 * @return array The taxonomies.
	 */
	public function taxonomies(): array {
		return array();
	}
}
