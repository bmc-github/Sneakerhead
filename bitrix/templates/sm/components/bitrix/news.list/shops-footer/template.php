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
$this->setFrameMode(true);
?>
            <div class="col-lg-12 text-uppercase">
              <h6>Оффлайн магазины в Москве:</h6>
            </div>
<?foreach($arResult["ITEMS"] as $i=>$arItem){
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    if($arItem['NAME']!='Интернет-магазин'){
      $metro = explode(', ', $arItem["PROPERTIES"]["METRO"]["VALUE"]);
      $adr = $arItem["PROPERTIES"]["ADDRESS"]["VALUE"];
      if($i == count($arResult["ITEMS"])-1)
        $adr = wordwrap($adr,50,'<br>');
      else
        $adr = $adr.'<br />';
?>
            <div class="col-md-6 col-xs-6" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
              <a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$adr?> (<?=$metro[0]?>)</a>
            </div>
<?  }
  }?>
