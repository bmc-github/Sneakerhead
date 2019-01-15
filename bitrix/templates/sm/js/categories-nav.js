document.addEventListener('DOMContentLoaded', function(){
  var classes = {
    endScroll: 'categories-nav--scroll-end',
    startScroll: 'categories-nav--scroll-start',
  };

  var categoriesNav = document.querySelector('.categories-nav'),
    categoriesNavScroll = document.querySelector('.categories-nav__scroll'),
		categoriesNavActiveItem = document.querySelector('.categories-nav__item--active');

  if (!categoriesNav && !categoriesNavScroll && !categoriesNavActiveItem) return;

  categoriesNavScroll.scrollLeft = categoriesNavActiveItem.offsetLeft;

  var checkScrollPosition = function(){
    var isEndScroll = categoriesNavScroll.scrollLeft + categoriesNavScroll.offsetWidth === categoriesNavScroll.scrollWidth;
    var isStartScroll = categoriesNavScroll.scrollLeft === 0;

    if (isEndScroll) {
      categoriesNav.classList.add(classes.endScroll);
    } else {
      categoriesNav.classList.remove(classes.endScroll);
    }

    if (isStartScroll) {
      categoriesNav.classList.add(classes.startScroll);
    } else {
      categoriesNav.classList.remove(classes.startScroll);
    }
  }

  checkScrollPosition();

  categoriesNavScroll.addEventListener('scroll', checkScrollPosition);
});