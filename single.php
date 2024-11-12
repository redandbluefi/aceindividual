<?php
/**
 * The template for displaying all single posts
 *
 * @package eternia
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 */

namespace Eternia;

the_post();
get_header();

?>
<div class="layout-grid content">
	<?php the_content(); ?>
</div>
<?php

get_footer();
