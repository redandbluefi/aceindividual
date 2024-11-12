<?php
/**
 * Some menu layout
 *
 * @package eternia
 */

namespace Eternia;

$defaults = array(
	'class'              => 'nav-some',
	'additional_classes' => null,
	'context'            => 'desktop',
);

$args            = array_merge( $defaults, $args );
$wrapper_classes = $args['additional_classes'] ? $args['class'] . ' ' . $args['additional_classes'] : $args['class'];

?>

<nav id="<?php echo 'nav-some-' . esc_attr( $args['context'] ); ?>"
	class="<?php echo esc_attr( $wrapper_classes ); ?>"
	aria-label="<?php echo esc_attr( get_default_localization( 'Social media menu' ) ); ?>">

	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'some',
			'container'      => false,
			'menu_class'     => esc_attr( $args['class'] ) . '__menu-items',
			'menu_id'        => 'some-menu-' . esc_attr( $args['context'] ),
			'echo'           => true,
			'fallback_cb'    => '__return_false',
			'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		)
	);
	?>

</nav><!-- #nav -->
