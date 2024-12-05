/* eslint-disable max-len, no-param-reassign, no-unused-vars */
/**
 * Eternia Front End JS, loaded on all pages
 */

// Import modules
import reframe from 'reframe.js';
import './core-image-lightbox';
import {
  initExternalLinkLabels,
  styleExternalLinks,
} from './modules/external-link';
import initFooterAnimation from './modules/footerAnimation';
import initNavigation from './modules/navigation';
import './modules/search';
import initTooltip from './modules/tooltip';

// Define Javascript is active by changing the body class
document.body.classList.remove('no-js');
document.body.classList.add('js');

document.addEventListener('DOMContentLoaded', () => {
  initNavigation();
  // Fit video embeds to container
  reframe('.wp-has-aspect-ratio iframe');
  styleExternalLinks();
  initExternalLinkLabels();
  const hasTooltip = document.querySelector('#tooltip');
  if (hasTooltip) {
    initTooltip();
  }

  initFooterAnimation();
});
