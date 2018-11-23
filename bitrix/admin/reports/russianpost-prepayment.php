<?use Bitrix\Main,
    Bitrix\Sale;

function num2str($num) {
	$nul='ноль';
	$ten=array(
		array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
		array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
	);
	$a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
	$tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
	$hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
	$unit=array( // Units
		array('копейка' ,'копейки' ,'копеек',	 1),
		array('рубль'   ,'рубля'   ,'рублей'    ,0),
		array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
		array('миллион' ,'миллиона','миллионов' ,0),
		array('миллиард','милиарда','миллиардов',0),
	);
	list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
	$out = array();
	if (intval($rub)>0) {
		foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
			if (!intval($v)) continue;
			$uk = sizeof($unit)-$uk-1; // unit key
			$gender = $unit[$uk][3];
			list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
			// mega-logic
			$out[] = $hundred[$i1]; # 1xx-9xx
			if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
			else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
			// units without rub & kop
			if ($uk>1) $out[]= morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
		}
	}
	else $out[] = $nul;
	$out[] = morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
	$out[] = $kop.' '.morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
	return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
}

function morph($n, $f1, $f2, $f5) {
	$n = abs(intval($n)) % 100;
	if ($n>10 && $n<20) return $f5;
	$n = $n % 10;
	if ($n>1 && $n<5) return $f2;
	if ($n==1) return $f1;
	return $f5;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="ru" xml:lang="ru">
<head>
<title langs="ru,s1">Почта России предоплата</title>
<link rel="stylesheet" href="reports/css/blank.css" />
<script src="reports/js/jquery-1.7.1.min.js"></script>
<script src="reports/js/a_blank.js"></script>
</head>
<body style="margin:0px;" cz-shortcut-listen="true">
	<button class="print_button" type="button" style="position:absolute;top:5px;right:230px;background:#ff4433;padding:10px;" media="screen">Распечатать</button>
	<a href="#" id="hide_cennost" class="hidec" media="screen">Скрыть ценность</a>


	<div class="page1"><span style="position:absolute;top:0;right:0;z-index:33;color:#000;"><?=$ORDER_ID?></span><div class="nakl_main" style="margin-top:0cm;">
			<div class="nakl_blnk1">
				<img src="reports/images/envelope.png" style="position:absolute;top:0;left:0px;width: 13,56cm; height: 19cm;z-index:1;">
				<div class="blk_ocen1 cennost" style="left:-146px;top:3cm;"><?=number_format($arOrder['PRICE'], 0, '.', '');?> руб. 00 <?=num2str($arOrder['PRICE']);?></div>
				<div class="blk_ocen2 cennost" style="left:-117px;top:3cm;"></div>
				<div class="blk_info1" style="top:228px;left:148px;"><?=$arOrder['USER_LAST_NAME']?> <?=$arOrder['USER_NAME']?></div>
				<div class="blk_info2" style="top:210px;left:226px;"><?=($arOrderProps['LOCATION_REGION']?$arOrderProps['LOCATION_REGION'].' ':'').$arOrderProps['LOCATION_CITY']?> <?=$arOrderProps['ADDRESS']?></div>
				<div class="blk_info3" style="top:300px;left:360px;"><?=$arOrderProps['ZIP']?></div>
				<div class="blk_info4" style="top:600px;right:-20px;"><?=$ORDER_ID?></div>
				<div class="blk_info6">Перемещение вложения</div>
				<div class="blk_info5" style="">Марин Сергей Валериевич</div>
				<div class="blk_info4" style="width:500px;font-size:9pt;top:350px;right:-220px;position:absolute;z-index:25;overflow:hidden;-moz-transform: rotate(-90deg);-webkit-transform: rotate(-90deg);-o-transform: rotate(-90deg);">
					Запрещенных к пересылке вложений нет.<br>
					Если форма 112ф утеряна, наложенный платеж отправлять по адресу:
					125445 Москва, до востребования. Марин Сергей Валериевич</div>
			</div>
			<div class="nakl_blnk2" style="margin-left:20px;">
							</div>
	</div>
		<div class="nakl_main">
			<div class="nakl_blnk1"><table width="100%">
			<tbody><tr>
				<td width="25%" rowspan="3" align="left" valign="top"><img src="reports/images/site_logo.jpg" width="110" height="112" style="margin:25px 0 0 7px;"></td>
				<td width="75%"><span style="position:absolute; padding-left:1.5cm;"><strong>ЗАКАЗ № <?=$ORDER_ID?>
				</strong></span><span style="float:right; margin-right:5px"><?=$arOrder['DATE_INSERT_FORMAT']?></span><br>
				<br></td>
			</tr>
			<tr>
				<td align="right"><span style="">Кому:</span> <span style="display:block; float:right; width:85%; margin-right: 5px;"><?=$arOrder['USER_LAST_NAME']?> <?=$arOrder['USER_NAME']?> <br>
				<?=$arOrderProps['LOCATION_CITY']?><br>
				<?=$arOrderProps['PHONE']?></span></td>
			</tr>
			<tr>
				<td height="40"><strong>Интернет магазин «Sneakerhead»</strong><br>
					тел.: 8(800) 700-32-53</td>
			</tr>
			<tr>
				<td height="191" colspan="2"><br>
				    <table width="100%" id="order" cellspacing="0">
				    	<tbody><tr>
							<td width="4%">№</td>
							<td>Бренд</td>
							<td>Название</td>
							<td width="5%">Размер</td>
							<td width="3%">К-во</td>
							<td width="8%">Цена</td>
							<td width="8%">Скидка</td>
							<td>Сумма</td>
						</tr>
<?$bs = \Bitrix\Sale\Basket::getList(array('filter' => array('ORDER_ID' => $ORDER_ID)));
  $sum = 0;
  $i = 1;
  while($it = $bs->Fetch()){
    $tp = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>3,'ID'=>$it['PRODUCT_ID']), false, false, array('ID','PROPERTY_SIZES_SHOES','PROPERTY_ARTNUMBER_T'))->GetNext(false,false);   
    $size = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>17,'ID'=>$tp['PROPERTY_SIZES_SHOES_VALUE']), false, false, array('NAME'))->GetNext(false,false)['NAME'];
    $sum += $it['QUANTITY'] * $it['PRICE'];
    $discount = $it['DISCOUNT_PRICE'] * 100 / $it['BASE_PRICE'];
