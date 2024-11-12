import { isNil } from "lodash-es";

/**
 * Creates a lightbox skeleton object under the body element.
 * This is utilised to create a lightbox that is not dependent on the DOM structure of the page.
 *
 * Utilises the Swiper on the page to control the active image, which is retrieved by its
 * ID from the WordPress media library through REST api.
 *
 * Lightbox shows the image, arrows to control the swiper, image caption rendered, and a close button.
 */
export function initLightbox() {
  const lightbox:HTMLDialogElement|null = document.querySelector('#lightbox') || null;
  const closeButton:HTMLButtonElement|null = document.querySelector('.lightbox__close') || null;

  closeButton?.addEventListener('click', () => {
    closeLightbox(lightbox);
  });

  if(lightbox){
    lightbox?.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        closeLightbox(lightbox);
      }
      trapFocus(e, lightbox);
    });
  }
}

/**
 * Traps focus within the lightbox
 */
function trapFocus(event: KeyboardEvent, lightbox: HTMLDialogElement) {
  const focusableElements = Array.from(lightbox.querySelectorAll<HTMLInputElement>(
    'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])',
  ));
  const firstElement = focusableElements[0];
  const lastElement = focusableElements[focusableElements.length - 1];

  if (event.key === 'Tab') {
    if (event.shiftKey) {
      // If shift key pressed for shift + tab combination
      if (document.activeElement === firstElement) {
        event.preventDefault();
        lastElement.focus(); // Set focus on the last element
      }
    } else {
      // If tab key is pressed
      if (document.activeElement === lastElement) {
        event.preventDefault();
        firstElement.focus(); // Set focus on the first element
      }
    }
  }
}

/**
 * Closes the lightbox
 */
function closeLightbox(lightbox) {
  lightbox.setAttribute('data-swiper-active', 'false');
  lightbox.classList.add('lightbox--closing');
  lightbox.classList.remove('lightbox--open');
  document.body.style.overflow = 'auto';

  // Add class lightbox-closed to the lightbox after 1s
  setTimeout(() => {
    lightbox.setAttribute('aria-hidden', 'true');
    lightbox.classList.add('lightbox--closed');
    lightbox.classList.remove('lightbox--closing');

    lightbox.removeAttribute('data-initial-focus');
  }, 250);
}

/**
 * Fetches media based on ID,
 * and updates the lightbox.
 *
 * @return { void }
 */
export function fetchMediaForLightbox(args:{
  mediaId:number, 
  swiperId?:number, 
  lightbox:HTMLDialogElement
}) {
  const { mediaId, swiperId, lightbox } = args;

  // Fetch the media object from WordPress REST API
  fetch(`${window?.eternia?.properties?.rest_url}wp/v2/media/${mediaId}/`)
    .then((response) => response.json())
    .then((data) => {
      updateLightbox({ data, swiperId, lightbox });
    })
    .catch((error) => console.error('Error:', error));
}

/**
 * Updates the lightbox fields with the media.
 *
 * @param {Object} data - Media object from WordPress REST API
 * @return {void}
 */
function updateLightbox(args:{
  data:{
    media_details: {
      sizes: {
        full: {
          source_url: string
        }
      }
    },
    caption:{
      rendered: string
    },
    source_url:string,
    alt_text:string,
  }, 
  swiperId?:number, 
  lightbox:HTMLDialogElement
}) {
  const { data, swiperId, lightbox } = args;

  const imageWrapper = lightbox.querySelector('.lightbox__image');
  const description = lightbox.querySelector('.lightbox__excerpt');
  const closeBtn:HTMLButtonElement|null = lightbox.querySelector('.lightbox__close') || null;
  // Get the full size image source; if not available, use the original source.
  const imgSrc = data.media_details
    && data.media_details.sizes
    && data.media_details.sizes.full
    ? data.media_details.sizes.full.source_url
    : data.source_url;

  // Update the image
  if(imageWrapper) {
    imageWrapper.innerHTML = `<img src="${imgSrc}" alt="${data.alt_text}" />`;
  }

  // Update the description
  if(description && data?.caption?.rendered) {
    description.innerHTML = data?.caption?.rendered;
  }

  // Show the lightbox
  lightbox.setAttribute('aria-hidden', 'false');
  lightbox.classList.remove('lightbox--closing');
  lightbox.classList.remove('lightbox--closed');
  lightbox.classList.add('lightbox--open');

  if (swiperId) {
    setSwiperToLightbox(swiperId, lightbox);
  }

  if (!lightbox.hasAttribute('data-initial-focus') && closeBtn) {
    closeBtn.focus();
    lightbox.setAttribute('data-initial-focus', 'true');
  }
}

