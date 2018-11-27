<? if (stristr($_SERVER['REQUEST_URI'], '/bitrix/admin/sale_order.php')): ?>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>


<style>
/* Стилизация модалок */
.modal-log {
    position: fixed;
    width:  100%;
    left: 0;
    top:  0;
    height: 100%;
    z-index: 9999;
    display:none;
}

.modal-log .backs {
    background: rgba(14,14,14,0.6);
    width:  100%;
    height:  100%;
    overflow: hidden;
    position: absolute;
    z-index: 998;
}

a.pp {
    margin-bottom:  5px;
    display:  block;
    padding: 2px;
    background: transparent;
    border-radius:  200px;
    border: 2px solid transparent;
}

a.pp:hover {
    border-color: grey;
}
.body-modal {
    background: white;
    z-index:  9999;
    width: 30%;
    position:  relative;
    margin: auto;
    margin-top:  10%;
    height: auto;
}

.body-modal form {
    position:  relative;
    overflow: hidden;
}

.body-modal input, .body-modal textarea, .body-modal select {
    margin: auto;
    display: block;
    margin-top: 40px;
    position: relative;
    width: 100%;
    min-height: 34px;
    line-height: 31px;
    padding-left: 10px;
    box-shadow: none;
    text-shadow: none;
}
.body-modal > span {
    position: absolute;
    right: 12px;
    top: 5px;
    z-index: 1000;
    cursor: pointer;
    font-size: 18px;
    opacity: 0.8;
}
input.btn.bnt-log {
    float: right;
    margin-top: 20px;
    margin-bottom: 20px;
    cursor: pointer;
}

.body-modal .form-group {
    width:  90%;
    margin: auto;
}

.body-modal > span {
    position:  absolute;
    right: 12px;
    top: 5px;
    z-index: 1000;
}

</style>
<script>
function popupT (b) {
  $('.modal-track').css('display', 'block');
  var a = b.attr('data-id');
  $('#id-track').val(a);  
};

function popupOP (b) {
  $('.modal-op').css('display', 'block');
  var a = b.attr('data-id');
  $('#id-OP').val(a);  
};

function popupOT (b) {
  $('.modal-ot').css('display', 'block');
  var a = b.attr('data-id');
  $('#id-OT').val(a);  
};

function popupOK (b) {
  var a = b.attr('data-id');
  $('#id-OK').val(a); 
  $('.OK').submit(); 
};

function closes (b) {
  b.parents('.modal-log').css('display', 'none');  
};
$(document).ready(function () {
	$(".formTRACK").submit(function(){
		var form = $(this);
		var error = false;
		if (!error) {
			var data = form.serialize();
			$.ajax({
			   type: 'POST',
			   dataType: 'json',
               url: '/bitrix/admin/sale_order.php',
			   data: data,
		       beforeSend: function(data) {
		            
		          },
		       success: function(data){
		         
		         },
		       error: function (xhr, ajaxOptions, thrownError) {
		          
		         },
		       complete: function(data) {
		          form.find('.bnt-log').val('Номер отправления изменен');
                  var num = form.find('#id-track').val();
				  $('#status_order_'+num).html('Отправлен');
                  $('#status_order_'+num).parent().css({'background':'rgba(0,166,80,0.6)'});
                  var new_track = form.find('.in').val();
                  $('.zzz-'+num+' .num-z').html(new_track);
                  setTimeout(function () {$('.modal-log').css('display', 'none')},1000);
                   
		         }  
			     });
		}
		return false;
	});
    
   	$(".OK").submit(function(){
		var form = $(this);
		var error = false;
		if (!error) {
			var data = form.serialize();
			$.ajax({
			   type: 'POST',
			   dataType: 'json',
               url: '/bitrix/admin/sale_order.php',
			   data: data,
		       beforeSend: function(data) {
		            
		          },
		       success: function(data){
		         
		         },
		       error: function (xhr, ajaxOptions, thrownError) {
		          
		         },
		       complete: function(data) {
                  var num = form.find('#id-OK').val();
                  $('#status_order_'+num).html('Отправлен');
                  $('#status_order_'+num).parent().css({'background':'rgba(0,166,80,0.6)'});
		         }  
			     });
		}
		return false;
	}); 
    
       	$(".formOP").submit(function(){
		var form = $(this);
		var error = false;
		if (!error) {
			var data = form.serialize();
			$.ajax({
			   type: 'POST',
			   dataType: 'json',
               url: '/bitrix/admin/sale_order.php',
			   data: data,
		       beforeSend: function(data) {
		            
		          },
		       success: function(data){
		         
		         },
		       error: function (xhr, ajaxOptions, thrownError) {
		          
		         },
		       complete: function(data) {
                  var num = form.find('#id-OP').val();
                  $('#status_order_'+num).html('Оплачен');
                  $('#status_order_'+num).parent().css({'background':'rgba(237,0,140,0.6)'});
                  comm = form.find('.in').val();
                  $('.comments'+num).html(comm);
                  $('.modal-log').css('display', 'none');
		         }  
			     });
		}
		return false;
	});
    
   	$(".formOT").submit(function(){
		var form = $(this);
		var error = false;
		if (!error) {
			var data = form.serialize();
			$.ajax({
			   type: 'POST',
			   dataType: 'json',
               url: '/bitrix/admin/sale_order.php',
			   data: data,
		       beforeSend: function(data) {
		            
		          },
		       success: function(data){
		         
		         },
		       error: function (xhr, ajaxOptions, thrownError) {
		          
		         },
		       complete: function(data) {
                  var num = form.find('#id-OT').val();
                  a = form.find('.in').val();
                  var stat = $('[value='+a+']').html();
                  $('#status_order_'+num).html(stat);
                  $('#status_order_'+num).parent().css({'background':'rgba(121,0,0,0.6)'});
                  comm = form.find('textarea.in').val();
                  $('.comments'+num).html(comm);
                  $('.modal-log').css('display', 'none');
		         }  
			     });
		}
		return false;
	});
    
    });
