<?php
/**
 * Site branding & logo
 *
 * @package eternia
 */

namespace Eternia;

?>

<div class="site-branding">

	<a class="site-branding__link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="logo" rel="home">
	<span class="screen-reader-text"><?php bloginfo( 'name' ); ?></span>
	<?php
	inline_svg(
		'logo-desktop.svg',
		array(
			'class'    => 'site-branding__logo',
			'itemprop' => 'logo',
		),
		true
	);
	?>
	</a>

</div>
