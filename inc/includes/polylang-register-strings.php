<?php
/**
 * Eternia's own functions for showing translated strings with Polylang or fallback to not translated one if Polylang is not installed
 *
 * @package eternia
 */

namespace Eternia;

// To get the is_plugin_active() function to work, we need to include plugin.php file.
require_once ABSPATH . 'wp-admin/includes/plugin.php';

$single_translatable_string = '';

if ( function_exists( 'pll_register_string' ) ) {
	$strings_to_translate = get_option( 'eternia_strings_to_translate', array() );
	// into stringsToTranslate array we get this kind of string "('Hello world', 'description for the client', 'Group')".

	foreach ( $strings_to_translate as $value ) {
		$temp_string = explode( "', '", trim( $value, '() ' ) );

		/**
	 * We get this kind of array:
	 * array(3) {
	 * [0]=> string(12) "('Hello world"
	 * [1]=> string(26) "description for the client"
	 * [2]=> string(6) "Group')"
	 * }
	 */

		// remove first and last brakets from string.
		$single_translatable_string = trim( $temp_string[0] ?? '', "'\"" );
		$context                    = trim( $temp_string[1] ?? '', "'\"" );
		$group                      = trim( $temp_string[2] ?? '', "'\"" );

		// get site name from wp_options table.
		$site_name = get_bloginfo( 'name' );

		// if $group is empty or has only empty '' add $site_name to $group.
		if ( '' === $group || "''" === $group ) {
			$group = $site_name;
		}

		if ( '' !== $single_translatable_string ) {
			pll_register_string( $context, $single_translatable_string, $group );
		}
	}
} else {
	// If Polylang isn't installed, you can still use Eternia's own translate__ function.
	translate__( $single_translatable_string );
}

/**
 * Set plugins to get string translations automatically.
 * NOTE: This filter doesn't work if you use wp-cli command `wp eternia set strings to translate`.
 *
 * @return array array of plugin directories to translate.
 */
function plugins_to_translate() {
	return array(
		'plugin-folder-name',
	);
} // end plugins_to_translate

// add_filter( 'eternia_plugins_to_string_translation', 'plugins_to_translate', 10, 1); // Uncomment this line to use filter.

/**
 * Get all files from directory and subdirectories
 *
 * @param string $dir_name directory name.
 * @return array $results array of files from selected directories and subdirectories.
 */
function get_files_from_dir( $dir_name ) {
	$results = array();

	$files_extensions = array(
		'php',
		'inc',
		'twig',
	);

	// Exclude these directories from active theme directory.
	$directories_to_exclude = array(
		'vendor',
		'node_modules',
		'gulp',
		'build',
		'acf-json',
		'app',
		'lang',
	);

	// Scandir all files and directories. exclude directories from $directories_to_exclude.
	$files = array_diff( scandir( $dir_name ), $directories_to_exclude );
	foreach ( $files as $key => $value ) {
		$path = realpath( $dir_name . DIRECTORY_SEPARATOR . $value );
		if ( ! is_dir( $path ) ) {
			$path_parts = pathinfo( $path );
			if ( ! empty( $path_parts['extension'] ) && in_array( $path_parts['extension'], $files_extensions, true ) ) {
				$results[] = $path;
			}
		} elseif ( '.' !== $value && '..' !== $value ) {
			$temp    = get_files_from_dir( $path );
			$results = array_merge( $results, $temp );
		}
	}

	return $results;
} // end get_files_from_dir

/**
 * Get strings from files
 *
 * @param array $files array of files.
 * @return array $strings array of strings.
 */
function get_strings_from_files( $files ) {
	$single_quote_temp_pattern = "\'";
	$single_quote_temp_reg     = '[\single_quote]';

	$double_quote_temp_pattern = '\"';
	$double_quote_temp_reg     = '[\double_quote]';

	$strings = array();
	foreach ( $files as $file ) {

		// Get file name with extension.
		$file_name = basename( $file );
		$content   = file_get_contents( $file ); // phpcs:ignore
		$content   = str_replace( $single_quote_temp_pattern, $single_quote_temp_reg, $content );
		$content   = str_replace( $double_quote_temp_pattern, $double_quote_temp_reg, $content );

		// preg_match the content inside translate__ function parentheses.
		preg_match_all( "/translate__\(\s*(?:'|\")([^'\"]*?)(?:'|\")\s*(?:,|;)\s*(?:'|\")([^'\"]*?)(?:'|\")\s*(?:,|;)\s*(?:'|\")([^'\"]*?)(?:'|\")\s*\)/", $content, $matches_three_parameters );

		// preg_match the content inside translate__ function parentheses with only two parameters.
		preg_match_all( "/translate__\(\s*(?:'|\")([^'\"]*?)(?:'|\")\s*(?:,|;)\s*(?:'|\")([^'\"]*?)(?:'|\")\s*\)/", $content, $matches_two_parameters );

		// preg_match the content inside translate__ function parentheses with only one parameter.
		preg_match_all( "/translate__\(\s*(?:'|\")([^'\"]*?)(?:'|\")\s*\)/", $content, $matches_one_parameter );

		if ( ! empty( $matches_three_parameters[0] ) ) {
			// Remove 'translate__' from $matches_three_parameters[0] array items.
			$matches_three_parameters[0] = str_replace( 'translate__', '', $matches_three_parameters[0] );

			$strings = array_merge( $strings, $matches_three_parameters[0] );
		}

		if ( ! empty( $matches_two_parameters[0] ) ) {
			// Remove 'translate__' from $matches_two_parameters[0] array items.
			$matches_two_parameters[0] = str_replace( 'translate__', '', $matches_two_parameters[0] );

			$strings = array_merge( $strings, $matches_two_parameters[0] );
		}

		if ( ! empty( $matches_one_parameter[0] ) ) {
			// Remove 'translate__' from $matches_one_parameter[0] array items.
			$matches_one_parameter[0] = str_replace( 'translate__', '', $matches_one_parameter[0] );

			$strings = array_merge( $strings, $matches_one_parameter[0] );
		}
	}

	foreach ( $strings as $key => $value ) {
		// Inverse quotes to normal.
		$value = str_replace( $single_quote_temp_reg, '\'', $value );
		$value = str_replace( $double_quote_temp_reg, '"', $value );

		$strings[ $key ] = $value;
	}
	return $strings;
} // end get_strings_from_files

$set_strings_to_translate = function ( $args = array(), $assoc_args = array() ) { // phpcs:ignore
	$start = microtime( true );
	$files = get_files_from_dir( get_template_directory() );
	foreach ( apply_filters( 'eternia_plugins_to_string_translation', array() ) as $plugin ) {
		$files = array_merge( $files, get_files_from_dir( WP_PLUGIN_DIR . '/' . $plugin ) );
	}
	$strings = get_strings_from_files( $files );
	update_option( 'eternia_strings_to_translate', $strings, false );

	$execution_time = microtime( true ) - $start;
	\WP_CLI::success( 'Loop ' . count( $files ) . ' files and added, ' . count( $strings ) . ' strings to translations. Execution time: ' . $execution_time );
};

/**
	* This command loops current theme and plugins that are set in 'eternia_plugins_to_string_translation' filter (array),
	* finds polylang translations and add them to options.
	* In theme we can get strings from that option and set string to be translated.
	*
	* Call `wp eternia set strings to translate`.
	*
	* We can use that wp-cli command on deploy action so this command run every time we deploy something.
	*/
if ( defined( 'WP_CLI' ) && WP_CLI ) {
	\WP_CLI::add_command( 'eternia set strings to translate', $set_strings_to_translate );
}
