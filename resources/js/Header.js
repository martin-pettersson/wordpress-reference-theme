/**
 * Reference: Header class
 *
 * @package Reference
 * @author Martin Pettersson
 * @license GPL-2.0
 * @since 0.1.0
 */

/**
 * Class representing the site header.
 *
 * @since 0.1.0
 */
class Header {

	/**
	 * Class name to use when the header should be transparent.
	 *
	 * @type {string}
	 */
	static #TRANSPARENT_CLASS_NAME = 'site-header--transparent';

	/**
	 * Header element.
	 *
	 * @type {HTMLElement}
	 */
	#element;

	/**
	 * Navigation instance.
	 *
	 * @type {?Navigation}
	 */
	#navigation;

	/**
	 * Scroll container.
	 *
	 * @type {Window}
	 */
	#scroll_container;

	/**
	 * Whether to toggle transparent header on scroll.
	 *
	 * @type {boolean}
	 */
	#should_toggle_transparent_header;

	/**
	 * Creates a new header instance.
	 *
	 * @since 0.1.0
	 * @param {HTMLElement} element Header element.
	 * @param {?Navigation} navigation Navigation instance.
	 * @param {Window}      scroll_container Scroll container.
	 */
	constructor( element, navigation, scroll_container ) {
		this.#element                          = element;
		this.#navigation                       = navigation;
		this.#scroll_container                 = scroll_container;
		this.#should_toggle_transparent_header = false;

		if ( navigation ) {
			const menu_button_element = this.#element.querySelector( '.site-header__menu-button' );

			menu_button_element.addEventListener( 'click', this.#toggle_navigation.bind( this ), true );
		}
	}

	/**
	 * Returns the header element.
	 *
	 * @since 0.1.0
	 * @return {HTMLElement} Header element.
	 */
	get element() {
		return this.#element;
	}

	/**
	 * Returns the navigation instance.
	 *
	 * @since 0.1.0
	 * @return {Navigation} Navigation instance.
	 */
	get navigation() {
		return this.#navigation;
	}

	/**
	 * Enables/disables toggling transparent header on scroll.
	 *
	 * @since 0.1.0
	 * @param {?boolean} active Whether to enable transparent header on scroll.
	 */
	toggle_transparent_header_on_scroll( active ) {
		this.#should_toggle_transparent_header = typeof active === 'boolean' ?
			active :
			! this.#should_toggle_transparent_header;

		this.#toggle_transparent_header();
	}

	/**
	 * Toggles transparent header on scroll.
	 */
	#toggle_transparent_header() {
		if ( ! this.#should_toggle_transparent_header ) {
			this.#element.classList.remove( Header.#TRANSPARENT_CLASS_NAME );

			return;
		}

		const y = this.#scroll_container.scrollY;

		if (
			( y === 0 && ! this.#element.classList.contains( Header.#TRANSPARENT_CLASS_NAME ) ) ||
			( y > 0 && this.#element.classList.contains( Header.#TRANSPARENT_CLASS_NAME ) )
		) {
			this.#element.classList[ y > 0 ? 'remove' : 'add' ]( Header.#TRANSPARENT_CLASS_NAME );
		}

		requestAnimationFrame( this.#toggle_transparent_header.bind( this ) );
	}

	/**
	 * Toggles the navigation visibility.
	 */
	#toggle_navigation() {
		this.navigation?.toggle();
	}
}

export default Header;
