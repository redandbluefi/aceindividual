<?php
/**
 * Footer menu layout
 *
 * @package eternia
 */

namespace Eternia;

$lang_pid = get_default_lang_option();

// ACF fields
$footer_links = get_field('footer_sitemap_links', $lang_pid) ?? '';

$wrapper_classes = 'site-footer__sitemap';
?>

<div class="<?php echo esc_attr($wrapper_classes); ?>"
  aria-label="<?php echo esc_attr(get_default_localization('Footer menu')); ?>">

  <ul class="<?php echo esc_attr($wrapper_classes . '__menu-items'); ?>">

    <?php
    if (!empty($footer_links)):
      foreach ($footer_links as $link_item):
        if (!isset($link_item['link'])) {
          continue;
        }
        $link = $link_item['link'];

        $url = isset($link['url']) ? $link['url'] : '';
        $title = isset($link['title']) ? $link['title'] : '';
        $target = !empty($link['target']) ? ' target="' . esc_attr($link['target']) . '"' : '';

        if (empty($url) || empty($title)) {
          continue;
        }
        ?>

        <li class="<?php echo esc_attr($wrapper_classes . '__menu-item'); ?>">
          <a href="<?php echo esc_url($url); ?>" class="<?php echo esc_attr($wrapper_classes . '__menu-link'); ?>" <?php echo esc_attr($target); ?>>
            <?php echo esc_html($title); ?>
          </a>
        </li>

        <?php
      endforeach;
    endif;
    ?>

  </ul>

</div><!-- #nav -->
