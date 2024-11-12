// Dependencies
const { dest, src } = require("gulp");
const config = require("../config.js");
const fs = require("fs");

// Task
async function fonts() {
  if (!fs.existsSync(config.fonts.srcFolder)) {
    fs.mkdirSync(config.fonts.srcFolder);
  }
  return src(config.fonts.src, { encoding: false }).pipe(dest(config.fonts.dest));
}

exports.fonts = fonts;
