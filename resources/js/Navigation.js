/**
 * Reference: Navigation class
 *
 * @package Reference
 * @author Martin Pettersson
 * @license GPL-2.0
 * @since 0.1.0
 */

/**
 * Class representing the site navigation.
 *
 * @since 0.1.0
 */
class Navigation {

	/**
	 * Class name to use when the navigation should be visible.
	 *
	 * @type {string}
	 */
	static #VISIBLE_CLASS_NAME = 'site-navigation--visible';

	/**
	 * Class name to use when a submenu should be expanded.
	 *
	 * @type {string}
	 */
	static #SUBMENU_VISIBLE_CLASS_NAME = 'menu-item-has-children--expanded';

	/**
	 * Navigation element.
	 *
	 * @type {HTMLElement}
	 */
	#element;

	/**
	 * Container element.
	 *
	 * @type {HTMLElement}
	 */
	#container;

	/**
	 * Overlay element.
	 *
	 * @type {HTMLElement}
	 */
	#overlay;

	/**
	 * Creates a new navigation instance.
	 *
	 * @since 0.1.0
	 * @param {HTMLElement} element Navigation element.
	 * @param {HTMLElement} overlay Overlay element.
	 * @param {HTMLElement} container Container element.
	 */
	constructor( element, overlay, container ) {
		this.#element   = element;
		this.#overlay   = overlay;
		this.#container = container;
		this.toggle     = this.toggle.bind( this );

		const menu_items = this.#element.querySelectorAll( '.menu-item-has-children' );

		for ( const menu_item of menu_items ) {
			menu_item.addEventListener( 'click', this.#toggleSubmenu.bind( this, menu_item ), true );
		}
	}

	/**
	 * Returns the navigation element.
	 *
	 * @since 0.1.0
	 * @return {HTMLElement} Navigation element.
	 */
	get element() {
		return this.#element;
	}

	/**
	 * Toggles the navigation visibility.
	 */
	toggle() {
		const action = this.#container.classList.contains( Navigation.#VISIBLE_CLASS_NAME ) ?
			'removeEventListener' :
			'addEventListener';

		this.#overlay[ action ]( 'click', this.toggle, true );
		this.#container.classList.toggle( Navigation.#VISIBLE_CLASS_NAME );
	}

	/**
	 * Toggles the visibility of the given menu item's submenu.
	 *
	 * @param {HTMLElement} menu_item Navigation menu item element.
	 * @param {MouseEvent}  event Click event triggering the toggle action.
	 */
	#toggleSubmenu( menu_item, event ) {
		if ( 'LI' !== event.target.tagName ) {
			return;
		}

		menu_item.classList.toggle( Navigation.#SUBMENU_VISIBLE_CLASS_NAME );
	}
}

export default Navigation;
