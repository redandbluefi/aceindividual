<?php
/**
 * Gutenberg related settings and hooks.
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Restricts available Gutenberg editor block types based on Eternia theme settings.
 *
 * @param array  $allowed_blocks Default allowed blocks.
 * @param object $editor_context The editor context.
 *
 * @return array $allowed_blocks Allowed blocks.
 */
function allowed_block_types( $allowed_blocks, $editor_context ) {
	if ( ! isset( THEME_SETTINGS['allowed_blocks'] ) || 'all' === THEME_SETTINGS['allowed_blocks'] ) {
		return $allowed_blocks;
	}

	// Add the default allowed blocks.
	$allowed_blocks = isset( THEME_SETTINGS['allowed_blocks']['default'] ) ? THEME_SETTINGS['allowed_blocks']['default'] : array();

	// If there is post type specific blocks, add them to the allowed blocks list.
	if ( isset( THEME_SETTINGS['allowed_blocks'][ $editor_context->post->post_type ] ) ) {
		$allowed_blocks = array_merge( $allowed_blocks, THEME_SETTINGS['allowed_blocks'][ $editor_context->post->post_type ] );
	}

	/**
	 * Allow all custom blocks by default. ACF will limit the blocks
	 * to the ones that are actually registered for each post type.
	 */
	if ( ETERNIA_BLOCKS ) {
		foreach ( ETERNIA_BLOCKS as $block_slug ) {
			$allowed_blocks[] = 'acf/' . $block_slug;
		}
	}

	return $allowed_blocks;
} // end allowed_block_types.

/**
 * Determine whether to use classic or block editor for a certain post type, as defined in the theme settings
 *
 * @param string $post_type Post type to check against classic editor array.
 * @return bool Whether to use block editor or not.
 */
function use_block_editor_for_post_type( $post_type ) {
	if ( in_array( $post_type, THEME_SETTINGS['use_classic_editor'], true ) ) {
		return false;
	}

	return true;
} // end use_block_editor_for_post_type.

/**
 * Enqueue block editor JavaScript and CSS
 */
function register_block_editor_assets() {

	// Dependencies.
	$dependencies = array(
		'wp-blocks',      // Provides useful functions and components for extending the editor.
		'wp-i18n',        // Provides localization functions.
		'wp-element',     // Provides React.Component.
		'wp-components',  // Provides many prebuilt components and controls.
	);

	// Enqueue the bundled block JS file.
	wp_enqueue_script(
		'block-editor-js',
		get_theme_file_uri( get_asset_file( 'gutenberg-editor.js' ) ),
		$dependencies,
		filemtime( dirname( __DIR__, 2 ) . '/' . get_asset_file( 'gutenberg-editor.js' ) ),
		'all'
	);

	// Enqueue editor styles.
	wp_enqueue_style(
		'block-editor-styles',
		get_theme_file_uri( get_asset_file( 'editor.css' ) ),
		array(),
		filemtime( dirname( __DIR__, 2 ) . '/' . get_asset_file( 'editor.css' ) ),
		'all',
		true
	);
} // end register_block_editor_assets

/**
 * Removes Gutenberg inline "Normalization styles" like .editor-styles-wrapper h1
 *
 * @param array  $editor_settings Default editor settings.
 * @param object $editor_context  The editor context.
 *
 * @return array $editor_settings Possibly modified editor settings.
 */
function remove_gutenberg_inline_styles( $editor_settings, $editor_context ) {
	if ( ! empty( $editor_context->post ) ) {
		unset( $editor_settings['styles'][0]['css'] );
	}

	return $editor_settings;
} // end remove_gutenberg_inline_styles
