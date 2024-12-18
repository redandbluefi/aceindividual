<?php
/**
 * The template for displaying the header
 *
 * <head> section and everything up until <div id="content">
 *
 * @package eternia
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

namespace Eternia;

?>

<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <?php get_template_part( 'template-parts/tag-manager/tm-head' ); ?>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <?php
  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo get_template_part( 'template-parts/favicons' );
	?>
  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-WPVBPDCJ');</script>
  <!-- End Google Tag Manager -->
  <?php wp_head(); ?>
</head>

<body <?php body_class( 'no-js' ); ?>>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WPVBPDCJ"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  <?php get_template_part( 'template-parts/tag-manager/tm-body' ); ?>

  <a class="skip-link screen-reader-text" href="#content">
	<span id="text"><?php echo esc_html( get_default_localization( 'Skip to content' ) ); ?></span>
	<span aria-hidden="true">&darr;</span>
  </a>

  <?php wp_body_open(); ?>

  <div id="page" class="site">

	<header class="site-header sticky-header layout-grid" id="site-header">

	  <?php echo do_blocks( '<!-- wp:eternia/legacy-header /-->' ); ?>

	</header>

	<?php get_template_part( 'template-parts/header/mobile-menu' ); ?>

	<div class="site-content" aria-hidden="false">

	  <main id="content" class="site-main">
