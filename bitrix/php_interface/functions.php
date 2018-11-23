<?


class ObjEventManager
{

    static $iblocks;

    private $cache_id;

    private $cache_dir;

    private $ttl = 3600;

    public static function SetPrice(&$arFields)
    {
        if ($arFields['IBLOCK_ID'] == 2) {
            $res = \CIBlockElement::GetList(array(self::$CATALOG_PRICE => 'ASC'), array(
                'PROPERTY_CML2_LINK' => $arFields['ID'],
                'ACTIVE' => 'Y',
                'IBLOCK_ID' => 3), false, array('nTopCount' => '1'),
                array(
                'ID',
                'IBLOCK_ID',
                self::$CATALOG_PRICE));
            if ($element = $res->Fetch()) {
                \CIBlockElement::SetPropertyValuesEx($arFields['ID'], $arFields['IBLOCK_ID'],
                    array('PRICE_SORT' => $element[self::$CATALOG_PRICE]));
            }
        }
    }
}
?>