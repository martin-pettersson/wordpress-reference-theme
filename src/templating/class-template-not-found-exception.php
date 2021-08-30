<?php
/**
 * Reference: Template not found exception class.
 *
 * @package Reference
 * @subpackage Templating
 * @author Martin Pettersson
 * @license GPL-2.0
 * @since 0.1.0
 */

namespace Reference\Templating;

use Exception;

/**
 * An exception to be thrown when a template engine cannot find a given template file.
 *
 * @since 0.1.0
 */
class Template_Not_Found_Exception extends Exception {

	/**
	 * Creates a new exception instance.
	 *
	 * @since 0.1.0
	 *
	 * @param string $template_name Name of the missing template.
	 */
	public function __construct( string $template_name ) {
		parent::__construct( "Could not find template: {$template_name}" );
	}
}
