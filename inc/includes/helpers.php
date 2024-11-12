<?php
/**
 * Helper functions.
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Function for getting first taxonomy term object.
 *
 * @param int    $post_id Post ID.
 * @param string $taxonomy_name Taxonomy name.
 * @return object Main taxonomy object.
 */
function rnb_get_first_term_object( $post_id, $taxonomy_name ) {
	global $wp_taxonomies;
	// check if taxonomy exists.
	$taxonomy_exist = get_taxonomy( $taxonomy_name );
	// if taxonomy does not exist, return empty string.
	if ( false === $taxonomy_exist ) {
		return '';
	} else {
		// get terms.
		$terms = wp_get_post_terms( $post_id, $taxonomy_name, array( 'fields' => 'all' ) );
		// check if yoast is active and get primary term id and primary term object.
		$primary_term_object = '';
		if ( function_exists( 'yoast_get_primary_term_id' ) ) {
			$primary_term_id = yoast_get_primary_term_id( $taxonomy_name, $post_id ) ?? '';
			if ( $primary_term_id ) {
				$primary_term_object = get_term( $primary_term_id, $taxonomy_name );
			}
		}
		// return primary term if it exists, otherwise return first term.
		if ( $primary_term_object ) {
			return $primary_term_object;
		} else {
			return $terms ? $terms[0] ?? '' : '';
		}
	}
}

/**
 * Function for getting current language option.
 *
 * @return string Language option.
 * If Polylang is active but no language is set, return 'option_'.
 * If Polylang is active, return 'option_' + current language slug.
 * If Polylang is not active, return 'option_' + current locale.
 */
function get_default_lang_option() {

	if ( is_plugin_active( 'polylang/polylang.php' ) && ! function_exists( 'pll_current_language' ) ) {
		return 'option_';
	} else {
		return function_exists( 'pll_current_language' ) ? 'option_' . pll_current_language( 'slug' ) : 'option_' . get_locale();
	}
}
