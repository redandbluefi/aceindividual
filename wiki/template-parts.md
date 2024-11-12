# Template parts folder instructions

## Favicons

  1) generate favicons e.g. with: https://realfavicongenerator.net/
  2) add favicon files to /app/img/favicon
  3) adjust markup / remove unnecessary lines below

## Breadcrumbs

  --> Breadcrumb class is defined in inc/includes/breadcrumbs.php
  OBS. breadcrumb and divider styles are defined in _breadcrumbs.scss

  $defaults can be overriden by passing args to get_template_part call,
  e.g. get_template_part( 'template-parts/breadcrumbs-markup', '', array('home_text' => 'Something else') )