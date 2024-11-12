/**
 * Declares lightbox JS bundle to the window object.
 *
 * This is done so our blocks and other components
 * can call lightbox without having to import it, reducing
 * the bundle size and optimizing performance.
 *
 * You can use lightbox like this:
 * const { lightbox } = window.lightbox;
 */
import { fetchMediaForLightbox, initLightbox, coreImagesEnableLightbox } from "./modules/lightbox";

export function globallyInitLightbox() {
  Object.assign(window.eternia, { lightbox: {
    fetchMediaForLightbox,
    coreImagesEnableLightbox,
    initLightbox
  } });
  return window.eternia.lightbox;
}
globallyInitLightbox();