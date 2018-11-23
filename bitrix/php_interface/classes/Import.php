<?php

use \Bitrix\Main\Loader,
    \Bitrix\Main\Application,
    \Bitrix\Iblock\ElementTable,
    \Bitrix\Main\Diag\Debug;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if (!Loader::includeModule('iblock') || !Loader::includeModule('sale') || !Loader::includeModule('catalog')) {
    ShowError('Error');
    return;
}

class Import
{
    const IBLOCK_ID = 2;
    const SKU_PROP_IBLOCK_ID = 17;
    const LOG = true;

    private static $ELEMENTS = array();
    private $LOG_FILE;
    private $DB;
    private $SKU;
    private $SIZE;
    private $SIZE_REV;
    private $STORE;
    private $BASE_PRICE;
    private $obElement;

    public function __construct()
    {
        $this->DB = Application::getConnection('import');
        $this->LOG_FILE = time() . ".log";
        $this->clearLog();
        $this->SKU = \CCatalogSKU::GetInfoByProductIBlock(self::IBLOCK_ID);
        $size = self::getSize();
        $this->SIZE = $size['IDS'];
        $this->SIZE_REV = $size['NAMES'];
        $this->STORE = self::getStore();
        $this->obElement = new \CIBlockElement();
        $this->BASE_PRICE = \CCatalogGroup::GetBaseGroup();
		//$this->BDB = Application::getConnection();
    }

