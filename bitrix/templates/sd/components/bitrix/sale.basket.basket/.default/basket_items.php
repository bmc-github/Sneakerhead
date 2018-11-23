<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @var array $arUrls */
/** @var array $arHeaders */
use Bitrix\Sale\DiscountCouponsManager;

if (!empty($arResult["ERROR_MESSAGE"]))
    ShowError($arResult["ERROR_MESSAGE"]);

$bDelayColumn = false;
$bDeleteColumn = false;
$bWeightColumn = false;
$bPropsColumn = false;
$bPriceType = false;
$noMoscow = false;

$retail_ids = array();
$addig = array();

if ($normalCount > 0):
    ?>

    <form method="post" action="<?=POST_FORM_ACTION_URI?>" name="basket_form" id="basket_form">
        <div id="basket_form_container" class="cart-info">
            <div id="basket_items_list">
                <div class="bx_ordercart_order_table_container">
                    <table id="basket_items">
                        <thead style="display:none;">
                        <tr>
                            <td class="margin"></td>
                            <? foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader) {
                                $arHeaders[] = $arHeader["id"];
                                if (in_array($arHeader["id"], array("TYPE"))) {
                                    $bPriceType = true;
                                    continue;
                                } elseif ($arHeader["id"] == "PROPS") {
                                    $bPropsColumn = true;
                                    continue;
                                } elseif ($arHeader["id"] == "DELAY") {
                                    $bDelayColumn = true;
                                    continue;
                                } elseif ($arHeader["id"] == "DELETE") {
                                    $bDeleteColumn = true;
                                    continue;
                                } elseif ($arHeader["id"] == "WEIGHT") {
                                    $bWeightColumn = true;
                                }
                                if ($arHeader["id"] == "NAME") {
                                    ?>
                                    <td class="item" colspan="3" id="col_<?= $arHeader["id"]; ?>">
                                    <?
                                } elseif ($arHeader["id"] == "PRICE") {
                                    ?>
                                    <td class="price" id="col_<?= $arHeader["id"]; ?>">
                                    <?
                                } else {
                                    ?>
                                    <td class="custom" id="col_<?= $arHeader["id"]; ?>">
                                    <?
                                } ?>
                                <?= $arHeader["name"]; ?>
                                </td>
                                <?
                            }
                            if ($bDeleteColumn || $bDelayColumn) {
                                ?>
                                <td class="custom"></td>
                            <? } ?>
                            <td class="margin"></td>
                        </tr>
                        </thead>
                        <tbody>
                        <? $skipHeaders = array('PROPS', 'DELAY', 'DELETE', 'TYPE');
                        foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):

                            if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"):

                                ?>
                                <tr id="<?= $arItem["ID"] ?>"
                                    data-item-name="<?= $arItem["NAME"] ?>"
                                    data-item-brand="<?= $arItem[$arParams['BRAND_PROPERTY'] . "_VALUE"] ?>"
                                    data-item-price="<?= $arItem["PRICE"] ?>"
                                    data-item-currency="<?= $arItem["CURRENCY"] ?>">
                                    <td class="margin"></td>
                                    <? foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):
                                        if (in_array($arHeader["id"], $skipHeaders)) // some values are not shown in the columns in this template
                                            continue;
                                        if ($arHeader["name"] == '')
                                            $arHeader["name"] = GetMessage("SALE_" . $arHeader["id"]);
                                        if ($arHeader["id"] == "NAME"):
                                            ?>
                                            <td class="image">
                                                <? if (strlen($arItem["DETAIL_PAGE_URL"]) > 0): ?><a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
                                                    <img src="<?= $arItem['PREVIEW_PICTURE_SRC'] ?>" width="96" height="96" alt=""/>
                                                <? if (strlen($arItem["DETAIL_PAGE_URL"]) > 0): ?></a><?endif;?>
                                            </td>
                                            <td class="name"><?//echo '<pre>';print_r($arItem);echo '</pre>';                                                ?>
                                                <a class="category_name" href="<?= $arItem['CATEGORY']['SECTION_PAGE_URL'] ?>"><?= $arItem['CATEGORY']['NAME'] ?></a><br/>
                                                <a class="manufacturer_name" href="<?= $arItem['BRAND']['DETAIL_PAGE_URL'] ?>"><?= $arItem['BRAND']['NAME'] ?></a>
                                                <? if (strlen($arItem["DETAIL_PAGE_URL"]) > 0): ?><a class="product_name" href="<?= $arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
                                                  <?= $arItem["NAME"] ?>
                                                <? if (strlen($arItem["DETAIL_PAGE_URL"]) > 0): ?></a><?endif;?>
                                            </td>
                                            <td class="option-select">
                                                <?
                                                if (is_array($arItem["SKU_DATA"]) && !empty($arItem["SKU_DATA"])):
                                                    $propsMap = array();
                                                    foreach ($arItem["PROPS"] as $propValue) {
                                                        if (empty($propValue) || !is_array($propValue))
                                                            continue;
                                                        $propsMap[$propValue['CODE']] = (isset($propValue['~VALUE']) ? $propValue['~VALUE'] : $propValue['VALUE']);
                                                    }
                                                    unset($propValue);

                                                    foreach ($arItem["SKU_DATA"] as $propId => $arProp):
                                                        $selectedIndex = 0;
                                                        // if property contains images or values
                                                        $isImgProperty = false;
                                                        if (!empty($arProp["VALUES"]) && is_array($arProp["VALUES"])) {
                                                            $counter = 0;
                                                            foreach ($arProp["VALUES"] as $id => $arVal) {
                                                                $counter++;
                                                                if (isset($propsMap[$arProp['CODE']])) {
                                                                    //if ($propsMap[$arProp['CODE']] == $arVal['NAME'] || $propsMap[$arProp['CODE']] == $arVal['XML_ID'])
                                                                    if ($propsMap[$arProp['CODE']] == $arVal['NAME'] || $propsMap[$arProp['CODE']] == $arVal['ID'])
                                                                        $selectedIndex = $counter;
                                                                }
                                                                if (!empty($arVal["PICT"]) && is_array($arVal["PICT"]) && !empty($arVal["PICT"]['SRC'])) {
                                                                    $isImgProperty = true;
                                                                }
                                                            }
                                                            unset($counter);
                                                        }
                                                        $countValues = count($arProp["VALUES"]);
                                                        $full = ($countValues > 5) ? "full" : "";

                                                        $marginLeft = 0;
                                                        if ($countValues > 5 && $selectedIndex > 5)
                                                            $marginLeft = ((5 - $selectedIndex) * 20) . '%';

                                                        /*if ($isImgProperty):
                                                        ?>
                                                                        <ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>"
                                                                            style="width: 200%; margin-left: <?=$marginLeft; ?>"
                                                                            class="sku_prop_list">
                                                                            <?
                                                                            $counter = 0;
                                                                            foreach ($arProp["VALUES"] as $valueId => $arSkuValue):
                                                                                $counter++;
                                                                                //$selected = ($selectedIndex == $counter ? ' bx_active' : '');
                                                                                $selected = ($selectedIndex == $counter ? ' selected' : '');
                                                                            ?>
                                                                                <li style="width:10%;"
                                                                                    class="sku_prop<?=$selected?>"
                                                                                    data-sku-selector="Y"
                                                                                    data-value-id="<?=$arSkuValue["XML_ID"]?>"
                                                                                    data-sku-name="<?=htmlspecialcharsbx($arSkuValue["NAME"]); ?>"
                                                                                    data-element="<?=$arItem["ID"]?>"
                                                                                    data-property="<?=$arProp["CODE"]?>">
                                                                                    <a href="javascript:void(0)" class="cnt"><span class="cnt_item" style="background-image:url(<?=$arSkuValue["PICT"]["SRC"];?>)"></span></a>
                                                                                </li>
                                                                            <?
                                                                            endforeach;
                                                                            unset($counter);
                                                                            ?>
                                                                        </ul>
                                                        <?else:*/
                                                        ?>
                                                        <select name="option[<?= $arItem['ID'] ?>]"
                                                                class="select_onwhite">

                                                            <?
                                                            if (!empty($arProp["VALUES"])) {
                                                                $counter = 0;
                                                                foreach ($arProp["VALUES"] as $valueId => $arSkuValue):
                                                                    $counter++;
                                                                    $selected = ($selectedIndex == $counter ? ' selected' : '');
                                                                    ?>
                                                                    <option value="<?= $arSkuValue["ID"] ?>"<?= $selected ?>><?= htmlspecialcharsbx($arSkuValue["NAME"]) ?></option>
                                                                    <?
                                                                endforeach;
                                                                unset($counter);
                                                            }
                                                            ?>
                                                        </select>
                                                        <?
                                                        //endif;
                                                    endforeach;
                                                endif;
                                                ?>
                                            </td>
                                            <?
                                        elseif ($arHeader["id"] == "QUANTITY"):
                                            ?>
                                            <td class="quantity">

                                                <input type="hidden" name="product_id" size="2"
                                                       value="<?= $arItem["ID"] ?>"/>
                                                <table cellspacing="0" cellpadding="0" class="counter">
                                                    <tr>
                                                        <td>
                                                            <?
                                                            $ratio = isset($arItem["MEASURE_RATIO"]) ? $arItem["MEASURE_RATIO"] : 0;
                                                            $useFloatQuantity = ($arParams["QUANTITY_FLOAT"] == "Y") ? true : false;
                                                            $useFloatQuantityJS = ($useFloatQuantity ? "true" : "false");
                                                            ?>
                                                            <input
                                                                    type="text"
                                                                    size="3"
                                                                    id="QUANTITY_INPUT_<?= $arItem["ID"] ?>"
                                                                    name="QUANTITY_INPUT_<?= $arItem["ID"] ?>"
                                                                    maxlength="18"
                                                                    style="max-width: 50px"
                                                                    value="<?= $arItem["QUANTITY"] ?>"
                                                                    onchange="updateQuantity('QUANTITY_INPUT_<?= $arItem["ID"] ?>', '<?= $arItem["ID"] ?>', <?= $ratio ?>, <?= $useFloatQuantityJS ?>)"
                                                            >
                                                        </td>
                                                        <?
                                                        if (!isset($arItem["MEASURE_RATIO"])) {
                                                            $arItem["MEASURE_RATIO"] = 1;
                                                        }

                                                        if (
                                                            floatval($arItem["MEASURE_RATIO"]) != 0
                                                        ):
                                                            ?>
                                                            <td id="basket_quantity_control">
                                                                <div class="basket_quantity_control">
                                                                    <a href="javascript:void(0);" class="plus"
                                                                       onclick="setQuantity(<?= $arItem["ID"] ?>, <?= $arItem["MEASURE_RATIO"] ?>, 'up', <?= $useFloatQuantityJS ?>);"></a>
                                                                    <a href="javascript:void(0);" class="minus"
                                                                       onclick="setQuantity(<?= $arItem["ID"] ?>, <?= $arItem["MEASURE_RATIO"] ?>, 'down', <?= $useFloatQuantityJS ?>);"></a>
                                                                </div>
                                                            </td>
                                                            <?
                                                        endif;
                                                        if (isset($arItem["MEASURE_TEXT"])) {
                                                            ?>
                                                            <td style="text-align: left"><?= htmlspecialcharsbx($arItem["MEASURE_TEXT"]) ?></td>
                                                            <?
                                                        }
                                                        ?>
                                                    </tr>
                                                </table>
                                                <!--</div>-->
                                                <input type="hidden" id="QUANTITY_<?= $arItem['ID'] ?>"
                                                       name="QUANTITY_<?= $arItem['ID'] ?>"
                                                       value="<?= $arItem["QUANTITY"] ?>"/>
                                            </td>
                                            <?
                                        elseif ($arHeader["id"] == "PRICE"):
                                            ?>
                                            <td class="price">
                                                <span class="cart_normal_price" id="current_price_<?= $arItem["ID"] ?>">
                                                <?if(($arItem['SALE'] == 'да') && ($arItem['SPECIAL_PRICE'] < $arItem["BASE_PRICE"]) && ($DB->CompareDates($arItem['SPECIAL_DATE'], date('d.m.Y')) == -1)): ?>
                                                  <?=number_format($arItem['SPECIAL_PRICE'], 0, '.', ' '); ?> <i class="fa fa-rub"></i>
                                                <?else:?>
                                                  <?=$arItem["PRICE_FORMATED"]?>
                                                <?endif;?>
						</span>
                                            </td>
                                            <?
                                        elseif ($arHeader["id"] == "DISCOUNT"):
                                            ?>
                                            <td class="price">
                                              <?if(($arItem['SALE'] == 'да') && ($arItem['SPECIAL_PRICE'] >0)/* && ($DB->CompareDates($arItem['SPECIAL_DATE'], date('d.m.Y')) == -1)*/):?>
                                                <span class="cart_old_price" id="old_price_<?//=$arItem["ID"]?>"><?=number_format($arItem['SPECIAL_PRICE'], 0, '.', ' '); ?> <i class="fa fa-rub"></i></span><br/>
                                                <span class="cart_discount_info">Распродажа</span><br/>
                                              <?else:?>
                                                <?if(floatval($arItem["DISCOUNT_PRICE_PERCENT"]) > 0):?>
                                                <span class="cart_old_price" id="old_price_<?=$arItem["ID"]?>"><?=$arItem["FULL_PRICE_FORMATED"]?></span><br />
						<span class="cart_discount_info"><?=$arHeader["name"]?> <?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?></span><br />
 					      <?endif;?>
					    <?endif;?>	
                                            </td>
                                            <?
                                        elseif ($arHeader["id"] == "WEIGHT"):
                                            ?>
                                            <td class="custom">
                                                <span><?= $arHeader["name"]; ?>:</span>
                                                <?= $arItem["WEIGHT_FORMATED"] ?>
                                            </td>
                                            <?
                                        else:
                                            ?>
                                            <td class="price">
                                                <? if ($arHeader["id"] == "SUM"):
                                                if(($arItem['SALE'] == 'да') && ($arItem['SPECIAL_PRICE'] < $arItem["PRICE"]) && ($DB->CompareDates($arItem['SPECIAL_DATE'], date('d.m.Y')) == -1))
                                                  $arItem['SUM'] = (int)$arItem['SPECIAL_PRICE'] * $arItem['QUANTITY'].' <i class="fa fa-rub"></i>';
                                                ?>
                                                <div id="sum_<?= $arItem["ID"] ?>">
                                                    <?
                                                    endif;
                                                    //echo $arHeader["id"];
                                                    echo $arItem[$arHeader["id"]];

                                                    if ($arHeader["id"] == "SUM"):
                                                    ?>
                                                </div>
                                            <?
                                            endif;
                                            ?>
                                            </td>
                                            <?
                                        endif;
                                    endforeach;

                                    if ($bDelayColumn || $bDeleteColumn):?>
                                        <td class="control">
                                            <? if ($bDeleteColumn): ?>
                                                <a class="checkout_removefromcart"
                                                   href="<?= str_replace("#ID#", $arItem["ID"], $arUrls["delete"]) ?>"
                                                   title="<?= GetMessage("SALE_DELETE") ?>"
                                                   onclick="return deleteProductRow(this)">
                                                    <img src="<?= SITE_TEMPLATE_PATH ?>/images/delicon-cart.png"
                                                         alt="<?= GetMessage("SALE_DELETE") ?>"/>
                                                </a>
                                                <br/>
                                                <?
                                            endif;
                                            if ($bDelayColumn):?>
                                                <a href="<?= str_replace("#ID#", $arItem["ID"], $arUrls["delay"]) ?>"><?= GetMessage("SALE_DELAY") ?></a>
                                            <? endif; ?>
                                        </td>
                                    <? endif; ?>
                                    <td class="margin"></td>
                                </tr>
                                <? $retail_ids[] = $arItem['XML_ID'];
                            endif;
                        endforeach;
                        ?>
                        </tbody>
                    </table>
                </div>
                <input type="hidden" id="column_headers" value="<?= htmlspecialcharsbx(implode($arHeaders, ",")) ?>"/>
                <input type="hidden" id="offers_props" value="<?= htmlspecialcharsbx(implode($arParams["OFFERS_PROPS"], ",")) ?>"/>
                <input type="hidden" id="action_var" value="<?= htmlspecialcharsbx($arParams["ACTION_VARIABLE"]) ?>"/>
                <input type="hidden" id="quantity_float" value="<?= ($arParams["QUANTITY_FLOAT"] == "Y") ? "Y" : "N" ?>"/>
                <input type="hidden" id="price_vat_show_value" value="<?= ($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") ? "Y" : "N" ?>"/>
                <input type="hidden" id="hide_coupon" value="<?= ($arParams["HIDE_COUPON"] == "Y") ? "Y" : "N" ?>"/>
                <input type="hidden" id="use_prepayment" value="<?= ($arParams["USE_PREPAYMENT"] == "Y") ? "Y" : "N" ?>"/>
                <input type="hidden" id="auto_calculation" value="<?= ($arParams["AUTO_CALCULATION"] == "N") ? "N" : "Y" ?>"/>
                <input type="hidden" name="BasketOrder" value="BasketOrder" />
            </div>
        </div>
    </form>
    <? if ($arParams['ORDER_PAGE'] !== "Y"): ?>
        <div class="cart-total clearafter">
            <div id="coupons_block" class="content" style="float:left;">
                <?
                if ($arParams["HIDE_COUPON"] != "Y") {
                    ?>
                    <?//\Bitrix\Sale\DiscountCouponsManager::delete($arResult['COUPON_LIST'][0]["COUPON"]);?>
                    
                    
        
   <?if(!$arResult['COUPON_LIST']):?>   
   <form action="" method="post" enctype="multipart/form-data">          
                         <p>Код купона:</p>
                        <input type="text" name="coupon" id="coupon" value="" <?/*onchange="enterCoupon();"*/?> style="background:#fff;"/>
                        <input type="hidden" name="next" value="coupon"/> 
                        <button type="button" value="Применить купон" class="redbutton" onclick="enterCoupon();" style="height:30px;line-height:30px;padding:0 20px;margin:1px 10px;float:right;">Применить</button>
</form>
<?endif?>

                        <? if (!empty($arResult['COUPON_LIST'])) {
                            foreach ($arResult['COUPON_LIST'] as $oneCoupon) {
                                $couponClass = 'disabled';
                                switch ($oneCoupon['STATUS']) {
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
                                    if (isset($oneCoupon['CHECK_CODE_TEXT'])) {
                                        echo(is_array($oneCoupon['CHECK_CODE_TEXT']) ? implode('<br>', $oneCoupon['CHECK_CODE_TEXT']) : $oneCoupon['CHECK_CODE_TEXT']);
                                    }?>
                                  </div>
                                  <form class="coup" method="POST">
                                  <input type="hidden" name="DelCop" value="<?=$oneCoupon["COUPON"]?>">
                                  <input type="submit" value="<?=GetMessage('DEL_COP')?>">
                                  </form>
                                </div>
                                <?else:?>
                                <?\Bitrix\Sale\DiscountCouponsManager::delete($oneCoupon["COUPON"]);?>
                                <div class="bx_ordercart_coupon">
                                  <input disabled readonly type="text" name="OLD_COUPON[]" value="<?= htmlspecialcharsbx($oneCoupon['COUPON']); ?>" class="<? echo $couponClass; ?>">
                                  <span class="<? echo $couponClass; ?>" data-coupon="<? echo htmlspecialcharsbx($oneCoupon['COUPON']); ?>"></span>
                                  <div class="bx_ordercart_coupon_notes"><?
                                    if (isset($oneCoupon['CHECK_CODE_TEXT'])) {
                                        echo(is_array($oneCoupon['CHECK_CODE_TEXT']) ? implode('<br>', $oneCoupon['CHECK_CODE_TEXT']) : $oneCoupon['CHECK_CODE_TEXT']);
                                    }?>
                                  </div>
                                </div>
                                <?endif?>
                                <?
                            }
                            unset($couponClass, $oneCoupon);
                        } ?>
                    
                    <?
                }
                ?>
            </div>
            <table id="total" style="width:auto;">
                <? if ($bWeightColumn && floatval($arResult['allWeight']) > 0): ?>
                    <tr>
                        <td class="custom_t1"><?= GetMessage("SALE_TOTAL_WEIGHT") ?></td>
                        <td class="custom_t2" id="allWeight_FORMATED"><?= $arResult["allWeight_FORMATED"] ?></td>
                    </tr>
                <? endif; ?>
                <? if ($arParams["PRICE_VAT_SHOW_VALUE"] == "Y"): ?>
                    <tr>
                        <td class="title"><b>Сумма:</b></td>
                        <td class="sum" id="allSum_wVAT_FORMATED"><?= $arResult["allSum_wVAT_FORMATED"] ?></td>
                    </tr>
                    <?/*
                    $showTotalPrice = (float)$arResult["DISCOUNT_PRICE_ALL"] > 0;
                    ?>
                    <tr style="display: <?= ($showTotalPrice ? 'table-row' : 'none'); ?>;">
                        <td class="custom_t1"></td>
                        <td class="custom_t2" style="text-decoration:line-through; color:#828282;" id="PRICE_WITHOUT_DISCOUNT">
                            <?= ($showTotalPrice ? $arResult["PRICE_WITHOUT_DISCOUNT"] : ''); ?>
                        </td>
                    </tr>
                    <?*/
                    if (floatval($arResult['allVATSum']) > 0):
                        ?>
                        <tr>
                            <td><? echo GetMessage('SALE_VAT') ?></td>
                            <td id="allVATSum_FORMATED"><?= $arResult["allVATSum_FORMATED"] ?></td>
                        </tr>
                        <?
                    endif;
                    ?>
                <? endif; ?>
                <tr>
                    <td class="title"><b><?= GetMessage("SALE_TOTAL") ?></b></td>
                    <td class="sum" id="allSum_FORMATED"><?= $arResult["allSum_FORMATED"] ?></td>
                </tr>


            </table>
        </div>
        <div class="fast-order">
            <table>
                <tbody>
                <tr>
                    <td style="width:40%;text-align:right;">
                        <a href="/" style="text-transform:uppercase;font-size:14px; padding-right: 16px;">Продолжить покупки</a>
                    </td>
                    <td style="width:224px;text-align:center;">
                        <? if ($arParams["USE_PREPAYMENT"] == "Y" && strlen($arResult["PREPAY_BUTTON"]) > 0): ?>
                            <?= $arResult["PREPAY_BUTTON"] ?>
                            <span><?= GetMessage("SALE_OR") ?></span>
                        <? endif; ?>
                        <? if ($arParams["AUTO_CALCULATION"] != "Y") {
                            ?>
                            <a href="javascript:void(0)" onclick="updateBasket();" class="checkout refresh"><?= GetMessage("SALE_REFRESH") ?></a>
                        <? } ?>
                        <a href="javascript:void(0)" onclick="checkOut();" class="redbutton checkout"><?= GetMessage("SALE_ORDER") ?></a>
                    </td>
                    <td style="width:40%;"></td>
                </tr>
                </tbody>
            </table>
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

$noMoscow = false;
	while($itemF = $basketF->Fetch()){
	$mxResult  = CCatalogSku::GetProductInfo($itemF["PRODUCT_ID"]);
	$addig[]= $mxResult['ID'];
		$db_props = CIBlockElement::GetProperty(2, $mxResult['ID'], array("sort" => "asc"), Array("ID"=>"84"));
$v = $db_props->fetch();
		if($v['VALUE'] == '22730'){
	$noMoscow = true;
}
	}


?>
			<? if(!$_SESSION['no_moscow_delivery'] && !$noMoscow){?>
            <div>
                <p style="text-transform:uppercase;text-align:center;margin: 30px 0 25px;">ИЛИ</p>
                <p class="title">Заказать по Москве без регистрации в 1 клик</p>
                <form class="feedBackWrapper" method="post" action="">
                    <hidden name="pickupshop" value="8" />
                    <table style="margin:10px auto;width:400px;" class="oneclick-inorder">
                        <tbody>
                        <tr>
                            <td>Имя</td>
                            <td><input type="text"<?if($stock_fail) echo ' disabled title="Недостаточно товаров"';?> name="name" placeholder="Как к вам обратиться?" class="input-ongray isrequired" style="width:100%"></td>
                        </tr>
                        <tr>
                            <td>Телефон</td>
                            <td><input type="text" name="telephone"<?if($stock_fail){echo ' disabled title="Недостаточно товаров"';}else{echo ' data-let-input="/^[0-9]+$/" data-let-phone="+7 (___) ___-__-__"';}?> placeholder="Телефон" class="input-ongray isrequired" style="width:100%"></td>
                        </tr>
                        <tr>
                            <td style="padding: 7px 16px 7px 0px;">Город доставки</td>
                            <td style="padding: 7px 0;">
                              <select class="city" style="width: 100%">
                                <option value="0">Москва</option>
                              </select>
                          </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="privacy_check" style="margin: 15px 20px;">
                                    <input type="checkbox" checked name="agree" disabled value="1"/>
                                    <label>Я прочитал и согласен с условиями</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center;">
                                <button type="submit"<?if($stock_fail) echo ' disabled title="Недостаточно товаров"';?> class="whitebutton" id="oneclickcart">Заказать в один клик</button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center;"><p class="successmsg"></p></td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
<?}?>
        </div>
 <div data-retailrocket-markup-block="57ea53fd9872e5765454b622" data-product-id="<?= join(',', $retail_ids); ?>"></div>

    <? endif; ?>
<? else: ?>
    <div id="basket_items_list">
        <table>
            <tbody>
            <tr>
                <td style="text-align:center">
                    <div class=""><?= GetMessage("SALE_NO_ITEMS"); ?></div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <?
endif; ?>

    <div class="popup-container" id="success_order">
      <a class="close" onclick="$('.fadeMe').trigger('click');">X</a>
      <div class="title"><p>СПАСИБО ЗА ПОКУПКУ!</p><br /></div>
      <div class="info"></div>
      <br />
      <p><a href="/shoes/" class="redbutton">Вернуться в магазин</a></p>
    </div>

<script>
    $('.select_onwhite').styler();
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
              var left = $(window).width() / 2 - 250;
              var top = ($(window).height() - $('#success_order').height())/2;
              popup.css('max-height', $(window.top).height());
              popup.css('left', left);
              popup.css('top', top);
              popup.find('.info').html(json.responseText); 
console.log(json.responseText);             
              popup.addClass('show');
              $('.fadeMe').show();
              $('.fadeMe').on('click',function() {
                document.location.replace("/");
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
