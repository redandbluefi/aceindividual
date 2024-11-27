<?php
/**
 * Header
 *
 * @package eternia
 */

namespace Eternia;

$lang_pid = get_default_lang_option();
$home_url = get_home_url();

$cta_button = get_field( 'cta_button', $lang_pid ) ?? '';
?>

<div class="header alignfull" id="main-navigation">
  <div class="header__navigation layout-grid">
	<div class="header__wrapper alignwide">
	  <div class="header__navigation-content desktop-only">
		<?php get_template_part( 'template-parts/header/nav-menu', null, array( 'context' => 'desktop' ) ); ?>
	  </div>
	  <div class="header__logo" id="logo">
		<a href="<?php echo esc_url( $home_url ); ?>">
		  <div class="logo-mobile">
			<?php inline_svg( 'logo-mobile.svg', array( 'wrapper' => 'div' ), true ); ?>
		  </div>
		  <div class="logo-desktop" style="display: none;">
			<?php inline_svg( 'logo-desktop.svg', array( 'wrapper' => 'div' ), true ); ?>
		  </div>
		</a>
	  </div>
	  <div class="header__cta desktop-only">
		<a href="<?php echo esc_url( $cta_button['url'] ); ?>" class="button-secondary">
		  <?php echo esc_html( $cta_button['title'] ); ?>
		  <?php inline_svg( 'arrow-right.svg', array( 'wrapper' => 'i' ), true ); ?>
		</a>
	  </div>
	</div>
  </div>
  <?php get_template_part( 'template-parts/header/nav-toggle' ); ?>
</div>
