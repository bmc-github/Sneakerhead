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

<?foreach($arResult["ITEMS"] as $i=>$arItem){
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    if($i==0){?>
            <div class="col-xs-8 metro-link-category mlk-big">
              <a href="<?=$arItem['CODE']?>" style="background-image: url('<?=$arItem['PREVIEW_PICTURE']['SRC']?>');">
                <span><?=(($_SESSION['lang']=='en')?$arItem['PROPERTIES']['NAME']['VALUE']:$arItem['NAME']);?></span>
              </a>
            </div>
<?php
    }else{
      if($i%2 == 1)
        echo '<div class="col-xs-4">';?>
              <div class="metro-link-category">
                <a href="<?=$arItem['CODE']?>" style="background-image: url('<?=$arItem['PREVIEW_PICTURE']['SRC']?>');">
                  <span><?=(($_SESSION['lang']=='en')?$arItem['PROPERTIES']['NAME']['VALUE']:$arItem['NAME']);?></span>
                </a>
              </div>
<?php
      if($i%2 == 0)
        echo '</div>';
    }
  }?>