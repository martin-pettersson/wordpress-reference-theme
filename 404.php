<?php
/**
 * Reference: 404 template file
 *
 * @package Reference
 * @author Martin Pettersson
 * @license GPL-2.0
 * @since 0.1.0
 */

// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo Reference\Theme::get_instance()->template_engine->render( '404' );
