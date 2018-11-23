<?php
CModule::AddAutoloadClasses('', array(
    "Util" => "/bitrix/php_interface/classes/Util.php",
    "IblockElementPropertyTable" => "/bitrix/php_interface/classes/IblockElementPropertyTable.php",
    "Import" => "/bitrix/php_interface/classes/Import.php",
    "ImportOrder" => "/bitrix/php_interface/classes/ImportOrder.php",
));
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