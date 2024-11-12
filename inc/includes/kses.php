<?php
/**
 * Customized KSES constants for sanitizing user inputs.
 *
 * Use wp_kses with any of the constants provided here,
 * to provide consistently sanitized output tailored to various data sanitazion needs.
 *
 * @package eternia
 */

namespace Eternia;

// Everything that is allowed for posts as default. Quite permissive.
$core_post_defaults = wp_kses_allowed_html( 'post' );

// Allow most inline elements, strip all blocks except for block quote.
$core_data = wp_kses_allowed_html( 'data' );

// Allow nothing but linebreaks.
$only_br = array( 'br' => array() );

/**
 * Allow SVG elements.
 *
 * Please note that SVG is a very powerful document type, not just a graphic or image.
 * The elements supported by SVG files are various, and this constant may miss some
 * possible element types.
 *
 * Please note that animations and scripts are removed by default due security
 * concerns. We may make extended KSES for animated SVG's further down the line
 * if use case arises.
 *
 * Find documentation for allowed elements in Mozilla reference below:
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/SVG/Element
 */
$svg_graphic = array(
	'svg'            => array(
		'class'           => true,
		'aria-hidden'     => true,
		'aria-labelledby' => true,
		'role'            => true,
		'xmlns'           => true,
		'width'           => true,
		'height'          => true,
		'viewbox'         => true,
		'fill'            => true,
	),
	'g'              => array( 'fill' => true ),
	'title'          => array( 'title' => true ),
	'path'           => array(
		'd'         => true,
		'fill'      => true,
		'clip-rule' => true,
		'fill-rule' => true,
	),
	'line'           => array(
		'x1'    => true,
		'y1'    => true,
		'x2'    => true,
		'y2'    => true,
		'style' => true,

	),
	'ellipse'        => array(
		'cx'    => true,
		'cy'    => true,
		'rx'    => true,
		'ry'    => true,
		'fill'  => true,
		'style' => true,
	),
	'rect'           => array(
		'x'      => true,
		'y'      => true,
		'width'  => true,
		'height' => true,
		'fill'   => true,
	),
	'polygon'        => array(
		'points' => true,
		'fill'   => true,
	),
	'circle'         => array(
		'cx'    => true,
		'cy'    => true,
		'r'     => true,
		'fill'  => true,
		'style' => true,
	),
	'defs'           => array(),
	'clippath'       => array(
		'id' => true,
	),
	'mask'           => array(
		'id' => true,
	),
	'polyline'       => array(
		'points' => true,
		'fill'   => true,
	),
	'text'           => array(
		'x'      => true,
		'y'      => true,
		'fill'   => true,
		'style'  => true,
		'length' => true,
	),
	'textpath'       => array(
		'length' => true,
	),
	'linearGradient' => array(
		'id' => true,
	),
	'radialGradient' => array(
		'id' => true,
	),
);


/**
 * Combine allowed element arrays into usable combinations.
 */
$allow_post_with_svg     = array_merge( $core_post_defaults, $svg_graphic );
$allow_only_br           = array_merge( $only_br, $svg_graphic );
$allow_svg_graphics_only = array_merge( $svg_graphic );


/**
 * Define KSES constants.
 *
 * Use these constants with wp_kses() to sanitize user input.
 *
 * @link https://developer.wordpress.org/reference/functions/wp_kses/
 */
define( 'ALLOW_ONLY_BR', $only_br );
define( 'ALLOW_POST_WITH_SVG', $allow_post_with_svg );
define( 'ALLOW_ONLY_SVG', $allow_svg_graphics_only );
