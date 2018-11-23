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
  if($arResult["ITEMS"] && $_SERVER['REQUEST_URI'] == '/brands/'){
?>
              <div class="brands" id="brandss">
<?  foreach($arResult["ITEMS"] as $arItem){
      $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
      $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
?>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-center" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                  <a href="http://<?=$_SERVER['SERVER_NAME']?>:<?=$_SERVER['SERVER_PORT']?>/shoes/#instock=on&manufacturer%5B%5D=<?=$arItem['ID']?>"><?=$arItem['NAME']?></a>
                </div>
<?  }?>
                <br />
              </div>
<?}?>
