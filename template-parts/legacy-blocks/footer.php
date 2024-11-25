<section class="site-footer__main-section alignwide">
  <div class="site-footer__navigation">
	<?php get_template_part( 'template-parts/footer/footer-contact', null, array( 'context' => 'desktop' ) ); ?>
	<?php get_template_part( 'template-parts/footer/footer-links', null, array( 'context' => 'desktop' ) ); ?>
	<?php get_template_part( 'template-parts/footer/footer-menu', null, array( 'context' => 'desktop' ) ); ?>
  </div>
</section>
<section class="site-footer__bottom-section alignwide">
  <div class="wrapper alignwide">
	<?php get_template_part( 'template-parts/header/branding', null, array( 'additional_classes' => 'site-branding--footer' ) ); ?>
	<?php get_template_part( 'template-parts/footer/footer-bottom' ); ?>
  </div>
</section>
