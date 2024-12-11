document.addEventListener("DOMContentLoaded", () => {
  const hero = document.querySelector(".block-frontpage-hero");
  const mainNavigation = document.getElementById("main-navigation");
  const preloader = document.getElementById("preloader");
  const preloaderShownTimestamp = localStorage.getItem(
    "preloaderShownTimestamp",
  );
  const now = Date.now();
  const twentyFourHours = 24 * 60 * 60 * 1000;

  let showPreloader =
    !preloaderShownTimestamp ||
    now - parseInt(preloaderShownTimestamp, 10) >= twentyFourHours;

  if (showPreloader) {
    document.body.classList.add("preloader-active");
    if (preloader) preloader.classList.remove("hidden");
    initPreloader(hero, mainNavigation);
    localStorage.setItem("preloaderShownTimestamp", now.toString());
  } else {
    if (mainNavigation) mainNavigation.style.display = "block";
    if (hero) hero.classList.add("hero-fade-in");
  }

  if (hero) heroAnimation(hero);
});

function initPreloader(hero, mainNavigation) {
  const preloader = document.getElementById("preloader");
  const preloaderLogo = preloader.querySelector(".preloader-logo");
  const logoMobile = preloaderLogo.querySelector(".logo-mobile");
  const logoDesktop = preloaderLogo.querySelector(".logo-desktop");

  function swapPreloaderLogo() {
    if (window.innerWidth >= 834) {
      logoMobile.style.display = "none";
      logoDesktop.style.display = "block";
    } else {
      logoMobile.style.display = "block";
      logoDesktop.style.display = "none";
    }
  }

  swapPreloaderLogo();
  window.addEventListener("resize", swapPreloaderLogo);

  preloaderLogo.addEventListener(
    "animationend",
    () => {
      preloader.style.display = "none";
      document.body.classList.remove("preloader-active");
      if (hero) hero.classList.add("hero-fade-in");
      if (mainNavigation) mainNavigation.style.display = "block";
    },
    { once: true },
  );
}

function heroAnimation(hero) {
  const logo = document.getElementById("logo");
  const header = document.querySelector(".header");
  const heroContent = document.querySelector(
    ".block-frontpage-hero__inner-content",
  );

  if (!logo || !header || !heroContent) return;

  let heroBottom = heroContent.getBoundingClientRect().bottom + window.scrollY;
  let ticking = false;
  let currentLogoState = null;

  window.addEventListener("resize", () => {
    heroBottom = heroContent.getBoundingClientRect().bottom + window.scrollY;
    handleScroll();
  });

  window.addEventListener("scroll", () => {
    if (!ticking) {
      window.requestAnimationFrame(() => {
        handleScroll();
        ticking = false;
      });
      ticking = true;
    }
  });

  function initializeLogo() {
    const screenHeight = window.innerHeight;
    const screenWidth = window.innerWidth;

    // Dynamically calculate top position based on screen height
    const dynamicTop = calculateDynamicTop(screenWidth);
    logo.style.top = `${dynamicTop}px`;

    // Dynamically calculate max-width based on screen width
    const dynamicMaxWidth = calculateDynamicMaxWidth(screenWidth);
    logo.style.maxWidth = `${dynamicMaxWidth}rem`;

    // Transform and scale logic
    logo.style.transform = "translateX(-50%) scale(1)";

    if (isDesktop()) {
      swapLogoToDesktop();
      currentLogoState = "desktop";
    } else {
      swapLogoToMobile();
      currentLogoState = "mobile";
    }
  }

  function handleScroll() {
    const scrollY = window.scrollY;

    // Dynamically update logo's position and size on scroll
    initializeLogo();

    if (isDesktop()) {
      applyDesktopAnimation(scrollY);
    } else {
      applyMobileAnimation(scrollY);
    }
    adjustHeaderOpacity(scrollY / heroBottom, scrollY >= heroBottom);
  }

  function calculateDynamicTop(screenWidth) {
    if (screenWidth < 800) return 127;
    if (screenWidth < 1200) return 123;
    return 150;
  }

  function calculateDynamicMaxWidth(screenWidth) {
    if (screenWidth > 1920) return 57.5;
    if (screenWidth <= 1440) return 50;
    return 53;
  }

  function calculateMobileTranslate(scrollY) {
    const screenHeight = window.innerHeight;
    const baseTranslateY = -110;
    return baseTranslateY + (scrollY / screenHeight) * 10; // Adjust scaling factor as needed
  }

  function isDesktop() {
    return window.innerWidth >= 834;
  }

  function applyDesktopAnimation(scrollY) {
    const maxScale = 1;
    const minScale =
      window.innerWidth >= 834 && window.innerWidth <= 1268 ? 0.4 : 0.2;
    const scrollThreshold = heroBottom * 0.3;
    let progress = Math.min(scrollY / scrollThreshold, 1);
    progress = parseFloat(progress.toFixed(5));

    const scaleFactor = maxScale - progress * (maxScale - minScale);
    const logoTopStart = parseFloat(logo.style.top) || 150; // Use dynamic `top`
    const logoTopEnd = 10; // End point for desktop
    const logoTop = logoTopStart - progress * (logoTopStart - logoTopEnd);

    logo.style.transform = `translateX(-50%) scale(${scaleFactor.toFixed(5)})`;
    logo.style.top = `${logoTop.toFixed(2)}px`;

    if (currentLogoState !== "desktop") {
      swapLogoToDesktop();
      currentLogoState = "desktop";
    }
  }

  function applyMobileAnimation(scrollY) {
    const scrollThreshold = heroBottom * 0.1;
    const logoStartTranslateX = -50;
    const dynamicTranslateY = calculateMobileTranslate(scrollY);

    if (scrollY > scrollThreshold && currentLogoState !== "desktop") {
      logo.style.transform = `translate(-65%, ${dynamicTranslateY}px) scale(0.8)`;
      logo.classList.add("logo--desktop");
      logo.classList.remove("logo--mobile");
      swapLogoToDesktop();
      currentLogoState = "desktop";
    } else if (scrollY <= scrollThreshold && currentLogoState !== "mobile") {
      logo.style.transform = `translate(${logoStartTranslateX}%, 0) scale(1)`;
      logo.classList.add("logo--mobile");
      logo.classList.remove("logo--desktop");
      swapLogoToMobile();
      currentLogoState = "mobile";
    }
  }

  function adjustHeaderOpacity(progress, isStuck) {
    header.style.backgroundColor = `rgba(0, 0, 0, ${progress.toFixed(3)})`;
    header.classList.toggle("header--stuck", isStuck);
    header.classList.toggle("header--fixed", !isStuck);
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

  initializeLogo();
  handleScroll();
}
