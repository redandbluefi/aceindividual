<?php
/**
 * Mobile menu dialog
 *
 * @package eternia
 */

namespace Eternia;

?>

<dialog class="mobile-menu" id="mobile-menu">

	<div class="mobile-menu__content-wrapper">

	<div class="mobile-menu__section mobile-menu__section--top">

		<?php get_template_part( 'template-parts/header/nav-search', null, array( 'button_id' => 'nav-search-mobile' ) ); ?>

	</div>

	<div class="mobile-menu__section mobile-menu__section--navigation">

		<?php
		get_template_part(
			'template-parts/header/nav-menu',
			null,
			array(
				'context'     => 'mobile',
				'toggle_icon' => 'arrow-down.svg',
			)
		);
		?>

	</div>

	<div class="mobile-menu__section mobile-menu__section--lang">

		<?php get_template_part( 'template-parts/header/nav-lang-switcher' ); ?>

	</div>

	</div>

</dialog>
