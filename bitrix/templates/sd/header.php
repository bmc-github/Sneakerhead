<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)die();
  

  if(!($_REQUEST['lang_code'])||$_REQUEST['lang_code']=='')
    $_REQUEST['lang_code'] = 'ru';
  if(isset($_SESSION['lang']) && $_SESSION['lang'] != '')
    $_REQUEST['lang_code'] = $_SESSION['lang'];
  IncludeTemplateLangFile(__file__, $_REQUEST['lang_code']);
  CJSCore::Init(array("fx"));
  $curPage = $APPLICATION->GetCurPage(false);
  //if($page == '/contacts/') $prefix=' prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# business: http://ogp.me/ns/business# place: http://ogp.me/ns/place#"';
  //if(in_array($_SERVER["REAL_FILE_PATH"],array('/catalog/index.php','/catalog-sale/index.php'))) $prefix=' prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# product: http://ogp.me/ns/product#"';
  if($_SERVER['REAL_FILE_PATH'] == '/blog/index.php') $prefix=' prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#"';
  header('X-UA-Compatible: IE=edge');

  $_REQUEST['lang_code']=preg_replace('/[^a-zA-Z0-9\s]/', '', strip_tags(html_entity_decode($_REQUEST['lang_code'])));

?>
<!DOCTYPE html>
<html xml:lang="<?=$_REQUEST['lang_code']?>" lang="<?=$_REQUEST['lang_code']?>">
  <head<?=$prefix?>>
    <meta charset="utf-8" />
    <title><?$APPLICATION->ShowTitle()?></title>
    <?$APPLICATION->ShowHead();
      $APPLICATION->SetAdditionalCSS("//fonts.googleapis.com/css?family=Roboto:100,300,400,500,600,700&subset=latin,cyrillic");
      $APPLICATION->SetAdditionalCSS("//fonts.googleapis.com/css?family=PT+Sans:100,300,400,500,600,700&subset=latin,cyrillic");
      $APPLICATION->SetAdditionalCSS("//fonts.googleapis.com/css?family=Open+Sans:100,300,400,500,600,700&subset=latin,cyrillic");
      $APPLICATION->SetAdditionalCSS("//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");?>
    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/css/stylesheet.css" />
    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/css/stylesheet-2.css" />
    <?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/jquery.bxslider.css");
      $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/jquery.fancybox.css");
      $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/jquery.growl.css");
      $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/svg_icons.css");
      $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/filterpro2.css");
      $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/jquery.formstyler.css");
      $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/subscribe-better.css");
   if($curPage == '/'){
      $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/news.css");
      $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/coin-slider-styles.css");
      $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/jquery.bxslider.css");
   }elseif($_SERVER['REAL_FILE_PATH'] == '/blog/index.php' || $curPage == '/blog/'){
      $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/jquery.bxslider.css");
      $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/tilda-grid-3.0.min.css");
      $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/tilda-blocks-2.12.css");
      $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/tilda-zoom-1.0.min.css");
      $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/news.css");
      $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/colorbox.css");
   }
      $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery-1.7.1.min.js");
      $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery-ui-1.8.16.custom.min.js");
      $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/common.js");
      $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.bxslider.min.js");
      $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.fancybox.pack.js");
      $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.formstyler.min.js");
      $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.zoom.min.js");
      $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.growl.js");
      $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.subscribe-better.js");
      $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.sticky.js");
      $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.lazyload.min.js");
      $APPLICATION->AddHeadString('<!--[if IE 7]>
    <link rel="stylesheet" href="'.SITE_TEMPLATE_PATH.'/css/ie7.css" />
    <![endif]-->
    <!--[if lt IE 7]>
    <link rel="stylesheet" href="'.SITE_TEMPLATE_PATH.'css/ie6.css" />
    <script src="'.SITE_TEMPLATE_PATH.'/js/DD_belatedPNG_0.0.8a-min.js"></script>
    <script>DD_belatedPNG.fix("#logo img");</script>
    <![endif]-->');
?>   
    <link href="//cdn.jsdelivr.net/npm/suggestions-jquery@17.12.0/dist/css/suggestions.min.css" rel="stylesheet" />
    <!--[if lt IE 10]><script src="//cdnjs.cloudflare.com/ajax/libs/jquery-ajaxtransport-xdomainrequest/1.0.1/jquery.xdomainrequest.min.js"></script><![endif]-->
    <script src="//cdn.jsdelivr.net/npm/suggestions-jquery@17.12.0/dist/js/jquery.suggestions.min.js"></script>
    <script>
      var rrPartnerId = "55379e776636b417f47acd68";
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
      function onCheckoutOption(step) {
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
      }
      dataLayer.push({
        'userId': '<?=$USER->GetID()?>'
      });
    </script>
    <script charset="UTF-8" src="//cdn.sendpulse.com/28edd3380a1c17cf65b137fe96516659/js/push/8371327a4864f5821ce14662cb5fec28_1.js" async></script>
	  <?/*    <script src="//cdn.ravenjs.com/3.17.0/raven.min.js" crossorigin="anonymous"></script>
    <script>Raven.config('//3cbe2060630f48faab2de35261926379@sentry.io/195994').install();</script>
*/?>
    <?php if ($_REQUEST['PAGEN_1']) { $APPLICATION->AddHeadString('<link rel="canonical" href="' . $APPLICATION->GetCurDir() . '"/>'); } ?>

    <?$APPLICATION->ShowPanel()?>
  </head>
  <body><?if($curPage != '/') echo '<!--noindex-->';?>
    <?$APPLICATION->IncludeComponent("h2o:favorites.add", "", array());?>
    <div class="header_wrapper" style="height:102px">    
      <div class="topline">
        <div class="header-language">
          <form class="ga_language" action="" method="post" enctype="multipart/form-data">
<?


if($_REQUEST['lang_code'] != 'en'):?>
            <div id="language" onclick="$('input[name=\'lang_code\']').val('en');$(this).parent().submit();">
              <span class="active">RUS</span>
              <img src="<?=SITE_TEMPLATE_PATH?>/images/lang-active-ru.png" alt="English" title="English" />
              <span class="noactive">ENG</span>
<?else:?>
            <div id="language" onclick="$('input[name=\'lang_code\']').val('ru');$(this).parent().submit();">
              <span class="noactive">RUS</span>
              <img src="<?=SITE_TEMPLATE_PATH?>/images/lang-active-en.png" alt="Русский" title="Русский" />
              <span class="active">ENG</span>
<?endif;?>
              <input type="hidden" name="lang_code" value="" />
            </div>
          </form>
        </div>
<?if($USER->IsAuthorized()){?>
        <p><?=GetMessage('H_LOGGED_AS');?> <a href="/personal/"><?=$USER->GetFullName()?></a> ( <a href="?logout=yes"><?=GetMessage('H_LOGOUT');?></a> )</p>
<?}else{?><?if($curPage == '/') echo '<!--noindex-->';?>
        <p><a id="header-login" class="login-fancybox" href="/login/" rel="nofollow" data-fancybox-type="ajax"><?=GetMessage('H_LOGIN');?></a> <?=GetMessage('H_OR');?> 
        <a id="header-register" class="login-fancybox" href="/create-account/" rel="nofollow" data-fancybox-type="ajax"><?=GetMessage('H_REGISTER');?></a></p><?if($curPage == '/') echo '<!--/noindex-->';?>
<?}?>
        <a href="/delivery/"<?if($curPage != '/') echo ' rel="nofollow"';?>><?=GetMessage('H_DELIVERY_AND_PAYMENT');?></a>
        <a href="/contacts-page/"<?if($curPage != '/') echo ' rel="nofollow"';?>><?=GetMessage('H_SHOP_ADDRESSES');?></a>
        <a href="/blog/"<?if($curPage != '/') echo ' rel="nofollow"';?>><?=GetMessage('H_BLOG');?></a>        
        <div class="header-phone">         
          <div class="header-phone-right"><a href="tel:+78007003253">+7 800 700 32 53</a></div>
          <p class="hours">8:00 - 20:00</p>
          <div class="clearfix"></div>        
        </div>
      </div>
      <header>
        <div class="header-left"> 
          <div class="header-logo">
<?if($curPage != '/'){?>
            <a href="/" title="<?=GetMessage('H_LOGO_TITLE');?>">
              <img src="<?=SITE_TEMPLATE_PATH?>/images/logo.svg" alt="<?=GetMessage('H_LOGO_ALT');?>" />
            </a>
<?}else{?>
            <img src="<?=SITE_TEMPLATE_PATH?>/images/logo.svg" alt="<?=GetMessage('H_LOGO_ALT');?>" title="<?=GetMessage('H_LOGO_TITLE');?>" />
<?}?>
          </div>
        </div>
        <div class="header-main">
          <div class="header-main-top">
            <div class="header-main-bottom clearafter">
              <div class="header-categories">
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list", 
	"topmenu", 
	array(
		"COMPONENT_TEMPLATE" => "topmenu",
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "2",
		"SECTION_ID" => "",
		"SECTION_CODE" => "",
		"COUNT_ELEMENTS" => "N",
		"TOP_DEPTH" => "2",
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
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"ADD_SECTIONS_CHAIN" => "N"
	),
	false
);
?>
              </div><?if($curPage == '/') echo '<!--noindex-->';?>
              <div class="header-tech-links">
                <ul>
                  <li class="header-wish">
