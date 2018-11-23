<? require ($_SERVER["DOCUMENT_ROOT"] .
"/bitrix/modules/main/include/prolog_before.php");


if (!$_REQUEST['id'] || !$_REQUEST['phone'] || !$_REQUEST['name'] || !$_REQUEST['shop']) {
    $msg = 'Заполните пустые поля';
    echo json_encode(array('order_id' => $orderId, 'msg' => $msg));
    die();
}
;

use Bitrix\Main\Context, Bitrix\Currency\CurrencyManager, Bitrix\Sale\Order,
    Bitrix\Sale\Basket, Bitrix\Sale\Delivery, Bitrix\Sale\PaySystem;

global $USER;

Bitrix\Main\Loader::includeModule("sale");
Bitrix\Main\Loader::includeModule("catalog");

// Допустим некоторые поля приходит в запросе
$request = Context::getCurrent()->getRequest();
$productId = $_REQUEST['id'];
$phone = $_REQUEST['phone'];
$name = $_REQUEST['name'];
$shop = $_REQUEST['shop'];
$comment = 'Быстрый заказ с самовывозом в магазин.';

$siteId = Context::getCurrent()->getSite();
$currencyCode = CurrencyManager::getBaseCurrency();

if (!$USER->isAuthorized()) {
    $rsUsers = CUser::GetList(($bys = "NAME"), ($orders = "desc"), array("PERSONAL_PHONE" =>
            $phone), array('ID'))->GetNext();
    if ($rsUsers) {
        $USERID = $rsUsers['ID'];
    } else {
        $anonUserEmail = "oneclick_" . randString(9) . "@sneakerhead.ru";
        $fields = array(
            "NAME" => $name,
            "EMAIL" => $anonUserEmail,
            "PERSONAL_PHONE" => $phone,
            "LOGIN" => $anonUserEmail,
            "LID" => "ru",
            "LANGUAGE_ID" => "ru",
            "ACTIVE" => 'Y',
            "GROUP_ID" => array(11, 5),
            "PASSWORD" => "q9C3OGhu",
            "CONFIRM_PASSWORD" => "q9C3OGhu",
            );
        $user = new CUser;
        $USERID = $user->Add($fields);
    }
    if (!$USERID) {
    $msg = '<p>Ошибка создания пользователя. Попробуйте позже</p>';
    echo $msg;
    die();
}
}

// Создаёт новый заказ
$order = Order::create($siteId, $USER->isAuthorized() ? $USER->GetID() : $USERID);
$order->setPersonTypeId(1);
$order->setField('CURRENCY', $currencyCode);
if ($comment) {
    $order->setField('USER_DESCRIPTION', $comment);
    // Устанавливаем поля комментария покупателя
}

// Создаём корзину с одним товаром
$basket = Basket::create($siteId);
$item = $basket->createItem('catalog', $productId);
$item->setFields(array(
    'QUANTITY' => 1,
    'CURRENCY' => $currencyCode,
    'LID' => $siteId,
    'PRODUCT_PROVIDER_CLASS' => '\CCatalogProductProvider',
    ));
$order->setBasket($basket);
$order->setField('COMMENTS', $comment);

// Создаём одну отгрузку и устанавливаем способ доставки - "Без доставки" (он служебный)

$shipmentCollection = $order->getShipmentCollection();
$shipment = $shipmentCollection->createItem();
$service = Delivery\Services\Manager::getById(3);
$shipment->setFields(array(
    'DELIVERY_ID' => $service['ID'],
    'DELIVERY_NAME' => $service['NAME'],
    ));
$shipment->setStoreId($shop);
$shipmentItemCollection = $shipment->getShipmentItemCollection();
$shipmentItem = $shipmentItemCollection->createItem($item);
$shipmentItem->setQuantity($item->getQuantity()); // Создаём оплату со способом #1
$paymentCollection = $order->getPaymentCollection();
$payment = $paymentCollection->createItem();
$paySystemService = PaySystem\Manager::getObjectById(1);
$payment->setFields(array(
    'PAY_SYSTEM_ID' => $paySystemService->getField("PAY_SYSTEM_ID"),
    'PAY_SYSTEM_NAME' => $paySystemService->getField("NAME"),
    )); // Устанавливаем свойства
$propertyCollection = $order->getPropertyCollection();
$phoneProp = $propertyCollection->getPhone();
$phoneProp->setValue($phone);
$nameProp = $propertyCollection->getPayerName();
$nameProp->setValue($name); // Сохраняем
$order->doFinalAction(true);
$result = $order->save();
$orderId = $order->getId();
/*$pr = \Bitrix\Sale\Order::load($orderId);
//Получение списка доставок
$shipmentCollection = $pr->getShipmentCollection();
foreach ($shipmentCollection as $shipment) {
    //Пропуск системных значений
    if ($shipment->isSystem())
        continue;
    $shipment->setStoreId($shop);
    $pr->save();
}*/
if ($orderId) {
    if ($USER->IsAuthorized()) {
        if ($_SESSION['moscow']) {
            $msg = sprintf('<p>Номер вашего заказа %s.</p><p>В данный момент заказ успешно размещен и собирается.</p><p>В течение часа с Вами свяжется оператор, чтобы уточнить детали доставки.</p>',
                $orderId);
        } else {
            $msg = sprintf('<p>Номер вашего заказа %s.</p><p>Мы отправили на вашу почту письмо со всей информацией.</p><p>В данный момент заказ успешно размещен и обрабатывается.</p><p>Мы проверим наличие вашего заказа на складе и сообщим результат дополнительным письмом.</p>',
                $orderId);
        }
    } else {
        $msg = sprintf('<p>Номер вашего заказа %s.</p><p>В данный момент заказ успешно размещен и собирается.</p><p>В течение часа с Вами свяжется оператор, чтобы уточнить детали доставки.</p>',
            $orderId);
    }
    echo $msg;
} else {
    echo $msg;
}
;

