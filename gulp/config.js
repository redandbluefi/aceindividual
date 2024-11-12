// Set theme dir
const themeDir = './';
require('dotenv').config();
const proxyUrl = process?.env?.proxyUrl || "http://eternia.local/";

module.exports = {
  cssnano: {
    preset: [
      "cssnano-preset-advanced",
      {
        discardComments: {
          removeAll: true,
        },
        reduceIdents: {
          gridTemplate: false,
        },
      },
    ],
  },
  size: {
    gzip: true,
    uncompressed: true,
    pretty: true,
    showFiles: true,
    showTotal: false,
  },
  rename: {
    min: {
      suffix: ".min",
    },
  },
  browsersync: {
    // Important! If src is wrong, styles will not inject to the browser
    src: [
      themeDir + "**/.php",
      themeDir + "build/css/**/*",
      themeDir + "build/js/dev/**/*",
    ],
    opts: {
      logLevel: "debug",
      injectChanges: true,
      proxy: proxyUrl,
      browser: "Google Chrome",
      open: true,
      notify: true,
      // @TODO: need to figure out how to handle ssl-certs in this setup with Local, below code that applies to Dude-stack
      //
      // Generate with: mkdir -p /var/www/certs && cd /var/www/certs && mkcert localhost 192.168.x.xxx ::1
      /*
      https: {
        key: "/var/www/certs/localhost-key.pem",
        cert: "/var/www/certs/localhost.pem",
      },
      */
    },
  },
  styles: {
    src: themeDir + "app/sass/*.scss",
    development: themeDir + "build/css/",
    production: themeDir + "build/css/",
    acfBlocks: {
      src: themeDir + "acf-blocks/**/*.scss",
      path: themeDir + "build/css/blocks-acf/"
    },
    watch: {
      development: themeDir + "app/sass/**/*.scss",
      production: themeDir + "build/css/*.css",
    },
    stylelint: {
      src: themeDir + "app/sass/**/*.scss",
      opts: {
        fix: false,
        reporters: [
          {
            formatter: "string",
            console: true,
            failAfterError: false,
            debug: false,
          },
        ],
      },
    },
    opts: {
      development: {
        verbose: true,
        bundleExec: false,
        outputStyle: "expanded",
        debugInfo: true,
        errLogToConsole: true,
        includePaths: [themeDir + "node_modules/"],
        quietDeps: true,
      },
      production: {
        verbose: false,
        bundleExec: false,
        outputStyle: "compressed",
        debugInfo: false,
        errLogToConsole: false,
        includePaths: [themeDir + "node_modules/"],
        quietDeps: true,
      },
    },
  },
  js: {
    src: [themeDir + "app/js/*.tsx", themeDir + "app/js/*.ts", themeDir + "app/js/*.js"],
    watch: [themeDir + "app/js/**/*", themeDir + "src/**/*"],
    watch: themeDir + "app/js/**/*",
    dest: themeDir + "build/js/",
  },
  blocksJs: {
    src: [themeDir + "acf-blocks/**/*.js"],
    watch: themeDir + "acf-blocks/**/*.js",
    dest: themeDir + "build/js/blocks-acf/",
  },
  php: {
    watch: [
      themeDir + "*.php",
      themeDir + "inc/**/*.php",
      themeDir + "template-parts/**/*.php",
    ],
  },
  phpcs: {
    src: [
      themeDir + "**/*.php",
      "!" + themeDir + "node_modules/**/*",
      "!" + themeDir + "vendor/**/*",
    ],
    opts: {
      bin: themeDir + "vendor/bin/phpcs",
      standard: themeDir + "phpcs.xml",
      warningSeverity: 0,
    },
  },
  images: {
    src: themeDir + "app/img/**/*.{png,jpg,jpeg,gif,svg}",
    dest: themeDir + "build/img/",
    watch: themeDir + "app/img/**/*",
  },
  blockPreviews: {
    src: themeDir + "acf-blocks/**/*.png",
    dest: themeDir + "build/img/block-preview",
    watch: themeDir + "acf-blocks/**/*.png",
  },
  favicons: {
    src: themeDir + "app/img/favicon/*.{ico,xml,webmanifest}",
    dest: themeDir + "build/img/favicon",
    watch: themeDir + "app/img/favicon/*",
  },
  fonts: {
    srcFolder: themeDir + "app/fonts/",
    src: themeDir + "app/fonts/**/*.{ttf,woff,woff2,eot,svg}",
    dest: themeDir + "build/fonts/",
    watch: themeDir + "app/fonts/**/*",
  },
};
