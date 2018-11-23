<?

namespace Sale\Handlers\Delivery;

use Bitrix\Sale\Delivery\CalculationResult;
use Bitrix\Sale\Delivery\Services\Base;
use Bitrix\Mje2;
use Bitrix\Main\Loader;

class MajorHandler extends Base
{
    public static $PRICE;

    public static function getClassTitle()
    {
        return 'Madjor служба доставки';
    }

    public static function getClassDescription()
    {
        return 'Madjor служба доставки';
    }

    public function isCompatible(\Bitrix\Sale\Shipment $shipment)
    {
        $calcResult = self::calculateConcrete($shipment);
        AddEventHandler("sale", "OnSaleComponentOrderDeliveriesCalculated", array("\\Sale\\Handlers\\Delivery\\MajorHandler", "OnSaleComponentOrderDeliveriesCalculated"));
        return $calcResult->isSuccess();
    }

    public function OnSaleComponentOrderDeliveriesCalculated($order, &$arUserResult, $request, &$arParams, &$arResult, &$arDeliveryServiceAll, &$arPaySystemServiceAll)
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
        $weight = floatval($shipment->getWeight()) / 1000;
        $order = $shipment->getCollection()->getOrder();
        $props = $order->getPropertyCollection();
        $zipProp = $props->getDeliveryLocationZip();
        if ($zipPropValue = $zipProp->getValue()) {
            if (Loader::includeModule("mje2.delivery")) {
                $row = Mje2\Mje2Table::getList(array(
                    'select' => array("*"),
                    'filter' => array("indexx" => $zipPropValue),
                    'limit' => 1
                ))->fetch();
                if ($row) {
                    $arr = array('1' => 700, '2' => 950, '3' => 1350, '4' => 1600, '5' => 2000);
                    self::$PRICE = ($arr[$row['pzone']] ? $arr[$row['pzone']] : 2000) + $weight * 400;
                    $result->setDeliveryPrice(roundEx(self::$PRICE, 2));
                    $result->setPeriodDescription('2-3 дня');
                    $result->setDescription('');
                } else {
                    $error = true;
                }
            } else {
                $error = true;
            }
        } else {
            $error = true;
        }
        if ($error) {
            $result->addError(new \Bitrix\Main\Error("стоимость доставки не рассчитана"));
        }
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