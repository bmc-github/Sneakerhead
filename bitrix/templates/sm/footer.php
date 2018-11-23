<?if(!(in_array($curPage,array('/checkout/','/create-account/','product','/search/','/shopping-cart/'))||($_SERVER['REAL_FILE_PATH'] == '/blog/index.php'))):?>
    </div>
<?endif;?>

    <div class="footer">
      <div class="container">
        <div class="row footMenu">
          <div class="col-md-4 col-xs-6 text-uppercase">
<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"bottom", 
	array(
		"ROOT_MENU_TYPE" => "bottom",
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
          <div class="col-md-4 col-xs-6 text-uppercase">
            <ul>
              <li><a href="/isnew/"><?=GetMessage('H_ISNEW');?></a></li>
              <li><a href="/brands/"><?=GetMessage('H_BRANDS');?></a></li>
              <li><a href="/shoes/sneakers/"><?=GetMessage('H_SNEAKERS');?></a></li>
              <li><a href="/clothes/"><?=GetMessage('H_CLOTHES');?></a></li>
              <li><a href="/sale/"><?=GetMessage('H_SALE');?></a></li>
            </ul>
          </div>
          <div class="col-md-4 col-xs-6 text-uppercase">
<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"bottom", 
	array(
		"ROOT_MENU_TYPE" => "top",
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
          <div class="clearfix"></div>
        </div>
      </div>
      <div class="footContacts">
        <div class="container">
          <div class="row">
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"shops-footer",
	array(
		"IBLOCK_TYPE" => "references",
		"IBLOCK_ID" => "5",
		"NEWS_COUNT" => "4",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(),
		"PROPERTY_CODE" => array(
			0 => "METRO",
			1 => "ADDRESS",
			2 => "",
		),
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
	),
	false
);?>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row socCopy">
          <div class="socialBox">
            <a class="vk" href="//vk.com/sneakerhead_ru"></a>
            <a class="in" href="//instagram.com/sneakerheadrussia"></a>
            <a class="fb" href="//www.facebook.com/pages/SneakerHead-Russia/163152103698950"></a>
            <a class="yo" href="//www.youtube.com/user/snkrhdstore"></a>
          </div>
          <div class="copy">© <?=date('Y');?> <?=GetMessage('FOOTER_COPYRIGHT');?></div>
        </div>
      </div>
      <div class="hidden">
<?CModule::IncludeModule('iblock');
  $rs = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>13,'CODE'=>$curPage,'ACTIVE'=>'Y'), false, false, array('ID'));
  if($rs->GetNext() && empty($_REQUEST['PAGE_1'])){
?>
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
                  }else{return false;}
                }).parent('.jq-selectbox').find('.jq-selectbox__select').addClass('slyled_select_onwhite');
              }
            });
          }, 300);        
        });
      </script>
    </div>
  </div>
  <div data-retailrocket-markup-block="5805f4219872e542105d778a"></div>
  <div onclick="javascript:void(0)" class="overlay" style="display:none"></div>
  <div class="fadeMe"></div>
  <div class="totop"></div>

  <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-5WTKH7" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  <script>(function(w,d,s,l,i){
    w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});
    var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-5WTKH7');</script>
  <script>
    $('#loadMore').hide();
  </script>
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
    var google_conversion_id = 951041715;
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
  </script>
  <script src="//www.googleadservices.com/pagead/conversion.js"></script>
<script>
var digiScript = document.createElement('script'); digiScript.src = '//cdn.diginetica.net/316/client.js?ts=' + Date.now(); digiScript.defer = true; digiScript.async = true; document.body.appendChild(digiScript);
</script>
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
</script>
<noscript><div><img src="//top-fwz1.mail.ru/counter?id=3065581;js=na" style="border:0;position:absolute;left:-9999px;" alt="Addigital" /></div></noscript>

<?/*
  <!-- BEGIN JIVOSITE CODE {literal} -->
<script type="text/javascript">
(function(){ var widget_id = '6anLRguFlY';
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
<!-- {/literal} END JIVOSITE CODE -->*/?>
  </body>
</html>