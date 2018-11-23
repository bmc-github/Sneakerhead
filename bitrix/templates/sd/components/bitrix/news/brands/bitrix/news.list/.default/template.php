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

  if($arResult["alphabet"]){
    $dellimer = true;
?>
<h1><?$APPLICATION->ShowTitle(false)?></h1>

<ul class="manufacturer_letters_wr">
<?  foreach($arResult["alphabet"] as $it){
      if(!preg_match('/[a-z]$/i', $it['name']) AND $dellimer){?>
  <li style="font-weight:100;">|</li>
<?      $dellimer = false; 
      }?>
  <li><a href="/brands/#<?=$it['name']?>"><b><?=$it['name']?></b></a></li>
<?  }?>
</ul>
<?$categories_chunk = array_chunk($arResult['alphabet'], 5);?>
<div class="manufacturer-list-container">
<?  foreach($categories_chunk as $categories){?>
  <div class="manufacturer-list-row">
<?    foreach($categories as $it){?>
    <div class="manufacturer-list">
      <div class="manufacturer-heading"><?=$it['name']?><a id="<?=$it['name']?>"></a></div>
      <div class="manufacturer-content">
<?      if($it['brands']){
          for($i = 0; $i < count($it['brands']);){?>
        <ul>
	<?  $j = $i + ceil(count($it['brands']) / 4);
	    for(; $i < $j; $i++){
              if(isset($it['brands'][$i])){?>
	  <li><a href="<?=$it['brands'][$i]['url']; ?>"><?=$it['brands'][$i]['name']; ?></a></li>
<?            }
            }?>
	</ul>
<?        }
        }?>
      </div>
    </div>
<?    }?>
  </div>
<?  }?>
</div>
<?}?>