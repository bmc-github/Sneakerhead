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

$this->setFrameMode(true);
?>

<?=$arResult["DETAIL_TEXT"];?>
<style>
.t-title_xl{text-transform:none;}
</style>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "NewsArticle",
  "mainEntityOfPage":{
    "@type": "WebPage",
    "@id": "https://<?=SITE_SERVER_NAME.$arResult['DETAIL_PAGE_URL']?>"
  },
  "headline": "<?=$arResult['NAME']?>",
  "description": "<?=$arResult['PREVIEW_TEXT']?>",
  "image": {
    "@type": "ImageObject",
    "url": "https://<?=SITE_SERVER_NAME.$arResult['PREVIEW_PICTURE']['SRC']?>",
    "height": "1110",
    "width": "1600" 
  },
  "datePublished": "<?=$arResult['datePublished']?>",
  "dateModified": "<?=$arResult['dateModified']?>",
  "author":{  
    "@type": "Organization",
    "name": "Sneakerhead",
    "logo": {
      "@type": "ImageObject",
      "url": "https://<?=SITE_SERVER_NAME.SITE_TEMPLATE_PATH?>/images/sneakerhead_logo.png"
    }
  },
  "publisher": {
    "@type": "Organization",
    "name": "Sneakerhead",
    "logo": {
      "@type": "ImageObject",
      "url": "https://<?=SITE_SERVER_NAME.SITE_TEMPLATE_PATH?>/images/sneakerhead_logo.png"
    }
  }
}
</script>