?>   
					    <tr>
					      <td><?=$i++?></td>
					      <td></td>
					      <td><span style="height:2em;overflow:hidden"><?=$it['NAME']?></span><br><?=$tp['PROPERTY_ARTNUMBER_T_VALUE']?></td>
					      <td><?=$size?></td>
					      <td align="right"><?=(int) $it['QUANTITY']?></td>
					      <td align="right"><?=number_format($it['BASE_PRICE'], 0, '.', '');?></td>
					      <td align="right"><?=$discount?>%</td>
					      <td align="right"><?=number_format($it['PRICE'], 0, '.', '');?></td>
					    </tr>
<?}?>
						<tr>
							<td>&nbsp;</td>
							<td colspan="5" style="text-align:right;">Сумма заказа</td>
							<td class="moscow_delivery"><?=number_format($sum, 0, '.', '');?></td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="5" style="text-align:right;">Доставка</td>
							<td class="moscow_delivery"><?=number_format($arOrder['PRICE_DELIVERY'], 0, '.', '');?></td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style="border-right:solid 0px;">&nbsp;</td>
							<td style="border-right:solid 0px; border-left:solid 0px;">&nbsp;</td>
							<td colspan="4" style="border-left:solid 0px;text-align:right;"><strong>ИТОГО </strong></td>
							<td><?=number_format($arOrder['PRICE'], 0, '.', '');?></td><td>&nbsp;</td>
						</tr>
					</tbody></table>
				</td>
			</tr>
		</tbody></table><div style="text-align:right;margin-top:25px;">
				<strong style="margin-top:25px;font-size:22pt;">БЕЗ Н/П </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></div>
			<div class="otrez"></div>
			<div class="nakl_blnk2"><table width="100%">
			<tbody><tr>
				<td width="25%" rowspan="3" align="left" valign="top"><img src="reports/images/site_logo.jpg" width="110" height="112" style="margin:25px 0 0 7px;"></td>
				<td width="75%"><span style="position:absolute; padding-left:1.5cm;"><strong>ЗАКАЗ № <?=$ORDER_ID?>
				</strong></span><span style="float:right; margin-right:5px"><?=$arOrder['DATE_INSERT_FORMAT']?></span><br>
				<br></td>
			</tr>
			<tr>
				<td align="right"><span style="">Кому:</span> <span style="display:block; float:right; width:85%; margin-right: 5px;"><?=$arOrder['USER_NAME']?> <?=$arOrder['USER_LAST_NAME']?><br>
				<?=$arOrderProps['LOCATION_CITY']?><br>
				<?=$arOrderProps['PHONE']?></span></td>
			</tr>
			<tr>
				<td height="40"><strong>Интернет магазин «Sneakerhead»</strong><br>
					тел.: 8(800) 700-32-53</td>
			</tr>
			<tr>
				<td height="191" colspan="2"><br>
				    <table width="100%" id="order" cellspacing="0">
				    	<tbody><tr>
							<td width="4%">№</td>
							<td>Бренд</td>
							<td>Название</td>
							<td width="5%">Размер</td>
							<td width="3%">К-во</td>
							<td width="8%">Цена</td>
							<td width="8%">Скидка</td>
							<td>Сумма</td>
						</tr>
