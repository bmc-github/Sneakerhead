<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);
//$this->addExternalCss('/bitrix/css/main/bootstrap.css');

$templateLibrary = array('popup', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES'])){
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
	'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList,
	'ITEM' => array(
		'ID' => $arResult['ID'],
		'IBLOCK_ID' => $arResult['IBLOCK_ID'],
		'OFFERS_SELECTED' => $arResult['OFFERS_SELECTED'],
		'JS_OFFERS' => $arResult['JS_OFFERS']
	)
);
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
	'ID' => $mainId,
	'DISCOUNT_PERCENT_ID' => $mainId.'_dsc_pict',
	'STICKER_ID' => $mainId.'_sticker',
	'BIG_SLIDER_ID' => $mainId.'_big_slider',
	'BIG_IMG_CONT_ID' => $mainId.'_bigimg_cont',
	'SLIDER_CONT_ID' => $mainId.'_slider_cont',
	'OLD_PRICE_ID' => $mainId.'_old_price',
	'PRICE_ID' => $mainId.'_price',
	'DISCOUNT_PRICE_ID' => $mainId.'_price_discount',
	'PRICE_TOTAL' => $mainId.'_price_total',
	'SLIDER_CONT_OF_ID' => $mainId.'_slider_cont_',
	'QUANTITY_ID' => $mainId.'_quantity',
	'QUANTITY_DOWN_ID' => $mainId.'_quant_down',
	'QUANTITY_UP_ID' => $mainId.'_quant_up',
	'QUANTITY_MEASURE' => $mainId.'_quant_measure',
	'QUANTITY_LIMIT' => $mainId.'_quant_limit',
	'BUY_LINK' => $mainId.'_buy_link',
	'ADD_BASKET_LINK' => $mainId.'_add_basket_link',
	'BASKET_ACTIONS_ID' => $mainId.'_basket_actions',
	'NOT_AVAILABLE_MESS' => $mainId.'_not_avail',
	'COMPARE_LINK' => $mainId.'_compare_link',
	'TREE_ID' => $mainId.'_skudiv',
	'DISPLAY_PROP_DIV' => $mainId.'_sku_prop',
	'DISPLAY_MAIN_PROP_DIV' => $mainId.'_main_sku_prop',
	'OFFER_GROUP' => $mainId.'_set_group_',
	'BASKET_PROP_DIV' => $mainId.'_basket_prop',
	'SUBSCRIBE_LINK' => $mainId.'_subscribe',
	'TABS_ID' => $mainId.'_tabs',
	'TAB_CONTAINERS_ID' => $mainId.'_tab_containers',
	'SMALL_CARD_PANEL_ID' => $mainId.'_small_card_panel',
	'TABS_PANEL_ID' => $mainId.'_tabs_panel'
);
$obName = $templateData['JS_OBJ'] = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
	: $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
	: $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
	: $arResult['NAME'];

$haveOffers = !empty($arResult['OFFERS']);
if ($haveOffers){
	$actualItem = isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']])
		? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]
		: reset($arResult['OFFERS']);
	$showSliderControls = false;

	foreach ($arResult['OFFERS'] as $offer){
		if ($offer['MORE_PHOTO_COUNT'] > 1){
			$showSliderControls = true;
			break;
		}
	}
}else{
	$actualItem = $arResult;
	$showSliderControls = $arResult['MORE_PHOTO_COUNT'] > 1;
}

$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

$showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['CATALOG_SUBSCRIBE'] === 'Y' || $haveOffers);

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');
$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');

$positionClassMap = array(
	'left' => 'product-item-label-left',
	'center' => 'product-item-label-center',
	'right' => 'product-item-label-right',
	'bottom' => 'product-item-label-bottom',
	'middle' => 'product-item-label-middle',
	'top' => 'product-item-label-top'
);

$discountPositionClass = 'product-item-label-big';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION'])){
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos){
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$labelPositionClass = 'product-item-label-big';
if (!empty($arParams['LABEL_PROP_POSITION'])){
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
	{
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

	$category = CIBlockSection::GetByID($arResult['~IBLOCK_SECTION_ID'])->GetNext(false,false);
	$brand = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>6,'ID'=>$arResult['DISPLAY_PROPERTIES']['BRAND']['VALUE']), false, false, array('ID','IBLOCK_ID','NAME','DETAIL_PAGE_URL','PROPERTY_SIZE_CHART','PROPERTY_SIZE_TABLES'))->GetNext(false,false);
	$stock_status = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>18,'ID'=>$arResult['PROPERTIES']['STOCK_STATUS']['VALUE']), false, false, array('PREVIEW_TEXT'))->GetNext(false,false);

	$cat = $arResult['PROPERTIES']['CATEGORY']['VALUE']?:$category['NAME'];
	$cat_ = substr(explode(' ',$cat)[0],-1);

	if($arResult['DISPLAY_PROPERTIES']['GENDER']['DISPLAY_VALUE']){
		$gender_ = strip_tags($arResult['DISPLAY_PROPERTIES']['GENDER']['DISPLAY_VALUE']);
		switch($cat_){
			case 'а':
			case 'я': $adg = 'ая'; break;
			case 'о': $adg = 'ое'; break;
			case 'и':
			case 'е':
			case 'ы': $adg = 'ие'; break;
			default:  {if(mb_substr($gender_,0,1,"UTF-8")=='М') $adg = 'ой'; else $adg = 'ий';}
		}
		$gender = substr($gender_,0,-2).$adg;
	}else{
		$gender = '';//'Унисекс';
	}
	if($arResult["PROPERTIES"]["COLAT"]["VALUE"]){
		$color_ = $arResult["PROPERTIES"]["COLAT"]["VALUE"];
		$color__ = substr($color_,-2);
		switch($cat_){
			case 'а':
			case 'я': if($color__ == 'ий') $adc = 'яя'; else $adc = 'ая'; break;
			case 'о': if($color__ == 'ий') $adc = 'ее'; else $adc = 'ое'; break;
			case 'и':
			case 'е':
			case 'ы': if($color__ == 'ий') $adc = 'ие'; else $adc = 'ые'; break;
			default:  $adc = $color__;
		}
		$color = substr($color_,0,-2).$adc;
	}else{
		$color = '';
	}
	$sku = $arResult['PROPERTIES']['ARTNUMBER']['VALUE'];

	$title = ($gender?$gender.' ':'').ToLower($cat).' '.$brand['NAME'].' '.$arResult['NAME'];
	if($category['IBLOCK_SECTION_ID'] == 11 || $category['IBLOCK_SECTION_ID'] == 12 || $category['ID'] == 11 || $category['ID'] == 12)
		$alt = ($gender?$gender.' ':'').ToLower(($color?$color.' ':'').$cat).' '.$brand['NAME'].' '.$arResult['NAME'];
	else
		$alt = 'Купить '.ToLower(($gender?$gender.' ':'').($color?$color.' ':'').$cat).' '.$brand['NAME'].' '.$arResult['NAME'];
