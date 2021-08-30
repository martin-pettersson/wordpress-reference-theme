<?php
/**
 * Reference: Asset type enum
 *
 * @package Reference
 * @author Martin Pettersson
 * @license GPL-2.0
 * @since 0.1.0
 */

namespace Reference\Asset;

use Reference\Abstract_Enum;

/**
 * An enum representing a fixed set of asset types.
 *
 * @since 0.1.0
 * @see \Reference\Abstract_Enum
 */
class Type extends Abstract_Enum {

	public const STYLE  = 'STYLE';
	public const SCRIPT = 'SCRIPT';
	public const FONT   = 'FONT';
}