<?$APPLICATION->IncludeComponent("h2o:favorites.line", "", array("URL_LIST" => "/wishlist/"));?>
		  </li>
                  <li class="header-cart" id="topcart">
<?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.small", "", array(
        "PATH_TO_BASKET" => "/shopping-cart/",
        "PATH_TO_ORDER" => "/checkout/",
        "SHOW_DELAY" => "Y",
        "SHOW_NOTAVAIL" => "Y",
        "SHOW_SUBSCRIBE" => "Y"
  ), false);
?>
                  </li>
                </ul>
              </div>
              <div id="wrap">
<?$APPLICATION->IncludeComponent("bitrix:search.form", ".default", array(
        "USE_SUGGEST" => "N",
        "PAGE" => "#SITE_DIR#search/",
        "COMPONENT_TEMPLATE" => ".default"
  ), false);
?> 
              </div>
              <div class="header-social" style="width: auto;">
                <ul>
                  <li><a href="//vk.com/sneakerhead_ru" class="round-icon-link" target="_blank" rel="nofollow"><i class="ri-vk"></i></a></li>
                  <li><a href="//instagram.com/sneakerheadrussia" class="round-icon-link" target="_blank" rel="nofollow"><i class="ri-instagram"></i></a></li>
                  <li><a href="//www.facebook.com/pages/SneakerHead-Russia/163152103698950" class="round-icon-link" target="_blank" rel="nofollow"><i class="ri-facebook"></i></a></li>
                  <li><a href="//www.youtube.com/user/snkrhdstore" class="round-icon-link" target="_blank" rel="nofollow"><i class="ri-youtube"></i></a></li>
                </ul>
              </div><?if($curPage == '/') echo '<!--/noindex-->';?>
            </div>
          </div>
        </div>
      </header>
    </div>     
    <div id="notification"></div><?if($curPage != '/') echo '<!--/noindex-->';?>
<?if($_SERVER['REAL_FILE_PATH'] == '/blog/index.php' || $curPage == '/blog/'):?>
    <div class="blog_container">
<?endif;
  if(in_array($curPage, array('/','/login/','/create-account/'))):
  else:?>
    <div class="container <?=$APPLICATION->ShowProperty('class');?>">
<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "", array(
            "START_FROM" => "0",
            "PATH" => "",
            "SITE_ID" => "-"), 
  false, array('HIDE_ICONS' => 'Y'));
?>
<?endif;
  if($_SERVER['REAL_FILE_PATH'] == '/blog/index.php' || $curPage == '/blog/'):?>
    </div>
<?endif;?>