<?$bs = \Bitrix\Sale\Basket::getList(array('filter' => array('ORDER_ID' => $ORDER_ID)));
  $sum = 0;
  $i = 1;
  while($it = $bs->Fetch()){
    $tp = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>3,'ID'=>$it['PRODUCT_ID']), false, false, array('ID','PROPERTY_SIZES_SHOES','PROPERTY_ARTNUMBER_T'))->GetNext(false,false);   
    $size = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>17,'ID'=>$tp['PROPERTY_SIZES_SHOES_VALUE']), false, false, array('NAME'))->GetNext(false,false)['NAME'];
    $sum += $it['QUANTITY'] * $it['PRICE'];
    $discount = $it['DISCOUNT_PRICE'] * 100 / $it['BASE_PRICE'];
?>   
					    <tr>
					      <td><?=$i++?></td>
					      <td></td>
					      <td><span style="height:2em;overflow:hidden"><?=$it['NAME']?></span><br><?=$tp['PROPERTY_ARTNUMBER_T_VALUE']?></td>
					      <td><?=$size?></td>
					      <td align="right"><?=(int) $it['QUANTITY']?></td>
					      <td align="right"><?=number_format($it['BASE_PRICE'], 0, '.', '');?></td>
					      <td align="right"><?=$discount?>%</td>
					      <td align="right"><?=number_format($it['PRICE'], 0, '.', '');?></td>
					    </tr>
<?}?>
						<tr>
							<td>&nbsp;</td>
							<td colspan="5" style="text-align:right;">Сумма заказа</td>
							<td class="moscow_delivery"><?=number_format($sum, 0, '.', '');?></td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="5" style="text-align:right;">Доставка</td>
							<td class="moscow_delivery"><?=number_format($arOrder['PRICE_DELIVERY'], 0, '.', '');?></td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style="border-right:solid 0px;">&nbsp;</td>
							<td style="border-right:solid 0px; border-left:solid 0px;">&nbsp;</td>
							<td colspan="4" style="border-left:solid 0px;text-align:right;"><strong>ИТОГО </strong></td>
							<td><?=number_format($arOrder['PRICE'], 0, '.', '');?></td><td>&nbsp;</td>
						</tr>
					</tbody></table>
				</td>
			</tr>
		</tbody></table><div style="text-align:right;margin-top:25px;">
				<strong style="margin-top:25px;font-size:22pt;">БЕЗ Н/П </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></div>
		</div>


<script>
	var moscow = false;
			$(".print_button").click(function(){
				if(moscow==true){
					//Printed("<?=$ORDER_ID?>");
					ShowMoscowDelivery();

				}else{
					//Printed('a:1:{i:0;s:5:"<?=$ORDER_ID?>";}');
					window.print();
				}
				return false;
			});
</script>

