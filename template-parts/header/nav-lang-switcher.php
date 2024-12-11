<?php
/**
 * Language switcher
 *
 * @package eternia
 */

namespace Eternia;

$defaults = array(
	'class'              => 'nav-lang-switcher',
	'additional_classes' => null,
);

$args            = array_merge( $defaults, $args );
$wrapper_classes = $args['additional_classes'] ? $args['class'] . ' ' . $args['additional_classes'] : $args['class'];
$lang_args       = array(
	'hide_current'     => 0,
	'display_names_as' => 'slug',
	'hide_if_empty'    => 0,
	'raw'              => 1,
);
$langs           = function_exists( 'pll_the_languages' ) ? pll_the_languages( $lang_args ) : null;
?>

<?php if ( $langs ) : ?>

	<ul class="<?php echo esc_attr( $wrapper_classes ); ?>">

	<?php
	foreach ( $langs as $lang ) :
		$active_lang  = $lang['current_lang'] ? 'active-lang' : '';
		$link_classes = $active_lang ? $args['class'] . '__link ' . $active_lang : $args['class'] . '__link';
		?>

		<li class="<?php echo esc_attr( $args['class'] ); ?>__item">
		<a class="<?php echo esc_attr( $link_classes ); ?>"
		href="<?php echo esc_url( $lang['url'] ); ?>"
		lang="<?php echo esc_attr( $lang['slug'] ); ?>"
		hreflang="<?php echo esc_attr( $lang['slug'] ); ?>">
			<?php echo esc_html( $lang['name'] ); ?>
		</a>
		</li>

	<?php endforeach; ?>

	</ul>

<?php endif; ?>
