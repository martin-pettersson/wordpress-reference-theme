<?php
/**
 * Reference: Style asset class
 *
 * @package Reference
 * @author Martin Pettersson
 * @license GPL-2.0
 * @since 0.1.0
 */

namespace Reference\Asset;

/**
 * Class representing a theme style asset.
 *
 * @since 0.1.0
 * @see \Reference\Asset\Abstract_Asset
 */
class Style extends Abstract_Asset {

	/**
	 * Whether the asset should be preloaded for optimization.
	 *
	 * @since 0.1.0
	 * @var bool
	 */
	protected bool $should_be_preloaded = true;

	/**
	 * The media for which this stylesheet has been defined.
	 *
	 * @var \Reference\Asset\Media_Type
	 */
	private Media_Type $media_type;

	/**
	 * Creates a new asset instance.
	 *
	 * @param string                             $handle Unique identifier.
	 * @param string                             $url Asset URL.
	 * @param string|null                        $version Asset version.
	 * @param array                              $dependencies List of asset dependencies.
	 * @param \Reference\Asset\Media_Type|string $media_type The media for which this stylesheet has been defined.
	 */
	public function __construct(
		string $handle,
		string $url,
		?string $version,
		array $dependencies = array(),
		$media_type = Media_Type::ALL
	) {
		parent::__construct( $handle, $url, $version, $dependencies );

		$this->media_type = $media_type instanceof Media_Type ?
			$media_type :
			new Media_Type( $media_type );
	}

	/**
	 * Returns the media for which this stylesheet has been defined.
	 *
	 * @since 0.1.0
	 * @return \Reference\Asset\Media_Type $media_type The media for which this stylesheet has been defined.
	 */
	public function media_type(): Media_Type {
		return $this->media_type;
	}
}
