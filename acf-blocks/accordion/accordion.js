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

  const sectionWidth = section.clientWidth;
  const newSize = Math.min(
    Math.max(sectionWidth * 0.5, MIN_IMAGE_SIZE),
    MAX_IMAGE_SIZE,
  ); // Calculate the new size within the allowed range

  // Set the overlay dimensions
  overlay.style.width = `${newSize}px`;
  overlay.style.height = `${newSize}px`;

  // Position and size the image
  image.style.width = `${newSize}px`;
  image.style.height = `${newSize}px`;
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