</div><span style="border-radius: 3px; text-indent: 20px; width: auto; padding: 0px 4px 0px 0px; text-align: center; font-style: normal; font-variant: normal; font-weight: bold; font-stretch: normal; font-size: 11px; line-height: 20px; font-family: &quot;Helvetica Neue&quot;, Helvetica, sans-serif; color: rgb(255, 255, 255); background: url(&quot;data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGhlaWdodD0iMzBweCIgd2lkdGg9IjMwcHgiIHZpZXdCb3g9Ii0xIC0xIDMxIDMxIj48Zz48cGF0aCBkPSJNMjkuNDQ5LDE0LjY2MiBDMjkuNDQ5LDIyLjcyMiAyMi44NjgsMjkuMjU2IDE0Ljc1LDI5LjI1NiBDNi42MzIsMjkuMjU2IDAuMDUxLDIyLjcyMiAwLjA1MSwxNC42NjIgQzAuMDUxLDYuNjAxIDYuNjMyLDAuMDY3IDE0Ljc1LDAuMDY3IEMyMi44NjgsMC4wNjcgMjkuNDQ5LDYuNjAxIDI5LjQ0OSwxNC42NjIiIGZpbGw9IiNmZmYiIHN0cm9rZT0iI2ZmZiIgc3Ryb2tlLXdpZHRoPSIxIj48L3BhdGg+PHBhdGggZD0iTTE0LjczMywxLjY4NiBDNy41MTYsMS42ODYgMS42NjUsNy40OTUgMS42NjUsMTQuNjYyIEMxLjY2NSwyMC4xNTkgNS4xMDksMjQuODU0IDkuOTcsMjYuNzQ0IEM5Ljg1NiwyNS43MTggOS43NTMsMjQuMTQzIDEwLjAxNiwyMy4wMjIgQzEwLjI1MywyMi4wMSAxMS41NDgsMTYuNTcyIDExLjU0OCwxNi41NzIgQzExLjU0OCwxNi41NzIgMTEuMTU3LDE1Ljc5NSAxMS4xNTcsMTQuNjQ2IEMxMS4xNTcsMTIuODQyIDEyLjIxMSwxMS40OTUgMTMuNTIyLDExLjQ5NSBDMTQuNjM3LDExLjQ5NSAxNS4xNzUsMTIuMzI2IDE1LjE3NSwxMy4zMjMgQzE1LjE3NSwxNC40MzYgMTQuNDYyLDE2LjEgMTQuMDkzLDE3LjY0MyBDMTMuNzg1LDE4LjkzNSAxNC43NDUsMTkuOTg4IDE2LjAyOCwxOS45ODggQzE4LjM1MSwxOS45ODggMjAuMTM2LDE3LjU1NiAyMC4xMzYsMTQuMDQ2IEMyMC4xMzYsMTAuOTM5IDE3Ljg4OCw4Ljc2NyAxNC42NzgsOC43NjcgQzEwLjk1OSw4Ljc2NyA4Ljc3NywxMS41MzYgOC43NzcsMTQuMzk4IEM4Ljc3NywxNS41MTMgOS4yMSwxNi43MDkgOS43NDksMTcuMzU5IEM5Ljg1NiwxNy40ODggOS44NzIsMTcuNiA5Ljg0LDE3LjczMSBDOS43NDEsMTguMTQxIDkuNTIsMTkuMDIzIDkuNDc3LDE5LjIwMyBDOS40MiwxOS40NCA5LjI4OCwxOS40OTEgOS4wNCwxOS4zNzYgQzcuNDA4LDE4LjYyMiA2LjM4NywxNi4yNTIgNi4zODcsMTQuMzQ5IEM2LjM4NywxMC4yNTYgOS4zODMsNi40OTcgMTUuMDIyLDYuNDk3IEMxOS41NTUsNi40OTcgMjMuMDc4LDkuNzA1IDIzLjA3OCwxMy45OTEgQzIzLjA3OCwxOC40NjMgMjAuMjM5LDIyLjA2MiAxNi4yOTcsMjIuMDYyIEMxNC45NzMsMjIuMDYyIDEzLjcyOCwyMS4zNzkgMTMuMzAyLDIwLjU3MiBDMTMuMzAyLDIwLjU3MiAxMi42NDcsMjMuMDUgMTIuNDg4LDIzLjY1NyBDMTIuMTkzLDI0Ljc4NCAxMS4zOTYsMjYuMTk2IDEwLjg2MywyNy4wNTggQzEyLjA4NiwyNy40MzQgMTMuMzg2LDI3LjYzNyAxNC43MzMsMjcuNjM3IEMyMS45NSwyNy42MzcgMjcuODAxLDIxLjgyOCAyNy44MDEsMTQuNjYyIEMyNy44MDEsNy40OTUgMjEuOTUsMS42ODYgMTQuNzMzLDEuNjg2IiBmaWxsPSIjYmQwODFjIj48L3BhdGg+PC9nPjwvc3ZnPg==&quot;) 3px 50% / 14px 14px no-repeat rgb(189, 8, 28); position: absolute; opacity: 1; z-index: 8675309; display: none; cursor: pointer; border: none; -webkit-font-smoothing: antialiased; top: 10px; left: 10px;">Сохранить</span><span style="width: 24px; height: 24px; background: url(&quot;data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pjxzdmcgd2lkdGg9IjI0cHgiIGhlaWdodD0iMjRweCIgdmlld0JveD0iMCAwIDI0IDI0IiB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxkZWZzPjxtYXNrIGlkPSJtIj48cmVjdCBmaWxsPSIjZmZmIiB4PSIwIiB5PSIwIiB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHJ4PSI2IiByeT0iNiIvPjxyZWN0IGZpbGw9IiMwMDAiIHg9IjUiIHk9IjUiIHdpZHRoPSIxNCIgaGVpZ2h0PSIxNCIgcng9IjEiIHJ5PSIxIi8+PHJlY3QgZmlsbD0iIzAwMCIgeD0iMTAiIHk9IjAiIHdpZHRoPSI0IiBoZWlnaHQ9IjI0Ii8+PHJlY3QgZmlsbD0iIzAwMCIgeD0iMCIgeT0iMTAiIHdpZHRoPSIyNCIgaGVpZ2h0PSI0Ii8+PC9tYXNrPjwvZGVmcz48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIGZpbGw9IiNmZmYiIG1hc2s9InVybCgjbSkiLz48L3N2Zz4=&quot;) 50% 50% / 14px 14px no-repeat rgba(0, 0, 0, 0.4); position: absolute; opacity: 1; z-index: 8675309; display: none; cursor: pointer; border: none; border-radius: 12px; top: 8px; left: 455px;"></span>
</body>
</html>