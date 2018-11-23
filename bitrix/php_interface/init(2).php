<?php

CModule::AddAutoloadClasses('', array(
    "Util" => "/bitrix/php_interface/classes/Util.php",
    "IblockElementPropertyTable" =>
        "/bitrix/php_interface/classes/IblockElementPropertyTable.php",
    "Import" => "/bitrix/php_interface/classes/Import.php",
    "ImportOrder" => "/bitrix/php_interface/classes/ImportOrder.php",
    ));

AddEventHandler("main", "OnBuildGlobalMenu", "MyOnBuildGlobalMenu");
function MyOnBuildGlobalMenu(&$aGlobalMenu, &$aModuleMenu)
{

    $NewItem = $aGlobalMenu["global_menu_desktop"];
    $NewItem = array(
        'menu_id' => 'logistic',
        'text' => 'Логистика',
        'title' => 'Логистика',
        'url' => '/',
        'sort' => 10,
        'items_id' => 'logistic',
        'help_section' => 'logistic',
        'items' => array());
    $NewItem["items"][] = array(
        "text" => 'Логистический модуль (Сайт)',
        "url" => "/logistic/",
        "title" => "",
        "page_icon" => "clouds_page_icon",
        "items_id" => "menu_clouds_bucket_" . $arBucket["ID"],
        "module_id" => "clouds",
        "items" => array());
    $NewItem["items"][] = array(
        "text" => 'Логистический модуль (Админ панель)',
        "url" => "/bitrix/admin/iblock_list_admin.php?IBLOCK_ID=19&type=references&lang=ru",
        "title" => "",
        "page_icon" => "clouds_page_icon",
        "items_id" => "menu_clouds_bucket_" . $arBucket["ID"],
        "module_id" => "clouds",
        "items" => array());
    $aGlobalMenu[] = $NewItem;
}

// файл /bitrix/php_interface/init.php
// регистрируем обработчик
AddEventHandler("search", "BeforeIndex", array("Srch", "BeforeIndexHandler"));

class Srch
{
    // создаем обработчик события "BeforeIndex"
    function BeforeIndexHandler($arFields)
    {
        if (!CModule::IncludeModule("iblock")) // подключаем модуль

            return $arFields;
        if ($arFields["MODULE_ID"] == "iblock" && $arFields["PARAM2"] == 2) {


            if (CModule::IncludeModule('iblock')) {
                $arSort = array("NAME" => "ASC");
                $arSelect = array(
                    "ID",
                    "NAME",
                    "PROPERTY_BRAND",
                    "IBLOCK_SECTION_ID");
                $arFilter = array("IBLOCK_ID" => 2, "ID" => $arFields["ITEM_ID"]);

                $res = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);

                while ($ob = $res->GetNextElement()) {


                    $fields = $ob->GetFields();
                    $category = CIBlockSection::GetByID($fields['~IBLOCK_SECTION_ID'])->GetNext()['NAME'];

                    $brand = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 6, 'ID' => $fields['PROPERTY_BRAND_VALUE']), false, false,
                        array(
                        'ID',
                        'IBLOCK_ID',
                        'NAME'))->GetNext()['NAME'];


                    $arFields["TITLE"] = $category . ' ' . $brand . ' ' . $arFields["TITLE"];


                    /*
                    if ( $arFields["ITEM_ID"]==77347){
                    echo '<pre>';
                    var_dump($fields);
                    echo '</pre>';
                    echo $arFields["TITLE"] . '<br>';
                    exit;

                    }
                    */
                }
            }


        }

        return $arFields; // вернём изменения
    }
}

$eventManager = \Bitrix\Main\EventManager::getInstance();


/*Подстановка цены товара для активных при изменении*/
$eventManager->addEventHandler("iblock", "OnAfterIBlockElementUpdate",
    "SetPrice");
$eventManager->addEventHandler("iblock", "OnAfterIBlockElementAdd", "SetPrice");


/*Убираем ненужные способы оплаты*/


//AddEventHandler("sale", "OnSaleComponentOrderDeliveriesCalculated","myOnSaleComponentOrderResultPrepared");
AddEventHandler("sale", "OnSaleComponentOrderDeliveriesCalculated",
    "myOnSaleComponentOrderResultPrepared");


function myOnSaleComponentOrderResultPrepared($order, &$arUserResult, $request,
    &$arParams, &$arResult, &$arDeliveryServiceAll, &$arPaySystemServiceAll)
    //($ID, $arFields)
{

    global $DB;
    global $USER;


    $off = false;

    $props = $order->getPropertyCollection();
    $Location = $props->getDeliveryLocation()->getValue();

    $basket = $order->getBasket();
    $price = $basket->getPrice();
    $basketItems = $basket->getBasketItems();
    $arrayP = array();

    $noMoscow = false;

    foreach ($basketItems as $basketItem) {
        $mxResult = CCatalogSku::GetProductInfo($basketItem->getProductId());

        $poS = CIBlockElement::GetList(array(), array('IBLCOK_ID' => 2, 'ID' => $mxResult['ID']), false, false,
            array(
            'ID',
            'IBLOCK_ID',
            'PROPERTY_STOCK_STATUS'))->GetNext();
        if ($poS['PROPERTY_STOCK_STATUS_VALUE'] == 22730) {
            $noMoscow = true;
        }
    }
    ;


    if ($Location == '0000073738' && $noMoscow) {
        foreach ($arDeliveryServiceAll as $key => $ps) {
            unset($arDeliveryServiceAll[$key]);
        }
        foreach ($arPaySystemServiceAll as $key => $ps) {
            unset($arPaySystemServiceAll[$key]);
        }
        foreach ($arResult["DELIVERY"] as $key => $ps) {
            unset($arResult["DELIVERY"][$key]);
        }
    }

    //echo '<pre>';
    //var_dump($arResult["DELIVERY"]);
    //echo '</pre>';
    //mail('dimm4ik@yandex.ru','test',print_r($arPaySystemServiceAll,true));
    /*
    if ($Location != '0000073738') {


    //Для товаров из распродажи отключить оплату при получении


    foreach ($basketItems as $item) {
    $pid = CCatalogSKU::GetProductInfo($item->getProductId())['ID'];


    $rsElement = CIBlockElement::GetList(array(), array(
    "SECTION_ID" => 55,
    "PROPERTY_NEW_VALUE" => "Y",
    "IBLOCK_ID" => 2,
    "ACTIVE" => "Y",
    "ID" => $pid), false, array("ID"), array("ID"));


    if ($rsElement->SelectedRowsCount() > 0) {


    $off = true;
    }

    }


    }
    /*Выбираем оплаченные заказы текущего пользователя и считаем сумму*/
    /*
    $arFilter = array("USER_ID" => $USER->GetID(), 'PAYED' => 'Y');
    $rsOrders = CSaleOrder::GetList(array('ID' => 'DESC'), $arFilter, array('SUM' =>
    'PRICE'));

    $sum = 0;
    while ($ar_sales = $rsOrders->Fetch()) {
    $sum = $sum + $ar_sales['PRICE'];

    }
    /*Если оплаченных заказов на 15000 или более - разрешим постоплату*/
    /*if ($sum > 15000) {

    $off = false;

    }*/

    if ($price >= 20000 && $Location != '0000073738') {
        //За пределами москвы недоступна постоплата заказов от 20.000
        $off = true;

    }
    if ($Location == '0000073738') {
        //В москве недоступна постоплата 4х и больше позиций
        $arcount = $basket->getQuantityList();
        $cnt = array_sum($arcount);

        if ($cnt >= 4) {

            $off = true;
        }

    }


    //Черный список
    $arGroups = CUser::GetUserGroup($USER->GetID());
    if (in_array(12, $arGroups)) {

        $off = true;

    }


    if ($off == true) {

        foreach ($arPaySystemServiceAll as $key => $ps) {

            if ($ps['ID'] == 1) {

                //Убираем оплату при получении

                //$arPaySystemServiceAll[$key]['ACTIVE']="N";
                unset($arPaySystemServiceAll[$key]);

            }

        }


    }
    if (in_array(22727, $arrayP)) {
        foreach ($arPaySystemServiceAll as $key => $ps) {

            if ($ps['ID'] != 10) {

                //Убираем оплату при получении

                //$arPaySystemServiceAll[$key]['ACTIVE']="N";
                unset($arPaySystemServiceAll[$key]);

            }

        }
    } else
        if (in_array(22728, $arrayP) && $Location != '0000073738') {
            foreach ($arPaySystemServiceAll as $key => $ps) {

                if ($ps['ID'] != 10) {

                    //Убираем оплату при получении

                    //$arPaySystemServiceAll[$key]['ACTIVE']="N";
                    unset($arPaySystemServiceAll[$key]);

                }

            }
        }


}


\Bitrix\Main\EventManager::getInstance()->addEventHandler('sale',
    'OnSaleComponentOrderJsData', 'OnSaleComponentOrderJsData');

function OnSaleComponentOrderJsData(&$arResult, &$arParams)
{
    //\Bitrix\Main\Diag\Debug::writeToFile($arResult,'','/upload/order_log.txt');
    $arResult['ERX'] = 'DRUGS!!!';
}


