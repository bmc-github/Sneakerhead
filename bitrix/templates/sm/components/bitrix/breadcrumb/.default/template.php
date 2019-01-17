<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//delayed function must return a string
if(empty($arResult))
  return "";

//global $APPLICATION;
CModule::IncludeModule('iblock');
global $APPLICATION;
$cats = array();
$rs = CIBlockSection::GetList(array(), array('IBLOCK_ID'=>2,'ACTIVE'=>'Y'), false, array('NAME','SECTION_PAGE_URL','UF_NAME'), false);
while($it = $rs->GetNext())
  $cats[] = array('name'=>$it[(($_SESSION['lang']=='en')?'UF_':'').'NAME'], 'url'=>$it['SECTION_PAGE_URL']);

$strReturn.='<ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">';
for($index = 0; $index < count($arResult); $index++){
  $title = htmlspecialcharsex($arResult[$index]["TITLE"]);
  foreach($cats as $it){
    if($arResult[$index]['LINK'] == $it['url']){
      $title = $it['name'];
      if(substr_count($_SERVER['REQUEST_URI'],'isnew') > 0){
        if($it['url'] != '/isnew/')
          $arResult[$index]['LINK'] = '/isnew'.$arResult[$index]['LINK'];
      }elseif(substr_count($_SERVER['REQUEST_URI'],'sale') > 0){
        if($it['url'] != '/sale/')
          $arResult[$index]['LINK'] = '/sale'.$arResult[$index]['LINK'];
      }
    }
  }
  $strReturn.='<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';

  if($arResult[$index]["LINK"] <> "" && $index != count($arResult)-1){
    $strReturn.='  <a itemprop="item" href="'.$arResult[$index]["LINK"].'"><span itemprop="name">'.$title.'</span></a>';
  }else{
    if(!$arResult[$index]["LINK"])
      $arResult[$index]["LINK"] = $APPLICATION->GetCurPage(false);
    $strReturn.='  <span itemprop="item" content="https://'.SITE_SERVER_NAME.$arResult[$index]["LINK"].'"><span itemprop="name">'.$title.'</span></span>';
  }
  $strReturn.='  <meta itemprop="position" content="'.($index+1).'" />';
  $strReturn.='</li>';
}
$strReturn.= '</ol>';
return $strReturn;