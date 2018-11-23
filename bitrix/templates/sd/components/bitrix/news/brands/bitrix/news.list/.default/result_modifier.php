<?if(!defined('B_PROLOG_INCLUDED')||B_PROLOG_INCLUDED !== true) die();
  $arResult['alphabet'] = array();
  $alphabet = array();
  $ids = array();
  $rs = CIBlockElement::GetList(array("NAME"=>"ASC"),array("IBLOCK_ID"=>6,"ACTIVE"=>"Y","ID"=>CIBlockElement::SubQuery("PROPERTY_BRAND", array("IBLOCK_ID"=>2,"ACTIVE"=>"Y","CATALOG_AVAILABLE"=>"Y"))),false,false,array("ID","NAME"));
  while($it = $rs->GetNext()){
    $alphabet[] = ToUpper(substr($it["NAME"],0,1));  
    $ids[] = $it["ID"];
  }
  $alphabet = array_unique($alphabet);
  $ids = array_unique($ids);

/*Убираем пустые бренды из списка*/
  /*foreach($arResult['ITEMS'] as $i=>$arItem){
    $cnt = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>2,"ACTIVE"=>"Y","PROPERTY_BRAND"=>$arItem['ID']), array(), false, array('ID', 'NAME')); 
    if($cnt==0)
      unset($arResult['ITEMS'][$i]);    
  }*/
  foreach($arResult['ITEMS'] as $i=>$arItem){
    if(in_array($arItem['ID'], $ids)){
      foreach($alphabet as $key=>$it){
        $arResult['alphabet'][$key]['name'] = $it;
        if(ToUpper(substr($arItem["NAME"],0,1)) == $it)
          $arResult['alphabet'][$key]['brands'][] = array('name' => $arItem['NAME'], 'url' => $arItem['DETAIL_PAGE_URL']);
      }
    }else{
      unset($arResult['ITEMS'][$i]);
    }
  }
?>