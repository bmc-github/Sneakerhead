<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */
CModule::IncludeModule("catalog");

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

$brand = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>6,'ID'=>$arResult['DISPLAY_PROPERTIES']['BRAND']['VALUE']), false, false, array('ID','IBLOCK_ID','NAME','DETAIL_PAGE_URL','PROPERTY_SIZE_CHART','PROPERTY_SIZE_TABLES'))->GetNext(false,false);
$category = CIBlockSection::GetByID($arResult['~IBLOCK_SECTION_ID'])->GetNext(false,false);
$stock_status = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>18,'ID'=>$arResult['PROPERTIES']['STOCK_STATUS']['VALUE']), false, false, array('PREVIEW_TEXT'))->GetNext(false,false);

global $DB;
$strSql = "SELECT * FROM cat_category_sizecharts WHERE brand_id=" . $brand['EXTERNAL_ID'];
$res = $DB->Query($strSql, false, $err_mess . __line__);
$sizes_u = array();
while($arElement = $res->GetNext())
    $sizes_u[] = $arElement;

if(empty($sizes_u)) {
    $sizes_u = array(
        array(
            'US' => '4',
            'UK' => '3',
            'EUR' => '37',
            'RUS' => '36',
            'CM' => '22'),
        array(
            'US' => '4.5',
            'UK' => '3.5',
            'EUR' => '37.5',
            'RUS' => '36.5',
            'CM' => '22.5'),
        array(
            'US' => '5',
            'UK' => '4',
            'EUR' => '38',
            'RUS' => '37',
            'CM' => '23'),
        array(
            'US' => '5.5',
            'UK' => '4.5',
            'EUR' => '38.5',
            'RUS' => '37.5',
            'CM' => '23.5'),
        array(
            'US' => '6',
            'UK' => '5',
            'EUR' => '39',
            'RUS' => '38',
            'CM' => '24'),
        array(
            'US' => '6.5',
            'UK' => '5.5',
            'EUR' => '39.5',
            'RUS' => '38.5',
            'CM' => '24.5'),
        array(
            'US' => '7',
            'UK' => '6',
            'EUR' => '40',
            'RUS' => '39',
            'CM' => '25'),
        array(
            'US' => '7.5',
            'UK' => '6.5',
            'EUR' => '40.5',
            'RUS' => '39.5',
            'CM' => '25.5'),
        array(
            'US' => '8',
            'UK' => '7',
            'EUR' => '41',
            'RUS' => '40',
            'CM' => '26'),
        array(
            'US' => '8.5',
            'UK' => '7.5',
            'EUR' => '42',
            'RUS' => '41',
            'CM' => '26.5'),
        array(
            'US' => '9',
            'UK' => '8',
            'EUR' => '42.5',
            'RUS' => '41.5',
            'CM' => '27'),
        array(
            'US' => '9.5',
            'UK' => '8.5',
            'EUR' => '43',
            'RUS' => '42',
            'CM' => '27.5'),
        array(
            'US' => '10',
            'UK' => '9',
            'EUR' => '44',
            'RUS' => '43',
            'CM' => '28'),
        array(
            'US' => '10.5',
            'UK' => '9.5',
            'EUR' => '44.5',
            'RUS' => '43.5',
            'CM' => '28.5'),
        array(
            'US' => '11',
            'UK' => '10',
            'EUR' => '45',
            'RUS' => '44',
            'CM' => '29'),
        array(
            'US' => '11.5',
            'UK' => '10.5',
            'EUR' => '45.5',
            'RUS' => '44.5',
            'CM' => '29.5'),
        array(
            'US' => '12',
            'UK' => '11',
            'EUR' => '46',
            'RUS' => '45',
            'CM' => '30'),
        array(
            'US' => '12.5',
            'UK' => '11.5',
            'EUR' => '47',
            'RUS' => '46',
            'CM' => '30.5'),
        array(
            'US' => '13',
            'UK' => '12',
            'EUR' => '47.5',
            'RUS' => '46.5',
            'CM' => '31'),
        array(
            'US' => '13.5',
            'UK' => '12.5',
            'EUR' => '48',
            'RUS' => '47',
            'CM' => '31.5'),
        array(
            'US' => '14',
            'UK' => '13',
            'EUR' => '48.5',
            'RUS' => '47.5',
            'CM' => '32'),
        array(
            'US' => '15',
            'UK' => '14',
            'EUR' => '49.5',
            'RUS' => '48.5',
            'CM' => '33'),
        array(
            'US' => '16',
            'UK' => '15',
            'EUR' => '50.5',
            'RUS' => '49.5',
            'CM' => '34'),
        array(
            'US' => '17',
            'UK' => '16',
            'EUR' => '51.5',
            'RUS' => '50.5',
            'CM' => '35'),
        array(
            'US' => '18',
            'UK' => '17',
            'EUR' => '52.5',
            'RUS' => '51.5',
            'CM' => '36'));
}

