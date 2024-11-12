<?php
/**
 * Site footer bottom bar
 *
 * @package eternia
 */

namespace Eternia;

$lang_pid       = get_default_lang_option();
$copyright_text = get_field( 'footer_copyright', $lang_pid ) ?? '';

// Add field to ACF site settings.
$copyright_text = function_exists( 'get_field' ) ? get_field( 'footer_copyright', $lang_pid ) : 'Eternia';

?>

<div class="site-footer__bottom-content">

	<p class="site-footer__copyright">
	<?php
	if ( $copyright_text ) :
		echo esc_html( translate__( $copyright_text, '', 'eternia' ) );
	endif;
	?>

	<span>
		<?php
      // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo gmdate( 'Y' );
		?>
	</span>
	</p>

</div>
