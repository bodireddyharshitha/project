<?php
/**
 * Class Iterator.
 *
 * @package WPTravelEngine\Abstracts
 */

namespace WPTravelEngine\Abstracts;

/**
 * Class Iterator
 * This class represents an iterator in the WP Travel Engine plugin.
 */
abstract class Iterator implements \Iterator {
	/**
	 * The data array.
	 *
	 * @var array
	 */
	protected array $data = array();

	/**
	 * The position of the current element in the data array.
	 *
	 * @var int
	 */
	protected int $position = 0;

	/**
	 * Iterator Constructor.
	 *
	 * @param array $data The data array.
	 */
	public function __construct( array $data ) {
		$this->data = $data;
	}

	/**
	 * Return the current element in the data array.
	 *
	 * @return mixed
	 */
	#[\ReturnTypeWillChange]
	public function current() {
		return $this->data[ $this->position ];
	}

	/**
	 * Return the key of the current element in the data array.
	 *
	 * @return int
	 */
	#[\ReturnTypeWillChange]
	public function key() {
		return $this->position;
	}

	/**
	 * Move the position of the current element in the data array to the next element.
	 */
	#[\ReturnTypeWillChange]
	public function next() {
		++ $this->position;
	}

	/**
	 * Reset the position of the current element in the data array to the first element.
	 */
	#[\ReturnTypeWillChange]
	public function rewind() {
		$this->position = 0;
	}

	/**
	 * Check if the current element in the data array is valid.
	 *
	 * @return bool
	 */
	#[\ReturnTypeWillChange]
	public function valid() {
		return isset( $this->data[ $this->position ] );
	}

	/**
	 * Get the trip object.
	 *
	 * @return array
	 */
	public function array(): array {
		return $this->data;
	}
}
