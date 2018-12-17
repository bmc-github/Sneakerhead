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
use \Bitrix\Main\Localization\Loc;
$this->setFrameMode(true);

$sort = "ID";
if($_GET['sort'] && $_GET['order']){
    $arrSortAlown = array('price'=>'CATALOG_PRICE_1','date'=>'CREATED_DATE');   
    $_sort = isset($arrSortAlown[$_GET['sort']]) ? $arrSortAlown[$_GET['sort']] : 'CREATED_DATE';
    $_order = isset($_GET['order']) && $_GET['order']=='asc' ? 'ASC' : 'DESC';
    $param = 'sort='.$_GET['sort'].'&order='.$_GET['order'];
} 
$APPLICATION->SetPageProperty('class', 'category-page');
if (!$uri_parts) {
    $url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri_parts = explode('/', trim($url_path, ' /'));
}
unset($uri_parts[0]);

if (\Bitrix\Main\Loader::includeModule('iblock')) {
    $count = count($uri_parts);
    for ($i = 1; $i <= $count; $i++) {
        $rsResult = \Bitrix\Iblock\SectionTable::getList([
            'select' => ['ID'],
            'filter' => ['=IBLOCK_ID' => 2, '=CODE' => $uri_parts[$i]],
        ]);
        if ($row = $rsResult->fetch()) {
            unset($uri_parts[$i]);
            $arCurSection['ID'] = $row["ID"];
        }
    }
}

$SMART_FILTER_PATH = implode("/", $uri_parts);

global $searchFilter;
$searchFilter = array('ACTIVE'=>'Y','CATALOG_AVAILABLE'=>'Y');

$curPage = $APPLICATION->getCurPage(false);
$seo = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>13,'CODE'=>$curPage,'ACTIVE'=>'Y'), false, false, array('ID'))->GetNext();
?>
      <div class="row">
        <div class="col-xs-12">
          <table class="heading-title-block">
    	    <tr>
    	      <td><?if($_REQUEST['PAGEN_1'] && $_REQUEST['PAGEN_1']>1) echo '<!--noindex-->';?>
	        <h1><?$APPLICATION->ShowTitle(false)?></h1>
	      <?if($_REQUEST['PAGEN_1'] && $_REQUEST['PAGEN_1']>1) echo '<!--/noindex-->';?></td>
	      <td style="text-align:right;"><?echo '<!--noindex-->';?>
	        <div class="product-filter">
    	          <div class="sort">
    	            <label></label>
    	            <select onchange="location = this.value;" class="input-ongray">
    		      <option value="?sort=created_date&order=DESC">Сортировка</option>
    		      <option value="?sort=price&order=ASC">Цена (по возрастанию)</option>
    		      <option value="?sort=price&order=DESC">Цена (по убыванию)</option>
    		    </select>
    	          </div>
     	        </div><?echo '<!--/noindex-->';?>
     	      </td>
     	    </tr>
     	  </table>
        </div>
	<div class="col-xs-3">
          <div class="column-left">
