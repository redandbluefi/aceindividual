<?php
/**
 * Create image sizes based on the theme settings.
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Registers image sizes based on the theme settings.
 */
function image_sizes() {
	if ( ! is_array( THEME_SETTINGS['image_sizes'] ) || ! THEME_SETTINGS['image_sizes'] ) {
		return;
	}
	foreach ( THEME_SETTINGS['image_sizes'] as $arrays ) {
		add_image_size( $arrays['name'], $arrays['width'], $arrays['height'], $arrays['crop'] );
	}
} // end image_sizes
