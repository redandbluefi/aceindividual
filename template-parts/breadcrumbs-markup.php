<?php
/**
 * Template part for breadcrumbs markup
 *
 * @package eternia
 */

namespace Eternia;

$defaults = array(
	'home_text'                  => translate__( 'Etusivu', '', 'eternia' ),
	'wrapper_block_class'        => 'rnb-breadcrumbs',
	'additional_wrapper_classes' => '',
);

$breadcrumb_args = array_merge( $defaults, $args );
$breadcrumb_item = new Breadcrumb( $breadcrumb_args );

?>

<?php
// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
echo $breadcrumb_item->print();
