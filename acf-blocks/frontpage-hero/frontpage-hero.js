document.addEventListener("DOMContentLoaded", () => {
  const hero = document.querySelector(".block-frontpage-hero"); // Get the hero section element
  const mainNavigation = document.getElementById("main-navigation"); // Get the main navigation element
  const preloader = document.getElementById("preloader"); // Get the preloader element

  // Retrieve the timestamp of when the preloader was last shown from localStorage
  const preloaderShownTimestamp = localStorage.getItem(
    "preloaderShownTimestamp",
  );
  const now = Date.now(); // Get the current timestamp
  const twentyFourHours = 24 * 60 * 60 * 1000; // 24 hours in milliseconds

  let showPreloader = true; // Flag to determine whether to show the preloader

  if (preloaderShownTimestamp) {
    const timeSinceLastShown = now - parseInt(preloaderShownTimestamp, 10); // Calculate time since last shown
    if (timeSinceLastShown < twentyFourHours) {
      showPreloader = false; // Do not show the preloader if less than 24 hours have passed
    }
  }

  if (showPreloader) {
    document.body.classList.add("preloader-active"); // Add class to body to indicate preloader is active

    if (preloader) {
      preloader.classList.remove("hidden"); // Make the preloader visible
    }

    initPreloader(hero, mainNavigation); // Initialize the preloader animations and logic

    // Store the current timestamp to track when the preloader was last shown
    localStorage.setItem("preloaderShownTimestamp", now.toString());
  } else {
    // If preloader should not be shown, display main navigation and hero content immediately
    if (mainNavigation) {
      mainNavigation.style.display = "block"; // Show the main navigation
    }
    if (hero) {
      hero.classList.add("hero-fade-in"); // Start the hero fade-in animation
    }
  }

  if (hero) {
    heroAnimation(hero); // Initialize the hero animations
  }
});

function initPreloader(hero, mainNavigation) {
  const preloader = document.getElementById("preloader"); // Get the preloader element
  const preloaderLogo = preloader.querySelector(".preloader-logo"); // Get the logo within the preloader
  const logoMobile = preloaderLogo.querySelector(".logo-mobile"); // Mobile version of the logo
  const logoDesktop = preloaderLogo.querySelector(".logo-desktop"); // Desktop version of the logo

  // Function to swap logos based on screen width
  function swapPreloaderLogo() {
    if (window.innerWidth >= 834) {
      logoMobile.style.display = "none"; // Hide mobile logo
      logoDesktop.style.display = "block"; // Show desktop logo
    } else {
      logoMobile.style.display = "block"; // Show mobile logo
      logoDesktop.style.display = "none"; // Hide desktop logo
    }
  }

  swapPreloaderLogo(); // Initial call to set the correct logo
  window.addEventListener("resize", swapPreloaderLogo); // Update logo on window resize

  preloaderLogo.addEventListener(
    "animationend",
    function () {
      preloader.style.display = "none"; // Hide the preloader after animation ends
      document.body.classList.remove("preloader-active"); // Remove active class from body

      if (hero) {
        hero.classList.add("hero-fade-in"); // Start the hero fade-in animation
      }

      if (mainNavigation) {
        mainNavigation.style.display = "block"; // Show the main navigation
      }
    },
    { once: true }, // Ensure the event listener is called only once
  );
}

