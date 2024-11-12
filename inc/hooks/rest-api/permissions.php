<?php
/**
 * REST API endpoints permission & other authorization related callbacks
 *
 * @package eternia
 */

namespace Eternia;

use WP_Error;
use WP_REST_Request;

/**
 * Restrict access to specifies default WP REST API routes.
 *
 * @param mixed                    $response - The response object.
 * @param mixed                    $handler - The handler object.
 * @param WP_REST_Request|WP_Error $request - The request object OR WP_Error object on failure.
 */
function restrict_wp_default_api_requests( $response, $handler, \WP_REST_Request $request ): mixed {
	// Do not restrict access to the REST API for logged in users who have right to access wp-admin.
	if ( current_user_can( 'edit_posts' ) ) {
		return $response;
	}

	// Restrict access to following routes.
	// Routes can include wildcards (*) to match any character sequence.
	$admin_content_routes = array(
		'/wp/v2/users',
		'/wp/v2/users/*',
	);

	foreach ( $admin_content_routes as $pattern ) {
		// Escape special regex characters.
		$pattern = preg_quote( $pattern, '/' );

		// Replace the wildcard * with a regex that matches any character sequence.
		$pattern = str_replace( '\*', '.*', $pattern );

		// Add start and end anchors.
		$pattern = '/^' . $pattern . '$/';

		// If the requested route matches the pattern, return an error.
		if ( 1 === preg_match( $pattern, $request->get_route() ) ) {
			return new WP_Error( 'unauthorized_access', 'Sorry, you are not authorized to access this data.', array( 'status' => 401 ) );
		}
	}

	return $response;
}
