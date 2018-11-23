<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");
CModule::IncludeModule("sale");

foreach($arResult['FAVORITES'] as $i=>$arItem){
    	$img = CFile::ResizeImageGet($arItem['ELEMENT']['PREVIEW_PICTURE'], array('width'=>58, 'height'=>58), BX_RESIZE_IMAGE_PROPORTIONAL, false); 
        $arResult['FAVORITES'][$i]['ELEMENT']['PREVIEW_PICTURE'] = $img['src'];
	$arResult['FAVORITES'][$i]['OFFERS'] = array();
	$offers = CIBlockPriceTools::GetOffersArray(array('IBLOCK_ID'=>2,'HIDE_NOT_AVAILABLE'=>'Y'), array($arItem['ELEMENT_ID']), array(), array('ID','IBLOCK_ID','CATALOG_QUANTITY','CATALOG_AVAILABLE'), array('SIZES_SHOES'), 0, null, null, array('CURRENCY_ID'=>'RUB'));
	if(count($offers) > 0){
		foreach($offers as $offer){
			if($offer['CATALOG_QUANTITY'] > 0){
				$arResult['FAVORITES'][$i]['OFFERS'][] = array('ID'=>$offer['ID'],'NAME'=>strip_tags($offer['DISPLAY_PROPERTIES']['SIZES_SHOES']['DISPLAY_VALUE']));
				
                        	CCatalogProduct::setUseDiscount(true);
	                        $price = CCatalogProduct::GetOptimalPrice($offer['ID'], 1, array(), "N");
				$arResult['FAVORITES'][$i]['PRICE'] = $price['DISCOUNT_PRICE'];
			
				$arResult['FAVORITES'][$i]['STORES'] = array();		
				$rs = CCatalogStoreProduct::GetList(array('SORT'=>'ASC'), array('ACTIVE'=>'Y','PRODUCT_ID'=>$offer['ID']), false, false, array('ID','STORE_NAME','AMOUNT'));
				while($store = $rs->GetNext()){
			   		if($store['AMOUNT'] > 0){
						$arResult['FAVORITES'][$i]['STORES'][] = array('ID'=>$store['ID'],'NAME'=>$store['STORE_NAME']);
					}
		  		}               
			}
		}
		usort($arResult['FAVORITES'][$i]['OFFERS'], function($a, $b){
		    return $a['NAME'] > $b['NAME'] ? 1 : -1;
		});     

        	$status = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>18,'ACTIVE'=>'Y','ID'=>$arItem['ELEMENT']['PROPERTIES']['STOCK_STATUS']['VALUE']), false, false, array('NAME'))->GetNext()['NAME'];
        	if(count($arResult['FAVORITES'][$i]['STORES']) == 0){
			$arResult['FAVORITES'][$i]['STOCK_STATUS'] = $status;
		}else{
			$arResult['FAVORITES'][$i]['STOCK_STATUS'] = 'В наличии';
		}			
	}

}
