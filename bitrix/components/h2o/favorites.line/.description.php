<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("H2O_FAVORITES_LINE_DESC_LINE"),
	"DESCRIPTION" => GetMessage("H2O_FAVORITES_LINE_DESC_LINE_DESC"),
//	"ICON" => "/images/1c-imp.gif",
	"CACHE_PATH" => "Y",
	"SORT" => 120,
	"PATH" => array(
		"ID" => "h2o",
		"CHILD" => array(
			"ID" => "favorites",
			"NAME" => GetMessage("H2O_FAVORITES_ADD_DESC_GROUP"),
			"SORT" => 100,
		),
	),
);

?>