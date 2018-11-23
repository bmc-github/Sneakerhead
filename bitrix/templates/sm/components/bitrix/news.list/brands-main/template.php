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

      <div class="glide__wrapper">
        <ul class="glide__track">
<?foreach($arResult["ITEMS"] as $arItem){
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
?>
          <li class="glide__slide" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
<?php
    if($arItem['CODE']){?>
            <a class="brandBox" href="<?=$arItem['CODE']?>">
              <div class="brand"><?/*style="background-image: url('<?=SITE_TEMPLATE_PATH?>/images/rybashka.png');">*/?>
                <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>" />
              </div>
            </a>
<?php
    }else{?>
            <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>" />
<?php
    }?>
          </li>
<?}?>
        </ul>
      </div>
      <div class="glide__bullets"></div>
