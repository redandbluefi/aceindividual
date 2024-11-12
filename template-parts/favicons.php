<?php
/**
 * Favicons for site Head
 *
 * @package eternia
 */

namespace Eternia;

$tile_color  = '#000';
$theme_color = '#fff';

/**
 * Array of HTML meta items to create.
 *
 * Element corresponds to type of HTML element to create.
 * The other arguments are any attributes to add to the element.
 */
$link_items = array(
	array(
		'element' => 'link',
		'rel'     => 'apple-touch-icon',
		'type'    => 'image/png',
		'sizes'   => '180x180',
		'href'    => 'apple-touch-icon.png',
	),
	array(
		'element' => 'link',
		'rel'     => 'icon',
		'type'    => 'image/png',
		'sizes'   => '32x32',
		'href'    => 'favicon-32x32.png',
	),
	array(
		'element' => 'link',
		'rel'     => 'icon',
		'type'    => 'image/png',
		'sizes'   => '16x16',
		'href'    => 'favicon-16x16.png',
	),
	array(
		'element' => 'link',
		'rel'     => 'manifest',
		'href'    => 'site.webmanifest',
	),
	array(
		'element' => 'link',
		'rel'     => 'mask-icon',
		'href'    => 'safari-pinned-tab.svg',
		'color'   => $tile_color,
	),
	array(
		'element' => 'link',
		'rel'     => 'shortcut icon',
		'href'    => 'favicon.ico',
	),
	array(
		'element' => 'meta',
		'name'    => 'msapplication-TileColor',
		'content' => $tile_color,
	),
	array(
		'element' => 'meta',
		'name'    => 'msapplication-config',
		'content' => 'browserconfig.xml',
	),
	array(
		'element' => 'meta',
		'name'    => 'theme-color',
		'content' => $theme_color,
	),
);

foreach ( $link_items as $link_item ) {
	echo construct_favicons_meta_item( $link_item ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}


/**
 * Construct HTML meta item
 *
 * Takes an array of attributes and returns a string of HTML markup.
 *
 * @param array $item Array of attributes.
 * @return string
 */
function construct_favicons_meta_item( array $item ) {

	if ( ! is_array( $item ) ) {
		return;
	}

	$element = $item['element'] ?? 'meta';
	$open    = '<' . esc_attr( $element ) . ' ';
	$close   = '>';
	$output  = '';

	$favicons_folder = '/build/img/favicon/';

	foreach ( $item as $attribute => $value ) {
		if ( 'href' === $attribute ) {
			// Check if the file exists in the build folder.
			$exists = file_exists( get_template_directory() . $favicons_folder . $value );
			if ( ! $exists ) {
				continue; // Don't output the meta item at all.
			}
			$value = get_template_directory_uri() . $favicons_folder . $value;

			$output .= esc_attr( $attribute ) . '="' . esc_url( $value ) . '" ';
		} else {
			$output .= esc_attr( $attribute ) . '="' . esc_attr( $value ) . '" ';
		}
	}

	$output = $open . $output . $close;

	return $output;
}
