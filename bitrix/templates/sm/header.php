<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
  if(!($_REQUEST['lang_code'])||$_REQUEST['lang_code']=='')
    $_REQUEST['lang_code'] = 'ru';
  if(isset($_SESSION['lang']) && $_SESSION['lang'] != '')
    $_REQUEST['lang_code'] = $_SESSION['lang'];
  IncludeTemplateLangFile(__file__, $_REQUEST['lang_code']);
  CJSCore::Init(array("fx"));
  $curPage = $APPLICATION->GetCurPage(false);
  if($_SERVER['REAL_FILE_PATH'] == '/blog/index.php') $prefix=' prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#"';
?>
<!DOCTYPE html>
<html dir="ltr" lang="<?=$_REQUEST['lang_code']?>">
  <head<?=$prefix?>>
    <meta charset="utf-8" />
    <title><?$APPLICATION->ShowTitle()?></title>
    <?$APPLICATION->ShowHead();?>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <?
    $APPLICATION->SetAdditionalCSS("//fonts.googleapis.com/css?family=Roboto:100,300,400,500,700&subset=latin,cyrillic");
    $APPLICATION->SetAdditionalCSS("//fonts.googleapis.com/css?family=PT+Sans:100,300,400,500,700&subset=latin,cyrillic");
    $APPLICATION->SetAdditionalCSS("//fonts.googleapis.com/css?family=Open+Sans:100,300,400,500,700&subset=latin,cyrillic");
    $APPLICATION->SetAdditionalCSS("//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css");
    ?>

    <link rel="stylesheet" href="<?= autoVersion(SITE_TEMPLATE_PATH . '/css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= autoVersion(SITE_TEMPLATE_PATH . '/css/stylesheet-9.css') ?>" />
    <link rel="stylesheet" href="<?= autoVersion(SITE_TEMPLATE_PATH . '/css/mobile.css') ?>" />
    <link rel="stylesheet" href="<?= autoVersion(SITE_TEMPLATE_PATH . '/css/mobile.min.v5.css') ?>" />

    <?
    $APPLICATION->SetAdditionalCSS("/bitrix/templates/sd/css/jquery.bxslider.css");
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/jquery.fancybox.css");
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/jquery.formstyler.css");

    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/glide.core.min.css");
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/glide.theme.min.css");
if($curPage == '/'){
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/news.css");
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/coin-slider-styles.css");
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/jquery.bxslider.css");
}elseif($_SERVER['REAL_FILE_PATH'] == '/blog/index.php' || $curPage == '/blog/'){
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/tilda-grid-3.0.min.css");
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/tilda-blocks-2.12.css");
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/tilda-zoom-1.0.min.css");
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/news.css");
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/colorbox.css");
}
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.min.js");
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery-ui-1.8.16.custom.min.js");
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.bxslider.min.js");
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.fancybox.pack.js");
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.formstyler.min.js");
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.lazyload.min.js");
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/glide.min.js");
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/mobile.min.js");
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/categories-nav.js");
    $APPLICATION->AddHeadString(
    '<!--[if IE 7]>
    <link rel="stylesheet" href="'.SITE_TEMPLATE_PATH.'/css/ie7.css" />
    <![endif]-->
    <!--[if lt IE 7]>
    <link rel="stylesheet" href="'.SITE_TEMPLATE_PATH.'/css/ie6.css" />
    <script src="'.SITE_TEMPLATE_PATH.'/js/DD_belatedPNG_0.0.8a-min.js"></script>
    <script>
      DD_belatedPNG.fix("#logo img");
    </script>
    <![endif]-->');
    ?>
    <link href="//cdn.jsdelivr.net/npm/suggestions-jquery@17.12.0/dist/css/suggestions.min.css" rel="stylesheet" />
<!--[if lt IE 10]><script src="//cdnjs.cloudflare.com/ajax/libs/jquery-ajaxtransport-xdomainrequest/1.0.1/jquery.xdomainrequest.min.js"></script><![endif]-->
    <script src="//cdn.jsdelivr.net/npm/suggestions-jquery@17.12.0/dist/js/jquery.suggestions.min.js"></script>
	  <?/*    <script>
    $(document).ready (function () {
      $("#soa-property-7").suggestions({
        serviceUrl: "https://dadata.ru/api/v2",
        token: "ce370a953e5d1a97747c059fe309f034bae97ece",
        type: "ADDRESS",
        count: 5,
        onSelect: function(suggestion) {
            console.log(suggestion);
        }
      });
    });
</script>*/ ?>
    <script src="//cdn.sendpulse.com/28edd3380a1c17cf65b137fe96516659/js/push/8371327a4864f5821ce14662cb5fec28_1.js" async></script>
    <script> var rrPartnerId = "55379e776636b417f47acd68";
      var rrApi = {};
      var rrApiOnReady = rrApiOnReady || [];
      rrApi.addToBasket = rrApi.order = rrApi.categoryView = rrApi.view = rrApi.recomMouseDown = rrApi.recomAddToCart = function(){};
      (function(d) {
        var ref = d.getElementsByTagName('script')[0];
        var apiJs, apiJsId = 'rrApi-jssdk';
        if (d.getElementById(apiJsId)) return;
        apiJs = d.createElement('script');
        apiJs.id = apiJsId;
        apiJs.async = true;
        apiJs.src = "//cdn.retailrocket.ru/content/javascript/api.js";
        ref.parentNode.insertBefore(apiJs, ref);
      }(document));
      dataLayer = [];
      function onCheckoutOption(step){
        window.dataLayer = window.dataLayer || [];
        dataLayer.push({
          'ecommerce': {
            'currencyCode': 'RUB',
            'checkout': {
              'actionField': {'step': step}
            }
          },
          'event': 'gtm-ee-event',
          'gtm-ee-event-category': 'Enhanced Ecommerce',
          'gtm-ee-event-action': 'Checkout Step '+step,
          'gtm-ee-event-non-interaction': 'False',
        });
        console.log(step);
      }
    </script>
    <script>
      dataLayer.push({
        'userId': '<?=$userId?>'
      });
    </script>
    <?$APPLICATION->ShowPanel()?>
  </head>
  <body>
    <header>
      <?/*
      <style>
        .topline p {
          display: inline-block;
          padding: 3px 0;
          color: #fff;
          text-transform: uppercase;
          font-weight: 400;
          font-size: 11px;
              margin-bottom: 0px;
      }
      </style>
      <div class="topline" style="height: auto; background-color: #ef0d22; position: relative;text-align: center;">
        <div class="promo">
          <p style="width: 100%; color: #fff; font-size: 12px; font-weight: 300; padding: 5px 0">Внимание!</br>
          В связи с техническими проблемами сегодня мы не принимаем звонки и не отвечаем на любые сообщения.</br> Приносим свои извинения.</p>
          <!--  <a href="/new-year-sale/" style="display: inline;color: #fff; font-size: 11px; text-decoration: underline; padding: 5px 15px">Условия акции</a>
            <a href="/sale/" style="display: inline;color: #fff; font-size: 11px; text-decoration: underline; padding: 5px 15px">Перейти к покупкам</a>-->
        </div>
      </div>
      */ ?>
      <div class="header">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="btnMenu">
                <span class="iconBar"></span>
                <span class="iconBar"></span>
                <span class="iconBar"></span>
              </div>
              <a class="logo" href="/" title="">
                <img src="<?=SITE_TEMPLATE_PATH?>/images/logo.svg" alt="" />
              </a>
              <div class="iconsBox">
                <a href="tel:+78007003253" class="call"></a>
<?$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket.small",
	"",
	array(
		"PATH_TO_BASKET" => "/shopping-cart/",
		"PATH_TO_ORDER" => "/checkout/",
		"SHOW_DELAY" => "Y",
		"SHOW_NOTAVAIL" => "Y",
		"SHOW_SUBSCRIBE" => "Y"
	),
	false
);?>
                <label class="search"></label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="categories-nav categories-nav--scroll-start categories-nav--scroll-end">
        <div class="categories-nav__scroll">
          <ul class="categories-nav__list">
            <li class="categories-nav__item">
              <a class="categories-nav__link" href="#" title="Новинки">Новинки</a>
            </li>
            <li class="categories-nav__item">
              <a class="categories-nav__link" href="#" title="Бренды">Бренды</a>
            </li>
            <li class="categories-nav__item">
              <a class="categories-nav__link" href="#" title="Обувь">Обувь</a>
            </li>
            <li class="categories-nav__item">
              <a class="categories-nav__link" href="#" title="Одежда">Одежда</a>
            </li>
            <li class="categories-nav__item">
              <a class="categories-nav__link" href="#" title="Аксессуары">Аксессуары</a>
            </li>
            <li class="categories-nav__item categories-nav__item--active">
              <a class="categories-nav__link" href="#" title="Распродажа">Распродажа</a>
            </li>
          </ul>
        </div>
      </div>
      <a class="sale-banner" href="/sale/" title="Финальная распродажа">
        <div class="sale-banner__inner">Финальная распродажа &rarr;</div>
      </a>
      <!-- Всплывающий блок поиска -->
      <div class="searchContainer">
        <div class="searchBox">
          <div class="container">
