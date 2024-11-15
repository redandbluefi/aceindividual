<?php
/**
 * Footer menu layout
 *
 * @package eternia
 */

namespace Eternia;

$defaults = array(
  'class' => 'site-footer__menu',
  'additional_classes' => null,
  'context' => 'desktop',
);

$args = array_merge($defaults, $args);
$wrapper_classes = $args['additional_classes'] ? $args['class'] . ' ' . $args['additional_classes'] : $args['class'];

?>

<div class="<?php echo esc_html($wrapper_classes); ?>"
  aria-label="<?php echo esc_html(get_default_localization('Footer menu')); ?>">

  <?php
  wp_nav_menu(
    array(
      'theme_location' => 'footer',
      'container' => false,
      'menu_class' => $args['class'] . '__menu-items',
      'menu_id' => 'footer-menu-' . $args['context'],
      'echo' => true,
      'fallback_cb' => '__return_false',
      'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
    )
  );
  ?>

</div><!-- #nav -->
