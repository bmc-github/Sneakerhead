<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $item
 * @var array $actualItem
 * @var array $minOffer
 * @var array $itemIds
 * @var array $price
 * @var array $measureRatio
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var array $morePhoto
 * @var bool $showSlider
 * @var string $imgTitle
 * @var string $productTitle
 * @var string $buttonSizeClass
 * @var CatalogSectionComponent $component
 */
	$curPage = $APPLICATION->GetCurPage(false);
	$cat = CIBlockSection::GetByID($item['~IBLOCK_SECTION_ID'])->GetNext(false,false);
	$brand = CIBlockElement::GetByID($item['PROPERTIES']['BRAND']['VALUE'])->GetNext(false,false);
	$cat_ = $item['PROPERTIES']['CATEGORY']['VALUE']?:$cat['NAME'];
?>
								<div class="item" onclick="return productClick('<?=$item['IBLOCK_SECTION_ID']?>' , '0' , '<?=$item['ID']?>')">
									<a href="<?=$item['DETAIL_PAGE_URL']?>">
<?if($item['PROPERTIES']['ISNEW']['VALUE'] == 'да' && $curPage != '/'){?>
										<span class="new-label"><?=Loc::getMessage('LIST_NEW');?></span>
<?}?>
<?if (($arParams['SHOW_OLD_PRICE'] == 'Y') && ($item['PROPERTIES']['SALE']['VALUE'] == 'да') && ($item['PROPERTIES']['SPECIAL_PRICE']['VALUE'] > 0) && (strtotime($item['PROPERTIES']['SPECIAL_DATE']['VALUE']) < strtotime("now"))) {

$percent_todisp = 100 - round($price['RATIO_BASE_PRICE']*100/$item['PROPERTIES']['SPECIAL_PRICE']['VALUE'], -1, PHP_ROUND_HALF_DOWN);
?><span class="discount-badge">-<? echo $percent_todisp; ?>%</span>
<?php }?>
										<div class="img">
							<?php if (date(strtotime($item['PROPERTIES']['DATE_AVAILABLE']['VALUE'])) > strtotime("now")) {   ?>
								<?php if(($item['PROPERTIES']['STOCK_STATUS']['VALUE'] == 22727 || $item['PROPERTIES']['STOCK_STATUS']['VALUE'] == 89319 )) { ?>
									<div style = "position: absolute; bottom: 115px; width: 100%; text-align: center; height: 62px;margin:0; background: #F20113; opacity: 0.5; color: #fff;padding: 18px;">

										<p style="opacity: 1.0; font-size: 20px;font-weight: 300" >ПРЕДЗАКАЗ</p>
									</div>
								<?php } else {?>
							<div style = "position: absolute; bottom: 115px; width: 100%; text-align: center; height: 62px;margin:0; background: #F20113; opacity: 0.5; color: #fff;padding: 10px;">
								<p style="opacity: 1.0;font-size: 12px" >СТАРТ ПРОДАЖ: </p>
								<p style="opacity: 1.0; font-size: 20px;font-weight: 300" ><?php echo date('d.m.Y', strtotime($item['PROPERTIES']['DATE_AVAILABLE']['VALUE'])); ?></p>
							</div>
						<?php } } ?>
											<img class="lazy" src="<?=$item['PREVIEW_PICTURE']['SRC']?>" data-original="<?=$item['PREVIEW_PICTURE']['SRC']?>" alt="" />
										</div>
										<div style="height:auto">
											<p class="category"><?=$cat_?></p>
											<p class="brand"><?=$brand['NAME']?></p>
											<p class="title"><?=$item['NAME']?></p>
											<p class="price">
<?if(($arParams['SHOW_OLD_PRICE'] == 'Y') && ($item['PROPERTIES']['SALE']['VALUE'] == 'да') && ($item['PROPERTIES']['SPECIAL_PRICE']['VALUE'] >0) && (strtotime($item['PROPERTIES']['SPECIAL_DATE']['VALUE']) < strtotime("now"))){?>
												<span class="price-old"><?=number_format($item['PROPERTIES']['SPECIAL_PRICE']['VALUE'],0,'','');?> <i class="fa fa-rub"></i></span>
												<span class="price-new"><?=$price['BASE_PRICE']?> <i class="fa fa-rub"></i></span>
<?}else{?>
						<?=$price['BASE_PRICE']?> <i class="fa fa-rub"></i>
<?}?>
											</p>
										</div>

									</a>
								</div>