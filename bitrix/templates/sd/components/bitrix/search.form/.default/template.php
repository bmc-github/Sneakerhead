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
                <form method="get" action="<?=$arResult["FORM_ACTION"]?>">
                  <input type="text" name="q" id="search" placeholder="Что будем искать ?" />
                  <input type="submit" id="search_submit" value="Rechercher" />
                </form>