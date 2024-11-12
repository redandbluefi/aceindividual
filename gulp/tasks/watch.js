// Dependencies
const {
  watch,
  series
} = require('gulp');
const bs = require('browser-sync').create();
const config = require('../config.js');
const {
  handleError
} = require('../helpers/handle-errors.js');

const devBlockStyles = require("./devstyles.js").devBlockStyles;
const jsBlocks = require("./js.js").jsBlocks;
const blockPreviews = require("./images.js").blockPreviews;

// Watch task
function watchFiles(done) {
  // Init BrowserSync
  bs.init(config.browsersync.src, config.browsersync.opts);

  // Console info
  function consoleInfo(path) {
    console.log(
      `\x1b[37m[\x1b[35mfileinfo\x1b[37m] \x1b[37mFile \x1b[34m${path} \x1b[37mwas changed.\x1b[0m`
    );
  }

  // Styles in development environment
  const watchedDevStyles = watch(
    [config.styles.watch.development, '!' + config.styles.acfBlocks.src],
    series("devstyles")
  ).on("error", handleError());
  watchedDevStyles.on("change", function (path) {
    consoleInfo(path);
  });

  // Block styles in development environment
  const watchedDevBlockStyles = watch(
    config.styles.acfBlocks.src,
    series(devBlockStyles)
  ).on("error", handleError());
  watchedDevBlockStyles.on("change", function (path) {
    consoleInfo(path);
  });

  // JavaScript
  const watchJavascript = watch(['!' + config.blocksJs.src].concat(config.js.watch), series("js"));
  watchJavascript.on("change", function (path) {
    consoleInfo(path);
  });

  // Block JavaScript
  const watchJavascriptBlocks = watch(config.blocksJs.src, series(jsBlocks));
  watchJavascriptBlocks.on("change", function (path) {
    consoleInfo(path);
  });

  // PHP
  /*
  const php = watch(config.php.watch, series("phpcs"), bs.reload);
  php.on("change", function (path) {
    consoleInfo(path);
  });
  */

  // Images
  watch(config.images.watch, series("images"));

  // Block previews
  watch(config.blockPreviews.watch, series(blockPreviews));

  // Fonts
  watch(config.fonts.watch, series("fonts"));

  // Lint styles
  // watch(config.styles.watch.development, series("lintstyles"));

  // Finish task
  done();
};

exports.watch = watchFiles;
