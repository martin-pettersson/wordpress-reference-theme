<?php
/**
 * Reference: Asset media type enum
 *
 * @package Reference
 * @author Martin Pettersson
 * @license GPL-2.0
 * @since 0.1.0
 */

namespace Reference\Asset;

use Reference\Abstract_Enum;

/**
 * An enum representing a fixed set of style media types.
 *
 * @since 0.1.0
 * @see \Reference\Abstract_Enum
 */
class Media_Type extends Abstract_Enum {

	public const ALL    = 'all';
	public const PRINT  = 'print';
	public const SCREEN = 'screen';
}
