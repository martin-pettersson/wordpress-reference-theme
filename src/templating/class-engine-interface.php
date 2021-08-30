<?php
/**
 * Reference: Template engine interface.
 *
 * @package Reference
 * @subpackage Templating
 * @author Martin Pettersson
 * @license GPL-2.0
 * @since 0.1.0
 */

namespace Reference\Templating;

/**
 * An interface for template engines.
 *
 * @since 0.1.0
 */
interface Engine_Interface {

	/**
	 * Adds the given directories to be searched for templates.
	 *
	 * @since 0.1.0
	 *
	 * @param array $directories Directories to add.
	 */
	public function add_template_directories( array $directories ): void;

	/**
	 * Renders a matching template in the given context.
	 *
	 * @since 0.1.0
	 *
	 * @param string $template_name Name of the template to render.
	 * @param array  $context Context to render the template in.
	 * @return string Rendered template.
	 * @throws \Reference\Templating\Template_Not_Found_Exception If the given template cannot be found.
	 */
	public function render( string $template_name, array $context = array() ): string;
}