\Bitrix\Main\EventManager::getInstance()->addEventHandler('sale',
    'onSaleDeliveryServiceCalculate', 'onSaleDeliveryServiceCalculate');
Bitrix\Main\EventManager::getInstance()->addEventHandler('sale',
    'OnBasketUpdate', "OnBasketUpdateHandler");

function onSaleDeliveryServiceCalculate(\Bitrix\Main\Event $event)
{
    $calcResult = $event->getParameter('RESULT');

    $shipment = $event->getParameter('SHIPMENT');
    if ($shipment->getField("DELIVERY_ID") == 280 || $shipment->getField("DELIVERY_ID") ==
        281) {
        $order = $shipment->getCollection()->getOrder();

        $sum = $order->getPrice();

        $props = $order->getPropertyCollection();
        $Location = $props->getDeliveryLocation()->getValue();
        if ($Location == '0000073738') {
            $calcResult->setDeliveryPrice(0);
        }
    }
    if ($shipment->getField("DELIVERY_ID") == 256) {

        $order = $shipment->getCollection()->getOrder();

        $sum = $order->getPrice();

        $props = $order->getPropertyCollection();
        $Location = $props->getDeliveryLocation()->getValue();


        $arLocs = CSaleLocation::GetByID($Location, LANGUAGE_ID);

        $country = $arLocs["COUNTRY_NAME"];


        if ($country == 'Россия') {

            $newPrice = ceil($calcResult->getDeliveryPrice() + 70);
            $newPrice = round($newPrice, -1);

            $calcResult->setDeliveryPrice($newPrice);

        } else {
            $basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(), \Bitrix\Main\Context::
                getCurrent()->getSite());

            $weight = $basket->getWeight();
            $weight = $weight / 1000;

            $del = $weight - 1;


            if ($del > 0) {


                $del = ceil($del);

                $dost = 1500 + 1000 * $del;

            } else {


                $dost = 1500;

            }


            $calcResult->setDeliveryPrice($dost);

        }


        return new \Bitrix\Main\EventResult(\Bitrix\Main\EventResult::SUCCESS, array("RESULT" =>
                $calcResult, ));


    }
}


function OnBasketUpdateHandler($ID, $arFields)
{
    if (!$arFields['ORDER_ID'] && \Bitrix\Main\Loader::includeModule('sale')) {
        $basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(), \Bitrix\Main\Context::
            getCurrent()->getSite());
        $quantity = count($basket->getQuantityList());
        $weight = 300 / $quantity;
        $basketItems = $basket->getBasketItems();

        foreach ($basketItems as $basketItem) {
            CSaleBasket::Update($basketItem->getId(), array('WEIGHT' => (getWeight($basketItem->
                    getProductId()) + $weight)));
        }
    }
}

function getWeight($ID)
{
    if (CModule::IncludeModule('catalog')) {
        $ar_res = \CCatalogProduct::GetByID($ID);
        return $ar_res['WEIGHT'];
    }
}

function SetPrice(&$arFields)
{
	/*
    CModule::IncludeModule('iblock');
    CModule::IncludeModule('catalog');


    $IBLOCK_ID = 2;
    $ID = $arFields['ID'];
    $arInfo = CCatalogSKU::GetInfoByProductIBlock($IBLOCK_ID);

    if (is_array($arInfo)) {


        $ar_res = CPrice::GetBasePrice($ID);

        if (isset($ar_res['PRICE'])) {

            $ret = $ar_res['PRICE'];


        }
        if (!isset($ret) || $ret == null) {

            $res = CIBlockElement::GetList(array("PRICE" => "asc"), array(
                'IBLOCK_ID' => $arInfo['IBLOCK_ID'],
                'ACTIVE' => 'Y',
                'PROPERTY_' . $arInfo['SKU_PROPERTY_ID'] => $ID,
                'CATALOG_AVAILABLE' => 'Y'), false, false, array(
                'ID',
                'NAME',
                'CATALOG_QUANTITY'))->GetNext();
            if ($res) {


                $ret = GetCatalogProductPrice($res["ID"], 1);
                if ($ret['PRICE']) {
                    $ret = $ret['PRICE'];
                }
            } else {


                $res = CIBlockElement::GetList(array("PRICE" => "asc"), array(
                    'IBLOCK_ID' => $arInfo['IBLOCK_ID'],
                    'ACTIVE' => 'Y',
                    'PROPERTY_' . $arInfo['SKU_PROPERTY_ID'] => $ID), false, false, array(
                    'ID',
                    'NAME',
                    'CATALOG_QUANTITY'))->GetNext();

                if ($res) {


                    $ret = GetCatalogProductPrice($res["ID"], 1);
                    if ($ret['PRICE']) {
                        $ret = $ret['PRICE'];
                    }
                }


            }
        }
    }


    CIBlockElement::SetPropertyValuesEx($arFields['ID'], false, array('PRICE_SORT' =>
            $ret));
*/
}


/*Ограничения для служб доставки ВСЕ КРОМЕ*/


$eventManager->addEventHandler('sale',
    'onSaleDeliveryRestrictionsClassNamesBuildList', 'myDeliveryRestrictions');

function myDeliveryRestrictions()
{
    return new \Bitrix\Main\EventResult(\Bitrix\Main\EventResult::SUCCESS, array('\ExclLocationsDeliveryRestriction' =>
            '/bitrix/php_interface/include/ExclLocationsDeliveryRestriction.php', ));
}

