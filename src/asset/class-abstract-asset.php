<?php
/**
 * Reference: Abstract asset class
 *
 * @package Reference
 * @author Martin Pettersson
 * @license GPL-2.0
 * @since 0.1.0
 */

namespace Reference\Asset;

/**
 * Class representing an abstract theme asset.
 *
 * This class is intended to be extended to create theme assets. It provides
 * sensible default values for the most common parameters.
 *
 * @since 0.1.0
 */
abstract class Abstract_Asset {

	/**
	 * Unique identifier.
	 *
	 * @since 0.1.0
	 * @var string
	 */
	protected string $handle;

	/**
	 * Asset URL.
	 *
	 * @since 0.1.0
	 * @var string
	 */
	protected string $url;

	/**
	 * Asset version.
	 *
	 * @since 0.1.0
	 * @var string|null
	 */
	protected ?string $version;

	/**
	 * List of asset dependencies.
	 *
	 * @since 0.1.0
	 * @var array
	 */
	protected array $dependencies;

	/**
	 * Whether the asset should be preloaded for optimization.
	 *
	 * @since 0.1.0
	 * @var bool
	 */
	protected bool $should_be_preloaded = false;

	/**
	 * Creates a new asset instance.
	 *
	 * @param string      $handle Unique identifier.
	 * @param string      $url Asset URL.
	 * @param string|null $version Asset version.
	 * @param array       $dependencies List of asset dependencies.
	 */
	public function __construct( string $handle, string $url, ?string $version, array $dependencies = array() ) {
		$this->handle       = $handle;
		$this->url          = $url;
		$this->version      = $version;
		$this->dependencies = $dependencies;
	}

	/**
	 * Returns the unique identifier.
	 *
	 * @since 0.1.0
	 * @return string Unique identifier.
	 */
	public function handle(): string {
		return $this->handle;
	}

	/**
	 * Returns the asset URL.
	 *
	 * @since 0.1.0
	 * @return string Asset URL.
	 */
	public function url(): string {
		return $this->url;
	}

	/**
	 * Returns the asset version.
	 *
	 * @since 0.1.0
	 * @return string|null Asset version.
	 */
	public function version(): ?string {
		return $this->version;
	}

	/**
	 * Returns a list of asset dependencies.
	 *
	 * @since 0.1.0
	 * @return array A list of asset dependencies.
	 */
	public function dependencies(): array {
		return $this->dependencies;
	}

	/**
	 * Determines whether the asset should be preloaded for optimization.
	 *
	 * @since 0.1.0
	 * @return bool True if the asset should be preloaded for optimization.
	 */
	public function should_be_preloaded(): bool {
		return $this->should_be_preloaded;
	}
}
