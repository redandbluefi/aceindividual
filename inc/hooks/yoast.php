<?php
/**
 * Yoast SEO plugin related hooks
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Move Yoast SEO metabox to bottom
 *
 * The Yoast metabox gets often in the way,
 * and holds less priority to content managers
 * than content related metaboxes.
 *
 * @return string The priority of the Yoast metabox.
 */
function move_yoast_to_bottom() {
	return 'low';
} // end move_yoast_to_bottom
