<?php
/**
 * Template Part for displaying general article card in blocks.
 *
 * @param array $args - Arguments for the item
 *
 * @package eternia
 */

namespace Eternia;

$item_id = $args['item_id'] ?? null;

// Classes.
$item_classes       = 'lift-card';
$item_extra_classes = $args['item_extra_classes'] ?? '';

if ( $item_extra_classes ) :
	$item_classes .= ' ' . $item_extra_classes;
endif;

// Basic data.
$item_type     = get_post_type( $item_id ) ?? '';
$item_title    = get_the_title( $item_id ) ?? '';
$item_date     = get_the_date( get_option( 'date_format' ), $item_id ) ?? '';
$item_datetime = get_the_date( 'c', $item_id ) ?? '';

$show_excerpt = $args['show_excerpt'] ?? false;
$item_excerpt = get_post_field( 'post_excerpt', $item_id ) ?? '';

$item_link = get_permalink( $item_id ) ?? '';

// Heading level check.
$parent_heading_level = $args['parent_heading_level'] ?? '';
$heading_level        = 2;

if ( $parent_heading_level ) {
	$heading_level = $parent_heading_level + 1;
}

// Set the heading level.
$opening_element = '<h' . esc_attr( $heading_level ) . ' class="lift-card__title">';
$closing_element = '</h' . esc_attr( $heading_level ) . '>';

// Image.
$image_id              = get_post_thumbnail_id( $item_id ) ?? '';
$placeholder_image_url = get_stylesheet_directory_uri() . '/build/img/placeholder.png';
$placeholder_html      = $placeholder_image_url ? '<img src="' . $placeholder_image_url . '" alt="" />' : '';
$image_html            = $image_id ? wp_get_attachment_image( $image_id, 'medium', false, array( 'class' => 'lift-card__img' ) ) : $placeholder_html;

// Terms. Get terms and list them separated with comma.
$terms      = wp_get_post_terms( $item_id, 'category', array( 'fields' => 'names' ) );
$terms_list = '';

if ( is_array( $terms ) ) {
	$terms_list = implode( ', ', $terms );
}

?>

<li class="<?php echo esc_attr( $item_classes ); ?>">
	<div class="lift-card__image-wrap">
	<?php if ( $image_html ) : ?>
		<?php echo wp_kses_post( $image_html ); ?>
	<?php elseif ( $placeholder_image ) : ?>
		<img src="<?php echo esc_url( $placeholder_image ); ?>" alt="" />
	<?php endif; ?>
	</div>

	<div class="lift-card__content">
	<p class="lift-card__info">
		<?php if ( $item_date ) : ?>
		<time class="lift-lift-card__date" datetime="<?php echo esc_attr( $item_datetime ); ?>">
			<?php echo esc_html( $item_date ); ?>
		</time>
		<?php endif; ?>

		<?php if ( $terms ) : ?>
		<span class="lift-card__category">
			<?php echo esc_html( $terms_list ); ?>
		</span>
		<?php endif; ?>
	</p>

	<?php if ( $item_title ) : ?>
		<?php
			echo $opening_element; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
		<?php if ( $item_link ) : ?>
			<a href="<?php echo esc_url( $item_link ); ?>">
		<?php endif; ?>
		<?php echo esc_html( $item_title ); ?>
		<?php if ( $item_link ) : ?>
			</a>
		<?php endif; ?>
		<?php
			echo $closing_element; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
	<?php endif; ?>
	<?php if ( $show_excerpt && $item_excerpt ) : ?>
		<p class="lift-card__excerpt"><?php echo esc_html( $item_excerpt ); ?></p>
	<?php endif; ?>
	</div>
</li>
