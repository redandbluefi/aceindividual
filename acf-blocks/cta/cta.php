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

$background_image_id  = get_field( 'background_image' ) ?? null;
$background_image_url = $background_image_id ? wp_get_attachment_image_url( $background_image_id, 'full' ) : null;

$cta_title = get_field( 'cta_title' ) ?? null;

$cta_buttons = null;
if ( have_rows( 'cta_buttons' ) ) {
	$cta_buttons = array();
	while ( have_rows( 'cta_buttons' ) ) {
		the_row();
		$button = get_sub_field( 'cta_link' );
		if ( ! empty( $button ) && is_array( $button ) ) {
			$cta_buttons[] = array(
				'title'  => $button['title'] ?? '',
				'url'    => $button['url'] ?? '',
				'target' => $button['target'] ?? '_self',
			);
		}
	}
}

// Exit early if no buttons are defined.
if ( empty( $cta_buttons ) ) {
	return;
}

$wrapper_classes = array( 'block-cta', 'alignwide' );

if ( ! empty( $block['className'] ) ) {
	$wrapper_classes[] = $block['className'];
}

$section_style = '';
if ( ! empty( $background_image_url ) ) {
	$section_style = "background-image: url('" . esc_url( $background_image_url ) . "');";
}
?>

<section id="<?php echo esc_attr( $block_id ); ?> cta" class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>"
  style="<?php echo esc_attr( $section_style ); ?>">
  <div class="block-cta__inner-content alignwide">
	<?php if ( ! empty( $cta_title ) ) : ?>
	  <h2 class="block-cta__title"><?php echo esc_html( $cta_title ); ?></h2>
	<?php endif; ?>

	<?php if ( ! empty( $cta_buttons ) ) : ?>
	  <div class="block-cta__buttons">
		<?php foreach ( $cta_buttons as $index => $button ) : ?>
			<?php if ( ! empty( $button['url'] ) && ! empty( $button['title'] ) ) : ?>
		  <a href="<?php echo esc_url( $button['url'] ); ?>"
			 class="button button-secondary block-cta__button"
			 target="<?php echo esc_attr( $button['target'] ); ?>"
			 style="--cta-button-index: <?php echo $index; ?>">
				<?php echo esc_html( $button['title'] ); ?>
				<?php inline_svg( 'arrow-right.svg', array( 'wrapper' => 'i' ), true ); ?>
		  </a>
		  <?php endif; ?>
		<?php endforeach; ?>
	  </div>
	<?php endif; ?>
  </div>
</section>
