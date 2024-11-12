<?php
/**
 * Main settings for Eternia theme.
 *
 * Modify the array to set up project specifics.
 * Various functions across the theme construct
 * the site based on these settings.
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Theme settings
 */
function theme_settings() {
	$theme_settings = array(
		/**
		 * Theme textdomain
		 */
		'textdomain'                    => 'eternia',
		/**
		 * Production url
		 * Add site url here if you want to hide ACF fields from live site
		 */
		'prod_url'                      => 'localhost',

		/**
		 * Site domain
		 * This is used e.g. in modifying WP Mail header values ('from' and 'reply-to')
		 */
		'domain'                        => '',

		/**
		* Image and content sizes
		* Add image sizes here if you want to use them in your theme
		* These are handelled in hooks folder file image-sizes.php
		*/

		'image_sizes'                   => array(

			/*
				Array(
					'name' => 'logo',
					'width' => 1500,
					'height' => 1500,
					'crop' => 0
				),
				Array(
					'name' => 'marketing',
					'width' => 100,
					'height' => 500,
					'crop' => 1
				)
				*/
		),
		'content_width'                 => 800,

		/**
		 * Logo and featured image
		 */
		'default_featured_image'        => null,
		'logo'                          => '/build/img/logo.svg',

		/**
		* Custom setting group settings when using Air setting groups plugin.
		* On multilingual sites using Polylang, translations are handled automatically.
		*/
		'custom_settings'               => array(
			// 'your-custom-setting' => [
			// 'id' => Your custom setting post id,
			// 'title' => 'Your custom setting',
			// 'block-editor' => true,
			// ],
		),

		/**
		* All links are cheked with JS, if those direct to external site and if,
		* indicator of that is included. Exclude domains from that check in this array.
		*/
		'external_link_domains_exclude' => array(
			'localhost:3000',
			'localhost',
		),

		/**
		* Menu locations
		*/
		'menu_locations'                => array(
			'primary' => translate__( 'Primary navigation menu' ),
			'footer'  => translate__( 'Footer menu' ),
			'some'    => translate__( 'Social media menu' ),
		),

		/**
		* Taxonomies
		*
		* See the instructions:
		* https://github.com/digitoimistodude/air-light#custom-taxonomies
		*/
		'taxonomies'                    => array(
			// 'Your_Taxonomy' => [ 'post', 'page' ],
		),

		/**
		* Post types
		*
		* See the instructions:
		* https://github.com/digitoimistodude/air-light#custom-post-types
		*/
		'post_types'                    => array(
			// 'Your_Post_Type',
			'video',
		),

		/**
		* Here you can add fixed terms to taxonomies in array format.
		* The lang of the term is set with the 'lang' key.
		* The lang is fi if you do not set it.
		*/

		'fixed_terms'                   => array(
			'your_taxonomy' => array(
				array(
					'slug'        => 'term_slug',
					'name'        => 'Term name',
					'description' => 'Term description',
				),
			),
		),

		/**
		* Here you can add more tabs to the options page.
		* You can also create multiple options pages.
		* advanced-custom-fields.php file is responsible for creating the top level options pages.
		*/

		'theme_options_pages'           => array(
			array(
				'page_title' => '404',
				'menu_title' => '404',
			),
			array(
				'page_title' => 'Footer',
				'menu_title' => 'Footer',
			),
		),

		/**
		 * Restrict core blocks.
		 *
		 * Please note that ACF block post type settings are set
		 * in the block specific block.json file instead.
		 */
		'allowed_blocks'                => array(
			'default' => array(
				// 'core/archives',
				// 'core/audio',
				'core/block', // Named funny, but is essentially reusable blocks.
				// 'core/buttons',
				// 'core/categories',
				// 'core/code',
				// 'core/column',
				// 'core/columns',
				// 'core/coverImage',
				// 'core/embed',
				// 'core/file',
				// 'core/freeform',
				// 'core/gallery',.
				'core/heading',
				// 'core/html',
				'core/image',
				// 'core/latestComments',
				// 'core/latestPosts',
				'core/list',
				'core/list-item',
				// 'core/more',
				// 'core/nextpage',
				'core/paragraph',
			// 'core/preformatted',
			// 'core/pullquote',
			// 'core/quote',
			// 'core/separator',
			// 'core/shortcode',
			// 'core/spacer',
			// 'core/subhead',
			// 'core/table',
			// 'core/textColumns',
			// 'core/verse',
			// 'core/video',
			),
			'post'    => array(
				// 'core/archives',
				// 'core/audio',
				// 'core/buttons',
				// 'core/categories',
				// 'core/code',
				// 'core/column',
				// 'core/columns',
				// 'core/coverImage',
				// 'core/embed',
				// 'core/file',
				// 'core/freeform',
				// 'core/gallery',
				'core/heading',
				// 'core/html',
				'core/image',
				// 'core/latestComments',
				// 'core/latestPosts',
				'core/list',
				'core/list-item',
				// 'core/more',
				// 'core/nextpage',
				'core/paragraph',
			// 'core/preformatted',
			// 'core/pullquote',
			// 'core/quote',
			// 'core/block',
			// 'core/separator',
			// 'core/shortcode',
			// 'core/spacer',
			// 'core/subhead',
			// 'core/table',
			// 'core/textColumns',
			// 'core/verse',
			// 'core/video',
			),
		),

		// If you want to use classic editor somewhere, define it here.
		'use_classic_editor'            => array(),

		// Log file name. This is used in write_log() function.
		'log_file'                      => 'eternia__debug.log',

		// Integer value. Defines how many characters are written to log file.
		// This is used in write_log() function.
		'log_output_maxlength'          => 10000,

		// Content Security Policy headers.
		'csp_headers'                   => array(
			'default-src' => array( "'self'", "'unsafe-inline'" ),
			'script-src'  => array( "'self'", "'unsafe-inline'", "'unsafe-eval'",'googletagmanager.com', 'cookiebot.eu' ),
			'style-src'   => array( "'self'", "'unsafe-inline'" ),
      'worker-src'  => array( "'self'", "'unsafe-inline'", "blob:" ),
			'img-src'     => array( "'self'", '*.gravatar.com',  ),
			'font-src'    => array( "'self'", "'unsafe-inline'", "data:" ),
			'connect-src' => array( "'self'" ),
			'media-src'   => array( "'self'" ),
		),

		// Add your own settings and use them wherever you need, for example THEME_SETTINGS['my_custom_setting'].
		'my_custom_setting'             => true,
	);

		$theme_settings = apply_filters( 'air_light_theme_settings', $theme_settings );

		define( 'THEME_SETTINGS', $theme_settings );
} // end action after_setup_theme.
