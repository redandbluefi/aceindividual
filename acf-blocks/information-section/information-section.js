document.addEventListener("DOMContentLoaded", () => {
  const blockInfos = document.querySelectorAll(".block-info");

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("animate");

          const items = entry.target.querySelectorAll(".block-info__item");
          items.forEach((item, index) => {
            item.style.setProperty("--item-index", index);
            item.classList.add("visible");
          });

          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.2 },
  );

  blockInfos.forEach((blockInfo) => observer.observe(blockInfo));
});
