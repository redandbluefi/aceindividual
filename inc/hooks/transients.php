<?php
/**
 * Transients related callbacks. Use this for example for clearing transients.
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Delete singular breadcrumb transient(s) or any of its translations when post is updated.
 *
 * @param int      $post_id Post ID.
 * @param \WP_Post $post Post object.
 * @param bool     $update Whether this is an existing post being updated or not.
 */
function delete_breadcrumb_transients_on_post_change( $post_id, $post, $update ) {
	// Apply only when post is updated.
	if ( ! $update ) {
		return;
	}

	$post_translations = function_exists( 'pll_get_post_translations' ) ? \pll_get_post_translations( $post_id ) : array( $post_id );

	foreach ( $post_translations as $post_translation_id ) {
		$breadcrumb_transient_key = 'rnb-br_single_' . $post_translation_id;
		if ( false !== get_transient( $breadcrumb_transient_key ) ) {
			delete_transient( $breadcrumb_transient_key );
		}
	}
}

/**
 * Delete taxonomy term (archive) breadcrumb transient(s) or any of its translations when term is updated.
 *
 * @param int    $term_id Term ID.
 * @param int    $tt_id Term taxonomy ID.
 * @param string $taxonomy Taxonomy slug.
 * @param bool   $update Whether this is an existing term being updated or not.
 */
function delete_breadcrumb_transients_on_term_change( int $term_id, int $tt_id, string $taxonomy, bool $update ) {
	// Apply only when term is updated.
	if ( ! $update ) {
		return;
	}

	$term_translations = function_exists( 'pll_get_term_translations' ) ? \pll_get_term_translations( $term_id ) : array( $term_id );

	foreach ( $term_translations as $term_translation_id ) {
		$breadcrumb_transient_key = 'rnb-br_term_' . $term_translation_id;
		if ( false !== get_transient( $breadcrumb_transient_key ) ) {
			delete_transient( $breadcrumb_transient_key );
		}
	}
}

/**
 * Delete cache for blocks found on saved post.
 *
 * Ran on post type specific hooks so no need to check here.
 *
 * @param int      $post_id Post ID.
 * @param \WP_Post $post Post object.
 * @param bool     $update Whether this is an existing post being updated or not.
 */
function delete_block_cache_on_post_change( $post_id, $post, $update ) {
	// Can't be cached if just created.
	if ( ! $update ) {
		return;
	}

	$redis_keys = get_post_block_cache_keys( $post_id );

	$deleted_transients_count = delete_redis_cache_items( $redis_keys );

	if ( $deleted_transients_count > 0 ) {
		write_log( 'Purged ' . $deleted_transients_count . ' block caches on post ' . $post_id . ' update.', ETERNIA_CACHE_LOG );
	}
}

/**
 * Trigger a cache purge for specific blocks,
 * when post type associated gets an update.
 *
 * @param int      $post_id Post ID.
 * @param \WP_Post $post Post object.
 */
function purge_post_type_dependent_block_caches( $post_id, $post ) {
	// Post type dependency is defined in block.json and added to filter on block-registration.
	$blocks_to_purge = apply_filters( 'eternia_blocks_to_purge_on_post_type_update', array() );

	foreach ( $blocks_to_purge as $block_slug => $post_types ) {
		if ( in_array( $post->post_type, $post_types, true ) ) {
			$redis_keys = get_block_cache_keys( $block_slug );

			$deleted_transients_count = delete_redis_cache_items( $redis_keys );

			if ( $deleted_transients_count > 0 ) {
					write_log( 'Purged ' . $deleted_transients_count . ' post-type dependent block caches on ' . $post->post_type . ' update.', ETERNIA_CACHE_LOG );
			}
		}
	}
}

/**
 * Purge transients when post type is updated.
 *
 * @param int      $post_id Post ID.
 * @param \WP_Post $post Post object.
 */
function purge_post_type_dependent_transients( $post_id, $post ) {
	$transient_prefixes = apply_filters( 'eternia_transient_prefixes_to_purge_on_post_type_update', array() );

	foreach ( $transient_prefixes as $transient_prefix => $post_types ) {
		if ( in_array( $post->post_type, $post_types, true ) ) {
			$redis_keys = get_transient_cache_keys( $transient_prefix );

			$deleted_transients_count = delete_redis_cache_items( $redis_keys );

			if ( $deleted_transients_count > 0 ) {
				write_log( 'Purged ' . $deleted_transients_count . ' post-type dependent transients on ' . $post->post_type . ' update.', ETERNIA_CACHE_LOG );
			}
		}
	}
}

/**
 * Define the transients to purge when a post type is updated.
 *
 * @param array $transients Array of transients to purge.
 * @return array $transients Array of transients to purge.
 *  - 'transient_prefix' => array( 'post_type_1', 'post_type_2' ).
 */
function define_transient_prefixes_to_purge_on_post_type_update( $transients ) {
	// Define the transients to purge when a post type is updated.
	// Array of key-value pairs where key is the transient prefix and value is an array of post types.
	$added_transients = array();

	return array_merge( $transients, $added_transients );
}
