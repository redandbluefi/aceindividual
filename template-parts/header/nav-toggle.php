<?php
/**
 * Navigation toggle button
 *
 * @package eternia
 */

namespace Eternia;

$defaults = array(
  'class' => 'nav-toggle',
  'additional_classes' => 'nav-toggle--open mobile-only',
  'aria_label_open' => translate__('Avaa navigointivalikko', '', 'eternia'),
  'aria_label_close' => translate__('Sulje navigointivalikko', '', 'eternia'),
  'button_id' => 'menu-toggle',
  'button_text' => translate__('Valikko', '', 'eternia'),
  'icon_open' => 'menu.svg',
  'icon_close' => 'close.svg',
);

$args = array_merge($defaults, $args);
$wrapper_classes = $args['additional_classes'] ? $args['class'] . ' ' . $args['additional_classes'] : $args['class'];
$icon_class = $args['class'] . '__icon';
?>

<div class="<?php echo esc_attr($wrapper_classes); ?>">
  <button aria-controls="nav" id="<?php echo esc_attr($args['button_id']); ?>"
    class="<?php echo esc_attr($args['class']); ?>__button" type="button" data-action="open"
    data-aria-close="<?php echo esc_attr($args['aria_label_close']); ?>"
    data-aria-open="<?php echo esc_attr($args['aria_label_open']); ?>"
    aria-label="<?php echo esc_attr($args['aria_label_open']); ?>">
    <?php if ($args['button_text']): ?>
      <span
        class="<?php echo esc_attr($args['class']); ?>__text sr-only"><?php echo esc_html($args['button_text']); ?></span>
    <?php endif; ?>
    <?php
    inline_svg(
      $args['icon_open'],
      array(
        'wrapper' => 'i',
        'class' => "$icon_class $icon_class--open",
      ),
      true
    );
    ?>
    <?php
    inline_svg(
      $args['icon_close'],
      array(
        'wrapper' => 'i',
        'class' => "$icon_class $icon_class--close",
      ),
      true
    );
    ?>
  </button>
</div>