foreach($arResult['SKU_PROPS'] as $skuProperty){
  if(!isset($arResult['OFFERS_PROP'][$skuProperty['CODE']]))
    continue;
  $skuProps[] = array(
          'ID' => $skuProperty['ID'],
	  'SHOW_MODE' => $skuProperty['SHOW_MODE'],
	  'VALUES' => $skuProperty['VALUES'],
	  'VALUES_COUNT' => $skuProperty['VALUES_COUNT']
  );
}
$arResult['RELATED_PRODUCTS'] = array();
$rs = CIBlockElement::GetList(array("SORT"=>"ASC"), array('IBLOCK_ID'=>2,'ID'=>$arResult['PROPERTIES']['RELATED_PRODUCTS']['VALUE'],'ACTIVE'=>'Y'), false, false, array('ID','NAME','DETAIL_PAGE_URL','PROPERTY_ARTNUMBER','PROPERTY_COLOR','PROPERTY_COLAT'));
while($it = $rs->GetNext()){   
  $color = CIBlockElement::GetByID($it['PROPERTY_COLOR_VALUE'])->GetNext(false,false);
  $arResult['RELATED_PRODUCTS'][] = array('ID'=>$it['ID'],'URL'=>$it['DETAIL_PAGE_URL'],'COLOR'=>$it["PROPERTY_COLAT_VALUE"]);  
}
$sizes = array();
$rt = CIBlockElement::GetProperty(6, $brand['ID'], array('SORT'=>'ASC'), array('CODE'=>'SIZE_TABLES'));
while($it = $rt->GetNext())
  $sizes[] = $it['VALUE'];

$arResult['CATALOG_QUANTITY'] = 0;
$arResult['STORES'] = array();
$arResult['STORES_MAP'] = array();
$arResult['SIZES_TABLE'] = array();
$aSizes = array();
$gend = mb_strtolower(mb_substr(strip_tags($arResult['DISPLAY_PROPERTIES']['GENDER']['DISPLAY_VALUE']),0,1,"UTF-8"),"UTF-8");

