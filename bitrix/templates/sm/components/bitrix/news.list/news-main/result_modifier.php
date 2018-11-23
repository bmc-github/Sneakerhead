<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */

foreach ($arResult["ITEMS"] as $key => $arItem) {
    //если картинка больше чем надо то, подгоняем размер картинки, что бы большите не вылазили и не растягивали сайт
    if ($arItem[PREVIEW_PICTURE]["WIDTH"] > 266 || $arItem[PREVIEW_PICTURE]["HEIGHT"] > 190) {
        $arFileTmp = CFile::ResizeImageGet(
            $arItem[PREVIEW_PICTURE][ID],
            array("width" => 266, "height" => 190),
            //BX_RESIZE_IMAGE_PROPORTIONAL,
            BX_RESIZE_IMAGE_EXACT,
            true
        );

        $arResult["ITEMS"][$key][PREVIEW_PICTURE][SRC] = $arFileTmp[src];
        //$arResult["ITEMS"][$key][DETAIL_PICTURE][WIDTH] = $arFileTmp[width];
        //$arResult["ITEMS"][$key][DETAIL_PICTURE][HEIGHT] = $arFileTmp[height];
    }
}
?>