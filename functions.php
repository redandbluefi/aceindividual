<?php
/**
 * Gather all bits and pieces together.
 * If you end up having multiple post types, taxonomies,
 * hooks and functions - please split those to their
 * own files under /inc and just require here.
 *
 * @package eternia
 */

namespace Eternia;

/** Exit early if no ACF */
if ( ! is_admin() && ! defined( 'WP_CLI' ) && ! function_exists( 'get_field' ) ) {
	wp_die( '<p style="font-size:2dvw;text-align:center;">Missing ACF! Install it first!</p>', 'Missing ACF' );
	exit;
}

/**
 * Required files
 */
require_once __DIR__ . '/inc/theme-settings.php';
add_action( 'after_setup_theme', __NAMESPACE__ . '\theme_settings' );
require_once __DIR__ . '/inc/hooks.php';
require_once __DIR__ . '/inc/includes.php';
require_once __DIR__ . '/inc/template-tags.php';

// Run theme setup.
add_action( 'init', __NAMESPACE__ . '\theme_setup' );
add_action( 'after_setup_theme', __NAMESPACE__ . '\build_theme_support' );