?>
		<div class="container detail">
			<div class="row product-detail" id="<?=$itemIds['ID']?>">
				<div class="col-lg-12">
					<h1><?=($gender?$gender.' ':'').ToLower($cat)?> <span><?=$brand['NAME']?></span> <?=$arResult['NAME']?></h1>
					<p class="vendorCode">Артикул: <?=$sku?></p>
<?if($arResult['DISPLAY_PROPERTIES']['ISNEW']['VALUE'] == 'да'){?>
					<span class="product_isnew" style="position:relative;top:0;left:0;color:#f20113">новинка</span>
<?}
	if($arResult['DISPLAY_PROPERTIES']['SALE']['VALUE'] == 'да'){?>
					<span class="product_isnew" style="position:relative;top:0;left:0;color:#f20113">Распродажа</span>
<?}
	if(!empty($actualItem['MORE_PHOTO'])){?>
					<div id="Glide" class="glide">
						<div class="glide__wrapper">
							<ul class="glide__track">
							<?if($arResult['XML_ID'] < '16442'){ ?>
								<li class="glide__slide">
									<div class="imgBox">
										<div class="bigImgBox">
											<div class="bigImg">
												<a href="<?=$img['src']?>" title="<?=$title?>">
													<img src="<?=$img['src']?>" alt="<?=$alt?>" id="image" />
												</a>
											</div>
										</div>
									</div>
								</li>
							<?}
								foreach($actualItem['MORE_PHOTO'] as $i=>$photo){?>
								<li class="glide__slide">
									<div class="imgBox">
										<div class="bigImgBox">
											<div class="bigImg">
												<a href="<?=$photo['SRC']?>" title="<?=$title?> - изображение N<?=$i+1?> картинки">
													<img src="<?=$photo['SRC']?>" alt="<?=$alt?> - фото <?=$i+1?> картинки" id="image" />
												</a>
											</div>
										</div>
									</div>
								</li>
							<?}?>
							</ul>
						</div>
						<div class="glide__arrows"></div>
						<div class="glide__bullets"></div>
					</div>
<?}
	if($actualItem['CATALOG_QUANTITY']){?>
					<div class="price">
<?  if(($arParams['SHOW_OLD_PRICE'] == 'Y') && ($arResult['PROPERTIES']['SALE']['VALUE'] == 'да') && ($arResult['PROPERTIES']['SPECIAL_PRICE']['VALUE'] < $price['RATIO_BASE_PRICE']) && ($arResult['PROPERTIES']['SPECIAL_DATE']['VALUE'] < date('d.m.Y'))){?>
						<span class="price-old"><?=number_format($arResult['PROPERTIES']['SPECIAL_PRICE']['VALUE'],0,'','');?></span>
						<span class="price-new"><?=$price['BASE_PRICE']?> <i class="fa fa-rub"></i></span>
<?  }else{?>
						<?=$price['BASE_PRICE']?> <i class="fa fa-rub"></i>
<?  }
		if($points){?>
						<span class="reward"><small><?php echo $text_points; ?> <?php echo $points; ?></small></span><br />
<?  }
		if($discounts){?>
						<br />
						<div class="discount">
<?    foreach($discounts as $discount){
				echo sprintf($text_discount, $discount['quantity'], $discount['price']).'<br />';
			}?>
						</div>
<?  }?>
					</div>
					<div class="colorSize">
<?  if(!empty($arResult['RELATED_PRODUCTS'])){?>
						<select id="product_color_link">
							<option value="0"><?=$color_?></option>
<?    foreach($arResult['RELATED_PRODUCTS'] as $key => $product){?>
							<option value="<?=$product['ID']?>"><?=$product['COLOR']?></option>
<?    }?>
						</select>
						<script>
							var products_links = [];
						<?  foreach($arResult['RELATED_PRODUCTS'] as $key => $product){?>
							products_links["<?=$product['ID']?>"] = "<?=$product['URL']; ?>";
						<?  }?>
							$(document.body).on("change", "#product_color_link", function(){
								var t = $("#product_color_link");
								if(t.val() !== 0){
									window.location = products_links[t.val()];
								}
							});
						</script>
<?  }else{?>
						<select name="" id="product_color_link">
							<option value="0"><?=$color_?></option>
						</select>
<?  }?>
					</div>
<?  if($haveOffers && !empty($arResult['OFFERS_PROP']) && ($arResult['OFFERS'][0]['US_NAME']!='' || $arResult['OFFERS'][0]['UK_NAME']!='' || $arResult['OFFERS'][0]['EUR_NAME']!='' || $arResult['OFFERS'][0]['RUS_NAME']!='' || $arResult['OFFERS'][0]['CM_NAME']!='')){?>
					<div class="choose-size-wrap">
						<div class = "flex-row sizes-chart-header" >
							<div>
								<p>Выбрать размер</p>
							</div>
							<div class="sizes-chart-names">
								<a href="#US" class="size_range_name">US</a>
								<a href="#UK" class="size_range_name">UK</a>
								<a href="#RUS" class="size_range_name">RUS</a>
								<a href="#EUR" class="size_range_name">EUR</a>
								<a href="#CM" class="size_range_name">CM</a>
							</div>
						</div>
						<!--US SIZES-->
						<div class="flex-row sizes-chart-items-tab">
						<?foreach($arResult['OFFERS'] as $it){?>
							<div class="sizes-chart-item" data-id="<?=$it['ID']?>" data-shops="<?=implode('<br>',$arResult['STORES'][$it['ID']]);?>">
								<?=$it['US_NAME']?>
							</div>
						<?}?>
						</div>
						<!--UK SIZES-->
						<div class="flex-row sizes-chart-items-tab">
						<?foreach($arResult['OFFERS'] as $it){?>
							<div class="sizes-chart-item" data-id="<?=$it['ID']?>" data-shops="<?=implode('<br>',$arResult['STORES'][$it['ID']]);?>">
								<?=$it['UK_NAME']?>
							</div>
						<?}?>
						</div>
						<!--RUS SIZES-->
						<div class="flex-row sizes-chart-items-tab">
						<?foreach($arResult['OFFERS'] as $it){?>
							<div class="sizes-chart-item" data-id="<?=$it['ID']?>" data-shops="<?=implode('<br>',$arResult['STORES'][$it['ID']]);?>">
								<?=$it['RUS_NAME']?>
							</div>
						<?}?>
						</div>
						<!--EUR SIZES-->
						<div class="flex-row sizes-chart-items-tab">
						<?foreach($arResult['OFFERS'] as $it){?>
							<div class="sizes-chart-item" data-id="<?=$it['ID']?>" data-shops="<?=implode('<br>',$arResult['STORES'][$it['ID']]);?>">
								<?=$it['EUR_NAME']?>
							</div>
						<?}?>
						</div>
						<!--CM SIZES-->
						<div class="flex-row sizes-chart-items-tab">
						<?foreach($arResult['OFFERS'] as $it){?>
							<div class="sizes-chart-item" data-id="<?=$it['ID']?>" data-shops="<?=implode('<br>',$arResult['STORES'][$it['ID']]);?>">
								<?=$it['CM_NAME']?>
							</div>
						<?}?>
						</div>
						<?    if(in_array($category['XML_ID'],array(46,26,21,10,43))){?>
							<a href="javascript:void(0)" class="show_size_grid_trigger">Размерная сетка</a>
						<?    } ?>
					</div>

		<? }else{?>
					<div class="choose-size-wrap">
						<div class = "flex-row sizes-chart-header">
							<div>
								<p>Выбрать размер</p>
							</div>
						</div>
						<!--CM SIZES-->
						<div class="flex-row sizes-chart-items-tab">
						<?foreach($arResult['OFFERS'] as $it){?>
							<div class="sizes-chart-item" data-id="<?=$it['ID']?>" data-shops="<?=implode('<br>',$arResult['STORES'][$it['ID']]);?>">
								<?=$it['SIZE_NAME']?>
							</div>
						<?}?>
						</div>
						<?if(in_array($category['XML_ID'],array(46,26,21,10,43))){?>
						<a href="javascript:void(0)" class="show_size_grid_trigger redlink">Размерная сетка</a>
						<?}?>
					</div>
<?  }?>
					<div class="size_grid_info_container" style="position:relative">
						<table class="size_grid_info_title_wr">
							<tbody>
								<tr>
									<td><div class="size_grid_info_title">Размерная сетка</div></td>
									<td><a href="javascript:void(0)" class="size_grid_info_close"></a></td>
								</tr>
							</tbody>
						</table>
						<table class="size_grid_info_header">
							<tbody>
								<tr>
									<td>US</td>
									<td>UK</td>
									<td>EUR</td>
									<td>RUS</td>
									<td>CM</td>
								</tr>
							</tbody>
						</table>
<?  switch($brand['PROPERTIES']['SIZE']['VALUE']){
			case 'US':  $line = 1; break;
			case 'UK':  $line = 2; break;
			case 'EUR': $line = 3; break;
			case 'RUS': $line = 4; break;
			case 'CM':  $line = 5; break;
		}?>
						<style>.size_grid_info tr td:nth-child(<?=$line?>){background: #F4F4F4;font-weight: bold;}</style>
<?  if(empty($arResult['SIZES_TABLE'])){?>
						<div class="size_grid_info_scroll_wr">
							<table class="size_grid_info">
								<tbody>
									<tr> <td>4</td><td>3</td><td>37</td><td>36</td><td>22</td></tr>
									<tr> <td>4.5</td><td>3.5</td><td>37.5</td><td>36.5</td><td>22.5</td></tr>
									<tr> <td>5</td><td>4</td><td>38</td><td>37</td><td>23</td></tr>
									<tr> <td>5.5</td><td>4.5</td><td>38.5</td><td>37.5</td><td>23.5</td></tr>
									<tr> <td>6</td><td>5</td><td>39</td><td>38</td><td>24</td></tr>
									<tr> <td>6.5</td><td>5.5</td><td>39.5</td><td>38.5</td><td>24.5</td></tr>
									<tr> <td>7</td><td>6</td><td>40</td><td>39</td><td>25</td></tr>
									<tr> <td>7.5</td><td>6.5</td><td>40.5</td><td>39.5</td><td>25.5</td></tr>
									<tr> <td>8</td><td>7</td><td>41</td><td>40</td><td>26</td></tr>
									<tr> <td>8.5</td><td>7.5</td><td>42</td><td>41</td><td>26.5</td></tr>
									<tr> <td>9</td><td>8</td><td>42.5</td><td>41.5</td><td>27</td></tr>
									<tr> <td>9.5</td><td>8.5</td><td>43</td><td>42</td><td>27.5</td></tr>
									<tr> <td>10</td><td>9</td><td>44</td><td>43</td><td>28</td></tr>
									<tr> <td>10.5</td><td>9.5</td><td>44.5</td><td>43.5</td><td>28.5</td></tr>
									<tr> <td>11</td><td>10</td><td>45</td><td>44</td><td>29</td></tr>
									<tr> <td>11.5</td><td>10.5</td><td>45.5</td><td>44.5</td><td>29.5</td></tr>
									<tr> <td>12</td><td>11</td><td>46</td><td>45</td><td>30</td></tr>
									<tr> <td>12.5</td><td>11.5</td><td>47</td><td>46</td><td>30.5</td></tr>
									<tr> <td>13</td><td>12</td><td>47.5</td><td>46.5</td><td>31</td></tr>
									<tr> <td>13.5</td><td>12.5</td><td>48</td><td>47</td><td>31.5</td></tr>
									<tr> <td>14</td><td>13</td><td>48.5</td><td>47.5</td><td>32</td></tr>
									<tr> <td>15</td><td>14</td><td>49.5</td><td>48.5</td><td>33</td></tr>
									<tr> <td>16</td><td>15</td><td>50.5</td><td>49.5</td><td>34</td></tr>
									<tr> <td>17</td><td>16</td><td>51.5</td><td>50.5</td><td>35</td></tr>
									<tr> <td>18</td><td>17</td><td>52.5</td><td>51.5</td><td>36</td></tr>
								</tbody>
							</table>
						</div>
<?  }else{?>
						<div class="size_grid_info_scroll_wr">
							<table class="size_grid_info">
								<tbody>
<?    foreach($arResult['SIZES_TABLE'] as $v){ ?>
										<tr><td><?=$v['US']?></td><td><?=$v['UK']?></td><td><?=$v['EUR']?></td><td><?=$v['RUS']?></td><td><?=$v['CM']?></td></tr>
<?    }?>
								</tbody>
							</table>
						</div>
<?  }?>
					</div>
<?}?>
					<div class="available_shops"></div>
					<div class="product-description">
<?if(!$actualItem['CATALOG_QUANTITY']){?>
						<p style="color:red;"><br>Товар закончился.</p>
<?}?>
<?/*if($actualItem['CATALOG_QUANTITY']>0 && !empty($stock_status['PREVIEW_TEXT'])){?>
						<div class="stock">
<?  if(($arResult['PROPERTIES']['STOCK_STATUS']['VALUE'] == 22727 || $arResult['PROPERTIES']['STOCK_STATUS']['VALUE'] == 89319 ) &&  $DB->CompareDates($arResult['PROPERTIES']['DATE_AVAILABLE']['VALUE'], date('d.m.Y ')) > 0){
			echo htmlspecialchars_decode(str_replace('[DATE]',$arResult['PROPERTIES']['DATE_AVAILABLE']['VALUE'],$stock_status['PREVIEW_TEXT']));
		}elseif($arResult['PROPERTIES']['STOCK_STATUS']['VALUE'] != 22727 && $arResult['PROPERTIES']['STOCK_STATUS']['VALUE'] != 89319){
			echo htmlspecialchars_decode($stock_status['PREVIEW_TEXT']);
		}?>
						</div>
<?}*/?>
<?if(!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS']){
		if(!empty($arResult['DISPLAY_PROPERTIES'])){
			foreach($arResult['DISPLAY_PROPERTIES'] as $property){
				if(isset($arParams['MAIN_BLOCK_PROPERTY_CODE'][$property['CODE']])){?>
						<p><?=$property['NAME']?>: <b><?=(is_array($property['DISPLAY_VALUE'])? implode(' / ', $property['DISPLAY_VALUE']): $property['DISPLAY_VALUE'])?></b></p>
<?      }
			}
			unset($property);
		}
	}
	if($arResult['PREVIEW_TEXT'] != '')
						echo $arResult['PREVIEW_TEXT'];?>
					</div>
					<div class="flex-box">
						<div style="width: 68px"><i class="icon icon_delivery"></i></div>
						<div style="width: -webkit-calc(100% - 68px);width: calc(100% - 68px);">
							<p><strong>Закажи доставку курьерской службой Redexpress в пределах МКАД — и мы доставим товар бесплатно!</strong></p>
							<p><a class="redlink" href="/delivery/">Подробно о предложении</a></p>
						</div>
					</div>

					<div class="cart waveBlock waves-effect waves-block" <?if(!$actualItem['CATALOG_QUANTITY']) echo 'style="display:none;";'?>>
						<form data-adr="<?=$_SERVER['REQUEST_URI']?>" method="post" id="frm_add">
<?if(date(strtotime($arResult['PROPERTIES']['DATE_AVAILABLE']['VALUE'])) > strtotime("now")){
		if(($arResult['PROPERTIES']['STOCK_STATUS']['VALUE'] == 22727 || $arResult['PROPERTIES']['STOCK_STATUS']['VALUE'] == 89319 )){?>
							<button type="button" class="addCart button" id="button-cart" onclick="preorder()">Предзаказ</button>
<?  }else{?>
							<button type="button" class="addCart button" id="button-cart" value="" disabled>В продаже с <?=date('d.m', strtotime($arResult['PROPERTIES']['DATE_AVAILABLE']['VALUE']));?></button>
<?  }
	}else{
		if($arResult['PROPERTIES']['STOCK_STATUS']['VALUE'] == 22730){?>
							<button type="button" class="addCart button" id="button-cart" onclick="preorder()">Добавить в корзину</button>
<?  }else{?>
							<button type="button" class="addCart button" id="button-cart" onclick="miniup()">Добавить в корзину</button>
<?  }
	}?>
							<input type="hidden" name="<?=$arParams['ACTION_VARIABLE']?>" value="ADD2BASKET" />
							<input type="hidden" name="<?=$arParams['PRODUCT_ID_VARIABLE']?>" value="" />
							<input type="hidden" name="<?=$arParams["PRODUCT_QUANTITY_VARIABLE"] ?>" value="1" />
							<div id="<?=$itemIds['BASKET_PROP_DIV']?>" style="display: none;">
							<?if(!empty($arResult['PROPERTIES'])){
									foreach($arResult['PROPERTIES'] as $propId => $propInfo){?>
								<input type="hidden" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]" value="<?=htmlspecialcharsbx($propInfo['ID'])?>">
				<?  }
								}?>
							</div>
							<div class="addCart redbutton cart-success" style="display:none;">Добавлено <a href="/shopping-cart/">в корзину</a></div>
							<div class="addCart redbutton cart-error" style="display:none;">Укажите размер!</div>
						</form>
				<?/*
if($arResult['PROPERTIES']['STOCK_STATUS']['VALUE'] != 22730 && date(strtotime($arResult['PROPERTIES']['DATE_AVAILABLE']['VALUE'])) < strtotime("now")){?>
						<div class="pickup">
							<div class="pickup-item">
								<div class="popup" style="width: 100%">
									<a class="whitebutton">Забрать из магазина</a>
								</div>
								<div style="color:red" class="error">Выберите размер</div>
							</div>
						</div>
<?
}*/?>
					</div>
				</div>
			</div>
