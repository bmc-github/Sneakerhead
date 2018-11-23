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

<?foreach($arResult["ITEMS"] as $arItem){
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
?>
            <div class="col-xs-8 banner-index"  style="height:296px;">
              <div class="metro-link-product metro-link">
                <div class="metro-link-product-borderfix main-link-product-borderfix" style="padding:0 !important;">
                  <a class="metro-link-product white-bg metro-link-category metro-link-product-image main-link-product" style="background-image: url('<?=$arItem['PREVIEW_PICTURE']['SRC']?>');height:296px;" href="<?=$arItem['CODE']?>"></a>
                  <div class="metro-link-product-left" style="top:0">
                    <?=htmlspecialchars_decode($arItem['PREVIEW_TEXT'])?>
                  </div>
                </div>
              </div>
            </div>
<?}?>
