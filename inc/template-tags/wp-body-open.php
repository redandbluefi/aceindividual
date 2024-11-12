<?php
/**
 * Add wp_body_open() to the template.
 *
 * @package eternia
 */

namespace Eternia;

if ( ! function_exists( 'wp_body_open' ) ) {

	/**
	 *  Backwards compatibility for wp_body_open()
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}
