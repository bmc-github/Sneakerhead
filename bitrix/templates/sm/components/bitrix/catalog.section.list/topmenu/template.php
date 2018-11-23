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

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

if(0 < $arResult["SECTIONS_COUNT"]){?>
          <ul>
<?//preg_match('#\/brands\/#',$_SERVER['REQUEST_URI'], $href);
  //if(empty($href)){?>
            <li><a href="/brands/">Бренды</a></li>
<?/*}else{?>
            <li class="parent open">
              <a href="/brands/">Бренды</a>
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"brands",
	array(
		"IBLOCK_TYPE" => "references",
		"IBLOCK_ID" => "6",
		"NEWS_COUNT" => "999",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "NAME",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "N",
		"STRICT_SECTION_CHECK" => "Y",
		"DISPLAY_TOP_PAGER" => "Y",
		"DISPLAY_BOTTOM_PAGER" => "Y"
	),
	false
);?> 
            </li>
<?php
  }*/
  $intCurrentDepth = 1;
  $boolFirst = true;
  foreach ($arResult['SECTIONS'] as &$arSection){
    $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
    $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
    $cnt = CIBlockSection::GetCount(array('SECTION_ID'=>$arSection['ID'],'ACTIVE'=>'Y','DEPTH_LEVEL'=>$arSection['DEPTH_LEVEL']+1));

    if ($intCurrentDepth < $arSection['RELATIVE_DEPTH_LEVEL']){
      if ($intCurrentDepth > 0){
        echo "\n",str_repeat("\t", $arSection['RELATIVE_DEPTH_LEVEL']),'<ul>';
      }
    }elseif ($intCurrentDepth == $arSection['RELATIVE_DEPTH_LEVEL']){
      if (!$boolFirst){
        echo '</li>';
      }
    }else{
      while ($intCurrentDepth > $arSection['RELATIVE_DEPTH_LEVEL']){
        echo '</li>',"\n",str_repeat("\t", $intCurrentDepth),'</ul>',"\n",str_repeat("\t", $intCurrentDepth-1);
	$intCurrentDepth--;
      }
      echo str_repeat("\t", $intCurrentDepth-1),'</li>';
    }
    echo (!$boolFirst ? "\n" : ''),str_repeat("\t", $arSection['RELATIVE_DEPTH_LEVEL']);

/*
    preg_match('#\/[a-zA-Z0-9]{1,}\/#',$_SERVER['REQUEST_URI'], $href);
    if(!empty($href)) {
      $http = 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$href[0]==$arSection['SECTION_PAGE_URL'];
      $https = 'https://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$href[0]==$arSection['SECTION_PAGE_URL'];
    }
    if(isset($http) && $http || isset($https) && $https){*/
?>
<?$arSection['SECTION_PAGE_URL']=str_replace('youth','kids',$arSection['SECTION_PAGE_URL'])?>
                  <li<?if($_SERVER['REQUEST_URI']==$arSection['SECTION_PAGE_URL']) echo ' class="parent open"';?> id="<?=$this->GetEditAreaId($arSection['ID']);?>">
                    <a href="<?=$arSection['SECTION_PAGE_URL']?>"><?=$arSection["NAME"]?><?if($cnt > 0){?><span></span><?}?></a>
<?php
    $intCurrentDepth = $arSection['RELATIVE_DEPTH_LEVEL'];
    $boolFirst = false;
  }
  unset($arSection);
  while ($intCurrentDepth > 1){
    echo '</li>',"\n",str_repeat("\t", $intCurrentDepth),'</ul>',"\n",str_repeat("\t", $intCurrentDepth-1);
    $intCurrentDepth--;
  }
  if ($intCurrentDepth > 0){
    echo '</li>',"\n";
  }
?>
            <li><a href="/blog/">Блог</a></li>
          </ul>
<?}?>