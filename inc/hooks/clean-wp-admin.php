<?php
/**
 * Cleans some usually unnecessary features from Admin.
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Hide updates button from admin top bar.
 */
function hide_updates_button() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu( 'updates' );
}

/**
 * Hide comments button from admin top bar.
 */
function hide_comments_button() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu( 'comments' );
}
