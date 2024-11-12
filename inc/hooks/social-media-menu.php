<?php
/**
 * Walker for the social media menu.
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Callback function for adding icons to the Some menu.
 *
 * @param string $output The menu item's starting HTML output.
 * @param object $item Menu item data object.
 * @param int    $depth Depth of menu item. Used for padding.
 * @param object $args An object of wp_nav_menu() arguments.
 *
 * @return string The menu item's modified HTML output.
 */
function some_icons_output( $output, $item, $depth, $args ) {

	// Rework the some menu markup with icons.
	if ( 'some' === $args->theme_location ) {
		$filepath = get_template_directory();

		switch ( strtolower( $item->title ) ) {

			case 'facebook':
				$inline_svg = inline_svg( 'social-facebook.svg', array( 'wrapper' => 'i' ) );
				if ( $inline_svg ) :
					$output = '<a href="' . esc_url( $item->url ) . '" title="' . esc_attr( $item->title ) . '" target="_blank" rel="noopener noreferrer">' . $inline_svg . '<span class="screen-reader-text">' . esc_html( $item->title ) . '</span></a>';
				else :
					$output = '<a href="' . esc_url( $item->url ) . '" title="' . esc_attr( $item->title ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $item->title ) . '</a>';
				endif;
				break;

			case 'twitter':
				$inline_svg = inline_svg( 'social-x.svg', array( 'wrapper' => 'i' ) );
				if ( $inline_svg ) :
					$output = '<a href="' . esc_url( $item->url ) . '" title="' . esc_attr( $item->title ) . '" target="_blank" rel="noopener noreferrer">' . $inline_svg . '<span class="screen-reader-text">' . esc_html( $item->title ) . '</span></a>';
				else :
					$output = '<a href="' . esc_url( $item->url ) . '" title="' . esc_attr( $item->title ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $item->title ) . '</a>';
				endif;
				break;

			case 'x':
				$inline_svg = inline_svg( 'social-x.svg', array( 'wrapper' => 'i' ) );
				if ( isset( $inline_svg ) ) :
					$output = '<a href="' . esc_url( $item->url ) . '" title="' . esc_attr( $item->title ) . '" target="_blank" rel="noopener noreferrer">' . $inline_svg . '<span class="screen-reader-text">' . esc_html( $item->title ) . '</span></a>';
				else :
					$output = '<a href="' . esc_url( $item->url ) . '" title="' . esc_attr( $item->title ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $item->title ) . '</a>';
				endif;
				break;

			case 'youtube':
				$inline_svg = inline_svg( 'social-youtube.svg', array( 'wrapper' => 'i' ) );
				if ( $inline_svg ) :
					$output = '<a href="' . esc_url( $item->url ) . '" title="' . esc_attr( $item->title ) . '" target="_blank" rel="noopener noreferrer">' . $inline_svg . '<span class="screen-reader-text">' . esc_html( $item->title ) . '</span></a>';
				else :
					$output = '<a href="' . esc_url( $item->url ) . '" title="' . esc_attr( $item->title ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $item->title ) . '</a>';
				endif;
				break;

			case 'instagram':
				$inline_svg = inline_svg( 'social-instagram.svg', array( 'wrapper' => 'i' ) );
				if ( $inline_svg ) :
					$output = '<a href="' . esc_url( $item->url ) . '" title="' . esc_attr( $item->title ) . '" target="_blank" rel="noopener noreferrer">' . $inline_svg . '<span class="screen-reader-text">' . esc_html( $item->title ) . '</span></a>';
				else :
					$output = '<a href="' . esc_url( $item->url ) . '" title="' . esc_attr( $item->title ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $item->title ) . '</a>';
				endif;
				break;
			case 'linkedin':
				$inline_svg = inline_svg( 'social-linkedin.svg', array( 'wrapper' => 'i' ) );
				if ( $inline_svg ) :
					$output = '<a href="' . esc_url( $item->url ) . '" title="' . esc_attr( $item->title ) . '" target="_blank" rel="noopener noreferrer">' . $inline_svg . '<span class="screen-reader-text">' . esc_html( $item->title ) . '</span></a>';
				else :
					$output = '<a href="' . esc_url( $item->url ) . '" title="' . esc_attr( $item->title ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $item->title ) . '</a>';
				endif;
				break;
		}
	}

	return $output;
} // end some_icons_output
