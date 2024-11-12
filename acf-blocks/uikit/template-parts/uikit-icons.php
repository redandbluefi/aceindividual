<?php
/**
 * Template part: UI Kit icons.
 * Parent block: UI Kit
 *
 * Dynamically fetches and displays all icons from the theme.
 *
 * @package Eternia
 */

namespace eternia;

$svg_folder = get_template_directory() . '/app/img/icons/';
$svg_files  = glob( $svg_folder . '*.svg' );

?>
<section class="uikit__icons" id="uikit-icons">
	<p>Unaltered icons:</p>
	<div class="icons-container icons-container--original">
		<?php
		foreach ( $svg_files as $svg_file ) {
			$svg_name = basename( $svg_file, '.svg' );
			?>
			<div class="icon icon--<?php echo esc_attr( $svg_name ); ?>">
				<?php inline_svg( $svg_name . '.svg', array( 'wrapper' => 'i' ), true ); ?>
			</div>
			<?php
		}
		?>
	</div>
	<p>Recolored icons:</p>
	<div class="icons-container icons-container--filled">
		<?php
		foreach ( $svg_files as $svg_file ) {
			$svg_name = basename( $svg_file, '.svg' );
			?>
			<div class="icon icon--<?php echo esc_attr( $svg_name ); ?>">
				<?php inline_svg( $svg_name . '.svg', array( 'wrapper' => 'i' ), true ); ?>
			</div>
			<?php
		}
		?>
	</div>
</section>