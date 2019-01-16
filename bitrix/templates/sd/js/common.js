$(document).ready(function () {
   // $('.header_cat_children').columnize({columns: 6});
    $('<a href="#" class="closeBox" />').click(function(){
        $(this).parent().slideUp(100);
        return false;
    }).appendTo('.header-categories .header_cat_children');
    var timerId;
    $('.header-categories > ul > li').hover(function(){
                clearTimeout(timerId);
                if (!$(this).hasClass("activeMenu")){
                    if ($(".activeMenu").length > 0) {
                        $(".activeMenu").removeClass("activeMenu").children('.header_cat_children').hide();
                        $(this).children('.header_cat_children').css('top', function () {
                            return $('header').outerHeight();
                        }).show();
                    } else {
                        $(this).children('.header_cat_children').css('top', function () {
                            return $('header').outerHeight();
                        }).slideDown(100);
                    }
                    $(this).addClass("activeMenu");
                }
            },
            function () {
                var that = $(this);
                timerId = setTimeout(function () {
                    $(that).children('.header_cat_children').slideUp(100, function(){$(that).removeClass("activeMenu")});
                }, 500, that);

            }
    );
    /* Search */
    $('.button-search').bind('click', function () {
        url = $('base').attr('href') + 'index.php?route=product/search';
        var search = $('input[name=\'search\']').attr('value');
        if (search) {
            url += '&search=' + encodeURIComponent(search);
        }
        location = url;
    });

    $('#header input[name=\'search\']').bind('keydown', function (e) {
        if (e.keyCode == 13) {
            url = $('base').attr('href') + 'index.php?route=product/search';
            var search = $('input[name=\'search\']').attr('value');
            if (search) {
                url += '&search=' + encodeURIComponent(search);
            }
            location = url;
        }
    });

    /* Ajax Cart */
    /*
    $('#cart > .heading a').live('click', function () {
        $('#cart').addClass('active');

        $('#cart').load('index.php?route=module/cart #cart > *');

        $('#cart').live('mouseleave', function () {
            $(this).removeClass('active');
        });
    });
    /*

    /* Mega Menu */
    $('#menu ul > li > a + div').each(function (index, element) {
        // IE6 & IE7 Fixes
        if ($.browser.msie && ($.browser.version == 7 || $.browser.version == 6)) {
            var category = $(element).find('a');
            var columns = $(element).find('ul').length;

            $(element).css('width', (columns * 143) + 'px');
            $(element).find('ul').css('float', 'left');
        }

        var menu = $('#menu').offset();
        var dropdown = $(this).parent().offset();

        i = (dropdown.left + $(this).outerWidth()) - (menu.left + $('#menu').outerWidth());

        if (i > 0) {
            $(this).css('margin-left', '-' + (i + 5) + 'px');
        }
    });

    // IE6 & IE7 Fixes
    if ($.browser.msie) {
        if ($.browser.version <= 6) {
            $('#column-left + #column-right + #content, #column-left + #content').css('margin-left', '195px');

            $('#column-right + #content').css('margin-right', '195px');

            $('.box-category ul li a.active + ul').css('display', 'block');
        }

        if ($.browser.version <= 7) {
            $('#menu > ul > li').bind('mouseover', function () {
                $(this).addClass('active');
            });

            $('#menu > ul > li').bind('mouseout', function () {
                $(this).removeClass('active');
            });
        }
    }

    $('.success img, .warning img, .attention img, .information img').live('click', function () {
        $(this).parent().fadeOut('slow', function () {
            $(this).remove();
        });
    });

     $('.totop').click(function () { // При клике по кнопке "Наверх" попадаем в эту функцию
      /* Плавная прокрутка наверх */
      $('body, html').animate({
        scrollTop: 0
      }, delay);
    });

    $(window).scroll(function () {if ($(this).scrollTop() > 50) {$('.totop').show();} else {$('.totop').hide();}});
    $('.totop').click(function () {$('body,html').animate({scrollTop: 0}, 400); return false;});
});


function getURLVar(key) {
    var value = [];

    var query = String(document.location).split('?');

    if (query[1]) {
        var part = query[1].split('&');

        for (i = 0; i < part.length; i++) {
            var data = part[i].split('=');

            if (data[0] && data[1]) {
                value[data[0]] = data[1];
            }
        }

        if (value[key]) {
            return value[key];
        } else {
            return '';
        }
    }
}

function addToCart(product_id, quantity) {
    quantity = typeof (quantity) != 'undefined' ? quantity : 1;

    $.ajax({
        url: 'index.php?route=checkout/cart/add',
        type: 'post',
        data: 'product_id=' + product_id + '&quantity=' + quantity,
        dataType: 'json',
        success: function (json) {
            $('.success, .warning, .attention, .information, .error').remove();

            if (json['redirect']) {
                location = json['redirect'];
            }

            if (json['success']) {
                $('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="/bitrix/templates/sd/images/close.png" alt="" class="close" /></div>');

                $('.success').fadeIn('slow');

                $('.header-cart').find('.cart-total').html(json['total']);

                $('html, body').animate({scrollTop: 0}, 'slow');
            }
        }
    });
}
function addToWishList(product_id) {
    $.ajax({
        url: 'index.php?route=account/wishlist/add',
        type: 'post',
        data: 'product_id=' + product_id,
        dataType: 'json',
        success: function (json) {
            $('.success, .warning, .attention, .information').remove();

            if (json['success']) {
                 $.growl({ title: "", message: json['success'], style: 'error'});
            }
        }
    });
    return false;
}

function addToCompare(product_id) {
    $.ajax({
        url: 'index.php?route=product/compare/add',
        type: 'post',
        data: 'product_id=' + product_id,
        dataType: 'json',
        success: function (json) {
            $('.success, .warning, .attention, .information').remove();

            if (json['success']) {
                $('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="/bitrix/templates/sd/images/close.png" alt="" class="close" /></div>');

                $('.success').fadeIn('slow');

                $('#compare-total').html(json['total']);

                $('html, body').animate({scrollTop: 0}, 'slow');
            }
        }
    });
}


$(".coup").submit(function(){
    var form = $(this);
    var error = false;
    if (!error) {
      var data = form.serialize();
      $.ajax({
         type: 'POST',
         dataType: 'json',
         url: $(this).attr('action'),
         data: data,
           beforeSend: function(data) {
                form.find('input[type="submit"]').attr('disabled', 'disabled');
              },
           success: function(data){
             },
           error: function (xhr, ajaxOptions, thrownError) {
             },
           complete: function(data) {
           window.location.reload();

           }});
           return false;
    }

  });