</script>
<!-- Модалка изменения трек номера -->
<div class="modal-log modal-track">
<div class="backs" onclick="closes($(this))"></div>
<div class="body-modal">
<span class="close" onclick="closes($(this))">x</span>
<form class="formTRACK" method="POST">
<div class="form-group"><input type="text" name="track" class="in form-control" placeholder="введите номер отправления" required=""></div>
<input type="hidden" name="id-track" id="id-track">
<div class="form-group"><input type="submit" class="btn bnt-log btn-success" value="Применить"></div>
</form>
</div>
</div>
<!-- END изменения трек номера -->

<!-- Модалка - Оплачен -->
<div class="modal-log modal-op">
<div class="backs" onclick="closes($(this))"></div>
<div class="body-modal">
<span class="close" onclick="closes($(this))">x</span>
<form class="formOP" method="POST">
<div class="form-group"><textarea type="textarea" name="commentOP" class="in form-control" placeholder="Комментарий" required=""></textarea></div>
<input type="hidden" name="id-OP" id="id-OP">
<div class="form-group"><input type="submit" class="btn bnt-log btn-success" value="Применить"></div>
</form>
</div>
</div>
<!-- END Модалка - Оплачен -->
<!-- Модалка - Отмена -->
<div class="modal-log modal-ot">
<div class="backs" onclick="closes($(this))"></div>
<div class="body-modal">
<span class="close" onclick="closes($(this))">x</span>
<form class="formOT" method="POST">
<div class="form-group">
<select name="OT" class="in form-control" required="">
<option value="O">Отмена</option>
<option value="ON">Отмена - нет в наличии</option>
<option value="OD">Отмена - дублирующий заказ</option>
<option value="OU">Отмена - не удалось связаться</option>
<option value="OE">Отмена - купил другое</option>
<option value="OS">Отмена - истек срок</option>
<option value="OO">Отмена - отказ</option>
</select></div>
<div class="form-group"><textarea type="textarea" name="commentOT" class="in form-control" placeholder="Комментарий" required=""></textarea></div>
<input type="hidden" name="id-OT" id="id-OT">
<div class="form-group"><input type="submit" class="btn bnt-log btn-success" value="Применить"></div>
</form>
</div>
</div>
<div style="display:none">
<form method="POST" class="OK">
<input type="hidden" name="id-OK" id="id-OK">
</form>
</div>
<?
$id_track=htmlspecialchars($_POST['id-track']);
$track=htmlspecialchars($_POST['track']);

$OT=htmlspecialchars($_POST['OT']);
$id_OT=htmlspecialchars($_POST['id-OT']);
$commentOT=htmlspecialchars($_POST['commentOT']);

$commentOP=htmlspecialchars($_POST['commentOP']);
$id_OP=htmlspecialchars($_POST['id-OP']);

$id_OK=htmlspecialchars($_POST['id-OK']);

if (($id_track!=''&&$track!='')||($commentOT!=''&&$id_OT!='')||($commentOP!=''&&$id_OP!='')||$id_OK!=''){
	if ($id_track!=''){
		$prM = \Bitrix\Sale\Order::load($id_track);   
	} else if ($id_OT!='') {
		$prM = \Bitrix\Sale\Order::load($id_OT);    
	} else if ($id_OP!='') {
		$prM = \Bitrix\Sale\Order::load($id_OP);  
	} else if ($id_OK!='') {
		$prM = \Bitrix\Sale\Order::load($id_OK);    
	};
//Дата последнего изменения и Статус заказа
$comment = $prM->getfield("COMMENTS");

//Кнопка отмена
if ($commentOT!=''&&$id_OT!=''){
	//Общий комментарий
	$prM->setfield('COMMENTS', $comment.'\n'.$commentOT);
	//Изменение общего статуса заказа на выбранный
	$prM->setfield('STATUS_ID', $OT);
	$prM->save();
	exit();
};

if ($id_OK!=''){
	//Изменение общего статуса заказа на выбранный
	$prM->setfield('STATUS_ID', 'F');
	$prM->save();
	exit();
};
//END

if($id_OP){//Кнопка оплачено
	$paymentCollection = $prM->getPaymentCollection();
	foreach ($paymentCollection as $payment){	    
		//Комментарий в редактировании оплаты
		$payment->setfield('COMMENTS', $comment.'\n'.$commentOP);
		//Изменени статуса оплачен - в редактировании оплаты
		$payment->setfield('PAID', 'Y');
		//Изменение общего статуса заказа на оплаченно
		
		};
		//END
	$prM->setfield('COMMENTS', $comment.'\n'.$commentOP);	
	$prM->setfield('STATUS_ID', 'OP');
	$prM->save();
	exit();
}


if($id_track!=''){//номер
	$shipmentCollection = $prM->getShipmentCollection();    
	foreach($shipmentCollection as $shipment)
	{
		//Пропуск системных значений
		if ($shipment->isSystem())
		continue;
		
		//Изменение трек номера
		if ($track!=''&&$id_track!=''){
			$shipment->setfield('DELIVERY_DOC_NUM', $_POST['track']);
		};
		//END
		
	};
	$prM->setfield('STATUS_ID', 'F');
	$prM->save();
	exit();
};
}
?>