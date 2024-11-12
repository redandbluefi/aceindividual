document.addEventListener("DOMContentLoaded", () => {
  const {
    current_user,
    frontpage_info,
    trash_button_texts,
    no_permission_message,
  } = test;
  const userRoles = current_user.roles;
  const isAdmin = userRoles.includes("administrator");

  if (!isAdmin) {
    // Filter out null values from frontpage_info
    const validFrontPageIds = Object.values(frontpage_info).filter(
      (id) => id !== null,
    );

    // Function to block delete buttons in the editor
    const blockEditorDeleteButton = () => {
      wp.data.subscribe(() => {
        const currentPostId = wp.data.select("core/editor").getCurrentPostId();
        if (validFrontPageIds.includes(currentPostId)) {
          const observer = new MutationObserver(() => {
            const trashButton = [
              ...document.querySelectorAll('[role="menuitem"]'),
            ].find((item) => {
              const text = item.innerText.toLowerCase();
              // Check if the button text matches any of the localized "Move to Trash" texts
              return trash_button_texts.some((trashText) =>
                text.includes(trashText.toLowerCase()),
              );
            });
            if (trashButton) {
              trashButton.remove(); // Remove the delete button
              observer.disconnect(); // Stop observing after finding and removing the button
            }
          });
          observer.observe(document.body, { childList: true, subtree: true });
        }
      });

      // Function to block delete buttons in the Classic Editor
      const classicObserver = new MutationObserver(() => {
        const deleteButton = document.querySelector(
          "#major-publishing-actions #delete-action a",
        );
        if (deleteButton) {
          deleteButton.style.pointerEvents = "none";
          deleteButton.style.opacity = "0.5";
          deleteButton.style.color = "gray";
          deleteButton.onclick = (e) => {
            e.preventDefault();
            alert(no_permission_message); // Notify the user that they cannot delete the page
          };
          classicObserver.disconnect(); // Stop observing after finding and disabling the button
        }
      });
      classicObserver.observe(document.body, {
        childList: true,
        subtree: true,
      });
    };

    // Initial call to block delete buttons in the editor
    blockEditorDeleteButton();

    // Function to block delete buttons in the page list
    const blockListDeleteButtons = () => {
      validFrontPageIds.forEach((id) => {
        const deleteLinks = document.querySelectorAll(
          `tr#post-${id} .submitdelete`,
        );
        deleteLinks.forEach((link) => {
          link.style.pointerEvents = "none";
          link.style.opacity = "0.5";
          link.style.color = "gray";
          link.onclick = (e) => {
            e.preventDefault();
            alert(no_permission_message); // Notify the user that they cannot delete the page
          };
        });
      });
    };

    // Use MutationObserver to monitor changes in the DOM on the page list
    const listObserver = new MutationObserver(blockListDeleteButtons);
    listObserver.observe(document.body, { childList: true, subtree: true });

    // Initial call to block delete buttons in the page list
    blockListDeleteButtons();
  }
});
