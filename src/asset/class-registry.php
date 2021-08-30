<?php
/**
 * Reference: Asset registry class
 *
 * @package Reference
 * @author Martin Pettersson
 * @license GPL-2.0
 * @since 0.1.0
 */

namespace Reference\Asset;

use Reference\Templating;

/**
 * Class representing a registry of theme assets.
 *
 * @since 0.1.0
 */
class Registry {

	/**
	 * All registered theme assets.
	 *
	 * @var array
	 */
	private array $assets;

	/**
	 * Template engine instance.
	 *
	 * @var \Reference\Templating\Engine_Interface
	 */
	private Templating\Engine_Interface $template_engine;

	/**
	 * Creates a new asset registry instance.
	 *
	 * @param \Reference\Templating\Engine_Interface $template_engine Template engine instance.
	 */
	public function __construct( Templating\Engine_Interface $template_engine ) {
		$this->assets          = array();
		$this->template_engine = $template_engine;
	}

	/**
	 * Registers a given theme asset.
	 *
	 * @since 0.1.0
	 * @param \Reference\Asset\Abstract_Asset $asset Theme asset instance.
	 */
	public function register( Abstract_Asset $asset ): void {
		add_action( 'wp_enqueue_scripts', fn() => $this->enqueue_asset( $asset ) );
	}

	/**
	 * Registers an asset by the given parameters.
	 *
	 * This is a convenience method that assembles the needed pieces to create
	 * and register a theme asset.
	 *
	 * @since 0.1.0
	 * @param \Reference\Asset\Type|string $type Asset type.
	 * @param string                       $handle Asset unique identifier.
	 * @param string                       $name Asset name.
	 */
	public function register_asset( $type, string $handle, string $name ): void {
		if ( ! $type instanceof Type ) {
			$type = new Type( $type );
		}

		switch ( $type->value() ) {
			case Type::STYLE:
				$this->register( $this->create_style_asset( $handle, $name ) );
				break;
			case Type::SCRIPT:
				$this->register( $this->create_script_asset( $handle, $name ) );
				break;
			case Type::FONT:
				$this->register( $this->create_font_asset( $handle, $name ) );
				break;
		}
	}

	/**
	 * Creates a style asset based on the given parameters.
	 *
	 * @param string $handle Asset unique identifier.
	 * @param string $name Asset name.
	 * @return \Reference\Asset\Abstract_Asset Style asset instance.
	 */
	private function create_style_asset( string $handle, string $name ): Abstract_Asset {
		list( 'version' => $version ) = require REFERENCE_THEME_DIR . '/assets/' . $name . '.scss.asset.php';

		return new Style( $handle, REFERENCE_THEME_DIR_URL . '/assets/' . $name . '.scss.css', $version, array() );
	}

	/**
	 * Creates a script asset based on the given parameters.
	 *
	 * @param string $handle Asset unique identifier.
	 * @param string $name Asset name.
	 * @return \Reference\Asset\Abstract_Asset Script asset instance.
	 */
	private function create_script_asset( string $handle, string $name ): Abstract_Asset {
		list(
			'dependencies' => $dependencies,
			'version' => $version
		) = require REFERENCE_THEME_DIR . '/assets/' . $name . '.asset.php';

		return new Script( $handle, REFERENCE_THEME_DIR_URL . '/assets/' . $name . '.js', $version, $dependencies );
	}

	/**
	 * Creates a font asset based on the given parameters.
	 *
	 * @param string $handle Asset unique identifier.
	 * @param string $name Asset name.
	 * @return \Reference\Asset\Abstract_Asset Font asset instance.
	 */
	private function create_font_asset( string $handle, string $name ): Abstract_Asset {
		$font_definitions = require REFERENCE_THEME_DIR . '/resources/fonts/' . $name . '.php';

		return new Font( $handle, $font_definitions );
	}

	/**
	 * Enqueues a given theme asset.
	 *
	 * @param \Reference\Asset\Abstract_Asset $asset Theme asset instance.
	 */
	private function enqueue_asset( Abstract_Asset $asset ): void {
		if ( $asset instanceof Style ) {
			wp_enqueue_style(
				$asset->handle(),
				$asset->url(),
				$asset->dependencies(),
				$asset->version(),
				$asset->media_type()->value()
			);
		}

		if ( $asset instanceof Script ) {
			wp_enqueue_script(
				$asset->handle(),
				$asset->url(),
				$asset->dependencies(),
				$asset->version(),
				$asset->target_location()->value() === Target_Location::FOOTER
			);
		}

		if ( $asset instanceof Font ) {
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			add_action( 'wp_head', fn() => $this->print_font_link( $asset ), 8 );
		}

		if ( $asset->should_be_preloaded() ) {
			add_action( 'wp_head', fn() => $this->preload_asset( $asset ), 2 );
		}
	}

	/**
	 * Prints the Google Font Link for the given asset.
	 *
	 * @param \Reference\Asset\Abstract_Asset $asset Theme asset instance.
	 */
	private function print_font_link( Abstract_Asset $asset ): void {
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $this->template_engine->render(
			'asset/font',
			array(
				'href' => $asset->url(),
				'rel'  => 'stylesheet',
			)
		);
		// phpcs:enable WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Preloads the given asset.
	 *
	 * @param \Reference\Asset\Abstract_Asset $asset Theme asset instance.
	 */
	private function preload_asset( Abstract_Asset $asset ): void {
		$class_name = get_class( $asset );
		$type       = strtolower( substr( $class_name, strrpos( $class_name, '\\' ) + 1 ) );
		$href       = apply_filters(
			"{$type}_loader_src",
			! is_null( $asset->version() ) ?
			add_query_arg( 'ver', $asset->version(), $asset->url() ) :
			$asset->url(),
			$asset->handle()
		);

		if ( $asset instanceof Script ) {
			add_filter(
				'script_loader_tag',
				fn( string $tag, string $handle ) => $this->defer_script( $asset, $tag, $handle ),
				10,
				2
			);
		}

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $this->template_engine->render( 'asset/preload', compact( 'href', 'type' ) );
	}

	/**
	 * Defers the given script.
	 *
	 * @param \Reference\Asset\Script $script Theme script asset instance.
	 * @param string                  $tag Asset script HTML element.
	 * @param string                  $handle Unique identifier.
	 * @return string Asset script HTML element.
	 */
	private function defer_script( Script $script, string $tag, string $handle ): string {
		if ( $handle !== $script->handle() ) {
			return $tag;
		}

		return str_replace( '><', ' defer><', $tag );
	}
}