AddEventHandler("sale", "OnOrderSave", "My_OnOrderSave");
AddEventHandler("sale", "OnOrderUpdate", "My_OnOrderSave2");
//Событие при оформлении заказа (распределение по складам, создания XML, отправка данных на баскетшоп)
function My_OnOrderSave($orderId)
{

    $ALL = array();
    $OrderY = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 19,
            "PROPERTY_ORDER" => $orderId), false, false, array("ID", "IBLOCK_ID"))->GetNext();

    CModule::IncludeModule("sale");
    CModule::IncludeModule('catalog');
    CModule::IncludeModule("grain.tables");
    $ro = CSaleOrder::GetList(array("ID" => "DESC"), array('ID' => $orderId), false, false,
        array(
        "ID",
        "DELIVERY_ID",
        "PAY_SYSTEM_ID",
        "DATE_INSERT",
        "STATUS_ID",
        "PRICE",
        "DISCOUNT_VALUE",
        "LOCK_STATUS",
        "COMMENTS",
        "ACCOUNT_NUMBER"));

    $pr = \Bitrix\Sale\Order::load($orderId);

    $basket = $pr->getBasket();
    $price = $basket->getPrice();

    $paymentCollection = $pr->getPaymentCollection();
    $paydSum = $paymentCollection->getPaidSum();
    $paymentSelected = $pr->getPaymentSystemId()['0'];

    if ($price != $paydSum && ($paymentSelected != 1 && $paymentSelected != 2)) {
        CSaleOrder::DeliverOrder($order_id, "N");
    }

    if ((($paymentSelected == 1 || $paymentSelected == 2) || ($price == $paydSum)) &&
        $pr->getField('ALLOW_DELIVERY') == 'N') { //->getPaymentSystemId()== 'N'){
        CSaleOrder::DeliverOrder($order_id, "Y");
    }


    while ($order = $ro->GetNext()) {
        $STORE_ITEM = array();
        //Получаем объект заказа
        $pr = \Bitrix\Sale\Order::load($order['ID']);
        //Получение списка доставок
        $shipmentCollection = $pr->getShipmentCollection();
        foreach ($shipmentCollection as $shipment) {
            //Пропуск системных значений
            if ($shipment->isSystem())
                continue;
            //Получение ID магазина выбранного пользователем (доставка в заказе)
            $STORE_ID = $shipment->getStoreId();
            //Получение товаров в доставке
            $COL = $shipment->getshipmentItemCollection();
            //Получение статуса доставки
            $STATUS = $shipment->getcollection();
            foreach ($STATUS as $STAT) {
                //Пропуск системных значений
                if ($STAT->isSystem())
                    continue;
                $STATs = $STAT->getfields();
                foreach ($COL as $item) {
                    $i = $item->getfields();
                    //Сравнение ID доставки полученной у товара и у заказа в общем
                    if ($i["ORDER_DELIVERY_ID"] == $STATs["ID"]) {
                        $S = $STATs["STATUS_ID"];
                        $basketItem = $item->getBasketItem();
                        $items = $basketItem->getProductId();
                        //Получение ID склада (пользовательский)
                        $STORE_ITEM[$items][] = $STORE_ID;
                        //Получение статуса текущей доставки
                        $STORE_ITEM[$items][] = $S;
                    }
                    ;
                }
                ;
            }
            ;
        }
        ;
        //получаем корзину товаров заказа
        $rb = CSaleBasket::GetList(array("NAME" => "ASC", "ID" => "ASC"), array("ORDER_ID" =>
                $order["ID"]), false, false, array(
            "ID",
            "ORDER_ID",
            "PRODUCT_ID",
            "NAME",
            "PRICE",
            "QUANTITY",
            "DISCOUNT_VALUE",
            "STORE_ID"));
        //Массив разбивки позиций заказа
        while ($it = $rb->GetNext()) {
            $storeRAZ = array();
            //получаем свойства торгового предложения
            $offer = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 3, "ID" => $it["PRODUCT_ID"]), false, false,
                array(
                "ID",
                "IBLOCK_ID",
                "PROPERTY_SIZES_SHOES",
                "PROPERTY_CML2_LINK",
                "STORE_ID",
                "PROPERTY_C_CODE",
                "PROPERTY_ARTNUMBER_T",
                "CATALOG_QUANTITY"))->GetNext();
            //Получаем ID размера
            $size = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 17, "ID" => $offer["PROPERTY_SIZES_SHOES_VALUE"]), false, false,
                array("NAME", "ID"))->GetNext();
            if ($offer) {
                $STORE_ID = $STORE_ITEM[$it["PRODUCT_ID"]][0];
                $STATUS = $STORE_ITEM[$it["PRODUCT_ID"]][1];
                //получаем свойства товара
                $rp = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 2, "ID" => $offer["PROPERTY_CML2_LINK_VALUE"]), false, false,
                    array(
                    "ID",
                    "IBLOCK_ID",
                    "PREVIEW_PICTURE",
                    "PROPERTY_ARTNUMBER"))->GetNext();
                //Проверяем наличие товара на выбранном складе
                $rsStore = CCatalogStoreProduct::GetList(array(), array(
                    'IBLOCK_ID' => '3',
                    'PRODUCT_ID' => $it["PRODUCT_ID"],
                    'STORE_ID' => $STORE_ID), false, false, array('AMOUNT', 'STORE_ID'))->GetNext();
                $arFieldsNEW = array("QUANTITY" => (float)$offer["CATALOG_QUANTITY"] - (float)$it["QUANTITY"]);
                $priorSHOPID = array();
                $ah = CCatalogStore::GetList(array('SORT' => 'ASC'), array('!ID' => $STORE_ID), false, false,
                    array('NAME', 'ID'));
                while ($ahprior = $ah->GetNext()) {
                    $priorSHOPID[] = $ahprior['ID'];
                }
                ;
                if ($rsStore['AMOUNT'] >= $it["QUANTITY"] && isset($rsStore['AMOUNT']) && $rsStore['AMOUNT'] != false) {
                    $storeRAZ['n0']['in'] = 8;
                    $storeRAZ['n0']['out'] = $STORE_ID;
                    $storeRAZ['n0']['col'] = (string )$it["QUANTITY"];
                    $storeRAZ['n0']['yes_m'] = 'no';
                    $storeRAZ['n0']['yes_a'] = 'no';
                    $storeRAZ['n0']['stat'] = 'none';
                    $storeRAZ['n0']['samov'] = 'no';
                    if ($storeRAZ['n0']['out'] == $STORE_ID) {
                        $storeRAZ['n0']['samov'] = 'yes';
                    } else {
                        $storeRAZ['n0']['samov'] = 'no';
                    }
                    ;
                    $it["QUANTITY"] = 0;
                }
                ;
                //Если не выполненно предыдущие условие - ищем склад удовлетворяющий условиям наличия товаров (все колличество)
                if ($it["QUANTITY"] > 0) {
                    foreach ($priorSHOPID as $SHOPID) {
                        $rsStore = CCatalogStoreProduct::GetList(array(), array(
                            'IBLOCK_ID' => '3',
                            'PRODUCT_ID' => $it["PRODUCT_ID"],
                            'STORE_ID' => $SHOPID), false, false, array('AMOUNT', 'STORE_ID'))->GetNext();
                        if ($rsStore['AMOUNT'] >= $it["QUANTITY"] && isset($rsStore['AMOUNT']) && $rsStore['AMOUNT'] != false &&
                            $rsStore['AMOUNT'] != null && $it["QUANTITY"] > 0) {
                            $storeRAZ['n0']['in'] = 8;
                            $storeRAZ['n0']['out'] = $SHOPID;
                            $storeRAZ['n0']['col'] = (string )$it["QUANTITY"];
                            $storeRAZ['n0']['yes_m'] = 'no';
                            $storeRAZ['n0']['yes_a'] = 'no';
                            $storeRAZ['n0']['stat'] = 'none';
                            if ($storeRAZ['n0']['out'] == $STORE_ID) {
                                $storeRAZ['n0']['samov'] = 'yes';
                            } else {
                                $storeRAZ['n0']['samov'] = 'no';
                            }
                            ;
                            $it["QUANTITY"] = 0;
                        }
                        ;
                    }
                    ;
                }
                ;
                $sm = false;
                if ($it["QUANTITY"] > 0) {
                    //Если не можем взять полное колличество позиций на одном складе разбиваем заказ (1. Проверяем наличие на выбранном складе самовывоза (любого колличества))
                    $i = 0;
                    $rsStore = CCatalogStoreProduct::GetList(array(), array(
                        'IBLOCK_ID' => '3',
                        'PRODUCT_ID' => $it["PRODUCT_ID"],
                        'STORE_ID' => $STORE_ID), false, false, array('AMOUNT', 'STORE_ID'))->GetNext();
                    if ($rsStore['AMOUNT'] >= 1 && isset($rsStore['AMOUNT']) && $rsStore['AMOUNT'] != false &&
                        $it["QUANTITY"] > 0) {
                        $it["QUANTITY"] = $it["QUANTITY"] - $rsStore['AMOUNT'];
                        $n = 'n' . $i++;
                        $storeRAZ[$n]['in'] = 8;
                        $storeRAZ[$n]['out'] = $STORE_ID;
                        $storeRAZ[$n]['col'] = (string )$rsStore['AMOUNT'];
                        $storeRAZ[$n]['yes_m'] = 'no';
                        $storeRAZ[$n]['yes_a'] = 'no';
                        $storeRAZ[$n]['stat'] = 'none';
                        if ($storeRAZ[$n]['out'] == $STORE_ID) {
                            $storeRAZ[$n]['samov'] = 'yes';
                        } else {
                            $storeRAZ[$n]['samov'] = 'no';
                        }
                        ;

                    }
                    ;
                }
                ;
                //В зависимости от полученных результатов ищем склады по наличию дальше
                if ($it["QUANTITY"] > 0) {
                    foreach ($priorSHOPID as $SHOPID) {
                        $rsStore = CCatalogStoreProduct::GetList(array(), array(
                            'IBLOCK_ID' => '3',
                            'PRODUCT_ID' => $it["PRODUCT_ID"],
                            'STORE_ID' => $SHOPID), false, false, array('AMOUNT', 'STORE_ID'))->GetNext();
                        if ($rsStore['AMOUNT'] > 0 && $rsStore['AMOUNT'] != null && $rsStore['AMOUNT'] != false &&
                            $rsStore['AMOUNT'] >= $it["QUANTITY"] && $it["QUANTITY"] > 0) {
                            //$itnew = $itnew-$rsStore['AMOUNT'];
                            $n = 'n' . $i++;
                            $storeRAZ[$n]['in'] = 8;
                            $storeRAZ[$n]['out'] = $SHOPID;
                            $storeRAZ[$n]['col'] = (string )$it["QUANTITY"];
                            $storeRAZ[$n]['yes_m'] = 'no';
                            $storeRAZ[$n]['yes_a'] = 'no';
                            $storeRAZ[$n]['stat'] = 'none';
                            if ($storeRAZ[$n]['out'] == $STORE_ID) {
                                $storeRAZ[$n]['samov'] = 'yes';
                            } else {
                                $storeRAZ[$n]['samov'] = 'no';
                            }
                            ;
                            $it["QUANTITY"] = 0;
                        } else
                            if ($rsStore['AMOUNT'] > 0 && $rsStore['AMOUNT'] < $it["QUANTITY"] && $it["QUANTITY"] >
                                0) {
                                $it["QUANTITY"] = (float)$it["QUANTITY"] - (float)$rsStore['AMOUNT'];
                                $n = 'n' . $i++;
                                $storeRAZ[$n]['in'] = 8;
                                $storeRAZ[$n]['out'] = $SHOPID;
                                $storeRAZ[$n]['col'] = (string )$rsStore['AMOUNT'];
                                $storeRAZ[$n]['yes_m'] = 'no';
                                $storeRAZ[$n]['yes_a'] = 'no';
                                $storeRAZ[$n]['stat'] = 'none';
                                if ($storeRAZ[$n]['out'] == $STORE_ID) {
                                    $storeRAZ[$n]['samov'] = 'yes';
                                } else {
                                    $storeRAZ[$n]['samov'] = 'no';
                                }
                                ;
                            }
                        ;
                    }
                    ;
                }
                ;
                //Если остались товары и система не может найти нужноее колличество - перебрасываем остаток на главный склад
                if ($it["QUANTITY"] > 0) {
                    $n = 'n' . $i++;
                    $storeRAZ[$n]['in'] = 8;
                    $storeRAZ[$n]['out'] = 8;
                    $storeRAZ[$n]['col'] = (string )$it["QUANTITY"];
                    $storeRAZ[$n]['yes_m'] = 'no';
                    $storeRAZ[$n]['yes_a'] = 'no';
                    $storeRAZ[$n]['stat'] = 'none';
                    if ($storeRAZ[$n]['out'] == $STORE_ID) {
                        $storeRAZ[$n]['samov'] = 'yes';
                    } else {
                        $storeRAZ[$n]['samov'] = 'no';
                    }
                    ;
                }
                ;
                $PROP = array();
                $PROP[92] = $order["ID"];
                $PROP[93] = $size['ID'];
                $PROP[89] = $it["PRODUCT_ID"];
                $PROP[101] = $storeRAZ;
                $PROP[99] = $STORE_ID;
                $PROP[95] = $offer['PROPERTY_C_CODE_VALUE'];
                $PROP[91] = $it["PRICE"];
                $PROP[96] = $offer["PROPERTY_ARTNUMBER_T_VALUE"];
                $PROP[107] = $order["ACCOUNT_NUMBER"];
                $el = new CIBlockElement;
                $PS = CIBlockElement::GetList(array(), array(
                    "IBLOCK_ID" => 19,
                    "PROPERTY_ORDER" => $orderId,
                    'NAME' => $it["NAME"],
                    'PROPERTY_SIZE' => $size['ID']), false, false, array("ID", "IBLOCK_ID"))->
                    GetNext(false, false);
                
                if (!$PS) {
                    CCatalogProduct::Update($it["PRODUCT_ID"], $arFieldsNEW);
                    $img = CFile::ResizeImageGet($rp["PREVIEW_PICTURE"], array("width" => 40,
                            "height" => 40), BX_RESIZE_IMAGE_EXACT, true);
                    $arFields = array(
                        "DATE_CREATE" => $order["DATE_INSERT"],
                        "IBLOCK_ID" => '19',
                        "NAME" => $it["NAME"],
                        "ACTIVE" => 'Y',
                        "PREVIEW_PICTURE" => CFile::MakeFileArray($img['src']),
                        "PROPERTY_VALUES" => $PROP,
                        );
                    if ( $IDs = $el->Add($arFields)) {
                        $ALL[] = $IDs;
                        foreach ($storeRAZ as $delcoll) {
                            $el = new CIBlockElement;
                            $rsStore = CCatalogStoreProduct::GetList(array(), array('PRODUCT_ID' => $offer['ID'],
                                    'STORE_ID' => $delcoll['out']), false, false, array('AMOUNT'))->Fetch();
                            $arFields = array(
                                "PRODUCT_ID" => $offer['ID'],
                                "STORE_ID" => $delcoll['out'],
                                "AMOUNT" => $rsStore['AMOUNT'] - $delcoll['col']);
                            $ID = CCatalogStoreProduct::UpdateFromForm($arFields);
                            $arLoadProductArrayEmpty = array();
                            $el->Update($offer['ID'], $arLoadProductArrayEmpty);
                        }
                        ;
                        $fp = fopen($_SERVER["DOCUMENT_ROOT"] . "/logistic/size.txt", "a+");
                        //Отправка позиций - баскетшоп
                        foreach ($storeRAZ as $onestore) {
                            for ($i = 1; $i <= (float)$onestore["col"]; $i++) {
                                $ah = CCatalogStore::GetList(array(), array('ID' => $onestore["out"]), false, false,
                                    array('NAME'))->GetNext();
                                $SHOP = $ah['XML_ID'];
                                $params = ['art' => urlencode($offer["PROPERTY_ARTNUMBER_T_VALUE"]), 'size' =>
                                    urlencode($size["NAME"]), 'shop_id' => urlencode($SHOP)];
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_AUTOREFERER, true);
                                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                curl_setopt($ch, CURLOPT_POST, 1);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                                curl_setopt($ch, CURLOPT_URL, 'https://www.basketshop.ru/administrator/size.php');
                                curl_setopt($ch, CURLOPT_REFERER,
                                    'https://www.basketshop.ru/administrator/size.php');
                                $response = curl_exec($ch);
                                curl_close($ch);
                                fwrite($fp, $response . "\r\n");
                            }
                            ;
                        }
                        ;
                        fclose($fp); //END
                    }
                    ;
                } else {
                    $ALL[] = $PS['ID'];
                }
                ;
            }
            ;
        }
        ;
    }
    ;





    if (!$OrderY['ID']) {
        $orderNumber = $orderId;
        CModule::IncludeModule("sale");
        CModule::IncludeModule('catalog');
        $prZ = \Bitrix\Sale\Order::load($orderNumber);
        $propertyCollectionZ = $prZ->getPropertyCollection(); //Собираем все поля
        //orderNumber - ID заказа
        $dom_xmlV = new DomDocument("1.0", "utf-8"); // Создаём корневой элемент
        $ordersV = $dom_xmlV->createElement("orders");
        $dom_xmlV->appendChild($ordersV);
        //Создаем элемент order
        $orderV = $dom_xmlV->createElement("order");
        $ordersV->appendChild($orderV);
        //Создаем элемент orderNumber
        $orderNumberV = $dom_xmlV->createElement("orderNumber", 's' . $orderNumber);
        $orderV->appendChild($orderNumberV); //FIO - имя клиента + телефон
        $NAME = $propertyCollectionZ->getPayerName();
        $NAME = $NAME->getfields();
        $NAME = $NAME["VALUE"];
        $PHONE = $propertyCollectionZ->getPhone();
        $PHONE = $PHONE->getfields();
        $PHONE = $PHONE["VALUE"]; //Создаем элемент FIO
        $fioV = $dom_xmlV->createElement("FIO", $NAME . " " . $PHONE);
        $orderV->appendChild($fioV);
        $CITY = $propertyCollectionZ->getDeliveryLocation();
        $CITY = $CITY->getfields();
        $CITY = Bitrix\Sale\Location\Admin\LocationHelper::getLocationPathDisplay($CITY["VALUE"]);
        $CITY = explode(',', $CITY); //Страна
        $COUNTRY = trim($CITY[1]); //Создаем элемент country
        $countryV = $dom_xmlV->createElement("country", $COUNTRY);
        $orderV->appendChild($countryV); //Создаем элемент region - пока пустой
        $regionV = $dom_xmlV->createElement("region", "");
        $orderV->appendChild($regionV);
        //Город
        $CITY = trim($CITY[0]); //Создаем элемент $CITY
        $cirtV = $dom_xmlV->createElement("city", $CITY);
        $orderV->appendChild($cirtV);
        $ADRESS = $propertyCollectionZ->getAddress();
        $ADRESS = $ADRESS->getfields();
        $ADRESS = $ADRESS["VALUE"]; //Создаем элемент adress
        $adressV = $dom_xmlV->createElement("adress", $ADRESS);
        $orderV->appendChild($adressV);
        //EMAIL
        $EMAIL = $propertyCollectionZ->getUserEmail();
        $EMAIL = $EMAIL->getfields();
        $EMAIL = $EMAIL["VALUE"]; //Создаем элемент email
        $emailV = $dom_xmlV->createElement("email", $EMAIL);
        $orderV->appendChild($emailV);
        //Создаем элемент tel
        $telV = $dom_xmlV->createElement("tel", $PHONE);
        $orderV->appendChild($telV);
        //Комментарий пользователя
        $COMMENT = $prZ->getfields();
        $COMMENT = $COMMENT["USER_DESCRIPTION"];
        //Создаем элемент comment - пока пустой
        $commentV = $dom_xmlV->createElement("comment", $COMMENT);
        $orderV->appendChild($commentV); //Дата создания и обновления
        $DATE = $prZ->getfields();
        $DATE_UPDATE = $DATE["DATE_UPDATE"]->toString();
        $DATE_CREATE = $DATE["DATE_INSERT"]->toString();
        //$DATE_CREATE = str_replace('.', '-', $DATE_CREATE);
        $DATE_CREATE = explode(' ', trim($DATE_CREATE));
        $DATE_CREATE_DATE = $DATE_CREATE[0];
        $DATE_CREATE_TIME = $DATE_CREATE[1];
        $DATE_CREATE_DATE = explode('.', $DATE_CREATE_DATE);
        $DATE_CREATE = $DATE_CREATE_DATE[2] . '-' . $DATE_CREATE_DATE[1] . '-' . $DATE_CREATE_DATE[0] .
            ' ' . $DATE_CREATE_TIME; //$DATE_UPDATE = str_replace('.', '-', $DATE_UPDATE);
        $DATE_UPDATE = explode(' ', trim($DATE_UPDATE));
        $DATE_UPDATE_DATE = $DATE_UPDATE[0];
        $DATE_UPDATE_TIME = $DATE_UPDATE[1];
        $DATE_UPDATE_DATE = explode('.', $DATE_UPDATE_DATE);
        $DATE_UPDATE = $DATE_UPDATE_DATE[2] . '-' . $DATE_UPDATE_DATE[1] . '-' . $DATE_UPDATE_DATE[0] .
            ' ' . $DATE_UPDATE_TIME; //Создаем элемент created
        $createdV = $dom_xmlV->createElement("created", $DATE_CREATE);
        $orderV->appendChild($createdV); //Предоплата
        //Создаем элемент prepayment - пока пустой
        $prepaymentV = $dom_xmlV->createElement("prepayment", "");
        $orderV->appendChild($prepaymentV); //Цена
        $PRICE = $prZ->getfields();
        $PRICE = $PRICE["PRICE"]; //Создаем элемент summ
        $summV = $dom_xmlV->createElement("summ", $PRICE);
        $orderV->appendChild($summV);
        //Способ доставки
        foreach ($prZ->getShipmentCollection() as $oneShip):
            if ($oneShip->isSystem())
                continue;
            $DELIVERY = $oneShip->getfields();
            $DELIVERY = $DELIVERY["DELIVERY_NAME"];
            //Создаем элемент delivery
            $deliveryV = $dom_xmlV->createElement("delivery", $DELIVERY);
            $orderV->appendChild($deliveryV); //Номер отправления
            $TRACKINGNUMBER = $oneShip->getfields();
            $TRACKINGNUMBER = $TRACKINGNUMBER["TRACKING_NUMBER"];
            //Создаем элемент pickupStore - пока пустой
            $trackingNumberV = $dom_xmlV->createElement("trackingNumber", $TRACKINGNUMBER);
            $orderV->appendChild($trackingNumberV);
            //Создаем элемент pickupStore - пока пустой
            $ah = CCatalogStore::GetList(array(), array('ID' => $oneShip->getstoreId()), false, false,
                array('NAME'))->GetNext();
            $pickupStoreV = $dom_xmlV->createElement("pickupStore", $ah["TITLE"]);
            $orderV->appendChild($pickupStoreV);
        endforeach;
        //Стоимость доставки
        $DELIVERYPRICE = $prZ->getfields();
        $DELIVERYPRICE = $DELIVERYPRICE["PRICE_DELIVERY"];
        //Создаем элемент deliveryCost
        $deliveryCostV = $dom_xmlV->createElement("deliveryCost", $DELIVERYPRICE);
        $orderV->appendChild($deliveryCostV); //Купоны
        $COUPON = $prZ->getDiscount();
        $COUPON = $COUPON->getApplyResult();
        foreach ($COUPON["COUPON_LIST"] as $onecoup) {
            $COUPONID = $onecoup["DATA"]["ID"]; //Создаем элемент deliveryCost
            $couponIdV = $dom_xmlV->createElement("couponId", $COUPONID);
            $orderV->appendChild($couponIdV);
        }
        ;
        $STAT_Z = $prZ->getfields();
        $STAT_Z = CSaleStatus::GetList(array(), array("ID" => $STAT_Z["STATUS_ID"]), false, false,
            array())->GetNext();
        //Создаем элемент status
        $statusV = $dom_xmlV->createElement("status", $STAT_Z["NAME"]);
        $orderV->appendChild($statusV); //Получаем список товаров заказа
        $rbZ = CSaleBasket::GetList(array("NAME" => "ASC", "ID" => "ASC"), array("ORDER_ID" =>
                $orderNumber), false, false, array(
            "ID",
            "ORDER_ID",
            "PRODUCT_ID",
            "NAME",
            "BASE_PRICE",
            "PRICE",
            "QUANTITY",
            "DISCOUNT_VALUE",
            "STORE_ID"));
        $i = 0;
        while ($itZ = $rbZ->GetNext()) {
            $id = $i + 1;
            $itemV = $dom_xmlV->createElement('item');
            $itemV->setAttribute("");
            $orderV->appendChild($itemV); //Получаем сам товару
            $offerZ = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 3, "ID" => $itZ["PRODUCT_ID"]), false, false,
                array(
                "ID",
                "IBLOCK_ID",
                "PROPERTY_SIZES_SHOES",
                "PROPERTY_CML2_LINK",
                "STORE_ID",
                "PROPERTY_C_CODE",
                "PROPERRTY_GENDER",
                "PROPERTY_ARTNUMBER_T",
                "NAME"))->GetNext();
            if ($offerZ) {
                //1с код
                $CODE_1C = $offerZ["PROPERTY_C_CODE_VALUE"]; //Создаем элемент code1c
                $code1cV = $dom_xmlV->createElement("code1c", $CODE_1C);
                $itemV->appendChild($code1cV);
                //Артикул
                $ARTICLE = $offerZ["PROPERTY_ARTNUMBER_T_VALUE"]; //Создаем элемент article
                $articleV = $dom_xmlV->createElement("article", $ARTICLE);
                $itemV->appendChild($articleV);
                $rpZ = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 2, "ID" => $offerZ["PROPERTY_CML2_LINK_VALUE"]), false, false,
                    array(
                    "ID",
                    "IBLOCK_ID",
                    "PREVIEW_PICTURE",
                    "PROPERTY_ARTNUMBER",
                    "PROPERRTY_GENDER",
                    "PROPERTY_C_CODE",
                    "PROPERTY_BRAND"))->GetNext();
                $sizeZ = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 17, "ID" => $offerZ["PROPERTY_SIZES_SHOES_VALUE"]), false, false,
                    array("NAME", "ID"))->GetNext();
                $BRAND = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 6, "ID" => $rpZ["PROPERTY_BRAND_VALUE"]), false, false,
                    array("NAME", "ID"))->GetNext(); //Бренд
                $BRANDNAME = $BRAND["NAME"]; //Создаем элемент brand
                $brandV = $dom_xmlV->createElement("brand", $BRANDNAME);
                $itemV->appendChild($brandV);
                $sizeZ = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 17, "ID" => $offerZ["PROPERTY_SIZES_SHOES_VALUE"]), false, false,
                    array("NAME", "ID"))->GetNext(); //Размер
                $SIZE = $sizeZ["NAME"]; //Создаем элемент size
                $sizeV = $dom_xmlV->createElement("size", $SIZE);
                $itemV->appendChild($sizeV);
            }
            ; //Базовая цена
            $BASE_PRICE = $itZ["BASE_PRICE"]; //Создаем элемент price
            $priceV = $dom_xmlV->createElement("price", $BASE_PRICE);
            $itemV->appendChild($priceV);
            //Создаем элемент discount_percent - пока пустой
            $discount_percentV = $dom_xmlV->createElement("discount_percent", "0");
            $itemV->appendChild($discount_percentV); //Величина скидки
            $DIC_SUMM = (float)$itZ["BASE_PRICE"] - (float)$itZ["PRICE"];
            //Создаем элемент discount_summ
            $discount_summV = $dom_xmlV->createElement("discount_summ", $DIC_SUMM);
            $itemV->appendChild($discount_summV); //Колличество определенной единицы
            $QU = $itZ["QUANTITY"]; //Создаем элемент quantity
            $quantityV = $dom_xmlV->createElement("quantity", $QU);
            $itemV->appendChild($quantityV);
            //дата обновления
            $DATE_UPDATE = $DATE_UPDATE; //Создаем элемент change_time
            $change_timeV = $dom_xmlV->createElement("change_time", $DATE_UPDATE);
            $itemV->appendChild($change_timeV);
            $dom_xmlV->preserveWhiteSpace = false;
            $dom_xmlV->formatOutput = true;
            //$pathV = $_SERVER["DOCUMENT_ROOT"] . '/logistic/order/snrk_' . date("Y-m-d H:i:s") .'.xml';

            $pathV = 'ftp://sneake01_ftp:6BjvOObrXT@ftp.sneake01.nichost.ru/fromHC/Orders/snrk_' .
                date("d-m-Y H:i:s") . '.xml';
            $dom_xmlV->save($pathV);
        }
        ;
    }
                    $ALLstoreOrders = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 19,
                        "PROPERTY_ORDER" => $orderId), false, false, array("ID", "IBLOCK_ID","PROPERTY_NAME_T"));
                while ($ALLstoreOrder = $ALLstoreOrders->GetNext()) {
                    if (!in_array($ALLstoreOrder['ID'], $ALL)) {
                        CIBlockElement::Delete($ALLstoreOrder['ID']);
                        };
                    
                };
