<?php
/**
 * Reference: Enum class
 *
 * @package Reference
 * @author Martin Pettersson
 * @license GPL-2.0
 * @since 0.1.0
 */

namespace Reference;

use InvalidArgumentException;
use ReflectionClass;

/**
 * Abstract class representing an enum.
 *
 * @since 0.1.0
 */
abstract class Abstract_Enum {

	/**
	 * The enum value.
	 *
	 * @since 0.1.0
	 * @var mixed
	 */
	protected $value;

	/**
	 * List of strings used when representing the enum as a string.
	 *
	 * @since 0.1.0
	 * @var array
	 */
	protected array $strings = array();

	/**
	 * Creates a new enum instance.
	 *
	 * @param mixed $value The enum value.
	 * @throws \InvalidArgumentException When value is not part of the enum.
	 */
	final public function __construct( $value ) {
		if ( ! in_array( $value, static::values(), true ) ) {
			throw new InvalidArgumentException( 'Invalid value for enum ' . static::class . ': ' . $value );
		}

		$this->value = self::constant_from_value( $value );
	}

	/**
	 * Returns a string representation of the enum value.
	 *
	 * @return string The enum value represented as a string.
	 */
	final public function __toString(): string {
		return array_key_exists( $this->value(), $this->strings ) ?
			(string) $this->strings[ $this->value() ] :
			(string) $this->value;
	}

	/**
	 * Returns the enum value.
	 *
	 * @since 0.1.0
	 * @return mixed The enum value.
	 */
	final public function value() {
		return constant( "static::{$this->value}" );
	}

	/**
	 * Returns the enum constants.
	 *
	 * @since 0.1.0
	 * @return array The enum constants.
	 */
	final public function enum(): array {
		return array_keys( ( new ReflectionClass( static::class ) )->getConstants() );
	}

	/**
	 * Returns the enum values.
	 *
	 * @since 0.1.0
	 * @return array The enum values.
	 */
	final public function values(): array {
		return array_values( ( new ReflectionClass( static::class ) )->getConstants() );
	}

	/**
	 * Returns the enum constant for the given value.
	 *
	 * @since 0.1.0
	 * @param mixed $value The value to get the constant for.
	 * @return string The constant for the given value.
	 */
	final public static function constant_from_value( $value ): string {
		return (string) array_flip( ( new ReflectionClass( static::class ) )->getConstants() )[ $value ];
	}
}
