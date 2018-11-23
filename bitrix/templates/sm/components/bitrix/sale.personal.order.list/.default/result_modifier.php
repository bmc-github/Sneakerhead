<?
use Bitrix\Sale,
    Bitrix\Catalog;

foreach($arResult['ORDERS'] as $i=>$order){ 
	$rb = CSaleBasket::GetList(array("NAME"=>"ASC","ID"=>"ASC"),array(/*"FUSER_ID"=>CSaleBasket::GetBasketUserID(),*/"LID"=>SITE_ID,"ORDER_ID"=>$order["ORDER"]["ID"]),false,false,array("ID","PRODUCT_ID","QUANTITY","PRICE","NAME","DETAIL_PAGE_URL"));
        while($it = $rb->Fetch()){
          $ro = CIBlockElement::GetList(array(),array('IBLOCK_ID'=>3,'ID'=>$it['PRODUCT_ID']),false,false,array('ID','PROPERTY_CML2_LINK','PROPERTY_SIZES_SHOES'));
          while($offer = $ro->GetNext(false,false)){
            $product = CIBlockElement::GetList(array(),array('IBLOCK_ID'=>2,'ID'=>$offer['PROPERTY_CML2_LINK_VALUE']),false,false,array('ID','IBLOCK_SECTION_ID','PROPERTY_CATEGORY','PROPERTY_BRAND','PREVIEW_PICTURE'))->GetNext(false,false);
	    $category = CIBlockSection::GetList(array(),array('IBLOCK_ID'=>2,'ID'=>$product['IBLOCK_SECTION_ID']),false,array('SECTION_PAGE_URL'),false)->GetNext(false,false);
            $brand = CIBlockElement::GetList(array(),array('IBLOCK_ID'=>6,'ID'=>$product['PROPERTY_BRAND_VALUE']),false,false,array('NAME','DETAIL_PAGE_URL'))->GetNext(false,false);
            $size = CIBlockElement::GetList(array(),array('IBLOCK_ID'=>17,'ID'=>$offer['PROPERTY_SIZES_SHOES_VALUE']),false,false,array('NAME'))->GetNext(false,false)['NAME'];
            $img = CFile::ResizeImageGet($product['PREVIEW_PICTURE'],array('width'=>120,'height'=>120),BX_RESIZE_IMAGE_PROPORTIONAL,false);

            $arResult['ORDERS'][$i]['BASKET'][] = array(
		'CATEGORY'=>array('NAME'=>$product['PROPERTY_CATEGORY_VALUE'],'DETAIL_PAGE_URL'=>$category['SECTION_PAGE_URL']),
		'BRAND'=>array('NAME'=>$brand['NAME'],'DETAIL_PAGE_URL'=>$brand['DETAIL_PAGE_URL']),
		'PRODUCT'=>array('NAME'=>$it['NAME'],'PREVIEW_PICTURE'=>$img['src'],'DETAIL_PAGE_URL'=>$it['DETAIL_PAGE_URL'],'QUANTITY'=>$it['QUANTITY'],'PRICE'=>$it['PRICE'],'SIZE'=>$size)
	    );
	  }
        }
	$arResult['ORDERS'][$i]['ADDRESS'] = '';
	$orderItem = Sale\Order::load($order["ORDER"]["ID"]);
	$propertyCollection = $orderItem->getPropertyCollection();	
	foreach($propertyCollection as $prop){
		if($prop->getField('CODE') == 'ZIP' && $prop->getValue() != ''){
			$arResult['ORDERS'][$i]['ADDRESS'].= $prop->getValue().', ';			
		}
		if($prop->getField('CODE') == 'ADDRESS' && $prop->getValue() != ''){
			$arResult['ORDERS'][$i]['ADDRESS'].= $prop->getValue();
		}
	}/*	
        $shipmentCollection = $orderItem->getShipmentCollection();	
	foreach($shipmentCollection as $shipment){    
		if(!$shipment->isSystem()){
			$storeId = $shipment->getStoreId();
			$store = Catalog\StoreTable::getRow(['select'=>['TITLE'],'filter'=>['ID'=>$storeId]]);
		}
	}*/
	//$location = $propertyCollection->getDeliveryLocation()->getValue();
}
?>