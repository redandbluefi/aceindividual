<?php
/**
 * Callback functions that modify the response headers.
 *
 * @package eternia
 */

namespace Eternia\Inc\Hooks\ResponseHeaders;

/**
 * Add Content Security Policy headers.
 * - Default values for project specific CSP headers are defined in theme-settings
 * - Values can be amended through eternia_csp_headers filter hook.
 *
 * @param array $headers Headers.
 * @return array $headers Modified headers.
 */
function add_csp_headers( array $headers ): array {
	// Apply headers only when not in admin area.
	if ( is_admin() ) {
		return $headers;
	}

	// CSP headers settings are and associative array in format 'directive' => array( 'value')
	// Example array( 'default-src' => array( "'self'", 'other-domain.com' ) ).
	$csp_headers_settings = apply_filters( 'eternia_csp_headers', THEME_SETTINGS['csp_headers'] );

	// Convert settings array to array of strings in format 'directive value'.
	$csp_headers_array = array_reduce(
		array_keys( $csp_headers_settings ),
		function ( $acc, $key ) use ( $csp_headers_settings ) {
			if ( ! empty( $csp_headers_settings[ $key ] ) && is_array( $csp_headers_settings[ $key ] ) ) {
					$acc[] = $key . ' ' . implode( ' ', $csp_headers_settings[ $key ] );
			}
			return $acc;
		},
		array()
	);

	// Join strings together and add to headers.
	if ( ! empty( $csp_headers_array ) ) {
		$headers['Content-Security-Policy'] = implode( '; ', $csp_headers_array );
	}

	return $headers;
}

/**
 * Add Content Security Policy headers for WP Admin Bar.
 * - Additional headers are added when admin bar is visible.
 *
 * @param array $csp_headers CSP headers.
 * @return array $csp_headers Modified CSP headers.
 */
function amend_csp_headers_for_wp_admin_bar( array $csp_headers ): array {
	// Apply only when admin bar is visible.
	if ( ! is_admin_bar_showing() ) {
		return $csp_headers;
	}

	$additional_headers = array(
		'img-src' => array( "'unsafe-inline'", 'data:' ),
	);

	$modified_headers = array_merge_recursive( $csp_headers, $additional_headers );

	return $modified_headers;
}
