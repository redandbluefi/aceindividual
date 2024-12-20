import { debounce } from 'lodash-es';
import getCssVariableValue from '../helpers/get-css-variable-value';

function initNavigation() {
  // 1. ELEMENTS
  const siteWrapper = document?.querySelector('#page') ?? null;
  const skipLink = document?.querySelector('.skip-link') ?? null;
  const siteBranding = document?.querySelector('.site-branding__link') ?? null;
  const siteContent = document?.querySelector('.site-content') ?? null;
  const footer = document?.querySelector('.site-footer') ?? null;
  const backToTop: HTMLButtonElement | null = document?.querySelector('#top') ?? null;
  const mobileMenuToggle: HTMLButtonElement | null = document?.querySelector('#menu-toggle') ?? null;
  const mobileMenuDialog: HTMLDialogElement | null = document?.querySelector('#mobile-menu') ?? null;
  const desktopMenu: HTMLDialogElement | null = document?.querySelector('#main-menu-desktop') ?? null;
  const mobileMenu: HTMLDialogElement | null = document?.querySelector('#main-menu-mobile') ?? null;
  const contactButton: HTMLButtonElement | null = document?.querySelector('#menu-mobile__contact-button') ?? null;

  const dialogTransitionDuration = parseInt(
    getComputedStyle(document?.documentElement)
      ?.getPropertyValue('--rnb--transition-duration--dialog')
      ?.replace('ms', '') || '300',
    10,
  );
  const desktopSubMenuToggles: HTMLButtonElement[] = Array.from(desktopMenu?.querySelectorAll('.sub-menu__toggle') || []);
  const mobileSubMenuToggles: HTMLButtonElement[] = Array.from(mobileMenu?.querySelectorAll('.sub-menu__toggle') || []);

  const dialogSets = [
    {
      dialog: mobileMenuDialog,
      button: mobileMenuToggle,
    },
  ]; // all dialogs and their toggle buttons

  // 2. CONSTANTS / STATE VARIABLES
  const mobileMenuBreakpoint = getCssVariableValue({
    name: '--breakpoint-mobile-menu',
    unit: 'px',
  }) ?? null;
  let scrollingPosition = window.scrollY;

  // fail early if no elements are found
  if (!desktopMenu || !mobileMenu) {
    return;
  }

  // Update css variable that is used for displaying elements with wp admin bar
  function updateWPAdminBarOffset() {
    const wpAdminBar = document?.querySelector('#wpadminbar') ?? null;
    if (!wpAdminBar) {
      return;
    }
    const offsetValue = wpAdminBar?.getBoundingClientRect().height;
    document.documentElement.style.setProperty(
      '--wp-admin-bar-offset',
      `${offsetValue}px`,
    );
  }

  // Update css variable that is used for adding margin top to site body (when sticky header is positioned fixed)
  function updateStickyHeaderHeight() {
    const header = document?.querySelector('.sticky-header') ?? null;
    if (header) {
      const headerHeight = header?.getBoundingClientRect().height;
      document?.documentElement?.style?.setProperty(
        '--header--height',
        `${headerHeight}px`,
      );
    }
  }

  // Update css variable that is used for displaying mobile menu
  function updateMobileMenuOffset() {
    const header = document?.querySelector('#site-header') ?? null;
    if (header) {
      const offsetValue = header.getBoundingClientRect().height;
      mobileMenuDialog?.style?.setProperty(
        '--mobile-menu-offset',
        `${offsetValue}px`,
      );
    }
  }

  function closeSingleSubMenu(subMenu) {
    subMenu?.classList.add('closing');
    subMenu?.classList.remove('sub-menu-open');
    const subMenuToggle = subMenu?.querySelector('.sub-menu__toggle');
    subMenuToggle.setAttribute('aria-expanded', false);
    const toggleIcon = subMenu?.querySelector('.sub-menu__toggle-icon');
    toggleIcon?.classList.remove('sub-menu__toggle-icon--open');
  }

  function closeOpenSubMenus(menu) {
    const openSubMenus = menu?.querySelectorAll('.sub-menu-open');
    openSubMenus.forEach((subMenu) => closeSingleSubMenu(subMenu));
  }

  // Update css variable that is used for displaying sub menus on desktop
  function updateSubMenuOffset(toggle) {
    const nav = document?.querySelector('#nav-primary') ?? null;
    if (nav) {
      const navBottom = nav.getBoundingClientRect().bottom;
      const toggleTop = toggle.getBoundingClientRect().top;
      const offsetValue = navBottom - toggleTop + 8;
      document.documentElement.style.setProperty(
        '--nav-sub-menu-offset',
        `${offsetValue}px`,
      );
    }
  }

  function openSubMenu(args) {
    const { subMenu, toggle, menu } = args;
    if (menu.id === 'main-menu-desktop') {
      updateSubMenuOffset(toggle);
    }
    subMenu?.classList.add('sub-menu-open');
    toggle.setAttribute('aria-expanded', true);
    const toggleIcon = subMenu?.querySelector('.sub-menu__toggle-icon');
    toggleIcon?.classList.add('sub-menu__toggle-icon--open');
  }

  function handleHiddenAttributes(target) {
    if (!target) {
      return;
    }
    const targetAttribute = target?.getAttribute('aria-hidden');
    if (targetAttribute === 'true') {
      target?.setAttribute('aria-hidden', 'false');
      target.inert = false;
    } else if (targetAttribute === 'false') {
      target?.setAttribute('aria-hidden', 'true');
      target.inert = true;
    }
  }

  function openDialog(dialog, duration: number) {
    updateMobileMenuOffset();
    dialog?.show();
    dialog?.classList.add('opening');
    document?.body?.classList.add('dialog-open');
    setTimeout(() => {
      dialog?.classList.remove('opening');
    }, duration);
    // hide all elments outside of dialog that screen readers should not read
    handleHiddenAttributes(skipLink);
    handleHiddenAttributes(siteBranding);
    handleHiddenAttributes(siteContent);
    handleHiddenAttributes(footer);
    handleHiddenAttributes(backToTop);

    // set focus to dialog's first focusable element
    const focusableElements = 'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])';
    const firstFocusableElement = dialog?.querySelectorAll(focusableElements)[0]; // get first element to be focused inside modal
    firstFocusableElement.focus();
  }

  function closeDialog(dialog: HTMLDialogElement, duration: number) {
    dialog?.classList.add('closing');
    setTimeout(() => {
      dialog?.classList?.remove('closing');
      dialog?.close();
    }, duration);
    // show all elments outside of dialog that screen readers should read
    handleHiddenAttributes(skipLink);
    handleHiddenAttributes(siteBranding);
    handleHiddenAttributes(siteContent);
    handleHiddenAttributes(footer);
    handleHiddenAttributes(backToTop);
    document?.body?.classList.remove('dialog-open');
  }

  async function toggleDialog(args, duration: number) {
    const { dialog, button } = args;
    // if dialog is open, close it
    if (dialog.open) {
      closeDialog(dialog, duration);
      button.dataset.action = 'open';
      button.ariaLabel = button.dataset.ariaOpen;
    } else {
      // else open the dialog
      // first, close all other open dialogs
      dialogSets.forEach(async (dialogSet: { dialog: HTMLDialogElement | null, button: HTMLButtonElement | null }) => {
        if (dialogSet?.dialog?.open) {
          const updatedDialogButton = { ...dialogSet.button };
          closeDialog(dialogSet.dialog, duration);
          if (updatedDialogButton?.dataset) {
            updatedDialogButton.dataset.action = 'open';
            updatedDialogButton.ariaLabel = button.dataset.ariaOpen;
          }
        }
      });
      openDialog(dialog, duration);
      button.dataset.action = 'close';
      button.ariaLabel = button.dataset.ariaClose;
    }
  }

  function handleEscapeKey() {
    // if mobile menu is open, close it
    if (mobileMenuDialog?.open) {
      toggleDialog({ dialog: mobileMenuDialog, button: mobileMenuToggle }, dialogTransitionDuration);
    }

    // If submenus' are open, close them
    const desktopSubMenuOpen = (desktopMenu?.querySelectorAll('.sub-menu-open')?.length || 0) > 0;
    if (desktopSubMenuOpen) {
      closeOpenSubMenus(desktopMenu);
    }
  }

  interface ToggleSubMenuArgs {
    toggle: HTMLButtonElement | null,
    menu: HTMLDialogElement | null
  }

  function toggleSubMenu(args: ToggleSubMenuArgs) {
    const { toggle, menu } = args;
    const selectedSubMenu = toggle?.parentElement;

    if (selectedSubMenu?.classList?.contains('sub-menu-open')) {
      // if selected menu is already open -> close it
      closeSingleSubMenu(selectedSubMenu);
      return;
    }

    // close any open submenus
    closeOpenSubMenus(menu);

    // open selected submenu
    openSubMenu({
      subMenu: selectedSubMenu,
      toggle,
      menu,
    });
  }

  // focus trap for dialogs
  function focusTrapDialog(args) {
    const { dialog, additionalElements, event } = args;
    const dialogSelectors = `#${dialog.id} button, #${dialog.id} a[href], #${dialog.id} input, #${dialog.id} select, #${dialog.id} textarea, #${dialog.id} [tabindex]:not([tabindex="-1"])`;
    const dialogElements = Array.from(
      document?.querySelectorAll(dialogSelectors),
    );
    const focusableElements = [...additionalElements, ...dialogElements]; // combine additional elements and dialog elements
    const activeElementOutside = !focusableElements.includes(
      document.activeElement,
    ); // whether active element is outside of dialog and additional elements

    if (activeElementOutside) {
      event.preventDefault();
      focusableElements[0].focus(); // add focus for the first focusable element
      return;
    }

    const currentIndex = focusableElements.indexOf(document.activeElement);
    const increment = event.shiftKey ? -1 : 1; // if shift key pressed for shift + tab combination then decrement, if not then increment
    const nextIndex = currentIndex + increment;

    switch (currentIndex) {
      // first focusable element aka first additional element
      case 0:
        if (nextIndex < 0) {
          focusableElements[focusableElements.length - 1].focus();
          event.preventDefault();
        }
        break;

      // last additional element
      case additionalElements.length - 1:
        if (nextIndex > additionalElements.length - 1) {
          focusableElements[additionalElements.length].focus();
          event.preventDefault();
        }
        break;

      // first focusable dialog element
      case additionalElements.length:
        if (nextIndex < additionalElements.length) {
          focusableElements[additionalElements.length - 1].focus();
          event.preventDefault();
        }
        break;

      // last focusable element aka last dialog element
      case focusableElements.length - 1:
        if (nextIndex > focusableElements.length - 1) {
          focusableElements[0].focus();
          event.preventDefault();
        }
        break;
      default:
        break;
    }
  }

  function handleTabKey(e) {
    dialogSets.forEach((dialogSet) => {
      // if any dialog is open, trap focus to dialog + additional elements outside of it
      if (dialogSet?.dialog?.open) {
        let selectors = '';
        switch (dialogSet.dialog.id) {
          case 'mobile-menu':
            selectors = '#site-header button, #site-header a[href], #site-header [tabindex]:not([tabindex="-1"])';
            break;
          default:
            selectors = `#${dialogSet?.button?.id}`;
            break;
        }

        // get all visible elements that are outside of dialog but should be included in focus trap
        const additionalElements = Array.from(
          document?.querySelectorAll<HTMLElement>(selectors),
        ).filter((element) => element?.offsetParent !== null);

        focusTrapDialog({
          dialog: dialogSet.dialog,
          additionalElements,
          event: e,
        });
      }
    });
  }

  // Handle scrolling event: show / hide sticky header
  function handleScrolling(prevScrollpos) {
    const header: HTMLDivElement | null = document?.querySelector('.sticky-header');
    const wpAdminBar: HTMLDivElement | null = document?.querySelector('#wpadminbar') ?? null;
    const headerHeight = wpAdminBar
      ? (header?.offsetHeight || 0) + wpAdminBar.offsetHeight
      : (header?.offsetHeight || 0);
    const currentScrollPos = window.scrollY;

    // scrolling down on mobile with wp admin bar
    if (
      wpAdminBar
      && window.innerWidth <= 600
      && prevScrollpos > currentScrollPos
      && prevScrollpos < wpAdminBar.offsetHeight
      && header
    ) {
      header.style.top = `${wpAdminBar.offsetHeight}px`;
    } else if (prevScrollpos > currentScrollPos && header) {
      // scrolling up: display nav bar
      header.style.top = wpAdminBar && window.innerWidth > 600
        ? `${wpAdminBar.offsetHeight}px`
        : '0';
    } else if (currentScrollPos > headerHeight && header) {
      // scrolling down past menu: close opened search form / menu and hide nav bar
      header.style.top = `-${headerHeight}px`;
      closeOpenSubMenus(desktopMenu);
    }
    return currentScrollPos;
  }

  function handleScreenResize() {
    // close mobile menu if screen is resized to desktop size
    if (
      mobileMenuDialog?.open
      && mobileMenuBreakpoint
      && window.innerWidth > mobileMenuBreakpoint
    ) {
      toggleDialog({ dialog: mobileMenuDialog, button: mobileMenuToggle }, dialogTransitionDuration);
    }
    // update offset values
    updateWPAdminBarOffset();
    updateStickyHeaderHeight();
    updateMobileMenuOffset();
  }

  mobileSubMenuToggles?.forEach((toggle) => toggle?.addEventListener('click', () => toggleSubMenu({ toggle, menu: mobileMenu })));

  function handleAnchorLinkClick(event: Event) {
    const target = event.currentTarget as HTMLAnchorElement;
    const href = target.getAttribute('href');
    console.log('href', href);
    if (href && href.startsWith('#')) {
      if (mobileMenuDialog?.open) {
        closeDialog(mobileMenuDialog, dialogTransitionDuration);
        if (mobileMenuToggle) {
          mobileMenuToggle.dataset.action = 'open';
          mobileMenuToggle.ariaLabel = mobileMenuToggle.dataset.ariaOpen!;
          mobileMenuToggle.focus();
        }
      }
    }
  }

  const mobileMenuAnchorLinks = mobileMenu?.querySelectorAll('a[href^="#"]') || [];
  mobileMenuAnchorLinks.forEach((link) => {
    link.addEventListener('click', handleAnchorLinkClick);
  });

  contactButton?.addEventListener('click', handleAnchorLinkClick);

  function handleClickOutside(target) {
    // desktop sub menu
    const desktopSubMenus = desktopMenu?.querySelectorAll('.sub-menu');
    const desktopSubMenuOpen = (desktopSubMenus?.length || 0) > 0;
    if (
      desktopSubMenuOpen
      && !(
        target?.closest('.sub-menu__container')
        || target?.closest('.sub-menu__toggle')
      )
    ) {
      closeOpenSubMenus(desktopMenu);
    }
  }

  // Initialize offset values
  updateWPAdminBarOffset();
  updateStickyHeaderHeight();
  updateMobileMenuOffset();

  // Menu toggle: open / close
  mobileMenuToggle?.addEventListener('click', () => toggleDialog({
    dialog: mobileMenuDialog,
    button: mobileMenuToggle,
  }, dialogTransitionDuration));

  // desktop sub menu toggles
  desktopSubMenuToggles?.forEach((toggle) => toggle?.addEventListener('click', () => toggleSubMenu({ toggle, menu: desktopMenu })));

  // Mobile sub menu toggles
  mobileSubMenuToggles?.forEach((toggle) => toggle?.addEventListener('click', () => toggleSubMenu({ toggle, menu: mobileMenu })));

  // mouse click outside opened menu
  siteWrapper?.addEventListener('click', (e) => handleClickOutside(e.target));

  document.addEventListener('keydown', (e: KeyboardEvent) => {
    // escape key
    if (e.key === 'Escape') {
      handleEscapeKey();
      return;
    }

    // tab key
    if (e.key === 'Tab') {
      handleTabKey(e);
    }
  });

  // screen resize
  window.addEventListener('resize', debounce(() => handleScreenResize(), 300));

  // scroll
  window.addEventListener('scroll', () => {
    scrollingPosition = handleScrolling(scrollingPosition);
  });
}

export default initNavigation;
