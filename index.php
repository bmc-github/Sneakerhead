<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
  $APPLICATION->SetPageProperty('title', 'Интернет магазин кроссовок, одежды и обуви с доставкой по Москве, России и заграницу Sneakerhead');
  $APPLICATION->SetPageProperty('keywords', 'online shop footwear clothing accessories sports brands moscow');
  $APPLICATION->SetPageProperty('description', 'Sneakerhead – один из самых больших сетевых магазинов кроссовок в России и СНГ. Интернет-магазин «Сникерхед» предлагает оригинальную одежду и обувь Nike, adidas, Jordan, Reebok, New Balance, ASICS и др. Купить кроссовки с доставкой по всему миру.');
?>
<?if(SITE_TEMPLATE_ID == "sd"){?>

    <div class="slideshow">
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"slider-main", 
	array(
		"IBLOCK_TYPE" => "services",
		"IBLOCK_ID" => "7",
		"NEWS_COUNT" => "6",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
		"CACHE_TYPE" => "N",
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
		"PARENT_SECTION" => "46",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "N",
		"STRICT_SECTION_CHECK" => "Y",
		"COMPONENT_TEMPLATE" => "slider-main",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => ""
	),
	false
);?> 
    </div>

    <main class="container">
      <div class="row">      
        <div class="col-xs-9">
          <div itemscope itemtype="http://schema.org/Service"><!-- Новинки -->
            <meta itemprop="serviceType" content="Продажа кроссовок, спортивной одежды и обуви" />
            <meta itemprop="areaServed" content="Россия, СНГ" />
            <div itemprop="provider" itemscope itemtype="http://schema.org/Organization">
              <meta itemprop="name" content="Интернет-магазин «Сникерхед»" />
              <meta itemprop="telephone" content="+7 (495) 647-88-20" />
              <meta itemprop="address" content="125445, Москва, ул. Беломорская, 13-1-408" />
            </div>
            <table class="nice-line-header">
              <thead></thead>
              <tbody>
                <tr>
                  <td class="nice-line-header-title"><p><?=GetMessage('H_ISNEW');?></p></td>
                  <td class="nice-line-header-subtitle"><div><a href="/isnew/"><?=GetMessage('H_ISNEW_ALL');?></a></div></td>
                </tr>
              </tbody>
            </table>                  
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"new-main",
	array(
		"IBLOCK_TYPE" => "services",
		"IBLOCK_ID" => "7",
		"NEWS_COUNT" => "1",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
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
		"PARENT_SECTION" => "48",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "N",
		"STRICT_SECTION_CHECK" => "Y",
	),
	false
);?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.top", 
	"novelties-main", 
	array(
		"COMPONENT_TEMPLATE" => "novelties-main",
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "2",
		"FILTER_NAME" => "",
		"CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[{\"CLASS_ID\":\"CondIBSection\",\"DATA\":{\"logic\":\"Equal\",\"value\":56}},{\"CLASS_ID\":\"CondIBSection\",\"DATA\":{\"logic\":\"Equal\",\"value\":1}}]}",
		"HIDE_NOT_AVAILABLE" => "Y",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"ELEMENT_SORT_FIELD" => "DATE_CREATE",
		"ELEMENT_SORT_ORDER" => "desc",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER2" => "asc",
		"OFFERS_SORT_FIELD" => "DATE_CREATE",
		"OFFERS_SORT_ORDER" => "desc",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER2" => "asc",
		"ELEMENT_COUNT" => "4",
		"LINE_ELEMENT_COUNT" => "3",
		"PROPERTY_CODE" => array(
			0 => "BRAND",
			1 => "NEW",
			2 => "",
		),
		"PROPERTY_CODE_MOBILE" => array(
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_PROPERTY_CODE" => array(
			0 => "SIZES_SHOES",
			1 => "ARTNUMBER",
			2 => "COLOR_REF",
			3 => "SIZES_CLOTHES",
			4 => "",
		),
		"OFFERS_LIMIT" => "3",
		"VIEW_MODE" => "SECTION",
		"TEMPLATE_THEME" => "blue",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"ADD_PICT_PROP" => "-",
		"LABEL_PROP" => array(
		),
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"SHOW_OLD_PRICE" => "Y",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_CLOSE_POPUP" => "N",
		"PRODUCT_SUBSCRIPTION" => "Y",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'0','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"ENLARGE_PRODUCT" => "STRICT",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
		"SHOW_SLIDER" => "N",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"SECTION_URL" => "#SECTION_CODE_PATH#/",
		"DETAIL_URL" => "#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"SEF_MODE" => "Y",
		"SEF_RULE" => "",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "N",
		"CACHE_FILTER" => "N",
		"COMPATIBLE_MODE" => "Y",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"CONVERT_CURRENCY" => "N",
		"BASKET_URL" => "/shopping-cart/",
		"USE_PRODUCT_QUANTITY" => "Y",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRODUCT_PROPERTIES" => array(
		),
		"OFFERS_CART_PROPERTIES" => array(
		),
		"ADD_TO_BASKET_ACTION" => "ADD",
		"DISPLAY_COMPARE" => "N",
		"MESS_BTN_COMPARE" => "Сравнить",
		"COMPARE_NAME" => "CATALOG_COMPARE_LIST",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"OFFER_ADD_PICT_PROP" => "-",
		"OFFER_TREE_PROPS" => array(
			0 => "SIZES_SHOES",
		),
		"DISCOUNT_PERCENT_POSITION" => "bottom-right",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>
            <div class="clearfix"></div>
          </div>
          <div><!-- Бренды -->
            <table class="nice-line-header">
              <thead></thead>
              <tbody>
                <tr>
                  <td class="nice-line-header-title"><p><?=GetMessage('H_BRANDS');?></p></td>
                  <td class="nice-line-header-subtitle"><div><a href="/brands/"><?=GetMessage('H_BRANDS_ALL');?></a></div></td>
                </tr>
              </tbody>
            </table>
            <div class="row">
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"brands-main",
	array(
		"IBLOCK_TYPE" => "services",
		"IBLOCK_ID" => "7",
		"NEWS_COUNT" => "3",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
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
		"PARENT_SECTION" => "47",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "N",
		"STRICT_SECTION_CHECK" => "Y",
	),
	false
);?> 
            </div>
            <div class="clearfix"></div>
          </div>
          <!-- categories -->
          <div class="row" style="margin-top:35px;">
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"clothes-main",
	array(
		"IBLOCK_TYPE" => "services",
		"IBLOCK_ID" => "7",
		"NEWS_COUNT" => "3",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"PARENT_SECTION" => "49",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "N",
		"STRICT_SECTION_CHECK" => "Y",
		"PROPERTY_CODE" => array("NAME"),
	),
	false
);?> 
          </div>
          <div class="col-xs-12"><!-- внешние слайдеры -->
            <div class="row featured_block" style="background-color: #fff;padding: 0 15px; margin-bottom: 15px">
              <div data-retailrocket-markup-block="57ea4cd29872e5765454b578" ></div>
            </div>
          </div>
        </div>
        <div class="col-xs-3 main-right-side">
          <div class="column-right"><!-- статьи -->
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"news-main", 
	array(
		"IBLOCK_TYPE" => "news",
		"IBLOCK_ID" => "1",
		"NEWS_COUNT" => "6",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
	),
	false
);?>
            <script>
              var random = Math.floor(Math.random() * $('.metro-link-right-banner').length);
              $('.metro-link-right-banner').hide().eq(random).show();
            </script>
          </div>
        </div>
      </div><?echo '<!--noindex-->';?>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-xs-6">
          <div class="insagramm-onindex-wr">
            <a href="//www.instagram.com/sneakerheadrussia/" target="_blank" rel="nofollow">
              <div class="instagramBox">
                SNEAKERHEAD INSTAGRAM <img src="<?=SITE_TEMPLATE_PATH?>/images/shinsta.png" alt="" />
              </div>
            </a>
            <script src="//lightwidget.com/widgets/lightwidget.js"></script>
            <iframe src="//lightwidget.com/widgets/21c6bb7963b051699ca18305bac0ee24.html" id="lightwidget_21c6bb7963" name="lightwidget_21c6bb7963"  scrolling="no" allowtransparency="true" class="lightwidget-widget" style="width: 100%; border: 0; overflow: hidden;"></iframe>    
          </div>
        </div>
        <div class="col-xs-3">
          <a class="support" href="/faq/" rel="nofollow">
            <p class="supportTitle"><?=GetMessage('H_SUPPORT')?></p>
            <p class="supportPodTitle"><?=GetMessage('H_SUPPORT_TITLE')?></p>
          </a>
        </div>
        <div class="col-xs-3">
          <div class="podpiska-wr">
            <p class="podpiska-title"><?=GetMessage('H_SUBSCRIBE')?></p>
            <table>
              <tbody>
                <tr>
                  <td><input type="text" name="subscr_mail" placeholder="E-mail" class="podpiska-input isrequired" onblur="var regex = /^([a-zA-Z0-9_.+-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;if(regex.test(this.value)) { try {rrApi.setEmail(this.value);rrApi.welcomeSequence(this.value); }catch(e){}}"></td>
                  <td width="24"><button class="ajaxgo"></button></td>
                </tr>
              </tbody>
            </table>
            <div class="podpiska-successmsg"></div>
            <p style="font-size: 12px"><input type="checkbox" name="option1" value="a1" checked disabled /> <?=GetMessage('H_AGREEMENT')?> <a href="/privacy/" rel="nofollow"><?=GetMessage('H_AGREEMENT_PRIVACY')?></a></p>
          </div>
        </div>
        <div class="clearfix"></div>
      </div><?echo '<!--/noindex-->';?>
    </main>
    <script>      
      $(".subscribe-me").subscribeBetter({
        trigger: "atendpage",
        animation: "fade",
        delay: 0,
        showOnce: true,
        autoClose: false,
        scrollableModal: false
      });
      $(document.body).on("click", ".ajaxgo", send);    
      $(document.body).on("focus", "input", function(){$(this).css("border","");});    
      function send(){
        var wr = $(this).parents(".podpiska-wr");
        var validate = true;
        wr.find(".isrequired").each(function(){
          if(!$(this).val().length){validate = false; $(this).css("border","1px solid #D22")}
        });
        if (validate){
          var need = {};
          need['header'] = "Заявка на подписку";
          need['fields'] = [];
          wr.find("input").each(function(){
            var fieldElement = {};
            fieldElement['type'] = $(this).attr("type") || 'text';
            fieldElement['title'] = $(this).attr("placeholder");
            fieldElement['value'] = $(this).val();
            need['fields'][need['fields'].length] = fieldElement;
          });
          output = JSON.stringify(need);
          $.ajax({
            type: "POST",
            data: {data1: output},
            url:'/mail.php',
            dataType:'json',
            success: function(data){
              wr.find(".ajaxgo").hide();
              wr.find("table").hide();
              wr.find(".podpiska-successmsg").html(data.result);
              wr.find(".podpiska-successmsg").fadeIn(300).css("display","inline-block");
            },
            error: function (xhr, ajaxOptions, thrownError){
              console.log(xhr.responseText);
            }
          });
        }
      }

    </script>

