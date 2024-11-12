<?php
/**
 * UI kit -block
 *
 * This kit renders content for the site, to validate if
 * the styles are properly applied. This version is modular,
 * so you can show only the parts you want to test.
 *
 * Choose the modules shown in the block editor.
 *
 * @param array $block ACF block object.
 * @return void Markup for block registration.
 *
 * @author Red & Blue
 * @version 2.1.0
 * @package Eternia
 */

namespace eternia;

// Return if block settings aren't included.
if ( ! $block ) {
	return;
}

add_acf_preview_image( $block );
$block_anchor = get_block_anchor_link( $block );

// Get block settings.
$modules_to_show = get_field( 'modules_to_show' ) ?? array();

if ( ! $modules_to_show || ! is_array( $modules_to_show ) ) {
	return; // Render nothing.
}

?>
<section class="uikit uikit__block alignfull" id="<?php echo esc_attr( $block_anchor ); ?>" data-block="uikit">
	<?php
	get_template_part( 'acf-blocks/uikit/template-parts/uikit', 'header' );

	foreach ( $modules_to_show as $module ) {
		$slug  = $module['value'];
		$label = $module['label'];
		get_template_part( 'acf-blocks/uikit/template-parts/uikit', 'sectionheader', array( 'section_title' => $label ) );
		get_template_part( 'acf-blocks/uikit/template-parts/uikit', $slug );
	}

	get_template_part( 'acf-blocks/uikit/template-parts/uikit', 'footer' );
	?>
</section>