<?php
// Убирать товар из новинок через 3 недели после поступления

$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';
set_time_limit(0);

use Bitrix\Main\Loader;

Loader::includeModule('iblock');

$dbItems = CIBlockElement::GetList(
    [],
    [
        'IBLOCK_ID' => 2,
        'ACTIVE' => 'Y',
        '!PROPERTY_ISNEW' => false,
        '<PROPERTY_DATE_AVAILABLE' => date('Y-m-d', strtotime("-3 weeks")),
    ],
    false,
    false,
    [
        'IBLOCK_ID',
        'ID'
    ]
);
while ($item = $dbItems->GetNext()) {

    if ($_GET['log']) echo "{$item['ID']}<br>";
    if ($_GET['debug']) continue;

    // убираем флаг Новинка
    CIBlockElement::SetPropertyValuesEx($item['ID'], 2, [
        'ISNEW' => false,
    ]);

    // удаляем из группы Новинки
    $dbGroups = CIBlockElement::GetElementGroups($item['ID'], true, ['ID']);
    $groups = [];
    while($group = $dbGroups->Fetch()) {
        if ($group['ID'] != 56) {
            $groups[] = $group['ID'];
        }
    }
    CIBlockElement::SetElementSection($item['ID'], $groups);
}