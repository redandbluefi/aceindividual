<?php
/**
 * User roles
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Modify theme user roles
 */
function eternia_modify_user_roles() {
	// Remove Yoast 'SEO Manager' role.
	if ( \get_role( 'wpseo_manager' ) ) {
		\remove_role( 'wpseo_manager' );
	}

	// Remove Yoast 'SEO Editor' role.
	if ( \get_role( 'wpseo_editor' ) ) {
		\remove_role( 'wpseo_editor' );
	}
} // end eternia_modify_user_roles

/* Register CLI command for modifying user roles */
$eternia_delete_roles = function () {
	if ( function_exists( 'Eternia\eternia_modify_user_roles' ) ) {
		eternia_modify_user_roles();

		\WP_CLI::success( 'Roles deleted' );
	} else {
		\WP_CLI::error( ' function not existing ' );
	}
};

if ( defined( 'WP_CLI' ) && \WP_CLI ) {
	/**
	 * Modify theme user roles
	 * call `wp eternia delete roles`
	 */
	\WP_CLI::add_command( 'eternia delete roles', $eternia_delete_roles );
}
