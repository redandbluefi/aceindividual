/**
 * A set of reusable functions for vue paginations
 */

export function scrollToTop() {
  //  document.querySelector(location).scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
}
function changePage(setPage) {
  this.page = setPage;
  this.dotsRight = true;
  this.dotsLeft = true;
  this.fetchPosts();
  // this.scrollToTop();
  this.hideThis();
}
export function setPageArrow(setPage) {
  this.page += setPage;
  this.dotsRight = true;
  this.dotsLeft = true;
  this.fetchPosts();
  // this.scrollToTop();
  this.hideThis();
}
export function hideThis(pageNumber) {
  if (pageNumber === 1 || pageNumber === this.totalPages) {
    return false;
  }
  if (this.page + 2 < pageNumber) {
    this.dotsRight = false;
    return true;
  }
  if (this.page - 2 > pageNumber) {
    this.dotsLeft = false;
    return true;
  }
  return false;
}
export default changePage;
