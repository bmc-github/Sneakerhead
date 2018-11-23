$(document).ready(function(){
  $("#header-login").on('click',function(e){
    $.fancybox.open({href: '/login/?popup=1&redir_url=' + encodeURIComponent(window.location.href), wrapCSS:'login-bg',type:'ajax'});
    e.preventDefault();
  });
  $("#header-register").on('click',function(e){
    $.fancybox.open({href: '/create-account/?popup=1&redir_url=' + encodeURIComponent(window.location.href) + '&register=yes', wrapCSS:'login-bg',type:'ajax'});
    e.preventDefault();
  });
  $(document.body).on("click", "a[href*='login']:not(#header-login)", function(e){
    $("#header-login").click();
    e.preventDefault();
  });  
  //$(".login-fancybox").fancybox();
  $(".fancybox").fancybox();
  $(".filterproshow-trigger").click(function(e){
    var t = $(this);
    var f = $(".filterpro-wrapper");
    if(f.length){
      e.preventDefault();
      if(f.css("display") == "none"){
        f.slideDown(500);
      }else{
        f.slideUp(500);
      }
    }
  });
  $(".lazy_load").fadeIn(300);
});
$(document.body).on("click", ".header_search_trigger", function(){
  var t = $(this);
  var form = t.parents("li").find(".header_search");
  form.show();
  form.find("input[name='search']").focus();
});
$(document.body).on("blur", ".header_search input[name='search']", function(){
  $(this).parents(".header_search").hide();
});

$('#search').focusin(function() {
  $('.header-categories').css({opacity: 1.0, visibility: "visible"}).animate({opacity: 0}, 200);
});
$('#search').blur( function() {
  $('.header-categories').css({opacity: 0.0, visibility: "visible"}).animate({opacity: 1.0}, 200);
});

var colors = new Array(
[27,27,27],
[105,143,210],
[73,183,238],
[11,247,198],
[10,93,215]);

var step = 0;
//color table indices for:
// current color left
// next color left
// current color right
// next color right
var colorIndices = [0,1,2,3];

//transition speed
var gradientSpeed = 0.002;

function updateGradient(){

  if ( $===undefined ) return;

  var c0_0 = colors[colorIndices[0]];
  var c0_1 = colors[colorIndices[1]];
  var c1_0 = colors[colorIndices[2]];
  var c1_1 = colors[colorIndices[3]];

  var istep = 1 - step;
  var r1 = Math.round(istep * c0_0[0] + step * c0_1[0]);
  var g1 = Math.round(istep * c0_0[1] + step * c0_1[1]);
  var b1 = Math.round(istep * c0_0[2] + step * c0_1[2]);
  var color1 = "rgb("+r1+","+g1+","+b1+")";
  
  var r2 = Math.round(istep * c1_0[0] + step * c1_1[0]);
  var g2 = Math.round(istep * c1_0[1] + step * c1_1[1]);
  var b2 = Math.round(istep * c1_0[2] + step * c1_1[2]);
  var color2 = "rgb("+r2+","+g2+","+b2+")";

  $('#gradient')
    .css({background: "-webkit-gradient(linear, left top, right top, from("+color1+"), to("+color2+"))"})
    .css({background: "-moz-linear-gradient(left, "+color1+" 0%, "+color2+" 100%)"});        
  step += gradientSpeed;
  if ( step >= 1 ){
    step %= 1;
    colorIndices[0] = colorIndices[1];
    colorIndices[2] = colorIndices[3];

    //pick two new target color indices
    //do not pick the same as the current one
    colorIndices[1] = ( colorIndices[1] + Math.floor( 1 + Math.random() * (colors.length - 1))) % colors.length;
    colorIndices[3] = ( colorIndices[3] + Math.floor( 1 + Math.random() * (colors.length - 1))) % colors.length;      
  }
}      
setInterval(updateGradient,10);

$('.totop').click(function(){
  $('body,html').animate({
    scrollTop: 0
  }, 600);
  return false;
});
$(window).scroll(function(){
  //var fh = $('#filterpro_box').height();
  if ($(this).scrollTop() > 100){
    $('.totop').fadeIn();
  } else {
    $('.totop').fadeOut();
  }
  if ($(this).scrollTop() > 100){    
    $('.totop').css("position","fixed"); // make it related
    $('.totop').css("bottom","50%"); // 60 px, height of #toTop
    $('.totop').css("display","block");
    $('.totop').css("right","20px");
  }      
});


$('.header-categories li a').each(function () {     
        var location = window.location.href; 
        var link = this.href;
        if(location == link) {
            $(this).removeAttr("href");
            $(this).addClass('currentMy');
        }
    });


    

var $el, $ps, $up, totalHeight;
$(".category-info .button").click(function(){
  totalHeight = 0
  $el = $(this);
  $p  = $el.parent();
  $up = $p.parent();
  $ps = $up.find("p");
  $uls = $up.find("h2, ul");

  $ps.each(function(){
    totalHeight += $(this).outerHeight(true);
  });
  $uls.each(function() {
    totalHeight += $(this).outerHeight();
  });
  totalHeight -= 84;
  $up
    .css({
      // Set height to prevent instant jumpdown when max height is removed
      "height": $up.height(),
      "max-height": 9999
    })
    .animate({
      "height": totalHeight
    });                  
  // fade out read-more
  $p.fadeOut();          
  // prevent jump-down
  return false;          
});

// Это код обновления мини корзины
function miniup(){
    
    
    
  if($('input[name="id"]').val() == ''){
    

    if($('.choose-size-wrap').children().length > 2){
      $('#button-cart').hide();
      $('.cart').find('.cart-error').show();
      $('.cart').find('.cart-success').hide();
      $(this).hide();
      return false;
    }else{
        
        $('input[name="id"]').val($('.sizes-chart-item').data('id'))
        
        
        
    }
    
    
  }
  $.ajax({
	type: "POST",
	//url: $("#frm_add").data('adr'),
    url: '/bitrix/templates/.default/ajax/ajax.php',
        data:$("#frm_add").serialize(),
        dataType: "html",
        success: function(outf){
            
		$.ajax({
                	type: "GET",
			url: "/mini.php",
        	        dataType: "html",
                	success: function(out){
                	   console.log(outf);
                        	$("#topcart").html(out);
			        $('.cart').find('.cart-success').show();
			        $('#button-cart').hide();
                      	}
               });
        }
  });
  return false;
}