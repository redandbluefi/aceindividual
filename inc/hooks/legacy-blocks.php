<?php 
/**
 * Legacy blocks
 *
 * @package eternia
 */

namespace Eternia\LegacyBlocks;

function register_legacy_blocks(){
	register_block_type('eternia/legacy-header', array(
		'attributes' => array(),
		'render_callback' => function($attributes = [], $content = null){
			ob_start();
			get_template_part('template-parts/legacy-blocks/header');
			return ob_get_clean();
		},
	));
	register_block_type('eternia/legacy-footer', array(
		'attributes' => array(),
		'render_callback' => function($attributes = [], $content = null){
			ob_start();
			get_template_part('template-parts/legacy-blocks/footer');
			return ob_get_clean();
		},
	));
}