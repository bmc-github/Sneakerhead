<?php

use \Bitrix\Main\Loader,
    \Bitrix\Main\Application,
    \Bitrix\Iblock\ElementTable,
    \Bitrix\Main\Diag\Debug,
    \Bitrix\Sale,
    \Bitrix\Main\Context;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if (!Loader::includeModule('iblock') || !Loader::includeModule('sale') || !Loader::includeModule('catalog')) {
    ShowError('Error');
    return;
}

class ImportOrder
{
    const IBLOCK_ID = 20;

    private $DB;
    private $BASE_PRICE;
    private $obElement;
    private $lastOrderId;
    private $isDiscount = false;
    private $isChanged = false;

    public function __construct()
    {
        $this->DB = Application::getConnection('shbase_test');
        $this->obElement = new \CIBlockElement();
        $this->BASE_PRICE = \CCatalogGroup::GetBaseGroup();
        $this->DB->Query("SET NAMES 'utf8'");
        $this->DB->Query('SET collation_connection = "utf8_unicode_ci"');
        $this->lastOrderId = \Bitrix\Main\Config\Option::get("import_order", "last_order_id", 92134);
    }

    private function getOrders()
    {
        $sql = "SELECT * FROM oc_order WHERE order_id < " . $this->lastOrderId . " ORDER BY order_id DESC LIMIT 200";
        //$sql = "SELECT * FROM oc_order WHERE order_id = 91998 ORDER BY order_id DESC LIMIT 100";
        $rows = $this->DB->query($sql)->fetchAll();
        return $rows;
    }

    private function getOrderProducts($orderId)
    {
        $sql = "SELECT o.*, p.image, op.`value` op_size
                FROM oc_order_product o 
                LEFT JOIN oc_product p ON o.product_id=p.product_id
                LEFT JOIN oc_order_option `op` ON (o.order_product_id=op.order_product_id and `op`.`name` = 'Размер')
                WHERE o.order_id = " . $orderId . ";";
        $rows = $this->DB->query($sql, false)->fetchAll();
        foreach ($rows as &$row) {
            if ($row["op_size"]) {
                $size = trim($row["op_size"]);
                $size = explode(' ', $size);
                $size = trim($size[0]);
                $size = strip_tags($size);
                $size = trim($size);
                $row["size"] = $size;
            }
        }
        return $rows;
    }

    private function getElement($arFields)
    {
        $rsElement = \CIBlockElement::GetList(
            array(),
            array(
                'IBLOCK_ID' => self::IBLOCK_ID,
                'NAME' => $arFields['name'],
                'PROPERTY_SIZE' => $arFields['size'],
                'PROPERTY_ARTNUMBER' => $arFields['model'],
            ),
            false,
            false,
            array("ID")
        );
        if ($obElement = $rsElement->GetNextElement()) {
            $arElement = $obElement->GetFields();
            return $arElement;
        }
        return false;
    }


    private function addProduct($arFields)
    {
        $arElement = $this->getElement($arFields);
        if ($arElement) {
            return $arElement['ID'];
        } else {
            $arLoadProductArray = array(
                "IBLOCK_ID" => self::IBLOCK_ID,
                "IBLOCK_SECTION_ID" => false,
                "ACTIVE" => 'Y',
                "NAME" => $arFields['name'],
                "PROPERTY_VALUES" => array(
                    "SIZE" => $arFields['size'],
                    "ARTNUMBER" => $arFields['model']
                )
            );
            if ($arFields['image']) {
                $url = "https://sneakerhead.ru/image/" . $arFields['image'];
                $path = $_SERVER['DOCUMENT_ROOT'] . '/upload/tmp/' . basename($arFields['image']);
                file_put_contents($path, file_get_contents($url));
                $arLoadProductArray["PREVIEW_PICTURE"] = \CFile::MakeFileArray($path);
            }
            if ($productId = $this->obElement->Add($arLoadProductArray)) {
                $arLoadProductArray = array(
                    "ID" => $productId,
                    'PURCHASING_PRICE' => 0,
                    'PURCHASING_CURRENCY' => 'RUB',
                    'MEASURE' => 5,
                    'WEIGHT' => 0,
                    'QUANTITY' => 100,
                    "HEIGHT" => 0,
                    "WIDTH" => 0,
                    "LENGTH" => 0,
                );
                $catalog_product = \CCatalogProduct::GetByID($productId);
                if (!$catalog_product) {
                    \CCatalogProduct::Add($arLoadProductArray);
                } else {
                    \CCatalogProduct::Update($productId, $arLoadProductArray);
                }
                $arLoadProductArray = Array(
                    "PRODUCT_ID" => $productId,
                    "CATALOG_GROUP_ID" => $this->BASE_PRICE['ID'],
                    "PRICE" => doubleval($arFields['price']),
                    "CURRENCY" => "RUB",
                );
                $res = \CPrice::GetList(
                    array(),
                    array(
                        "PRODUCT_ID" => $productId,
                        "CATALOG_GROUP_ID" => $this->BASE_PRICE['ID']
                    )
                );
                if ($arr = $res->Fetch()) {
                    \CPrice::Update($arr["ID"], $arLoadProductArray);
                } else {
                    \CPrice::Add($arLoadProductArray);
                }
                return $productId;
            }
        }
    }

