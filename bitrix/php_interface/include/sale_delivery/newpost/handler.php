<?

namespace Sale\Handlers\Delivery;

use Bitrix\Sale\Delivery\CalculationResult;
use Bitrix\Sale\Delivery\Services\Base;
use Bitrix\Mje2;
use Bitrix\Main\Loader;

class NewpostHandler extends Base
{
    public static $PRICE;

    public static function getClassTitle()
    {
        return 'Почта России новая';
    }

    public static function getClassDescription()
    {
        return 'Почта России новая';
    }

    public function isCompatible(\Bitrix\Sale\Shipment $shipment)
    {
        $calcResult = self::calculateConcrete($shipment);
        AddEventHandler("sale", "OnSaleComponentOrderDeliveriesCalculated", array("\\Sale\\Handlers\\Delivery\\NewpostHandler",
                "OnSaleComponentOrderDeliveriesCalculated"));
        return $calcResult->isSuccess();
    }

    public function OnSaleComponentOrderDeliveriesCalculated($order, &$arUserResult,
        $request, &$arParams, &$arResult, &$arDeliveryServiceAll, &$arPaySystemServiceAll)
    {
        foreach ($arDeliveryServiceAll as $key => $deliveryObj) {
            $DELIVERY_ID = $deliveryObj->getId();
            if (isset($arResult['DELIVERY'][$DELIVERY_ID])) {
                if ($deliveryObj instanceof self) {
                    $arResult['DELIVERY'][$DELIVERY_ID]['PRICE'] = self::$PRICE;
                }
            }
        }
    }

    protected function calculateConcrete(\Bitrix\Sale\Shipment $shipment)
    {
        $error = false;
        $result = new CalculationResult();
        $weight = floatval($shipment->getWeight());
        $weight = $weight / 1000;
        $order = $shipment->getCollection()->getOrder();
        $props = $order->getPropertyCollection();
        $zipProp = $props->getDeliveryLocationZip();


        $zipPropValue = $zipProp->getValue();

        $locPropValue = $props->getDeliveryLocation()->getViewHtml();


        $country = explode(',', $locPropValue);


        if ($zipPropValue <= 100000 || $country[0] != 'Россия') {
            //В случае если индекс имеет нестандартную длину или не Россия
            $counted = 1500 + round($weight - 0.9) * 1000;

        } else {

            global $DB;


            $arr = array(
                '1' => 150,
                '2' => 160,
                '3' => 180,
                '4' => 240,
                '5' => 320);
            $arr_add = array(
                '1' => 29,
                '2' => 32,
                '3' => 37,
                '4' => 49,
                '5' => 55);

            $sql = "SELECT * FROM `zakaz_pzone` WHERE `index` LIKE '" . $zipPropValue . "'";
            $res = $DB->Query($sql, false, $err_mess . __line__);
            $row = $res->Fetch();


            $sql2 = "SELECT *,IF(deltype LIKE 'прямой авиа',1,0) AS avia,IF(deltype LIKE 'запрещена',1,0) AS zapret,IF(deltype LIKE 'наземная',1,0) AS zemlya FROM zakaz_prestr WHERE `index` = " .
                $row['index'];
            $res2 = $DB->Query($sql, false, $err_mess . __line__);


            while ($rowr = $res2->Fetch()) {

                $date1 = explode('.', $rowr->prbegdate);
                $date2 = explode('.', $rowr->prenddate);
                //$date3 = explode('-',$row -> created);

                $beg = mktime(0, 0, 0, $date1[1], $date1[0], date('Y'));
                $end = mktime(0, 0, 0, $date2[1], $date2[0], date('Y'));

                $cre = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

                if ($beg < $cre && $cre < $end && ($rowr->avia || $rowr->zapret)) {
                    $add = 500;
                }

            }


            $counted = ($arr[$row['zone']] + intval($weight * 2) * $arr_add[$row['zone']] +
                $add) * 1.04 + $order->getPrice() * 0.04 + 150;


      
        }
      $counted = ceil($counted / 10) * 10;
        $result->setPeriodDescription('2-3 дня');
        $result->setDeliveryPrice($counted);

        self::$PRICE = $counted;

        return $result;
    }


    protected function getConfigStructure()
    {
        return array();
    }

    public function isCalculatePriceImmediately()
    {
        return true;
    }

    public static function whetherAdminExtraServicesShow()
    {
        return true;
    }

}

?>