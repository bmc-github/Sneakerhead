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
$this->createFrame()->begin("");
?>
	<?if($arParams['URL_LIST'] != "" && $arResult['COUNT'] > 0):?>
		<a href="<?=$arParams['URL_LIST']?>" class="round-icon-link" rel="nofollow">
			<i class="ri-star"><span class="wish-total"><?=$arResult['COUNT']?></span></i>
		</a>
	<?else:?>
		<span class="round-icon-link">
			<i class="ri-star"><?if($arResult['COUNT'] > 0):?><span class="wish-total"><?=$arResult['COUNT']?></span><?endif;?></i>
		</span>
	<?endif;?>