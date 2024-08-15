<?php
/**
 * Data.
 *
 * @package WPTravelEngine/Abstracts
 * @since 6.0.0
 */

namespace WPTravelEngine\Abstracts;

use WP_Error;
use WP_Post;
use WPTravelEngine\Traits\Factory;

/**
 * Abstract class PostModel.
 *
 * @package WPTravelEngine/Abstracts
 */
abstract class PostModel {

	use Factory;

	/**
	 * Post data.
	 *
	 * @var array
	 */
	protected array $data = array();

	/**
	 * Post type name.
	 *
	 * @var string
	 */
	protected string $post_type;

	/**
	 * Post object.
	 *
	 * @var WP_Post
	 */
	public WP_Post $post;

	/**
	 * Post ID.
	 *
	 * @var int
	 */
	public int $ID;

	/**
	 * PostModel Constructor.
	 *
	 * @param WP_Post|int $post The post-object.
	 *
	 * @throws \InvalidArgumentException If the provided $post is not an instance of WP_Post or if the post type is invalid.
	 */
	public function __construct( $post ) {
		if ( is_numeric( $post ) ) {
			$post = get_post( $post );
		}

		if ( ! $post instanceof WP_Post ) {
			throw new \InvalidArgumentException( 'Invalid post object' );
		}

		if ( $post->post_type !== $this->post_type ) {
			throw new \InvalidArgumentException( 'Invalid post type' );
		}

		$this->ID = $post->ID;

		$this->post = $post;
	}

	/**
	 * Get the post ID
	 *
	 * This method is not abstract and can be used directly in child classes
	 *
	 * @return int The post ID
	 */
	public function get_id(): int {
		return $this->post->ID;
	}

	/**
	 * Get the post-title.
	 *
	 * This method is not abstract and can be used directly in child classes.
	 *
	 * @return string The post-title
	 */
	public function get_title(): string {
		return \get_the_title( $this->post );
	}

	/**
	 * Get the post permalink.
	 *
	 * This method is not abstract and can be used directly in child classes.
	 *
	 * @return string The post-permalink.
	 */
	public function get_permalink(): string {
		return get_permalink( $this->post );
	}

	/**
	 * Get the post-content.
	 *
	 * This method is not abstract and can be used directly in child classes.
	 *
	 * @return string The post-content
	 */
	public function get_content(): string {
		return get_the_content( null, false, $this->post );
	}

	/**
	 * Get the post-excerpt.
	 *
	 * This method is not abstract and can be used directly in child classes.
	 *
	 * @return string The post-excerpt.
	 */
	public function get_excerpt(): string {
		return get_the_excerpt( $this->ID );
	}

	/**
	 * Get a specific post-meta value
	 *
	 * This method is abstract and must be implemented in child classes.
	 * Child classes should define the specific meta-keys they use.
	 *
	 * @param string $meta_key The meta-key.
	 *
	 * @return mixed The meta-value or null if not found.
	 */
	public function get_meta( string $meta_key, $default = null ) {
		if ( isset( $this->data[ $meta_key ] ) ) {
			return $this->data[ $meta_key ];
		}

		$this->data[ $meta_key ] = get_post_meta( $this->post->ID, $meta_key, true );

		return $this->data[ $meta_key ];
	}

	/**
	 * @param $meta_key
	 * @param $meta_value
	 *
	 * @return mixed
	 */
	public function set_meta( $meta_key, $meta_value ) {
		$this->data['__changes'][ $meta_key ] = $meta_value;

		return $this;
	}

	/**
	 * Update the post-metadata.
	 *
	 * This method is abstract and must be implemented in child classes.
	 *
	 * @return bool|int
	 */
	public function update_meta( $meta_key, $meta_value ) {
		return update_post_meta( $this->ID, $meta_key, $meta_value );
	}

	/**
	 * Save the post-metadata.
	 * This method saves all the changes made to the post-metadata.
	 *
	 * @return object
	 */
	public function save(): object {
		foreach ( $this->data['__changes'] as $meta_key => $meta_value ) {
			$this->update_meta( $meta_key, $meta_value );
			unset( $this->data[ $meta_key ] );
		}
		unset( $this->data['__changes'] );

		return $this;
	}

	/**
	 * Get all post-metadata.
	 *
	 * This method is not abstract and can be used directly in child classes.
	 *
	 * @return array An associative array of all post meta data.
	 */
	public function get_all_meta(): array {
		return get_post_meta( $this->post->ID );
	}

	/**
	 * Get the post-type.
	 *
	 * @return string|null
	 */
	public function get_post_type(): string {
		return $this->post_type;
	}

	/**
	 * Create a new post for this post-type.
	 *
	 * @return $this The new post ID on success. The value 0 or WP_Error on failure.
	 */
	public static function create_post( array $postarr ): PostModel {
		return new static( \wp_insert_post( $postarr ) );
	}

	/**
	 * Update the post-title.
	 *
	 * This method is abstract and must be implemented in child classes.
	 *
	 * @param array $postarr The post-data.
	 *
	 * @return int|WP_Error The post-ID on success. The value 0 or WP_Error on failure.
	 */
	public function update_post( array $postarr ) {
		$postarr['ID'] = $this->ID;

		return wp_update_post( $postarr );
	}
}
