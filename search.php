<?php
/**
 * The template for displaying search results pages
 *
 * @package eternia
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 */

namespace Eternia;

get_header();

$get_query_parameter = get_search_query();

// Translations.
$string_title = translate__( 'Hakutulokset', 'Hakulomake', 'eternia' );
?>

<div class="main-grid">

	<div class="search__header">

		<h1 class="search__title">
			<?php echo esc_html( $string_title ); ?>
		</h1>

		<div class="search__form-wrapper">
			<?php
			$form_args = array(
				'form_id' => null,
			);
			get_search_form( $form_args );
			?>
		</div>

		<?php
		$meta_args = array(
			'get_query_parameter' => $get_query_parameter,
		);
		get_template_part( 'template-parts/search/result', 'meta', $meta_args );
		?>

	</div>

	<?php if ( ! empty( $get_query_parameter ) && have_posts() ) : ?>

		<div class="search__results">
			<?php
			while ( have_posts() ) :
				the_post();
				?>

				<?php
					$result_args = array(
						'result_id'            => get_the_ID(),
						'result_extra_classes' => '',
					);
					get_template_part( 'template-parts/search/result', 'item', $result_args );
					?>

			<?php endwhile; ?>
		</div>

		<?php if ( $wp_query->max_num_pages > 1 ) : ?>
			<div class="search__pagination">
				<?php get_template_part( 'template-parts/pagination' ); ?>
			</div>
		<?php endif; ?>

	<?php endif; ?>

<?php
get_footer();
