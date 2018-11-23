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
            <a href="<?=$arItem['DETAIL_PAGE_URL']?>">
              <div class="box-news">
                <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?//=$arItem['NAME']?>" />
                <div class="box-text">
                  <p><span><?=$arItem["DISPLAY_ACTIVE_FROM"]?></span></p>
                  <p class="title"><?=$arItem["NAME"]?></p>
                  <p><?=$arItem["PREVIEW_TEXT"]?></p>
                </div>
              </div>                
            </a>
          </li>
<?}?>
        </ul>   
      </div>
      <div class="glide__bullets"></div>