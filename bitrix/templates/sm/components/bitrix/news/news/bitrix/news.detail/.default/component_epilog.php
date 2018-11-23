<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

global $APPLICATION;

$APPLICATION->SetPageProperty('title', $arResult['IPROPERTY_VALUES']['ELEMENT_META_TITLE']);
$APPLICATION->SetPageProperty('keywords', $arResult['IPROPERTY_VALUES']['ELEMENT_META_KEYWORDS']);
$APPLICATION->SetPageProperty('description', $arResult['IPROPERTY_VALUES']['ELEMENT_META_DESCRIPTION']);

$APPLICATION->AddHeadString('<meta property="og:type" content="article" />');
$APPLICATION->AddHeadString('<meta property="og:title" content="'.$arResult['NAME'].'" />');
$APPLICATION->AddHeadString('<meta property="og:description" content="'.$arResult['PREVIEW_TEXT'].'" />');
$APPLICATION->AddHeadString('<meta property="og:url" content="https://'.SITE_SERVER_NAME.$arResult['DETAIL_PAGE_URL'].'" />');
$APPLICATION->AddHeadString('<meta property="og:image" content="https://'.SITE_SERVER_NAME.$arResult['PREVIEW_PICTURE']['SRC'].'" />');
$APPLICATION->AddHeadString('<meta property="article:published_time" content="'.$arResult['datePublished'].'" />');
$APPLICATION->AddHeadString('<meta property="article:modified_time" content="'.$arResult['dateModified'].'" />');
$APPLICATION->AddHeadString('<meta property="article:publisher" content="https://www.facebook.com/sneakerheadrussia" />');
?>
