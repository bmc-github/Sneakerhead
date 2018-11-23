<?
Global $APPLICATION;

CModule::IncludeModule("sale");

Class CDeliveryMajor {

/**
* Описние обработчика
*/
function Init()
{
//настройки
return array(
"SID"                     => "Major",  // Идентификатор службы доставки
"NAME"                     => "Пример обработчика службы доставки",
"DESCRIPTION"             => "Описание его для клиентов сайта",
"DESCRIPTION_INNER"     => "Описание для администраторов сайта",
"BASE_CURRENCY"         => "RUR",

"HANDLER"                 => __FILE__,

/* Определение методов */
"DBGETSETTINGS"         => array("CDeliveryPlain", "GetSettings"),
"DBSETSETTINGS"         => array("CDeliveryPlain", "SetSettings"),
"GETCONFIG"             => array("CDeliveryPlain", "GetConfig"),

"COMPABILITY"             => array("CDeliveryPlain", "Compability"),
"CALCULATOR"             => array("CDeliveryPlain", "Calculate"),

/* Список профилей */
"PROFILES" => array(
"all" => array(
"TITLE" => "Без ограничений",
"DESCRIPTION" => "Профиль доставки без каких-либо ограничений",

"RESTRICTIONS_WEIGHT" => array(0),
"RESTRICTIONS_SUM" => array(0),
),
)
);
}

/* Установка параметров */
function SetSettings($arSettings)
{
foreach ($arSettings as $key => $value){
if (strlen($value) > 0)
$arSettings[$key] = doubleval($value);
else
unset($arSettings[$key]);
}

return serialize($arSettings);
}

/* Запрос параметров */
function GetSettings($strSettings) {
return unserialize($strSettings);
}

/* Запрос конфигурации службы доставки */
function GetConfig()
{
$arConfig = array(
"CONFIG_GROUPS" => array(
"all" => "Параметры",
),

"CONFIG" => array(
"DELIVERY_PRICE" => array(
"TYPE" => "STRING",
"DEFAULT" => "200",
"TITLE" => "Стоимость доставки",
"GROUP" => "all"
)
),
);
return $arConfig;
}

/* Проверка соответствия профиля доставки заказу */
function Compability($arOrder, $arConfig)
{
return array("all");
}

/* Калькуляция стоимости доставки*/
function Calculate($profile, $arConfig, $arOrder, $STEP, $TEMP = false) {
return array(
"RESULT" => "OK",
"VALUE" => $arConfig["DELIVERY_PRICE"]
);
}

}

AddEventHandler("sale", "onSaleDeliveryHandlersBuildList", array("CDeliveryPlain", "Init"));

?>