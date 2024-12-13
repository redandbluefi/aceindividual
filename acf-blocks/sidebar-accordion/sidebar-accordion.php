<?php
/**
 * ACF Block: Accordion
 *
 * Part of Redandblue Block Library.
 *
 * @param array $block The block settings and attributes.
 *
 * @package eternia
 */

namespace Eternia;

if ( ! isset( $block ) ) {
	return;
}

$block_id = 'block-accordion-' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

// Required ACF-fields.
$accordions = get_field( 'accordions' ) ?? null;


if ( empty( $accordions ) ) {
	return;
}

// Additional ACF-fields.
$heading       = get_field( 'top_level_heading' ) ?? null;
$heading_level = get_field( 'top_level_heading_level' ) ?? '2';
$ingress       = get_field( 'ingress' ) ?? null;

$heading_open  = false;
$heading_close = false;

// Heading level check.
$single_accordion_heading_level = 2;

if ( $heading ) {
	// Prepare heading tag.
	$heading_open  = '<h' . esc_attr( $heading_level ) . ' class="text__heading h2">';
	$heading_close = '</h' . esc_attr( $heading_level ) . '>';

	$single_accordion_heading_level = $heading_level + 1;
}

$accordion_args = array(
	'single_accordion_heading_level' => $single_accordion_heading_level,
	'block_id'                       => $block_id,
);

?>
<section id="<?php echo esc_attr( $block_id ); ?>" class="sidebar-accordion alignwide">
  <div class="sidebar-accordion__container">
	<div class="sidebar-accordion__heading">
	  <?php if ( $heading_open && $heading_close ) : ?>
			<?php
			// Heading
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $heading_open . esc_html( $heading ) . $heading_close;
			?>
	  <?php endif; ?>

	  <?php if ( $ingress ) : ?>
		<p class="sidebar-accordion__ingress"><?php echo wp_kses( $ingress, ALLOW_ONLY_BR ); ?></p>
	  <?php endif; ?>
	</div>
	<div class="sidebar-accordion__content__wrapper">
	  <aside class="sidebar-accordion__sidebar">
		<div class="sidebar-accordion__items">
		  <?php
			foreach ( $accordions as $counter => $accordion_item ) {
				$accordion_args['accordion_item'] = $accordion_item;
				$accordion_args['counter']        = $counter;
				$accordion_args['is_first']       = $counter === 0; // Mark the first item

				get_template_part( 'acf-blocks/sidebar-accordion/template-parts/sidebar-accordion-item', null, $accordion_args );
			}
			?>
		</div>
	  </aside>
	  <div class="sidebar-accordion__content">
		<?php
		// Display content of the first accordion item by default
		if ( ! empty( $accordions[0]['accordion']['accordion_content'] ) ) {
			echo wp_kses_post( $accordions[0]['accordion']['accordion_content'] );
		}
		?>
	  </div>
	</div>
  </div>
</section>
