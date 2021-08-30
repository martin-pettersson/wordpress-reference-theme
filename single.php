<?php
/**
 * Reference: Page template file
 *
 * @package Reference
 * @author Martin Pettersson
 * @license GPL-2.0
 * @since 0.1.0
 */

// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
echo Reference\Theme::get_instance()->template_engine->render(
	'single',
	array(
		'content' => get_the_content(),
	)
);
// phpcs:enable WordPress.Security.EscapeOutput.OutputNotEscaped
