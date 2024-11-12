<?php
/**
 * ACF Block: Accordion - Accordion item template part
 *
 * @package eternia
 */

namespace Eternia;

if ( empty( $args['accordion_item']['accordion']['accordion_heading'] ) ) {
	return;
}

$accordion_open_icon  = 'chevron-down.svg';
$accordion_close_icon = 'chevron-up.svg';

$accordion_item_id = $args['block_id'] . '-' . $args['counter'];

// Set the accordion heading open and closing element.
$accordion_opening_element = '<h' . esc_attr( $args['single_accordion_heading_level'] ) . ' class="accordion-item__title">';
$accordion_closing_element = '</h' . esc_attr( $args['single_accordion_heading_level'] ) . '>';

?>

<div class="accordion-item">
	<?php
    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $accordion_opening_element;
	?>
	<button id="<?php echo esc_attr( $accordion_item_id ); ?>"
	class="accordion-item__header"
	aria-expanded="false"
	aria-controls="accordion-item__panel-<?php echo esc_attr( $accordion_item_id ); ?>">
		<span><?php echo esc_html( $args['accordion_item']['accordion']['accordion_heading'] ); ?></span>
		<span class="accordion-icon-wrapper">
		<?php
		inline_svg(
			'../block-icons/accordion-open.svg',
			array(
				'wrapper' => 'i',
				'class'   => 'open-icon',
			),
			true
		);
		?>
		<?php
		inline_svg(
			'../block-icons/accordion-close.svg',
			array(
				'wrapper' => 'i',
				'class'   => 'close-icon',
			),
			true
		);
		?>
		</span>
	</button>

	<?php
    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $accordion_closing_element;
	?>

	<div class="accordion-item__section-wrapper">
	<section id="accordion-item__panel-<?php echo esc_attr( $accordion_item_id ); ?>" class="accordion-item__panel entry-content" aria-labelledby="<?php echo esc_attr( $accordion_item_id ); ?>">
		<div class="accordion-item__content">
			<?php echo wp_kses_post( $args['accordion_item']['accordion']['accordion_content'] ); ?>
		</div>
	</section>
	</div>
</div>