<div data-retailrocket-markup-block="57ea49939872e5765454b533" data-product-id="<?=$arResult['ID']?>"></div>
		</div>

		<div class="popup-container" id="oneclick_pickup">
			<a class="close" onclick="$('.fadeMe').trigger('click');">X</a>
			<div class="title"><p>БЫСТРЫЙ ЗАКАЗ С САМОВЫВОЗОМ&nbsp;В&nbsp;МАГАЗИН</p><br /></div>
			<p class="sub-title">По факту готовности заказа с вами свяжется оператор</p>
			<p class="info">Любой вопрос по заказу Вы можете задать по телефону:</p>
			<p class="tel"><a href="tel:+74952303084">+7 (495) 230-30-84</a></p>
			<br />
			<form data-adr="<?=$_SERVER['REQUEST_URI']?>" method="post">
				<table style="margin:10px auto;" class="oneclick-inorder">
					<tbody>
						<tr>
							<td colspan="2">
								<p id="choose" class="sub-title">Выберите магазин</p>
							</td>
						</tr>
						<tr>
							<td colspan="2" id="pickup_select">
				</td>
						</tr>
						<tr>
							<td colspan="2">
					<a href="/contacts-page/" style="text-transform: uppercase; font-weight: 200; border-bottom: 1px #f20113 dashed;">Адреса магазинов</a>
							</td>
			</tr>
						<tr>
							<td>Имя</td>
							<td><input type="text"  name="name" placeholder="Как в вам обратиться?" class="input-ongray isrequired" style="width:100%"></td>
						</tr>
						<tr>
							<td>Телефон</td>
							<td><input type="text" name="telephone" data-let-input="/^[0-9]+$/" data-let-phone="+7 (___) ___-__-__" placeholder="Телефон" class="input-ongray isrequired" style="width:100%"></td>
						</tr>
						<tr>
							<td colspan="2">
								<div class="privacy_check" style="margin: 15px 20px;">
									<input type="checkbox" checked name="agree" disabled value="1" />
									<label>Я прочитал и согласен с <a class="fancybox" target = "_blank"  href="/privacy/"><b>условиями</b></a></label>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="text-align:center;">
								<div class="redbutton" id="oneclickcart">Забрать в магазине</div>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="text-align:center;color:red">
								<p class="successmsg"></p>
								<p class="admitad"></p>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>

		<div class="popup-container" id="success_order">
			<a class="close" onclick="$('.fadeMe').trigger('click');">X</a>
			<div class="title"><p>СПАСИБО ЗА ПОКУПКУ!</p><br /></div>
			<div class="info"></div>
			<br />
			<p><a href="/shoes/" class="redbutton">Вернуться в магазин</a></p>
		</div>

