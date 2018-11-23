<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Логистический модуль");
?>

      <div class="white-bg">
        <h1><?$APPLICATION->ShowTitle(false)?></h1>

<?$APPLICATION->IncludeComponent(
	"realweb:catalog.store.list", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"PHONE" => "N",
		"SCHEDULE" => "N",
		"PATH_TO_ELEMENT" => "/logistic/##store_code#",
		"MAP_TYPE" => "0",
		"SET_TITLE" => "Y",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>      </div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>