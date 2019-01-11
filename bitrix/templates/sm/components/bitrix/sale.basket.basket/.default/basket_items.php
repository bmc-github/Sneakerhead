<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @var array $arUrls */
/** @var array $arHeaders */
use Bitrix\Sale\DiscountCouponsManager;

if (!empty($arResult["ERROR_MESSAGE"]))
	ShowError($arResult["ERROR_MESSAGE"]);

$bDelayColumn  = false;
$bDeleteColumn = false;
$bWeightColumn = false;
$bPropsColumn  = false;
$bPriceType    = false;

$retail_ids = array();
$addig = array();

if ($normalCount > 0):
?>
<?

	$basketF= CSaleBasket::GetList(
        array(
                "NAME" => "ASC",
                "ID" => "ASC"
            ),
        array(
                "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                "ORDER_ID" => "NULL"
            ),
        false,
        false,
        array("ID",
              "PRODUCT_ID"
              )
    );

$nomoscow = false;
	while($itemF = $basketF->Fetch()){
	$mxResult  = CCatalogSku::GetProductInfo($itemF["PRODUCT_ID"]);
	$addig[]= $mxResult['ID'];
$db_props = CIBlockElement::GetProperty(2, $mxResult['ID'], array("sort" => "asc"), Array("ID"=>"84"));
$v = $db_props->fetch();
		if($v['VALUE'] == '22730' || $v['VALUE'] == '22727'){
	$noMoscow = true;
}
	}


