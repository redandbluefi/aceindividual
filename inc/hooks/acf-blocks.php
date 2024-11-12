<?php
/**
 * Hooks related to blocks created with ACF - Advanced Custom Fields -plugin.
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Add a new block category for ACF blocks.
 *
 * @param  array $categories Default categories.
 * @param  array $post       Post object.
 * @return array             Categories with "Theme blocks" -category added.
 */
function add_block_categories( $categories, $post ) { // phpcs:ignore
	return array_merge(
		$categories,
		array(
			array(
				'slug'  => 'eternia',
				'title' => translate__( 'Theme blocks', '', 'eternia' ),
			),
		)
	);
} // end add_block_categories

/**
 * Modernized block registration.
 *
 * Ensures the existence of block.json files in the theme directory,
 * and registers blocks found with WordPress internal block registration
 * functionality.
 *
 * @return void
 */
function register_eternia_blocks() {

	$block_directory = '/acf-blocks';
	// Each block has a folder beneath the block directory, and a block.json file within.

	// Get all block JSON files.
	$block_json_files = glob( get_template_directory() . $block_directory . '/*/block.json' );

	if ( ! is_array( $block_json_files ) || empty( $block_json_files ) ) {
		return;
	}

	// Construct an array with blocks name as a key, and block array as value.
	$blocks = array_reduce(
		$block_json_files,
		function ( $carry, $block_file ) {
			ob_start();
			require $block_file;
			$json_file = ob_get_clean();
			$block     = json_decode( $json_file, true );
			if ( isset( $block['name'] ) ) {
				$carry[ $block['name'] ] = $block;
			}
			return $carry;
		},
		array()
	);

	foreach ( $blocks as $block ) {
		/**
		 * The block registration.
		 *
		 * We could send the block contents here.
		 */
		$slug                = $block['name'];
		$slug_without_prefix = str_replace( 'acf/', '', $slug );
		$block_json_location = get_template_directory() . $block_directory . '/' . $slug_without_prefix;

		// If block's cache is dependent on post type, add it to filter. Dependency is defined on block.json Eternia API ['cache']['post_types'].
		if ( ! empty( $block['eternia']['cache']['post_types'] ) ) {
			add_filter(
				'eternia_blocks_to_purge_on_post_type_update',
				function ( $blocks ) use ( $slug, $block ) {
					$blocks[ $slug ] = $block['eternia']['cache']['post_types'];
					return $blocks;
				}
			);
		}

		register_block_type( $block_json_location );
	}
}

/**
 * Handle Eternia block API.
 *
 * Reads extra keys set in Block JSON and registers them for the
 * block type object. This is to ensure we can utilise our own
 * block settings in both frontend and render callback.
 *
 * @param array $settings Block's core compatible settings.
 * @param array $metadata Meta data registered for the block in block.json.
 * @return $settings The modified settings with out API enabled.
 */
function handle_eternia_block_api( $settings, $metadata ) {

	if ( ! isset( $metadata['acf'] ) ) {
		return $settings;
	}

	$eternia_metadata = $metadata['eternia'] ?? array();

	// Ensure the cache is on if nothing is set on block settings.
	$eternia_cache = $eternia_metadata['cache']['mode'] ?? 'general';

	/**
	 * Construct eternia API.
	 */
	$eternia_api                  = $eternia_metadata;
	$eternia_api['cache']['mode'] = $eternia_cache;

	// Add eternia API to block settings.
	$settings['eternia'] = $eternia_api;

	return $settings;
}

/**
 * If scripts are not set in block JSON,
 * try to load them from blocks scripts folder.
 *
 * @param array $settings Block's core compatible settings.
 * @param array $metadata Meta data registered for the block in block.json.
 * @return $settings The modified settings with scripts maybe autoloaded.
 */
