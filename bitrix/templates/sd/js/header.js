document.addEventListener('DOMContentLoaded', function(){
  var throttle = function (type, name, obj) {
    obj = obj || window;
    var running = false;
    var func = function () {
      if (running) {
        return;
      }
      running = true;
      requestAnimationFrame(function () {
        obj.dispatchEvent(new CustomEvent(name));
        running = false;
      });
    };
    obj.addEventListener(type, func);
  };

  throttle('scroll', 'optimizedScroll');

  var win = window;
  var doc = document.documentElement;
  var headerContainer = document.querySelector('.header-container');
  var header = document.querySelector('.header_wrapper header');

  var saleBannerContainer = document.querySelector('.sale-banner-container');
  var saleBanner = document.querySelector('.sale-banner');

  var getWindowTop = function(){
    return (win.pageYOffset || doc.scrollTop)  - (doc.clientTop || 0);
  };

  ['optimizedScroll', 'load'].forEach(function(event){
    win.addEventListener(event, function(){
      // 28 - высота topline, 35 - высота sale-banner
      if (headerContainer.getBoundingClientRect().top - 35 <= 0) {
        header.classList.add('is-fixed');
      } else {
        header.classList.remove('is-fixed');
      }

      if (saleBannerContainer.getBoundingClientRect().top <= 0) {
        saleBanner.classList.add('is-fixed');
      } else {
        saleBanner.classList.remove('is-fixed');
      }
    });
  });
});