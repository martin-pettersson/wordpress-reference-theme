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
	 * Scroll semaphore.
	 *
	 * This is used in combination with requestAnimationFrame to optimize
	 * scrolling.
	 *
	 * @type {boolean}
	 */
	#scroll_semaphore;

	/**
	 * Reference to the toggle_transparent_header method.
	 *
	 * We need to pass the same method instance when removing the event listener
	 * and since the method is bound we need to save a reference to it.
	 *
	 * @type {Function}
	 */
	#toggle_transparent_header_reference;

	/**
	 * Creates a new header instance.
	 *
	 * @since 0.1.0
	 * @param {HTMLElement} element Header element.
	 * @param {?Navigation} navigation Navigation instance.
	 * @param {Window}      scroll_container Scroll container.
	 */
	constructor( element, navigation, scroll_container ) {
		this.#element                             = element;
		this.#navigation                          = navigation;
		this.#scroll_container                    = scroll_container;
		this.#scroll_semaphore                    = false;
		this.#toggle_transparent_header_reference = this.#toggle_transparent_header.bind( this );

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
	 * @param {boolean} active Whether to enable transparent header on scroll.
	 */
	toggle_transparent_header_on_scroll( active = true ) {
		const action = active ? 'addEventListener' : 'removeEventListener';

		this.#scroll_container[ action ](
			'scroll',
			this.#toggle_transparent_header_reference,
			{
				capture: true,
				passive: true
			}
		);

		if ( ! active ) {
			this.#element.classList.remove( Header.#TRANSPARENT_CLASS_NAME );
		}

		if ( active && this.#scroll_container.scrollY === 0 ) {
			this.#element.classList.add( Header.#TRANSPARENT_CLASS_NAME );
		}
	}

	/**
	 * Toggles transparent header on scroll.
	 */
	#toggle_transparent_header() {
		const y = this.#scroll_container.scrollY;

		if (
			this.#scroll_semaphore ||
			( y === 0 && this.#element.classList.contains( Header.#TRANSPARENT_CLASS_NAME ) ) ||
			( y > 0 && ! this.#element.classList.contains( Header.#TRANSPARENT_CLASS_NAME ) )
		) {
			return;
		}

		requestAnimationFrame(() => {
			const action = y > 0 ? 'remove' : 'add';

			this.#element.classList[ action ]( Header.#TRANSPARENT_CLASS_NAME );
			this.#scroll_semaphore = false;
		});

		this.#scroll_semaphore = true;
	}

	/**
	 * Toggles the navigation visibility.
	 */
	#toggle_navigation() {
		this.navigation?.toggle();
	}
}

export default Header;
