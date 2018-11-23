<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->createFrame()->begin("");
?>
<div class="wishlist-info"><?
	if(is_array($arResult['ERRORS']['FATAL']) && !empty($arResult['ERRORS']['FATAL'])):?>

		<?foreach($arResult['ERRORS']['FATAL'] as $error):?>
			<?=ShowError($error)?>
		<?endforeach?>

	<?elseif(is_array($arResult["FAVORITES"]) && !empty($arResult['FAVORITES'])):?>

		<?if(is_array($arResult['ERRORS']['NONFATAL']) && !empty($arResult['ERRORS']['NONFATAL'])):?>

			<?foreach($arResult['ERRORS']['NONFATAL'] as $error):?>
				<?=ShowError($error)?>
			<?endforeach?>

		<?endif?>

		<?if($arParams["DISPLAY_TOP_PAGER"]):?>
			<?=$arResult["NAV_STRING"]?>
		<?endif;?>
		<table>
			<!--<thead>
				<tr>
					<th><?=GetMessage("H2O_FAVORITES_FIELD_DATE_INSERT")?></th>
					<th><?=GetMessage("H2O_FAVORITES_FIELD_ELEMENT")?></th>
					<th><?=GetMessage("H2O_FAVORITES_FIELD_DELETE")?></th>
				</tr>
 			</thead>-->
			<tbody>
			<?foreach($arResult["FAVORITES"] as $arItem):?>
				<tr id="row<?=$arItem['ID']?>">
					<td class="image">
						<a href="<?=$arItem['ELEMENT']['DETAIL_PAGE_URL']?>"><img src="<?=$arItem['ELEMENT']['PREVIEW_PICTURE']?>" alt="<?=$arItem['ELEMENT']['NAME']?>" /></a>
					</td>
					<td class="name">
						<a href="<?=$arItem['ELEMENT']['DETAIL_PAGE_URL']?>"><?=$arItem['ELEMENT']['NAME']?></a>
					</td>
					<td class="option-select">
						<select name="option[34]">
						<?foreach($arItem['OFFERS'] as $offer){?>
							<option value="<?=$offer['ID']?>"><?=$offer['NAME']?></option>
						<?}?>
						</select><br />
<!--
						<select name="store">
						<?foreach($arItem['STORES'] as $store){?>
							<option value="<?=$store['ID']?>"><?=$store['NAME']?></option>
						<?}?>
						</select>
						<div class="option_errors" style="color:red"></div>-->
					</td>
					<td class="price">
						<div class="price">
						<?if(($arItem['ELEMENT']['PROPERTIES']['SALE']['VALUE'] == 'да') && ($DB->CompareDates($arItem['ELEMENT']['PROPERTIES']['SPECIAL_DATE']['VALUE'], date('d.m.Y')) == -1) && ($arItem['ELEMENT']['PROPERTIES']['SPECIAL_PRICE']['VALUE'] < $arItem['PRICE'])){?>
							<s><?=$arItem['PRICE']?></s>
							<b><?=number_format($arItem['ELEMENT']['PROPERTIES']['SPECIAL_PRICE']['VALUE'], 0, '.', '');?></b>
						<?}else{?>
							<?=$arItem['PRICE']?>
						<?}?>
						</div>
						<?/*
						<form method="post" id="frm_add" data-adr="<?=$_SERVER['REQUEST_URI']?>">
							<input type="hidden" name="action" value="ADD2BASKET" />       							
					                <input type="hidden" name="id" value="" />          
					                <input type="hidden" name="quantity" value="1" />                
							<div id="basket_prop_<?=$arItem['ELEMENT_ID']?>" style="display:none;">
							<?foreach($arItem['ELEMENT']['PROPERTIES'] as $prop){?>
					 		  <input type="hidden" name="prop[<?=$prop['CODE']?>]" value="<?=htmlspecialcharsbx($prop['ID'])?>" />
							<?}?>
							</div>
						</form>
*/?>
					</td>
					<td class="stock">
						<?=$arItem['STOCK_STATUS']?>
					</td>
	                                <td>
<?/*
						<a class="checkout_addtocart" data-id="<?=$arItem['ID']?>">
							<img src="<?=SITE_TEMPLATE_PATH?>/images/add_to_cart_text_img.png" alt="addtocart" />
						</a>
						<a class="checkout_removefromcart" data-id="<?=$arItem['ID']?>" title="<?=GetMessage("H2O_FAVORITES_DELETE_ITEM")?>">
							<img src="<?=SITE_TEMPLATE_PATH?>/images/delicon-cart.png" alt="<?=GetMessage("H2O_FAVORITES_DELETE_ITEM")?>" />
						</a>
*/?>
					</td>
				</tr>
			<?endforeach;?>
			</tbody>
		</table>
		<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
			<br /><?=$arResult["NAV_STRING"]?>
		<?endif;?>

	<?else:?>
		<?=GetMessage("H2O_FAVORITES_EMPTY_LIST");?>
	<?endif;?>
</div>