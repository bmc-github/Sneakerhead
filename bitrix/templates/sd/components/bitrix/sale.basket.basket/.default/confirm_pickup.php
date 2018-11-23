<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main,
    Bitrix\Main\Loader,
    Bitrix\Main\Config\Option,
    Bitrix\Sale,
    Bitrix\Sale\Order,
    Bitrix\Main\Application,
    Bitrix\Sale\Delivery,
    Bitrix\Sale\PaySystem,
    Bitrix\Sale\DiscountCouponsManager;
CModule::IncludeModule('catalog');

    if (!Loader::IncludeModule('sale')) die();

    $request = Application::getInstance()->getContext()->getRequest();

    global $USER, $APPLICATION;

    $siteId = \Bitrix\Main\Context::getCurrent()->getSite();
    $currencyCode = Option::get('sale', 'default_currency', 'RUB');
    DiscountCouponsManager::init();

    $bUserExists = false;
    $anonUserID = $USER->GetID();

    if($anonUserID > 0){
      //$dbUser = CUser::GetList('id', 'asc', array('%NAME'=>$request->getPost('name'),'%PERSONAL_PHONE'=>$request->getPost('telephone')), array("FIELDS" => array("ID")));
      //if($arUser = $dbUser->Fetch())
      $anonUser = CUser::GetByID($anonUserID)->Fetch();        
      $bUserExists = true;
    }
    if(!$bUserExists){
      $anonUserEmail = "oneclick_" . randString(9) . "@example.com";
      $arErrors = array();
      $anonUserID = CSaleUser::DoAutoRegisterUser($anonUserEmail, array('NAME'=>$request->getPost('name')), $siteId, $arErrors, array("ACTIVE" => "N"));

      $user = new CUser;
      $user->Update($anonUserID, array('PERSONAL_PHONE'=>$request->getPost('telephone'),'PERSONAL_COUNTRY'=>1,'PERSONAL_CITY'=>'Москва'));

      if($anonUserID > 0){
        //COption::SetOptionInt("sale", "one_click_user_id", $anonUserID);
        $anonUser = CUser::GetByID($anonUserID)->Fetch();        
      }else{
        $errorMessage = "";
        if(!empty($arErrors)){
          $errorMessage = " ";
          foreach($arErrors as $value){
            $errorMessage .= $value["TEXT"] . "<br />";
          }
        }
        $APPLICATION->ThrowException("Ошибка создания анонимного пользователя." . $errorMessage, "ANONYMOUS_USER_CREATE_ERROR");
        return 0;
      }
    }

if( $anonUserID != 22){
    $basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), $siteId);
    $productId = intval($request->getPost("id")); 
    $quantity = intval($request->getPost("quantity"));

    if($item = $basket->getExistsItem('catalog', $productId)){
        $item->setField('QUANTITY', $item->getQuantity() + $quantity); //добавляем указанное количество к существующему товару
    }else{
        $item = $basket->createItem('catalog', $productId); //создаём новый товар в корзине
        $item->setFields(array(
            'QUANTITY' => 1,
            'CURRENCY' => \Bitrix\Currency\CurrencyManager::getBaseCurrency(),
            'LID' => $siteId,
            'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
        ));
    }
    $basket->save();

    $order = Order::create($siteId, $anonUserID);
    $order->setPersonTypeId(1);
    $basket = Sale\Basket::loadItemsForFUser(\CSaleBasket::GetBasketUserID(), $siteId)->getOrderableItems();

    $order->setBasket($basket);

    /*Shipment*/
    $shipmentCollection = $order->getShipmentCollection();
    $shipment = $shipmentCollection->createItem();
$service = Delivery\Services\Manager::getById(278);
$shipment->setFields(array(
    'DELIVERY_ID' => $service['ID'],
    'DELIVERY_NAME' => $service['NAME'],
    )); 
    $shipmentItemCollection = $shipment->getShipmentItemCollection();
    foreach($order->getBasket() as $item){
        $shipmentItem = $shipmentItemCollection->createItem($item);
        $shipmentItem->setQuantity($item->getQuantity());
    }

    /*Payment*/
    $paymentCollection = $order->getPaymentCollection();
    $extPayment = $paymentCollection->createItem();
    $paySystemService = PaySystem\Manager::getObjectById(1);
$extPayment->setFields(array(
    'PAY_SYSTEM_ID' => $paySystemService->getField("PAY_SYSTEM_ID"),
    'PAY_SYSTEM_NAME' => $paySystemService->getField("NAME"),
    )); // Устанавливаем свойства

    /**/
    $order->doFinalAction(true);
    $propertyCollection = $order->getPropertyCollection();
//$propertyCollection = $order->getPropertyCollection();

    foreach($propertyCollection->getGroups() as $group){
	foreach($propertyCollection->getGroupProperties($group['ID']) as $property){
                $p = $property->getProperty();

                if($p["CODE"] == "FIO"){
                    $property->setValue($request->getPost('name'));
                }
                if($p["CODE"] == "PHONE"){
                    $property->setValue($request->getPost('telephone'));
                }
				if($p["CODE"] == "LOCATION"){
					$property->setValue('0000073738');
				}
	}
    }            

    $order->setField('CURRENCY', $currencyCode);
    $order->setField('COMMENTS', 'Заказ без регистрации. ');
    $order->save();
    $orderId = $order->GetId();


