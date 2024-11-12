<?php
/**
 * Rest API handling
 *
 * @package eternia
 */

/**
 * Add ACF fields to REST API
 *
 * @param WP_REST_Response $response The response object.
 * @param object           $post The post object.
 * @param object           $request The request object.
 * @return WP_REST_Response Modified response object.
 */
function acf_to_rest_api( $response, $post, $request ) { // phpcs:ignore
	if ( ! function_exists( 'get_fields' ) ) :
		return $response;
	endif;
	if ( isset( $post ) ) {
		$acf                   = get_fields( $post->id );
		$response->data['acf'] = $acf;
	}
	return $response;
} // end acf_to_rest_api
add_filter( 'rest_prepare_post', 'acf_to_rest_api', 10, 3 );
