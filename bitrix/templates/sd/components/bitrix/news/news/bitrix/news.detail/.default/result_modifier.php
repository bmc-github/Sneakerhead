<?
preg_match_all('|<div[^>]*field="text"[^>]*>(.*)</div>|isU', $arResult["DETAIL_TEXT"], $preview);
$desc = explode('+++', str_replace(array('<br>', '<br />'), '+++', strip_tags($preview[0][0], '<br>')))[0];
if (strlen($desc) < 100)
	$desc = str_replace(array('<br><br>','<br /><br />','<br>','<br />',' .'), array('. ','. ','','','.'), strip_tags($preview[0][0], '<br>'));
$arResult['PREVIEW_TEXT'] = trim(str_replace(array(' "','" ','".'), array(' «','» ','».'), $desc));

$arResult['DETAIL_TEXT'] = str_replace(array(' style=""',' rel=""',' rel="noopener"','/search/?search=','www.'), array('','',' rel="nofollow noopener"','/search/?q=',''), $arResult["DETAIL_TEXT"]);
$arResult['DETAIL_TEXT'] = preg_replace('/<h1(.*)>(.*)<\/h1>/isU', '<div$1>$2</div>', $arResult['DETAIL_TEXT']);

$name = trim(str_replace(array('  ','« ',' »'),array(' ','«','»'),$arResult['NAME']));
/*
$arResult['DETAIL_TEXT'] = preg_replace_callback(array(
	'/<div class="t001__title t-title t-title_xl" field="title">(.*)<\/div>/isU',
	'/<div class="t001__title t-title t-title_xl " field="title">(.*)<\/div>/isU'), 
	function($matches) use (&$name){
        	$mname = trim(str_replace(array('<br>','<br />','  ','« ',' »'),array(' ',' ',' ','«','»'),$matches[1]));
		if($mname == $name){
			return "<h1 class=\"t001__title t-title t-title_xl\" field=\"title\">$name</h1>";
		}else{
			return "<h1 class=\"t001__title t-title t-title_xl\" field=\"title\">$name</h1>$matches[0]";
		}
	}, $arResult['DETAIL_TEXT']);
$arResult['DETAIL_TEXT'] = preg_replace_callback('#<a([^>]+?)href\s*=\s*(["\']*)\s*(http|https|ftp)://([^"\'\s>]+)\s*\\2([^>]*?)>(.*?)</a>#is',
	create_function('$matches',
	'if(strpos($matches[0], "sneakerhead.ru")===false){
		if(strpos($matches[0], "rel=")===false){
			return "<noindex><a$matches[1]href=$matches[2]$matches[3]://$matches[4]$matches[2]$matches[5] rel=\"nofollow\">$matches[6]</a></noindex>";
		}else{
			return "<noindex>$matches[0]</noindex>";
		}
	}else{
		$matches[4] = str_replace("sneakerhead.ru","",$matches[4]);
		return "<a$matches[1]href=$matches[2]$matches[4]$matches[2]>$matches[6]</a>";
	}'), $arResult['DETAIL_TEXT']);
*/
$dateP = new DateTime($arResult['ACTIVE_FROM']);
$dateM = new DateTime($arResult['TIMESTAMP_X']);
$arResult['datePublished'] = $dateP->format('c');
$arResult['dateModified'] = $dateM->format('c');

$arResult['IPROPERTY_VALUES'] = array();
$arResult['IPROPERTY_VALUES']['ELEMENT_META_TITLE'] = $arResult["NAME"].' - Статьи блога интернет магазина Sneakerhead';
$arResult['IPROPERTY_VALUES']['ELEMENT_META_KEYWORDS'] = ToLower($arResult["NAME"]);
$arResult['IPROPERTY_VALUES']['ELEMENT_META_DESCRIPTION'] = $arResult['PREVIEW_TEXT'];

$cp = $this->__component;
if (is_object($cp))
    $cp->SetResultCacheKeys(array('NAME','PREVIEW_TEXT','PREVIEW_PICTURE','datePublished','dateModified','DETAIL_PAGE_URL','IPROPERTY_VALUES'));
?>