    public function clearLog()
    {
        if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/upload/import/')) {
            foreach (glob($_SERVER["DOCUMENT_ROOT"] . '/upload/import/*') as $file) {
                unlink($file);
            }
        }
    }

    public function getRemnants()
    {
        $sql = "SELECT * FROM catalog_1c_codes WHERE `q` > 0";
        $rows = $this->DB->query($sql)->fetchAll();
        $arData = array();
        foreach ($rows as $row) {
            $arData[$row['art']][$row['size']][$row['shop']] = array("q" => $row['q'], "code" => $row['code']);
        }
        return $arData;
    }

    public function getElements()
    {
        $rows = IblockElementPropertyTable::getList(array(
            "select" => array("ID", "ELEMENT_ID" => "IBLOCK_ELEMENT_ID", "ARTNUMBER" => "VALUE"),
            "filter" => array(
                "!VALUE" => false,
                "=ELEMENT.IBLOCK_ID" => self::IBLOCK_ID,
                "PROPERTY.CODE" => "ARTNUMBER"
            ),
        ))->fetchAll();
        return $rows;
    }

    public function getOffers()
    {
        $rows = IblockElementPropertyTable::getList(array(
            "select" => array(
                "PROPERTY_CODE" => "PROPERTY.CODE",
                "ELEMENT_ID" => "IBLOCK_ELEMENT_ID",
                "VALUE" => "VALUE",
            ),
            "filter" => array(
                "=ELEMENT.IBLOCK_ID" => $this->SKU['IBLOCK_ID'],
                0 => array(
                    'LOGIC' => 'OR',
                    array("=PROPERTY.CODE" => "CML2_LINK"),
                    array("=PROPERTY.CODE" => "SIZES_SHOES"),
                )
            ),
        ))->fetchAll();
        $arData = array();
        $arItems = array();
        foreach ($rows as $row) {
            $arItems[$row['ELEMENT_ID']]['ELEMENT_ID'] = $row['ELEMENT_ID'];
            $arItems[$row['ELEMENT_ID']][$row['PROPERTY_CODE']] = $row['VALUE'];
        }
        foreach ($arItems as $item) {
            $arData[$item['CML2_LINK']][$this->SIZE[$item['SIZES_SHOES']]] = $item['ELEMENT_ID'];
        }
        unset($rows);
        unset($arElements);
        return $arData;
    }

    public function getElementId($arFilter)
    {
        $rsElement = \CIBlockElement::GetList(
            array(),
            $arFilter,
            false,
            false,
            array("ID")
        );
        if ($arElement = $rsElement->GetNext()) {
            return $arElement['ID'];
        }
        return false;
    }

    public function getOffersByProductId($id)
    {
        $arOffers = array();
        $rsOffers = \CIBlockElement::GetList(
            array(),
            array(
                'IBLOCK_ID' => $this->SKU['IBLOCK_ID'],
                'PROPERTY_' . $this->SKU['SKU_PROPERTY_ID'] => $id
            ),
            false,
            false,
            array("ID", "IBLOCK_ID", "PROPERTY_SIZES_SHOES")
        );
        while ($arOffer = $rsOffers->GetNext()) {
            $arOffers[$this->SIZE[$arOffer['PROPERTY_SIZES_SHOES_VALUE']]] = $arOffer["ID"];
        }
        return $arOffers;
    }

    public static function getSize()
    {
        $result = array();
        $rows = ElementTable::getList(array(
            "select" => array("ID", "NAME"),
            "filter" => array(
                "IBLOCK_ID" => self::SKU_PROP_IBLOCK_ID,
            ),
        ))->fetchAll();
        $result['IDS'] = array_column($rows, 'NAME', 'ID');
        $result['NAMES'] = array_column($rows, 'ID', 'NAME');
        return $result;
    }

    public static function getStore()
    {
        $rows = \Bitrix\Catalog\StoreTable::getList(array(
            'select' => array("ID", "XML_ID"),
        ))->fetchAll();
        $rows = array_column($rows, 'ID', 'XML_ID');
        return $rows;
    }

    public function log($arData)
    {
        if (self::LOG) {
            Debug::writeToFile($arData, "", "/upload/import/" . $this->LOG_FILE);
        }
    }

    public function getAmountProduct($id)
    {
        $arAmount = \Bitrix\Catalog\StoreProductTable::getList(array(
            'select' => array("*"),
            'filter' => array("PRODUCT_ID" => $id)
        ))->fetchAll();
        $arAmount = array_column($arAmount, null, 'STORE_ID');
        return $arAmount;
    }

    public function updateRemnants($id, $arStories, $size, $elementId)
    {
        $quantity = 0;
		$this->obElement->Update($id, array('ACTIVE' => 'Y'));
		//$this->BDB->query("UPDATE b_iblock_element SET ACTIVE ='Y'  WHERE ID='".$id."' LIMIT 1" );

        $arAmount = $this->getAmountProduct($id);
        $arIds = array();
        // обновляем/добавляем для склада
        foreach ($arStories as $xmlId => $store) {
            $storeId = $this->STORE[$xmlId];
            $arIds[$storeId] = $storeId;
            if ($arAmount[$storeId]) {
                \Bitrix\Catalog\StoreProductTable::update(
                    $arAmount[$storeId]['ID'],
                    array('AMOUNT' => $store["q"])
                );
            } else {
                \Bitrix\Catalog\StoreProductTable::add(array(
                    'AMOUNT' => $store["q"],
                    'PRODUCT_ID' => $id,
                    'STORE_ID' => $storeId
                ));

            }
            $this->log("Update: id " . $id . ", size " . $size . ", store " . $storeId . ", quantity " . $store["q"]);
            $quantity += floatval($store["q"]);
        }
        // обнуляем там где нет
        foreach ($arAmount as $storeId => $store) {
            if (!$arIds[$storeId]) {
                \Bitrix\Catalog\StoreProductTable::delete($store['ID']);
            }
        }
        // обновляем общее количество
        $catalog_product = \CCatalogProduct::GetByID($id);
        if (!$catalog_product) {
            $weight = current($this->getProperty('WEIGHT', $elementId, self::IBLOCK_ID));
            $weight = doubleval($weight['VALUE']);
            $weight = $this->calcWeight($weight);
            $arFields = array(
                "ID" => $id,
                'PURCHASING_PRICE' => 0,
                'PURCHASING_CURRENCY' => 'RUB',
                'QUANTITY' => $quantity,
                'WEIGHT' => $weight
            );
            \CCatalogProduct::Add($arFields);
        } else {
            $weight = current($this->getProperty('WEIGHT', $elementId, self::IBLOCK_ID));
            $weight = doubleval($weight['VALUE']);
            $weight = $this->calcWeight($weight);
            \CCatalogProduct::Update($id, array('QUANTITY' => $quantity, 'WEIGHT' => $weight));
        }
    }

    public function getElementById($id)
    {
        if (self::$ELEMENTS[$id]) {
            return self::$ELEMENTS[$id];
        }
        $rsElement = \CIBlockElement::GetList(
            array(),
            array(
                'IBLOCK_ID' => self::IBLOCK_ID,
                'ID' => $id
            ),
            false,
            false,
            array("ID", "IBLOCK_ID", "NAME", "CODE", "PROPERTY_*")
        );
        if ($obElement = $rsElement->GetNextElement()) {
            $arElement = $obElement->GetFields();
            $arElement['PROPS'] = $obElement->GetProperties();
            return $arElement;
        }
    }

    public function getPropsEnumValue($CODE, $VALUE, $IBLOCK_ID)
    {
        $PropID = 0;
        $property_enums = \CIBlockPropertyEnum::GetList(Array("DEF" => "DESC", "SORT" => "ASC"), Array("IBLOCK_ID" => $IBLOCK_ID, "CODE" => $CODE, "VALUE" => $VALUE));
        if ($enum_fields = $property_enums->GetNext()) {
            $PropID = $enum_fields["ID"];
        } else {
            $properties = \CIBlockProperty::GetList(Array("sort" => "asc", "name" => "asc"), Array("IBLOCK_ID" => $IBLOCK_ID, "CODE" => $CODE));
            if ($prop_fields = $properties->GetNext()) {
                $ibpenum = new \CIBlockPropertyEnum;
                $PropID = $ibpenum->Add(Array('PROPERTY_ID' => $prop_fields["ID"], 'VALUE' => $VALUE));
            }
        }
        return $PropID;
    }

    public function addSize($value)
    {
        $arFields = array(
            "IBLOCK_ID" => self::SKU_PROP_IBLOCK_ID,
            "IBLOCK_SECTION_ID" => false,
            "ACTIVE" => 'Y',
            "NAME" => $value
        );
        if ($id = $this->obElement->Add($arFields)) {
            return $id;
        }
    }

    public function calcWeight($value)
    {
        if ($value > 1000) {
            $value = $value / 1000;
        } elseif ($value < 10 && $value > 0) {
            $value = $value * 1000;
        } elseif ($value == 0) {
            $value = 500;
        }
        return $value;
    }

    public function getProperty($code, $elementId, $iblockId)
    {
        $arResult = array();
        $dbProperty = \CIBlockElement::getProperty(
            $iblockId,
            $elementId,
            "sort",
            "asc",
            array("CODE" => $code)
        );
        while ($arProperty = $dbProperty->Fetch()) {
            $arResult[] = $arProperty;
        }
        return $arResult;
    }

    public function addProduct($id, $arStories, $size)
    {
        $arElement = $this->getElementById($id);
        if ($arElement) {
            $sizeId = $this->SIZE_REV[$size];
            if (!$sizeId) {
                $sizeId = $this->addSize($size);
            }

            $productId = $this->getElementId(array(
                "IBLOCK_ID" => $this->SKU['IBLOCK_ID'],
                "PROPERTY_CML2_LINK" => $arElement['ID'],
                "PROPERTY_SIZES_SHOES" => $sizeId
            ));

            if (!$productId) {
                $arFields = array(
                    "IBLOCK_ID" => $this->SKU['IBLOCK_ID'],
                    "IBLOCK_SECTION_ID" => false,
                    "ACTIVE" => 'Y',
                    "NAME" => $arElement['NAME'],
                    "PROPERTY_VALUES" => array(
                        "CML2_LINK" => $arElement['ID'],
                        "ARTNUMBER_T" => $arElement['PROPS']['ARTNUMBER']['VALUE'],
                        "C_CODE" => current($arStories)['code'],
                        "SIZES_SHOES" => $sizeId
                    )
                );
                if ($productId = $this->obElement->Add($arFields)) {
                    $arFields = array(
                        "ID" => $productId,
                        'PURCHASING_PRICE' => 0,
                        'PURCHASING_CURRENCY' => 'RUB',
                        'MEASURE' => 5,
                        'WEIGHT' => $this->calcWeight(doubleval($arElement['PROPS']['WEIGHT']['VALUE'])),
                        'QUANTITY' => 0,
                        "HEIGHT" => 0,
                        "WIDTH" => 0,
                        "LENGTH" => 0,
                    );
                    $catalog_product = \CCatalogProduct::GetByID($productId);
                    if (!$catalog_product) {
                        \CCatalogProduct::Add($arFields);
                    } else {
                        \CCatalogProduct::Update($productId, $arFields);
                    }
                    $arFields = Array(
                        "PRODUCT_ID" => $productId,
                        "CATALOG_GROUP_ID" => $this->BASE_PRICE['ID'],
                        "PRICE" => doubleval($arElement['PROPS']['PRICE_SORT']['VALUE']),
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
                        \CPrice::Update($arr["ID"], $arFields);
                    } else {
                        \CPrice::Add($arFields);
                    }
                    $this->log("Add: id " . $productId . ", size " . $size);
                    $this->updateRemnants($productId, $arStories, $size, $arElement['ID']);
                }
            } else {
                $this->updateRemnants($productId, $arStories, $size, $arElement['ID']);
            }
        }
    }

    public function deactivateProduct($id)
    {
		$this->obElement->Update($id, array('ACTIVE' => 'N'));
		//$this->BDB->query("UPDATE b_iblock_element SET ACTIVE ='N'  WHERE ID='".$id."' LIMIT 1" );
        $this->log("Deactivate: id " . $id);
    }

    public static function agentImport()
    {
//        $rsAgent = \CAgent::GetList(array(), array("NAME" => "Import::agentImport();"));
//        if ($agent = $rsAgent->GetNext()) {
//            if ($agent['RUNNING'] == 'Y') {
//                return "Import::agentImport();";
//            }
//        }
        $processImport = \COption::GetOptionString("import", "process_import", "N");
        if ($processImport == 'Y') {
            //return "Import::agentImport();";
        }
        \COption::SetOptionString("import", 'process_import', 'Y');
        $obImport = new self();
        $arRemnants = $obImport->getRemnants();
        $arElements = $obImport->getElements();
        foreach ($arElements as $arItem) {
            if ($arRemnants[$arItem['ARTNUMBER']]) {
                $arOffers = $obImport->getOffersByProductId($arItem['ELEMENT_ID']);
                $offers = array_keys($arOffers);
                $remnants = array_keys($arRemnants[$arItem['ARTNUMBER']]);

                // обновление
                $arSize = array_intersect($offers, $remnants);
                foreach ($arSize as $size) {
                    $obImport->updateRemnants($arOffers[$size], $arRemnants[$arItem['ARTNUMBER']][$size], $size, $arItem['ELEMENT_ID']);
                }

                // деактивация
                $arSize = array_diff($offers, $remnants);
                foreach ($arSize as $size) {
                    $obImport->deactivateProduct($arOffers[$size]);
                }

                // добавление
                $arSize = array_diff($remnants, $offers);
                foreach ($arSize as $size) {
                    $obImport->addProduct($arItem['ELEMENT_ID'], $arRemnants[$arItem['ARTNUMBER']][$size], $size);
                }
				$obImport->obElement->Update($arItem['ELEMENT_ID'], array('ACTIVE' => 'Y'));
				//$this->BDB->query("UPDATE b_iblock_element SET ACTIVE ='Y'  WHERE ID=".$arItem['ELEMENT_ID']." LIMIT 1" );
            } else {
				$obImport->obElement->Update($arItem['ELEMENT_ID'], array('ACTIVE' => 'N'));
				//$this->BDB->query("UPDATE b_iblock_element SET ACTIVE ='N'  WHERE ID=".$arItem['ELEMENT_ID']." LIMIT 1" );
                $obImport->log("Not found: " . $arItem['ARTNUMBER']);
            }
        }
        \COption::SetOptionString("import", 'process_import', 'N');
        return "Import::agentImport();";
    }
}