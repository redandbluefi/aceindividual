<?php
/**
 * Gutenberg editor related functions
 *
 * @package eternia
 */

/**
 * Callback function for setting up Gutenberg editor.
 */
function rnb_setup_gutenberg() {
	add_theme_support( 'disable-custom-colors' );
	add_theme_support( 'align-wide' );
} // end rnb_setup_gutenberg

add_action( 'after_setup_theme', 'rnb_setup_gutenberg' );

// Add custom font sizes to Gutenberg editor.
add_theme_support(
	'editor-font-sizes',
	array(
		array(
			'name'      => __( 'Regular', 'rnb' ),
			'shortName' => __( 'M', 'rnb' ),
			'size'      => 16,
			'slug'      => 'regular',
		),
		array(
			'name'      => __( 'Ingressi', 'rnb' ),
			'shortName' => __( 'I', 'rnb' ),
			'size'      => 24,
			'slug'      => 'ingressi',
		),
		array(
			'name'      => __( 'Small', 'rnb' ),
			'shortName' => __( 'S', 'rnb' ),
			'size'      => 13,
			'slug'      => 'small',
		),
		array(
			'name'      => __( 'Large', 'rnb' ),
			'shortName' => __( 'L', 'rnb' ),
			'size'      => 20,
			'slug'      => 'large',
		),
		array(
			'name'      => __( 'Huge', 'rnb' ),
			'shortName' => __( 'XL', 'rnb' ),
			'size'      => 24,
			'slug'      => 'xtra_larger',
		),
	)
);
