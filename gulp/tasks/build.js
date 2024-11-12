// Dependencies
const { series } = require("gulp");

// Tasks
const clean = require("./clean.js").clean;
const js = require("./js.js").js;
const jsBlocks = require("./js.js").jsBlocks;
const devstyles = require("./devstyles.js").devstyles;
const devBlockStyles = require("./devstyles.js").devBlockStyles;
const prodstyles = require("./prodstyles.js").prodstyles;
const prodBlockStyles = require("./prodstyles.js").prodBlockStyles;
const images = require("./images.js").images;
const favicons = require("./images.js").favicons;
const blockPreviews = require("./images.js").blockPreviews;
const fonts = require("./fonts.js").fonts;
require('dotenv').config();

exports.build = series(
  clean,
  js,
  jsBlocks,
  process?.env?.NODE_ENV == 'production' ? prodstyles : devstyles,
  process?.env?.NODE_ENV == 'production' ? prodBlockStyles : devBlockStyles,
  images,
  favicons,
  blockPreviews,
  fonts
);
