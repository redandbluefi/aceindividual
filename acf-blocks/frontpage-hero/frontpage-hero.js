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

  function isDesktop() {
    return window.innerWidth >= 834;
  }

  let heroBottom = heroContent.getBoundingClientRect().bottom + window.scrollY;

  window.addEventListener("resize", () => {
    heroBottom = heroContent.getBoundingClientRect().bottom + window.scrollY;
    setupAnimation();
  });

  let scrollListenerAdded = false;
  let minScale = 0.2;

  function setupAnimation() {
    if (isDesktop()) {
      if (window.innerWidth >= 834 && window.innerWidth <= 1268) {
        minScale = 0.4;
      } else if (window.innerWidth > 1268) {
        minScale = 0.2;
      }

      if (!scrollListenerAdded) {
        window.addEventListener("scroll", handleScroll);
        scrollListenerAdded = true;
        handleScroll();
      }
    } else {
      if (scrollListenerAdded) {
        window.removeEventListener("scroll", handleScroll);
        scrollListenerAdded = false;
        logo.style.transform = "";
        logo.style.top = "";
        header.style.backgroundColor = "";
        header.classList.remove("header--stuck");
        header.classList.remove("header--fixed");
      }
    }
  }

  function handleScroll() {
    const scrollY = window.scrollY;
    const maxScale = 1;
    const scrollThreshold = heroBottom * 0.3;
    let progress = Math.min(scrollY / scrollThreshold, 1);
    let scaleFactor = maxScale - progress * (maxScale - minScale);
    scaleFactor = Math.max(scaleFactor, minScale);
    logo.style.transform = `translateX(-50%) scale(${scaleFactor})`;
    let logoTopStart = 100;
    let logoTopEnd = 13.5;
    let logoTop = logoTopStart - progress * (logoTopStart - logoTopEnd);
    logo.style.top = `${logoTop}px`;
    let bgOpacity = progress;
    header.style.backgroundColor = `rgba(0, 0, 0, ${bgOpacity})`;

    if (scrollY >= heroBottom) {
      header.classList.add("header--stuck");
      header.classList.remove("header--fixed");
    } else {
      header.classList.remove("header--stuck");
      header.classList.add("header--fixed");
    }
  }

  setupAnimation();
}
