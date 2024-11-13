<?php
/**
 * Template part: UI Kit buttons.
 * Parent block: UI Kit
 *
 * Prints example buttons to display the site button styles.
 * Add the button styles used on your site.
 *
 * @package Eternia
 */

namespace eternia;

?>
<section class="uikit__buttons" id="uikit-buttons">
  <a class="button-primary">
    <span>
      Button primary
    </span>
  </a>
  <a class="button-primary">
    <span>
      Button primary
      <?php inline_svg('arrow-right.svg', array('wrapper' => 'i'), true); ?>
    </span>
  </a>
  <button class="button-secondary">
    <span>
      Button secondary
    </span>
  </button>
  <button class="button-secondary">
    <span>
      Button secondary
      <?php inline_svg('arrow-right.svg', array('wrapper' => 'i'), true); ?>
    </span>
  </button>
  <button class="button-tertiary">
    Button tertiary
  </button>
  <button class="button-tertiary">
    Button tertiary
    <?php inline_svg('arrow-right.svg', array('wrapper' => 'i'), true); ?>
  </button>
</section>
