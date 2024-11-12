<?php
/**
 * Template part for displaying search result meta
 *
 * @package eternia
 */

namespace Eternia;

$search_term = $args['get_query_parameter'] ?? get_search_query();
$total_posts = $wp_query->found_posts;

// Search meta.
$found_posts       = (int) $wp_query->found_posts;
$posts_per_page    = (int) $wp_query->query_vars['posts_per_page'];
$current_page      = (int) $wp_query->query_vars['paged'];
$pages_total       = (int) ceil( $found_posts / $posts_per_page );
$showing_from      = (int) $found_posts < $posts_per_page || 0 === $current_page ? 1 : $posts_per_page * $current_page - $posts_per_page + 1;
$showing_to        = (int) 0 === $current_page ? $current_page + 1 * $posts_per_page : $current_page * $posts_per_page;
$currently_showing = (int) $found_posts < $posts_per_page ? $found_posts : $posts_per_page;

// Search meta strings.
$string_results_prefix = translate__( 'hakusanalle', 'Hakutulokset', 'eternia' );
$string_result_from_to = translate__( 'Näytetään tulokset', 'Hakutulokset', 'eternia' );
$string_page           = translate__( 'Sivu', 'Hakutulosten sivun teksti', 'eternia' );
$string_no_results     = translate__( 'Haku ei löytänyt tuloksia.', 'Hakulomake', 'eternia' );
if ( $found_posts < $posts_per_page ) {
	$string_result_from_to = translate__( 'Näytetään kaikki tulokset', 'Hakutulokset', 'eternia' );
}
?>

<?php if ( ! empty( $search_term ) && have_posts() ) : ?>

	<div id="search-meta" class="search__meta" tabindex="-1" aria-live="polite">
		<p class="search__meta-resultcount">
			<?php
			if ( $found_posts < $posts_per_page ) {
				echo esc_html( $string_result_from_to ) . ' ' . esc_html( $string_results_prefix ) . ' "' . esc_html( $search_term ) . '".';
			} else {
				echo esc_html( $string_result_from_to ) . ' ' . esc_html( $showing_from ) . '&ndash;' . ( $showing_to > $found_posts ? esc_html( $found_posts ) : esc_html( $showing_to ) ) . ' / ' . esc_html( $found_posts );
			}
			?>
		</p>
		<?php if ( $pages_total > 1 ) : ?>
		<p class="search__meta-pagecount">
			<?php echo esc_html( $string_page ) . ' ' . ( 0 === $current_page ? 1 : esc_html( $current_page ) ) . ' / ' . esc_html( $pages_total ); ?>
		</p>
		<?php endif; ?>
	</div>

<?php else : ?>
	<p><?php echo esc_html( $string_no_results ); ?></p>
<?php endif; ?>
