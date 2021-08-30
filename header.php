<?php
/**
 * Reference: Header template file
 *
 * @package Reference
 * @author Martin Pettersson
 * @license GPL-2.0
 * @since 0.1.0
 */

$logo_image_data = has_custom_logo() ?
	wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) ) :
	false;

// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
echo Reference\Theme::get_instance()->template_engine->render(
	'header',
	array(
		'charset'        => get_bloginfo( 'charset' ),
		'header_classes' => array( 'site-header' ),
		'site_url'       => get_site_url(),
		'site_title'     => get_bloginfo( 'site-title' ),
		'logo'           => false !== $logo_image_data ? reset( $logo_image_data ) : null,
		'nav_menu'       => has_nav_menu( 'header' ) ?
			wp_nav_menu(
				array(
					'theme_location'  => 'header',
					'fallback_cb'     => false,
					'container'       => 'nav',
					'container_id'    => 'site-navigation',
					'container_class' => 'site-navigation',
					'menu_id'         => 'site-navigation__menu',
					'menu_class'      => 'site-navigation__menu',
					'echo'            => false,
				)
			) :
			null,
		'hero'           => null,
	)
);
// phpcs:enable WordPress.Security.EscapeOutput.OutputNotEscaped