foreach($arResult['OFFERS'] as $i=>$offer){
  $arResult['CATALOG_QUANTITY']+= $offer['CATALOG_QUANTITY'];
  $rs = CCatalogStoreProduct::GetList(array('ID'=>'ASC'), array('PRODUCT_ID' => $offer['ID']), false, false, array('ID','STORE_ID','STORE_NAME','STORE_ADDR','STORE_GPS_N','STORE_GPS_S','AMOUNT'));
  while($store = $rs->GetNext()){
    if($store['AMOUNT'] > 0){
      $arResult['STORES_MAP'][$offer['ID']][] = array('ID'=>$store["STORE_ID"],'NAME'=>$store['STORE_NAME'],'ADDRESS'=>$store['STORE_ADDR'],'GEO_LAT'=>$store['STORE_GPS_N'],'GEO_LONG'=>$store['STORE_GPS_S'],'AMOUNT'=>$store['AMOUNT']);
      $arResult['STORES'][$offer['ID']][] = $store['STORE_NAME'];
    }
  }
  foreach($skuProperty['VALUES'] as &$value){
    $value['NAME'] = htmlspecialcharsbx($value['NAME']);
    if($value['ID'] == $offer['PROPERTIES']['SIZES_SHOES']['VALUE'] && $arResult['STORES_MAP'][$offer['ID']][0]['AMOUNT'] > 0) {
      if($brand['PROPERTY_SIZE_CHART_VALUE'] && in_array($category['XML_ID'], array(46,26,21))) {

        foreach($sizes as $it){
          if(($it['Пол'] == $gend) && ($it[$brand['PROPERTY_SIZE_CHART_VALUE']] == $value['NAME'])){
            $arResult['OFFERS'][$i]['SIZE'] = $value['NAME'];
            $arResult['OFFERS'][$i]['SIZE_NAME'] = $value['NAME'].$brand['PROPERTY_SIZE_CHART_VALUE'].' - '.$it['CM'].'СМ';

            $arResult['OFFERS'][$i]['US_NAME'] = $it['US'];
            $arResult['OFFERS'][$i]['UK_NAME'] = $it['UK'];
            $arResult['OFFERS'][$i]['EUR_NAME'] = $it['EUR'];
            $arResult['OFFERS'][$i]['RUS_NAME'] = $it['RUS'];
            $arResult['OFFERS'][$i]['CM_NAME'] = $it['CM'];
            $arResult['DEFAULT_SIZE_CHART'] = $brand['PROPERTY_SIZE_CHART_VALUE'];
          }
        }
        if(empty($arResult['OFFERS'][$i]['SIZE'])){
          $arResult['NOT_SIZES'] = true;
          foreach($sizes_u as $it){
            if($it[$brand['PROPERTY_SIZE_CHART_VALUE']] == $value['NAME']){
              $arResult['OFFERS'][$i]['SIZE'] = $value['NAME'];
              $arResult['OFFERS'][$i]['SIZE_NAME'] = $value['NAME'].$brand['PROPERTY_SIZE_CHART_VALUE'].' - '.$it['CM'].'СМ';

              $arResult['OFFERS'][$i]['US_NAME'] = $it['US'];
              $arResult['OFFERS'][$i]['UK_NAME'] = $it['UK'];
              $arResult['OFFERS'][$i]['EUR_NAME'] = $it['EUR'];
              $arResult['OFFERS'][$i]['RUS_NAME'] = $it['RUS'];
              $arResult['OFFERS'][$i]['CM_NAME'] = $it['CM'];
              $arResult['DEFAULT_SIZE_CHART'] = $brand['PROPERTY_SIZE_CHART_VALUE'];
            }
          }
        }else{
          $arResult['NOT_SIZES'] = false;
        }
      }else{
        if($arResult['STORES_MAP'][$offer['ID']][0]['AMOUNT'] > 0) {
          $arResult['OFFERS'][$i]['SIZE'] = $value['NAME'];
          $arResult['OFFERS'][$i]['SIZE_NAME'] = $value['NAME'];
        }
      }
    }
  }
}                                     
usort($arResult['OFFERS'], function($a, $b){
    return $a['SIZE'] > $b['SIZE'] ? 1 : -1;
});
foreach($sizes as $it){
  if($it['Пол'] == $gend)
    $arResult['SIZES_TABLE'][] = array('US'=>$it['US'],'UK'=>$it['UK'],'EUR'=>$it['EUR'],'RUS'=>$it['RUS'],'CM'=>$it['CM']);
}

$haveOffers = !empty($arResult['OFFERS']);
if($haveOffers)
  $actualItem = isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']]) ? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']] : reset($arResult['OFFERS']);
else
  $actualItem = $arResult;
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];

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
if($arResult['PROPERTIES']['COLAT']['VALUE']){
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

$arResult['META'] = array();

if($category['IBLOCK_SECTION_ID'] == 11 || $category['IBLOCK_SECTION_ID'] == 12 || $category['ID'] == 11 || $category['ID'] == 12){
  $arResult['META']['TITLE'] = ($color?$color.' ':'').($gender?ToLower($gender).' ':'').ToLower($cat).' '.$arResult['NAME'].' от '.$brand['NAME'].' ('.$sku.') по цене '.$price['RATIO_PRICE'].' рублей';
  $arResult['META']['KEYWORDS'] = ToLower(($color?$color.' ':'').($gender?$gender.' ':'').$cat).' '.$arResult['NAME'].' '.$brand['NAME'].' '.$sku.' цена купить интернет магазин';
  $arResult['META']['DESCRIPTION'] = $cat.' '.$arResult['NAME'].' от '.$brand['NAME'].' ('.$sku.') по лучшей цене с фото, описанием и отзывами только в мультибрендовом интернет магазине Sneakerhead.';
}else{
  $arResult['META']['TITLE'] = 'Купить '.ToLower(($color?$color.' ':'').($gender?$gender.' ':'').$cat).' '.$arResult['NAME'].' от '.$brand['NAME'].' ('.$sku.') по цене '.$price['RATIO_PRICE'].' рублей';
  $arResult['META']['KEYWORDS'] = ToLower(($color?$color.' ':'').($gender?$gender.' ':'').$cat).' '.$arResult['NAME'].' '.$brand['NAME'].' '.$sku.' цена купить интернет магазин';
  $arResult['META']['DESCRIPTION'] = 'Купить '.ToLower(($color?$color.' ':'').($gender?$gender.' ':'').$cat).' '.$arResult['NAME'].' от '.$brand['NAME'].' ('.$sku.') по лучшей цене с фото, описанием и отзывами только в мультибрендовом интернет магазине Sneakerhead.';
}
$cp = $this->__component;
if(is_object($cp))
  $cp->SetResultCacheKeys(array('META'));
