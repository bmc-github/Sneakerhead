<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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

$templateData = array(
    'TEMPLATE_THEME' => $this->GetFolder() . '/themes/' . $arParams['TEMPLATE_THEME'] . '/colors.css',
    'TEMPLATE_CLASS' => 'bx-' . $arParams['TEMPLATE_THEME']
);

if (isset($templateData['TEMPLATE_THEME']))
    $this->addExternalCss($templateData['TEMPLATE_THEME']);

//$this->addExternalCss("/bitrix/css/main/bootstrap.css");
//$this->addExternalCss("/bitrix/css/main/font-awesome.css");
?>
        <div class="container category-page filterList" style="left:100%">
          <div class="row">
            <div class="col-lg-12">
              <a class="prev" href="catalog.html">Назад</a>
              <h1>Фильтр</h1>
              <form id="filterpro" name="<?=$arResult['FILTER_NAME']?>_form" action="<?=$arResult['FORM_ACTION']?>" method="get">
                <div><input class="btn-link" type="submit" id="del_filter" name="del_filter" value="Очистить фильтр" /></div>
                <div class="filterBox" id="filterpro_box">
                  <div class="box-content filterpro">
                  <?foreach($arResult["HIDDEN"] as $arItem){?>
                    <input type="hidden" name="<? echo $arItem["CONTROL_NAME"] ?>" id="<? echo $arItem["CONTROL_ID"] ?>" value="<? echo $arItem["HTML_VALUE"] ?>" />
                  <?}
                    if(!empty($arResult['CATEGORIES'])){
                      foreach($arResult['PARENTS'] as $parent){?>
                    <div class="bx-filter-parameters-box bx-active group">
	              <span class="bx-filter-container-modef"></span>
                      <div class="bx-filter-parameters-box-title" onclick="smartFilter.hideFilterProps(this)">
                        <span class="bx-filter-parameters-box-hint">
                          <?if($_SESSION['lang'] == null || $_SESSION['lang'] == 'ru') echo $parent['NAME']; else echo $parent['UF_NAME']; ?> 
                          <i data-role="prop_angle" class="fa fa-angle-up"></i>
                        </span>
                      </div>
		      <div class="bx-filter-block" data-role="bx_filter_block">
                        <div class="bx-filter-parameters-box-container">
		        <?foreach($arResult['CATEGORIES'] as $it){
                            if($it['IBLOCK_SECTION_ID'] == $parent['ID']){?>
                          <div class="checkbox">
		            <a href="<?=$it['SECTION_PAGE_URL']?>" class="filter-link<?if(substr_count($_SERVER['REQUEST_URI'],$it['SECTION_PAGE_URL']) > 0) echo ' checked';?>"><?=$it[(($_SESSION['lang'] == 'en') ? 'UF_' : '').'NAME'] ?></a>
                          </div>
		        <?  }
                          }?>
                        </div>
		      </div>
	            </div><?
                      }
                    }
                    //not prices
                    foreach ($arResult["ITEMS"] as $key => $arItem){
		      if(empty($arItem["VALUES"]) || isset($arItem["PRICE"]) || $arItem['CODE'] == 'SPECIAL_PRICE' || $arItem['CODE'] == 'ISNEW' || $arItem['CODE'] == 'SALE' ||
		        ((substr_count($APPLICATION->GetCurPage(false),'brands')>0 || substr_count($APPLICATION->GetCurPage(false),'isnew')>0) && in_array($arItem['CODE'],array('GENDER','COLOR','SIZES_SHOES'))) ||
			((substr_count($APPLICATION->GetCurPage(false),'sale')>0) && in_array($arItem['CODE'],array('GENDER','COLOR'))) 
			)
                        continue;
                      if($arItem["DISPLAY_TYPE"] == "A" && ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0))
                        continue;
                      if($arItem['CODE'] == 'SIZES_SHOES')
                        echo '<!--noindex-->'; ?>
                    <div class="bx-filter-parameters-box <?if($arItem["DISPLAY_EXPANDED"] == "Y"):?>bx-active<?endif ?> group">
                      <span class="bx-filter-container-modef"></span>
                      <div class="bx-filter-parameters-box-title" onclick="smartFilter.hideFilterProps(this)">
	                <span class="bx-filter-parameters-box-hint">
                          <?if($_SESSION['lang'] == null || $_SESSION['lang'] == 'ru') echo $arItem['NAME']; else echo (($arItem['CODE'] == 'SIZES_SHOES') ? 'SIZE' : $arItem['CODE']);?>
                          <i data-role="prop_angle" class="fa fa-angle-<?if($arItem["DISPLAY_EXPANDED"] == "Y"):?>up<?else:?>down<?endif ?>"></i>
			</span>
                      </div>
                      <div class="bx-filter-block" data-role="bx_filter_block">
                        <div class="bx-filter-parameters-box-container">
                  <?$arCur = current($arItem["VALUES"]);
                    switch($arItem["DISPLAY_TYPE"]){
                      case 'URL':
                        foreach ($arItem["VALUES"] as $val => $ar){?>
                          <div class="checkbox"><?
                          $url = $arResult['FILTER_URL_PROPS'];
                          $url[$arItem['CODE']] = $ar['URL_ID'];
                          $url = array_diff($url, array(''));
                          if($arItem['CODE'] == 'BRAND' && substr_count($_SERVER['REQUEST_URI'], 'brands') > 0)
			    $res_url = '/brands/'.implode("/", $url);
		          elseif($arItem['CODE'] == 'BRAND' && $_SERVER['REQUEST_URI'] == '/isnew/')
			    $res_url = '/isnew/'.implode("/", $url);
		          elseif($arItem['CODE'] == 'BRAND' && $_SERVER['REQUEST_URI'] == '/sale/')
			    $res_url = '/sale/'.implode("/", $url);
		          elseif($arItem['CODE'] == 'SIZES_SHOES' && $_SERVER['REQUEST_URI'] == '/sale/')
			    $res_url = '/sale/'.implode("/", $url);
                          else
                    	    $res_url = $arResult['FILTER_URL_CLEAR'].implode("/", $url);                    
                          $ru = explode('/', $res_url);
                          $ru2 = array_unique($ru);
                          $res_url = implode('/', $ru2).'/';?>
                            <a class="filter-link<?if(!$ar['ELEMENT_COUNT']) echo ' disabled'; if($ar["CHECKED"]) echo ' checked';?>"<?if($ar['ELEMENT_COUNT']) echo ' href="'.$res_url.'"'; if($arItem['CODE'] == 'SIZES_SHOES') echo ' rel="nofollow"';?>>
                              <?if(in_array($arItem['CODE'], array('GENDER', 'COLOR')) && $_SESSION['lang'] == 'en') echo ucfirst($ar["URL_ID"]); else echo $ar["VALUE"];?>
                            </a>
                          </div><?
                        }
                        break;
                      default://CHECKBOXES
                        foreach ($arItem["VALUES"] as $val => $ar){?>
                          <div class="checkbox">
                            <label data-role="label_<?= $ar["CONTROL_ID"] ?>" class="bx-filter-param-label <? echo $ar["DISABLED"] ? 'disabled' : '' ?>" for="<? echo $ar["CONTROL_ID"] ?>">
                              <span class="bx-filter-input-checkbox">
                                <input type="checkbox" value="<?=$ar['HTML_VALUE']?>" name="<?=$ar['CONTROL_NAME']?>" id="<?=$ar['CONTROL_ID']?>" <?if($ar["CHECKED"]) echo 'checked="checked"';?> onclick="smartFilter.click(this)" />
                                <span class="bx-filter-param-text" title="<?=$ar["VALUE"]?>">
                                  <?=$ar["VALUE"]?>
                                  <?/*if($arParams["DISPLAY_ELEMENT_COUNT"] != "N" && isset($ar["ELEMENT_COUNT"])){?>&nbsp;(<span data-role="count_<?=$ar["CONTROL_ID"]?>"><?=$ar["ELEMENT_COUNT"]?></span>)<?}*/?>
                                </span>
                              </span>
                            </label>
                          </div>
                      <?}
                      }?>
                        </div>
                      </div>
                    </div>
                  <?}?>
                  </div>
                </div><?if($arItem['CODE'] == 'SIZES_SHOES')
              echo '<!--/noindex-->';?>
                <?/*<div class="row">
                  <div class="col-xs-12 bx-filter-button-box">
                    <div class="bx-filter-block">
                      <div class="bx-filter-parameters-box-container">
                        <input class="btn btn-themes" type="hidden" id="set_filter" name="set_filter" value="<?= GetMessage("CT_BCSF_SET_FILTER") ?>" />
                        <input class="btn btn-link" type="submit" id="del_filter" name="del_filter" value="<?= GetMessage("CT_BCSF_DEL_FILTER") ?>" />
                        <div class="bx-filter-popup-result <?if($arParams["FILTER_VIEW_MODE"] == "VERTICAL") echo $arParams["POPUP_POSITION"]?>" id="modef" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"';?> style="display: inline-block;"> 
                          <? echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">' . intval($arResult["ELEMENT_COUNT"]) . '</span>')); ?>
                          <span class="arrow"></span>
                          <br/>
                          <a href="<? echo $arResult["FILTER_URL"] ?>" target=""><? echo GetMessage("CT_BCSF_FILTER_SHOW") ?></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>*/?>
              </form>
            </div>
          </div>
        </div>
<script>
    var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>