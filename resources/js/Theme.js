/**
 * Reference: Theme class
 *
 * @package Reference
 * @author Martin Pettersson
 * @license GPL-2.0
 * @since 0.1.0
 */

import Header from "./Header.js";
import Hero from "./Hero.js";
import Navigation from "./Navigation.js";

/**
 * Class representing the theme.
 *
 * @since 0.1.0
 */
class Theme {
	/**
	 * Single instance of this class.
	 *
	 * @type {Theme}
	 */
	static #instance;

	/**
	 * Semaphore used to determine if an instance is being constructed correctly.
	 *
	 * This is a crude way of implementing the singleton pattern.
	 *
	 * @type {boolean}
	 */
	static #is_correctly_constructed_semaphore = false;

	/**
	 * Header instance.
	 *
	 * @type {?Header}
	 */
	#header;

	/**
	 * Hero instance.
	 *
	 * @type {?Hero}
	 */
	#hero;

	/**
	 * Retrieves a single instance of this class.
	 *
	 * @since 0.1.0
	 * @return {Theme}
	 */
	static get_instance() {
		if ( ! Theme.#instance ) {
			Theme.#is_correctly_constructed_semaphore = true;
			Theme.#instance                           = new Theme();
			Theme.#is_correctly_constructed_semaphore = false;
		}

		return Theme.#instance;
	}

	/**
	 * Creates a new theme instance.
	 */
	constructor() {
		if ( ! Theme.#is_correctly_constructed_semaphore ) {
			throw new Error( 'You cannot directly instantiate this class, you should use #get_instance()' );
		}

		const header_element       = document.querySelector( '#site-header' );
		const navigation_element   = header_element.querySelector( '#site-navigation' );
		const site_overlay_element = document.querySelector( '#site-overlay' );
		const hero_element         = document.querySelector("#hero");
		const navigation           = navigation_element ?
			new Navigation( navigation_element, site_overlay_element, document.body ) :
			null;
		const blur_offset          = document.body.classList.contains( 'has-cover-image' ) ?
			(header_element?.getBoundingClientRect().height ?? 0) * 4 :
			0;

		this.#header = header_element ? new Header( header_element, navigation, window ) : null;
		this.#hero   = hero_element ? new Hero( hero_element, window, blur_offset ) : null;

		if ( document.body.classList.contains( 'has-header-image' ) ) {
			this.#header.toggle_transparent_header_on_scroll( true );
		}
	}

	/**
	 * Returns the header instance.
	 *
	 * @return {?Header}
	 */
	get header() {
		return this.#header;
	}

	/**
	 * Returns the hero instance.
	 *
	 * @return {?Hero}
	 */
	get hero() {
		return this.#hero;
	}
}

export default Theme;
