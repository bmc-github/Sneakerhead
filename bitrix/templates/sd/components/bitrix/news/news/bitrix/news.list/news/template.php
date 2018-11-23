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
        <div id="rec6520826" class="r" style="padding-top:60px;padding-bottom:0" data-animationappear="off" data-record-type="404">
          <div class="t404" data-show-count="15">
<?$count = 0;
  foreach($arResult["ITEMS"] as $arItem){
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    $count++;
    if($count == 1) echo '<div class="t-container">';
?>
              <div class="t404__col t-col t-col_4 t-align_left" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <a class="t404__link" href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                  <div class="t404__imgbox">
                    <div class="t404__img t-bgimg" data-original="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" style="background-image:url('<?=$arItem[PREVIEW_PICTURE][SRC]?>');"></div>
                    <div class="t404__separator"></div>
                  </div>
                  <div class="t404__textwrapper">
                    <div class="t404__uptitle t-uptitle" style="text-transform:uppercase;">
                      <span style="text-transform:uppercase;" class="t404__date"><?=FormatDateFromDB($arItem["DISPLAY_ACTIVE_FROM"],'l, j MMMM');?></span>
                    </div>
                    <div class="t404__title t-heading t-heading_xs"><?=$arItem["NAME"]?></div>
                    <div class="t404__descr t-descr t-descr_xs"><?=$arItem["PREVIEW_TEXT"];?></div>
                  </div>
                </a>
              </div>
<?php
    if($count == 3){
      echo '</div>';
      $count = 0;
    }
  }?>
            <div class="t404__buttonwrapper">
              <div class="t404__showmore t404__btn t-btn" style="color:#fff;border:0;background-color:#000;border-radius:30px;">
                <table style="width:100%; height:100%;">
                  <tr><td>ПОКАЗАТЬ ЕЩЕ</td></tr>
                </table>
              </div>
            </div>
          </div>
          <script>          
            $(document).ready(function(){              
              t404_unifyHeights();              
              $('.t404').bind('displayChanged',function(){
                t404_unifyHeights();
              });              
              setTimeout(function() { 
                 t404_unifyHeights();
              }, 2500);              
            });              
            $(window).resize(function() {
                t404_unifyHeights();
            });              
            $(window).load(function(){
                t404_unifyHeights();
            });           
          </script>
          <script>          
            $(document).ready(function(){
              t404_showMore('6520826');
            });          
          </script>  
        </div>     
<?/*if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;*/?>