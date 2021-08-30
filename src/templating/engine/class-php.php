<?php
/**
 * Reference: Template engine interface.
 *
 * @package Reference
 * @subpackage Templating\Engine
 * @author Martin Pettersson
 * @license GPL-2.0
 * @since 0.1.0
 */

namespace Reference\Templating\Engine;

use Reference\Templating\Engine_Interface;
use Reference\Templating\Template_Not_Found_Exception;

/**
 * A PHP template implementation of a template engine.
 *
 * @since 0.1.0
 */
class Php implements Engine_Interface {

	/**
	 * The directories to search for templates in.
	 *
	 * @since 0.1.0
	 *
	 * @var array
	 */
	private array $template_directories;

	/**
	 * Creates a new template engine instance.
	 *
	 * @since 0.1.0
	 *
	 * @param array $template_directories Directories to search for templates in.
	 */
	public function __construct( array $template_directories = array() ) {
		$this->template_directories = $template_directories;
	}

	/**
	 * Adds the given directories to be searched for templates.
	 *
	 * @since 0.1.0
	 *
	 * @param array $directories Directories to add.
	 */
	public function add_template_directories( array $directories ): void {
		$this->template_directories = array_unique( array_merge( $this->template_directories, $directories ) );
	}

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
	public function render( string $template_name, array $context = array() ): string {
		$template_file = $this->locate_template( $template_name );

		ob_start();

		// phpcs:ignore WordPress.PHP.DontExtract.extract_extract
		extract( $context );
		include $template_file;

		return (string) ob_get_clean();
	}

	/**
	 * Locates and returns the path to the given template.
	 *
	 * @param string $template_name Name of the template to locate.
	 * @return string Path to the given template.
	 * @throws \Reference\Templating\Template_Not_Found_Exception If the given template cannot be found.
	 */
	private function locate_template( string $template_name ): string {
		$template_filename = $this->get_template_filename( $template_name );

		foreach ( $this->template_directories as $directory ) {
			$template_file = rtrim( $directory, '/' ) . '/' . $template_filename;

			if ( is_readable( $template_file ) ) {
				return $template_file;
			}
		}

		throw new Template_Not_Found_Exception( $template_name );
	}

	/**
	 * Returns the filename of the given template name.
	 *
	 * @param string $template_name Name of the template.
	 * @return string Name of the template file.
	 */
	private function get_template_filename( string $template_name ): string {
		return rtrim( $template_name, '.php' ) . '.php';
	}
}
