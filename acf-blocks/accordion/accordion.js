function ariaExpanded(button) {
  const xAria = button.getAttribute('aria-expanded') === 'true' ? 'false' : 'true';

  button.setAttribute('aria-expanded', xAria);
}

function checkAccordionItems(accordions) {
  accordions.forEach(async (accordion) => {
    const button = accordion.querySelector('.accordion-item__header');

    button.addEventListener('click', () => {
      ariaExpanded(button);

      const panel = accordion.querySelector('.accordion-item__panel');

      const ariaExpandedAttribute = button.getAttribute('aria-expanded');

      if (ariaExpandedAttribute === 'true') {
        // Set max height.
        panel.style.display = 'block';
        panel.classList.add('max-height');
        panel.style.maxHeight = `${panel.scrollHeight}px`;
      } else {
        // Remove max height.
        panel.style.maxHeight = null;
        panel.style.display = 'none';
      }
    });
  });
}

// Init conditionally.
const accordions = document.querySelectorAll('.accordion-item');

if (accordions.length > 0) {
  document.addEventListener('DOMContentLoaded', () => checkAccordionItems(accordions));
}
