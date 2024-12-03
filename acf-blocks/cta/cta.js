document.addEventListener("DOMContentLoaded", () => {
  const ctaBlock = document.querySelector(".block-cta");
  const ctaButtons = document.querySelectorAll(".block-cta__button");

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("animate");

          ctaButtons.forEach((button, index) => {
            button.style.setProperty("--cta-button-index", index);
            button.classList.add("visible");
          });

          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.2 },
  );

  if (ctaBlock) observer.observe(ctaBlock);
});
