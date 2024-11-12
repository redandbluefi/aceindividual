/**
 * Declares Swiper JS bundle to the window object.
 *
 * This is done so our blocks and other components
 * can call Swiper without having to import it, reducing
 * the bundle size and optimizing performance.
 *
 * You can use Swiper like this:
 * const { Swiper } = window.swiper;
 *
 * To limit package size, we've opted to load modules
 * on demand. You can access them like this:
 * const { Navigation } = window.swiper.modules;
 */

import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';

if (window?.eternia) {
  window.eternia.swiper = {};
} else {
  window.eternia = { swiper: {} };
}

if (!window.eternia.swiper) {
  window.eternia.swiper = {};
}

window.eternia.swiper.Swiper = Swiper;
window.eternia.swiper.modules = {
  Navigation,
};
