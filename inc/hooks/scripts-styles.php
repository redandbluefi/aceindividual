<?php
/**
 * Enqueue and localize theme scripts and styles
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Move jQuery to footer
 *
 * @param  WP_Scripts $wp_scripts Instance of WP_Scripts.
 */
function move_jquery_into_footer( $wp_scripts ) {
	if ( ! is_admin() ) {
		$wp_scripts->add_data( 'jquery', 'group', 1 );
		$wp_scripts->add_data( 'jquery-core', 'group', 1 );
		$wp_scripts->add_data( 'jquery-migrate', 'group', 1 );
	}
} // end move_jquery_into_footer

/**
 * Enqueue theme scripts and styles needed in the head
 *
 * @since 1.0.0
 */
function enqueue_early_theme_scripts(){
	$svg_file_path = dirname( __DIR__, 2 ) . '/app/img/icons/external.svg';
	// Check if the file exists.
	if ( file_exists( $svg_file_path ) ) {
		ob_start();
		require $svg_file_path;
		$external_link_svg = ob_get_clean();
	} else {
		$external_link_svg = '<!-- external.svg file not found in app/img folder. Please add it -->';
	} ?>
	<script>
		window.eternia = {
			properties:<?php echo json_encode(array(
				'root_url'          => get_site_url(),
				'rest_url' 					=> get_rest_url(),
				'nonce'             => wp_create_nonce( 'wp_rest' ),
				'external_link_svg' => $external_link_svg,
			), JSON_UNESCAPED_SLASHES); ?>
		};
	</script>
	<?php
}

/**
 * Enqueue scripts and styles.
 */
function enqueue_theme_scripts() {

	// Enqueue main.css file.
	wp_enqueue_style(
		'styles',
		get_theme_file_uri( get_asset_file( 'main.css' ) ),
		array(),
		filemtime( dirname( __DIR__, 2 ) . '/' . get_asset_file( 'main.css' ) )
	);

	// Enqueue jquery and front-end.js file.
	wp_enqueue_script( 'jquery-core' );
	wp_enqueue_script(
		'scripts',
		get_theme_file_uri( get_asset_file( 'front-end.js' ) ),
		array(),
		filemtime( dirname( __DIR__, 2 ) . '/' . get_asset_file( 'front-end.js' ) ),
		true
	);
	wp_register_script( 'lightbox', get_theme_file_uri( get_asset_file( 'lightbox.js' ) ), array(), filemtime( dirname( __DIR__, 2 ) . '/' . get_asset_file( 'lightbox.js' ) ), false );
	wp_register_script( 'core-image-lightbox', get_theme_file_uri( get_asset_file( 'core-image-lightbox.js' ) ), array('lightbox'), filemtime( dirname( __DIR__, 2 ) . '/' . get_asset_file( 'core-image-lightbox.js' ) ), false );
	wp_register_script( 'eternia-vue', get_theme_file_uri( get_asset_file( 'eternia-vue.js' ) ), array(), filemtime( dirname( __DIR__, 2 ) . '/' . get_asset_file( 'eternia-vue.js' ) ), false );
	wp_register_script( 'swiper', get_theme_file_uri( get_asset_file( 'swiper.js' ) ), array(), filemtime( dirname( __DIR__, 2 ) . '/' . get_asset_file( 'swiper.js' ) ), false );

	// LOAD CORE IMAGE LIGHTBOX
	// wp_enqueue_script( 'core-image-lightbox' );

	// Required comment-reply script.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_localize_script(
		'scripts',
		'air_light_screenReaderText',
		array(
			'expand'          => get_default_localization( 'Open child menu' ),
			'collapse'        => get_default_localization( 'Close child menu' ),
			'expand_for'      => get_default_localization( 'Open child menu for' ),
			'collapse_for'    => get_default_localization( 'Close child menu for' ),
			'expand_toggle'   => get_default_localization( 'Open main menu' ),
			'collapse_toggle' => get_default_localization( 'Close main menu' ),
			'external_link'   => get_default_localization( 'External site' ),
			'target_blank'    => get_default_localization( 'opens in a new window' ),
			'previous_slide'  => get_default_localization( 'Previous slide' ),
			'next_slide'      => get_default_localization( 'Next slide' ),
			'last_slide'      => get_default_localization( 'Last slide' ),
			'skip_slider'     => get_default_localization( 'Skip over the carousel element' ),
		)
	);

	// Add domains/hosts to disable external link indicators.
	wp_localize_script( 'scripts', 'air_light_externalLinkDomains', THEME_SETTINGS['external_link_domains_exclude'] );
	wp_localize_script( 'scripts', 'current_lang', array( 'language' => ICL_LANGUAGE_CODE ) );

} // end enqueue_theme_scripts

/**
 * Returns the built asset filename and path depending on
 * current environment.
 *
 * @param string $filename File name with the extension.
 * @return string file and path of the asset file
 */
function get_asset_file( $filename ) {
	$env = 'production' === wp_get_environment_type() ? 'prod' : 'dev'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

	$filetype = pathinfo( $filename )['extension'];

	return 'build/' . $filetype . '/' . $filename;
} // end get_asset_file.

/**
 * Load admin styles and scripts from the build folder
 */
function load_admin_styles() {
	wp_enqueue_style(
		'admin-styles',
		get_theme_file_uri( get_asset_file( 'admin.css' ) ),
		array(),
		filemtime( dirname( __DIR__, 2 ) . '/' . get_asset_file( 'admin.css' ) ),
		'all'
	);

	// Check if the current screen is the page list or page editor.
	$screen = get_current_screen();
	if ( $screen && ( 'edit-page' === $screen->id || 'page' === $screen->post_type ) ) {
		// Enqueue the script for preventing front page deletion.
		wp_enqueue_script(
			'prevent-front-page-deletion',
			get_theme_file_uri( get_asset_file( 'editor.js' ) ),
			array( 'wp-data', 'wp-edit-post', 'wp-core-data' ),
			null,
			true
		);

		// Initialize frontpage_info array.
		$frontpage_info = array();

		// Check if Polylang is active.
		if ( function_exists( 'pll_get_post' ) && function_exists( 'pll_languages_list' ) ) {
			// Get all languages.
			$languages = pll_languages_list();

			// Loop through each language and get the front page ID.
			foreach ( $languages as $lang ) {
				$frontpage_id                   = pll_get_post( get_option( 'page_on_front' ), $lang );
				$frontpage_info[ "id-{$lang}" ] = $frontpage_id;
			}
		}

		// Translated texts for the "Move to Trash" button (add more as needed)
		// In different languages, the text for the trash button varies.
		// To accurately find the element, specify its translation.
		$trash_button_texts = array(
			translate__( 'Move to Trash', 'eternia' ),
			translate__( 'Move to Bin', 'eternia' ),
			translate__( 'Siirrä roskakoriin', 'eternia' ),
			translate__( 'Lägg i papperskorgen', 'eternia' ),
			translate__( 'Удалить', 'eternia' ),
		);

		// Localize the script with necessary data.
		wp_localize_script(
			'prevent-front-page-deletion',
			'test', // The name of the JavaScript object.
			array(
				'current_user'          => wp_get_current_user(),
				'frontpage_info'        => $frontpage_info,
				'trash_button_texts'    => $trash_button_texts,
				'no_permission_message' => __( 'You do not have permission to delete this page.', 'eternia' ),
			)
		);
	}
}
