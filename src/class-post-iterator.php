<?php
/**
 * Reference: Post iterator class
 *
 * @package Reference
 * @author Martin Pettersson
 * @license GPL-2.0
 * @since 0.1.0
 */

namespace Reference;

use Iterator;
use WP_Query;

/**
 * A post iterator to be used as "the loop".
 *
 * @since 0.1.0
 */
class Post_Iterator implements Iterator {

	/**
	 * The current position.
	 *
	 * @var int
	 */
	private int $position;

	/**
	 * The post query.
	 *
	 * @var \WP_Query
	 */
	private WP_Query $query;

	/**
	 * The current post object.
	 *
	 * @var \WP_Post|array|null
	 */
	private $current_post;

	/**
	 * Creates a new iterator instance.
	 *
	 * @since 0.1.0
	 * @param \WP_Query $query The query to run the iterator over.
	 */
	public function __construct( WP_Query $query ) {
		$this->position = 0;
		$this->query    = $query;
	}

	/**
	 * Returns the current post object.
	 *
	 * @since 0.1.0
	 * @return \WP_Post|array|null The current post object.
	 */
	public function current() {
		if ( is_null( $this->current_post ) ) {
			$this->query->the_post();
			$this->current_post = get_post();
		}

		return $this->current_post;
	}

	/**
	 * Returns the current position.
	 *
	 * @since 0.1.0
	 * @return int
	 */
	public function key(): int {
		return $this->position;
	}

	/**
	 * Sets up the next post in the query.
	 *
	 * @since 0.1.0
	 */
	public function next(): void {
		$this->current_post = null;
		$this->position++;
	}

	/**
	 * Rewinds the query.
	 *
	 * @since 0.1.0
	 */
	public function rewind(): void {
		$this->position = 0;
		$this->query->rewind_posts();
	}

	/**
	 * Returns true if the current value is valid.
	 *
	 * @since 0.1.0
	 * @return bool
	 */
	public function valid(): bool {
		$is_valid = $this->query->have_posts();

		if ( ! $is_valid ) {
			wp_reset_postdata();
		}

		return $is_valid;
	}
}