;//*/
}
; //Событие при изменении заказа (создания XML)

function My_OnOrderSave2($orderId)
{

    ////////////


    CModule::IncludeModule("sale");
    CModule::IncludeModule('catalog');
    CModule::IncludeModule("grain.tables");
    $order_id = $orderId;
    $OrderY = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 19,
            "PROPERTY_ORDER" => $order_id), false, false, array("ID", "IBLOCK_ID"))->
        GetNext();
    $ro = CSaleOrder::GetList(array("ID" => "DESC"), array('ID' => $order_id), false, false,
        array(
        "ID",
        "DELIVERY_ID",
        "PAY_SYSTEM_ID",
        "DATE_INSERT",
        "STATUS_ID",
        "PRICE",
        "DISCOUNT_VALUE",
        "LOCK_STATUS",
        "COMMENTS",
        "ACCOUNT_NUMBER"));
    $pr = \Bitrix\Sale\Order::load($order_id);
    $basket = $pr->getBasket();
    $price = $basket->getPrice();
    $paymentCollection = $pr->getPaymentCollection();
    $paydSum = $paymentCollection->getPaidSum();
    $paymentSelected = $pr->getPaymentSystemId()['0'];
    if ($price != $paydSum && ($paymentSelected != 1 && $paymentSelected != 2)) {
        CSaleOrder::DeliverOrder($order_id, "N");
    }

    if ((($paymentSelected == 1 || $paymentSelected == 2) || ($price == $paydSum)) &&
        $pr->getField('ALLOW_DELIVERY') == 'N') { //->getPaymentSystemId()== 'N'){
        CSaleOrder::DeliverOrder($order_id, "Y");
    }


    $shipmentCollection = $pr->getShipmentCollection();
    foreach ($shipmentCollection as $shipment) {
        //Пропуск системных значений
        if ($shipment->isSystem())
            continue;
        //Получение ID магазина выбранного пользователем (доставка в заказе)
        $STORE_ID = $shipment->getStoreId(); //Получение товаров в доставке
        $COL = $shipment->getshipmentItemCollection(); //Получение статуса доставки
        $STATUS = $shipment->getcollection();
        foreach ($STATUS as $STAT) {
            //Пропуск системных значений
            if ($STAT->isSystem())
                continue;
            $STATs = $STAT->getfields();
            foreach ($COL as $item) {
                $i = $item->getfields();
                //Сравнение ID доставки полученной у товара и у заказа в общем
                if ($i["ORDER_DELIVERY_ID"] == $STATs["ID"]) {
                    $S = $STATs["STATUS_ID"];
                    $basketItem = $item->getBasketItem();
                    $items = $basketItem->getProductId(); //Получение ID склада (пользовательский)
                    $STORE_ITEM[$items][] = $STORE_ID; //Получение статуса текущей доставки
                    $STORE_ITEM[$items][] = $S;
                }
                ;
            }
            ;
        }
        ;
    }
    ;
    $rb = CSaleBasket::GetList(array("NAME" => "ASC", "ID" => "ASC"), array("ORDER_ID" =>
            $order_id), false, false, array(
        "ID",
        "ORDER_ID",
        "PRODUCT_ID",
        "NAME",
        "PRICE",
        "QUANTITY",
        "DISCOUNT_VALUE",
        "STORE_ID"));
    $item_in_order = array();
    while ($it = $rb->GetNext()) {
        $item_in_order[$it["PRODUCT_ID"]] = $it["QUANTITY"];
    }


    $PS = CIBlockElement::GetList(array(), array(
        "IBLOCK_ID" => 19,
        "PROPERTY_ORDER" => $order_id,
        ), false, false, array(
        "ID",
        "IBLOCK_ID",
        "NAME",
        "PROPERTY_C_CODE",
        "PROPERTY_101",
        "PROPERTY_89",
        "PROPERTY_93",
        "PROPERTY_95",
        "PROPERTY_91",
        "PROPERTY_96"));
    $item = array();
    $item_values = array();
    while ($positions = $PS->GetNext()) {
        $itemp[$positions["PROPERTY_89_VALUE"]]['q'] += $positions["PROPERTY_101_VALUE"]['col'];
        $item_values[$positions["PROPERTY_89_VALUE"]][] = $positions;
    }
    foreach ($item_in_order as $key => $val) {

        if ($item_in_order[$key] > $itemp[$key]['q']) {

            //приоритет складов
            $priorSHOPID = array();
            $ah = CCatalogStore::GetList(array('SORT' => 'ASC'), array('!ID' => $STORE_ID), false, false,
                array('NAME', 'ID'));
            while ($ahprior = $ah->GetNext()) {
                $priorSHOPID[] = $ahprior['ID'];
            }
            ;
            $quantity = $item_in_order[$key] - $itemp[$key]['q'];
            $qq = $i = 0;
            $sm = false;
            if ($qauntity > 0) {
                //Если не можем взять полное колличество позиций на одном складе разбиваем заказ (1. Проверяем наличие на выбранном складе самовывоза (любого колличества))
                $i = 0;
                $rsStore = CCatalogStoreProduct::GetList(array(), array(
                    'IBLOCK_ID' => '3',
                    'PRODUCT_ID' => $key,
                    'STORE_ID' => $STORE_ID), false, false, array('AMOUNT', 'STORE_ID'))->GetNext();
                if (isset($rsStore['AMOUNT']) && $rsStore['AMOUNT'] != false && $rsStore['AMOUNT'] >=
                    1) {
                    if ($quantity >= $rsStore['AMOUNT']) {
                        $quantity = $qauntity - $rsStore['AMOUNT'];
                        $qq = $rsStore['AMOUNT'];
                    } else {
                        $qq = $quantity;
                        $quantity = 0;
                    }
                    $n = 'n' . $i++;
                    $storeRAZ[$n]['in'] = 8;
                    $storeRAZ[$n]['out'] = $STORE_ID;
                    $storeRAZ[$n]['col'] = (string )$qq;
                    $storeRAZ[$n]['yes_m'] = 'no';
                    $storeRAZ[$n]['yes_a'] = 'no';
                    $storeRAZ[$n]['stat'] = 'none';
                    if ($storeRAZ[$n]['out'] == $STORE_ID) {
                        $storeRAZ[$n]['samov'] = 'yes';
                    } else {
                        $storeRAZ[$n]['samov'] = 'no';
                    }
                    ;
                }
                ;
            }
            ; //В зависимости от полученных результатов ищем склады по наличию дальше
            if ($quantity > 0) {
                foreach ($priorSHOPID as $SHOPID) {
                    $rsStore = CCatalogStoreProduct::GetList(array(), array(
                        'IBLOCK_ID' => '3',
                        'PRODUCT_ID' => $key,
                        'STORE_ID' => $SHOPID), false, false, array('AMOUNT', 'STORE_ID'))->GetNext();
                    if ($rsStore['AMOUNT'] != false && $rsStore['AMOUNT'] > 0 && $rsStore['AMOUNT'] != null &&
                        $quantity > 0) {

                        if ($quantity >= $rsStore['AMOUNT']) {
                            $quantity = $qauntity - $rsStore['AMOUNT'];
                            $qq = $rsStore['AMOUNT'];
                        } else {
                            $qq = $quantity;
                            $quantity = 0;
                        }
                        $n = 'n' . $i++;
                        $storeRAZ[$n]['in'] = 8;
                        $storeRAZ[$n]['out'] = $SHOPID;
                        $storeRAZ[$n]['col'] = (string )$qq;
                        $storeRAZ[$n]['yes_m'] = 'no';
                        $storeRAZ[$n]['yes_a'] = 'no';
                        $storeRAZ[$n]['stat'] = 'none';
                        if ($storeRAZ[$n]['out'] == $STORE_ID) {
                            $storeRAZ[$n]['samov'] = 'yes';
                        } else {
                            $storeRAZ[$n]['samov'] = 'no';
                        }
                        ;
                    }
                }
                ;
            }
            ; //Если остались товары и система не может найти нужноее колличество - перебрасываем остаток на главный склад
            if ($quantity > 0) {
                $n = 'n' . $i++;
                $storeRAZ[$n]['in'] = 8;
                $storeRAZ[$n]['out'] = 8;
                $storeRAZ[$n]['col'] = (string )$quantity;
                $storeRAZ[$n]['yes_m'] = 'no';
                $storeRAZ[$n]['yes_a'] = 'no';
                $storeRAZ[$n]['stat'] = 'none';
                if ($storeRAZ[$n]['out'] == $STORE_ID) {
                    $storeRAZ[$n]['samov'] = 'yes';
                } else {
                    $storeRAZ[$n]['samov'] = 'no';
                }
                ;
            }
            ; ////

            $PROP = array();
            $PROP[92] = $order_id;
            $PROP[93] = $item_values[$key][0]["PROPERTY_93_VALUE"];
            $PROP[89] = $key;
            $PROP[101] = $storeRAZ;
            $PROP[99] = $STORE_ID;
            $PROP[95] = $item_values[$key][0]['PROPERTY_95_VALUE'];
            $PROP[91] = $item_values[$key][0]["PROPERTY_91_VALUE"];
            $PROP[96] = $item_values[$key][0]["PROPERTY_96_VALUE"];
            $PROP[107] = $order_id;
            $el = new CIBlockElement;
            //CCatalogProduct::Update($it["PRODUCT_ID"], $arFieldsNEW);
            $offer = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 3, "ID" => $key), false, false,
                array(
                "ID",
                "IBLOCK_ID",
                "PROPERTY_SIZES_SHOES",
                "PROPERTY_CML2_LINK",
                "STORE_ID",
                "PROPERTY_C_CODE",
                "PROPERTY_ARTNUMBER_T",
                "CATALOG_QUANTITY"))->GetNext();
            $size = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 17, "ID" => $offer["PROPERTY_SIZES_SHOES_VALUE"]), false, false,
                array("NAME", "ID"))->GetNext(); //получаем свойства товара
            $rp = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 2, "ID" => $offer["PROPERTY_CML2_LINK_VALUE"]), false, false,
                array(
                "ID",
                "IBLOCK_ID",
                "PREVIEW_PICTURE",
                "PROPERTY_ARTNUMBER"))->GetNext();
            $img = CFile::ResizeImageGet($rp["PREVIEW_PICTURE"], array("width" => 40,
                    "height" => 40), BX_RESIZE_IMAGE_EXACT, true);
            $arFields = array(
                "DATE_CREATE" => date("Y-m-d"),
                "IBLOCK_ID" => '19',
                "NAME" => $item_values[$key][0]["NAME"],
                "ACTIVE" => 'Y',
                "PREVIEW_PICTURE" => CFile::MakeFileArray($img['src']),
                "PROPERTY_VALUES" => $PROP,
                );
            if ($el->Add($arFields)) {

                foreach ($storeRAZ as $delcoll) {
                    $el = new CIBlockElement;
                    $rsStore = CCatalogStoreProduct::GetList(array(), array('PRODUCT_ID' => $offer['ID'],
                            'STORE_ID' => $delcoll['out']), false, false, array('AMOUNT'))->Fetch();
                    $arFields = array(
                        "PRODUCT_ID" => $offer['ID'],
                        "STORE_ID" => $delcoll['out'],
                        "AMOUNT" => $rsStore['AMOUNT'] - $delcoll['col']);
                    $ID = CCatalogStoreProduct::UpdateFromForm($arFields); //$arLoadProductArrayEmpty = array();
                    //                            $el->Update($offer['ID'], $arLoadProductArrayEmpty);
                }
                ;
                $fp = fopen($_SERVER["DOCUMENT_ROOT"] . "/logistic/size.txt", "a+");
                //Отправка позиций - баскетшоп
                foreach ($storeRAZ as $onestore) {
                    for ($i = 1; $i <= (float)$onestore["col"]; $i++) {
                        $ah = CCatalogStore::GetList(array(), array('ID' => $onestore["out"]), false, false,
                            array('NAME'))->GetNext();
                        $SHOP = $ah['XML_ID'];
                        $params = ['art' => urlencode($offer["PROPERTY_ARTNUMBER_T_VALUE"]), 'size' =>
                            urlencode($size["NAME"]), 'shop_id' => urlencode($SHOP)];
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                        curl_setopt($ch, CURLOPT_URL, 'https://www.basketshop.ru/administrator/size.php');
                        curl_setopt($ch, CURLOPT_REFERER,
                            'https://www.basketshop.ru/administrator/size.php');
                        $response = curl_exec($ch);
                        curl_close($ch);
                        fwrite($fp, $response . "\r\n");
                    }
                    ;
                }
                ;
                fclose($fp); //END/

            }
            ; ////
        }
	}//*/
	
