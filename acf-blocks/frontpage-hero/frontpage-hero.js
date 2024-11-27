document.addEventListener("DOMContentLoaded", () => {
  const hero = document.querySelector(".page-template-wide-template");

  if (hero) {
    heroAnimation(hero);
  }
});

function heroAnimation(hero) {
  const logo = document.getElementById("logo");
  const header = document.querySelector(".header");
  const heroContent = document.querySelector(
    ".block-frontpage-hero__inner-content",
  );

  if (!logo || !header || !heroContent) {
    return;
  }

  let heroBottom = heroContent.getBoundingClientRect().bottom + window.scrollY;

  window.addEventListener("resize", () => {
    heroBottom = heroContent.getBoundingClientRect().bottom + window.scrollY;
    setupAnimation();
  });

  let scrollListenerAdded = false;
  let currentLogoState = null; // 'desktop' or 'mobile'

  function setupAnimation() {
    if (!scrollListenerAdded) {
      window.addEventListener("scroll", onScroll);
      scrollListenerAdded = true;
      handleScroll();
    }
  }

  function isDesktop() {
    return window.innerWidth >= 834;
  }

  let ticking = false;

  function onScroll() {
    if (!ticking) {
      window.requestAnimationFrame(() => {
        handleScroll();
        ticking = false;
      });
      ticking = true;
    }
  }

  function handleScroll() {
    const scrollY = window.scrollY;
    const maxScale = 1;
    const scrollThreshold = heroBottom * 0.3;
    let progress = Math.min(scrollY / scrollThreshold, 1);

    // Round progress to avoid floating-point issues
    progress = parseFloat(progress.toFixed(5));

    if (isDesktop()) {
      // Desktop behavior
      let minScale =
        window.innerWidth >= 834 && window.innerWidth <= 1268 ? 0.4 : 0.2;

      let scaleFactor = maxScale - progress * (maxScale - minScale);
      scaleFactor = Math.max(scaleFactor, minScale);
      scaleFactor = parseFloat(scaleFactor.toFixed(5)); // Limit precision

      logo.style.transform = `translateX(-50%) scale(${scaleFactor})`;

      let logoTopStart = 150;
      let logoTopEnd = 18;
      let logoTop = logoTopStart - progress * (logoTopStart - logoTopEnd);
      logoTop = parseFloat(logoTop.toFixed(2)); // Limit precision
      logo.style.top = `${logoTop}px`;

      // Swap to desktop logo if not already
      if (currentLogoState !== "desktop") {
        swapLogoToDesktop();
        currentLogoState = "desktop";
      }
    } else {
      // Mobile behavior
      let minScale = 0.8;
      let scaleFactor = maxScale - progress * (maxScale - minScale);
      scaleFactor = Math.max(scaleFactor, minScale);
      scaleFactor = parseFloat(scaleFactor.toFixed(5)); // Limit precision

      // Adjust translateXValue to move the logo to -67%
      let translateXValue = -50 - progress * 17;
      translateXValue = parseFloat(translateXValue.toFixed(5)); // Limit precision

      logo.style.transform = `translateX(${translateXValue}%) scale(${scaleFactor})`;

      let logoTopStart = 150;
      let logoTopEnd = 25;
      let logoTop = logoTopStart - progress * (logoTopStart - logoTopEnd);
      logoTop = parseFloat(logoTop.toFixed(2)); // Limit precision
      logo.style.top = `${logoTop}px`;

      // Swap logos based on progress, avoiding unnecessary swaps
      if (progress >= 1 && currentLogoState !== "desktop") {
        swapLogoToDesktop();
        currentLogoState = "desktop";
      } else if (progress < 1 && currentLogoState !== "mobile") {
        swapLogoToMobile();
        currentLogoState = "mobile";
      }
    }

    let bgOpacity = progress;
    bgOpacity = parseFloat(bgOpacity.toFixed(5)); // Limit precision
    header.style.backgroundColor = `rgba(0, 0, 0, ${bgOpacity})`;

    if (scrollY >= heroBottom) {
      header.classList.add("header--stuck");
      header.classList.remove("header--fixed");
    } else {
      header.classList.remove("header--stuck");
      header.classList.add("header--fixed");
    }
  }

  function swapLogoToDesktop() {
    const logoMobile = logo.querySelector(".logo-mobile");
    const logoDesktop = logo.querySelector(".logo-desktop");
    if (logoMobile && logoDesktop) {
      logoMobile.style.display = "none";
      logoDesktop.style.display = "block";
    }
  }

  function swapLogoToMobile() {
    const logoMobile = logo.querySelector(".logo-mobile");
    const logoDesktop = logo.querySelector(".logo-desktop");
    if (logoMobile && logoDesktop) {
      logoMobile.style.display = "block";
      logoDesktop.style.display = "none";
    }
  }

  setupAnimation();
}
