<?php
/**
 * Logging helper functions.
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Helper function to write message / variable to a log file
 *
 * @param mixed $item The item to be logged.
 * @param array $args Optional arguments.
 *                                  'log_file' => (string) Log file name, overrides default file name set in THEME_SETTINGS.
 *                                  'production_log' => (bool) Whether to allow logging in production environment. Default false.
 * @return bool True if logging was successful, false if not.
 */
function write_log( $item = null, $args = array() ) {
	$log_file_override = $args['log_file'] ?? null;
	$production_log    = $args['production_log'] ?? false;

	$local_environment = 'local' === wp_get_environment_type();

	// Fail early: allow logging only if defined as "production log" OR in Local environment OR if WP_DEBUG is true.
	if ( ! $local_environment && ( WP_DEBUG !== true ) && ! $production_log ) {
		return false;
	}

	// Define log file to be used.
	$default_log_file = THEME_SETTINGS['log_file'] ?? 'eternia__debug.log';
	$log_file         = $log_file_override ?? $default_log_file;

	// File path: Set according to environment.
	$local_file_path  = ''; // In Local as a default (if not defined), log file will be created in /app/public/ OR /app/public/wp-admin/ folder.
	$seravo_file_path = '/data/log/';
	$log_file_path    = $local_environment ? $local_file_path : $seravo_file_path;

	$message = '';

	$output_maxlength = THEME_SETTINGS['log_output_maxlength'] ?? 10000;

	// If WP_Error, log only the error message.
	// For arrays and objects, log the whole array/object.
	// For strings, log the string.
	if ( is_wp_error( $item ) ) {
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r
		$message = print_r( $item->get_error_messages(), true );
	} elseif ( is_array( $item ) || is_object( $item ) ) {
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r
		$message = print_r( $item, true );
	} else {
		$message = $item;
	}

	// Sanitize output length so that it won't get too long and break the log file.
	if ( is_string( $message ) && strlen( $message ) > $output_maxlength ) {
		$message = substr( $message, 0, $output_maxlength );
	}

	$message_with_meta = wp_date( 'Y-m-d H:i:s' ) . ' | ' . $message . "\n";
	// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
	error_log( $message_with_meta, 3, $log_file_path . $log_file );

	return true;
}