<?$APPLICATION->IncludeComponent(
	"bitrix:search.form",
	".default",
	array(
		"USE_SUGGEST" => "N",
		"PAGE" => "#SITE_DIR#search/",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?>
          </div>
        </div>
      </div>
      <!-- Меню -->
      <div class="menuContainer" style="width:0">
        <a class="topLogo" href="/" title="<?=GetMessage('H_LOGO_TITLE');?>">
          <img src="<?=SITE_TEMPLATE_PATH?>/images/logo.svg" alt="<?=GetMessage('H_LOGO_ALT');?>" />
        </a>
        <div class="menu">
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"topmenu",
	array(
		"COMPONENT_TEMPLATE" => "topmenu",
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "2",
		"SECTION_ID" => "",
		"SECTION_CODE" => "",
		"COUNT_ELEMENTS" => "Y",
		"TOP_DEPTH" => "1",
		"SECTION_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SECTION_USER_FIELDS" => array(
			0 => "UF_NAME",
			1 => "UF_IS_ACTION",
		),
		"VIEW_MODE" => "LIST",
		"SHOW_PARENT_NAME" => "Y",
		"SECTION_URL" => "",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"ADD_SECTIONS_CHAIN" => "N"
	),
	false
);?>
        </div>
        <div class="bottomAdd">
        <?if(!$USER->IsAuthorized()){?>
          <p><a href="/login/"><?=GetMessage('H_LOGIN');?></a></p>
        <?}else{?>
          <p><a href="/personal/orders/"><?=GetMessage('H_PERSONAL');?></a></p>
        <?}?>
          <p><a href="/delivery"><?=GetMessage('H_DELIVERY_AND_PAYMENT');?></a></p>
          <p><a href="/return/"><?=GetMessage('H_RETURN');?></a></p>
          <p><a href="/contacts-page/"><?=GetMessage('H_SHOP_ADDRESSES');?></a></p>
          <p><a href="tel:+78007003253">+7(800)700-32-53</a></p>
        </div>
        <div class="bottomSoc">
          <div class="socialBox">
            <a href="//vk.com/sneakerhead_ru" class="round-icon-link vk" target="_blank"><i class=""></i></a>
            <a href="//instagram.com/sneakerheadrussia" class="round-icon-link in" target="_blank"><i class=""></i></a>
            <a href="//www.facebook.com/pages/SneakerHead-Russia/163152103698950" class="round-icon-link fb" target="_blank"><i class=""></i></a>
            <a href="//www.youtube.com/user/snkrhdstore" class="round-icon-link yo" target="_blank"><i class=""></i></a>
          </div>
        </div>
      </div>
    </header>
    <div id="notification"></div>
<?if($_SERVER['REAL_FILE_PATH'] == '/blog/index.php' || $curPage == '/blog/'):?>
    <div class="blog_container">
<?endif;
  if(in_array($curPage,array('/login/','/create-account/'))):?>
    <div class="container_login">
<?elseif($curPage == '/' || in_array($_SERVER['REAL_FILE_PATH'],array('/catalog/index.php','/catalog/detail.php','/brands/index.php'))):?>
<?else:?>
    <div class="container <?=$APPLICATION->ShowProperty('class');?>">
<?/*$APPLICATION->IncludeComponent("bitrix:breadcrumb", "", array(
		"START_FROM" => "0",
		"PATH" => "",
		"SITE_ID" => "-"
	),
	false,
	Array('HIDE_ICONS' => 'Y')
);*/?>
      <?/*<h1><?$APPLICATION->ShowTitle(false)?></h1>*/?>
<?endif;
  if($_SERVER['REAL_FILE_PATH'] == '/blog/index.php' || $curPage == '/blog/'):?>
    </div>
<?endif;?>