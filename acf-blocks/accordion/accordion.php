<?php
/**
 * ACF Block: Accordion
 *
 * Part of Redandblue Block Library.
 *
 * @param array $block The block settings and attributes.
 *
 * @package eternia
 */

namespace Eternia;

if (!isset($block)) {
  return;
}

$block_id = 'block-accordion-' . $block['id'];

if (!empty($block['anchor'])) {
  $block_id = $block['anchor'];
}

// Required ACF-fields.
$accordions = get_field('accordions') ?? null;
$bg_image = get_field('bg_image') ?? null; // ID

if (empty($accordions)) {
  return;
}

// Additional ACF-fields.
$heading = get_field('top_level_heading') ?? null;
$heading_level = get_field('top_level_heading_level') ?? '2';
$ingress = get_field('ingress') ?? null;

$heading_open = false;
$heading_close = false;

// Heading level check.
$single_accordion_heading_level = 2;

if ($heading) {
  // Prepare heading tag.
  $heading_open = '<h' . esc_attr($heading_level) . ' class="text__heading h2">';
  $heading_close = '</h' . esc_attr($heading_level) . '>';

  $single_accordion_heading_level = $heading_level + 1;
}

$accordion_args = array(
  'single_accordion_heading_level' => $single_accordion_heading_level,
  'block_id' => $block_id,
);

?>
<section class="alignfull accordion layout-grid">
  <div id="<?php echo esc_attr($block_id); ?>" class="block-accordion alignwide">
    <?php
    if ($bg_image) { ?>
      <div class="block-accordion__bg-image-overlay">
        <?php
        echo wp_get_attachment_image($bg_image, 'full', false, array('class' => 'block-accordion__bg-image'));
        ?>
      </div> <?php
    }
    ?>
    <div class="block-accordion__heading">
      <div>
        <?php
        if ($heading_open && $heading_close) {
          // Heading.
          // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
          echo $heading_open . esc_html($heading) . $heading_close;
        }
        ?>
      </div>
      <?php if ($ingress): ?>
        <div>
          <p class="block-accordion__heading--ingress"><?php echo wp_kses($ingress, ALLOW_ONLY_BR); ?></p>
        </div>
      <?php endif; ?>
    </div>
    <div class="block-accordion__accordions">
      <?php
      foreach ($accordions as $counter => $accordion_item) {
        // Add accordion item to args.
        $accordion_args['accordion_item'] = $accordion_item;

        // Add counter to args.
        $accordion_args['counter'] = $counter;

        get_template_part('acf-blocks/accordion/template-parts/accordion-item', null, $accordion_args);
      }
      ?>
    </div>
  </div>
</section>