<?php
/**
 * Footer contact section
 *
 * @package eternia
 */

namespace Eternia;

$lang_pid = get_default_lang_option();

// ACF fields
$footer_contact_title = get_field( 'footer_contact_title', $lang_pid ) ?? '';
$footer_contact_text  = get_field( 'footer_contact_text', $lang_pid ) ?? '';
$footer_contact_email = get_field( 'footer_contact_email', $lang_pid ) ?? '';
$footer_contact_phone = get_field( 'footer_contact_phone', $lang_pid ) ?? '';

$footer_customer_title = get_field( 'footer_customer_title', $lang_pid ) ?? '';
$footer_customer_text  = get_field( 'footer_customer_text', $lang_pid ) ?? '';
$footer_customer_email = get_field( 'footer_customer_email', $lang_pid ) ?? '';
$footer_customer_phone = get_field( 'footer_customer_phone', $lang_pid ) ?? '';

$footer_cta_button = get_field( 'footer_cta_button', $lang_pid ) ?? '';
if ( $footer_cta_button ) {
	$button_url    = $footer_cta_button['url'] ?? '';
	$button_title  = $footer_cta_button['title'] ?? '';
	$button_target = $footer_cta_button['target'] ? ' target="' . esc_attr( $footer_cta_button['target'] ) . '"' : '';
}

$wrapper_classes = 'site-footer__contact';
?>

<div class="<?php echo esc_attr( $wrapper_classes ); ?>">

  <div class="<?php echo esc_attr( $wrapper_classes . '__contact' ); ?>">
	<?php if ( ! empty( $footer_contact_title ) ) : ?>
	  <h3 class="<?php echo esc_attr( $wrapper_classes . '__title' ); ?>">
		<?php echo esc_html( $footer_contact_title ); ?>
	  </h3>
	<?php endif; ?>

	<?php if ( ! empty( $footer_contact_text ) ) : ?>
	  <p class="<?php echo esc_attr( $wrapper_classes . '__text' ); ?>">
		<?php echo wp_kses( $footer_contact_text, ALLOW_ONLY_BR ); ?>
	  </p>
	<?php endif; ?>

	<?php if ( ! empty( $footer_contact_email ) ) : ?>
	  <p class="<?php echo esc_attr( $wrapper_classes . '__email' ); ?>">
		<a href="mailto:<?php echo antispambot( esc_attr( $footer_contact_email ) ); ?>"
		  class="<?php echo esc_attr( $wrapper_classes . '__link' ); ?>">
		  <?php echo esc_html( $footer_contact_email ); ?>
		</a>
	  </p>
	<?php endif; ?>

	<?php if ( ! empty( $footer_contact_phone ) ) : ?>
	  <p class="<?php echo esc_attr( $wrapper_classes . '__phone' ); ?>">
		<a href="tel:<?php echo esc_attr( $footer_contact_phone ); ?>"
		  class="<?php echo esc_attr( $wrapper_classes . '__link' ); ?>">
		  <?php echo esc_html( $footer_contact_phone ); ?>
		</a>
	  </p>
	<?php endif; ?>
  </div>


  <div class="<?php echo esc_attr( $wrapper_classes . '__customer' ); ?>">
	<?php if ( ! empty( $footer_customer_title ) ) : ?>
	  <h3 class="<?php echo esc_attr( $wrapper_classes . '__title' ); ?>">
		<?php echo esc_html( $footer_customer_title ); ?>
	  </h3>
	<?php endif; ?>

	<?php if ( ! empty( $footer_customer_text ) ) : ?>
	  <p class="<?php echo esc_attr( $wrapper_classes . '__text' ); ?>">
		<?php echo wp_kses( $footer_customer_text, ALLOW_ONLY_BR ); ?>
	  </p>
	<?php endif; ?>

	<?php if ( ! empty( $footer_customer_email ) ) : ?>
	  <p class="<?php echo esc_attr( $wrapper_classes . '__email' ); ?>">
		<a href="mailto:<?php echo antispambot( esc_attr( $footer_customer_email ) ); ?>"
		  class="<?php echo esc_attr( $wrapper_classes . '__link' ); ?>">
		  <?php echo esc_html( $footer_customer_email ); ?>
		</a>
	  </p>
	<?php endif; ?>

	<?php if ( ! empty( $footer_customer_phone ) ) : ?>
	  <p class="<?php echo esc_attr( $wrapper_classes . '__phone' ); ?>">
		<a href="tel:<?php echo esc_attr( $footer_customer_phone ); ?>"
		  class="<?php echo esc_attr( $wrapper_classes . '__link' ); ?>">
		  <?php echo esc_html( $footer_customer_phone ); ?>
		</a>
	  </p>
	<?php endif; ?>
  </div>

  <div class="<?php echo esc_attr( $wrapper_classes . '__lang' ); ?>">
	  <?php get_template_part( 'template-parts/header/nav-lang-switcher' ); ?>
  </div>

  <?php if ( ! empty( $button_url ) && ! empty( $button_title ) ) : ?>
	<div class="<?php echo esc_attr( $wrapper_classes . '__cta' ); ?>">
	  <a href="<?php echo esc_url( $button_url ); ?>" class="button-secondary" <?php echo esc_attr( $button_target ); ?>>
		<?php echo esc_html( $button_title ); ?>
		<?php inline_svg( 'arrow-right.svg', array( 'wrapper' => 'i' ), true ); ?>
	  </a>
	</div>
  <?php endif; ?>


</div>