/*
use Bitrix\Main, Bitrix\Main\Loader, Bitrix\Main\Config\Option, Bitrix\Sale,
Bitrix\Sale\Order, Bitrix\Main\Application, Bitrix\Sale\DiscountCouponsManager;
if (!Loader::IncludeModule('sale'))
die();
$request = Application::getInstance()->getContext()->getRequest();
global $USER, $APPLICATION;
$siteId = \Bitrix\Main\Context::getCurrent()->getSite();
$currencyCode = Option::get('sale', 'default_currency', 'RUB');
DiscountCouponsManager::init();
$bUserExists = false;
$anonUserID = $USER->GetID();
if ($anonUserID > 0) {
//$dbUser = CUser::GetList('id', 'asc', array('%NAME'=>$request->getPost('name'),'%PERSONAL_PHONE'=>$request->getPost('telephone')), array("FIELDS" => array("ID")));
//if($arUser = $dbUser->Fetch())
$anonUser = CUser::GetByID($anonUserID)->Fetch();
$bUserExists = true;
}
if (!$bUserExists) {
$anonUserEmail = "oneclick_" . randString(9) . "@example.com";
$arErrors = array();
$anonUserID = CSaleUser::DoAutoRegisterUser($anonUserEmail, array('NAME' => $request->
getPost('name')), $siteId, $arErrors, array("ACTIVE" => "N"));
$user = new CUser;
$user->Update($anonUserID, array(
'PERSONAL_PHONE' => $request->getPost('telephone'),
'PERSONAL_COUNTRY' => 1,
'PERSONAL_CITY' => 'Москва'));
if ($anonUserID > 0) {
//COption::SetOptionInt("sale", "one_click_user_id", $anonUserID);
$anonUser = CUser::GetByID($anonUserID)->Fetch();
} else {
$errorMessage = "";
if (!empty($arErrors)) {
$errorMessage = " ";
foreach ($arErrors as $value) {
$errorMessage .= $value["TEXT"] . "<br />";
}
}
$APPLICATION->ThrowException("Ошибка создания анонимного пользователя." . $errorMessage,
"ANONYMOUS_USER_CREATE_ERROR");
return 0;
}
}

$basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), $siteId);
$productId = intval($request->getPost("id"));
$quantity = intval($request->getPost("quantity"));
if ($item = $basket->getExistsItem('catalog', $productId)) {
$item->setField('QUANTITY', $item->getQuantity() + $quantity);
//добавляем указанное количество к существующему товару
} else {
$item = $basket->createItem('catalog', $productId);
//создаём новый товар в корзине
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
$basket = Sale\Basket::loadItemsForFUser(\CSaleBasket::GetBasketUserID(), $siteId)->
getOrderableItems();
$order->setBasket($basket);
$shipmentCollection = $order->getShipmentCollection();
$shipment = $shipmentCollection->createItem();
$shipment->setFields(array(
'DELIVERY_ID' => 3,
'DELIVERY_NAME' => 'Самовывоз',
'CURRENCY' => $order->getCurrency()));
$shipmentItemCollection = $shipment->getShipmentItemCollection();
foreach ($order->getBasket() as $item) {
$shipmentItem = $shipmentItemCollection->createItem($item);
$shipmentItem->setQuantity($item->getQuantity());
}


$paymentCollection = $order->getPaymentCollection();
$extPayment = $paymentCollection->createItem();
$extPayment->setFields(array(
'PAY_SYSTEM_ID' => 2,
'PAY_SYSTEM_NAME' => 'Оплата при получении',
'SUM' => $order->getPrice()));
$order->doFinalAction(true);
$propertyCollection = $order->getPropertyCollection();
$propertyCollection = $order->getPropertyCollection();
foreach ($propertyCollection->getGroups() as $group) {
foreach ($propertyCollection->getGroupProperties($group['ID']) as $property) {
$p = $property->getProperty();
if ($p["CODE"] == "FIO") {
$property->setValue($anonUser['NAME']);
}
if ($p["CODE"] == "PHONE") {
$property->setValue($anonUser['PERSONAL_PHONE']);
}
}
}

$order->setField('CURRENCY', $currencyCode);
$order->setField('COMMENTS', 'Быстрый заказ с самовывозом в магазин. ' . $comment);
$order->save();
$orderId = $order->GetId();
if ($orderId > 0) {
if ($USER->IsAuthorized()) {
if ($_SESSION['moscow']) {
$msg = sprintf('<p>Номер вашего заказа %s.</p><p>В данный момент заказ успешно размещен и собирается.</p><p>В течение часа с Вами свяжется оператор, чтобы уточнить детали доставки.</p>',
$orderId);
} else {
$msg = sprintf('<p>Номер вашего заказа %s.</p><p>Мы отправили на вашу почту письмо со всей информацией.</p><p>В данный момент заказ успешно размещен и обрабатывается.</p><p>Мы проверим наличие вашего заказа на складе и сообщим результат дополнительным письмом.</p>',
$orderId);
}
} else {
$msg = sprintf('<p>Номер вашего заказа %s.</p><p>В данный момент заказ успешно размещен и собирается.</p><p>В течение часа с Вами свяжется оператор, чтобы уточнить детали доставки.</p>',
$orderId);
}
echo json_encode(array('order_id' => $orderId, 'msg' => $msg));
CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());
} else {
echo json_encode(array('order_id' => $orderId, 'msg' => 'Ошибка оформления'));
}
*/



