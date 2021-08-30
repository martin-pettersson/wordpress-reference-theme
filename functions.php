<?php
/**
 * Reference: Functions file
 *
 * @package Reference
 * @author Martin Pettersson
 * @license GPL-2.0
 * @since 0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

define( 'REFERENCE_THEME_FILE', __FILE__ );
define( 'REFERENCE_THEME_DIR', dirname( REFERENCE_THEME_FILE ) );
define( 'REFERENCE_THEME_DIR_URL', get_template_directory_uri() );

require_once REFERENCE_THEME_DIR . '/vendor/autoload.php';

$theme = Reference\Theme::get_instance();

add_action( 'after_setup_theme', array( $theme, 'load' ) );
add_action( 'after_switch_theme', array( $theme, 'activate' ) );
add_action( 'switch_theme', array( $theme, 'deactivate' ) );
