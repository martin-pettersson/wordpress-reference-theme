<?php
/**
 * Reference: Index template file
 *
 * @package Reference
 * @author Martin Pettersson
 * @license GPL-2.0
 * @since 0.1.0
 */

// phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
$posts = new Reference\Post_Iterator(
	new WP_Query(
		array(
			'post_type' => 'post',
		)
	)
);

// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo Reference\Theme::get_instance()->template_engine->render( 'index', compact( 'posts' ) );
