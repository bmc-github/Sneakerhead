<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
  use Bitrix\Main,
      Bitrix\Sale;
Bitrix\Main\Loader::includeModule('iblock');


  $basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());

  $price = $basket->getPrice(); // Сумма с учетом скидок
  $fullPrice = $basket->getBasePrice(); // Сумма без учета скидок

  $productId = intval($_POST['id']);
  $quantity = intval($_POST['quantity']);

   $productone = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>3,'ID'=>$productId), false, false, array('IBLOCK_ID','PROPERTY_ARTNUMBER_T','PROPERTY_CML2_LINK'))->GetNext(false,false);

$inBasket = false;

$basketItems = $basket->getBasketItems();
foreach ($basketItems as $basketItem) {
   $prod = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>3,'ID'=>$basketItem->getProductId()), false, false, array('IBLOCK_ID','PROPERTY_ARTNUMBER_T','PROPERTY_CML2_LINK'))->GetNext(false,false);

	if($prod['PROPERTY_CML2_LINK_VALUE'] == $productone['PROPERTY_CML2_LINK_VALUE']){
		$inBasket = true;
		//break;
	}
}

  if ($inBasket){
    //$item->setField('QUANTITY', $item->getQuantity() + $quantity);
	  //if($item->getQuantity() == 1){
      $APPLICATION->RestartBuffer();
      header('Content-Type: application/json');
      echo Main\Web\Json::encode(array("status" => "ERROR", "text" => "Условие продажи товара:<br>1 пара в руки!"));
	  //}

  }else{
    $item = $basket->createItem('catalog', $productId);
    $item->setFields(array(
        'QUANTITY' => 1,
        'CURRENCY' => Bitrix\Currency\CurrencyManager::getBaseCurrency(),
        'LID' => Bitrix\Main\Context::getCurrent()->getSite(),
        'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
    ));
    $basket->save();
    $APPLICATION->RestartBuffer();
    header('Content-Type: application/json');
	  echo Main\Web\Json::encode(array("status" => "SUCCESS"));
	  //echo Main\Web\Json::encode(array("status" => "ERROR", "text" => "Условие продажи товара:<br>1 пара в руки!"));
  }
  die();               
?>
