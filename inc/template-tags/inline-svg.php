<?php
/**
 * Inline SVG
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Creates a potentially wrapped, inline SVG element from a file in the /build/img/ folder.
 *
 * PHP files should use this helper function to fetch SVG files
 * from a common folder, rather than explicitly render the
 * SVG code in the template code.
 *
 * @param string $name     Name of the file to look for. Can be just the name, or with the file extension.
 * @param array  $args     Optional arguments
 *  - wrapper (string)   | HTML wrapper the svg is added within. Default no wrapper.
 *  - class (string)     | HTML class to add to the wrapper element. Default: i.
 *  - itemprop (string)  | Itemprop attribute to add to the wrapper element. Default: null.
 *  - subfolder (string) | Subfolder to look for the file in. Default: 'icons'. Use false for main folder.
 * @param bool   $echo_svg Whether to echo the svg or not.
 *
 * @return bool|string|void The svg element or void if echoed
 */
function inline_svg( $name, $args = array(), $echo_svg = false ) {
	$checklist = array( $name, "$name.svg", "icon_$name.svg" ); // Check in this order.

	$build_svg = function ( $path, $args, $echo_svg ) {
		$wrapper_element = array_key_exists( 'wrapper', $args ) ? esc_html( $args['wrapper'] ) : 'span';

		$wrapper_classes = array_key_exists( 'class', $args ) ? esc_attr( $args['class'] ) : null;
		$class_markup    = $wrapper_classes ? "class='$wrapper_classes'" : '';

		$itemprop        = array_key_exists( 'itemprop', $args ) ? esc_attr( $args['itemprop'] ) : null;
		$itemprop_markup = $itemprop ? "itemprop='$itemprop'" : '';

		$svg = file_get_contents( $path ); // phpcs:ignore

		if ( $echo_svg ) {
			echo wp_kses_post( "<$wrapper_element $class_markup $itemprop_markup>" ) . wp_kses( $svg, ALLOW_ONLY_SVG ) . wp_kses_post( "</$wrapper_element>" );
			return;
		}

		return "<$wrapper_element $class_markup $itemprop_markup>$svg</$wrapper_element>";
	};

	foreach ( $checklist as $file ) {
		$filepath = get_template_directory() . '/build/img/';

		$subfolder = array_key_exists( 'subfolder', $args ) ? esc_attr( $args['subfolder'] ) : 'icons';

		if ( $subfolder ) {
			$filepath .= $subfolder . '/';
		}

		if ( ! file_exists( $filepath . $file ) ) {
			return false;
		}

		if ( $filepath ) {
			return $build_svg( $filepath . $file, $args, $echo_svg );
		}

		return false;
	}

	return false;
}
