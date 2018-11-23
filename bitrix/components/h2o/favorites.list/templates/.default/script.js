function favorites_list(){
   /* При нажатии на элемент с классом delete_favorites делаем ajax запрос, чтобы удалить элемент, переданный в атрибуте id */ 
	$(document).on('click','.checkout_removefromcart', function(e){
		e.preventDefault();
		var link = '?AJAX_CALL_FAVORITES_LIST=Y';
		var postArray = {
			'DELETE_FAVOR': 'Y',
			'ID': $(this).data('id')
		};
		$.ajax(link, {
			type: "post",
			dataType: "html",
			data: postArray,
			success: function(data){
				var obj = $("<div />").html(data);
				$(".wishlist-info").html(obj.find(".wishlist-info").html());
				if(typeof updateFavoritesLine == 'function'){
					updateFavoritesLine();
				}
			}		
		});
	});                  
}
/* Проверка композитности */
if (window.frameCacheVars !== undefined){
        BX.addCustomEvent("onFrameDataReceived" , function(json) {
            favorites_list();
        });
} else {
        $(function() {
            favorites_list();
        });
}
$(function(){
	function addCartFavorite(id,e){
		e.preventDefault();
		$.ajax({
			type: "post",
	        	dataType: "html",
			url: '/bitrix/components/h2o/favorites.list/templates/.default/ajax.php',
		        data: $('#row'+id+' #frm_add').serialize(),
        		success: function(data){
				$.ajax({
                			type: "get",
				        dataType: "html",
					url: "/mini.php",        			
                			success: function(data){
                        			$("#topcart").html(data);			        
	                      		}
	        	       });
	        	}
	  });
	  return false;
	}

	$('select[name="option[34]"]').styler();
	$('select[name="store"]').styler();

        $('select[name="option[34]"]').on('change',function(){
          var tr = $(this).parent().parent().parent().attr('id');
          $('#'+tr+' input[name="id"]').val($(this).val());
	  $('#'+tr+' .option_errors').html('');
          return false;
        });

	$('.checkout_addtocart').on('click',function(e){
		var id = $(this).data('id');
		if($('#row'+id+' input[name="id"]').val() == ''){
        		if($('#row'+id+' select[name="option[34]"]').children().length == 1){          
        			$('#row'+id+' select[name="option[34]"] :last').prop('selected',true);
			      	$('#row'+id+' input[name="id"]').val($('#row'+id+' select[name="option[34]"]').val());	
				addCartFavorite(id,e);
			}else{
				$('#row'+id+' .option_errors').html('Укажите размер');
				return false;
			}
	        }else{
        		addCartFavorite(id,e);
	        }
		return false;
	});
});
