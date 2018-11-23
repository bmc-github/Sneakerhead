<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

$this->setFrameMode(true);
//$this->addExternalCss("/bitrix/css/main/bootstrap.css");

if (!isset($arParams['FILTER_VIEW_MODE']) || (string)$arParams['FILTER_VIEW_MODE'] == '')
    $arParams['FILTER_VIEW_MODE'] = 'VERTICAL';
$arParams['USE_FILTER'] = (isset($arParams['USE_FILTER']) && $arParams['USE_FILTER'] == 'Y' ? 'Y' : 'N');

$isVerticalFilter = ('Y' == $arParams['USE_FILTER'] && $arParams["FILTER_VIEW_MODE"] == "VERTICAL");
$isSidebar = ($arParams["SIDEBAR_SECTION_SHOW"] == "Y" && isset($arParams["SIDEBAR_PATH"]) && !empty($arParams["SIDEBAR_PATH"]));
$isFilter = ($arParams['USE_FILTER'] == 'Y');

if ($isFilter) {
    $arFilter = array(
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "ACTIVE" => "Y",
        "GLOBAL_ACTIVE" => "Y",
    );
    if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
        $arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
    elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
        $arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];

    $obCache = new CPHPCache();
    if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog")) {
        $arCurSection = $obCache->GetVars();
    } elseif ($obCache->StartDataCache()) {
        $arCurSection = array();
        if (Loader::includeModule("iblock")) {
            $dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));

            if (defined("BX_COMP_MANAGED_CACHE")) {
                global $CACHE_MANAGER;
                $CACHE_MANAGER->StartTagCache("/iblock/catalog");

                if ($arCurSection = $dbRes->Fetch())
                    $CACHE_MANAGER->RegisterTag("iblock_id_" . $arParams["IBLOCK_ID"]);

                $CACHE_MANAGER->EndTagCache();
            } else {
                if (!$arCurSection = $dbRes->Fetch())
                    $arCurSection = array();
            }
        }
        $obCache->EndDataCache($arCurSection);
    }
    if (!isset($arCurSection))
        $arCurSection = array();
}
?>

<?
if ($isVerticalFilter)
    include($_SERVER["DOCUMENT_ROOT"] . "/" . $this->GetFolder() . "/section_vertical.php");
else
    include($_SERVER["DOCUMENT_ROOT"] . "/" . $this->GetFolder() . "/section_horizontal.php");

$obCache = new CPHPCache();
if ($obCache->InitCache(36000, serialize($APPLICATION->GetCurPage(false)), "/iblock/catalog_meta")) {
    $meta = $obCache->GetVars();
} elseif ($obCache->StartDataCache()) {
    $seo = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>13,'CODE'=>$APPLICATION->GetCurPage(false),'ACTIVE'=>'Y'), false, false, array('ID'))->GetNext(false,false);
    $iprop = new \Bitrix\Iblock\InheritedProperty\ElementValues(13, $seo["ID"]);
    $meta = $iprop->getValues();
    $obCache->EndDataCache($meta);
}

if($_REQUEST['PAGEN_1'] && $_REQUEST['PAGEN_1']>1){
  $APPLICATION->SetPageProperty('title', ($meta['ELEMENT_PAGE_TITLE'] ? $meta['ELEMENT_PAGE_TITLE'] : $GLOBALS['meta']['h1']).' - �������� �������� �'.$_REQUEST['PAGEN_1']);
  $APPLICATION->SetPageProperty('keywords', '');
  $APPLICATION->SetPageProperty('description', '');
}else{
  $APPLICATION->SetPageProperty('title', $meta['ELEMENT_META_TITLE'] ? $meta['ELEMENT_META_TITLE'] : $GLOBALS['meta']['title']);
  $APPLICATION->SetPageProperty('keywords', $meta['ELEMENT_META_KEYWORDS'] ? $meta['ELEMENT_META_KEYWORDS'] : $GLOBALS['meta']['keywords']);
  $APPLICATION->SetPageProperty('description', $meta['ELEMENT_META_DESCRIPTION'] ? $meta['ELEMENT_META_DESCRIPTION'] : $GLOBALS['meta']['description']);
}
$APPLICATION->SetTitle($meta['ELEMENT_PAGE_TITLE'] ? $meta['ELEMENT_PAGE_TITLE'] : $GLOBALS['meta']['h1']);

if(!empty($GLOBALS['meta']['urls']))
  foreach($GLOBALS['meta']['urls'] as $it)
    $APPLICATION->AddChainItem($it['NAME'],$it['URL']);
?>
<script type="text/javascript">
<?php $arResult['SECTION_ID'] = CIBlockFindTools::GetSectionID( $arResult['VARIABLES']['SECTION_ID'], $arResult['VARIABLES']['SECTION_CODE'], array('IBLOCK_ID' => $arParams['IBLOCK_ID']) ); ?>
    (window["rrApiOnReady"] = window["rrApiOnReady"] || []).push(function() {
        try { rrApi.categoryView(<?=$arResult['SECTION_ID']?>); } catch(e) {}
    })
</script>
<script type="text/javascript">
var _tmr = _tmr || [];
_tmr.push({
    id: '3065581',
    type: 'itemView',
    productid: '',
    pagetype: 'category',
    list: '1',
    totalvalue: ''
});
</script>

