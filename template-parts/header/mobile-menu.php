<?php
/**
 * Mobile menu dialog
 *
 * @package eternia
 */

namespace Eternia;

$lang_pid = get_default_lang_option();

$cta_button = get_field( 'cta_button', $lang_pid ) ?? '';

?>

<dialog class="mobile-menu" id="mobile-menu">

  <div class="mobile-menu__content-wrapper">

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

  </div>

  <div class="mobile-menu__section mobile-menu__section--cta">
  <?php get_template_part( 'template-parts/header/nav-lang-switcher' ); ?>
	<?php if ( $cta_button ) : ?>
	<a id="menu-mobile__contact-button" href="<?php echo esc_url( $cta_button['url'] ); ?>" class="button-secondary">
	  <span>
		<?php echo esc_html( $cta_button['title'] ); ?>
		<?php inline_svg( 'arrow-right.svg', array( 'wrapper' => 'i' ), true ); ?>
	  </span>
	</a>
	<?php endif; ?>
  </div>

</dialog>
