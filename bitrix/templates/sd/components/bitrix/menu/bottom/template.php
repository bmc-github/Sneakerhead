<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
  $page = $APPLICATION->GetCurPage(false);
  if(!empty($arResult)){?>
            <ul>
<?  foreach($arResult as $arItem){
	  if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) continue;
	  if($arItem["SELECTED"]){?>
              <li><?=$arItem["TEXT"]?></li>
	<?}else{?>
              <li><a href="<?=$arItem['LINK']?>"<?if($page != '/' || ($page == '/' && in_array($arItem['LINK'],array('/privacy/','/oferta/')))) echo ' rel="nofollow"';?>><?=$arItem["TEXT"]?></a></li>
	<?}
    }?>
            </ul>
<?}?>