<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)die();
/**
 * @var array $templateData 
 * @global * CMain $APPLICATION 
*/
CJSCore::Init(array('fx', 'popup'));
$i = 0;
$arAll = array();
foreach ($arResult['ITEMS'] as $item) {
    $vals = array();
    foreach ($item['VALUES'] as $v) {
        if ($v['CHECKED'] == true) {
            $vals[] = $v;
        }
    }
    $arAll[$i] = $item;
    $arAll[$i]['VALUES'] = $vals;
    $i++;
}
function mb_ucfirst($str){
    $fc = strtoupper(substr($str, 0, 1));
    return $fc . substr($str, 1, strlen($str) - 1);
}
$section = array();
$section = CIBlockSection::GetByID($arResult["SECTION"]["ID"])->GetNext();
$m1 = $arResult['ITEMS'][8]['VALUES']['MIN']['FILTERED_VALUE'];
$m2 = $arResult['ITEMS']['BASE']['VALUES']['MIN']['FILTERED_VALUE'];
if($m1 > $m2 && $m2 > 0)
    $price = (int)$m2;
if($m1 > $m2 && $m2 <= 0)
    $price = (int)$m1;
if($m1 < $m2 && $m1 > 0)
    $price = (int)$m1;
if($m1 < $m2 && $m1 <= 0)
    $price = (int)$m2;

$color = $gender = $brand = $brand_rus = $size = '';
$url = (substr_count($_SERVER['REQUEST_URI'],'brands')>0) ? '/brands/': $section['SECTION_PAGE_URL'];
$urls = array();
foreach($arAll as $it) {
  if(!empty($it['VALUES']) && count($it['VALUES']) == 1){
    if($it['CODE'] == 'GENDER'){
      $gender_ = ToLower($it['VALUES'][0]['VALUE']);
      $gender = substr($gender_,0,-2).(in_array($section['CODE'], array('shoes','clothes','form','winter-shoes'))?'ая':'ие');
      $url.= $it['VALUES'][0]['URL_ID'].'/';
      $urls[] = array('NAME'=>$gender,'URL'=>$url);
    }
    if($it['CODE'] == 'BRAND'){
      $brand = $it['VALUES'][0]['VALUE'];
      $url.= $it['VALUES'][0]['URL_ID'].'/';
      $urls[] = array('NAME'=>$brand,'URL'=>$url);
      $b = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>6,'ID'=>$it['VALUES'][0]['FACET_VALUE']), false, false, array('PROPERTY_NAME_RUS'))->GetNext();
      if($b && $b['PROPERTY_NAME_RUS_VALUE'] != '')
        $brand_rus = $b['PROPERTY_NAME_RUS_VALUE'];
    }
    if($it['CODE'] == 'COLOR'){
      $color_ = ToLower($it['VALUES'][0]['VALUE']);
      switch(substr($color_,-2)){
        case 'ый': $color = substr($color_,0,-2).(in_array($section['CODE'], array('shoes','clothes','form','winter-shoes'))?'ая':'ые'); break;
        case 'ий': $color = substr($color_,0,-2).(in_array($section['CODE'], array('shoes','clothes','form','winter-shoes'))?'ая':'ие'); break;
	default: $color = 'цвет'.(in_array($section['CODE'], array('shoes','clothes','form','winter-shoes'))?'ая':'ые');
      }
      $url.= $it['VALUES'][0]['URL_ID'].'/';
      $urls[] = array('NAME'=>$color,'URL'=>$url);
    }
    if($it['CODE'] == 'SIZES_SHOES'){
      $size = $it['VALUES'][0]['VALUE'];
      $url.= $it['VALUES'][0]['URL_ID'].'/';
      $urls[] = array('NAME'=>'размер '.$size,'URL'=>$url);
    }
  }
}
                                                          
