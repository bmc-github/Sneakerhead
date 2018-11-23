<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var $APPLICATION CMain
 */

if ($arParams["SET_TITLE"] == "Y")
{
	$APPLICATION->SetTitle(Loc::getMessage("SOA_ORDER_COMPLETE"));
}
?>
<? if (!empty($arResult["ORDER"])): ?>

	<table class="sale_order_full_table">
		<tr>
			<td>
				<?=Loc::getMessage("SOA_ORDER_SUC", array(
					"#ORDER_DATE#" => $arResult["ORDER"]["DATE_INSERT"],
					"#ORDER_ID#" => $arResult["ORDER"]["ACCOUNT_NUMBER"]
				))?>
				<? if (!empty($arResult['ORDER']["PAYMENT_ID"])): ?>
					<?=Loc::getMessage("SOA_PAYMENT_SUC", array(
						"#PAYMENT_ID#" => $arResult['PAYMENT'][$arResult['ORDER']["PAYMENT_ID"]]['ACCOUNT_NUMBER']
					))?>
				<? endif ?>
				<br /><br />
				<?=Loc::getMessage("SOA_ORDER_SUC1", array("#LINK#" => $arParams["PATH_TO_PERSONAL"]))?>
			</td>
		</tr>
	</table>

<?
	if (!isset($_GET['PAYMENT']) || $_GET['PAYMENT'] != 'Y')
	{

$orderF = \Bitrix\Sale\Order::load($arResult["ORDER"]["ACCOUNT_NUMBER"]);
$arr = array();
$arr_rr = array();
$basketF = $orderF->getBasket();
	foreach($basketF AS $itemF){
	$f = $itemF->getFields();
	$mxResult  = CCatalogSku::GetProductInfo($f["PRODUCT_ID"]);
	$f["PRODUCT_ID"] = $mxResult['ID'];
	$arr[] = $f["PRODUCT_ID"];
	$arr_rr[] = "{id:".$f["PRODUCT_ID"].", qnt: ".$f["QUANTITY"].",price:".$f["PRICE"]."}";
$gtm[] = "{
				'name': '". $а['NAME'] . "', // название товара
				'id': '" . $f["PRODUCT_ID"] ."', // id товара
				'price': '". $f["PRICE"] ."',
				'variant': '" . $product['option']['option_value'] ."',
				'quantity': '". $f["QUANTITY"]. "'
				}";
	}


?>
<script type="text/javascript">
var _tmr = _tmr || [];
_tmr.push({
    id: '3065581',
    type: 'itemView',
    productid: "[<? echo join(',',$arr);?>]",
    pagetype: 'purchase',
    list: '1',
    totalvalue: '<?=$basketF->getPrice();?>'
});
</script>

<script type="text/javascript">
(window["rrApiOnReady"] = window["rrApiOnReady"] || []).push(function() {
    try {
        rrApi.order({
            transaction: '<?=$arResult["ORDER"]["ACCOUNT_NUMBER"];?>',
            items: [
                <? echo join(',',$arr_rr);?>
            ]
        });
    } catch(e) {}
})


</script>
<script>
				dataLayer.push({
				'ecommerce': {
						'currencyCode': 'RUB',
						'purchase': {
								'actionField': {
								'id': '<?=$arResult["ORDER"]["ACCOUNT_NUMBER"];?>',
								'revenue': '<?=$orderF->getPrice();?>',
								'shipping': '<? echo ($orderF->getPrice()-$basketF->getPrice());?>'
							},
							'products': [<?= join(',',$gtm);?>]
					}
				},
				'event': 'gtm-ee-event',
				'gtm-ee-event-category': 'Enhanced Ecommerce',
				'gtm-ee-event-action': 'Purchase',
				'gtm-ee-event-non-interaction': 'False',
			});
			</script>


	<?
	}
if ($arResult["ORDER"]["IS_ALLOW_PAY"] === 'Y')
	{
		if (!empty($arResult["PAYMENT"]))
		{
			foreach ($arResult["PAYMENT"] as $payment)
			{
				if ($payment["PAID"] != 'Y')
				{
					if (!empty($arResult['PAY_SYSTEM_LIST'])
						&& array_key_exists($payment["PAY_SYSTEM_ID"], $arResult['PAY_SYSTEM_LIST'])
					)
					{
						$arPaySystem = $arResult['PAY_SYSTEM_LIST'][$payment["PAY_SYSTEM_ID"]];

						if (empty($arPaySystem["ERROR"]))
						{
							?>
                            <?if ($_REQUEST['PAYMENT']=='Y'){?>
							<br /><br />

							<table class="sale_order_full_table">
								<tr>
									<td class="ps_logo">
										<div class="pay_name"><?=Loc::getMessage("SOA_PAY") ?></div>
										<?=CFile::ShowImage($arPaySystem["LOGOTIP"], 100, 100, "border=0\" style=\"width:100px\"", "", false) ?>
										<div class="paysystem_name"><?=$arPaySystem["NAME"] ?></div>
										<br/>
									</td>
								</tr>
								<tr>
									<td>
										<? if (strlen($arPaySystem["ACTION_FILE"]) > 0 && $arPaySystem["NEW_WINDOW"] == "Y" && $arPaySystem["IS_CASH"] != "Y"): ?>
											<?
											$orderAccountNumber = urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]));
											$paymentAccountNumber = $payment["ACCOUNT_NUMBER"];
											?>
											<script>
												window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=$orderAccountNumber?>&PAYMENT_ID=<?=$paymentAccountNumber?>');
											</script>
										<?=Loc::getMessage("SOA_PAY_LINK", array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$orderAccountNumber."&PAYMENT_ID=".$paymentAccountNumber))?>
										<? if (CSalePdf::isPdfAvailable() && $arPaySystem['IS_AFFORD_PDF']): ?>
										<br/>
											<?=Loc::getMessage("SOA_PAY_PDF", array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$orderAccountNumber."&pdf=1&DOWNLOAD=Y"))?>
										<? endif ?>
										<? else: ?>
											<?=$arPaySystem["BUFFERED_OUTPUT"]?>
										<? endif ?>
									</td>
								</tr>
							</table>
                            <?}?>
							<?
						}
						else
						{
							?>
							<span style="color:red;"><?=Loc::getMessage("SOA_ORDER_PS_ERROR")?></span>
							<?
						}
					}
					else
					{
						?>
						<span style="color:red;"><?=Loc::getMessage("SOA_ORDER_PS_ERROR")?></span>
						<?
					}
				}
			}
		}
	}
	else
	{
		?>
		<br /><strong><?=$arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR']?></strong>
		<?
	}
	?>

<? else: ?>

	<b><?=Loc::getMessage("SOA_ERROR_ORDER")?></b>
	<br /><br />

	<table class="sale_order_full_table">
		<tr>
			<td>
				<?=Loc::getMessage("SOA_ERROR_ORDER_LOST", array("#ORDER_ID#" => $arResult["ACCOUNT_NUMBER"]))?>
				<?=Loc::getMessage("SOA_ERROR_ORDER_LOST1")?>
			</td>
		</tr>
	</table>

<? endif ?>