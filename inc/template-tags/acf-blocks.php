<?php
/**
 * ACF Blocks
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Callback function for ACF block registration.
 *
 * @param array   $block Block data.
 * @param string  $content Block content.
 * @param boolean $is_preview Define if block is in preview mode. False if not.
 * @param int     $post_id Post ID.
 * @return void
 */
function render_acf_block( $block, $content = '', $is_preview = false, $post_id = 0 ) {

	// TODO: Block JSON way does not currently support preview image mode, but might render dynamically.
	// If in preview mode & image is set, render only the image and escape early.
	if ( $is_preview && add_acf_preview_image( $block ) ) {
		echo wp_kses_post( add_acf_preview_image( $block ) );
		return;
	}

	$block_slug = str_replace( 'acf/', '', $block['name'] );
	$block_path = dirname( __DIR__, 2 ) . "/acf-blocks/{$block_slug}/{$block_slug}.php";

	// Always bypass cache if is preview from editor or in development phase.
	$cache_mode          = $block['eternia']['cache']['mode'] ?? 'general';
	$dev_env             = 'development' === wp_get_environment_type() ? true : false;
	$block_cache_enabled = ( 'off' === $cache_mode || $dev_env || $is_preview ) ? false : true;
	$user_specific_cache = 'user' === $cache_mode;

	/**
	 * Make cache key for this block.
	 *
	 * Block ID is always unique per block.
	 *
	 * Use crc32 hash (it's quickest to calculate) as additional
	 * way to identify blocks, but also as an way to burst the
	 * block cache when contents are updated.
	 */
	$content_hash = crc32( serialize( get_fields() ) ); // phpcs:ignore

	$current_username = wp_get_current_user() ? wp_get_current_user()->ID : '0';
	$cache_key        = $user_specific_cache ?
							"post_{$post_id}_{$block['id']}_user_{$current_username}|{$content_hash}" :
							"post_{$post_id}_{$block['id']}|{$content_hash}";

	// Get block contents.
	if ( ! $block_cache_enabled ) {
		$block_output = load_acf_block( $block_path, false, $block, $is_preview );
	} else {
		$block_output = load_acf_block_from_cache( $cache_key, $block_slug, $block_path, $block, $is_preview, $post_id );
	}

	// Output block contents (this is safe unescaped).
  echo $block_output; // phpcs:ignore
} // end render_acf_block

/**
 * Load block data from cache.
 *
 * @param string  $cache_key Cache key.
 * @param string  $block_slug Block slug.
 * @param string  $block_path Block path.
 * @param array   $block Block data.
 * @param boolean $is_preview Define if block is in preview mode. False if not.
 * @param int     $post_id Post ID.
 * @return string Block contents.
 */
function load_acf_block_from_cache( $cache_key, $block_slug, $block_path, $block, $is_preview = false, $post_id = 0 ) {
	// Block can be cached, try to find it is already in cache.
	$output = \wp_cache_get( $cache_key, 'theme' );

	if ( $output ) {
		return $output;
	}

	// Block is not found in cache, load block content.
	$output = load_acf_block( $block_path, true, $block, $is_preview );

	// Save block to cache.
	\wp_cache_set( $cache_key, $output, 'theme', apply_filters( 'eternia_acf_block_cache_lifetime', HOUR_IN_SECONDS, $block_slug, $post_id ) );

	return $output;
} // end load_acf_block_from_cache

/**
 * Load block contents.
 *
 * @param string  $block_path Block path.
 * @param boolean $cache Define if block should be cached. False if not.
 * @param array   $block Block data.
 * @param boolean $is_preview   Define if block is in preview mode. False if not.
 * @return string Block contents.
 */
function load_acf_block( $block_path, $cache = false, $block = array(), $is_preview = false ) {
	$output_callback = $cache ? 'ob_gzhandler' : null;

	/**
	 * Check if it's allowed to show this block in this context.
	 * Always allow in preview mode.
	 *
	 * This might happen when we build a reusable block in a page and
	 * then add that reusable block to post
	 */
	if ( ! $is_preview ) {
		$post_type = get_post_type();
		if ( $post_type && 'wp_block' !== $post_type && is_array( $block['post_types'] ) && ! in_array( $post_type, $block['post_types'], true ) ) {
			return '';
		}
	}

	// Validate that file actually exists.
	if ( ! \file_exists( $block_path ) ) {
		// phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores
		\do_action( 'qm/error', "Block file {$block_path} not found" );
		return '';
	}

	// Get and return block contents.
	\ob_start( $output_callback );
	include $block_path;
	$content = \ob_get_clean();

	if ( ! $is_preview && isset( $block['anchor'] ) && ! empty( $block['anchor'] ) ) {
		$content = str_replace( '<section class="block', '<section id="' . $block['anchor'] . '" class="block', $content );
	}

	return $content;
} // end load_acf_block(

/**
 * Show error block if user is allowed to see error blocks.
 *
 * @param string $message Error message to be shown.
 * @param mixed  $title Set to false to show default title, a string for block title or an empty string to hide the title.
 */
function maybe_show_error_block( $message, $title = false ) {
	if ( ! current_user_can( 'edit_posts' ) ) {
		return;
	}

	if ( false === $title ) {
		$title = get_default_localization( 'Block missing required data' );
	}
	?>
	<div class="block block-error">
	<div class="container">
		<?php if ( ! empty( $title ) ) : ?>
		<h2><?php echo esc_html( $title ); ?></h2>
		<?php endif; ?>

		<?php if ( ! empty( $message ) ) : ?>
		<p class="error-message"><?php echo wp_kses_post( $message ); ?></p>
		<?php endif; ?>

		<p class="info"><?php echo esc_html( get_default_localization( 'This error is shown only for logged in users' ) ); ?></p>
	</div>
	</div>
	<?php
}
