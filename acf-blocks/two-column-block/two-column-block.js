document.addEventListener("DOMContentLoaded", () => {
  const twoColumnBlocks = document.querySelectorAll(".two-column-block");

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const columns = entry.target.querySelectorAll(
            ".two-column-block__column--left, .two-column-block__column--right",
          );

          entry.target.classList.add("animate");

          columns.forEach((column, index) => {
            setTimeout(() => {
              column.classList.add("visible");
            }, index * 200);
          });

          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.2 },
  );

  twoColumnBlocks.forEach((block) => observer.observe(block));
});