function heroAnimation(hero) {
  // Select key elements required for the animation
  const logo = document.getElementById("logo"); // The logo element to animate
  const header = document.querySelector(".header"); // The header element
  const heroContent = document.querySelector(
    ".block-frontpage-hero__inner-content",
  ); // Content within the hero section

  // Exit the function if any required element is missing
  if (!logo || !header || !heroContent) {
    return;
  }

  // Calculate the bottom position of the hero content relative to the page
  let heroBottom = heroContent.getBoundingClientRect().bottom + window.scrollY;

  // Update heroBottom when the window is resized
  window.addEventListener("resize", () => {
    heroBottom = heroContent.getBoundingClientRect().bottom + window.scrollY;
    setupAnimation();
  });

  // Prevent multiple scroll listeners
  let scrollListenerAdded = false;
  let currentLogoState = null; // Tracks whether the logo is in "desktop" or "mobile" mode

  // Add scroll listener if it hasn’t been added already
  function setupAnimation() {
    if (!scrollListenerAdded) {
      window.addEventListener("scroll", onScroll);
      scrollListenerAdded = true;

      // Trigger the initial animation state
      handleScroll();
    }
  }

  // Check if the device is in desktop mode based on screen width
  function isDesktop() {
    return window.innerWidth >= 834;
  }

  // Use requestAnimationFrame to optimize scrolling performance
  let ticking = false;

  function onScroll() {
    if (!ticking) {
      window.requestAnimationFrame(() => {
        handleScroll();
        ticking = false; // Reset the ticking flag
      });
      ticking = true; // Prevent additional calls until the current one is resolved
    }
  }

  function handleScroll() {
    const scrollY = window.scrollY; // Get the current scroll position
    const maxScale = 1; // Maximum scale for the logo
    const scrollThreshold = heroBottom * 0.3; // Define the scroll range for the animation
    let progress = Math.min(scrollY / scrollThreshold, 1); // Normalize scroll progress to a range of 0 to 1

    // Round progress to avoid floating-point errors
    progress = parseFloat(progress.toFixed(5));

    if (isDesktop()) {
      // Animation logic for desktop devices
      let minScale =
        window.innerWidth >= 834 && window.innerWidth <= 1268 ? 0.4 : 0.2;

      // Calculate the scale factor for the logo
      let scaleFactor = maxScale - progress * (maxScale - minScale);
      scaleFactor = Math.max(scaleFactor, minScale); // Ensure the scale doesn't go below the minimum
      scaleFactor = parseFloat(scaleFactor.toFixed(5)); // Round to improve precision

      // Apply scaling and centering transformations to the logo
      logo.style.transform = `translateX(-50%) scale(${scaleFactor})`;

      // Adjust the top position of the logo
      let logoTopStart = 150;
      let logoTopEnd = 18;
      let logoTop = logoTopStart - progress * (logoTopStart - logoTopEnd);
      logoTop = parseFloat(logoTop.toFixed(2)); // Round for precision
      logo.style.top = `${logoTop}px`;

      // Swap to the desktop version of the logo if necessary
      if (currentLogoState !== "desktop") {
        swapLogoToDesktop();
        currentLogoState = "desktop";
      }
    } else {
      // Animation logic for mobile devices
      let minScale = 0.8; // Minimum scale for mobile devices
      let scaleFactor = maxScale - progress * (maxScale - minScale);
      scaleFactor = Math.max(scaleFactor, minScale); // Ensure the scale doesn't go below the minimum
      scaleFactor = parseFloat(scaleFactor.toFixed(5)); // Round for precision

      // Adjust horizontal translation (shift left)
      let translateXValue = -50 - progress * 17; // Moves from -50% to -67%
      translateXValue = parseFloat(translateXValue.toFixed(5)); // Round for precision

      // Apply scaling and horizontal translation to the logo
      logo.style.transform = `translateX(${translateXValue}%) scale(${scaleFactor})`;

      // Adjust the top position of the logo
      let logoTopStart = 150;
      let logoTopEnd = 25;
      let logoTop = logoTopStart - progress * (logoTopStart - logoTopEnd);
      logoTop = parseFloat(logoTop.toFixed(2)); // Round for precision
      logo.style.top = `${logoTop}px`;

      // Swap logos based on the scroll progress
      if (progress >= 1 && currentLogoState !== "desktop") {
        swapLogoToDesktop();
        currentLogoState = "desktop";
      } else if (progress < 1 && currentLogoState !== "mobile") {
        swapLogoToMobile();
        currentLogoState = "mobile";
      }
    }

    // Adjust the header's background opacity based on scroll progress
    let bgOpacity = progress;
    bgOpacity = parseFloat(bgOpacity.toFixed(5)); // Round for precision
    header.style.backgroundColor = `rgba(0, 0, 0, ${bgOpacity})`;

    // Add or remove header classes based on scroll position
    if (scrollY >= heroBottom) {
      header.classList.add("header--stuck");
      header.classList.remove("header--fixed");
    } else {
      header.classList.remove("header--stuck");
      header.classList.add("header--fixed");
    }
  }

  // Swap the logo to the desktop version
  function swapLogoToDesktop() {
    const logoMobile = logo.querySelector(".logo-mobile");
    const logoDesktop = logo.querySelector(".logo-desktop");
    if (logoMobile && logoDesktop) {
      logoMobile.style.display = "none"; // Hide the mobile logo
      logoDesktop.style.display = "block"; // Show the desktop logo
    }
  }

  // Swap the logo to the mobile version
  function swapLogoToMobile() {
    const logoMobile = logo.querySelector(".logo-mobile");
    const logoDesktop = logo.querySelector(".logo-desktop");
    if (logoMobile && logoDesktop) {
      logoMobile.style.display = "block"; // Show the mobile logo
      logoDesktop.style.display = "none"; // Hide the desktop logo
    }
  }

  // Initialize the animation by adding the scroll listener
  setupAnimation();
}
