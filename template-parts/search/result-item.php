<?php
/**
 * Template Part for displaying search result.
 *
 * @param array $args - Arguments for the item
 *
 * @package eternia
 */

namespace Eternia;

$result_extra_classes = $args['result_extra_classes'] ?? '';
$result_id            = $args['result_id'] ?? null;

// Basic data.
$result_type     = get_post_type( $result_id ) ?? '';
$result_title    = get_the_title( $result_id ) ?? '';
$result_date     = get_the_date( get_option( 'date_format' ), $result_id ) ?? '';
$result_datetime = get_the_date( 'c', $result_id ) ?? '';
$result_excerpt  = get_post_field( 'post_excerpt', $result_id ) ?? '';
$result_link     = get_permalink( $result_id ) ?? '';

// Image.
$image_id              = get_post_thumbnail_id( $result_id ) ?? '';
$placeholder_image_url = get_stylesheet_directory_uri() . '/build/img/placeholder.png';
$placeholder_html      = $placeholder_image_url ? '<img src="' . $placeholder_image_url . '" alt="" />' : '';
$image_html            = $image_id ? wp_get_attachment_image( $image_id, 'thumbnail', false, array( 'class' => 'result-img' ) ) : $placeholder_html;

// Terms. Example: category. Works also with custom taxonomies.
$result_category_name = rnb_get_first_term_object( $result_id, 'category' )->name ?? '';

$result_classes = 'search__result';

if ( $result_extra_classes ) :
	$result_classes .= ' ' . $result_extra_classes;
endif;

?>

<div class="<?php echo esc_attr( $result_classes ); ?>">
	<div class="search__result-image-wrap">
	<?php if ( $image_html ) : ?>
		<?php echo wp_kses_post( $image_html ); ?>
	<?php elseif ( $placeholder_image ) : ?>
		<img src="<?php echo esc_url( $placeholder_image ); ?>" alt="" />
	<?php endif; ?>
	</div>

	<div class="search__result-content">
	<div class="search__result-info">
		<?php if ( $result_date ) : ?>
		<time class="search__result-date" datetime="<?php echo esc_attr( $result_datetime ); ?>">
			<?php echo esc_html( $result_date ); ?>
		</time>
		<?php endif; ?>
		<?php if ( $result_type && $result_date ) : ?>
		-
		<?php endif; ?>
		<?php if ( $result_type ) : ?>
		<span class="search__result-type">
			<?php echo esc_html( $result_type ); ?>
		</span>

		<?php endif; ?>
		<?php if ( $result_category_name ) : ?>
		-
		<span class="search__result-category">
			<?php echo esc_html( $result_category_name ); ?>
		</span>
		<?php endif; ?>

	</div>
	<?php if ( $result_title ) : ?>
		<h2 class="search__result-title">
		<?php if ( $result_link ) : ?>
			<a href="<?php echo esc_url( $result_link ); ?>">
			<?php endif; ?>
			<?php echo esc_html( $result_title ); ?>
			<?php if ( $result_link ) : ?>
			</a>
		<?php endif; ?>
		</h2>
	<?php endif; ?>
	<?php if ( $result_excerpt ) : ?>
		<p class="search__result-excerpt"><?php echo esc_html( $result_excerpt ); ?></p>
	<?php endif; ?>
	</div>
</div>
