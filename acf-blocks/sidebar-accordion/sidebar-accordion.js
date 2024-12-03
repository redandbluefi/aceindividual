function ariaExpanded(button) {
  const isExpanded = button.getAttribute("aria-expanded") === "true";
  button.setAttribute("aria-expanded", !isExpanded);
}

function handleSidebarAccordion() {
  const sidebarItems = document.querySelectorAll(
    ".sidebar-accordion-item__header",
  );
  const contentContainer = document.querySelector(
    ".sidebar-accordion__content",
  );

  // Set first item as active by default
  const firstItem = sidebarItems[0];
  if (firstItem) {
    firstItem.classList.add("is-active");
    const firstPanelId = firstItem.getAttribute("aria-controls");
    const firstPanel = document.querySelector(`#${firstPanelId}`);
    if (firstPanel) {
      contentContainer.innerHTML = firstPanel.innerHTML;
    }
  }

  sidebarItems.forEach((item) => {
    item.addEventListener("click", () => {
      // Remove active class from all items
      sidebarItems.forEach((el) => el.classList.remove("is-active"));

      // Set the clicked item as active
      item.classList.add("is-active");

      // Toggle aria-expanded
      ariaExpanded(item);

      // Get the associated panel content
      const panelId = item.getAttribute("aria-controls");
      const panel = document.querySelector(`#${panelId}`);

      if (panel) {
        // Load the panel content into the main content container
        contentContainer.innerHTML = panel.innerHTML;
      }
    });
  });
}

function handleSidebarAccordionAnimation() {
  const sidebarAccordions = document.querySelectorAll(".sidebar-accordion");

  const observerOptions = {
    root: null,
    threshold: 0.2,
  };

  const handleIntersect = (entries, observer) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const sidebarItems = entry.target.querySelectorAll(
          ".sidebar-accordion__items > .sidebar-accordion-item",
        );

        entry.target.classList.add("animate");

        sidebarItems.forEach((item, index) => {
          item.style.setProperty("--item-index", index);
          item.classList.add("visible");
        });

        observer.unobserve(entry.target);
      }
    });
  };

  const observer = new IntersectionObserver(handleIntersect, observerOptions);

  sidebarAccordions.forEach((accordion) => {
    observer.observe(accordion);
  });
}

// Initialize sidebar accordion functionality
document.addEventListener("DOMContentLoaded", () => {
  handleSidebarAccordion();
  handleSidebarAccordionAnimation();
});
