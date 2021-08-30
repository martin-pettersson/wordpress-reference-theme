<?php
/**
 * Reference: Asset target location enum
 *
 * @package Reference
 * @author Martin Pettersson
 * @license GPL-2.0
 * @since 0.1.0
 */

namespace Reference\Asset;

use Reference\Abstract_Enum;

/**
 * An enum representing a fixed set of script target locations.
 *
 * @since 0.1.0
 * @see \Reference\Abstract_Enum
 */
class Target_Location extends Abstract_Enum {

	public const HEADER = 'HEADER';
	public const FOOTER = 'FOOTER';
}
