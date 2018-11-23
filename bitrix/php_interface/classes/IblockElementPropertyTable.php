<?php

use Bitrix\Main\Entity;

class IblockElementPropertyTable extends Entity\DataManager
{
    public static function getFilePath()
    {
        return __FILE__;
    }

    public static function getTableName()
    {
        return 'b_iblock_element_property';
    }

    public static function getMap()
    {
        return
            array(
                'ID' => array(
                    'data_type' => 'integer',
                    'primary' => true,
                    'autocomplete' => true,
                    'title' => "ID",
                ),
                'IBLOCK_PROPERTY_ID' => array(
                    'data_type' => 'integer',
                    'primary' => true,
                ),
                'IBLOCK_ELEMENT_ID' => array(
                    'data_type' => 'integer',
                    'primary' => true,
                ),
                'VALUE' => array(
                    'data_type' => 'string',
                    'required' => true,
                ),
                'VALUE_TYPE' => array(
                    'data_type' => 'string',
                    'required' => true,
                ),
                'VALUE_ENUM' => array(
                    'data_type' => 'integer',
                ),
                'VALUE_NUM' => array(
                    'data_type' => 'float',
                ),
                'DESCRIPTION' => array(
                    'data_type' => 'string',
                ),
                'PROPERTY' => array(
                    'data_type' => 'Bitrix\Iblock\Property',
                    'reference' => array('=this.IBLOCK_PROPERTY_ID' => 'ref.ID'),
                ),
                'ELEMENT' => array(
                    'data_type' => 'Bitrix\Iblock\Element',
                    'reference' => array('=this.IBLOCK_ELEMENT_ID' => 'ref.ID'),
                ),
                'ENUM' => array(
                    'data_type' => 'Bitrix\Iblock\PropertyEnumeration',
                    'reference' => array('=this.VALUE_ENUM' => 'ref.ID'),
                )
            );
    }

    public static function getElementData($arParams)
    {
        $arData = [];
        if (!$arParams['select'])
            $arParams['select'] = array();
        $defaultSelect = array(
            "PROPERTY_CODE" => "PROPERTY.CODE",
            "ELEMENT_ID" => "IBLOCK_ELEMENT_ID",
            "VALUE" => "VALUE",
        );
        $arParams["select"] = array_merge($defaultSelect, $arParams["select"]);
        $rows = self::getList($arParams);
        while ($row = $rows->fetch()) {
            if (!$arData[$row['ELEMENT_ID']]) {
                foreach ($arParams['select'] as $key => $value) {
                    if (!is_nan($key)) {
                        $arData[$row['ELEMENT_ID']][$key] = $row[$key];
                    }
                }
            }
            $arData[$row['ELEMENT_ID']][$row['PROPERTY_CODE']][] = $row['VALUE'];
        }
        return $arData;
    }

    public static function getProperties(array $parameters = array(), $funcFetch = false)
    {
        if (!isset($parameters["select"]))
            $parameters["select"] = array();
        $defaultSelect = array(
            "PROPERTY_ID" => "PROPERTY.ID",
            "PROPERTY_CODE" => "PROPERTY.CODE",
            "PROPERTY_NAME" => "PROPERTY.NAME",
            "PROPERTY_IS_REQUIRED" => "PROPERTY.IS_REQUIRED",
            "PROPERTY_TYPE" => "PROPERTY.PROPERTY_TYPE",
            "PROPERTY_MULTIPLE" => "PROPERTY.MULTIPLE",
            "PROPERTY_DEFAULT_VALUE" => "PROPERTY.DEFAULT_VALUE",
            "PROPERTY_VALUE_ID" => "ID",
            "VALUE" => "VALUE",
            "VALUE_ENUM",
            "VALUE_XML_ID" => "ENUM.XML_ID",
            "VALUE_NUM",
        );
        $parameters["select"] = array_merge($defaultSelect, $parameters["select"]);
        return is_callable($funcFetch) ? $funcFetch(self::getList($parameters)) : self::getList($parameters)->fetchAll();
    }
}