<?
$_SERVER["DOCUMENT_ROOT"] = realpath(dirname(__FILE__) . "/../../../");
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
define('CHK_EVENT', true);
define('LANG', 's1');
define('BX_UTF', true);
define('BX_BUFFER_USED', true);
date_default_timezone_set('Europe/Moscow');
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
@set_time_limit(0);
@ignore_user_abort(true);
global $USER,$APPLICATION;
if (!is_object($USER)) $USER = new \CUser();
//$arAuthResult = $USER->Login("CRON", "CRON_PASS", "Y");
//$APPLICATION->arAuthResult = $arAuthResult;
$import = new ImportOrder();
$import->importProducts();