<?php
/**
 * The template for displaying default page.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @package eternia
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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