<?//}?>
		<script>
			$("#Glide").glide({
				type: "carousel"
			});
			$(".size_grid_info_close").click(function(){
				$(".size_grid_info_container").slideUp();
			});
			$(".show_size_grid_trigger").click(function(){
				$(".size_grid_info_container").slideDown();
			});

			$(document).ready(function(){
				setTimeout(function(){
					var PSO = '.product-size-option';
					$(PSO).styler({
						onFormStyled:function(){
							$(PSO).parent('.jq-selectbox').find('.jq-selectbox__dropdown').find('li').each(function(){
								var t = $(this);
								var shopdata = t.data('shopdata');
								t.addClass('product-size-option-item');
								if(shopdata){
									t.append('<span>'+shopdata+'</span>');
								}
							});
						},
						onSelectOpened:function(){
							$(PSO).parent('.jq-selectbox').find('.jq-selectbox__dropdown').find('ul').css({
								'overflow-y':'',
								'overflow-x':'',
								'height':function(){
									return $(PSO).parent('.jq-selectbox').find('.jq-selectbox__dropdown').find('li').length * 32 +"px";
								},
								'max-height':function(){
									return $(PSO).parent('.jq-selectbox').find('.jq-selectbox__dropdown').find('li').length * 32 +"px";
								}
							});
						},
						onSelectClosed:function(){
							$('.cart').find('.cart-error').hide();
							$('.cart').find('.cart-success').hide();
							$('.cart').find('#button-cart').show();
						}
					});
					$('#product_color_link').styler();

					$(".colorSize .selectric-items").width($(".colorSize .selectric-wrapper").width());

					$("div.minImg").on("click", "a", function(e){
						e.preventDefault();
						$("div.minImg").removeClass("active");
						$(this).closest("div.minImg").addClass("active");
						$("div.bigImgBox img#image").attr("src", $(this).attr("href"));
					});
				}, 300);

				$('.success, .warning, .attention, information, .error').remove();
			<?if(date(strtotime($arResult['PROPERTIES']['DATE_AVAILABLE']['VALUE'])) > strtotime('now') && $arResult['PROPERTIES']['STOCK_STATUS']['VALUE'] != 22727 && $arResult['PROPERTIES']['STOCK_STATUS']['VALUE'] != 89319){?>
				$('.cart').find('.cart-error').html('В продаже с <?=date('d.m', strtotime($arResult['PROPERTIES']['DATE_AVAILABLE']['VALUE']));?>');
																																																								 /*$('.cart').find('.cart-error').show();*/
				$('.cart').find('.cart-success').hide();
				$(this).hide();
			<?}?>

				$(".colorSize .selectric-items ul li").click(function(){
					$('.cart').find('.cart-error').hide();
					$('.cart').find('.cart-success').hide();
					$('.cart').find('#button-cart').show();
				});

				$('select[name="option[34]"]').change(function(){
					$('.cart form input[name="id"]').val($(this).val());
					$(this).find('option').each(function() {
						if($(this).prop('selected') == true){
							$('#shops').html( $(this).attr('data-shopdata'));
						}
					});
					return false;
				});

				if($('input[name="id"]').val() == ''){
					if($('select[name="option[34]"]').children().length > 2){
					}else{
						$('select[name="option[34]"] :last').prop('selected',true);
			$('input[name="id"]').val($('select[name="option[34]"]').val());
						$(this).hide();
		}
				}else{
					$(this).hide();
				}
			});
						function preorder(){
							if($('input[name="id"]').val() == ''){
					if($('select[name="option[34]"]').children().length > 2){
												$('#button-cart').hide();
												$('.cart').find('.cart-error').show();
												$('.cart').find('.cart-success').hide();
												$(this).hide();
												return false;
											}
										}
							$.ajax({
								type: "post",
								url: '<?=$templateFolder?>/preorder.php',
								dataType: "html",
								data: $('#frm_add').serialize(),
								success: function(data){
									data = JSON.parse(data);
									if(data.status == 'ERROR'){
										$('.cart').find('.cart-error').html(data.text).show();
										$('#button-cart').hide();
									}else{
										$.ajax({
											type: "get",
											url: "/mini.php",
											dataType: "html",
											success: function(data){
											 				$("#topcart").html(data);
															$('.cart').find('.cart-success').show();
															$('#button-cart').hide();
										 	}
										});
									}
								}
							});
							return false;
						}
		</script>
		<?/*<script>
			$('#button-cart').bind('click', function() {
				var t = $(this);
				$.ajax({
					url: 'index.php?route=checkout/cart/add',
					type: 'post',
					data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
					dataType: 'json',
					success: function(json) {
					console.log(json);
						$('.success, .warning, .attention, information, .error').remove();
						if (json['error']) {
							if (json['error']['option']) {
								t.parent('.cart').find('.cart-error').show();
								t.parent('.cart').find('.cart-success').hide();
								t.hide();
							}
							if (json['error']['release']) {
								t.parent('.cart').find('.cart-error').html(json['error']['release']);
								t.parent('.cart').find('.cart-error').show();
								t.parent('.cart').find('.cart-success').hide();
								t.hide();
							}
						}
						if (json['success']) {
							t.parent('.cart').find('.cart-success').show();
							t.hide();
							t.parent('.cart').find('.cart-error').hide();
							if($('.header-cart').find('.cart-total').html() == '') {
								$('.header-cart').find('.cart-total').html(json['total']);
							} else {
								$('.header-cart').find(".ri-cart").html("<span class=\"cart-total\">"+json['total']+"</span></i>");
							}
							try { rrApi.addToBasket(18493) } catch(e) {}
							window.dataLayer = window.dataLayer || [];
							dataLayer.push({
								'ecommerce': {
									'currencyCode': 'RUB',
									'add': {
										'products': [{
										'name': '<?=$arResult["NAME"]?>',
										'id': '<?=$arResult["ID"]?>',
										'categoryId': '<?=$category["ID"]?>',
										'category': '<?=$category["NAME"]?>',
										'price': '<?=$price["RATIO_PRICE"]?>',
										'quantity': 1
									}]
								}
							},
							'event': 'gtm-ee-event',
							'gtm-ee-event-category': 'Enhanced Ecommerce',
							'gtm-ee-event-action': 'Adding a Product to a Shopping Cart',
							'gtm-ee-event-non-interaction': 'False'
						});
						}
					}
				});
			});
		</script>*/?>
		<script>
			(window["rrApiOnReady"] = window["rrApiOnReady"] || []).push(function(){
				try{ rrApi.view(<?=$arResult['ID']?>); } catch(e) {}
			});
		</script>
