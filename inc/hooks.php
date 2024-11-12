<?php
/**
 * Hooks
 *
 * All hooks that are run in the theme are listed here
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Enable search view
 */
// phpcs:ignore
// add_filter( 'air_helper_disable_views_search', '__return_false' );

/**
 * Breadcrumb
 */
// phpcs:ignore 
// require_once __DIR__. '/hooks/breadcrumb.php';

/**
 * General hooks
 */
require_once __DIR__ . '/hooks/general.php';
add_action( 'widgets_init', __NAMESPACE__ . '\widgets_init' );

/**
 * Legacy blocks
 */
require_once __DIR__ . '/hooks/legacy-blocks.php';
add_action( 'init', __NAMESPACE__ . '\LegacyBlocks\register_legacy_blocks' );

/**
 * Scripts and styles associated hooks
 */
require_once __DIR__ . '/hooks/scripts-styles.php';
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_early_theme_scripts', 9 );
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_theme_scripts' );
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\load_admin_styles' );

/**
 * If you use ajax functionality in Gravity Forms, remove this line to prevent Uncaught ReferenceError: jQuery is not defined
 */
add_action( 'wp_default_scripts', __NAMESPACE__ . '\move_jquery_into_footer' );

/**
 * Gutenberg associated hooks
 */
require_once __DIR__ . '/hooks/gutenberg.php';
add_filter( 'allowed_block_types_all', __NAMESPACE__ . '\allowed_block_types', 10, 2 );
add_filter( 'use_block_editor_for_post_type', __NAMESPACE__ . '\use_block_editor_for_post_type', 10, 2 );
add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\register_block_editor_assets' );
add_filter( 'block_editor_settings_all', __NAMESPACE__ . '\remove_gutenberg_inline_styles', 10, 2 );

/**
 * ACF blocks
 */
require_once __DIR__ . '/hooks/acf-blocks.php';
add_action( 'init', __NAMESPACE__ . '\register_eternia_blocks', 5 );
add_filter( 'block_type_metadata_settings', __NAMESPACE__ . '\handle_eternia_block_api', 10, 2 );
add_filter( 'block_type_metadata_settings', __NAMESPACE__ . '\register_eternia_block_scripts', 10, 2 );
add_filter( 'block_type_metadata_settings', __NAMESPACE__ . '\register_eternia_block_styles', 10, 2 );
add_filter( 'block_type_metadata_settings', __NAMESPACE__ . '\enable_acf_dynamic_preview', 10, 2 );
add_filter( 'block_categories_all', __NAMESPACE__ . '\add_block_categories', 10, 2 );
add_filter( 'block_type_metadata', __NAMESPACE__ . '\add_acf_key_if_missing', 9, 1 );
add_filter( 'block_type_metadata', __NAMESPACE__ . '\add_acf_block_defaults', 10, 1 );
add_filter( 'block_type_metadata', __NAMESPACE__ . '\load_eternia_block_assets', 10, 1 );
add_filter( 'block_type_metadata', __NAMESPACE__ . '\add_custom_block_icon', 10, 1 );
add_filter( 'acf/pre_save_block', __NAMESPACE__ . '\add_unique_anchor_attribute_to_acf_blocks', 10, 1 );

/**
 * ACF theme options
 */
require_once __DIR__ . '/hooks/acf-options-page.php';
add_action( 'acf/init', __NAMESPACE__ . '\register_acf_sub_pages_from_array' );
add_action( 'admin_notices', __NAMESPACE__ . '\check_acf_options_page' );

/**
 * Register fixed terms
 */
require_once __DIR__ . '/hooks/fixed-terms.php';
add_action( 'init', __NAMESPACE__ . '\register_fixed_terms_from_array', 15 ); // After post types and taxonomies are registered (priority 10).
add_filter( 'tag_row_actions', __NAMESPACE__ . '\remove_delete_button_from_term_in_admin', 10, 2 );

/**
 * Form related hooks
 */
require_once __DIR__ . '/hooks/forms.php';
add_action( 'gform_enqueue_scripts', __NAMESPACE__ . '\dequeue_gf_stylesheets', 999 );

/**
 * Users
 */
require_once __DIR__ . '/hooks/users.php';
add_filter( 'redandblue-user-roles/rnb_urc_caps', __NAMESPACE__ . '\rnb_content_manager_caps', 999, 0 );
add_filter( 'redandblue-user-roles/rnb_urc_users', '__return_true' ); // Allow content managers to manage users.

