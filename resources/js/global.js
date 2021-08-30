/**
 * Reference: Theme entrypoint
 *
 * @package Reference
 * @author Martin Pettersson
 * @license GPL-2.0
 * @since 0.1.0
 */

import Theme from "./Theme.js";

window.reference ??= {};
window.reference.theme = Theme.get_instance();
