<?php
/**
 * Callbacks related to disabling emojis in WordPress.
 *
 * @package eternia
 */

 namespace Eternia\Inc\Hooks\DisableEmojis;

/**
 * Disable emojis that are loaded with wp hooks.
 * - Removes all hooks that are loading emojis by default.
 */
function disable_wp_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}

/**
 * Disable tinymce plugin(s) related to emojis.
 *
 * @param array $plugins Array of tinymce plugins.
 * @return array Modified array of tinymce plugins.
 */
function disable_tinymce_emojis( array $plugins = array() ): array {
	return array_diff( $plugins, array( 'wpemoji' ) );
}
