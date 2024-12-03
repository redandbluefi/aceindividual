<?php
/**
 * ACF Block: Information Section
 *
 * @package eternia
 */

namespace Eternia;

if ( ! isset( $block ) ) {
	return;
}

$block_id = 'block-info-' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

// ACF fields.
$left_title          = get_field( 'left_title' ) ?? 'Tietoa yrityksestä';
$left_content        = get_field( 'left_content' ) ?? null;
$right_repeater      = get_field( 'right_repeater' ) ?? array();
$background_image_id = get_field( 'background_image' ) ?? null;

$background_image_url = $background_image_id ? wp_get_attachment_image_url( $background_image_id, 'full' ) : null;

// Wrapper classes.
$wrapper_classes = array( 'block-info', 'alignfull', 'extend-layout-grid' );

// Check if block has additional classes from the editor.
if ( ! empty( $block['className'] ) ) {
	$wrapper_classes[] = $block['className'];
}

?>

<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>"
						<?php
						if ( $background_image_url ) :
							?>
	style="background-image: url('<?php echo esc_url( $background_image_url ); ?>');" <?php endif; ?>>
  <div class="block-info__container alignwide">
	<div class="block-info__left">
	  <h2 class="block-info__title">
		<?php echo esc_html( $left_title ); ?>
	  </h2>
	  <div class="block-info__content">
		<?php echo wp_kses_post( $left_content ); ?>
	  </div>
	</div>

	<div class="block-info__right">
	  <?php if ( ! empty( $right_repeater ) ) : ?>
		<div class="block-info__items">
			<?php foreach ( $right_repeater as $index => $item ) : ?>
				<?php
				$item_title = $item['item_title'] ?? '';
				$item_text  = $item['item_text'] ?? '';
				?>
			<div class="block-info__item" style="--item-index: <?php echo esc_attr( $index ); ?>;">
				<?php if ( ! empty( $item_title ) ) : ?>
				<h3 class="block-info__item__title">
					<?php echo esc_html( $item_title ); ?>
				</h3>
			  <?php endif; ?>
				<?php if ( ! empty( $item_text ) ) : ?>
				<p class="block-info__item__text">
					<?php echo wp_kses( $item_text, ALLOW_ONLY_BR ); ?>
				</p>
			  <?php endif; ?>
			</div>
		  <?php endforeach; ?>
		</div>
	  <?php endif; ?>
	</div>
  </div>
</section>
