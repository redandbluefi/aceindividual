<?php
/**
 * Block anchor link helper function
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Adds a block anchor link if such is defined in the editor's advanced block settings.
 *
 * @param array  $block - the block array. This is automatically included on all blocks.
 * @param string $prefix - optional prefix for the ID attribute. Does not contain separator character.
 * @return string - HTML id attribute declaration and value, or false if no ID was found.
 *
 * @package eternia;
 */
function get_block_anchor_link( $block, string $prefix = '' ) {

	if ( ! isset( $block['anchor'] ) || empty( $block['anchor'] ) ) {
		return false;
	}

	ob_start();

	echo 'id="';
	if ( ! empty( $prefix ) ) {
		echo esc_attr( $prefix );
	}
	echo esc_attr( $block['anchor'] );
	echo '"';

	return ob_get_clean();
}
