export default function initFooterAnimation() {
  const footerLogo = document.querySelector(".site-branding__logo");
  const footer = document.querySelector(".site-branding");

  if (!footerLogo || !footer) return;

  function triggerAnimation(entries) {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        footerLogo.classList.remove("blink");
        void footerLogo.offsetWidth;
        footerLogo.classList.add("blink");
      }
    });
  }

  const observer = new IntersectionObserver(triggerAnimation, {
    root: null,
    threshold: 0.5,
  });

  observer.observe(footer);
}
