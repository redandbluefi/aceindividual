<?php
/**
 * Template part: UI Kit section header.
 * Parent block: UI Kit
 *
 * Used between different UI kit sections to emphasize the change.
 *
 * @package Eternia
 */

namespace eternia;

$default_args  = array(
	'section_title' => 'Osion otsikko',
);
$args          = isset( $args ) ? array_merge( $default_args, $args ) : $default_args;
$section_title = $args['section_title'];

?>
<header class="uikit__sectionheader">
	<?php if ( ! empty( $section_title ) ) : ?>
		<p><?php echo esc_html( $section_title ); ?></p>
	<?php endif; ?>
</header>