?>
	<? if ($arParams['ORDER_PAGE'] !== "Y"){ ?>
   <div id="coupons_block" class="content coupon-form">
<?if ($arParams["HIDE_COUPON"] != "Y"){?>
<?if(!$arResult['COUPON_LIST']):?>
      <form class="coupon-form__form" action="" method="post" enctype="multipart/form-data">
        <!-- <label class="coupon-form__label" for="coupon">Код купона:</label> -->
        <div class="coupon-form__input">
          <input class="coupon-form__input-control" type="text" id="coupon" name="coupon" value="" placeholder="Код купона" <?/*onchange="enterCoupon();"*/?> />
          <input type="hidden" name="next" value="coupon" />
        </div>
        <button type="submit" value="Применить" class="coupon-form__submit redbutton" onclick="enterCoupon();return false;">Применить</button>
</form>
<?endif?>
			<?if (!empty($arResult['COUPON_LIST'])){
					foreach ($arResult['COUPON_LIST'] as $oneCoupon){
						$couponClass = 'disabled';
						switch ($oneCoupon['STATUS']){
							case DiscountCouponsManager::STATUS_NOT_FOUND:
							case DiscountCouponsManager::STATUS_FREEZE:
								$couponClass = 'bad';
								break;
							case DiscountCouponsManager::STATUS_APPLYED:
								$couponClass = 'good';
								break;
						}
						?>
            <?if($couponClass!='bad'):?>
        <div class="bx_ordercart_coupon">
          <span class="<? echo $couponClass; ?>" data-coupon="<? echo htmlspecialcharsbx($oneCoupon['COUPON']); ?>"></span>
          <div class="bx_ordercart_coupon_notes">
          <?=GetMessage('COP')?> <?= htmlspecialcharsbx($oneCoupon['COUPON']); ?>
          <?
						if (isset($oneCoupon['CHECK_CODE_TEXT'])){
							echo (is_array($oneCoupon['CHECK_CODE_TEXT']) ? implode('<br>', $oneCoupon['CHECK_CODE_TEXT']) : $oneCoupon['CHECK_CODE_TEXT']);
						}
						?>
          </div>
                                            <form class="coup" method="POST">
                                  <input type="hidden" name="DelCop" value="<?=$oneCoupon["COUPON"]?>">
                                  <input type="submit" value="<?=GetMessage('DEL_COP')?>">
                                  </form>
        </div>
        <?else:?>
        <?\Bitrix\Sale\DiscountCouponsManager::delete($oneCoupon["COUPON"]);?>
        <div class="bx_ordercart_coupon">
          <input disabled readonly type="text" name="OLD_COUPON[]" value="<?=htmlspecialcharsbx($oneCoupon['COUPON']);?>" class="<? echo $couponClass; ?>">
          <span class="<? echo $couponClass; ?>" data-coupon="<? echo htmlspecialcharsbx($oneCoupon['COUPON']); ?>"></span>
          <div class="bx_ordercart_coupon_notes"><?
						if (isset($oneCoupon['CHECK_CODE_TEXT'])){
							echo (is_array($oneCoupon['CHECK_CODE_TEXT']) ? implode('<br>', $oneCoupon['CHECK_CODE_TEXT']) : $oneCoupon['CHECK_CODE_TEXT']);
						}
						?>
          </div>
        </div>
        <?endif?>
        <?
					}
					unset($couponClass, $oneCoupon);
				}?>

		<?}?>
    </div>
<form method="post" action="/checkout/" name="basket_form" id="basket_form" class="feedBackWrapper cart">

      <table id="basket_items" class="cart-info listItems">
		<thead>
				<tr>
					<?foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader){
						$arHeaders[] = $arHeader["id"];
						if (in_array($arHeader["id"], array("TYPE"))){
							$bPriceType = true;
							continue;
						}elseif ($arHeader["id"] == "PROPS"){
							$bPropsColumn = true;
							continue;
						}elseif ($arHeader["id"] == "DELAY"){
							$bDelayColumn = true;
							continue;
						}elseif ($arHeader["id"] == "DELETE"){
							$bDeleteColumn = true;
							continue;
						}elseif ($arHeader["id"] == "WEIGHT"){
							$bWeightColumn = true;
						}
						if ($arHeader["id"] == "NAME"){?>
							<td id="col_<?=$arHeader["id"];?>">
					      <?}elseif ($arHeader["id"] == "PRICE"){?>
							<td id="col_<?=$arHeader["id"];?>">
					      <?}else{?>
							<td id="col_<?=$arHeader["id"];?>">
					      <?}?>
							<?=$arHeader["name"]; ?>
							</td>
					<?}
                                          /*if ($bDeleteColumn || $bDelayColumn){?>
						<td class="custom"></td>
					<?}*/?>
				</tr>
			</thead>
			<tbody>
      <?$skipHeaders = array('PROPS', 'DELAY', 'DELETE', 'TYPE');
				foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):
					if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"):
					?>
        <tr id="<?=$arItem["ID"]?>" class="item" data-item-name="<?=$arItem["NAME"]?>" data-item-price="<?=$arItem["PRICE"]?>" data-item-currency="<?=$arItem["CURRENCY"]?>">
          <?foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):
	      if (in_array($arHeader["id"], $skipHeaders)) // some values are not shown in the columns in this template
		continue;
	      if ($arHeader["name"] == '')
		$arHeader["name"] = GetMessage("SALE_".$arHeader["id"]);
	      if ($arHeader["id"] == "NAME"):
	  ?>
          <td class="imgBox">
	    <?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
              <img src="<?=$arItem['PREVIEW_PICTURE_SRC']?>" alt="" style="width:80px" />
	    <?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
          </td>
	  <td class="des" colspan="3">
            <p class="cat"><a class="category_name" href="<?=$arItem['CATEGORY']['SECTION_PAGE_URL']?>"><?=$arItem['CATEGORY']['NAME']?></a></p>
            <p class="titleItem">
              <a class="manufacturer_name" href="<?=$arItem['BRAND']['DETAIL_PAGE_URL']?>"><?=$arItem['BRAND']['NAME']?></a>
              <?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a class="product_name" href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?><?=$arItem["NAME"]?><?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
            </p>
	    <div class="options option-select">
							<?if (is_array($arItem["SKU_DATA"]) && !empty($arItem["SKU_DATA"])):
										$propsMap = array();
										foreach ($arItem["PROPS"] as $propValue){
											if (empty($propValue) || !is_array($propValue))
												continue;
											$propsMap[$propValue['CODE']] = (isset($propValue['~VALUE']) ? $propValue['~VALUE'] : $propValue['VALUE']);
										}
										unset($propValue);

										foreach ($arItem["SKU_DATA"] as $propId => $arProp):
											$selectedIndex = 0;
											// if property contains images or values
											$isImgProperty = false;
											if (!empty($arProp["VALUES"]) && is_array($arProp["VALUES"])){
												$counter = 0;
												foreach ($arProp["VALUES"] as $id => $arVal){
													$counter++;
													if (isset($propsMap[$arProp['CODE']])){
														if ($propsMap[$arProp['CODE']] == $arVal['NAME'] || $propsMap[$arProp['CODE']] == $arVal['XML_ID'])
															$selectedIndex = $counter;
													}
													if (!empty($arVal["PICT"]) && is_array($arVal["PICT"])&& !empty($arVal["PICT"]['SRC'])){
														$isImgProperty = true;
													}
												}
												unset($counter);
											}
											$countValues = count($arProp["VALUES"]);
											$full = ($countValues > 5) ? "full" : "";

											$marginLeft = 0;
											if ($countValues > 5 && $selectedIndex > 5)
												$marginLeft = ((5 - $selectedIndex)*20).'%';

											if ($isImgProperty): // iblock element relation property
											else:
											?>
							<label>Размер<?//=htmlspecialcharsbx($arProp["NAME"])?>:</label>
							<select name="option[<?=$arItem['ID']?>]" class="select_onwhite">

																<?if (!empty($arProp["VALUES"])){
																	$counter = 0;
																	foreach ($arProp["VALUES"] as $valueId => $arSkuValue):
																		$counter++;
																		$selected = ($selectedIndex == $counter ? ' selected' : '');
								?>
                <option value="<?=$arSkuValue["ID"]?>"<?=$selected?>><?=htmlspecialcharsbx($arSkuValue["NAME"])?></option>
																	<?
																	endforeach;
																	unset($counter);
																}?>
              </select>
	      <span class="checkout_update_button">UPDATE</span>
											<?endif;
										endforeach;
									endif;
									?>
            </div>
            <div class="priceQuanBox">
 	      <?elseif ($arHeader["id"] == "QUANTITY"):?>
              <div class="quantity">
		<input type="hidden" name="product_id" size="2" value="<?=$arItem["ID"]?>" />
													<?
													$ratio = isset($arItem["MEASURE_RATIO"]) ? $arItem["MEASURE_RATIO"] : 0;
													$useFloatQuantity = ($arParams["QUANTITY_FLOAT"] == "Y") ? true : false;
													$useFloatQuantityJS = ($useFloatQuantity ? "true" : "false");
													?>
												<?if(!isset($arItem["MEASURE_RATIO"])){
													$arItem["MEASURE_RATIO"] = 1;
												}

												if(floatval($arItem["MEASURE_RATIO"]) != 0):
												?>

								<a href="javascript:void(0);" class="minus" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'down', <?=$useFloatQuantityJS?>);"></a>
                <input type="text" name="QUANTITY_INPUT_<?=$arItem["ID"]?>" id="QUANTITY_INPUT_<?=$arItem["ID"]?>" value="<?=$arItem["QUANTITY"]?>" onchange="updateQuantity('QUANTITY_INPUT_<?=$arItem["ID"]?>', '<?=$arItem["ID"]?>', <?=$ratio?>, <?=$useFloatQuantityJS?>)" />
								<a href="javascript:void(0);" class="plus" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'up', <?=$useFloatQuantityJS?>);"></a>
												<?endif;
												?>
                <input type="hidden" id="QUANTITY_<?=$arItem['ID']?>" name="QUANTITY_<?=$arItem['ID']?>" value="<?=$arItem["QUANTITY"]?>" />
              </div>
	<?elseif ($arHeader["id"] == "PRICE"):?>
	      <p class="price">
		<span class="cart_normal_price" id="current_price_<?=$arItem["ID"]?>">
                <?if(($arItem['SALE'] == 'да') && ($arItem['SPECIAL_PRICE'] < $arItem["BASE_PRICE"]) && ($DB->CompareDates($arItem['SPECIAL_DATE'], date('d.m.Y'))==-1)):?>
                  <?=number_format($arItem['SPECIAL_PRICE'], 0, '.', ' ');?> <i class="fa fa-rub"></i>
                <?else:?>
		  <?=$arItem["PRICE_FORMATED"]?>
                <?endif;?>
		</span>
										<?/*<div class="old_price" id="old_price_<?=$arItem["ID"]?>">
											<?if (floatval($arItem["DISCOUNT_PRICE_PERCENT"]) > 0):?>
												<?=$arItem["FULL_PRICE_FORMATED"]?>
											<?endif;?>
										</div>

									<?if ($bPriceType && strlen($arItem["NOTES"]) > 0):?>
										<div class="type_price"><?=GetMessage("SALE_TYPE")?></div>
										<div class="type_price_value"><?=$arItem["NOTES"]?></div>
									<?endif;*/?>
              </p>
	<?elseif (($arHeader["id"] == "DISCOUNT") && ($arItem['SALE'] == 'да') && ($arItem['SPECIAL_PRICE'] < $arItem["BASE_PRICE"]) && ($DB->CompareDates($arItem['SPECIAL_DATE'], date('d.m.Y'))==-1)):?>
	      <p class="price">
                <span class="cart_old_price"><?=number_format($arItem['BASE_PRICE'], 0, '.', ' ');?> <i class="fa fa-rub"></i></span><br />
                <span class="cart_discount_info">Распродажа</span><br />

									<?/*<span><?=$arHeader["name"]; ?>:</span>
							<div id="discount_value_<?=$arItem["ID"]?>"><?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?></div>*/?>
	      </p>
	<?else:?>
	<?endif;endforeach;?>
           </div>

          <?/*if ($bDelayColumn || $bDeleteColumn):?>
								<?
								if ($bDeleteColumn):*/
									?>
         <a class="deleteItem checkout_removefromcart" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>" title="<?=GetMessage("SALE_DELETE")?>" onclick="return deleteProductRow(this)"></a>

					<?/*endif;?>

						<?endif;*/?>
         </td>
        </tr>
					<?$retail_ids[] = $arItem['XML_ID'];
					endif;
				endforeach;?>
	</tbody>
      </table>
      <input type="hidden" id="column_headers" value="<?=htmlspecialcharsbx(implode($arHeaders, ","))?>" />
      <input type="hidden" id="offers_props" value="<?=htmlspecialcharsbx(implode($arParams["OFFERS_PROPS"], ","))?>" />
      <input type="hidden" id="action_var" value="<?=htmlspecialcharsbx($arParams["ACTION_VARIABLE"])?>" />
      <input type="hidden" id="quantity_float" value="<?=($arParams["QUANTITY_FLOAT"] == "Y") ? "Y" : "N"?>" />
      <input type="hidden" id="price_vat_show_value" value="<?=($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") ? "Y" : "N"?>" />
      <input type="hidden" id="hide_coupon" value="<?=($arParams["HIDE_COUPON"] == "Y") ? "Y" : "N"?>" />
      <input type="hidden" id="use_prepayment" value="<?=($arParams["USE_PREPAYMENT"] == "Y") ? "Y" : "N"?>" />
      <input type="hidden" id="auto_calculation" value="<?=($arParams["AUTO_CALCULATION"] == "N") ? "N" : "Y"?>" />

      <div class="totalPrice">
        <div id="total">
	<?if ($arParams["PRICE_VAT_SHOW_VALUE"] == "Y"):?>
          <div class="clearfix">
            <div class="pull-left">Сумма:</div>
	    <div class="pull-right" id="allSum_wVAT_FORMATED"><?=$arResult["allSum_wVAT_FORMATED"]?></div>
          </div>
					<?
					$showTotalPrice = (float)$arResult["DISCOUNT_PRICE_ALL"] > 0;
					?>
	  <div style="display: <?=($showTotalPrice ? 'block' : 'none'); ?>; line-height: 30px;">
            <div class="custom_t1"></div>
						<div class="custom_t2 pull-right" style="text-decoration:line-through; color:#828282;" id="PRICE_WITHOUT_DISCOUNT">
              <?=($showTotalPrice ? $arResult["PRICE_WITHOUT_DISCOUNT"] : ''); ?>
            </div>
          </div>
					<?
					if (floatval($arResult['allVATSum']) > 0):
						?>
          <div class="clearfix">
            <div class="pull_left"><?echo GetMessage('SALE_VAT')?></div>
            <div class="pull_right" id="allVATSum_FORMATED"><?=$arResult["allVATSum_FORMATED"]?></div>
          </div>
						<?
					endif;
					?>
				<?endif;?>
          <div class="clearfix" style="display: none;">
            <div class="pull-left"><?=GetMessage("SALE_TOTAL")?></div>
	    <div class="pull-right" id="allSum_FORMATED"><?=$arResult["allSum_FORMATED"]?></div>
          </div>
        </div>
      </div>

      <div data-retailrocket-markup-block="57ea53fd9872e5765454b622" data-product-id="<?=join(',', $retail_ids);?>"></div>
      <?if ($arParams["USE_PREPAYMENT"] == "Y" && strlen($arResult["PREPAY_BUTTON"]) > 0):?>
			<?=$arResult["PREPAY_BUTTON"]?>
			<span><?=GetMessage("SALE_OR")?></span>
      <?endif;?>
      <?if ($arParams["AUTO_CALCULATION"] != "Y"){?>
      <a href="javascript:void(0)" onclick="updateBasket();" class="checkout refresh"><?=GetMessage("SALE_REFRESH")?></a>
      <?}?>
      <?/*<a href="javascript:void(0)" onclick="checkOut();" class="redbutton checkout"><?=GetMessage("SALE_ORDER")?></a>*/?>
      <a href="/checkout/" onclick="checkOut();" class="redbutton checkout"><?=GetMessage("SALE_ORDER")?></a>
    </form>

