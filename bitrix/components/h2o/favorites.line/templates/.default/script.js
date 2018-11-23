function updateFavoritesLine(){
	var link = '?AJAX_CALL_FAVORITES_LINE=Y';
	$.ajax(link, {
		type: "post",
		dataType: "html",
		success: function(data){
			$(".header-wish").html(data);
		}		
	});
}