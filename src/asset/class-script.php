<?php
/**
 * Reference: Script asset class
 *
 * @package Reference
 * @author Martin Pettersson
 * @license GPL-2.0
 * @since 0.1.0
 */

namespace Reference\Asset;

/**
 * Class representing a theme script asset.
 *
 * @since 0.1.0
 * @see \Reference\Asset\Abstract_Asset
 */
class Script extends Abstract_Asset {

	/**
	 * Whether the asset should be preloaded for optimization.
	 *
	 * @since 0.1.0
	 * @var bool
	 */
	protected bool $should_be_preloaded = true;

	/**
	 * The location where this script should be loaded.
	 *
	 * @var \Reference\Asset\Target_Location
	 */
	private Target_Location $target_location;

	/**
	 * Creates a new asset instance.
	 *
	 * @param string                                  $handle Unique identifier.
	 * @param string                                  $url Asset URL.
	 * @param string|null                             $version Asset version.
	 * @param array                                   $dependencies List of asset dependencies.
	 * @param \Reference\Asset\Target_Location|string $target_location The location where this script should be loaded.
	 */
	public function __construct(
		string $handle,
		string $url,
		?string $version,
		array $dependencies,
		$target_location = Target_Location::FOOTER
	) {
		parent::__construct( $handle, $url, $version, $dependencies );

		$this->target_location = $target_location instanceof Target_Location ?
			$target_location :
			new Target_Location( $target_location );
	}

	/**
	 * Returns the location where this script should be loaded.
	 *
	 * @since 0.1.0
	 * @return \Reference\Asset\Target_Location $target_location The location where this script should be loaded.
	 */
	public function target_location(): Target_Location {
		return $this->target_location;
	}
}
