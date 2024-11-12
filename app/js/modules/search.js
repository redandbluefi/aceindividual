document.addEventListener('DOMContentLoaded', () => {
  // get searchMeta element in search.php
  const searchMeta = document.getElementById('search-meta');
  // if searchMeta element is found, scroll to it and focus on it screen readers will read the searchMeta element
  if (searchMeta) {
    window.scrollTo({
      top: searchMeta.offsetTop,
      behavior: 'smooth',
    });
    searchMeta.focus();
  }
});