<?$APPLICATION->IncludeComponent(
	"realweb:catalog.smart.filter", 
	".default", 
	array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "2",
		"SECTION_ID" => $arCurSection["ID"]?$arCurSection["ID"]:"",
		"FILTER_NAME" => "searchFilter",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"SAVE_IN_SESSION" => "N",
		"FILTER_VIEW_MODE" => "VERTICAL",
		"XML_EXPORT" => "Y",
		"SECTION_TITLE" => "NAME",
		"SECTION_DESCRIPTION" => "DESCRIPTION",
		"HIDE_NOT_AVAILABLE" => "Y",
		"TEMPLATE_THEME" => "green",
		"CONVERT_CURRENCY" => "N",
		"CURRENCY_ID" => "",
		"SEF_MODE" => "Y",
		"SEF_RULE" => "#SMART_FILTER_PATH#/",
		"SMART_FILTER_PATH" => $SMART_FILTER_PATH,
		"PAGER_PARAMS_NAME" => "",
		"INSTANT_RELOAD" => "Y",
		"FOLDER" => "/brands/".$arResult["VARIABLES"]["ELEMENT_CODE"]."/",
		"COMPONENT_TEMPLATE" => ".default",
		"DISPLAY_ELEMENT_COUNT" => "Y",
		"SECTION_CODE" => "",
		"SECTION_CODE_PATH" => "",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false,
	array(
		"HIDE_ICONS" => "N"
	)
);?>
	  </div>
	</div>
        <div class="col-xs-9">
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	".default", 
	array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "2",
		"HIDE_NOT_AVAILABLE" => "Y",
		"HIDE_NOT_AVAILABLE_OFFERS" => "Y",
		"ELEMENT_SORT_FIELD" => $sort,
		"ELEMENT_SORT_ORDER" => "desc",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER2" => "desc",
		"PAGE_ELEMENT_COUNT" => "51",
		"LINE_ELEMENT_COUNT" => "3",
		"PROPERTY_CODE" => array(
			0 => "ARTNUMBER",
			1 => "ISNEW",
			2 => "BRAND",
			3 => "SALE",
			4 => "SPECIAL_PRICE",
			5 => "SPECIAL_DATE",
			6 => "",
		),
		"OFFERS_CART_PROPERTIES" => array(
			0 => "SIZES_SHOES",
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_PROPERTY_CODE" => array(
			0 => "SIZES_SHOES",
			1 => "",
		),
		"OFFERS_SORT_FIELD" => $sort,
		"OFFERS_SORT_ORDER" => "desc",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER2" => "desc",
		"OFFERS_LIMIT" => "0",
		"BASKET_URL" => "/shopping-cart/",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"DISPLAY_COMPARE" => "N",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_PROPERTIES" => array(
			0 => "BRAND",
			1 => "COLOR",
		),
		"USE_PRODUCT_QUANTITY" => "N",
		"CONVERT_CURRENCY" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Товары",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000000",
		"PAGER_SHOW_ALL" => "N",
		"FILTER_NAME" => "searchFilter",
		"SECTION_ID" => $arCurSection['ID'] ? $arCurSection['ID'] : '',
		"SECTION_CODE" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"INCLUDE_SUBSECTIONS" => "Y",
		"SHOW_ALL_WO_SECTION" => "Y",
		"META_KEYWORDS" => "",
		"META_DESCRIPTION" => "",
		"BROWSER_TITLE" => "-",
		"ADD_SECTIONS_CHAIN" => "Y",
		"SET_TITLE" => "Y",
		"SET_STATUS_404" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"COMPONENT_TEMPLATE" => ".default",
		"CUSTOM_FILTER" => "",
		"PROPERTY_CODE_MOBILE" => array(
			0 => "ISNEW",
			1 => "BRAND",
			2 => "SALE",
			3 => "SPECIAL_PRICE",
			4 => "SPECIAL_DATE",
		),
		"BACKGROUND_IMAGE" => "-",
		"TEMPLATE_THEME" => "red",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"ENLARGE_PRODUCT" => "STRICT",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
		"SHOW_SLIDER" => "N",
		"ADD_PICT_PROP" => "MORE_PHOTO",
		"LABEL_PROP" => array(
		),
		"OFFER_ADD_PICT_PROP" => "-",
		"OFFER_TREE_PROPS" => array(
			0 => "SIZES_SHOES",
		),
		"PRODUCT_SUBSCRIPTION" => "Y",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "Y",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_CLOSE_POPUP" => "N",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"RCM_TYPE" => "personal",
		"RCM_PROD_ID" => "",
		"SHOW_FROM_SECTION" => "N",
		"SEF_MODE" => "Y",
		"SEF_RULE" => "",
		"SECTION_CODE_PATH" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "Y",
		"AJAX_OPTION_STYLE" => "N",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "Y",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PARTIAL_PRODUCT_PROPERTIES" => "Y",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"LAZY_LOAD" => "N",
		"LOAD_ON_SCROLL" => "N",
		"SHOW_404" => "Y",
		"FILE_404" => "",
		"COMPATIBLE_MODE" => "Y",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"SECTION_URL" => "",
		"DETAIL_URL" => ""
	),
	false,
	array(
		"HIDE_ICONS" => "N"
	)
);?>

<?if(!empty($seo) && empty($_REQUEST['PAGEN_1']) && ($_SESSION['lang']==NULL || $_SESSION['lang']=='ru')){
    if(empty($_REQUEST['PAGEN_1'])){
?>
          <div class="category-info">
<?$APPLICATION->IncludeComponent("bitrix:news.detail", "seo", Array(
		"IBLOCK_TYPE" => "services",
		"IBLOCK_ID" => "13",
		"ELEMENT_ID" => "",
		"ELEMENT_CODE" => $curPage,
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "1",
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
            
	  </div>
<?  }
  }elseif($_SESSION['lang']=='en'){
          $APPLICATION->SetTitle($arResult['UF_NAME']);
  }?>
      </div>
    </div>

<?if($seo){
  $iprop = new \Bitrix\Iblock\InheritedProperty\ElementValues(13, $seo["ID"]);
  $meta = $iprop->getValues(); 
}else
  $meta = array();

$arResult['META'] = array();
if($_REQUEST['PAGEN_1'] && $_REQUEST['PAGEN_1']>1){
  $arResult['META']['TITLE'] = $GLOBALS['meta']['h1'].' - страница каталога №'.$_REQUEST['PAGEN_1'];
  $arResult['META']['KEYWORDS'] = '';
  $arResult['META']['DESCRIPTION'] = 'Страница №'.$_REQUEST['PAGEN_1'].': '.$meta['ELEMENT_META_DESCRIPTION'];
  $arResult['META']['H1'] = $GLOBALS['meta']['h1'].' — страница №'.$_REQUEST['PAGEN_1'];
}else{
  $arResult['META']['TITLE'] =  $GLOBALS['meta']['title'];
  $arResult['META']['KEYWORDS'] = $GLOBALS['meta']['keywords'];
  $arResult['META']['DESCRIPTION'] = $meta['ELEMENT_META_DESCRIPTION'] ? $meta['ELEMENT_META_DESCRIPTION'] : $GLOBALS['meta']['description'];
  $arResult['META']['H1'] = $GLOBALS['meta']['h1'];
}

$cp = $this->__component;
if(is_object($cp))
  $cp->SetResultCacheKeys(array('META'));

$APPLICATION->SetPageProperty('title', $arResult['META']['TITLE']);
$APPLICATION->SetPageProperty('keywords', $arResult['META']['KEYWORDS']);
$APPLICATION->SetPageProperty('description', $arResult['META']['DESCRIPTION']);
$APPLICATION->SetTitle($arResult['META']['H1']);

if(!empty($GLOBALS['meta']['urls']))
  foreach($GLOBALS['meta']['urls'] as $it)
    $APPLICATION->AddChainItem($it['NAME'],$it['URL']);

?>