function register_eternia_block_scripts( $settings, $metadata ) {

	if ( ! isset( $metadata['acf'] ) ) {
		return $settings;
	}

	// Do not override if already set.
	if ( ! empty( $settings['viewScript'] ) ) {
		return $settings;
	}

	$script_file_location = '/build/js/blocks-acf/';
	$slug                 = get_acf_block_slug( $settings, $metadata );

	// Check if dependencies are set in eternia API.
	$dependencies = $metadata['eternia']['dependencies']['scripts'] ?? array();

	// Check if script file exists.
	$script_file_path = $script_file_location . $slug . '/' . $slug . '.js';
	$script_file      = get_template_directory() . $script_file_path;

	if ( ! file_exists( $script_file ) ) {
		return $settings;
	}

	// Enqueue block script.
	$script_handle = 'block-' . $slug;

	wp_register_script(
		$script_handle,
		get_template_directory_uri() . $script_file_path,
		$dependencies,
		filemtime( $script_file ),
		true
	);

	return $settings;
}

/**
 * Adds block assets to be enqueued.
 *
 * At this point the assets should be registered, but are
 * not added to the blocks object. This function adds them
 * to the block object so they are enqueued.
 *
 * @param array $metadata Block metadata from block.json.
 * @return array Block metadata with assets loaded.
 */
function load_eternia_block_assets( $metadata ) {

	if ( ! isset( $metadata['acf'] ) ) {
		return $metadata;
	}

	if ( empty( $metadata['viewScript'] ) ) {
		$slug                   = str_replace( 'acf/', '', $metadata['name'] );
		$metadata['viewScript'] = 'block-' . $slug;
	}

	if ( empty( $metadata['style'] ) ) {
		$slug                    = str_replace( 'acf/', '', $metadata['name'] );
		$metadata['viewStyle']   = 'block-' . $slug;
		$metadata['editorStyle'] = 'block-' . $slug;
	}

	return $metadata;
}

/**
 * If styles are not set in block JSON,
 * try to load them from blocks styles folder.
 *
 * @param array $settings Block's core compatible settings.
 * @param array $metadata Meta data registered for the block in block.json.
 * @return $settings The modified settings with styles maybe autoloaded.
 */
function register_eternia_block_styles( $settings, $metadata ) {

	if ( ! isset( $metadata['acf'] ) ) {
		return $settings;
	}

	// Do not override if already set.
	if ( ! empty( $settings['style'] ) ) {
		return $settings;
	}

	$style_file_location = '/build/css/blocks-acf/';
	$slug                = get_acf_block_slug( $settings, $metadata );

	// Check if dependencies are set in eternia API.
	$dependencies = $metadata['eternia']['dependencies']['styles'] ?? array();

	// Check if style file exists.
	$style_file_path = $style_file_location . $slug . '/' . $slug . '.css';

	if ( ! file_exists( get_template_directory() . $style_file_path ) ) {
		return $settings;
	}

	// Enqueue block style.
	$style_handle = 'block-' . $slug;

	wp_register_style(
		$style_handle,
		get_template_directory_uri() . $style_file_path,
		$dependencies,
		filemtime( get_template_directory() . $style_file_path )
	);

	return $settings;
}

/**
 * Engages the dynamic block preview for block inserter, if otherwise not set.
 *
 * @param array $settings Block's core compatible settings.
 * @param array $metadata Meta data registered for the block in block.json.
 * @return $settings The modified settings with dynamic preview maybe enabled.
 */
function enable_acf_dynamic_preview( $settings, $metadata ) {

	if ( ! isset( $metadata['acf'] ) ) {
		return $settings;
	}

	// If a preview image is set, use that over dynamic preview.
	$slug               = get_acf_block_slug( $settings, $metadata );
	$preview_image_path = '/build/img/block-preview/' . $slug . '/preview.png';

	if ( file_exists( get_template_directory() . $preview_image_path ) ) {
		$preview_image_uri  = get_template_directory_uri() . $preview_image_path;
		$preview_image_html = '<img src="' . esc_html( $preview_image_uri ) . '" style="display: block; width:100%; height: 100%; object-fit: contain;">';

		$settings['example'] = array(
			'attributes' => array(
				'mode' => 'preview',
				'data' => array(
					'preview_image_help' => $preview_image_html,
				),
			),
		);

		return $settings;
	}

	// Do not override if already set.
	if ( ! empty( $settings['example']['mode'] ) ) {
		return $settings;
	}

	// Allow override by user, but set 1440 as default.
	$viewport_width = $settings['example']['viewportWidth'] ?? 1440;

	// Use dynamic preview if no preview image is set.
	$settings['example'] = array(
		'viewportWidth' => $viewport_width,
		'attributes'    => array(
			'mode' => 'preview',
		),
	);

	return $settings;
}