<script type="text/javascript">
var _tmr = _tmr || [];
_tmr.push({
		id: '3065581',
		type: 'itemView',
		productid: '<?=$arResult["ID"]?>',
		pagetype: 'product',
		list: '1',
		totalvalue: '<?=$price["RATIO_PRICE"]?>'
});
</script>
		<script>
			// required object
			window.ad_product = {
			"id": "<?=$arResult['ID']?>",
			"vendor": "<?=$brand['NAME']?>",
			"price": "<?=$price['RATIO_PRICE']?>",
			"url": "",
			"picture": "",
			"name": "<?=$arResult['NAME']?>",
			"category": "<?=$category['ID']?>"
			};
			window._retag = window._retag || [];
			window._retag.push({code: "9ce8886989", level: 2});
			(function () {
			var id = "admitad-retag";
			if (document.getElementById(id)) {return;}
			var s = document.createElement("script");
			s.async = true; s.id = id;
			var r = (new Date).getDate();
			s.src = (document.location.protocol == "https:" ? "https:" : "http:") + "//cdn.lenmit.com/static/js/retag.min.js?r="+r;
			var a = document.getElementsByTagName("script")[0]
			a.parentNode.insertBefore(s, a);
			})()
		</script>
		<!-- GTM -->
		<script>
			window.dataLayer = window.dataLayer || [];
			dataLayer.push({
				'ecommerce':{
					'currencyCode': 'RUB',
					'detail':{
						'products': [{
							'name': '<?=$arResult["NAME"]?>', // название товара
							'id': '<?=$arResult["ID"]?>', // id товара
							'categoryId': '<?=$category["ID"]?>', // id категории
							'category': '<?=$category["NAME"]?>',
							'price': '<?=$price["RATIO_PRICE"]?>' // цена товара
						}]
					}
				},
				'event': 'gtm-ee-event',
				'gtm-ee-event-category': 'Enhanced Ecommerce',
				'gtm-ee-event-action': 'Product Details',
				'gtm-ee-event-non-interaction': 'True',
			});
		</script>
		<script>
			$('.popup').click(function(){
				var t = $(this);
				var option =  $('.input-ongray .product-size-option option:selected').val();
				var html = '';
				var stores = [];
//        if(option == '')
//          $('.cart-error').html('Выберите размер');

				if(option == ''){
					$('#button-cart').hide();
					$('.cart-error').show();
					return false;
				}

<?foreach($arResult['STORES_MAP'] as $i=>$arr){?>
				var store = [];
<?  $a=0;
		foreach($arr as $it){?>
				var st=[]
				st['id'] = "<?=$it['ID'];?>";
				st['name']  = "<?=$it['NAME'];?>";
				store[<?=$a;?>]=st;
<?    $a++;
		}?>
				stores[<?=$i;?>] = store;
<?}?>
				var arr = stores[option];
				arr.forEach(function(item, i, arr){
					html += '<input type="radio" name="pickupshop" value="'+item['id']+'" />'+item['name']+' (Забрать сегодня)<br />';
				});
				//console.log(html);

				var popup = $('#oneclick_pickup');
				$('#pickup_select').html(html);
	popup.addClass('show');
	$('html, body').animate({
		scrollTop: popup.offset().top
	}, 2000);

				//$('.fadeMe').show();
				$('.fadeMe').on('click',function() {
		$('#pickup_select').html('');
		popup.removeClass('show');
		$('.fadeMe').hide();
		$('#pickup_select').empty();
				});
				$("input[name=pickupshop]:radio").click(function(){
					var id = $(this).val();
		$(document.body).find(".address .item").each(function(){
				if($(this).attr('id') == id){
							$(this).css('display', 'block');
			}else{
							$(this).css('display', 'none');
						}
					});
	});
			});
		</script>
		<script>
			$(document.body).on("focus", ".isrequired", function(){$(this).css("border","");});
			$("#oneclickcart").click(function(){
			id = $('.cart').find('[name=id]').val();
			name = $('#oneclick_pickup').find('[name=name]').val();
			phone = $('#oneclick_pickup').find('[name=telephone]').val();
			shop = $('#oneclick_pickup').find('[name=pickupshop]').val();
				event.preventDefault();
				var wri = $("#oneclick_pickup");
				//var wrp = $(".cart-info");
				var validate = true;
				wri.find(".isrequired").each(function(){
					if(!$(this).val().length){validate = false; $(this).css("border","1px solid #D22")}
				});
				if(!$("input[type=\'radio\']:checked" ).val()){
 		validate = false;
		$('#choose').css("color","#D22");
	}
				if (validate){
					$("#oneclickcart").hide();
					wri.find('.successmsg').html("Пожалуйста, подождите");
					wri.find('.successmsg').show();
					$.ajax({
						url: '<?=$templateFolder?>/confirm_pickup.php',
						type: 'post',
						data: 'id='+id+'&shop='+shop+'&name='+name+'&phone='+phone,
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
<?
if ($haveOffers)
{
	$offerIds = array();
	$offerCodes = array();

	$useRatio = $arParams['USE_RATIO_IN_RANGES'] === 'Y';

	foreach ($arResult['JS_OFFERS'] as $ind => &$jsOffer)
	{
		$offerIds[] = (int)$jsOffer['ID'];
		$offerCodes[] = $jsOffer['CODE'];

		$fullOffer = $arResult['OFFERS'][$ind];
		$measureName = $fullOffer['ITEM_MEASURE']['TITLE'];

		$strAllProps = '';
		$strMainProps = '';
		$strPriceRangesRatio = '';
		$strPriceRanges = '';

		if ($arResult['SHOW_OFFERS_PROPS'])
		{
			if (!empty($jsOffer['DISPLAY_PROPERTIES']))
			{
				foreach ($jsOffer['DISPLAY_PROPERTIES'] as $property)
				{
					$current = '<dt>'.$property['NAME'].'</dt><dd>'.(
						is_array($property['VALUE'])
							? implode(' / ', $property['VALUE'])
							: $property['VALUE']
						).'</dd>';
					$strAllProps .= $current;

					if (isset($arParams['MAIN_BLOCK_OFFERS_PROPERTY_CODE'][$property['CODE']]))
					{
						$strMainProps .= $current;
					}
				}

				unset($current);
			}
		}

		if ($arParams['USE_PRICE_COUNT'] && count($jsOffer['ITEM_QUANTITY_RANGES']) > 1)
		{
			$strPriceRangesRatio = '('.Loc::getMessage(
					'CT_BCE_CATALOG_RATIO_PRICE',
					array('#RATIO#' => ($useRatio
							? $fullOffer['ITEM_MEASURE_RATIOS'][$fullOffer['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']
							: '1'
						).' '.$measureName)
				).')';

			foreach ($jsOffer['ITEM_QUANTITY_RANGES'] as $range)
			{
				if ($range['HASH'] !== 'ZERO-INF')
				{
					$itemPrice = false;

					foreach ($jsOffer['ITEM_PRICES'] as $itemPrice)
					{
						if ($itemPrice['QUANTITY_HASH'] === $range['HASH'])
						{
							break;
						}
					}

					if ($itemPrice)
					{
						$strPriceRanges .= '<dt>'.Loc::getMessage(
								'CT_BCE_CATALOG_RANGE_FROM',
								array('#FROM#' => $range['SORT_FROM'].' '.$measureName)
							).' ';

						if (is_infinite($range['SORT_TO']))
						{
							$strPriceRanges .= Loc::getMessage('CT_BCE_CATALOG_RANGE_MORE');
						}
						else
						{
							$strPriceRanges .= Loc::getMessage(
								'CT_BCE_CATALOG_RANGE_TO',
								array('#TO#' => $range['SORT_TO'].' '.$measureName)
							);
						}

						$strPriceRanges .= '</dt><dd>'.($useRatio ? $itemPrice['PRINT_RATIO_PRICE'] : $itemPrice['PRINT_PRICE']).'</dd>';
					}
				}
			}

			unset($range, $itemPrice);
		}

		$jsOffer['DISPLAY_PROPERTIES'] = $strAllProps;
		$jsOffer['DISPLAY_PROPERTIES_MAIN_BLOCK'] = $strMainProps;
		$jsOffer['PRICE_RANGES_RATIO_HTML'] = $strPriceRangesRatio;
		$jsOffer['PRICE_RANGES_HTML'] = $strPriceRanges;
	}

	$templateData['OFFER_IDS'] = $offerIds;
	$templateData['OFFER_CODES'] = $offerCodes;
	unset($jsOffer, $strAllProps, $strMainProps, $strPriceRanges, $strPriceRangesRatio, $useRatio);

	$jsParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => true,
			'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
			'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
			'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
			'OFFER_GROUP' => $arResult['OFFER_GROUP'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
			'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
			'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
			'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
			'USE_STICKERS' => true,
			'USE_SUBSCRIBE' => $showSubscribe,
			'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
			'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
			'ALT' => $alt,
			'TITLE' => $title,
			'MAGNIFIER_ZOOM_PERCENT' => 200,
			'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
			'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
			'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
				? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
				: null
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'VISUAL' => $itemIds,
		'DEFAULT_PICTURE' => array(
			'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
			'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
		),
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'ACTIVE' => $arResult['ACTIVE'],
			'NAME' => $arResult['~NAME'],
			'CATEGORY' => $arResult['CATEGORY_PATH']
		),
		'BASKET' => array(
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'BASKET_URL' => $arParams['BASKET_URL'],
			'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		),
		'OFFERS' => $arResult['JS_OFFERS'],
		'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
		'TREE_PROPS' => $skuProps
	);
}
else
{
	$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
	if ($arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y' && !$emptyProductProperties)
	{
		?>
		<div id="<?=$itemIds['BASKET_PROP_DIV']?>" style="display: none;">
			<?
			if (!empty($arResult['PRODUCT_PROPERTIES_FILL']))
			{
				foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propId => $propInfo)
				{
					?>
					<input type="hidden" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]" value="<?=htmlspecialcharsbx($propInfo['ID'])?>">
					<?
					unset($arResult['PRODUCT_PROPERTIES'][$propId]);
				}
			}

			$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
			if (!$emptyProductProperties)
			{
				?>
				<table>
					<?
					foreach ($arResult['PRODUCT_PROPERTIES'] as $propId => $propInfo)
					{
						?>
						<tr>
							<td><?=$arResult['PROPERTIES'][$propId]['NAME']?></td>
							<td>
								<?
								if (
									$arResult['PROPERTIES'][$propId]['PROPERTY_TYPE'] === 'L'
									&& $arResult['PROPERTIES'][$propId]['LIST_TYPE'] === 'C'
								)
								{
									foreach ($propInfo['VALUES'] as $valueId => $value)
									{
										?>
										<label>
											<input type="radio" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]"
												value="<?=$valueId?>" <?=($valueId == $propInfo['SELECTED'] ? '"checked"' : '')?>>
											<?=$value?>
										</label>
										<br>
										<?
									}
								}
								else
								{
									?>
									<select name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]">
										<?
										foreach ($propInfo['VALUES'] as $valueId => $value)
										{
											?>
											<option value="<?=$valueId?>" <?=($valueId == $propInfo['SELECTED'] ? '"selected"' : '')?>>
												<?=$value?>
											</option>
											<?
										}
										?>
									</select>
									<?
								}
								?>
							</td>
						</tr>
						<?
					}
					?>
				</table>
				<?
			}
			?>
		</div>
		<?
	}

	$jsParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => !empty($arResult['ITEM_PRICES']),
			'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
			'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
			'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
			'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
			'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
			'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
			'USE_STICKERS' => true,
			'USE_SUBSCRIBE' => $showSubscribe,
			'ALT' => $alt,
			'TITLE' => $title,
			'MAGNIFIER_ZOOM_PERCENT' => 200,
			'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
			'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
			'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
				? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
				: null
		),
		'VISUAL' => $itemIds,
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'ACTIVE' => $arResult['ACTIVE'],
			'PICT' => reset($arResult['MORE_PHOTO']),
			'NAME' => $arResult['~NAME'],
			'SUBSCRIPTION' => true,
			'ITEM_PRICE_MODE' => $arResult['ITEM_PRICE_MODE'],
			'ITEM_PRICES' => $arResult['ITEM_PRICES'],
			'ITEM_PRICE_SELECTED' => $arResult['ITEM_PRICE_SELECTED'],
			'ITEM_QUANTITY_RANGES' => $arResult['ITEM_QUANTITY_RANGES'],
			'ITEM_QUANTITY_RANGE_SELECTED' => $arResult['ITEM_QUANTITY_RANGE_SELECTED'],
			'ITEM_MEASURE_RATIOS' => $arResult['ITEM_MEASURE_RATIOS'],
			'ITEM_MEASURE_RATIO_SELECTED' => $arResult['ITEM_MEASURE_RATIO_SELECTED'],
			'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
			'SLIDER' => $arResult['MORE_PHOTO'],
			'CAN_BUY' => $arResult['CAN_BUY'],
			'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
			'QUANTITY_FLOAT' => is_float($arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']),
			'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],
			'STEP_QUANTITY' => $arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'],
			'CATEGORY' => $arResult['CATEGORY_PATH']
		),
		'BASKET' => array(
			'ADD_PROPS' => $arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y',
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
			'EMPTY_PROPS' => $emptyProductProperties,
			'BASKET_URL' => $arParams['BASKET_URL'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		)
	);
	unset($emptyProductProperties);
}

if ($arParams['DISPLAY_COMPARE'])
{
	$jsParams['COMPARE'] = array(
		'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
		'COMPARE_DELETE_URL_TEMPLATE' => $arResult['~COMPARE_DELETE_URL_TEMPLATE'],
		'COMPARE_PATH' => $arParams['COMPARE_PATH']
	);
}
?>
<script>
	BX.message({
		ECONOMY_INFO_MESSAGE: '<?=GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO2')?>',
		TITLE_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR')?>',
		TITLE_BASKET_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS')?>',
		BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR')?>',
		BTN_SEND_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS')?>',
		BTN_MESSAGE_BASKET_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT')?>',
		BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE')?>',
		BTN_MESSAGE_CLOSE_POPUP: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP')?>',
		TITLE_SUCCESSFUL: '<?=GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK')?>',
		COMPARE_MESSAGE_OK: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK')?>',
		COMPARE_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR')?>',
		COMPARE_TITLE: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE')?>',
		BTN_MESSAGE_COMPARE_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT')?>',
		PRODUCT_GIFT_LABEL: '<?=GetMessageJS('CT_BCE_CATALOG_PRODUCT_GIFT_LABEL')?>',
		PRICE_TOTAL_PREFIX: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_PRICE_TOTAL_PREFIX')?>',
		RELATIVE_QUANTITY_MANY: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY'])?>',
		RELATIVE_QUANTITY_FEW: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW'])?>',
		SITE_ID: '<?=SITE_ID?>'
	});

	var <?=$obName?> = new JCCatalogElement(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
</script>
<?unset($actualItem, $itemIds, $jsParams);?>
<script src="<?=SITE_TEMPLATE_PATH?>/js/let.min.js"></script>
<script>
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

function miniup(){
console.log($(".sizes-chart-item.selected").data('id'));
	if($(".sizes-chart-item.selected").data('id')){
$('input[name="id"]').val($('.sizes-chart-item.selected').data('id'));
	}else{
	$('#button-cart').hide();
			$('.cart').find('.cart-error').show();
			$('.cart').find('.cart-success').hide();
			$(this).hide();
			return false;
}
	/*  if($('.cart form input[name="id"]').val() == ''){
		if($('select[name="option[34]"]').children().length > 2){
			$('#button-cart').hide();
			$('.cart').find('.cart-error').show();
			$('.cart').find('.cart-success').hide();
			$(this).hide();
			return false;
		}else{

				$('input[name="id"]').val($('.sizes-chart-item').data('id'))



}
	}*/
console.log($("#frm_add").data('adr'));
console.log($("#frm_add").serialize());
	$.ajax({
	type: "POST",
	url: $("#frm_add").data('adr'),
				data:$("#frm_add").serialize(),
				dataType: "html",
				success: function(out){
		$.ajax({
									type: "GET",
			url: "/mini.php",
									dataType: "html",
									success: function(out){
													$(".header .iconsBox a.cart").html(out);
							$('.cart').find('.cart-success').show();
							$('#button-cart').hide();
												}
							 });
				}
	});
	return false;
}
</script>