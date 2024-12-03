document.addEventListener("DOMContentLoaded", () => {
  const contactBlock = document.querySelector(".block-contact");
  const personnelItems = document.querySelectorAll(
    ".block-contact__personnel .person",
  );
  const contactForm = document.querySelector(".block-contact__form");

  const observerOptions = {
    root: null,
    threshold: 0.2,
  };

  const observerCallback = (entries, observer) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("animate");

        personnelItems.forEach((person, index) => {
          person.style.setProperty("--person-index", index);
          person.classList.add("visible");
        });

        if (contactForm) {
          contactForm.classList.add("visible");
        }

        observer.unobserve(entry.target);
      }
    });
  };

  const observer = new IntersectionObserver(observerCallback, observerOptions);

  if (contactBlock) {
    observer.observe(contactBlock);
  }
});
