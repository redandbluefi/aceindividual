<?php
/**
 * Functions related to utilising the Redis cache.
 *
 * Our production environments use Redis as a cache solution,
 * which means some of the WP object cache functions are
 * not enough to effectively control the caching.
 *
 * The Redis class referenced here is phpredis. It is enabled in
 * Seravo enviroments by default.
 *
 * @link https://github.com/phpredis/phpredis
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Scan and return all keys that match pattern.
 *
 * Improved version of redis_find_keys,
 * which uses SCAN instead of KEYS.
 *
 * While KEYS will run through all available keys in
 * the database, SCAN does so in minor fragments,
 * which is much more efficient as the redis thread
 * is not blocked for the whole duration of the operation.
 *
 * @link https://redis.io/commands/scan
 *
 * @param string $pattern The pattern to search for. Default is wildcard for all keys.
 * @return array Array of keys, empty if none were found.
 */
function redis_scan_keys( $pattern = '*' ) {

	$result = array();

	if ( class_exists( 'Redis' ) ) {
		$redis = new \Redis();
		$redis->connect( '127.0.0.1', 6379 );
		$redis->setOption( \Redis::OPT_SCAN, \Redis::SCAN_RETRY );
		$iterator = null;

		$result = array();

    // phpcs:ignore Generic.CodeAnalysis.AssignmentInCondition.FoundInWhileCondition
		while ( $keys = $redis->scan( $iterator, $pattern ) ) {
			$result = array_merge( $result, $keys );
		}

		return $result;
	}

	return (array) $result;
}

/**
 * Adds the group and possibly blog ID to the Redis key prefix.
 *
 * @param string $group Group name.
 * @return string Redis key prefix.
 */
function get_redis_prefix( $group = 'theme' ) {

	$prefix       = is_multisite() ? get_current_blog_id() . ':wp:' : 'wp:';
	$group_prefix = $group . ':';

	return $prefix . $group_prefix;
}

/**
 * Get all cache keys for a specific transient prefix.
 *
 * @param string $transient_prefix Transient prefix.
 * @return array Array of keys.
 */
function get_transient_cache_keys( $transient_prefix ) {
	$prefix = get_redis_prefix() . $transient_prefix . '*';

	$keys = redis_scan_keys( $prefix );

	return $keys;
}

/**
 * Get all cache keys for a specific post.
 *
 * @param int    $post_id Post ID.
 * @param string $block_slug Block slug with namespace. 'acf/block-slug' & 'acf/' both valid.
 * @return array Array of keys.
 */
function get_post_block_cache_keys( $post_id, $block_slug = false ) {

	$prefix = get_redis_prefix();

	$prefix .= 'post_' . $post_id . '*';

	if ( $block_slug ) {
		$prefix .= '_' . $block_slug . '*';
	}

	$keys = redis_scan_keys( $prefix );

	return $keys;
}

/**
 * Get all cache keys for a specific block.
 *
 * @param string $block_slug Block slug with namespace. 'acf/block-slug' & 'acf/' both valid.
 * @return array Array of keys.
 */
function get_block_cache_keys( $block_slug ) {

	$prefix = get_redis_prefix();

	$prefix .= 'post_*_'; // Post wildcard. Any post is fetched.

	$prefix .= $block_slug . '*';

	$keys = redis_scan_keys( $prefix );

	return $keys;
}

/**
 * Delete redis cache items with given keys.
 *
 * @param array $redis_keys Array of redis keys to delete.
 * @return int Number of deleted cache items.
 */
function delete_redis_cache_items( array $redis_keys ) {
	$deleted_transients_count = array_reduce(
		$redis_keys,
		function ( $carry, $redis_key ) {
			$redis_key          = str_replace( get_redis_prefix(), '', $redis_key );
			$cache_item_deleted = wp_cache_delete( $redis_key, 'theme' );
			return $carry + intval( $cache_item_deleted );
		},
		0
	);

	return $deleted_transients_count;
}
