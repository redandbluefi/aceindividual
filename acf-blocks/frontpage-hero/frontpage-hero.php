<?php
/**
 * ACF Block: Frontpage Hero
 *
 * @package eternia
 */

namespace Eternia;

if (!isset($block)) {
  return;
}

$block_id = 'block-frontpage-hero-' . $block['id'];

if (!empty($block['anchor'])) {
  $block_id = $block['anchor'];
}

// Required ACF fields.
$heading = get_field('frontpage-hero_title') ?? null;
$image = get_field('frontpage-hero_image') ?? null;

// Fail fast if no heading or image.
if (empty($heading) || empty($image)) {
  return;
}

// Additional ACF fields.
$text = get_field('frontpage-hero_text') ?? null;
$buttons = get_field('frontpage-hero_buttons') ?? null;

$allow_break = array('br' => array());

// Wrapper classes.
$wrapper_classes = array('block-frontpage-hero', 'alignfull', 'extend-layout-grid');

// Check if block has additional classes from the editor.
if (!empty($block['className'])) {
  $wrapper_classes[] = $block['className'];
}
?>

<section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr(implode(' ', $wrapper_classes)); ?>">
  <div class="block-frontpage-hero__inner-content alignwide">

    <?php if ($image): ?>
      <div class="block-frontpage-hero__image mobile-only">
        <?php echo wp_get_attachment_image($image['id'], '1536x1536'); ?>
      </div>
    <?php endif; ?>

    <div class="block-frontpage-hero__text-wrapper">
      <?php if ($heading): ?>
        <h1 class="block-frontpage-hero__title"><?php echo esc_html($heading); ?></h1>
      <?php endif; ?>

      <?php if ($text): ?>
        <div class="block-frontpage-hero__text"><?php echo wp_kses_post($text); ?></div>
      <?php endif; ?>

      <?php if (have_rows('frontpage-hero_buttons')): ?>
        <div class="block-frontpage-hero__buttons">
          <?php while (have_rows('frontpage-hero_buttons')): ?>
            <?php
            the_row();
            $button = get_sub_field('frontpage-hero_button');
            $button_url = $button['url'] ?? null;
            $button_title = $button['title'] ?? null;
            $button_target = $button['target'] ?? null;
            ?>

            <?php if (($button_url && $button_title) && ('_blank' === $button_target)): ?>
              <a href="<?php echo esc_url($button_url); ?>" class="button-primary-icon"
                target="<?php echo esc_attr($button_target); ?>" rel="noreferrer noopener">
                <?php echo esc_html($button_title); ?>
                <?php inline_svg('external.svg', array('wrapper' => 'i'), true); ?>
                <div class="button-content">
                  <span
                    class="screen-reader-text"><?php echo esc_html(', ' . translate__('Avautuu uuteen välilehteen', '', 'eternia')); ?></span>
                </div>
              </a>
            <?php elseif ($button_url && $button_title): ?>
              <a href="<?php echo esc_url($button_url); ?>" class="button-primary"
                target="<?php echo esc_attr($button_target); ?>">
                <?php echo esc_html($button_title); ?>
              </a>
            <?php endif; ?>
          <?php endwhile; ?>
        </div>
      <?php endif; ?>
    </div>

    <?php if ($image): ?>
      <div class="block-frontpage-hero__image desktop-only">
        <?php echo wp_get_attachment_image($image['id'], '1536x1536'); ?>
      </div>
    <?php endif; ?>

  </div>
</section>
