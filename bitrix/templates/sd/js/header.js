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
  var header = document.querySelector('.header_wrapper header');

  var getWindowTop = function(){
    return (win.pageYOffset || doc.scrollTop)  - (doc.clientTop || 0);
  };

  win.addEventListener('optimizedScroll', function(){
    // 28 - высота topline
    if (getWindowTop() >= 28) {
      header.classList.add('is-fixed');
    } else {
      header.classList.remove('is-fixed');
    }
  });
});