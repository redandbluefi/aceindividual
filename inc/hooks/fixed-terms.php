<?php
/**
 * THEME_SETTINGS['fixed_terms'] contains an array of terms and their names/slugs and here we can create them.
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Register fixed terms on init.
 */
function register_fixed_terms_from_array() {

	if ( ! isset( THEME_SETTINGS['fixed_terms'] ) ) {
		return;
	}

	foreach ( THEME_SETTINGS['fixed_terms'] as $taxonomy => $terms ) {
		foreach ( $terms as $term ) {
			// Register fixed term if it doesn't exist already.
			if ( taxonomy_exists( $taxonomy ) && ! term_exists( $term['slug'], $taxonomy ) ) {
				$term_id = wp_insert_term(
					$term['name'],
					$taxonomy,
					array(
						'description' => $term['description'],
						'slug'        => $term['slug'],
					)
				);

				if ( isset( $term['lang'] ) ) {
					$lang = $term['lang'];
				} else {
					$lang = 'fi';
				}

				if ( function_exists( 'pll_the_languages' ) ) {
					pll_set_term_language( $term_id, $lang );
				}

				// Add custom class to the created term.
				if ( $term_id && is_wp_error( $term_id ) === false ) {
					add_term_meta( $term_id['term_id'], 'term_is_fixed', 'delete_not_possible' );
				}
			}
		}
	}
} // end register_fixed_terms_from_array

/**
 * Remove delete button from fixed terms in admin.
 *
 * @param  string  $actions The action that user can do in admin.
 * @param  wp_term $tag This contains the term data.
 * @return $actions Here we return the modified action.
 */
function remove_delete_button_from_term_in_admin( $actions, $tag ) {
	// Replace 'custom_meta_key' and 'some_value' with your actual meta key and value conditions.
	$meta_key   = 'term_is_fixed';
	$meta_value = 'delete_not_possible';

	// Get the term meta value for the specified term.
	$term_meta_value = get_term_meta( $tag->term_id, $meta_key, true );

	// Check if the term meta value meets your condition.
	if ( $term_meta_value === $meta_value ) {
		// If the condition is met, remove the "Delete" action from the actions array.
		unset( $actions['delete'] );
	}

	return $actions;
} // end remove_delete_button_from_term_in_admin