/**
 * Adds default settings for ACF block registration.
 *
 * @link https://www.advancedcustomfields.com/resources/acf-blocks-key-concepts/#acf-blocks-and-blockjson
 *
 * @param array $metadata Block metadata from block.json.
 * @return array Default settings for ACF blocks.
 */
function add_acf_block_defaults( $metadata ) {

	if ( ! isset( $metadata['acf'] ) ) {
		return $metadata;
	}

	if ( empty( $metadata['acf']['renderCallback'] ) ) {
		$metadata['acf']['renderCallback'] = __NAMESPACE__ . '\render_acf_block';
	}

	if ( empty( $metadata['acf']['mode'] ) ) {
		$metadata['acf']['mode'] = 'auto';
	}

	return $metadata;
}

/**
 * If namespace seems like this is an ACF block,
 * but no ACF key is set, add it.
 *
 * This is to ensure our block registration can add the
 * necessary settings even if the developer does not set
 * the acf settings.
 *
 * @param array $metadata Block metadata from block.json.
 * @return array Default settings for ACF blocks.
 */
function add_acf_key_if_missing( $metadata ) {

	if ( empty( $metadata['name'] ) ) {
		return $metadata;
	}

	if ( strpos( $metadata['name'], 'acf/' ) === 0 && empty( $metadata['acf'] ) ) {
		$metadata['acf'] = array();
	}

	return $metadata;
}

/**
 * If a block icon exists with the block slug in build/img/block-icons,
 * add it to the block metadata.
 *
 * @param array $metadata Block metadata from block.json.
 * @return array Default settings for ACF blocks.
 */
function add_custom_block_icon( $metadata ) {

	if ( empty( $metadata['name'] ) ) {
		return $metadata;
	}

	$slug = explode( '/', $metadata['name'] );
	$slug = end( $slug );

	$icon_path = '/build/img/block-icons/' . $slug . '.svg';

	if ( file_exists( get_template_directory() . $icon_path ) ) {
		$metadata['icon'] = get_template_directory_uri() . $icon_path;
	}

	return $metadata;
}

/**
 * Helper function for getting acf block's slug while filtering block type metadata settings.
 *
 * Contents of Block settings has changed in WP 6.5. This function is to ensure
 * we can get the block slug from either settings or metadata.
 *
 * @param array $settings Block settings.
 * @param array $metadata Block metadata.
 * @return string Block slug.
 */
function get_acf_block_slug( $settings, $metadata ) {
	$block_name = '';
	if ( isset( $settings['name'] ) ) {
		$block_name = $settings['name'];
	} elseif ( isset( $metadata['name'] ) ) {
		$block_name = $metadata['name'];
	}

	return str_replace( 'acf/', '', $block_name );
}

/**
 * Add custom anchor attribute (a unique ID) to each ACF block.
 *
 * The ID provided by ACF to each block is not actually unique but
 * a hashed version of block data. This function adds a unique ID to
 * the anchor attribute of each block, so it can be overwritten
 * by user in the editor if need be.
 *
 * @param array $attributes The block attributes.
 * @return array The modified block attributes.
 */
function add_unique_anchor_attribute_to_acf_blocks( $attributes ) {
	// Skip if anchor is already set.
	if ( ! empty( $attributes['anchor'] ) ) {
		return $attributes;
	}

	$attributes['anchor'] = uniqid( 'acf-block-' );
	return $attributes;
}

/**
 * Register all ACF field groups for blocks
 */
add_action(
	'acf/include_fields',
	function () {
		$default_json_list = array_merge(
			glob( dirname( __DIR__, 2 ) . '/acf-blocks/**/acf-json/*.json' ),
			glob( dirname( __DIR__, 2 ) . '/blocks/**/acf-json/*.json' )
		);
		foreach ( apply_filters( 'acf_block_field_group_jsons', $default_json_list ) as $field ) {
			ob_start();
			require $field;
			$json = ob_get_clean();
			acf_add_local_field_group( json_decode( $json, true ) );
		}
	}
);
