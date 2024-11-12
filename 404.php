<?php
/**
 * The template for displaying error 404 pages (not found)
 *
 * @package eternia
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 */

namespace Eternia;

get_header();

$lang_pid = get_default_lang_option();

$heading = get_field( '404_heading', $lang_pid ) ?? '';
$text    = get_field( '404_text', $lang_pid ) ?? '';

?>

<section class="block block-error-404">
	<div class="layout-grid">
		<div class="content">
			<h1 id="content">404 <span class="screen-reader-text"><?php echo esc_html( $heading ); ?></span></h1>
			<h2 aria-hidden="true"><?php echo esc_html( $heading ); ?></h2>
			<p><?php echo esc_html( $text ); ?></p>
		</div>
	</div>
</section>

<?php

get_footer();

// WordPress scripts and hooks.
wp_footer();
