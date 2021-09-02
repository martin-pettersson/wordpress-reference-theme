/**
 * Reference: Hero class
 *
 * @package Reference
 * @author Martin Pettersson
 * @license GPL-2.0
 * @since 0.1.0
 */

/**
 * Class representing the site hero.
 *
 * @since 0.1.0
 */
class Hero {

	/**
	 * Hero element.
	 *
	 * @type {HTMLElement}
	 */
	#element;

	/**
	 * Scroll container.
	 *
	 * @type {Window}
	 */
	#scroll_container;

	/**
	 * Whether to use the parallax scrolling effect.
	 *
	 * @type {boolean}
	 */
	#should_use_parallax_effect;

	/**
	 * Hero image element.
	 *
	 * @type {HTMLImageElement}
	 */
	#image_element;

	/**
	 * Hero image initial transforms.
	 *
	 * @type {string}
	 */
	#image_element_initial_transforms;

	/**
	 * Hero video element.
	 *
	 * @type {HTMLVideoElement}
	 */
	#video_element;

	/**
	 * Hero title element.
	 *
	 * @type {HTMLElement}
	 */
	#title_element;

	/**
	 * Scroll offset before hero elements are blurred.
	 *
	 * @type {number}
	 */
	#blur_offset;

	/**
	 * Creates a new hero instance.
	 *
	 * @since 0.1.0
	 * @param {HTMLElement} element Header element.
	 * @param {Window}      scroll_container Scroll container.
	 * @param {number}      blur_offset Scroll offset before hero elements are blurred.
	 */
	constructor( element, scroll_container, blur_offset = 0 ) {
		this.#element                          = element;
		this.#scroll_container                 = scroll_container;
		this.#should_use_parallax_effect       = false;
		this.#image_element                    = this.#element.querySelector( '.hero__image' );
		this.#image_element_initial_transforms = '';
		this.#video_element                    = this.#element.querySelector( '.hero__video' );
		this.#title_element                    = this.#element.querySelector( '.hero__title' );
		this.#blur_offset                      = blur_offset;

		if ( this.#image_element ) {
			const transforms = getComputedStyle( this.#image_element ).transform.replace( 'none', '' );

			this.#image_element_initial_transforms = transforms.length > 0 ? transforms + ' ' : '';
		}

		if ( this.#image_element ?? this.#video_element ?? this.#title_element ) {
			this.toggle_parallax_scrolling_effect( ! navigator.userAgent.toLowerCase().includes( 'mobile' ) );
		}
	}

	/**
	 * Enables/disables parallax scrolling effect.
	 *
	 * @since 0.1.0
	 * @param {?boolean} active Whether to enable parallax effect.
	 */
	toggle_parallax_scrolling_effect( active ) {
		this.#should_use_parallax_effect = typeof active === 'boolean' ? active : ! this.#should_use_parallax_effect;

		this.#displace_elements_on_scroll();
	}

	/**
	 * Displaces the hero elements on scroll.
	 */
	#displace_elements_on_scroll() {
		this.#displace_elements( this.#should_use_parallax_effect ? this.#scroll_container.scrollY : 0 );

		if ( this.#should_use_parallax_effect ) {
			requestAnimationFrame( this.#displace_elements_on_scroll.bind( this ) );
		}
	}

	/**
	 * Displaces the hero elements based on the given offset.
	 *
	 * @param {number} offset Offset to displace the hero elements by.
	 */
	#displace_elements( offset ) {
		if ( this.#image_element ) {
			const blur = offset > this.#blur_offset ?
				Math.min( 5, ( offset - this.#blur_offset ) / 30 ) :
				0;

			this.#image_element.style.transform = `${this.#image_element_initial_transforms}translateY(${offset / 2}px)`;
			this.#image_element.style.filter = `blur(${blur}px)`;
		}

		if ( this.#video_element ) {
			this.#video_element.style.transform = `translate(-50%, calc(-50% + ${offset / 2}px))`;
		}

		if ( this.#title_element ) {
			this.#title_element.style.transform = `translateY(${offset / 3}px)`;
			this.#title_element.style.opacity = true ?
				Math.max( 0.5, 1 - ( offset - this.#blur_offset ) / 360 ) :
				1;
		}
	}
}

export default Hero;
