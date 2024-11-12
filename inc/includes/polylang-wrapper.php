<?php
/**
 * Eternia's own functions for showing translated strings with Polylang or fallback to not translated one if Polylang is not installed
 *
 * @link https://stackoverflow.com/questions/46557981/polylang-how-to-translate-custom-strings
 * See inc/includes/polylang-register-strings.php for more info about registering strings
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Returns translated string if Polylang exists or output's not translated one as a fallback
 * Remember to always escape output with esc_html(), esc_attr() or similar
 *
 * @param string $string_to_translate Matches Polylang's pll_register_string.
 * @param string $context Matches Polylang's pll_register_string.
 * @param string $group Matches Polylang's pll_register_string textdomain.
 *
 * @return string string, translated if Polylang exists or unodified if Polylang isn't installed.
 */
function translate__( $string_to_translate = '', $context = '', $group = '' ) { // phpcs:ignore
	if ( function_exists( 'pll__' ) ) {
		return pll__( $string_to_translate );
	}
	return $string_to_translate;
} // end translate__()
