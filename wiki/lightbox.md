Here’s a README for using the lightbox functionality based on your provided code:

---

# Lightbox Integration Guide

This lightbox component is designed to work seamlessly with WordPress and the Swiper library. It dynamically displays media content from the WordPress REST API and provides navigation features using Swiper. This guide will explain how to use the lightbox in your project.

## 1. Initialization

To use the lightbox, ensure the following script is included and the lightbox template is added to the footer of your theme:

- The lightbox JavaScript is registered globally via the `window.eternia.lightbox` object.
- The lightbox can be triggered dynamically, allowing media content to be fetched via the WordPress REST API.

### Key Functions:

- **`window.eternia.lightbox.fetchMediaForLightbox`**: Fetches and loads media content dynamically into the lightbox.
- **`window.eternia.lightbox.initLightbox`**: Initializes the lightbox by attaching event listeners and setting up focus trapping for accessibility.

## 2. Usage in a Swiper Carousel

In your Swiper carousel setup, you can integrate the lightbox as follows:

1. **Initialize the Lightbox**: Call `initLightbox()` to set up the lightbox event listeners. This should be done after the DOM is fully loaded.

2. **Trigger Lightbox via Swiper Click Event**: In the Swiper configuration, bind the `click` event to trigger the lightbox and fetch the relevant media from the REST API.

### Example Code:

```javascript
import Swiper from 'swiper/bundle';
import getCssVariableValue from '../../app/js/helpers/get-css-variable-value';

function initBlockCarousel() {
  const buildSwiper = (swiperContainer) => {
    const lightbox = document.getElementById('lightbox');

    const swiper = new Swiper(`#${swiperContainer.id}`, {
      slidesPerView: 'auto',
      direction: 'horizontal',
      loop: true,
      speed:
        getCssVariableValue({ name: '--transition-duration', unit: 'ms' }) ??
        170,
      watchSlidesProgress: true,
      slideToClickedSlide: true,
      navigation: {
        nextEl: `#${swiperContainer.id}-next`,
        prevEl: `#${swiperContainer.id}-prev`,
      },
      spaceBetween: 16,
      on: {
        click(swiper, event) {
          const { clickedSlide } = swiper;
          const { mediaId } = clickedSlide.dataset;
          const swiperId = swiperContainer.id;

          // Fetch and display media in the lightbox
          window.eternia.lightbox.fetchMediaForLightbox({
            mediaId,
            swiperId,
            lightbox,
          });
        },
        activeIndexChange(swiper) {
          const isLightboxActive = lightbox.getAttribute('data-swiper-active');
          if (isLightboxActive !== 'true') return;

          setTimeout(() => {
            const activeSlide = swiper.slides[swiper.activeIndex];
            const { mediaId } = activeSlide.dataset;
            const swiperId = swiperContainer.id;

            // Update the lightbox with the new active slide media
            window.eternia.lightbox.fetchMediaForLightbox({
              mediaId,
              swiperId,
              lightbox,
            });
          }, 50);
        },
      },
    });

    swiper.slides.forEach((slide) => {
      slide.addEventListener('keypress', (event) => {
        if (event.key === 'Enter') {
          const { mediaId } = slide.dataset;
          const swiperId = swiperContainer.id;

          // Trigger lightbox via keyboard navigation
          window.eternia.lightbox.fetchMediaForLightbox({
            mediaId,
            swiperId,
            lightbox,
          });
        }
      });
    });

    return swiper;
  };

  const articleSwipers = document.querySelectorAll('.block-carousel__swiper');

  if (articleSwipers.length > 0) {
    articleSwipers.forEach((swiper) => buildSwiper(swiper));
  }

  // Initialize the lightbox
  if (typeof window.eternia.lightbox.initLightbox === 'function') {
    window.eternia.lightbox.initLightbox();
  }
}

// Initialize conditionally after the DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  const accordions = document.querySelectorAll('.block-carousel__swiper');
  if (accordions.length > 0) {
    initBlockCarousel(accordions);
  }
});
```

## 3. Key Concepts

- **Swiper Integration**: The lightbox integrates with Swiper's `click` event, enabling users to click on a slide and open the corresponding media in the lightbox.
- **Dynamic Media Fetching**: Media is dynamically fetched from the WordPress REST API using the `fetchMediaForLightbox` function. The `mediaId` from the Swiper slide is used to retrieve and display the correct content.
- **Keyboard Accessibility**: Focus trapping and keyboard navigation are handled to ensure accessibility within the lightbox. Users can navigate between images using the arrow keys or close the lightbox with the "Escape" key.

## 4. Customization

The lightbox can be customized to fit your project needs. Key areas of customization include:

- **Lightbox Styling**: Update the styles for `.lightbox`, `.lightbox__image`, `.lightbox__close`, and other related elements.
- **Swiper Settings**: Adjust Swiper configurations (e.g., `slidesPerView`, `spaceBetween`) to match the design and functionality requirements.

## 5. Conclusion

This lightbox setup offers a flexible and dynamic way to display media content in a WordPress project. With Swiper integration and accessibility features, it provides a robust solution for handling images in a carousel format.
