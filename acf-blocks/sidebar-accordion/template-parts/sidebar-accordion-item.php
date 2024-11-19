<?php
/**
 * ACF Block: Accordion - Accordion item template part
 *
 * @package eternia
 */

namespace Eternia;

if (empty($args['accordion_item']['accordion']['accordion_heading'])) {
  return;
}

$accordion_open_icon = 'chevron-down.svg';
$accordion_close_icon = 'chevron-up.svg';

$accordion_item_id = $args['block_id'] . '-' . $args['counter'];

// Set the accordion heading open and closing element.
$accordion_opening_element = '<h' . esc_attr($args['single_accordion_heading_level']) . ' class="accordion-item__title">';
$accordion_closing_element = '</h' . esc_attr($args['single_accordion_heading_level']) . '>';

?>

<div class="sidebar-accordion-item">
  <button id="<?php echo esc_attr($accordion_item_id); ?>"
    class="sidebar-accordion-item__header <?php echo $args['is_first'] ? 'is-active' : ''; ?>"
    aria-expanded="<?php echo $args['is_first'] ? 'true' : 'false'; ?>"
    aria-controls="sidebar-accordion-item__panel-<?php echo esc_attr($accordion_item_id); ?>">
    <span><?php echo esc_html($args['accordion_item']['accordion']['accordion_heading']); ?></span>
  </button>
  <div class="sidebar-accordion-item__panel"
    id="sidebar-accordion-item__panel-<?php echo esc_attr($accordion_item_id); ?>">
    <?php

    // Display quote_text if exists
    if (!empty($args['accordion_item']['accordion']['quote_text'])) { ?>
      <div class="quote">
        <?php
        // Display quote_author_image if exists
        if (!empty($args['accordion_item']['accordion']['quote_author_image'])) {
          $quote_author_image_id = $args['accordion_item']['accordion']['quote_author_image'];
          ?>
          <div class="quote-author-image">
            <?php echo wp_get_attachment_image($quote_author_image_id, 'full', false, array('class' => 'image')); ?>
          </div>
          <?php
        } ?>
        <p class='quote-text'>
          <span class="quote-icon">
            <?php echo inline_svg(
              '../icons/quote.svg',
              array(
                'wrapper' => 'i',
                'class' => 'quote-icon',
              ),
              true
            ); ?>
          </span>
          <?php echo esc_html($args['accordion_item']['accordion']['quote_text']) ?>
        </p>
      </div> <?php
    }

    // Display accordion_content
    if (!empty($args['accordion_item']['accordion']['accordion_content'])) {
      ?>
      <div class="accordion-item__content">
        <?php echo wp_kses_post($args['accordion_item']['accordion']['accordion_content']); ?>
      </div>
      <?php
    }
    ?>
  </div>
</div>