$status = $pr->getField("STATUS_ID");

	if($status == 'N' || $status ==    'NS' || $status ==  'NZ' || $status ==  'ZO'  || $status == 'VR' || $status ==  'SZ'  || $status == 'OT'){
        ////////////
        $orderNumber = $orderId;
        CModule::IncludeModule("sale");
        CModule::IncludeModule('catalog');
        $prZ = \Bitrix\Sale\Order::load($orderNumber);
        $propertyCollectionZ = $prZ->getPropertyCollection(); //Собираем все поля
        //orderNumber - ID заказа
        $dom_xmlV = new DomDocument("1.0", "utf-8"); // Создаём корневой элемент
        $ordersV = $dom_xmlV->createElement("orders");
        $dom_xmlV->appendChild($ordersV);
        //Создаем элемент order
        $orderV = $dom_xmlV->createElement("order");
        $ordersV->appendChild($orderV);
        //Создаем элемент orderNumber
        $orderNumberV = $dom_xmlV->createElement("orderNumber", 's' . $orderNumber);
        $orderV->appendChild($orderNumberV); //FIO - имя клиента + телефон
        $NAME = $propertyCollectionZ->getPayerName();
        $NAME = $NAME->getfields();
        $NAME = $NAME["VALUE"];
        $PHONE = $propertyCollectionZ->getPhone();
        $PHONE = $PHONE->getfields();
        $PHONE = $PHONE["VALUE"]; //Создаем элемент FIO
        $fioV = $dom_xmlV->createElement("FIO", $NAME . " " . $PHONE);
        $orderV->appendChild($fioV);
        $CITY = $propertyCollectionZ->getDeliveryLocation();
        $CITY = $CITY->getfields();
        $CITY = Bitrix\Sale\Location\Admin\LocationHelper::getLocationPathDisplay($CITY["VALUE"]);
        $CITY = explode(',', $CITY); //Страна
        $COUNTRY = trim($CITY[1]); //Создаем элемент country
        $countryV = $dom_xmlV->createElement("country", $COUNTRY);
        $orderV->appendChild($countryV); //Создаем элемент region - пока пустой
        $regionV = $dom_xmlV->createElement("region", "");
        $orderV->appendChild($regionV);
        //Город
        $CITY = trim($CITY[0]); //Создаем элемент $CITY
        $cirtV = $dom_xmlV->createElement("city", $CITY);
        $orderV->appendChild($cirtV);
        $ADRESS = $propertyCollectionZ->getAddress();
        $ADRESS = $ADRESS->getfields();
        $ADRESS = $ADRESS["VALUE"]; //Создаем элемент adress
        $adressV = $dom_xmlV->createElement("adress", $ADRESS);
        $orderV->appendChild($adressV);
        //EMAIL
        $EMAIL = $propertyCollectionZ->getUserEmail();
        $EMAIL = $EMAIL->getfields();
        $EMAIL = $EMAIL["VALUE"]; //Создаем элемент email
        $emailV = $dom_xmlV->createElement("email", $EMAIL);
        $orderV->appendChild($emailV);
        //Создаем элемент tel
        $telV = $dom_xmlV->createElement("tel", $PHONE);
        $orderV->appendChild($telV);
        //Комментарий пользователя
        $COMMENT = $prZ->getfields();
        $COMMENT = $COMMENT["USER_DESCRIPTION"];
        //Создаем элемент comment - пока пустой
        $commentV = $dom_xmlV->createElement("comment", $COMMENT);
        $orderV->appendChild($commentV); //Дата создания и обновления
        $DATE = $prZ->getfields();
        $DATE_UPDATE = $DATE["DATE_UPDATE"]->toString();
        $DATE_CREATE = $DATE["DATE_INSERT"]->toString();
        //$DATE_CREATE = str_replace('.', '-', $DATE_CREATE);
        $DATE_CREATE = explode(' ', trim($DATE_CREATE));
        $DATE_CREATE_DATE = $DATE_CREATE[0];
        $DATE_CREATE_TIME = $DATE_CREATE[1];
        $DATE_CREATE_DATE = explode('.', $DATE_CREATE_DATE);
        $DATE_CREATE = $DATE_CREATE_DATE[2] . '-' . $DATE_CREATE_DATE[1] . '-' . $DATE_CREATE_DATE[0] .
            ' ' . $DATE_CREATE_TIME; //$DATE_UPDATE = str_replace('.', '-', $DATE_UPDATE);
        $DATE_UPDATE = explode(' ', trim($DATE_UPDATE));
        $DATE_UPDATE_DATE = $DATE_UPDATE[0];
        $DATE_UPDATE_TIME = $DATE_UPDATE[1];
        $DATE_UPDATE_DATE = explode('.', $DATE_UPDATE_DATE);
        $DATE_UPDATE = $DATE_UPDATE_DATE[2] . '-' . $DATE_UPDATE_DATE[1] . '-' . $DATE_UPDATE_DATE[0] .
            ' ' . $DATE_UPDATE_TIME; //Создаем элемент created
        $createdV = $dom_xmlV->createElement("created", $DATE_CREATE);
        $orderV->appendChild($createdV); //Предоплата
        //Создаем элемент prepayment - пока пустой
        $prepaymentV = $dom_xmlV->createElement("prepayment", "");
        $orderV->appendChild($prepaymentV); //Цена
        $PRICE = $prZ->getfields();
        $PRICE = $PRICE["PRICE"]; //Создаем элемент summ
        $summV = $dom_xmlV->createElement("summ", $PRICE);
        $orderV->appendChild($summV);
        //Способ доставки
        foreach ($prZ->getShipmentCollection() as $oneShip):
            if ($oneShip->isSystem())
                continue;
            $DELIVERY = $oneShip->getfields();
            $DELIVERY = $DELIVERY["DELIVERY_NAME"];
            //Создаем элемент delivery
            $deliveryV = $dom_xmlV->createElement("delivery", $DELIVERY);
            $orderV->appendChild($deliveryV); //Номер отправления
            $TRACKINGNUMBER = $oneShip->getfields();
            $TRACKINGNUMBER = $TRACKINGNUMBER["TRACKING_NUMBER"];
            //Создаем элемент pickupStore - пока пустой
            $trackingNumberV = $dom_xmlV->createElement("trackingNumber", $TRACKINGNUMBER);
            $orderV->appendChild($trackingNumberV);
            //Создаем элемент pickupStore - пока пустой
            $ah = CCatalogStore::GetList(array(), array('ID' => $oneShip->getstoreId()), false, false,
                array('NAME'))->GetNext();
            $pickupStoreV = $dom_xmlV->createElement("pickupStore", $ah["TITLE"]);
            $orderV->appendChild($pickupStoreV);
        endforeach;
        //Стоимость доставки
        $DELIVERYPRICE = $prZ->getfields();
        $DELIVERYPRICE = $DELIVERYPRICE["PRICE_DELIVERY"];
        //Создаем элемент deliveryCost
        $deliveryCostV = $dom_xmlV->createElement("deliveryCost", $DELIVERYPRICE);
        $orderV->appendChild($deliveryCostV); //Купоны
        $COUPON = $prZ->getDiscount();
        $COUPON = $COUPON->getApplyResult();
        foreach ($COUPON["COUPON_LIST"] as $onecoup) {
            $COUPONID = $onecoup["DATA"]["ID"]; //Создаем элемент deliveryCost
            $couponIdV = $dom_xmlV->createElement("couponId", $COUPONID);
            $orderV->appendChild($couponIdV);
        }
        ;
        $STAT_Z = $prZ->getfields();
        $STAT_Z = CSaleStatus::GetList(array(), array("ID" => $STAT_Z["STATUS_ID"]), false, false,
            array())->GetNext();
        //Создаем элемент status
        $statusV = $dom_xmlV->createElement("status", $STAT_Z["NAME"]);
        $orderV->appendChild($statusV); //Получаем список товаров заказа
        $rbZ = CSaleBasket::GetList(array("NAME" => "ASC", "ID" => "ASC"), array("ORDER_ID" =>
                $orderNumber), false, false, array(
            "ID",
            "ORDER_ID",
            "PRODUCT_ID",
            "NAME",
            "BASE_PRICE",
            "PRICE",
            "QUANTITY",
            "DISCOUNT_VALUE",
            "STORE_ID"));
        $i = 0;
        while ($itZ = $rbZ->GetNext()) {
            $id = $i + 1;
            $itemV = $dom_xmlV->createElement('item');
            $itemV->setAttribute("");
            $orderV->appendChild($itemV); //Получаем сам товару
            $offerZ = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 3, "ID" => $itZ["PRODUCT_ID"]), false, false,
                array(
                "ID",
                "IBLOCK_ID",
                "PROPERTY_SIZES_SHOES",
                "PROPERTY_CML2_LINK",
                "STORE_ID",
                "PROPERTY_C_CODE",
                "PROPERRTY_GENDER",
                "PROPERTY_ARTNUMBER_T",
                "NAME"))->GetNext();
            if ($offerZ) {
                //1с код
                $CODE_1C = $offerZ["PROPERTY_C_CODE_VALUE"]; //Создаем элемент code1c
                $code1cV = $dom_xmlV->createElement("code1c", $CODE_1C);
                $itemV->appendChild($code1cV);
                //Артикул
                $ARTICLE = $offerZ["PROPERTY_ARTNUMBER_T_VALUE"]; //Создаем элемент article
                $articleV = $dom_xmlV->createElement("article", $ARTICLE);
                $itemV->appendChild($articleV);
                $rpZ = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 2, "ID" => $offerZ["PROPERTY_CML2_LINK_VALUE"]), false, false,
                    array(
                    "ID",
                    "IBLOCK_ID",
                    "PREVIEW_PICTURE",
                    "PROPERTY_ARTNUMBER",
                    "PROPERRTY_GENDER",
                    "PROPERTY_C_CODE",
                    "PROPERTY_BRAND"))->GetNext();
                $sizeZ = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 17, "ID" => $offerZ["PROPERTY_SIZES_SHOES_VALUE"]), false, false,
                    array("NAME", "ID"))->GetNext();
                $BRAND = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 6, "ID" => $rpZ["PROPERTY_BRAND_VALUE"]), false, false,
                    array("NAME", "ID"))->GetNext(); //Бренд
                $BRANDNAME = $BRAND["NAME"]; //Создаем элемент brand
                $brandV = $dom_xmlV->createElement("brand", $BRANDNAME);
                $itemV->appendChild($brandV);
                $sizeZ = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 17, "ID" => $offerZ["PROPERTY_SIZES_SHOES_VALUE"]), false, false,
                    array("NAME", "ID"))->GetNext(); //Размер
                $SIZE = $sizeZ["NAME"]; //Создаем элемент size
                $sizeV = $dom_xmlV->createElement("size", $SIZE);
                $itemV->appendChild($sizeV);
            }
            ; //Базовая цена
            $BASE_PRICE = $itZ["BASE_PRICE"]; //Создаем элемент price
            $priceV = $dom_xmlV->createElement("price", $BASE_PRICE);
            $itemV->appendChild($priceV);
            //Создаем элемент discount_percent - пока пустой
            $discount_percentV = $dom_xmlV->createElement("discount_percent", "0");
            $itemV->appendChild($discount_percentV); //Величина скидки
            $DIC_SUMM = (float)$itZ["BASE_PRICE"] - (float)$itZ["PRICE"];
            //Создаем элемент discount_summ
            $discount_summV = $dom_xmlV->createElement("discount_summ", $DIC_SUMM);
            $itemV->appendChild($discount_summV); //Колличество определенной единицы
            $QU = $itZ["QUANTITY"]; //Создаем элемент quantity
            $quantityV = $dom_xmlV->createElement("quantity", $QU);
            $itemV->appendChild($quantityV);
            //дата обновления
            $DATE_UPDATE = $DATE_UPDATE; //Создаем элемент change_time
            $change_timeV = $dom_xmlV->createElement("change_time", $DATE_UPDATE);
            $itemV->appendChild($change_timeV);
            $dom_xmlV->preserveWhiteSpace = false;
            $dom_xmlV->formatOutput = true;
            //$pathV = $_SERVER["DOCUMENT_ROOT"] . '/logistic/order/snrk_' . date("Y-m-d H:i:s") .'.xml';
            $pathV = 'ftp://sneake01_ftp:6BjvOObrXT@ftp.sneake01.nichost.ru/fromHC/Orders/snrk_' .
                date("d-m-Y H:i:s") . '.xml';
            $dom_xmlV->save($pathV);
        }
        ;
}//*/
			// }
			// ;
}
;
AddEventHandler("main", "OnBeforeProlog", "isMobile");
function isMobile()
{
    global $APPLICATION;
    CModule::IncludeModule('nurgush.mobiledetect');
    $detect = new Nurgush\MobileDetect\Main();
    if ($detect->isMobile()) {

        return true;
    } else {

        return false;
    }

}
function pr($result)
{
    global $USER;
    if ($USER->IsAdmin()):
        echo '<pre>';
        print_r($result);
        echo '</pre>';
    endif;
}
/*
AddEventHandler("sale", "OnBasketAdd", "AddPresentToBasket");
AddEventHandler("sale", "OnBasketUpdate", "AddPresentToBasket");
*/
function AddPresentToBasket($ID, $arFields)
{

    /*if (!*/
    CModule::IncludeModule("iblock");
     /*) {
    die("error include iblock module");
    }*/
     /*if (!*/
    CModule::IncludeModule("sale");
     /*) {
    die("error include sale module");
    }*/
     /*if (!*/
    CModule::IncludeModule("catalog");
     /*) {
    die(" cant use catalog module");
    }*/
    $sku = CCatalogSku::GetProductInfo($arFields['PRODUCT_ID']);
    $product = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 2, 'ID' => $sku['ID']), false, false,
        array(
        'IBLOCK_ID',
        'ID',
        'IBLOCK_SECTION_ID',
        'NAME',
        'PROPERTY_BRAND',
        'PROPERTY_SALE',
        'PROPERTY_SPECIAL_PRICE',
        'PROPERTY_SPECIAL_DATE'))->GetNext();
    if ($product['PROPERTY_SPECIAL_PRICE_VALUE'] > 0) {

        $basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(), \Bitrix\Main\Context::
            getCurrent()->getSite());
        $basketItems = $basket->getBasketItems();
        if ($item = $basket->getItemById($ID)) {


            $item->setFields(['PRICE' => $product['PROPERTY_SPECIAL_PRICE_VALUE'],
                'CUSTOM_PRICE' => 'Y']); //Получим товары корзины

            // Сохранение изменения
            $item->save(); // Или сохранение изменения корзины
            $basket->save();
        }
    }


    // echo $sp;

    //var_dump($arFields);

    //exit;
}


//Обновление индексов при изменении товара
//AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("updateIndex", "OnAfterIBlockElementUpdateHandler"));
/*
class updateIndex
{
function OnAfterIBlockElementUpdateHandler(&$arFields)
{
if ($arFields['IBLOCK_ID']==2){
\Bitrix\Iblock\PropertyIndex\Manager::updateElementIndex($arFields['IBLOCK_ID'], $arFields["ID"]);
};
}
}
*/
/*
function Reindex_Search()// переиндексация поиска

{

if(CModule::IncludeModule("search"))

{

$Result= false;

$Result = CSearch::ReIndexAll(true, 60);

while(is_array($Result))

{

$Result = CSearch::ReIndexAll(true, 60, $Result);

}

}

return "Reindex_Search();";

}
*/

?>