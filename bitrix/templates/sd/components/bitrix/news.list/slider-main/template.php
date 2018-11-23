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
      <ul id="slideshow0">   
<?foreach($arResult["ITEMS"] as $arItem){
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
?>
        <li class="lazy_load" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
<?php
    if($arItem['CODE']){?>
          <a class="ss" href="<?=$arItem['CODE']?>" onclick="return promoClick('<?=$arItem['ID']?>', '<?=$arItem['NAME']?>');">
            <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>" />
          </a>
          <?=str_replace('href=""', 'href="'.$arItem['CODE'].'"', htmlspecialchars_decode($arItem['PREVIEW_TEXT']));?>
<?php
    }else{?>
          <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>" />
          <?=htmlspecialchars_decode($arItem['PREVIEW_TEXT']);?>
<?php
    }?>
        </li>
<?php
    $gtm[] = "{'id': '".$arItem['ID']."', 'name': '".$arItem['NAME']."', 'creative': '', 'position': 'Вверх главной страницы'}";
  }?>
      </ul>
      <script>
        $('.header_wrapper').css('height', '0px');
        $(document).ready(function () {
          $('#slideshow0').bxSlider({
            auto: true,
            mode: "fade",
            pause: 8000,
            pager: true
          });  
          dataLayer.push({
            'ecommerce':{
              'promoView':{
                'promotions':[{'id': '9_', 'name': ' ', 'creative': '', 'position': 'Вверх главной страницы' },
                              {'id': '9_', 'name': ' ', 'creative': '', 'position': 'Вверх главной страницы' },
                              {'id': '9_', 'name': ' ', 'creative': '', 'position': 'Вверх главной страницы' },
                              {'id': '9_', 'name': ' ', 'creative': '', 'position': 'Вверх главной страницы' },
                              {'id': '9_', 'name': ' ', 'creative': '', 'position': 'Вверх главной страницы' },
                              {'id': '9_', 'name': ' ', 'creative': '', 'position': 'Вверх главной страницы' }]
              }
            },
            'event': 'gtm-ee-event',
            'gtm-ee-event-category': 'Enhanced Ecommerce',
            'gtm-ee-event-action': 'Promo Views',
            'gtm-ee-event-non-interaction': 'False',
          });
          //$(".bx-viewport").height($(window).height());//убрать коммент
 <?/*   
          var $video = $('#vid');
          $video.on('canplaythrough', function(){
            this.play();
          });
          var $sl = $('.bx-viewport > #slideshow100');
          $sl.css('height', $video.height());      */?>
        });

        function promoClick(id, name){
          dataLayer.push({
            'ecommerce':{
              'click':{
                'actionField': {'list': 'Баннеры на главной'},
                'products': [{'id': id, 'name': name, 'creative': '', 'position': 'Верх главной страницы'}]
              }
            },
            'event': 'gtm-ee-event',
            'gtm-ee-event-category': 'Enhanced Ecommerce',
            'gtm-ee-event-action': 'Promotion Click',
            'gtm-ee-event-non-interaction': 'False',
          });
        }
      </script>
      <script>
        $(document).ready(function(){
          $('.main-slider').bxSlider({pager:false, controls:false,auto:true});
          setTimeout(function(){
            $('select').filter(function(){
              var validate = true;
              if($(this).parents('.checkout-steps-contents').length){
                validate = false;
              }
              if($(this).hasClass('product-size-option')){
                validate = false;
              }
              if($(this).hasClass('no_formstyling')){
                validate = false;
              }
              return validate;
            }).styler({
              onFormStyled:function(){
                $('select').filter(function(){
                  if($(this).hasClass('select_onwhite')){
                    return true;
                  }else{
                    return false;
                  }
                }).parent('.jq-selectbox').find('.jq-selectbox__select').addClass('slyled_select_onwhite');
              }
            });
          }, 300)      
        });
      </script>