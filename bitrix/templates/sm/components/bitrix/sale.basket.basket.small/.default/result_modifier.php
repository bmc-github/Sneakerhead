<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$common_count = 0;
$common_price = 0;
if (!empty($arResult["ITEMS"])){
foreach ($arResult["ITEMS"] as $arItem){
	if ($arItem["CAN_BUY"] !== "Y") continue;

    $common_count+=$arItem['QUANTITY'];
    
    	$common_price += $arItem['QUANTITY'] * $arItem['PRICE'];
    
}
}

$arResult["COMMON_COUNT"] = $common_count;
$arResult["COMMON_PRICE"] = SaleFormatCurrency($common_price, $arItem["CURRENCY"], true);
