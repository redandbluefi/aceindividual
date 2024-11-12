<?php
/**
 * THEME_SETTINGS['theme_options_pages'] contains an array of options pages that are then loopped here and created.
 * The options pages are created as ACF options sub pages so they all have their own tab and each create a seperate JSON file.
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Register ACF options pages from theme settings.
 */
function register_acf_sub_pages_from_array() {

	// Get the default language option.
	$option_lang = get_default_lang_option();

	/**
	 * Add options page for ACF. Default options page is used if no other options pages are defined in the theme settings.
	 */
	if ( function_exists( 'acf_add_options_page' ) ) {
		acf_add_options_page(
			array(
				'page_title' => 'Teeman asetukset',
				'menu_title' => 'Teeman asetukset',
				'menu_slug'  => 'theme-general-settings',
				'post_id'    => $option_lang,
			)
		);
	}

	if ( ! isset( THEME_SETTINGS['theme_options_pages'] ) ) {
		return;
	}

	if ( ! function_exists( 'acf_add_options_sub_page' ) ) {
		return;
	}

	// Check if there are any sub pages defined in the theme settings and create them.
	foreach ( THEME_SETTINGS['theme_options_pages'] as $sub_page ) {
		if ( isset( $sub_page['page_title'] ) && isset( $sub_page['menu_title'] ) ) {
			$parent_slug = isset( $sub_page['parent_slug'] ) && ! empty( $sub_page['parent_slug'] ) ? $sub_page['parent_slug'] : 'theme-general-settings';

			acf_add_options_sub_page(
				array(
					'page_title'  => $sub_page['page_title'],
					'menu_title'  => $sub_page['menu_title'],
					'parent_slug' => $parent_slug,
					'post_id'     => $option_lang,
				)
			);
		}
	}
} // end register_acf_sub_pages_from_array

/**
 * Check if the user is on an ACF Options Page in the admin
 * and ensure a language is selected or show a message.
 */
function check_acf_options_page() {
	// Check if the user is on any ACF Options Page.

	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( ! isset( $_GET['page'] ) || strpos( sanitize_text_field( wp_unslash( $_GET['page'] ) ), 'acf-options' ) !== 0 || ! function_exists( 'pll_current_language' ) ) {
		return;
	}

	$selected_language = pll_current_language();
	$languages         = pll_languages_list();

	// If Polylang is active but there are no languages, dont show the message.
	if ( is_plugin_active( 'polylang/polylang.php' ) && empty( $languages ) ) {
		return;
	}

	if ( empty( $selected_language ) ) {
			// No language selected, display a message.
			echo '<div class="notice notice-error"><p class="eternia-danger">';
			echo esc_html( translate__( 'Teeman asetussivut ovat kieliversiokohtaisia. Valitse käytettävä kieli yläpalkin valikosta.', 'eternia' ) );
			echo '</p></div>';
	}
} // end check_acf_options_page
