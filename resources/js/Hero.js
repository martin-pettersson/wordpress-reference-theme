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
	 * Scroll semaphore.
	 *
	 * This is used in combination with requestAnimationFrame to optimize
	 * scrolling.
	 *
	 * @type {boolean}
	 */
	#scroll_semaphore;

	/**
	 * Hero image element.
	 *
	 * @type {HTMLImageElement}
	 */
	#image_element;

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
	 * Reference to the displace_elements_on_scroll method.
	 *
	 * We need to pass the same method instance when removing the event listener
	 * and since the method is bound we need to save a reference to it.
	 *
	 * @type {Function}
	 */
	#displace_elements_on_scroll_reference;

	/**
	 * Creates a new hero instance.
	 *
	 * @since 0.1.0
	 * @param {HTMLElement} element Header element.
	 * @param {Window}      scroll_container Scroll container.
	 * @param {number}      blur_offset Scroll offset before hero elements are blurred.
	 */
	constructor( element, scroll_container, blur_offset = 0 ) {
		this.#element                               = element;
		this.#scroll_container                      = scroll_container;
		this.#scroll_semaphore                      = false;
		this.#image_element                         = this.#element.querySelector( '.hero__image' );
		this.#video_element                         = this.#element.querySelector( '.hero__video' );
		this.#title_element                         = this.#element.querySelector( '.hero__title' );
		this.#blur_offset                           = blur_offset;
		this.#displace_elements_on_scroll_reference = this.#displace_elements_on_scroll.bind( this );

		if ( this.#image_element ?? this.#video_element ?? this.#title_element ) {
			this.toggle_parallax_scrolling_effect( ! navigator.userAgentData?.mobile );
		}
	}

	/**
	 * Enables/disables parallax scrolling effect.
	 *
	 * @since 0.1.0
	 * @param {boolean} active Whether to enable parallax effect.
	 */
	toggle_parallax_scrolling_effect( active = true ) {
		const action = active ? 'addEventListener' : 'removeEventListener';

		this.#scroll_container[ action ](
			'scroll',
			this.#displace_elements_on_scroll_reference,
			{
				capture: true,
				passive: true
			}
		);
		this.#displace_elements( active ? this.#scroll_container.scrollY : 0 );
	}

	/**
	 * Displaces the hero elements on scroll.
	 */
	#displace_elements_on_scroll() {
		if ( this.#scroll_semaphore ) {
			return;
		}

		requestAnimationFrame( () => {
			this.#displace_elements( this.#scroll_container.scrollY );

			this.#scroll_semaphore = false;
		} );

		this.#scroll_semaphore = true;
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

			this.#image_element.style.backgroundPositionY = `calc(50% + ${offset / 2}px)`;
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
