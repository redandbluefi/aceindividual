<?php
/**
 * Set up the theme based on theme settings array.
 *
 * @package eternia
 **/

namespace Eternia;

/**
 * Reads the array constant THEME_SETTINGS, and sets up the theme accordingly.
 */
function theme_setup() {

	/**
	 * Register menu locations
	 */

	register_nav_menus( THEME_SETTINGS['menu_locations'] );

	/**
	 * Load textdomain.
	 */
	load_theme_textdomain( THEME_SETTINGS['textdomain'], get_template_directory() . '/lang' );

	/**
	 * Define content width in articles
	 */
	if ( ! isset( $content_width ) ) {
		$content_width = THEME_SETTINGS['content_width'];
	}

	/**
	 * Hide ACF fields from live site for every other user than admin or Super Admin.
	 * Admin user can now update ACF fields on live site.
	 *
	 * @param  boolean $show Show ACF fields to admin only.
	 */
	if ( isset( $_SERVER['SERVER_NAME'] ) && THEME_SETTINGS['prod_url'] === $_SERVER['SERVER_NAME'] ) :
		add_filter(
			'acf/settings/show_admin',
			// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
			function ( $show ) {
				return is_admin() && current_user_can( 'manage_options' );
			}
		);
	endif;

	// Run the rest of the setup.
	build_taxonomies();
	build_post_types();
} // end theme_setup

/**
 * Check is constant ICL_LANGUAGE_CODE defined, a.k.a. is Polylang (or WPML) installed.
 * If not, set ICL_LANGUAGE_CODE to 'fi' or 'en'.
 */
if ( ! defined( 'ICL_LANGUAGE_CODE' ) ) :
	if ( get_locale() === 'fi' ) :
		define( 'ICL_LANGUAGE_CODE', 'fi' );
	else :
		define( 'ICL_LANGUAGE_CODE', 'en' );
	endif;
endif;

/**
 * Add posibility to add SVG files
 * If needed re-write function and add checks to make svg upload secure
 */

/*
Disabled for now, not used for every project.

add_filter('upload_mimes', function ($file_types) {
	$new_filetypes = array();
	$new_filetypes['svg'] = 'image/svg+xml';
	$file_types = array_merge($file_types, $new_filetypes);
	return $file_types;
});
*/

// Disable comments from the backend.
add_action(
	'admin_init',
	function () {
		// Redirect any user trying to access comments page.
		global $pagenow;

		if ( 'edit-comments.php' === $pagenow ) {
			wp_safe_redirect( admin_url() );
			exit;
		}
		// Remove comments metabox from dashboard.
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );

		// Disable support for comments and trackbacks in post types.
		foreach ( get_post_types() as $post_type ) {
			if ( post_type_supports( $post_type, 'comments' ) ) {
				remove_post_type_support( $post_type, 'comments' );
				remove_post_type_support( $post_type, 'trackbacks' );
			}
		}
	}
);

// Close comments on the front-end.
add_filter( 'comments_open', '__return_false', 20, 2 );
add_filter( 'pings_open', '__return_false', 20, 2 );

// Remove comments page in menu.
add_action(
	'admin_menu',
	function () {
		remove_menu_page( 'edit-comments.php' );
	}
);

// Remove comments links from admin bar.
add_action(
	'init',
	function () {
		if ( is_admin_bar_showing() ) {
			remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
		}
	}
);

/**
 * Build custom taxonomies.
 *
 * @return void|string Returns error if taxonomy class file does not exist or does not have a class to instance, else void.
 */
function build_taxonomies() {
	if ( ! is_array( THEME_SETTINGS['taxonomies'] ) || ! THEME_SETTINGS['taxonomies'] ) {
		return;
	}

	foreach ( THEME_SETTINGS['taxonomies'] as $name => $post_types ) {
		$slug = strtolower( $name );

		$classname = __NAMESPACE__ . '\\' . $name;
		$file_path = dirname( __DIR__ ) . '/taxonomies/' . str_replace( '_', '-', $slug ) . '.php';

		if ( ! file_exists( $file_path ) ) {
			return new \WP_Error( 'invalid-taxonomy', translate__( 'The taxonomy class file does not exist.', '', 'eternia' ), $classname );
		}
		require $file_path;

		if ( ! class_exists( $classname ) ) {
			return new \WP_Error( 'invalid-taxonomy', translate__( 'The taxonomy you attempting to create does not have a class to instance. Possible problems: your configuration does not match the class file name; the class file name does not exist.', '', 'eternia' ), $classname );
		}

		$taxonomy_class = new $classname( $slug );
		$taxonomy_class->register( $post_types );
	}
} // end build_taxonomies

/**
 * Build theme post types
 *
 * @return void|string Returns error if the custom post tyle class file does not exist or does not have a class to instance, else void.
 */
function build_post_types() {
	if ( ! is_array( THEME_SETTINGS['post_types'] ) || ! THEME_SETTINGS['post_types'] ) {
		return;
	}

	foreach ( THEME_SETTINGS['post_types'] as $name ) {
		$slug = strtolower( $name );

		$classname = __NAMESPACE__ . '\\' . $name;
		$file_path = dirname( __DIR__ ) . '/post-types/' . str_replace( '_', '-', $slug ) . '.php';

		if ( ! file_exists( $file_path ) ) {
			return new \WP_Error( 'invalid-cpt', translate__( 'The custom post type class file does not exist.', '', 'eternia' ), $classname );
		}
		// Get the class file.
		require $file_path;

		if ( ! class_exists( $classname ) ) {
			return new \WP_Error( 'invalid-cpt', translate__( 'The custom post type you attempting to create does not have a class to instance. Possible problems: your configuration does not match the class file name; the class file name does not exist.', '', 'eternia' ), $classname );
		}

		$post_type_class = new $classname( $slug );
		$post_type_class->register();
	}
} // end build_post_types

/**
 * Build theme support.
 */
function build_theme_support() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style',
		)
	);
} // end build_theme_support

/**
 * List the Polylang translatable CPTs.
 *
 * @param  array $post_types The array of post type names.
 * @param  bool  $is_settings True when displaying the list of custom post types in Polylang settings (avoid the user to modify the decision made by the plugin author for a post type).
 * @return array $post_types The array of post type names to translate.
 */
function add_cpt_to_pll( $post_types, $is_settings ) {
	if ( $is_settings ) {
		// Hide CPTs from the list of custom post types in Polylang settings.
		$post_types['video'] = 'video';
	} else {
		// Add CPTs to the list of custom post types in Polylang settings, even when not set to public.
		$post_types['video'] = 'video';
	}

	return $post_types;
} // end add_cpt_to_pll
