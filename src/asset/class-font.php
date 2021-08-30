<?php
/**
 * Reference: Font asset class
 *
 * @package Reference
 * @author Martin Pettersson
 * @license GPL-2.0
 * @since 0.1.0
 */

namespace Reference\Asset;

/**
 * Class representing a theme font asset.
 *
 * @since 0.1.0
 * @see \Reference\Asset\Abstract_Asset
 */
class Font extends Abstract_Asset {

	/**
	 * Base URL to Google Fonts.
	 *
	 * @var string
	 */
	private const BASE_URL = 'https://fonts.googleapis.com/css2?display=swap';

	/**
	 * Creates a new asset instance.
	 *
	 * @param string $handle Unique identifier.
	 * @param array  $font_definitions List of font definitions to include.
	 */
	public function __construct( string $handle, array $font_definitions ) {
		parent::__construct( $handle, $this->build_asset_url( $font_definitions ), null, array() );
	}

	/**
	 * Builds a Google Fonts URL from the given font definitions.
	 *
	 * @param array $font_definitions List of font definitions to include.
	 * @return string Google Fonts URL.
	 */
	private function build_asset_url( array $font_definitions ): string {
		return array_reduce( $font_definitions, array( $this, 'add_font' ), self::BASE_URL );
	}

	/**
	 * Adds the given font to the URL.
	 *
	 * @param string $url Google Fonts URL.
	 * @param array  $font_definition Font parameters.
	 * @return string Google Font URL with the added font parameters.
	 */
	public function add_font( string $url, array $font_definition ): string {
		$family           = $this->create_family_definition( $font_definition );
		$family_parameter = urldecode( http_build_query( compact( 'family' ) ) );
		$separator        = strpos( $url, '?' ) === false ? '?' : '&';

		return "{$url}{$separator}{$family_parameter}";
	}

	/**
	 * Creates a URL font family from the given font definition.
	 *
	 * @param array $font_definition Font parameters.
	 * @return string URL font family.
	 */
	private function create_family_definition( array $font_definition ): string {
		$weights = '';

		if ( array_key_exists( 'weights', $font_definition ) ) {
			$weights = ':wght@' . implode( ';', $font_definition['weights'] );
		}

		return "{$font_definition['name']}{$weights}";
	}
}
