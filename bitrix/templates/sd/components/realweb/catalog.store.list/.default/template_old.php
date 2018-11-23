<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<style>
.adm_shops{display:table;text-align:center;}
.adm_shops a{display:table-cell;padding:7px 20px;background:#fff;font-size:15px;white-space:nowrap;color:#111;}
.adm_shops a.now_active,.adm_shops a:hover{background: #ddd;}
.adm_shops .now_active a{background:#E40E0E;color:#fff;cursor:default;border:2px solid #3C3C3C;}
.adm_shops .noactive a{border:2px solid #ccc;color:#999;cursor:default;}
.adm_shops .active a{background:#E40E0E;color:#fff;}
.sort{list-style:none none;}
.lm_order_list{width:90%;margin:25px auto;border-spacing:0;}
.lm_order_list td{padding:10px 20px;}
.lm_order_list tr td {
    border-bottom: 1px solid #999;
    border-top: 1px solid #fff;
    vertical-align: middle;
}
td.lm_prodimg_wr img {
    max-width: 40px;
    max-height: 40px;
}
.lm_prod_name{margin:0 0 5px;font-size:15px;}
.lm_attr_list{margin: 0 0 5px;font-size: 13px;padding: 0 0 0 16px;}
.lm_comment{height:100%;width:100%;background:transparent;border:1px solid rgba(0, 0, 0, 0.09);}
.lm_comment:focus{background:#fff;border:1px solid rgba(0, 0, 0, 0.20);outline:none;}
.ls_action_span1,.ls_action_span2,.ls_action_span3{display:inline-block;margin:4px 10px;width:64px;height:64px;color:#fff;font-size:14px;}
.ls_action{cursor:pointer;margin:5px 10px;color:transparent;width:60px;height:60px;border:none;outline:0px;}
.ls_action_span1,.ls_action_1{background:url('<?=SITE_TEMPLATE_PATH?>/images/icon_have_big.png') no-repeat;}
.ls_action_span2,.ls_action_2{background:url('<?=SITE_TEMPLATE_PATH?>/images/icon_donthave_big.png') no-repeat;}
.ls_action_span3,.ls_action_3{background:#DF1BEA;border:1px solid #9A09A2;}
.lm_prod_price{margin:0;text-align:right;float:right;}
.lm_prod_date{color:#999;margin:0 0 5px;}
.lm_prodimg_wr{padding:10px 5px;}
.lm_order_list td.lm_status_wr{padding:10px;white-space:nowrap;}
.lm_prod_moscow{color:red;text-transform:uppercase;font-size:18px;margin:10px auto;}
.shop_id_trigger {
cursor: pointer;
}
.white-bg {
background-color: #fff;
display: block;
padding: 20px 15px;
}
input.prin {
padding: 10px 20px;
margin-bottom: 20px;
}
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
    margin:  auto;
    display:  block;
    margin-top: 40px;
    position: relative;
}
input.btn.bnt-log {
    float: right;
    margin-top: 20px;
    margin-bottom: 20px;
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
/*Табы*/
.tabs-log {
    display: none;
}
.tabs-log.active {
    display: block;
}
.tabs-log-a {
    display:  block;
    width: 100%;
    margin-bottom: 20px;
}
.tabs-log-a ul {
    list-style: none;
    padding: 0;
}
.tabs-log-a ul li {
    display:  inline-block;
    padding: 20px;
    cursor: pointer;
}
.tabs-log-a ul li.active {
    background: grey !important;
    color: white !important;
}
.tabs-log-a ul li:hover {
    background: whitesmoke;
    color: black;
}
h2.h2-Z {
    font-size: 28px;
    text-align: center;
}
</style>
<script>
$('.shop_id_trigger').click(function (){
var a = $(this).attr('id');
$('.shop_id_trigger').removeClass('now_active');
$(this).addClass('now_active');
$('.lm_order_list').find('.shop_product_row').css('display', 'none');
$('.lm_order_list').find('.shop_product_row.'+a).css('display', 'table-row');
});
$('.open_popupT').click(function () {
  $('.modal-track').css('display', 'block');
  var a = $(this).attr('data-id');
  $('#id-track').val(a);  
});
$('.open_popupOP').click(function () {
  $('.modal-op').css('display', 'block');
  var a = $(this).attr('data-id');
  $('#id-OP').val(a);  
});
$('.open_popupOT').click(function () {
  $('.modal-ot').css('display', 'block');
  var a = $(this).attr('data-id');
  $('#id-OT').val(a);  
});
$('.backs, .body-modal .close').click(function () {
  $(this).parents('.modal-log').css('display', 'none');  
});
$('.tabs-log-a ul li').click(function () {
    var a = $(this).attr('data-tab');
    $('.tabs-log').removeClass('active');
    $('.'+a).addClass('active');
    $('.tabs-log-a ul li').removeClass('active');
    $(this).addClass('active');
});
$('.ss').click(function () {
    var a = $(this).attr('data-zzz');
    $('.new_shop_product_row').css('display','none');
    $(a+', .new_lm_order_list').css('display','');
    $('.h2-Z').css('display','block');
    $('.h2-Z>span').html($(this).attr('data-id'));
    var target_top = $('.h2-Z').offset().top;
    $('html, body').animate({
    scrollTop: target_top - 20
    }, 'slow');
});
   	$(".formOT").submit(function(){
		var form = $(this);
		var error = false;
		if (!error) {
			var data = form.serialize();
			$.ajax({
			   type: 'POST',
			   dataType: 'json',
               url: '/logistic/',
			   data: data,
		       beforeSend: function(data) {
		          form.find('.bnt-log').val('Идет отправка...');
		          },
		       success: function(data){
		         },
		       error: function (xhr, ajaxOptions, thrownError) {
		         },
		       complete: function(data) {
                  var num = form.find('#id-OT').val();
                  $('.del-'+num).remove();
                  $('.h2-Z, .new_lm_order_list').css('display','none');
                  $('.modal-log').css('display', 'none');
                  var col=$('.del').length;
                  form.find('.bnt-log').val('Применить');
                  if (col<1){
                    $('.del-full').css('display','none');
                  };
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
               url: '/logistic/',
			   data: data,
		       beforeSend: function(data) {
		          form.find('.bnt-log').val('Идет отправка...');
		          },
		       success: function(data){
		         },
		       error: function (xhr, ajaxOptions, thrownError) {
		         },
		       complete: function(data) {
                  var num = form.find('#id-OP').val();
                  $('.del-'+num).remove();
                  $('.h2-Z, .new_lm_order_list').css('display','none');
                  $('.modal-log').css('display', 'none');
                  var col=$('.del').length;
                  form.find('.bnt-log').val('Применить');
                  if (col<1){
                    $('.del-full').css('display','none');
                  };
		         }  
			     });
		}
		return false;
	});
    $('.ls_action').click(function () {
        $(this).addClass('active');
    });
               	$('.frms').submit(function(){
		var form = $(this);
		var error = false;
		if (!error) {
			var data = form.serialize()+'&Q_NUM='+form.find('.active').val();
            console.log(data);
			$.ajax({
			   type: 'POST',
			   dataType: 'json',
               url: '/logistic/',
			   data: data,
		       beforeSend: function(data) {
		          },
		       success: function(data){
		         },
		       error: function (xhr, ajaxOptions, thrownError) {
		         },
		       complete: function(data) {
form.find('.ls_action').css({'background': 'transparent'}); 
form.find('.ls_action.active').css({'color': 'black'}); 
console.log(form.find('.who').val());
console.log(form.find('.active').val());
if (form.find('.who').val()=='M'&&form.find('.active').val()=='Y') {
form.parent().parent().css({'background': 'rgb(179, 255, 214)'});    
} else if (form.find('.who').val()=='A'&&form.find('.active').val()=='Y') {
form.parent().parent().css({'background': 'rgb(7, 220, 105)'});    
} else if (form.find('.who').val()=='M'&&form.find('.active').val()=='N') {
form.parent().parent().css({'background': 'rgb(255, 110, 110)'});    
} else if (form.find('.who').val()=='A'&&form.find('.active').val()=='N') {
form.parent().parent().css({'background': 'rgb(255, 110, 110)'});    
};
			     }
		})
	};
    return false;
    });
    
        $("#formComment").submit(function() {
        var form = $(this);
        var error = false;
        if (!error) {
            var data = form.serialize();
            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: data,
                async: false,
                beforeSend: function(data) {
                ;
                },
                success: function(data) {
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    form.parent().addClass('ok');
                    form.html('Что-то пошло не так!');
                },
                complete: function(data) {
                    
                    if (data.responseJSON.errForm=='OK'){
                    form.parent().addClass('ok');
                    form.css('display','none');
                    $('.OKcomment').html('Спасибо за комментарий. Совсем скоро он появится на сайте');
                    form.find('textarea').val('');
                    } else {
                    form.parent().addClass('ok');
                    form.css('display','none');
                    $('.OKcomment').html('Что-то пошло не так!');
                    form.find('textarea').val('');
                    };
                }
            });
        }
        return false;
    });    
    
    
    
</script>
<!-- Модалка изменения трек номера -->
<div class="modal-log modal-track">
<div class="backs"></div>
<div class="body-modal">
<span class="close">x</span>
<form method="POST">
<div class="form-group"><input type="text" name="track" class="in form-control" placeholder="введите номер отправления"></div>
<input type="hidden" name="id-track" id="id-track">
<div class="form-group"><input type="submit" class="btn bnt-log btn-success" value="Применить"></div>
</form>
</div>
</div>
<!-- END изменения трек номера -->
<!-- Модалка - Оплачен -->
<div class="modal-log modal-op">
<div class="backs"></div>
<div class="body-modal">
<span class="close">x</span>
<form class="formOP" method="POST">
<div class="form-group"><textarea name="commentOP" class="in form-control" placeholder="Комментарий"></textarea></div>
<input type="hidden" name="id-OP" id="id-OP">
<div class="form-group"><input type="submit" class="btn bnt-log btn-success" value="Применить"></div>
</form>
</div>
</div>
<!-- END Модалка - Оплачен -->
<!-- Модалка - Отмена -->
<div class="modal-log modal-ot">
<div class="backs"></div>
<div class="body-modal">
<span class="close">x</span>
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
<div class="form-group"><textarea name="commentOT" class="in form-control" placeholder="Комментарий" required=""></textarea></div>
<input type="hidden" name="id-OT" id="id-OT">
<div class="form-group"><input type="submit" class="btn bnt-log btn-success" value="Применить"></div>
</form>
</div>
</div>
<!-- Получаем поля текущего пользователя -->
<? $rsUser = CUser::GetByID($USER->GetParam('USER_ID')); $arUser = $rsUser->Fetch(); ?>
<?$arGroups = CUser::GetUserGroup($USER->GetParam('USER_ID'));?>
<?
if(in_array(6,$arGroups)){
    $ADM = true;  
}
?>
<!-- Не выводим блок с табами и списком заказов если текущий пользователь администратор -->
<? if (!$USER->IsAdmin()&&$arUser['UF_DOSTUP']!=0):?>
<div class="tabs-log-a">
<ul>
<li data-tab="position" class="active">Позиции</li>
<? if (count($arResult['ITEMS-M'][$arUser['UF_DOSTUP']])>0)  :?>
<li data-tab="orders">Заказы</li>
<? endif ?>
</ul>
</div>
<? if (count($arResult['ITEMS-M'][$arUser['UF_DOSTUP']])>0)  :?>
<div class="orders tabs-log">
<? $sT=htmlspecialchars($_GET['sortT']); ?>
<? if (isset($sT)){
    $sT=explode(',',$sT);
    if ($sT[1]=='asc'){
      $sT='desc';  
    } else {
      $sT='asc';  
    };
} else {
  $sT='asc';  
};
?>
<table class="lm_order_list del-full">
<thead>
            <tr style="background-color: rgb(244, 244, 248);">
              <td class="right" style="width: 40px;"><a href="/logistic/?sortT=ID,<? echo $sT;?>">ID</a>
                </td>
                <td class="right">
                  <p>Действие</p>
                </td>
              <td class="left">                <a href="/logistic/?sortT=USER_NAME,<? echo $sT;?>">Имя покупателя</a>
                </td>
              <td class="left">                <a href="/logistic/?sortT=STATUS_ID,<? echo $sT;?>">Статус</a>
                </td>
              <td class="left">                <a href="/logistic/?sortT=DELIVERY_ID,<? echo $sT;?>">Способ доставки</a>
                </td>
              <td class="right">                <a href="/logistic/?sortT=PRICE,<? echo $sT;?>">Итого</a>
                </td>
              <td class="left">                <a href="/logistic/?sortT=DATE_UPDATE,<? echo $sT;?>">Дата изменения</a>
                </td>
                              <td class="left">
                </td>
            </tr>
          </thead>
          <tbody>
          <? foreach ($arResult['ITEMS-M'][$arUser['UF_DOSTUP']] as $arone):?>
          <tr class="del del-<?=$arone['ID']?>" style="background-color: rgb(244, 244, 248);">
              <td class="right"><?=$arone['ACCOUNT_NUMBER']?></td>
              <td class="right">
                        <?  /*        <!--<a data-id="<?=$arone['ID']?>"><img src="/images/send.png"></a>--> */?>
                  <a data-id="<?=$arone['ID']?>" class="open_popupOT" style="cursor: pointer;"><img src="/images/cancel.png"></a>
                  <a data-id="<?=$arone['ID']?>" class="open_popupOP" style="cursor: pointer;"><img src="/images/coins.png"></a>
                              </td>
              <td class="left"><?=$arone['FIO']?><br /> <?=$arone['PHONE']?></td>
              <? if ($arone['STATUS']=='F'){
                $arone['STATUS']='Отправлен';
              };?>
              <td class="left "><?=$arone['STATUS']?></td>
              <td class="right">
              <?=$arone["TRACK"]?><br />
              <?=$arone["DELIVERY"]?><br /><br />
              <? /*
            <!--<span style="border: 1px solid #ccc;padding: 4px 5px;font-weight: bold;" id="mail_number">
            <a data-id="<?=$arone['ID']?>" style="cursor: pointer;" class="open_popupT"><? if ($arone["TRACK"]!=''){ echo 'Изменить номер';} else { echo 'Добавить номер';}?></a></span>-->
       			  */?>
                     </td>
              <td class="right"><?=$arone["PRICE"]?></td>
              <td class="left"><?=$arone["DATE_UPDATE"]?></td>
              <td class="left">
              <input class="ss" data-id="<?=$arone['ID']?>" data-zzz=".rows-<?=$arone['ID']?>" type="submit" value="Состав заказа">
              </td>
            </tr>
            <? endforeach ?>
          </tbody>
          </table>
          <br />
          <br />
          <? if (count($arResult['Z-ITEM'])>0):?>
          <?$Z_Z=htmlspecialchars($_POST['ORDER-S']);?>
          <h2 style="display: none;" class="h2-Z">Состав заказа №<span></span></h2>
          <table style="display: none;" class="lm_order_list new_lm_order_list">
          <thead>
<tr>
<td>Фото</td>
<td>Название</td>
<td>Артикул</td>
<td>Цена</td>
<td>Размер</td>
<td>К-во</td>
</tr>
</thead>
<? foreach ($arResult['Z-ITEM'] as $z_item):?>
<tr style="display: none;" class="shop_product_row new_shop_product_row rows-<?=$z_item['ID']?>">
<td class="lm_prodimg_wr"><img src="<?=$z_item['IMG']['src']?>" alt=""></td>
<td>
<p class="lm_prod_name"><?=$z_item["NAME"]?></p>
</td>
<td><strong title="Артикул"><?=$z_item["ARTICLE"]?></strong></td>
<td><p><strong><?=round($z_item["PRICE"], 2);?> руб.</strong></p></td>
<td><strong><?=$z_item["SIZE"]?></strong></td>
<td>
<strong><?=$z_item["QUANTITY"]?></strong>
</td>
</tr>
<? endforeach; ?>
</table>
<? endif; ?>
          </div>
<? endif; ?>
<? endif; ?>
<!-- END - блок с заказами и табами -->
<!-- Список позиций логистического модуля -->
<div class="position tabs-log active">
<div class="okMoved"></div>
<?=$arResult['XML']?>
<? if (!$USER->IsAdmin()&&$arUser['UF_DOSTUP']!=0):?>
<form class="moved" method="POST">
<input type="hidden" value="<?=$arUser['UF_DOSTUP']?>" name="STORE_ID">
<input class="prin" type="submit" value="Переместить">
</form>
<? endif; ?>
<div class="adm_shops">
<?foreach($arResult["STORES"] as $i=>$arItem){?> 
<? global $USER;
if ($USER->IsAdmin()||$arUser['UF_DOSTUP']==0) {?>
<a id="shop_id<?=$arItem['ID']?>" class="shop_id_trigger <? if ($arItem['XML_ID']==11) echo 'now_active' ?>"><?=$arItem["LABEL"]?></a>    
<?} else {
if ($arItem['ID']==$arUser['UF_DOSTUP']) {?>  
<a id="shop_id<?=$arItem['ID']?>" class="shop_id_trigger now_active"><?=$arItem["LABEL"]?></a>
<? }
};
?>
<?}?>
</div>
<?
if ($_GET['sort']){
  $sort = explode('.',$_GET['sort']);
  if ($sort[1]=='asc'){
  $sort[1]='desc';
  } else {
  $sort[1]='asc';  
  };
} else {
 $sort[1]='asc';   
};
?>
<ul class="sort">
<li><strong>Сортировка:</strong></li>
<li><a href="?sort=article.<?=$sort[1]?>">по актикулу</a> /</li>
<li><a href="?sort=date.<?=$sort[1]?>">по дате</a> /</li>
<li><a href="?sort=price.<?=$sort[1]?>">по цене</a></li>
</ul>
<table class="lm_order_list">
<thead>
<tr>
<td>Фото</td>
<td>Инфо</td>
<td>Размер</td>
<td>К-во</td>
<td class="lm_status_wr"></td>
<td>Комментарий</td>
</tr>
</thead>
<tbody>
<?  foreach($arResult['ITEMS'] as $i=>$it){ 
$i++;
//Вывод цвета и статуса ответа (менеджера|администратора)
if ($it['ADM_OTV']=='Y') {
$STYLE_MAN = 'background: rgb(7, 220, 105);';   
} else if ($it['ADM_OTV']=='N') {
$STYLE_MAN = 'background: rgb(255, 110, 110);'; 
$OT_MAN = 1; 
} else if ($it['MAN_OTV']=='Y'){
$STYLE_MAN = 'background: rgb(179, 255, 214);';
$OT_MAN = 1;  
} else if ($it['MAN_OTV']=='N') {
$STYLE_MAN = 'background: rgb(255, 110, 110);';
$OT_MAN = 1;   
} else {
$STYLE_MAN = null;
$OT_MAN = 0;   
};
//Вывод цвета и статуса ответа (менеджера|администратора) при совпадении пункта самовывоза
if ($it['REAL_STORE'] == $it["STORE_ID"]&&$it['ADM_OTV']!='N'&&$it['MAN_OTV']!='N'){
$STYLE_MAN = 'background: rgb(246, 237, 117);'; 
if (isset($it['MAN_OTV'])){
$OT_MAN = 1; 
} else if (isset($it['ADM_OTV'])){
$OT_MAN = 1; 
} else {
$OT_MAN = 0; 
};
};
//Отображаем все для Админа
if ($USER->IsAdmin()||$arUser['UF_DOSTUP']==0) { 
$order_date = ConvertDateTime($it['ORDER_DATE'], 'dd/mm/Y HH:MI');
?>
<tr data-id="<?=$it['ORDER_ID'] ?>" class="shop_product_row shop_id<?=$it["STORE_ID"]; ?>" style="<?=$STYLE_MAN?> <? if ($it["STORE_ID"]!=8) echo 'display:none;' ?>">
<td class="lm_prodimg_wr"><img src="<?=$it['PICTURE']?>" alt="" /></td>
<td>
<? if($it['shipping_city'] == "Москва"){?>
<p class="lm_prod_moscow">Москва</p>
<? } ?>
<p class="lm_prod_date"><?=$order_date?> (Заказ <a target="_blank"<?if($ADM){?> href="/bitrix/admin/sale_order_edit.php?ID=<?=$it['ORDER_ID']?>&lang=ru&filter=Y&set_filter=Y"<?}?> style="color:inherit;">№<?=$it['ACCOUNT_NUMBER']?></a>)</p>
<p class="lm_prod_price"><strong><?=round((int)$it['PRICE']*(1-$it['DISCOUNT']/100),-1);?> руб.</strong></p>
<p class="lm_prod_name"><strong title="Артикул"><?=$it['ARTNUMBER']; ?></strong> <?=htmlspecialcharsBack($it['NAME']) .  '    '?></p>
</td>
<td><strong><?=$it['SIZE']?></strong></td>
<td>
<? if($it['QUANTITY'] == '2'){?>
<span style="color:red;font-size:14px"><strong><?=$it['QUANTITY']; ?></strong></span>
<? } else { ?>
<strong><?=$it['QUANTITY']?></strong>
<? } ?>
</td>
<td class="lm_status_wr">
<form action="<?$_SERVER['REQUEST_URI']?>" id="as<?=$i?>" class="frms" method="POST">
<? if ($it['REAL_STORE'] == $it["STORE_ID"]){ ?>  
<input type="hidden" name="SV" value="86">  
<? } else { ?>
<!-- C какого склада перемешаем -->
<input type="hidden" name="SKLA_O" value="<?=$it["STORE_ID"]?>">
<!-- В какой склад перемешаем -->
<input type="hidden" name="SKLA_K" value="<?=$it['REAL_STORE']?>">  
<? } ?>
<input type="hidden" name="WHO" class="who" value="A">
<input type="hidden" name="ID_LINE" value="<?=$it['ID_LINE']?>">
<input type="hidden" name="ID" value="<?=$it['ID']?>">
<input type="hidden" name="ORDER" value="<?=$it['ORDER_ID']?>">
<input type="hidden" name="SIZE" value="<?=$it['ID_SIZE']?>">
<input type="hidden" name="ADM_NAME" value="<?=$USER->GetFullName()?>">
<button class="ls_action ls_action_1" name="Q_NUM" value="Y">Отправили!</button>
<button class="ls_action ls_action_2" name="Q_NUM" value="N">Нет в наличии</button>
</form>
</td>
<td><textarea form="as<?=$i?>" name="COMMENTS" class="lm_comment" placeholder="Комментарий"><?=$it['COMMENTS']?></textarea></td>
</tr>
<?};
//Отображаем по менеджеру
if ($it["STORE_ID"]==$arUser['UF_DOSTUP']&&!$USER->IsAdmin()) {
$order_date = ConvertDateTime($it['ORDER_DATE'], 'dd/mm/Y HH:MI');
?>
<tr data-id="<?=$it['ORDER_ID'] ?>" class="shop_product_row shop_id<?=$it["STORE_ID"]; ?>" style="<?=$STYLE_MAN?>">
<td class="lm_prodimg_wr"><img src="<?=$it['PICTURE']?>" alt="" /></td>
<td>
<? if($it['shipping_city'] == "Москва") { ?>
<p class="lm_prod_moscow">Москва</p>
<? } ?>
<p class="lm_prod_date"><?=$order_date?> (Заказ <a style="color:inherit;">№<?=$it['ACCOUNT_NUMBER']?></a>)</p>
<p class="lm_prod_price"><strong><?=round((int)$it['PRICE']*(1-$it['DISCOUNT']/100),-1);?> руб.</strong></p>
<p class="lm_prod_name"><strong title="Артикул"><?=$it['ARTNUMBER']; ?></strong> <?=htmlspecialcharsBack($it['NAME']) .  '    '  . $for_pick_up[73593]; ?></p>
</td>
<td><strong><?=$it['SIZE']?></strong></td>
<td>
<? if($it['QUANTITY'] == '2') { ?>
<span style="color:red;font-size:14px"><strong><?=$it['QUANTITY']; ?></strong></span>
<? } else { ?>
<strong><?=$it['QUANTITY']?></strong>
<? } ?>
</td>
<td class="lm_status_wr">
<? //if ($OT_MAN==0) { ?>
<form method="POST" class="frms" id="as<?=$i?>"> 
<? if ($it['REAL_STORE'] == $it["STORE_ID"]){ ?>  
<input type="hidden" name="SV" value="86">  
<? } ?>
<input type="hidden" name="WHO" class="who" value="M">
<input type="hidden" name="ID_LINE" value="<?=$it['ID_LINE']?>">
<input type="hidden" name="ID" value="<?=$it['ID']?>">
<input type="hidden" name="ORDER" value="<?=$it['ORDER_ID']?>">
<input type="hidden" name="SIZE" value="<?=$it['ID_SIZE']?>">
<input type="hidden" name="MAN_NAME" value="<?=$arUser['NAME'].' '.$arUser['LAST_NAME']?>">
<input type="hidden" name="SKLAD" value="<?=$it["STORE_ID"]?>">
<button class="ls_action ls_action_1" name="Q_NUM" value="Y">Отправили!</button>
<button class="ls_action ls_action_2" name="Q_NUM" value="N">Нет в наличии!</button>
</form>
</td>
<td><textarea form="as<?=$i?>" name="COMMENTS" class="lm_comment" placeholder="Комментарий"></textarea></td>
</tr>
<?
};
}; 
?>
</tbody>
</table>
</div>