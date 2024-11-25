<?php
/**
 * Template name: Wide Template
 *
 * @package eternia
 */

namespace Eternia;

the_post();

// split content to hero ($hero_block) and rest ($content_blocks).
$content_page_id    = get_the_id();
$content_blocks     = $content_page_id ? parse_blocks( get_post( $content_page_id )->post_content ) : null;
$hero_content_block = $content_blocks && ( 'acf/frontpage-hero' === $content_blocks[0]['blockName'] ) ? array_shift( $content_blocks ) : null;
// Note that above $hero_block and $triple_hero_content_block is removed from $content_blocks array so it won't be rendered if user has added a hero as the first block in Gutenberg.

get_header(); ?>

<?php
// acf/hero-frontpage block is rendered separately as full width outside the grid (.main-grid).
if ( $hero_content_block ) {
  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo render_block( $hero_content_block );
}
?>

<div class="layout-grid content wide-template">

  <?php do_action( 'before_frontpage_content' ); ?>

  <?php
	// All the rest of the content blocks are rendered here.

	if ( $content_blocks ) {
		foreach ( $content_blocks as $block ) {


			/**
			 * Core embed can not be parsed with render_block() function alone, as its
			 * html needs to be parsed through the_content filter.
			 *
			 * The filter however causes weird glitches with other blocks, so we need to
			 * isolate the core/embed block and parse it separately.
			 */
			if ( 'core/embed' === $block['blockName'] ) {
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo apply_filters( 'the_content', $block['innerHTML'] );

				continue;
			}

		  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo render_block( $block );
		}
	}
	?>

</div>

<?php

get_footer();
