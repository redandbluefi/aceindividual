<?php
/**
 * Navigation layout
 *
 * @package eternia
 */

namespace Eternia;

$defaults = array(
	'class'              => 'nav-primary',
	'additional_classes' => null,
	'context'            => 'desktop',
);

$args            = array_merge( $defaults, $args );
$wrapper_classes = $args['additional_classes'] ? $args['class'] . ' ' . $args['additional_classes'] : $args['class'];

?>

<nav id="<?php echo 'nav-' . esc_attr( $args['context'] ); ?>" 
	class="<?php echo esc_attr( $wrapper_classes ); ?>" 
	aria-label="<?php echo esc_attr( get_default_localization( 'Main navigation' ) ); ?>">

	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'primary',
			'container'      => false,
			'depth'          => 2,
			'menu_class'     => $args['class'] . '__menu-items',
			'menu_id'        => 'main-menu-' . $args['context'],
			'echo'           => true,
			'fallback_cb'    => __NAMESPACE__ . '\Nav_Walker::fallback',
			'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'has_dropdown'   => true,
			'walker'         => new Nav_Walker(),
		)
	);
	?>

</nav><!-- #nav -->
