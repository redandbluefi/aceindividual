# Template tags folder instructions

## inline svg

  Example use case:
  echo inline_svg( 'my-icon.svg', array('wrapper' => 'i', 'class' => 'my-element__icon'), true );
  echo inline_svg( 'site-logo.svg', array('class' => 'site-branding__logo', 'itemprop' => 'logo'), true );

  - wrapper: HTML element to wrap the svg in (default: div).
  - class: Class attribute for the wrapper element.
  - itemprop: Itemprop attribute for the wrapper element.