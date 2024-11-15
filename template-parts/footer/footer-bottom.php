<?php
/**
 * Site footer bottom bar
 *
 * @package eternia
 */

namespace Eternia;

$lang_pid = get_default_lang_option();
$copyright_text = get_field('footer_copyright', $lang_pid) ?? '';
$privacy_policy_link = get_field('footer_privacy_policy_link', $lang_pid) ?? '';
if ($privacy_policy_link) {
  $url = $privacy_policy_link['url'];
  $title = $privacy_policy_link['title'];
  $target = $privacy_policy_link['target'] ? ' target="' . esc_attr($privacy_policy_link['target']) . '"' : '';
}

// Add field to ACF site settings.
$copyright_text = function_exists('get_field') ? get_field('footer_copyright', $lang_pid) : 'Eternia';

?>

<div class="site-footer__bottom-content">

  <?php if ($privacy_policy_link): ?>
    <a href="<?php echo esc_url($url); ?>" class="site-footer__privacy-policy-link" <?php echo esc_attr($target); ?>>
      <?php echo esc_html($title); ?>
    </a>
  <?php endif; ?>

  <p class="site-footer__copyright">
    <?php
    if ($copyright_text):
      echo esc_html($copyright_text);
    endif;
    ?>

    <span>
      <?php
      // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
      echo gmdate('Y');
      ?>
    </span>
  </p>

</div>
