<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<a class="round-icon-link" href="<?=$arParams['PATH_TO_BASKET']?>" rel="nofollow">
  <i class="ri-cart"><?if($arResult["COMMON_COUNT"] > 0):?><span class="cart-total"><?=$arResult["COMMON_COUNT"]?></span><?endif;?></i>
</a>
