<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

  if (!empty($arResult)){?>
            <ul>
<?  foreach($arResult as $arItem){
	  if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;
	  if($arItem["SELECTED"]){?>
              <li><a class="font11 active" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
	<?}else{?>
              <li><a class="font11" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
	<?}
    }?>
            </ul>
<?}?>