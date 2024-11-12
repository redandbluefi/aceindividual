<section class="site-footer__main-section alignwide">
	<div class="site-footer__eternia">
		<?php get_template_part( 'template-parts/header/branding', null, array( 'additional_classes' => 'site-branding--footer' ) ); ?>
	</div>
	<div class="site-footer__navigation">
		<?php get_template_part( 'template-parts/footer/footer-menu', null, array( 'context' => 'desktop' ) ); ?>
	</div>
	<div class="site-footer__social-links">
		<?php get_template_part( 'template-parts/footer/some-menu', null, array( 'context' => 'desktop' ) ); ?>
	</div>
</section>
<section class="site-footer__bottom-section alignwide">
	<?php get_template_part( 'template-parts/footer/footer-bottom' ); ?>
</section>