<? if(!$_SESSION['no_moscow_delivery'] && !$noMoscow)  {?>
    <div class="oneClickBox">
      <form class="feedBackWrapper" data-adr="<?=$_SERVER['REQUEST_URI']?>" method="post">
        <a name="new_order"><h3>Заказать по Москве<br> без регистрации в 1 клик</h3></a>
        <input class="isrequired" type="text" name="name" <?php if($stock_fail){echo "disabled='disabled' title='Недостаточно товаров'";} ?> placeholder="Введите ваше имя" />
        <input class="isrequired" type="text" name="telephone" <?php if($stock_fail){echo "disabled='disabled' title='Недостаточно товаров'";}else{ echo 'data-let-input="/^[0-9]+$/" data-let-phone="+7 (___) ___-__-__"'; } ?> placeholder="Номер телефона" />
        <div class="privacy_check" style="margin: 15px 20px;">
          <input type="checkbox" checked name="agree" disabled value="1" />
          <label>Я прочитал и согласен с условиями</label>
        </div>
        <button id="oneclickcart" type="submit" <?php if($stock_fail){echo "disabled='disabled' title='Недостаточно товаров'";} ?>>Подтвердить заказ</button>
        <p class="successmsg"></p>
      </form>
    </div>
    <div class="popup-container" id="success_order">
      <a class="close" onclick="$('.fadeMe').trigger('click');">X</a>
      <div class="title"><p>СПАСИБО ЗА ПОКУПКУ!</p><br /></div>
      <div class="info"></div>
      <br />
      <p><a href="/shoes/" class="redbutton">Вернуться в магазин</a></p>
    </div>
<?}?>

