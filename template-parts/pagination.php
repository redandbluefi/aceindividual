<?php
/**
 * Template part for displaying pagination
 *
 * @package eternia
 */

namespace Eternia;

// Print pagination.
$pagination_args = array(
	'mid_size'           => 1,
	'prev_next'          => true,
	'before_page_number' => '<span class="screen-reader-text">' . esc_html(
		translate__( 'Sivu', 'Sivutus', 'eternia' )
	) . '</span> ',
	'prev_text'          => inline_svg( 'chevron-left.svg', array( 'wrapper' => 'i' ), true ) . '<span class="screen-reader-text">' .
	esc_html( translate__( 'Edellinen sivu', 'Sivutus', 'eternia' ) ) . '</span>',
	'next_text'          => inline_svg( 'chevron-right.svg', array( 'wrapper' => 'i' ), true ) . '<span class="screen-reader-text">' .
	esc_html( translate__( 'Seuraava sivu', 'Sivutus', 'eternia' ) ) . '</span>',
);

the_posts_pagination( $pagination_args );
