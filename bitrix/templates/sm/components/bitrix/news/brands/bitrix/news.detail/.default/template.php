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
  if($arResult["DETAIL_TEXT"]){?>
         <div class="category-info">
           <?=$arResult["DETAIL_TEXT"]?>
            <p class="read-more"><a class="button" href="#">Читать далее</a></p>
         </div>
<?}?>
         <div style="background: #fff; margin-bottom: 20px">
           <div data-retailrocket-markup-block="58ad61115a65882da00fdd96" data-algorithm-param-vendor="<?=$arResult['NAME']?>"></div>
         </div>


