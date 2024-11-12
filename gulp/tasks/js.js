// Hide deprecation warnings
process.env.NODE_PENDING_DEPRECATION = 0;

// Dependencies
const {
  src
} = require('gulp');
const config = require('../config');
const vuePlugin = require("esbuild-plugin-vue3");
const esbuild = require('esbuild');
const gutil = require('gutil');
require('dotenv').config();

async function generateJs(args) {
  const {done, sourcePath, destination} = args;

  const result = await esbuild.build({
      entryPoints: sourcePath,
      bundle: true,
      minify: true,
      target: 'es2018',
      sourcemap: process?.env?.NODE_ENV !== 'production',
      jsxImportSource: 'vue/dist/vue.esm-bundler.js',
      jsxFactory: 'h',
      outdir: destination,
      plugins: [vuePlugin()],
      alias: {
        vue: "vue/dist/vue.esm-bundler.js"
      },
  }).catch(e=>e);

  gutil.log(result);

  done();
}

// Task: for building general js scripts
function js(done) {
  const args = {
    done,
    sourcePath: config.js.src,
    destination: config.js.dest
  }
  return generateJs(args);
}

// Task: for building block js scripts
function jsBlocks(done) {
  const args = {
    done,
    sourcePath: config.blocksJs.src,
    destination: config.blocksJs.dest
  }
  return generateJs(args);
}

exports.js = js;
exports.jsBlocks = jsBlocks;
