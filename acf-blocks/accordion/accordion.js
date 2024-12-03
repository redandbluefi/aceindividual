// Toggles the aria-expanded attribute for a button
function ariaExpanded(button) {
  const xAria =
    button.getAttribute("aria-expanded") === "true" ? "false" : "true";

  button.setAttribute("aria-expanded", xAria);
}

function checkAccordionItems(accordions) {
  accordions.forEach(async (accordion) => {
    const button = accordion.querySelector(".accordion-item__header");

    button.addEventListener("click", () => {
      // Toggle aria-expanded attribute
      ariaExpanded(button);

      const panel = accordion.querySelector(".accordion-item__panel");

      const ariaExpandedAttribute = button.getAttribute("aria-expanded");

      if (ariaExpandedAttribute === "true") {
        // If expanded, set max height to allow the content to show
        panel.style.display = "block";
        panel.classList.add("max-height");
        panel.style.maxHeight = `${panel.scrollHeight}px`;
      } else {
        // If collapsed, reset max height to hide the content
        panel.style.maxHeight = null;
        panel.style.display = "none";
      }
    });
  });
}

// Resizes the overlay and image dynamically based on the section width
function resizeOverlayAndImage() {
  const section = document.querySelector(".accordion");
  const overlay = document.querySelector(".block-accordion__bg-image-overlay");
  const image = document.querySelector(".block-accordion__bg-image");

  if (!section || !overlay || !image) return;

  const MAX_IMAGE_SIZE = 628; // Maximum size for the image
  const MIN_IMAGE_SIZE = 244; // Minimum size for the image

  const MAX_OVERLAY_SIZE = 428; // Maximum size for the overlay
  const MIN_OVERLAY_SIZE = 244; // Minimum size for the overlay

  const sectionWidth = section.clientWidth;

  const imageSize = Math.min(
    Math.max(sectionWidth * 0.5, MIN_IMAGE_SIZE),
    MAX_IMAGE_SIZE,
  );

  const overlaySize = Math.min(
    Math.max(sectionWidth * 0.6, MIN_OVERLAY_SIZE),
    MAX_OVERLAY_SIZE,
  );

  overlay.style.width = `${overlaySize}px`;
  overlay.style.height = `${overlaySize}px`;

  image.style.width = `${imageSize}px`;
}

// Initialize accordion functionality and resize logic
const accordions = document.querySelectorAll(".accordion-item");

if (accordions.length > 0) {
  document.addEventListener("DOMContentLoaded", () => {
    checkAccordionItems(accordions);
    resizeOverlayAndImage(); // Resize elements on page load
    window.addEventListener("resize", resizeOverlayAndImage); // Resize elements on window resize
  });
}

document.addEventListener("DOMContentLoaded", () => {
  const accordions = document.querySelectorAll(".accordion");

  const observerOptions = {
    root: null,
    threshold: 0.2,
  };

  const handleIntersect = (entries, observer) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const accordionItems = entry.target.querySelectorAll(
          ".block-accordion__accordions > *",
        );

        entry.target.classList.add("animate");

        accordionItems.forEach((item, index) => {
          item.style.setProperty("--item-index", index);
          item.classList.add("visible");
        });

        observer.unobserve(entry.target);
      }
    });
  };

  const observer = new IntersectionObserver(handleIntersect, observerOptions);

  accordions.forEach((accordion) => {
    observer.observe(accordion);
  });
});