/**
 * Sets the navigation for current swiper block.
 *
 * @param {integer} swiperId - The ID for current swiper element.
 * @param {Element} lightbox - The lightbox element.
 */
function setSwiperToLightbox(swiperId: number, lightbox: HTMLDialogElement) {
  // Set the swiper active
  lightbox?.setAttribute('data-swiper-active', 'true');

  // Set swiper left and right navigation
  const leftNav:HTMLButtonElement = lightbox?.querySelector('.swiper-button--prev') || document.createElement('button');
  const rightNav:HTMLButtonElement = lightbox?.querySelector('.swiper-button--next') || document.createElement('button');
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  const { swiper } = document.querySelector<HTMLDivElement>(`#${swiperId}`) as any;

  leftNav.addEventListener('click', () => {
    swiper?.slidePrev();
    leftNav?.focus();
  });

  rightNav.addEventListener('click', () => {
    swiper?.slideNext();
    rightNav?.focus();
  });

  lightbox.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') {
      swiper?.slidePrev();
      leftNav?.focus();
    }
    if (e.key === 'ArrowRight') {
      swiper?.slideNext();
      rightNav?.focus();
    }
  });
}

/**
 * Adds our custom lightbox to core images, if there are any.
 */
export function coreImagesEnableLightbox() {
  const lightbox:HTMLDialogElement = document.querySelector('#lightbox') || document.createElement('dialog');
  const coreFigures:HTMLDivElement[] = Array.from(document.querySelectorAll('.wp-block-image'));
  const coreImgs:HTMLImageElement[] = Array.from(document.querySelectorAll('img[class*="wp-image"]'));

  if (coreFigures.length === 0 || coreImgs.length === 0) return;

  // Remove all traces of the default WordPress lightbox from figure elements
  if (coreFigures.length > 0) {
    coreFigures.forEach((image) => {
      if ('wpContext' in image.dataset) {
        image.removeAttribute('data-wp-context');
      }

      if ('wpInteractive' in image.dataset) {
        image.removeAttribute('data-wp-interactive');
      }

      if (image.classList.contains('wp-lightbox-container')) {
        image.classList.remove('wp-lightbox-container');
      }

      const wpDefaultLightboxTrigger = image.querySelector(
        'button.lightbox-trigger',
      );
      if (wpDefaultLightboxTrigger) {
        wpDefaultLightboxTrigger.remove();
      }
    });
  }

  // Add our custom lightbox to core images whether they are wrapped in a figure or not
  if (coreImgs.length > 0) {
    function imageClickHandler(img:HTMLImageElement) {
      // Img element below has class wp-image-<id>
      const imageClasses = img.classList;
      let mediaId:string|null = null;

      // Find the one that matches the pattern
      imageClasses.forEach((className) => {
        if (className.match(/wp-image-\d+/)) {
          mediaId = className.split('-')[2];
        }
      });

      if (!mediaId) return;

      fetchMediaForLightbox({ mediaId, lightbox });
    }

    coreImgs.forEach((image) => {
      // Check for a link wrapping the image
      const isLink = !isNil(image.closest('.wp-block-image > a'));
      const imageLink = image.closest('figure');
      // If a link is found, clone the image and replace the link with a new picture element
      if (!isLink && imageLink) {
        // Set up the picture element and cloned image with click listener
        const pic = document.createElement('picture');
        image.addEventListener('click', () => {
          imageClickHandler(image);
        });
        pic.appendChild(image);
        // Replace the link with the picture element so it stays in place
        imageLink.replaceWith(pic);
      } else {
        // If no link, just add the click listener to the image
        image.addEventListener('click', () => {
          imageClickHandler(image);
        });
      }
    });
  }
}
