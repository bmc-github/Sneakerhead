<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Sale;

$basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
$price = $basket->getPrice(); // Сумма с учетом скидок
$fullPrice = $basket->getBasePrice(); // Сумма без учета скидок

$productId = intval($_POST['id']);
$quantity = intval($_POST['quantity']);
if ($item = $basket->getExistsItem('catalog', $productId)) {
    $item->setField('QUANTITY', $item->getQuantity() + $quantity);
} else {
    $item = $basket->createItem('catalog', $productId);
    $item->setFields(array(
        'QUANTITY' => $quantity,
        'CURRENCY' => Bitrix\Currency\CurrencyManager::getBaseCurrency(),
        'LID' => Bitrix\Main\Context::getCurrent()->getSite(),
        'PRODUCT_PROVIDER_CLASS' => '\CCatalogProductProvider',
    ));
}

$basket->save();
?>
