import { build } from './gulp/tasks/build.js';
import { clean } from './gulp/tasks/clean.js';
import { dev } from './gulp/tasks/dev.js';
import { devstyles } from './gulp/tasks/devstyles.js';
import { fonts } from './gulp/tasks/fonts.js';
import { images } from './gulp/tasks/images.js';
import { js } from './gulp/tasks/js.js';
import { phpcs } from './gulp/tasks/phpcs.js';
import { prodstyles } from './gulp/tasks/prodstyles.js';
import { watch } from './gulp/tasks/watch.js';

export {
  build, clean, dev, devstyles, fonts, images, js,
  phpcs, prodstyles, watch,
};
