<?php
/**
 * Theme constants.
 *
 * @package eternia
 */

namespace Eternia;

define( 'ETERNIA_VERSION', '1.0.0' );

/**
 * Check is constant ICL_LANGUAGE_CODE defined, a.k.a. is Polylang (or WPML) installed.
 * If not, set ICL_LANGUAGE_CODE to 'fi' or 'en'.
 */
if ( ! defined( 'ICL_LANGUAGE_CODE' ) ) :
	if ( get_locale() === 'fi' ) :
		define( 'ICL_LANGUAGE_CODE', 'fi' );
	else :
		define( 'ICL_LANGUAGE_CODE', 'en' );
	endif;
endif;

/**
 * Define a list of all custom blocks in this theme.
 *
 * Blocks are the names of the folders directly beneath acf/blocks
 */
$block_folders = is_dir( dirname( __DIR__, 2 ) . '/acf-blocks' ) ? scandir( dirname( __DIR__, 2 ) . '/acf-blocks' ) : array();
define( 'ETERNIA_BLOCKS', $block_folders );

/**
 * Define name for cache log file.
 * - This log is used for logging cache operations, e.g. when cache keys are busted on post save.
 */
$eternia_log_args = array(
	'log_file'       => 'eternia__cache.log',
	'production_log' => true,
);
define( 'ETERNIA_CACHE_LOG', $eternia_log_args );
