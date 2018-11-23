<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

array_unshift($arResult["SECTIONS"], array('NAME'=>GetMessage('H_BRANDS'),'SECTION_PAGE_URL'=>'/brands/','DEPTH_LEVEL'=>1));
if($APPLICATION->GetCurPage(false) != '/sitemap/')
  array_push($arResult["SECTIONS"], array('NAME'=>GetMessage('H_BLOG'),'SECTION_PAGE_URL'=>'/blog/','DEPTH_LEVEL'=>1));

?>
