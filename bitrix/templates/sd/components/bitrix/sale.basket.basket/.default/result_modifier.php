<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/*
 @var CBitrixComponentTemplate $this 
 @var array $arParams 
 @var array $arResult */
use Bitrix\Main;

$defaultParams = array('TEMPLATE_THEME' => 'blue');
$arParams = array_merge($defaultParams, $arParams);
unset($defaultParams);
if($_REQUEST['DelCop']):
$APPLICATION->RestartBuffer();
\Bitrix\Sale\DiscountCouponsManager::delete($_REQUEST['DelCop']);
echo json_decode(array('coup'=>'ok'));
die();
endif;
$arParams['TEMPLATE_THEME'] = (string )($arParams['TEMPLATE_THEME']);
if ('' != $arParams['TEMPLATE_THEME']) {
    $arParams['TEMPLATE_THEME'] = preg_replace('/[^a-zA-Z0-9_\-\(\)\!]/', '', $arParams['TEMPLATE_THEME']);
    if ('site' == $arParams['TEMPLATE_THEME']) {
        $templateId = (string )Main\Config\Option::get('main', 'wizard_template_id',
            'eshop_bootstrap', SITE_ID);
        $templateId = (preg_match("/^eshop_adapt/", $templateId)) ? 'eshop_adapt' : $templateId;
        $arParams['TEMPLATE_THEME'] = (string )Main\Config\Option::get('main', 'wizard_' .
            $templateId . '_theme_id', 'blue', SITE_ID);
    }
    if ('' != $arParams['TEMPLATE_THEME']) {
        if (!is_file($_SERVER['DOCUMENT_ROOT'] . $this->GetFolder() . '/themes/' . $arParams['TEMPLATE_THEME'] . '/style.css'))
            $arParams['TEMPLATE_THEME'] = '';
    }
}
if ('' == $arParams['TEMPLATE_THEME'])
    $arParams['TEMPLATE_THEME'] = 'blue';

foreach ($arResult["GRID"]["ROWS"] as $key => $arItem) {
    $sku = CCatalogSku::GetProductInfo($arItem['PRODUCT_ID']);
    $product = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 2, 'ID' => $sku['ID']), false, false,
        array(
        'IBLOCK_ID',
        'ID',	
        'IBLOCK_SECTION_ID',
	'XML_ID',
        'NAME',
        'PROPERTY_BRAND',
        'PROPERTY_SALE',
        'PROPERTY_SPECIAL_PRICE',
        'PROPERTY_SPECIAL_DATE'))->GetNext(); //CIBlockElement::GetByID($sku['ID'])->GetNext();

    $arResult["GRID"]["ROWS"][$key]['CATEGORY'] = CIBlockSection::GetByID($product['~IBLOCK_SECTION_ID'])->GetNext();
    $arResult["GRID"]["ROWS"][$key]['BRAND'] = CIBlockElement::GetByID($product['PROPERTY_BRAND_VALUE'])->GetNext();
    $arResult["GRID"]["ROWS"][$key]['SALE'] = $product['PROPERTY_SALE_VALUE'];
    $arResult["GRID"]["ROWS"][$key]['XML_ID'] = $product['XML_ID'];

    $arResult["GRID"]["ROWS"][$key]['SPECIAL_PRICE'] = $product['PROPERTY_SPECIAL_PRICE_VALUE'];
    $arResult["GRID"]["ROWS"][$key]['SPECIAL_DATE'] = $product['PROPERTY_SPECIAL_DATE_VALUE'];
}





//echo '<pre>';print_r($arResult["GRID"]["ROWS"][19]['SPECIAL_PRICE']);echo'</pre>';