if(($gender != '' || $brand != '' || $color != '' || $ssize != '') /*&& $section['CODE']*/){
  if(in_array($section['CODE'],array('shoes','stuff','winter-shoes'))){
    $title = ($color?$color.' ':'').($gender?$gender.' ':'').ToLower($section['NAME']).($brand?' '.$brand:'').($brand_rus?' ('.$brand_rus.')':'').($size?' '.$size.' размера':'').' - купить по цене от '.$price.' рублей в интернет магазине Sneakerhead';
    $keywords = ToLower($section['NAME']).($color?' '.$color:'').($gender?' '.$gender:'').($brand?' '.ToLower($brand):'').($brand_rus?' ('.ToLower($brand_rus).')':'').($size?' '.$size:'');
    $description = ($color?$color.' ':'').($gender?$gender.' ':'').ToLower($section['NAME']).($brand?' '.$brand:'').($size?' '.$size.' размера':'').' в каталогах с ценами интернет и оффлайн магазинов Sneakerhead! Заказывайте уже сейчас, доставка по Москве, Санкт-Петербургу и России.';
    $h1 = ($color?$color.' ':'').($gender?$gender.' ':'').ToLower($section['NAME']).($brand?' '.$brand:'').($size?' '.$size.' размера':'');
  }elseif(in_array($section['CODE'], array('clothes','form'))){
    $title = ($color?$color.' ':'').($gender?$gender.' ':'').ToLower($section['NAME']).($brand?' '.$brand:'').($brand_rus?' ('.$brand_rus.')':'').($size?' размера '.$size:'').' - купить по цене от '.$price.' рублей в интернет магазине Sneakerhead';
    $keywords = ToLower($section['NAME']).($color?' '.$color:'').($gender?' '.$gender:'').($brand?' '.ToLower($brand):'').($brand_rus?' ('.ToLower($brand_rus).')':'').($size?' '.$size: '');
    $description = ($color?$color.' ':'').($gender?$gender.' ':'').ToLower($section['NAME']).($brand?' '.$brand:'').($size?' размера '.$size:'').' в каталогах с ценами интернет и оффлайн магазинов Sneakerhead! Заказывайте уже сейчас, доставка по Москве, Санкт-Петербургу и России.';
    $h1 = ($color?$color.' ':'').($gender?$gender.' ':'').ToLower($section['NAME']).($brand?' '.$brand:'').($size?' размера '.$size:'');
  }elseif($section['CODE'] == 'other'){
    $title = 'Другие'.($color?' '.$color:'').($gender?' '.$gender:'').' аксессуары'.($brand?' '.$brand:'').($brand_rus?' ('.$brand_rus.')':'').($size?' размера '.$size:'').' - купить по цене от '.$price.' рублей в интернет магазине Sneakerhead';
    $keywords = ToLower($section['NAME']).($color?' '.$color:'').($gender?' '.$gender:'').($brand?' '.ToLower($brand):'').($brand_rus?' ('.ToLower($brand_rus).')':'').($size?' '.$size:'');
    $description = 'Другие'.($color?$color.' ':'').($gender?$gender.' ':'').'аксессуары'.($brand?' '.$brand:'').($size?' размера '.$size:'').' в каталогах с ценами интернет и оффлайн магазинов Sneakerhead! Заказывайте уже сейчас, доставка по Москве, Санкт-Петербургу и России.';
    $h1 = 'Другие'.($color?$color.' ':'').($gender?$gender.' ':'').'аксессуары'.($brand?' '.$brand:'').($size?' размера '.$size: '');
  }elseif($section['CODE'] == 'sale'){
    $title = 'Купить недорогие'.($color?' '.$color:'').($gender?' '.$gender:'').($brand?' '.$brand:'').($brand_rus?' ('.$brand_rus.')':'').($size?' '.$size.' размера':'').' - распродажа в интернет магазине Sneakerhead в Москве';
    $keywords = 'недорогие дешевые акции скидки низкие цены'.($color?' '.$color:'').($gender?' '.$gender:'').($brand?' '.ToLower($brand):'').($brand_rus?' ('.ToLower($brand_rus).')':'').($size?' '.$size:'');
    $description = 'Актуальные скидки на'.($color?' '.$color:'').($gender?' '.$gender:'').($brand?' '.$brand:'').($size?' '.$size.' размера':'').' в магазинах Sneakerhead.';
    $h1 = 'Распродажа -'.($color?' '.$color:'').($gender?' '.$gender:'').($brand?' '.$brand:'').($size?' '.$size.' размера':'');
  }elseif($section['CODE'] == 'isnew'){
    $title = 'Купить новые'.($color?' '.$color:'').($gender?' '.$gender:'').($brand?' '.$brand:'').($brand_rus?' ('.$brand_rus.')':'').($size?' '.$size.' размера':'').' - актуальные новинки в интернет магазине Sneakerhead в Москве';
    $keywords = 'новые коллекции новинки'.($color?' '.$color:'').($gender?' '.$gender:'').($brand?' '.ToLower($brand):'').($brand_rus?' ('.ToLower($brand_rus).')':'').($size?' '.$size:'');
    $description = 'Новые коллекции:'.($color?' '.$color:'').($gender?' '.$gender:'').($brand?' '.$brand:'').($size?' '.$size.' размера':'').' в магазинах Sneakerhead.';
    $h1 = 'Новинки:'.($color?' '.$color:'').($gender?' '.$gender:'').($brand?' '.$brand:'').($size?' '.$size.' размера':'');
  }else{
    $title = 'Купить'.($gender?' '.$gender:'').($color?' '.$color:'').' '.ToLower($section['NAME']).($brand?' '.$brand:'').($brand_rus?' ('.$brand_rus.')':'').($size?' '.$size.' размера':'').' по цене от '.$price.' рублей в интернет магазине Sneakerhead';
    $keywords = 'купить '.ToLower($section['NAME']).($color?' '.$color:'').($gender?' '.$gender:'').($brand?' '.ToLower($brand):'').($brand_rus?' ('.ToLower($brand_rus).')':'').($size?' '.$size:'');
    $description = 'Огромный выбор и приемлемые цены на'.($gender?' '.$gender:'').($color?' '.$color:'').' '.ToLower($section['NAME']).($brand?' '.$brand:'').($size?' '.$size.' размера':'').' только в интернет и оффлайн магазинах Sneakerhead! Заказывайте уже сейчас, доставка по Москве и России.';
    $h1 = ($gender?$gender.' ':'').($color?$color.' ':'').ToLower($section['NAME']).($brand?' '.$brand:'').($size?' '.$size.' размера': '');
  }

  global $meta;
  $meta = array(
	'title' => mb_ucfirst($title),
	'keywords' => $keywords,
	'description' => mb_ucfirst($description),
 	'h1' => mb_ucfirst($h1),
	'urls' => $urls
  );	
}
?>