$(function(){
	$("#hide_cennost").click(function(){
		$('.cennost').toggle();
		return false;
	});
/*
	$("#ch_yurid select").change(function(){
		var yur = $('#ch_yurid option:selected').val();
		if(yur == 1){
			$('.blk_4,.blk_5,.blk_6,.blk_7').show();
			$(".blk_9,.blk_10").hide();
			$("#main_blank").attr({'src':'a_images/payment_blank.png'});
			var url = '/administrator/js/a_zakaz_req.php?action=changeUrlico&id=' + oid + '&urlico=0';
			$.get(url , function(data){
			});
			
		}else if(yur == 2){
			$('.blk_4,.blk_5,.blk_6,.blk_7').hide();
			$(".blk_9,.blk_10").show();
			$("#main_blank").attr({'src':'a_images/payment_blank_urlico.png'});
			var url = '/administrator/js/a_zakaz_req.php?action=changeUrlico&id=' + oid + '&urlico=1';
			$.get(url , function(data){
			});
		}
	});
	
	$("#sms_dostavka_send").live('click',function(){
		
		$('#blank_moscow').dialog('destroy');
		MoscowSendSms();
		window.print();
		
		return false;
	});*/
	
});

function ShowMoscowDelivery(){
	if($('#blank_moscow').length != 0){
		$('#blank_moscow').html(' ');
	}else{
		$('<div class="" id="blank_moscow"> </div>').appendTo('body');
	}
	$('#blank_moscow').
	html('<form>Доставка будет произведена<br><input id="sms_dostavka_day" type="text"><select id="sms_dostavka_month"><option value=""></option>'
			+'<option value="01">января</option>'
			+'<option value="02">февраля</option>'
			+'<option value="03">марта</option>'
			+'<option value="04">апреля</option>'
			+'<option value="05">мая</option>'
			+'<option value="06">июня</option>'
			+'<option value="07">июля</option>'
			+'<option value="08">августа</option>'
			+'<option value="09">сентября</option>'
			+'<option value="10">октября</option>'
			+'<option value="11">ноября</option>'
			+'<option value="12">декабря</option></select><br>c<input id="sms_dostavka_from" type="text" value="12">до<input id="sms_dostavka_to" type="text" value="18"><br><button id="sms_dostavka_send">Отправить</button></form>').
		dialog({
			title:'Московская доставка',
			width:600,
			close:function(){
				$(this).dialog('destroy');
			}
		});
	return false;
}

/*function MoscowSendSms(){
	var url = '/administrator/a_zakaz_req.php?action=sendMoscowDeliveryTime&id=' + oid 
	+ '&sms_dostavka_day=' + $("#sms_dostavka_day").val() 
	+ '&sms_dostavka_month=' + $("#sms_dostavka_month").val()
	+ '&sms_dostavka_from=' + $("#sms_dostavka_from").val()
	+ '&sms_dostavka_to=' + $("#sms_dostavka_to").val();

	//alert(url);
	$.get(url,function(data){
		return true;
	});
}

function Printed(id) {	
	$.post("reports/addOrderHistoryPrinted", {"orders_id":encodeURIComponent(id)},function(data){
		url = window.opener.document.location.href ;
	    	window.opener.document.location.href = url;
	});
	return false;
}*/