/**
 * Admin settings
 */
require_once __DIR__ . '/hooks/wp-admin.php';
add_action( 'admin_menu', __NAMESPACE__ . '\redirect_plugin_access_to_content_managers' );
add_action( 'pre_trash_post', __NAMESPACE__ . '\restrict_post_deletion', 10, 1 );
add_action( 'before_delete_post', __NAMESPACE__ . '\restrict_post_deletion', 10, 1 );
add_filter( 'rest_pre_dispatch', __NAMESPACE__ . '\restrict_frontpage_rest_api_deletion', 10, 3 );
add_action( 'admin_notices', __NAMESPACE__ . '\restrict_frontpage_admin_notice' );


/**
 * WP Mail
 */
require_once __DIR__ . '/hooks/mail.php';
add_filter( 'wp_mail_from', __NAMESPACE__ . '\wp_mail_from' );
add_filter( 'wp_mail_from_name', __NAMESPACE__ . '\wp_mail_from_name' );
add_filter( 'wp_new_user_notification_email', __NAMESPACE__ . '\wp_new_user_notification_email', 10, 3 );

/**
 * WP image sizes
 */
require_once __DIR__ . '/hooks/image-sizes.php';
add_action( 'after_setup_theme', __NAMESPACE__ . '\image_sizes' );

/**
 * Yoast
 */
require_once __DIR__ . '/hooks/yoast.php';
add_filter( 'wpseo_metabox_prio', __NAMESPACE__ . '\move_yoast_to_bottom' );

/**
 * Clean WP Admin
 */

require_once __DIR__ . '/hooks/clean-wp-admin.php';
add_action( 'wp_before_admin_bar_render', __NAMESPACE__ . '\hide_updates_button' );
add_action( 'wp_before_admin_bar_render', __NAMESPACE__ . '\hide_comments_button' );

/**
 * Translatable custom post types.
 */
add_filter( 'pll_get_post_types', __NAMESPACE__ . '\add_cpt_to_pll', 10, 2 );

/**
 * Walker for the social media menu.
 */
require_once __DIR__ . '/hooks/social-media-menu.php';
add_filter( 'walker_nav_menu_start_el', __NAMESPACE__ . '\some_icons_output', 10, 4 );

/**
 * Transients
 */
require_once __DIR__ . '/hooks/transients.php';
add_action( 'save_post', __NAMESPACE__ . '\delete_breadcrumb_transients_on_post_change', 10, 3 );
add_action( 'saved_term', __NAMESPACE__ . '\delete_breadcrumb_transients_on_term_change', 10, 4 );
add_action( 'save_post', __NAMESPACE__ . '\delete_block_cache_on_post_change', 10, 3 );
add_action( 'save_post', __NAMESPACE__ . '\purge_post_type_dependent_block_caches', 10, 2 );
add_action( 'save_post', __NAMESPACE__ . '\purge_post_type_dependent_transients', 10, 2 );
add_filter( 'eternia_transient_prefixes_to_purge_on_post_type_update', __NAMESPACE__ . '\define_transient_prefixes_to_purge_on_post_type_update', 10, 1 );

/**
 * Rest API & routes
 */

// Authorize requests.
require_once __DIR__ . '/hooks/rest-api/permissions.php';
add_filter( 'rest_request_before_callbacks', __NAMESPACE__ . '\restrict_wp_default_api_requests', 10, 3 );


// Lightbox.
require get_theme_file_path( 'inc/hooks/lightbox.php' );
add_action( 'wp_footer', __NAMESPACE__ . '\add_lightbox_dialog' );

/**
 * Response headers.
 */
require_once __DIR__ . '/hooks/response-headers.php';
add_filter( 'wp_headers', __NAMESPACE__ . '\Inc\Hooks\ResponseHeaders\add_csp_headers', 10, 1 );
add_filter( 'eternia_csp_headers', __NAMESPACE__ . '\Inc\Hooks\ResponseHeaders\amend_csp_headers_for_wp_admin_bar', 10, 1 );

/**
 * Disable emojis.
 */
require_once __DIR__ . '/hooks/disable-emojis.php';
add_action( 'init', __NAMESPACE__ . '\Inc\Hooks\DisableEmojis\disable_wp_emojis' );
add_filter( 'tiny_mce_plugins', __NAMESPACE__ . '\Inc\Hooks\DisableEmojis\disable_tinymce_emojis' );