$orderF = $order;
$arr = array();
$arr_rr = array();
$basketF = $orderF->getBasket();
	foreach($basketF AS $itemF){
	$f = $itemF->getFields();
	$mxResult  = CCatalogSku::GetProductInfo($f["PRODUCT_ID"]);
	$f["PRODUCT_ID"] = $mxResult['ID'];
	$arr[] = $f["PRODUCT_ID"];
	$arr_rr[] = "{id:".$f["PRODUCT_ID"].", qnt: ".$f["QUANTITY"].",price:".$f["PRICE"]."}";
$gtm[] = "{
				'name': '". $а['NAME'] . "', // название товара
				'id': '" . $f["PRODUCT_ID"] ."', // id товара
				'price': '". $f["PRICE"] ."',
				'variant': '" . $product['option']['option_value'] ."',
				'quantity': '". $f["QUANTITY"]. "'
				}";
	}

$script = '
<script type="text/javascript">
		var _tmr = _tmr || [];
		_tmr.push({
			id: "3065581",
			type: "itemView",
			productid: "['.join(',',$arr).']",
			pagetype: "purchase",
			list: "1",
			totalvalue: "'.$basketF->getPrice().'"
		});


(window["rrApiOnReady"] = window["rrApiOnReady"] || []).push(function() {
    try {
        rrApi.order({
            transaction: "'.$orderId.'",
            items: [
                '. join(',',$arr_rr) .'
            ]
        });
    } catch(e) {}
});

				dataLayer.push({
				"ecommerce": {
						"currencyCode": "RUB",
						"purchase": {
								"actionField": {
								"id": "'.$orderId.'",
								"revenue": "'.$orderF->getPrice().'",
								"shipping": "'.($orderF->getPrice()-$basketF->getPrice()).'"
							},
							"products": ['.join(',',$gtm).']
					}
				},
				"event": "gtm-ee-event",
				"gtm-ee-event-category": "Enhanced Ecommerce",
				"gtm-ee-event-action": "Purchase",
				"gtm-ee-event-non-interaction": "False",
			});
			</script>';



    if($orderId > 0){
      if($USER->IsAuthorized()){
        if($_SESSION['moscow']){
          $msg = sprintf('<p>Номер вашего заказа %s.</p><p>В данный момент заказ успешно размещен и собирается.</p><p>В течение часа с Вами свяжется оператор, чтобы уточнить детали доставки.</p>', $orderId);
		$msg .= $script;
        }else{
     	  $msg = sprintf('<p>Номер вашего заказа %s.</p><p>Мы отправили на вашу почту письмо со всей информацией.</p><p>В данный момент заказ успешно размещен и обрабатывается.</p><p>Мы проверим наличие вашего заказа на складе и сообщим результат дополнительным письмом.</p>', $orderId) . $script;
        }
      }else{
	$msg = sprintf('<p>Номер вашего заказа %s.</p><p>В данный момент заказ успешно размещен и собирается.</p><p>В течение часа с Вами свяжется оператор, чтобы уточнить детали доставки.</p>', $orderId) . $script;
      }  
		echo $msg;//json_encode(array('order_id'=>$orderId,'msg'=>$msg));
      CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());
    }else{
		echo 'Ошибка оформления';//json_encode(array('order_id'=>$orderId,'msg'=>'Ошибка оформления'));
    }
}else{
$orderId =96106;
$orderF = \Bitrix\Sale\Order::load(96106);
$arr = array();
$arr_rr = array();
$basketF = $orderF->getBasket();
	foreach($basketF AS $itemF){
	$f = $itemF->getFields();
	$mxResult  = CCatalogSku::GetProductInfo($f["PRODUCT_ID"]);
	$f["PRODUCT_ID"] = $mxResult['ID'];
	$arr[] = $f["PRODUCT_ID"];
	$arr_rr[] = "{id:".$f["PRODUCT_ID"].", qnt: ".$f["QUANTITY"].",price:".$f["PRICE"]."}";
$gtm[] = "{
				'name': '". $а['NAME'] . "', // название товара
				'id': '" . $f["PRODUCT_ID"] ."', // id товара
				'price': '". $f["PRICE"] ."',
				'variant': '" . $product['option']['option_value'] ."',
				'quantity': '". $f["QUANTITY"]. "'
				}";
	}

	$script ='<script type="text/javascript">
		var _tmr = _tmr || [];
		_tmr.push({
			id: "3065581",
			type: "itemView",
			productid: "['.join(',',$arr).']",
			pagetype: "purchase",
			list: "1",
			totalvalue: "'.$basketF->getPrice().'"
		});


(window["rrApiOnReady"] = window["rrApiOnReady"] || []).push(function() {
    try {
        rrApi.order({
            transaction: "'.$orderId.'",
            items: [
                '. join(',',$arr_rr) .'
            ]
        });
    } catch(e) {}
});

				dataLayer.push({
				"ecommerce": {
						"currencyCode": "RUB",
						"purchase": {
								"actionField": {
								"id": "'.$orderId.'",
								"revenue": "'.$orderF->getPrice().'",
								"shipping": "'.($orderF->getPrice()-$basketF->getPrice()).'"
							},
							"products": ['.join(',',$gtm).']
					}
				},
				"event": "gtm-ee-event",
				"gtm-ee-event-category": "Enhanced Ecommerce",
				"gtm-ee-event-action": "Purchase",
				"gtm-ee-event-non-interaction": "False",
			});
			</script>';

	echo sprintf('<p>Номер вашего заказа %s.</p><p>В данный момент заказ успешно размещен и собирается.</p><p>В течение часа с Вами свяжется оператор, чтобы уточнить детали доставки.</p>', 96106).$script;

}
?>