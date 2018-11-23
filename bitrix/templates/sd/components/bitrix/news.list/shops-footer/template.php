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
          <div class="col-xs-2">
            <p style="text-transform:uppercase;font-weight:bold;font-size:10px;"><?=GetMessage('H_OFFLINE_STORES')?>:</p>
          </div>
<?foreach($arResult["ITEMS"] as $i=>$arItem){
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    if($arItem['NAME']!='Интернет-магазин'){
      $metro = explode(', ', $arItem["PROPERTIES"]["METRO".(($_SESSION["lang"]=="en")?"_EN":"")]["VALUE"]);
      $adr = $arItem["PROPERTIES"]["ADDRESS".(($_SESSION["lang"]=="en")?"_EN":"")]["VALUE"];
      if($i == count($arResult["ITEMS"])-2)
        $adr = wordwrap($adr,50,'<br>');      
      else
        $adr = $adr.'<br />';
?>
          <div class="col-xs-2" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <p><a href="<?=$arItem['DETAIL_PAGE_URL']?>"<?if($APPLICATION->GetCurPage(false) != '/') echo ' rel="nofollow"';?>><?=$adr?> (<?=$metro[0]?>)</a></p>
          </div>
<?  }
  }?>
          <div style="height:15px;clear:both;"></div>
          <div class="col-xs-2">
            <p> </p>
          </div>
