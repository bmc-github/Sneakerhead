<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (isset($arParams["TEMPLATE_THEME"]) && !empty($arParams["TEMPLATE_THEME"])) {
    $arAvailableThemes = array();
    $dir = trim(preg_replace("'[\\\\/]+'", "/", dirname(__FILE__) . "/themes/"));
    if (is_dir($dir) && $directory = opendir($dir)) {
        while (($file = readdir($directory)) !== false) {
            if ($file != "." && $file != ".." && is_dir($dir . $file))
                $arAvailableThemes[] = $file;
        }
        closedir($directory);
    }

    if ($arParams["TEMPLATE_THEME"] == "site") {
        $solution = COption::GetOptionString("main", "wizard_solution", "", SITE_ID);
        if ($solution == "eshop") {
            $templateId = COption::GetOptionString("main", "wizard_template_id", "eshop_bootstrap", SITE_ID);
            $templateId = (preg_match("/^eshop_adapt/", $templateId)) ? "eshop_adapt" : $templateId;
            $theme = COption::GetOptionString("main", "wizard_" . $templateId . "_theme_id", "blue", SITE_ID);
            $arParams["TEMPLATE_THEME"] = (in_array($theme, $arAvailableThemes)) ? $theme : "blue";
        }
    } else {
        $arParams["TEMPLATE_THEME"] = (in_array($arParams["TEMPLATE_THEME"], $arAvailableThemes)) ? $arParams["TEMPLATE_THEME"] : "blue";
    }
} else {
    $arParams["TEMPLATE_THEME"] = "blue";
}

$arParams["FILTER_VIEW_MODE"] = (isset($arParams["FILTER_VIEW_MODE"]) && toUpper($arParams["FILTER_VIEW_MODE"]) == "HORIZONTAL") ? "HORIZONTAL" : "VERTICAL";
$arParams["POPUP_POSITION"] = (isset($arParams["POPUP_POSITION"]) && in_array($arParams["POPUP_POSITION"], array("left", "right"))) ? $arParams["POPUP_POSITION"] : "left";

$arResult['CATEGORIES'] = array();
$arResult['PARENTS'] = array();

$sFilter = array("IBLOCK_ID"=>2,"ACTIVE"=>"Y","CATALOG_AVAILABLE"=>"Y");
if($arResult["FILTER_URL_PROPS"]["BRAND"])
  $sFilter["PROPERTY_BRAND.CODE"] = $arResult["FILTER_URL_PROPS"]["BRAND"];
if($arResult["FILTER_URL_PROPS"]["GENDER"])
  $sFilter["PROPERTY_GENDER.CODE"] = $arResult["FILTER_URL_PROPS"]["GENDER"];
if($arResult["FILTER_URL_PROPS"]["COLOR"])
  $sFilter["PROPERTY_COLOR.CODE"] = $arResult["FILTER_URL_PROPS"]["COLOR"];
if($arResult["FILTER_URL_PROPS"]["SIZES_SHOES"])
  $sFilter["PROPERTY_SIZES_SHOES.CODE"] = $arResult["FILTER_URL_PROPS"]["SIZES_SHOES"];

$ide = array();
$re = CIBlockElement::GetList(array(), $sFilter/*array("IBLOCK_ID"=>2,"ACTIVE"=>"Y","PROPERTY_BRAND.CODE"=>$arResult['FILTER_URL'][1])*/, false, false, array('IBLOCK_SECTION_ID'));
while($it = $re->GetNext())
  $ide[] = $it['IBLOCK_SECTION_ID'];
$ide = array_unique($ide);

if(substr_count($APPLICATION->GetCurPage(false),'brands')>0){
  $ids = array();
  $rc = CIBlockSection::GetList(array("LEFT_MARGIN"=>"ASC"), array("IBLOCK_ID"=>2,"ACTIVE"=>"Y","ID"=>$ide,"DEPTH_LEVEL"=>2), false, array("ID","NAME","SECTION_PAGE_URL","IBLOCK_SECTION_ID","UF_NAME"));
  while($it = $rc->GetNext()){
    foreach($arResult['FILTER_URL'] as $furl){
      if($furl == 'brands') continue;
      $it['SECTION_PAGE_URL'].= $furl.'/';
    }
    $arResult['CATEGORIES'][] = $it;
    $ids[] = $it['IBLOCK_SECTION_ID'];
  }
  $ids = array_unique($ids);
  $rp = CIBlockSection::GetList(array("LEFT_MARGIN"=>"ASC"),array("IBLOCK_ID"=>2,"ACTIVE"=>"Y","ID"=>$ids,"DEPTH_LEVEL"=>1), false, array("ID","NAME","SECTION_PAGE_URL","UF_NAME"));
  while($it = $rp->GetNext())
    $arResult['PARENTS'][] = $it;
}else{
  $section = array();
  $section = CIBlockSection::GetList(array(), array("IBLOCK_ID"=>2,"ACTIVE"=>"Y","ID"=>$arResult["SECTION"]["ID"]), false, array("ID","NAME","SECTION_PAGE_URL","IBLOCK_SECTION_ID","UF_NAME"))->GetNext(); 
  if($section["IBLOCK_SECTION_ID"]){
    $section = CIBlockSection::GetList(array(), array("IBLOCK_ID"=>2,"ACTIVE"=>"Y","ID"=>$section["IBLOCK_SECTION_ID"]), false, array("ID","NAME","SECTION_PAGE_URL","UF_NAME"))->GetNext(); 
  }
  $rc = CIBlockSection::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID"=>2,"ACTIVE"=>"Y","DEPTH_LEVEL"=>2,"SECTION_ID"=>$section["ID"],"ID"=>$ide), false, array("ID","NAME","SECTION_PAGE_URL","IBLOCK_SECTION_ID","UF_NAME"), false);
  while($it = $rc->GetNext()){
    foreach($arResult['FILTER_URL'] as $i=>$furl){
      if($i<1 && $section['IBLOCK_SECTION_ID'] == NULL) continue;
      if($i<2 && !in_array($arResult["SECTION"]["ID"],array(1,11,12,55,56))) continue;
      $it['SECTION_PAGE_URL'].= $furl.'/';
    }
    $arResult['CATEGORIES'][] = $it;       
  }
  $arResult['PARENTS'][] = $section;
}