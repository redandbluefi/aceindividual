<?php
/**
 * Include custom features etc.
 *
 * @package eternia
 */

namespace Eternia;

// Constants.
require_once __DIR__ . '/includes/constants.php';

// KSES.
require_once __DIR__ . '/includes/kses.php';

// Theme setup.
require_once __DIR__ . '/includes/theme-setup.php';

// Logging/debugging helper functions.
require_once __DIR__ . '/includes/logging.php';

// Localized strings.
require_once __DIR__ . '/includes/localization.php';

// Rest route.
require_once __DIR__ . '/includes/restroute.php';

// Editor colors.
require_once __DIR__ . '/includes/editor.php';

// User roles.
require_once __DIR__ . '/includes/user-roles.php';

// Nav Walker.
require_once __DIR__ . '/includes/nav-walker.php';

// Helpers.
require_once __DIR__ . '/includes/helpers.php';

// Post type and taxonomy base classes.
// We check this with if, because this stuff will not go to WP theme directory.
if ( file_exists( __DIR__ . '/includes/taxonomy.php' ) ) {
	require_once __DIR__ . '/includes/taxonomy.php';
}

if ( file_exists( __DIR__ . '/includes/post-type.php' ) ) {
	require_once __DIR__ . '/includes/post-type.php';
}

// Custom functions.

// Breadcrumbs.
require_once __DIR__ . '/includes/breadcrumb.php';

// Polylang get strings to translate.
require_once __DIR__ . '/includes/polylang-wrapper.php';
require_once __DIR__ . '/includes/polylang-register-strings.php';

// Require acf-block related include files.
$block_inc_files = glob( dirname( __DIR__ ) . '/acf-blocks/*/inc/*.php' );
if ( is_array( $block_inc_files ) ) {
	foreach ( $block_inc_files as $file ) {
		require_once $file;
	}
}

// Redis cache.
require_once __DIR__ . '/includes/redis-cache.php';

// Trim excerpt function.
require_once __DIR__ . '/includes/trim-excerpt.php';
