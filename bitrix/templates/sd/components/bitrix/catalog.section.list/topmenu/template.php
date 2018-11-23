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
$page = $APPLICATION->GetCurPage(false);

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

if (0 < $arResult["SECTIONS_COUNT"]){?>
                <ul>
<?$intCurrentDepth = 1;
  $boolFirst = true;
  //$i = 0;
  foreach($arResult['SECTIONS'] as $key=> &$arSection){
    if($key==1){?>
                      <li<?if(substr_count($page,'brands')>0) echo ' class="active"';?>>
                    <a href="/brands/"><?=GetMessage('H_BRANDS');?></a>
                    <div class="header_cat_children allbrands"> 
                      <ul class="column">
                        <li><a href="/brands/adidas-originals/">adidas Originals</a></li>
                        <li><a href="/brands/asics/">ASICS Tiger</a></li>
						<li><a href="/brands/casio/">Casio</a></li>
                      </ul>
                      <ul class="column">
                        <li><a href="/brands/converse/">Converse</a></li>
                        <li><a href="/brands/diadora/">Diadora</a></li>
						<li><a href="/brands/hard/">Hard</a></li>
                      </ul>
                      <ul class="column">

                        <li><a href="/brands/jordan/">Jordan</a></li>
						<li><a href="/brands/native/">Native</a></li>
                        <li><a href="/brands/nike/">Nike</a></li>
                      </ul>
                      <ul class="column">
                        <li><a href="/brands/nike-sb/">Nike SB</a></li>
                        <li><a href="/brands/new-balance/">New Balance</a></li>
                        <li><a href="/brands/onitsuka-tiger/">Onitsuka Tiger</a></li>
                      </ul>
                      <ul class="column">
                        <li><a href="/brands/puma/">Puma</a></li>
                        <li><a href="/brands/reebok/">Reebok</a></li>
                        <li><a href="/brands/sneakerhead/">Sneakerhead</a></li>
                      </ul>
                      <ul class="column">
                        <li><a href="/brands/stussy/">Stussy</a></li>
                        <li><a href="/brands/north-face/">The North Face</a></li>
                        <li><a href="/brands/vans/">Vans</a></li>
                      </ul>
                      <br style="clear:both" />
                    </div>
                  </li>
    <?}
    $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
    $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
    /*$cnt = CIBlockSection::GetCount(array('SECTION_ID'=>$arSection['ID'],'ACTIVE'=>'Y','DEPTH_LEVEL'=>$arSection['DEPTH_LEVEL']+1));
    if($cnt){
      $column_el = floor($cnt / 6);
      $ost = $cnt % 6;
    } */

    if ($intCurrentDepth < $arSection['RELATIVE_DEPTH_LEVEL']){
      if ($intCurrentDepth > 0){
        //$i = 0;
        echo "\n",str_repeat("\t", $arSection['RELATIVE_DEPTH_LEVEL']),'<ul class="header_cat_children">';
      }
    }elseif ($intCurrentDepth == $arSection['RELATIVE_DEPTH_LEVEL']){
      //$i++;
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
?>


<?$arSection['SECTION_PAGE_URL']=str_replace('youth','kids',$arSection['SECTION_PAGE_URL'])?>
                  <li class="column<?if($page == $arSection['SECTION_PAGE_URL']) echo ' active';?>" id="<?=$this->GetEditAreaId($arSection['ID']);?>">
                    <a href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection[(($_SESSION['lang']=='en')?'UF_':'').'NAME']?><?if($arParams["COUNT_ELEMENTS"]){?><span><?//=$arSection['DEPTH_LEVEL'].'/'.$cnt.'/'.$i?></span><?}?></a>
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
                </ul>
<?}?>