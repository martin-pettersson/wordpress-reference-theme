<?php
/**
 * Reference: Theme class
 *
 * @package Reference
 * @author Martin Pettersson
 * @license GPL-2.0
 * @since 0.1.0
 */

namespace Reference;

/**
 * Class representing the theme.
 *
 * @since 0.1.0
 */
class Theme {

	/**
	 * Current theme version.
	 *
	 * @since 0.1.0
	 * @var string
	 */
	public const VERSION = '0.1.6';

	/**
	 * Single instance of this class.
	 *
	 * @var \Reference\Theme
	 */
	private static Theme $instance;

	/**
	 * Template engine instance.
	 *
	 * @since 0.1.0
	 * @var \Reference\Templating\Engine_Interface
	 */
	public Templating\Engine_Interface $template_engine;

	/**
	 * Asset registry instance.
	 *
	 * @since 0.1.0
	 * @var \Reference\Asset\Registry
	 */
	public Asset\Registry $assets;

	/**
	 * Creates a new theme instance.
	 */
	private function __construct() {
		$this->template_engine = new Templating\Engine\Php(
			array(
				REFERENCE_THEME_DIR . '/resources/templates/php/',
			)
		);
		$this->assets          = new Asset\Registry( $this->template_engine );
	}

	/**
	 * Prevents this instance from being cloned.
	 */
	private function __clone() {}

	/**
	 * Retrieves a single instance of this class.
	 *
	 * @since 0.1.0
	 * @return \Reference\Theme
	 */
	public static function get_instance(): Theme {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new Theme();
		}

		return self::$instance;
	}

	/**
	 * Runs the theme's activation routine.
	 *
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 * @suppress PhanUnusedPublicNoOverrideMethodParameter
	 * @since 0.1.0
	 * @param string $previous_theme_name The name of the previously active theme.
	 */
	public function activate( string $previous_theme_name ): void {}

	/**
	 * Runs the theme's deactivation routine.
	 *
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 * @suppress PhanUnusedPublicNoOverrideMethodParameter
	 * @since 0.1.0
	 * @param string $next_theme_name The name of the next theme to be activated.
	 */
	public function deactivate( string $next_theme_name ): void {}

	/**
	 * Sets up the theme's features.
	 *
	 * @since 0.1.0
	 */
	public function load(): void {
		load_theme_textdomain( 'reference', REFERENCE_THEME_DIR . '/languages/' );

		$this->register_nav_menus();
		$this->add_theme_supports();
		$this->register_global_assets();
	}

	/**
	 * Registers the theme's navigation menus.
	 */
	private function register_nav_menus(): void {
		register_nav_menu( 'header', __( 'Header menu', 'reference' ) );
	}

	/**
	 * Adds the theme's supported features.
	 */
	private function add_theme_supports(): void {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);
		add_theme_support(
			'custom-header',
			array(
				'uploads' => true,
			)
		);
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 44,
				'width'       => 44,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);
	}

	/**
	 * Registers the theme's global assets.
	 */
	public function register_global_assets(): void {
		$this->assets->register_asset( Asset\Type::STYLE, 'reference-global', 'global' );
		$this->assets->register_asset( Asset\Type::SCRIPT, 'reference-global', 'global' );
		$this->assets->register_asset( Asset\Type::FONT, 'reference-global', 'global' );
	}
}
