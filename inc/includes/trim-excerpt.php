<?php
/**
 * Trims an excerpt / portion of text to the last full stop, question mark, or exclamation mark.
 *
 * Example use case:
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Trim an excerpt / portion of text to the last full stop, question mark, or exclamation mark.
 *
 * @param string $post_excerpt The excerpt to be trimmed.
 * @param int    $length The desired length of the excerpt in characters.
 */
function trim_excerpt( $post_excerpt, $length = 250 ) {
	// Some excerpts have html tags, strip them.
	$post_excerpt_stripped = wp_strip_all_tags( $post_excerpt );

	// Truncate excerpt to specified length.
	$post_excerpt_truncated = substr( $post_excerpt_stripped, 0, $length );

	// Check the position of truncated excerpt's last exclamation mark, question mark, and full stop, if any.
	$last_exclamation_mark_position = strrpos( $post_excerpt_truncated, '!' ) ?? 0;
	$last_question_mark_position    = strrpos( $post_excerpt_truncated, '?' ) ?? 0;
	$last_full_stop_position        = strrpos( $post_excerpt_truncated, '.' ) ?? 0;

	// Set the point where the excerpt should end as either the last exclamation mark, question mark, or full stop,
	// whichever comes latest in the truncated excerpt. If all are 0 (i.e. none found), there is no max returned.
	$end_point = max(
		$last_exclamation_mark_position,
		$last_question_mark_position,
		$last_full_stop_position
	);

	// If end point is not set because there are no exclamation marks, question marks, or full stops in the truncated excerpt...
	if ( ! $end_point ) {
		// Set the end point at the last space instead, to avoid cutting the ends of words off.
		$end_point = strrpos( $post_excerpt_truncated, ' ' );
		// Then define an ellipsis to end the excerpt to indicate it is in the middle of a sentence.
		$final_punctuation = '...';
	}

	// Cut the excerpt short at the defined point (+1 to include the final punctuation mark, whatever it was).
	// If somehow by this point the end point is still undefined, then it just goes to the end of the truncated portion.
	$post_excerpt_truncated_neatly = $end_point ? substr( $post_excerpt_truncated, 0, $end_point + 1 ) : substr( $post_excerpt_truncated, 0 );
	// Prepare the final excerpt - add the final punctuation, if any.
	$post_excerpt_final = isset( $final_punctuation ) ? $post_excerpt_truncated_neatly . $final_punctuation : $post_excerpt_truncated_neatly;

	return $post_excerpt_final;
}
