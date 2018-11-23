<?IncludeTemplateLangFile(__FILE__, $_REQUEST['lang_code']);
  if(!(in_array($curPage,array('/create-account/','product','/search/'))||($_SERVER['REAL_FILE_PATH'] == '/blog/index.php'))):?>
    </div>
<?endif;?><?if($curPage != '/') echo '<!--noindex-->';?>
    <div class="footer">
      <div class="container">
        <div class="row">
          <div class="col-xs-2">
            <p class="font13">&copy; <?=date('Y')?> <?=GetMessage('F_COPYRIGHT');?></p>
          </div>
          <div class="col-xs-2 text-uppercase">
<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"bottom", 
	array(
		"ROOT_MENU_TYPE" => "bottom",
		"COMPONENT_TEMPLATE" => "bottom",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(),
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N"
	),
	false
);?>
          </div>
          <div class="col-xs-2 text-uppercase">
            <ul>
              <li><a href="/isnew/"<?if($curPage != '/') echo ' rel="nofollow"';?>><?=GetMessage('H_ISNEW');?></a></li>
              <li><a href="/brands/"<?if($curPage != '/') echo ' rel="nofollow"';?>><?=GetMessage('H_BRANDS');?></a></li>
              <li><a href="/shoes/sneakers/"<?if($curPage != '/') echo ' rel="nofollow"';?>><?=GetMessage('H_SNEAKERS');?></a></li>
              <li><a href="/clothes/"<?if($curPage != '/') echo ' rel="nofollow"';?>><?=GetMessage('H_CLOTHES');?></a></li>
              <li><a href="/shoes/"<?if($curPage != '/') echo ' rel="nofollow"';?>><?=GetMessage('H_SHOES');?></a></li>
              <li><a href="/sale/"<?if($curPage != '/') echo ' rel="nofollow"';?>><?=GetMessage('H_SALE');?></a></li>
            </ul>
          </div>
          <div class="col-xs-2 text-uppercase">
<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"bottom", 
	array(
		"ROOT_MENU_TYPE" => "top",
		"COMPONENT_TEMPLATE" => "bottom",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(),
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N"
	),
	false
);?>
          </div>
          <div class="col-xs-2 footer-social">
            <ul>
              <li><a href="//www.youtube.com/user/snkrhdstore" class="round-icon-link" target="_blank" rel="nofollow"><i class="ri-youtube"></i></a></li>
              <li><a href="//www.facebook.com/pages/SneakerHead-Russia/163152103698950" class="round-icon-link" target="_blank" rel="nofollow"><i class="ri-facebook"></i></a></li>
              <li><a href="//instagram.com/sneakerheadrussia" class="round-icon-link" target="_blank" rel="nofollow"><i class="ri-instagram"></i></a></li>
              <li><a href="//vk.com/sneakerhead_ru" class="round-icon-link" target="_blank" rel="nofollow"><i class="ri-vk"></i></a></li>
            </ul>
          </div>
          <div class="col-xs-2 text-right">
            <p><img src="<?=SITE_TEMPLATE_PATH?>/images/verifed_by_visa.png" alt="Verifed by Visa" /> <img src="<?=SITE_TEMPLATE_PATH?>/images/mastercard_securecode.png" alt="Mastercard secure code" /></p>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="row footer-addresses">
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"shops-footer",
	array(
		"IBLOCK_TYPE" => "references",
		"IBLOCK_ID" => "5",
		"NEWS_COUNT" => "20",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(),
		"PROPERTY_CODE" => array("METRO","ADDRESS"),
		"CACHE_TYPE" => "A",
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
        "LANG" => $_SESSION["lang"]
	),
	false
);?>
          <div class="clearfix"></div>
        </div>
        <div class="about-wrap">
<?if($curPage == '/'){?>
        <h1><?$APPLICATION->ShowTitle(false)?></h1>
<?$APPLICATION->IncludeComponent("bitrix:news.detail", "seo", Array(
		"IBLOCK_TYPE" => "services",
		"IBLOCK_ID" => "13",
		"ELEMENT_ID" => "",
		"ELEMENT_CODE" => $curPage,
		"DETAIL_URL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"SET_TITLE" => "Y",
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_ELEMENT_CHAIN" => "N",
	),
	false
);?>
<?}?>
        </div>
        <div data-retailrocket-markup-block="57ea6df75a65880a841e9b06"></div>
        <div data-retailrocket-markup-block="5805f4219872e542105d778a"></div>
        <script src="<?=SITE_TEMPLATE_PATH?>/js/footer.js"></script>
        <?/*<!-- BEGIN JIVOSITE CODE {literal} -->
        <script>
          (function(){ var widget_id = '6anLRguFlY';
          var s = document.createElement('script'); s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();
        </script>
        <!-- {/literal} END JIVOSITE CODE -->*/?>
        <script>
          var google_conversion_id = 951041715;
          var google_custom_params = window.google_tag_params;
          var google_remarketing_only = true;
        </script>
        <script src="//www.googleadservices.com/pagead/conversion.js"></script>
        <noscript>
          <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/951041715/?value=0&amp;guid=ON&amp;script=0" />
          </div>
        </noscript>
      </div>
    </div>
    <div class="fadeMe"></div>
    <div class="totop"></div>
    <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-5WTKH7"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-5WTKH7');</script>
   <?if($curPage != '/') echo '<!--/noindex-->';?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter154446 = new Ya.Metrika({
                    id:154446,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true,
                    trackHash:true,
                    ecommerce:"dataLayer"
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/154446" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<script>
var _tmr = window._tmr || (window._tmr = []);
_tmr.push({id: "3065581", type: "pageView", start: (new Date()).getTime()});
(function (d, w, id) {
  if (d.getElementById(id)) return;
  var ts = d.createElement("script"); ts.async = true; ts.id = id;
  ts.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//top-fwz1.mail.ru/js/code.js";
  var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
  if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
})(document, window, "topmailru-code");
</script><noscript><div>
<img src="//top-fwz1.mail.ru/counter?id=3065581;js=na" style="border:0;position:absolute;left:-9999px;" alt="Addigital" />
</div></noscript>

   <!-- BEGIN JIVOSITE CODE {literal} -->
<script>
(function(){ var widget_id = '6anLRguFlY';
var s = document.createElement('script'); s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
<!-- {/literal} END JIVOSITE CODE -->
<script>
var digiScript = document.createElement('script');digiScript.src = '//cdn.diginetica.net/316/client.js?ts=' + Date.now(); digiScript.defer = true; digiScript.async = true; document.body.appendChild(digiScript);
</script>




 </body>
</html>