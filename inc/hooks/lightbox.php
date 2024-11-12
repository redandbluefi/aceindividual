<?php
/**
 * Lightbox related hooks.
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Add lightbox dialog to the site body.
 *
 * @return void
 */
function add_lightbox_dialog() {
	get_template_part( 'template-parts/components/lightbox' );
} // end add_lightbox_dialog