<?}else{?>

    <div id="Glide2" class="glide">
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"slider-main", 
	array(
		"IBLOCK_TYPE" => "services",
		"IBLOCK_ID" => "7",
		"NEWS_COUNT" => "6",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
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
		"PARENT_SECTION" => "46",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "N",
		"STRICT_SECTION_CHECK" => "Y",
	),
	false
);?> 
    </div>
    <main class="container">
      <div class="row">
        <div class="">
          <div class="categories">
            <ul>
              <li><a href="/isnew/"><?=GetMessage('H_ISNEW')?></a></li>
              <li><a href="/shoes/sneakers/"><?=GetMessage('H_SNEAKERS')?></a></li>
              <li><a href="/clothes/"><?=GetMessage('H_CLOTHES')?></a></li>
            </ul>
          </div>
<?/*if($banners){
    foreach ($banners as $banner) {?>
          <div class = "metro-link-right-banner">
            <a href="<?php echo $banner['link']; ?>">
              <img src ="image/<?php echo $banner['image']; ?>">
            </a>
          </div>
<?php  }}*/?>
          <div class="novinki">
            <div class="moduleHeader">
              <h3><?=GetMessage('H_ISNEW')?></h3>
            </div>
            <div class="newsItems items">
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.top", 
	"novelties-main", 
	array(
		"COMPONENT_TEMPLATE" => "novelties-main",
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "2",
		"FILTER_NAME" => "",
		"CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[{\"CLASS_ID\":\"CondIBProp:2:6\",\"DATA\":{\"logic\":\"Equal\",\"value\":1}}]}",
		"HIDE_NOT_AVAILABLE" => "N",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER2" => "desc",
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER2" => "desc",
		"ELEMENT_COUNT" => "4",
		"LINE_ELEMENT_COUNT" => "2",
		"PROPERTY_CODE" => array(
			0 => "NEW",
			1 => "BRAND",
			2 => "",
		),
		"PROPERTY_CODE_MOBILE" => array(
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_PROPERTY_CODE" => array(
			0 => "ARTNUMBER",
			1 => "COLOR_REF",
			2 => "SIZES_SHOES",
			3 => "SIZES_CLOTHES",
			4 => "",
		),
		"OFFERS_LIMIT" => "0",
		"VIEW_MODE" => "SECTION",
		"TEMPLATE_THEME" => "blue",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"ADD_PICT_PROP" => "-",
		"LABEL_PROP" => array(
		),
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"SHOW_OLD_PRICE" => "Y",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_CLOSE_POPUP" => "N",
		"PRODUCT_SUBSCRIPTION" => "Y",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"ENLARGE_PRODUCT" => "STRICT",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
		"SHOW_SLIDER" => "N",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"SECTION_URL" => "#SECTION_CODE_PATH#/",
		"DETAIL_URL" => "#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"SEF_MODE" => "Y",
		"SEF_RULE" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"CACHE_FILTER" => "N",
		"COMPATIBLE_MODE" => "Y",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"CONVERT_CURRENCY" => "N",
		"BASKET_URL" => "/shopping-cart/",
		"USE_PRODUCT_QUANTITY" => "Y",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRODUCT_PROPERTIES" => array(
		),
		"OFFERS_CART_PROPERTIES" => array(
		),
		"ADD_TO_BASKET_ACTION" => "ADD",
		"DISPLAY_COMPARE" => "N",
		"MESS_BTN_COMPARE" => "Сравнить",
		"COMPARE_NAME" => "CATALOG_COMPARE_LIST",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"OFFER_ADD_PICT_PROP" => "-",
		"OFFER_TREE_PROPS" => array(
			0 => "SIZES_SHOES",
		),
		"DISCOUNT_PERCENT_POSITION" => "bottom-right"
	),
	false
);?>
              <div data-retailrocket-markup-block="57ea4cd29872e5765454b578"></div>
            </div>
            <?/*<a style="margin:0 5px" id="loadMore" href="/new/">Все новинки</a>*/?>
          </div>
          <div class="brands">
            <div class="moduleHeader">
              <h3><?=GetMessage('H_BRANDS')?></h3>
              <a href="/brands/"><?=GetMessage('H_BRANDS_ALL')?></a>
            </div>
            <div id="Glide" class="glide">
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"brands-main",
	array(
		"IBLOCK_TYPE" => "services",
		"IBLOCK_ID" => "7",
		"NEWS_COUNT" => "3",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
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
		"PARENT_SECTION" => "47",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "N",
		"STRICT_SECTION_CHECK" => "Y",
	),
	false
);?> 
            </div>
          </div>
        </div>
        <div class="news" style="margin-top:25px;">
          <div class="moduleHeader">
            <h3><?=GetMessage('H_NEW_IN_BLOG')?></h3>
          </div>
          <div id="Glide3" class="glide">
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"news-main", 
	array(
		"IBLOCK_TYPE" => "news",
		"IBLOCK_ID" => "1",
		"NEWS_COUNT" => "6",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
	),
	false
);?>
          </div>
          <div style="text-align:right;">
            <a style="margin:39px 5px 0" id="loadMore" href="/blog/"><?=GetMessage('H_VIEW_ALL')?></a>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
    </main>
    <script>
      $("#Glide2").glide({
        type: "carousel"
      });
      $("#Glide").glide({
        type: "carousel",
        autoplay: false
      });
      $("#Glide3").glide({
        type: "carousel",
        autoplay: false
      });
      //$('.header_wrapper').css('height', '0px');
      var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
      if(width < 420){
        $("#Glide").glide({
          type: "carousel",
          autoplay: false
        });
      }else{
        $("#Glide").glide({
          type: "carousel",
          paddings: 200,
          autoplay: false
        });
      }
      var random = Math.floor(Math.random() * $('.metro-link-right-banner').length);
      $('.metro-link-right-banner').hide().eq(random).show();
    </script>

<?}?>
<script>
var _tmr = _tmr || [];
_tmr.push({
    id: '3065581',
    type: 'itemView',
    productid: '',
    pagetype: 'home',
    list: '1',
    totalvalue: ''
});
</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>