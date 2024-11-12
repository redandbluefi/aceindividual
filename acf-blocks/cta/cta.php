<?php
/**
 * ACF Block: CTA
 *
 * @package eternia
 */

namespace Eternia;

if ( ! isset( $block ) ) {
	return;
}

$block_id = 'block-cta-' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

// Required ACF fields.
$button  = get_field( 'cta_button' ) ?? null;
$heading = get_field( 'cta_title' ) ?? null;

// Fail fast if no heading or button.
if ( empty( $heading ) || empty( $button ) ) {
	return;
}

// Additional ACF fields.
$background_color = get_field( 'cta_background-color' ) ?? 'light';
$heading_level    = get_field( 'cta_heading-level' ) ?? '2';
$text             = get_field( 'cta_text' ) ?? null;

// Button fields.
$button_url    = $button['url'] ?? null;
$button_title  = $button['title'] ?? null;
$button_target = $button['target'] ?? '_self';

$allow_break = array( 'br' => array() );

// Wrapper classes.
$wrapper_classes = array( 'block-cta', 'block-cta--' . $background_color, 'alignfull', 'extend-layout-grid' );

// Check if block has additional classes from the editor.
if ( ! empty( $block['className'] ) ) {
	$wrapper_classes[] = $block['className'];
}

// Heading level check.
$opening_element = '<h' . esc_attr( $heading_level ) . ' class="block-cta__heading">';
$closing_element = '</h' . esc_attr( $heading_level ) . '>';

?>

<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>">
	<div class="block-cta__inner-content alignwide">

		<?php if ( $heading ) : ?>
			<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo $opening_element . $heading . $closing_element;
			?>
		<?php endif; ?>

		<?php if ( $text ) : ?>
			<p class="block-cta__text"><?php echo wp_kses( $text, $allow_break ); ?></p>
		<?php endif; ?>

		<?php if ( ( $button_url && $button_title ) && ( '_blank' === $button_target ) ) : ?>
			<a href="<?php echo esc_url( $button_url ); ?>" class="button button-primary" target="<?php echo esc_attr( $button_target ); ?>" rel="noreferrer noopener">
				<?php echo esc_html( $button_title ); ?>
				<span class="screen-reader-text"><?php echo esc_html( translate__( 'Avautuu uuteen välilehteen', '', 'eternia' ) ); ?></span>
			</a>
		<?php elseif ( $button_url && $button_title ) : ?>
			<a href="<?php echo esc_url( $button_url ); ?>" class="button button-primary" target="<?php echo esc_attr( $button_target ); ?>">
				<?php echo esc_html( $button_title ); ?>
			</a>
		<?php endif; ?>

	</div>
</section>
