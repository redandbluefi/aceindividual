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

// Initialize sidebar accordion functionality
document.addEventListener("DOMContentLoaded", handleSidebarAccordion);