<?} ///не отображаем на странице чекаута
?>
<?else:?>
    <div id="basket_items_list">
      <?=GetMessage("SALE_NO_ITEMS");?>
    </div>
<?endif;?>
<script>
    //$('.select_onwhite').styler();
    $('.city').styler();
    letJS.setHandler('data-let-phone', function(event, unchanged) {
      if (!this.value) {
        this.value = event.rule;
      }
      if (unchanged) {
        if (event.type === 'blur') {
            if (this.value === event.rule) {
               this.value = '';
            }
            return;
        } else {
            this.focus();
        }
      } else if (event.insertValue) {
        var parts = event.insertValue.split('');
        for(var i = 0; i < parts.length; i++) {
            this.value = this.value.replace(/^([^_]+)_/, '$1' + parts[i]);
        }
      } else if (event.cropValue) {
        this.value = this.value.replace(/(\+7.*)\d([^\d]*)$/, '$1_$2');
      }
      var pos = this.value.indexOf('_');
      event.selection(pos > 0 ? pos : this.value.length);
      return false;
    });
    $(document.body).on("focus", ".isrequired", function(){$(this).css("border","");});
    $("#oneclickcart").on('click',function(e){
        e.preventDefault();
        var wri = $(".feedBackWrapper");
        var validate = true;
        wri.find(".isrequired").each(function(){
          if(!$(this).val().length){validate = false; $(this).css("border","1px solid #D22")}
        });
        if(validate){
          $("#oneclickcart").hide();
          wri.find('.successmsg').html("Пожалуйста, подождите");
          wri.find('.successmsg').show();
          $.ajax({
            url: '<?=$templateFolder?>/confirm_pickup.php',
            type: 'post',
            data: $('.cart-info input[type=\'text\'],.cart-info input[type=\'hidden\'],.cart-info input[type=\'radio\']:checked,.cart-info input[type=\'checkbox\']:checked,.cart-info select,.cart-info textarea,.feedBackWrapper input[type=\'text\'],.feedBackWrapper input[type=\'hidden\']'),
            dataType: 'json',
            complete: function(json){
			var popup = $('#success_order');
	      var offset = popup.offset();
              popup.find('.info').html(json.responseText);
	      $('body, html').animate({
        	scrollTop: offset.top
	      }, 100);
              popup.addClass('show');
              wri.removeClass('show');
              wri.hide();
              $('.fadeMe').show();
              $('.fadeMe').on('click',function() {
                popup.removeClass('show');
                $('.fadeMe').hide();
            });
			}
          });
        }
    });

</script>
<script type="text/javascript">
var _tmr = _tmr || [];
_tmr.push({
    id: '3065581',
    type: 'itemView',
    productid: [<? echo join(',',$addig);?>],
    pagetype: 'cart',
    list: '1',
    totalvalue: '<?= $arResult["allSum"] ?>'
});
onCheckoutOption(1);
</script>

<style>
  .totop {
    display: none;
  }

  .rr-widget2 .retailrocket-widgettitle {
    margin-bottom: 20px;
    font-size: 15px;
  }

  .rr-widget2 .price {
    margin-left: 7px;
    text-align: left;
  }

  .rr-widget2 .slick-prev,
  .rr-widget2 .slick-next {
    filter: grayscale(100%);
  }
</style>

<script>
  function observeRetailRocketSlider() {
    var $slider = $('.retailrocket-items.slick-initialized');

    if (!$slider.length) {
      if (window.requestAnimationFrame) window.requestAnimationFrame(observeRetailRocketSlider);
    } else {
      $slider.slick('slickSetOption', {
        slidesToShow: 1,
        slidesToScroll: 1
      }, true);
     }
  };

  observeRetailRocketSlider();
</script>