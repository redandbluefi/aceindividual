<?php
/**
 * ACF Block: Two Column Block
 *
 * @package eternia
 */
namespace Eternia;

if ( ! isset( $block ) ) {
	return;
}

$block_id = 'two-column-block-' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

$left_column  = get_field( 'left_column' );
$right_column = get_field( 'right_column' );

$left_title = ! empty( $left_column['left_title'] ) ? $left_column['left_title'] : null;
$left_text  = ! empty( $left_column['left_text'] ) ? $left_column['left_text'] : null;

$right_title = ! empty( $right_column['right_title'] ) ? $right_column['right_title'] : null;
$right_text  = ! empty( $right_column['right_text'] ) ? $right_column['right_text'] : null;

$wrapper_classes = array( 'two-column-block', 'alignwide' );

if ( ! empty( $block['className'] ) ) {
	$wrapper_classes[] = $block['className'];
}
?>

<section id="<?php echo esc_attr( $block_id ); ?> two-column-block" class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>">
	<div class="two-column-block__column--left">
		<?php if ( $left_title || $left_text ) : ?>
			<?php if ( $left_title ) : ?>
				<h2 class="two-column-block__title"><?php echo esc_html( $left_title ); ?></h2>
			<?php endif; ?>
			<?php if ( $left_text ) : ?>
				<p class="two-column-block__text"><?php echo wp_kses( $left_text, ALLOW_ONLY_BR ); ?></p>
			<?php endif; ?>
		<?php endif; ?>
	</div>
	<div class="two-column-block__column--right">
		<?php if ( $right_title || $right_text ) : ?>
			<?php if ( $right_title ) : ?>
				<h2 class="two-column-block__title"><?php echo esc_html( $right_title ); ?></h2>
			<?php endif; ?>
			<?php if ( $right_text ) : ?>
				<p class="two-column-block__text"><?php echo wp_kses( $right_text, ALLOW_ONLY_BR ); ?></p>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</section>
