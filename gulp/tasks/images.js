// Dependencies
const { dest, src } = require("gulp");
let /** @type {import("gulp-imagemin")} */ imagemin;
const config = require("../config.js");

// Task
async function images(files) {
  imagemin = (await import("gulp-imagemin")).default;
  return src(config.images.src, { encoding: false })
    .pipe(imagemin())
    .pipe(dest(config.images.dest));
}

// Favicon related other files
function favicons(files) {
  return src(config.favicons.src, { encoding: false }).pipe(dest(config.favicons.dest));
}

// Block library images
async function blockPreviews(files) {
  svgo = (await import("gulp-imagemin")).svgo;

  return src(config.blockPreviews.src, { encoding: false })
    .pipe(imagemin(
      [
        svgo({
          plugins: [
            { removeViewBox: false }
          ],
        }),
      ],
    ))
    .pipe(dest(config.blockPreviews.dest));
}

exports.images = images;
exports.favicons = favicons;
exports.blockPreviews = blockPreviews;
