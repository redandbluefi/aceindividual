<div class="top-bar desktop-only alignwide" id="header-top-bar">
	<div class="top-bar__content-wrapper">
		<?php
		get_template_part(
			'template-parts/header/nav-search',
			null,
			array(
				'additional_classes' => 'desktop-only',
				'button_id'          => 'nav-search-desktop',
			)
		);
		?>
		<?php get_template_part( 'template-parts/header/nav-lang-switcher', null, array( 'additional_classes' => 'desktop-only' ) ); ?>
	</div>
</div>
<div class="main-navigation alignwide" id="main-navigation">
	<?php get_template_part( 'template-parts/header/branding', null, array( 'additional_classes' => 'site-branding--header' ) ); ?>
	<div class="main-navigation__content-wrapper desktop-only">
		<?php get_template_part( 'template-parts/header/nav-menu', null, array( 'context' => 'desktop' ) ); ?>
	</div>
	<?php get_template_part( 'template-parts/header/nav-toggle' ); ?>
</div>