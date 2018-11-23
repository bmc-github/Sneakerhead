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
    <script src="//api-maps.yandex.ru/2.1/?lang=ru_RU&load=Map"></script>
    <script>
      ymaps.modules.require(['Map','Placemark','geoObject.addon.hint','geoObject.addon.balloon','control.GeolocationControl','control.TypeSelector','control.ZoomControl','control.FullscreenControl','control.TrafficControl','control.RulerControl','control.SearchControl']).spread(function(Map,Placemark){
<?foreach ($arResult["ITEMS"] as $i=>$arItem):?>
        var map_<?=$i+1?> = new Map('ymapc<?=$i+1?>',{center:[<?=$arItem["PROPERTIES"]["GEO"]["VALUE"]?>],zoom:16,controls:['geolocationControl','typeSelector'/*,'zoomControl'*/,'fullscreenControl','trafficControl','rulerControl','searchControl']});
        map_<?=$i+1?>.behaviors.disable('scrollZoom');
        map_<?=$i+1?>.controls.add('zoomControl',{size:'large'});
        map_<?=$i+1?>.geoObjects.add(new Placemark(map_<?=$i+1?>.getCenter(),{       
	  balloonContentHeader:'<?=$arItem["PROPERTIES"]["ADDRESS"]["VALUE"]?>',
	  balloonContentBody:'<?=$arItem["PROPERTIES"]["LOCATION"]["VALUE"]?>',
          hintContent:'<?=$arItem["PROPERTIES"]["ADDRESS"]["VALUE"]?>'
	},{preset:'islands#dotIcon'}));
<?endforeach;?>
      },this);
    </script>                                                   

<?foreach($arResult["ITEMS"] as $i=>$arItem){
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    if($arItem['CODE'] == '') continue;
?>
              <div class="faq-tab-item" id="<?=$arItem['CODE']?>"><?/* id="<?=$this->GetEditAreaId($arItem['ID']);?>">*/?>
                <div class="faq-title"><?=$arItem['PROPERTIES']['METRO'.(($_SESSION['lang']=='en')?'_EN':'')]['VALUE']?></div>        
                <div class="faq-content">
                  <div class="alladdressBlock" itemscope itemtype="http://schema.org/LocalBusiness">
                    <meta itemprop="name" content="<?=$arItem['NAME']?>" />
                    <meta itemprop="image" content="http://<?=SITE_SERVER_NAME.SITE_TEMPLATE_PATH?>/images/sneakerhead_logo.png" />
                    <meta itemprop="priceRange" content="2$" />                    
                    <p class="adress-str" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                      <span itemprop="addressLocality"><?=$arItem['PROPERTIES']['CITY']['VALUE']?></span>
                      <?=$arItem['PROPERTIES']['METRO']['VALUE']?>
                      <span itemprop="streetAddress"><?=$arItem['PROPERTIES']['ADDRESS']['VALUE']?></span><br />                      
                      <span class="address-comment"><?=$arItem['PROPERTIES']['LOCATION']['VALUE']?></span>
                    </p>                                                             
                    <div class="address-ymap" id="ymapc<?=$i+1?>"></div>                    
                    <p class="address-hours">
                      <span class="address-nowrest">без перерывов и выходных</span><br />
                      часы работы 
<?php
    if($arItem["CODE"] == 'aviapark'){?>
                      <time itemprop="openingHours" datetime="Mo,Tu,We,Th,Su 10:00−22:00">вс-чт 10:00 - 22:00</time><br />
                      <time itemprop="openingHours" datetime="Fr,Sa 10:00−23:00">пт, сб 10:00 - 23:00</time>
<?php
    }else{?>
                      <time itemprop="openingHours" datetime="Mo-Su <?=str_replace(array('с ',' до '),array('','-'),$arItem['PROPERTIES']['OPENING_HOURS']['VALUE']);?>"><?=$arItem['PROPERTIES']['OPENING_HOURS']['VALUE']?></time>
<?php
    }?>
                    </p>                    
<?php
    if($arItem['PROPERTIES']['TELEPHONE']['VALUE']){?>
                    <p class="address-tel" itemprop="telephone"><?=$arItem['PROPERTIES']['TELEPHONE']['VALUE']?></p>
<?php
    } 
    if($arItem['PROPERTIES']['EMAIL']['VALUE']){?>
                    <p itemprop="email"><?=$arItem['PROPERTIES']['EMAIL']['VALUE']?></p>
<?php
    }?>
                  </div>
                </div>
              </div>	        
<?}?>