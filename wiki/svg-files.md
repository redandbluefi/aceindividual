# Proper use of SVG files

SVG files are mainly used for illustrations and icons within the site.

## Inline SVG

The helper function `inline_svg` is used to ensure we use the built and compressed version of the file. This is preferred over directly injecting the SVG code into the template. The `inline_svg` helper function contains a boolean echo parameter, and the `ALLOW_ONLY_SVG` KSES filter is used within the function if echo is true. More about the SVG KSES filters below.

## KSES

WordPress doesn't support SVG off the bat, but we have added our own KSES filter to allow SVG files within the theme. For only a SVG, use `ALLOW_ONLY_SVG`. If you wish to allow wp default post markup with svg, use `ALLOW_POST_WITH_SVG`.

## Cleaning up SVG markup

Within the `app/img` folder, there are sub folders the SVG files should be contained within.

`icons` folder includes SVG files, which may include some whitespace around the image, to ensure proper relative sizing when placed alongside each other. Do not include the height and width attribute, as those are set by the container. If the SVG is single color, ensure that paths within the file do not have a fill attribute, as they should use the SVG files fill attribute. The SVG file fill attribute should be `currentColor` by default, to match whatever color is set in the context it is used at.

`logos` and `illustrations` are by default cut to the edge of the graph, with no whitespace, to ensure more control over the spacing within the css code. Default size may be set, and paths may contain set colors. If not, the fill attribute should be set to currentColor, so we wouldn't have a temptation to load multiple versions of the same SVG file in different colors.
