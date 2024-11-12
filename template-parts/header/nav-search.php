<?php
/**
 * Navigation search button
 *
 * @package eternia
 */

namespace Eternia;

$defaults = array(
	'class'              => 'nav-search',
	'additional_classes' => null,
	'button_id'          => 'nav-search',
);

$args            = array_merge( $defaults, $args );
$wrapper_classes = $args['additional_classes'] ? $args['class'] . ' ' . $args['additional_classes'] : $args['class'];

?>

<div class="<?php echo esc_attr( $wrapper_classes ); ?>">
	<button class="<?php echo esc_attr( $args['class'] ); ?>__button"
			id="<?php echo esc_attr( $args['button_id'] ); ?>"
			type="button">
			<?php
			inline_svg( 'search.svg', array( 'wrapper' => 'i' ), true );
			?>
			<?php echo esc_html( __( 'Haku', 'eternia' ) ); ?>
	</button>
</div>
