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
?>
<?$cat = CIBlockSection::GetByID($item['~IBLOCK_SECTION_ID'])->GetNext(false,false);
  $brand = CIBlockElement::GetByID($item['PROPERTIES']['BRAND']['VALUE'])->GetNext(false,false);
  $cat_ = $item['PROPERTIES']['CATEGORY']['VALUE']?:$cat['NAME'];
  $curPage = $APPLICATION->GetCurPage(false);
?>
              <div class="col-xs-<?=($curPage=='/search/')?3:4?>" itemprop="itemListElement" itemscope itemtype="http://schema.org/Offer">
                <div class="metro-link-product metro-link" itemprop="itemOffered" itemscope itemtype="http://schema.org/Product">
                  <meta itemprop="name" content="<?=$item['NAME']?>" />
                  <meta itemprop="description" content="<?=$cat_.' '.$brand['NAME'].' '.$item['NAME']?>" />
                  <meta itemprop="sku" content="<?=$item['PROPERTIES']['ARTNUMBER']['VALUE']?>" />
                  <meta itemprop="category" content="<?=$cat_?>" />
                  <meta itemprop="manufacturer" content="<?=$brand['NAME']?>" />
	        
                  <div class="metro-link-product-borderfix">
<?if($item['PROPERTIES']['ISNEW']['VALUE'] == 'да' && $curPage != '/'){?>
                    <span class="product_isnew"><?=Loc::getMessage('LIST_NEW');?></span>
<?}if (($arParams['SHOW_OLD_PRICE'] == 'Y') && ($item['PROPERTIES']['SALE']['VALUE'] == 'да') && ($item['PROPERTIES']['SPECIAL_PRICE']['VALUE'] > 0) && (strtotime($item['PROPERTIES']['SPECIAL_DATE']['VALUE']) < strtotime("now"))) { 

$percent_todisp = 100 - round($price['RATIO_BASE_PRICE']*100/$item['PROPERTIES']['SPECIAL_PRICE']['VALUE'], -1, PHP_ROUND_HALF_DOWN);
?><span class="product_discount">-<? echo $percent_todisp; ?>%</span>
<?php }?>             
                    <a href="<?=$item['DETAIL_PAGE_URL']?>">
                    <?
                    $img = CFile::ResizeImageGet($item['PREVIEW_PICTURE']['ID'], array('width'=>296, 'height'=>296), BX_RESIZE_IMAGE_EXACT , true);
                    ?>
                      <img itemprop="image" class="metro-link-product-image lazy" src="<?=$img['src']?>" alt="" data-original="<?=$img['src']?>" onclick="return productClick('<?=$cat['ID']?>' , '0' , '<?=$item['ID']?>')" />       
<?if(date(strtotime($item['PROPERTIES']['DATE_AVAILABLE']['VALUE'])) > strtotime("now")){?>
								<?php if(($item['PROPERTIES']['STOCK_STATUS']['VALUE'] == 22727 || $item['PROPERTIES']['STOCK_STATUS']['VALUE'] == 89319 )) { ?>

	              <div style="position:absolute;text-align:center;bottom:79px;width:296px;height:62px;margin:0;background:#F20113;opacity:.5;color:#fff;padding:18px;">
	                <p style="opacity:1;font-size:20px;font-weight:300">ПРЕДЗАКАЗ</p>
	              </div>
<?php } else {?>
<div style="position:absolute;text-align:center;bottom:79px;width:296px;height:62px;margin:0;background:#F20113;opacity:.5;color:#fff;padding:18px;">
	                <p style="opacity: 1.0;font-size: 12px" >СТАРТ ПРОДАЖ: </p>
                <p style="opacity: 1.0; font-size: 20px;font-weight: 300" ><?php echo date('d.m.Y', strtotime($item['PROPERTIES']['DATE_AVAILABLE']['VALUE'])); ?></p>
	              </div>
<?}
																						}?>
                    </a>
                    <div class="metro-link-product-right" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
<?if(($arParams['SHOW_OLD_PRICE'] == 'Y') && ($item['PROPERTIES']['SALE']['VALUE'] == 'да') && ($item['PROPERTIES']['SPECIAL_PRICE']['VALUE'] > 0) && (strtotime($item['PROPERTIES']['SPECIAL_DATE']['VALUE']) < strtotime("now"))){?>
	              <p><span class="oldprice"><?=number_format($item['PROPERTIES']['SPECIAL_PRICE']['VALUE'],0,'','');?></span></p>
<?}?>
		      <p class="metro-link-product-price"><?=$price['RATIO_BASE_PRICE']?> <i class="fa fa-rub"></i></p>
		      <meta itemprop="price" content="<?=$price['RATIO_BASE_PRICE']?>" />
                      <meta itemprop="priceCurrency" content="RUB" />
                      <link itemprop="availability" href="http://schema.org/InStock" />
		    </div>
                    <div class="metro-link-product-left">
                      <a class="metro-link-product-subtitle" itemprop="url" href="<?=$item['DETAIL_PAGE_URL']?>" onclick="return productClick('<?=$cat['ID']?>' , '0' , '<?=$item['ID']?>')">
                        <?=$cat_?>
                        <span class="prod-manuf-name"><?=$brand['NAME']?></span>
                        <?=$item['NAME']?>
                      </a>
                    </div>
                    <div class="clearfix"></div>                                                                                 
                  </div>
                  <div class="metro-link-product-hover">
                    <table>
                      <tbody>
                        <tr>
                          <td>
                          <?foreach($arParams['SKU_PROPS'] as $skuProperty){
                              $propertyId = $skuProperty['ID'];
                              $skuProperty['NAME'] = htmlspecialcharsbx($skuProperty['NAME']);
                              if(!isset($item['SKU_TREE_VALUES'][$propertyId]))
                                continue;
                          ?>
                            <ul class="metro-link-product-sizes font12">
                            <?$item['offers'] = array();
                              foreach($skuProperty['VALUES'] as $value){
                                if(!isset($item['SKU_TREE_VALUES'][$propertyId][$value['ID']]))
				  continue;
                                //$value['NAME'] = htmlspecialcharsbx($value['NAME']);
                                $item['offers'][] = $value['NAME'];
                              }
                              usort($item['offers'], function($a, $b){
                                return $a > $b ? 1 : -1;
                              });
                              foreach($item['offers'] as $it){
                            ?>
                              <li><?=$it?><?//=$value['NAME']?></li>
                            <?}?>
                            </ul>
                          <?}?>
                          </td>
                          <td class="text-right">
                            <a data-id="<?=$item['ID']?>" class="favorite-add">
                            <?=Loc::getMessage('LIST_WISHLIST');?> <i class="fa fa-star-o"></i></a>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
<?$gtm[] = "{
			'id': '" . $item['ID'] . "' ,
			'categoryId': '" . $cat['ID'] . "',
			'list': '',
			'position': '0'
	     }";
?>