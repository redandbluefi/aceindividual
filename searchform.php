<?php
/**
 * Search form markup
 *
 * @package eternia
 */

namespace Eternia;

$form_id = $args['form_id'] ?? '';
?>

<form role="search" method="get" class="search__form"<?php echo $form_id ? 'id="' . esc_attr( $form_id ) . '"' : ''; ?> action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="search__label">
		<span class="screen-reader-text"><?php echo esc_html( translate__( 'Haku:', 'Hakulomake', 'eternia' ) ); ?></span>
		<input type="search" class="search__input" placeholder="<?php echo esc_html( translate__( 'Haku', 'Hakulomake', 'eternia' ) ); ?>" value="<?php get_search_query(); ?>" name="s" />
	</label>
	<input type="submit" class="search__button button-primary" value="<?php echo esc_html( translate__( 'Hae', 'Hakulomake', 'eternia' ) ); ?>" />
</form>
