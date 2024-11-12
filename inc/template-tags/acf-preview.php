<?php
/**
 * Helper functions related to ACF block inserter preview.
 *
 * @link https://www.advancedcustomfields.com/resources/acf_register_block_type/#settings
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Renders a preview image for the block, if found.
 *
 * @param array $block - the block array. This is automatically included on all blocks.
 * @return string|false - the preview image HTML, or false if not found.
 *
 * @package eternia;
 */
function add_acf_preview_image( $block ) {

	if ( ! isset( $block['data']['preview_image_help'] ) ) {
		return false;
	}

	ob_start();
	echo wp_kses_post( $block['data']['preview_image_help'] );
	return ob_get_clean();
}

/**
 * Determine if ACF is running in preview mode.
 *
 * The preview mode is used to draw block preview in the block inserter.
 * It can be a static image, or we can draw the block on the fly by
 * providing example data (or strong enough defaults for block to always render).
 *
 * @param array $block - the block array. This is automatically included on all blocks.
 * @return bool - true if ACF is running in preview mode.
 */
function is_acf_block_preview_mode( $block ) {
	return isset( $block['mode'] ) && 'preview' === $block['mode'];
}