    public function importProducts()
    {
        $connection = \Bitrix\Main\Application::getConnection();
        $result = array();
        $siteId = Context::getCurrent()->getSite();
        $arOrders = $this->getOrders();
        if (!$arOrders) return array('end' => true);
        foreach ($arOrders as $order) {
            $bxOrder = Sale\Order::load($order['order_id']);
            if ($bxOrder) {
                $this->isDiscount = false;
                $arProducts = $this->getOrderProducts($order['order_id']);
                foreach ($arProducts as $product) {
                    if ($product['discount']) {
                        $this->isDiscount = true;
                    }
                }

                if ($this->isDiscount) {
                    $basket = $bxOrder->getBasket();
                    $basketItems = $basket->getBasketItems();
                    foreach ($basketItems as $basketItem) {
                        $basketItem->delete();
                    }
                    $basket->save();
                    foreach ($arProducts as $product) {
                        $productId = $this->addProduct($product);
                        if ($productId) {
                            $item = $basket->createItem('catalog', $productId);
                            $arFields = array(
                                'NAME' => $product['name'],
                                'QUANTITY' => $product['quantity'],
                                'CURRENCY' => "RUB",
                                'LID' => $siteId,
                                'PRODUCT_PROVIDER_CLASS' => '\CCatalogProductProvider',
                            );
                            $discount = 0;
                            if ($product['discount']) {
                                $discount = $product['price'] - $product['total'] / $product['quantity'];
                            }
                            if ($discount > 0) {
                                $arFields['DISCOUNT_PRICE'] = $discount;
                            }
                            $item->setFields($arFields);
                            $item->save();
                            $properties = array(
                                'SIZE' => array(
                                    'NAME' => 'Размер',
                                    'CODE' => 'SIZE',
                                    'VALUE' => $product['size'],
                                    'SORT' => 100
                                )
                            );
                            $basketPropertyCollection = $item->getPropertyCollection();
                            $basketPropertyCollection->setProperty($properties);
                            $basketPropertyCollection->save();
                        }
                    }

                    try {
                        $basket->save();
                        $bxOrder->doFinalAction(true);
                        $bxOrder->save();
                        $connection->queryExecute("UPDATE b_sale_order SET PRICE=" . ($bxOrder->getBasket()->getPrice() + $bxOrder->getShipmentCollection()->getPriceDelivery()) . " WHERE ID=" . $order['order_id']);
                    } catch (Exception $e) {
                        \Bitrix\Main\Diag\Debug::writeToFile(array('orderId' => $bxOrder->getId(), 'error' => $e->getMessage()), "", "/upload/error_order.log");
                    }
                    $result[] = array('orderId' => $bxOrder->getId(), 'products' => $arProducts);
                }
                $this->lastOrderId = $bxOrder->getId();
            }
            \Bitrix\Main\Config\Option::set("import_order", "last_order_id", $order['order_id']);
        }

        return $result;
    }

    public static function agentImportOrder()
    {
        $obImport = new self();
        $obImport->importProducts();
    }
}