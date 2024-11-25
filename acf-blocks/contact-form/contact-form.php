<?php
/**
 * ACF Block: Contact Section
 *
 * @package eternia
 */
namespace Eternia;

if ( ! isset( $block ) ) {
	return;
}

$block_id = 'block-contact-' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

$title                 = get_field( 'title' ) ?: 'Yhteystiedot';
$ingress               = get_field( 'ingress' );
$personnel             = get_field( 'personnel' );
$contact_title         = get_field( 'contact_title' );
$contact_opening_hours = get_field( 'contact_opening_hours' );
$contact_email         = get_field( 'contact_email' );
$contact_mobile        = get_field( 'contact_mobile' );
$contact_form_title    = get_field( 'contact_form_title' );
$contact_form          = get_field( 'contact_form' );

$wrapper_classes = array( 'block-contact', 'alignwide' );

if ( ! empty( $block['className'] ) ) {
	$wrapper_classes[] = $block['className'];
}
?>

<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>">
  <div class="block-contact__section block-contact__intro">
	<?php if ( ! empty( $title ) ) : ?>
	  <h2 class="block-contact__title"><?php echo esc_html( $title ); ?></h2>
	<?php endif; ?>

	<?php if ( ! empty( $ingress ) ) : ?>
	  <p class="block-contact__ingress"><?php echo esc_html( $ingress ); ?></p>
	<?php endif; ?>
  </div>

  <div class="block-contact__left-column">
	<?php if ( ! empty( $personnel ) && is_array( $personnel ) ) : ?>
	  <div class="block-contact__section block-contact__personnel">
		<?php foreach ( $personnel as $person ) : ?>
			<?php if ( ! empty( $person ) && is_array( $person ) ) : ?>
			<div class="person">
				<?php if ( ! empty( $person['image'] ) ) : ?>
				<div class="person__image">
				  <img src="<?php echo esc_url( wp_get_attachment_image_url( $person['image'], 'medium' ) ); ?>"
					alt="<?php echo ! empty( $person['name'] ) ? esc_attr( $person['name'] ) : ''; ?>">
				</div>
			  <?php endif; ?>

			  <div class="person__details">
				<?php if ( ! empty( $person['name'] ) ) : ?>
				  <h3 class="person__name"><?php echo esc_html( $person['name'] ); ?></h3>
				<?php endif; ?>

				<?php if ( ! empty( $person['role'] ) ) : ?>
				  <p class="person__role"><?php echo esc_html( $person['role'] ); ?></p>
				<?php endif; ?>

				<?php if ( ! empty( $person['email'] ) ) : ?>
				  <p class="person__email">
					<a
					  href="mailto:<?php echo esc_attr( antispambot( $person['email'] ) ); ?>"><?php echo esc_html( antispambot( $person['email'] ) ); ?></a>
				  </p>
				<?php endif; ?>

				<?php if ( ! empty( $person['mobile'] ) ) : ?>
					<?php $person_mobile_href = str_replace( ' ', '', $person['mobile'] ); ?>
				  <p class="person__mobile">
					<a href="tel:<?php echo esc_attr( $person_mobile_href ); ?>"><?php echo esc_html( $person['mobile'] ); ?></a>
				  </p>
				<?php endif; ?>
			  </div>
			</div>
		  <?php endif; ?>
		<?php endforeach; ?>
	  </div>
	<?php endif; ?>

	<?php if ( ! empty( $contact_title ) || ! empty( $contact_opening_hours ) || ! empty( $contact_email ) || ! empty( $contact_mobile ) ) : ?>
	  <div class="block-contact__section block-contact__info">
		<?php if ( ! empty( $contact_title ) ) : ?>
		  <h3 class="block-contact__contact-title"><?php echo esc_html( $contact_title ); ?></h3>
		<?php endif; ?>

		<?php if ( ! empty( $contact_opening_hours ) ) : ?>
		  <p class="block-contact__opening-hours"><?php echo esc_html( $contact_opening_hours ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $contact_email ) ) : ?>
		  <p class="block-contact__email">
			<a
			  href="mailto:<?php echo esc_attr( antispambot( $contact_email ) ); ?>"><?php echo esc_html( antispambot( $contact_email ) ); ?></a>
		  </p>
		<?php endif; ?>

		<?php if ( ! empty( $contact_mobile ) ) : ?>
			<?php $contact_mobile_href = str_replace( ' ', '', $contact_mobile ); ?>
		  <p class="block-contact__mobile">
			<a href="tel:<?php echo esc_attr( $contact_mobile_href ); ?>"><?php echo esc_html( $contact_mobile ); ?></a>
		  </p>
		<?php endif; ?>
	  </div>
	<?php endif; ?>
  </div>

  <div class="block-contact__right-column">
	<?php if ( ! empty( $contact_form_title ) ) : ?>
	  <h3 class="block-contact__form-title"><?php echo esc_html( $contact_form_title ); ?></h3>
	<?php endif; ?>

	<?php if ( ! empty( $contact_form ) && is_numeric( $contact_form ) ) : ?>
	  <div class="block-contact__form">
		<?php echo do_shortcode( '[gravityform id="' . esc_attr( $contact_form ) . '" title="false" description="false" ajax="true"]' ); ?>
	  </div>
	<?php endif; ?>
  </div>
</section>
