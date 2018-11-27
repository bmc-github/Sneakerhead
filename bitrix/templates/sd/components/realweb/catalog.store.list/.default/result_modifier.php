<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)die();

CModule::IncludeModule("sale");
CModule::IncludeModule('catalog');
CModule::IncludeModule("grain.tables");
//Обновление позиций при действии из логистического модуля
 if (isset($_POST['ID'])){
	 $ID_UP = $_POST['ID']; 
	 $rpZZxx = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>19,"ID"=>$ID_UP), false, false, array("PROPERTY_OOO","ID",'NAME','PROPERTY_ORDER','PROPERTY_NAME_T','PROPERTY_SIZE','PROPERTY_SKLAD_O','PROPERTY_C_CODES','PROPERTY_PRICE','PROPERTY_ARTICLE','PROPERTY_ACCOUNT_NUMBER')); 
	 $PROP = array(); 
	 while($rpZZxxx=$rpZZxx->GetNext()){
		 $NAME = $rpZZxxx["NAME"];
		 //Данный массив нужен так как гребанный модуль таблицы не работает с человеческим обновление доп. полей.
		 $PROP[92] = $rpZZxxx["PROPERTY_ORDER_VALUE"];
		 $PROP[93] = $rpZZxxx["PROPERTY_SIZE_VALUE"];
		 $PROP[89] = $rpZZxxx["PROPERTY_NAME_T_VALUE"];
		 $PROP[99] = $rpZZxxx["PROPERTY_SKLAD_O_VALUE"];
		 $PROP[95] = $rpZZxxx["PROPERTY_C_CODES_VALUE"];
		 $PROP[91] = $rpZZxxx["PROPERTY_PRICE_VALUE"];
		 $PROP[96] = $rpZZxxx["PROPERTY_ARTICLE_VALUE"];
		 $PROP[107] = $rpZZxxx["PROPERTY_ACCOUNT_NUMBER_VALUE"];
		 $PROP[101][$rpZZxxx["PROPERTY_OOO_VALUE_ID"]]['in']=$rpZZxxx["PROPERTY_OOO_VALUE"]['in'];
		 $PROP[101][$rpZZxxx["PROPERTY_OOO_VALUE_ID"]]['out']=$rpZZxxx["PROPERTY_OOO_VALUE"]['out'];
		 $PROP[101][$rpZZxxx["PROPERTY_OOO_VALUE_ID"]]['col']=$rpZZxxx["PROPERTY_OOO_VALUE"]['col'];
		 $PROP[101][$rpZZxxx["PROPERTY_OOO_VALUE_ID"]]['yes_m']=$rpZZxxx["PROPERTY_OOO_VALUE"]['yes_m'];
		 $PROP[101][$rpZZxxx["PROPERTY_OOO_VALUE_ID"]]['yes_a']=$rpZZxxx["PROPERTY_OOO_VALUE"]['yes_a'];
		 $PROP[101][$rpZZxxx["PROPERTY_OOO_VALUE_ID"]]['com_a']=$rpZZxxx["PROPERTY_OOO_VALUE"]['com_a'];
		 $PROP[101][$rpZZxxx["PROPERTY_OOO_VALUE_ID"]]['com_m']=$rpZZxxx["PROPERTY_OOO_VALUE"]['com_m'];
		 $PROP[101][$rpZZxxx["PROPERTY_OOO_VALUE_ID"]]['stat']=$rpZZxxx["PROPERTY_OOO_VALUE"]['stat'];
		 $PROP[101][$rpZZxxx["PROPERTY_OOO_VALUE_ID"]]['moveds']=$rpZZxxx["PROPERTY_OOO_VALUE"]['moveds'];
		 //Если в админке был изменен склад откуда забирать
		 //интересно $rpZZxxx["PROPERTY_OOO_VALUE_ID"]== $_POST['ID_LINE'] ?
		 if ($rpZZxxx['PROPERTY_SKLAD_O_VALUE']==$rpZZxxx["PROPERTY_OOO_VALUE"]['out']){
		 	$PROP[101][$rpZZxxx["PROPERTY_OOO_VALUE_ID"]]['samov']='yes';  
		 } else {
		 	$PROP[101][$rpZZxxx["PROPERTY_OOO_VALUE_ID"]]['samov']='no';    
		 };
		 if ($_POST['WHO']=='A'){//отмечает админ
			 $PROP[101][$_POST['ID_LINE']]['yes_a']=$_POST['Q_NUM'];
			 $PROP[101][$_POST['ID_LINE']]['com_a']=$_POST['COMMENTS'];
			 if ($_POST['Q_NUM']=='Y'&&!isset($_POST['SV'])){
				 if ($PROP[101][$rpZZxxx["PROPERTY_OOO_VALUE_ID"]]['samov']=='yes'){
					$PROP[101][$_POST['ID_LINE']]['stat']='sent';   
				 } else {
				 	$PROP[101][$_POST['ID_LINE']]['stat']='approved=1';
				 }   
			 } else if ($_POST['Q_NUM']=='Y'&&isset($_POST['SV'])){//видимо склад совпал с магазином самовывоза
				 if ($PROP[101][$rpZZxxx["PROPERTY_OOO_VALUE_ID"]]['samov']=='yes'){
					 $PROP[101][$_POST['ID_LINE']]['stat']='sent';   
				 } else {
				 	$PROP[101][$_POST['ID_LINE']]['stat']='approved=1';
				 };  
			 } else if ($_POST['Q_NUM']=='N'&&!isset($_POST['SV'])){
				 $PROP[101][$_POST['ID_LINE']]['stat']='denied=2';   
			 } else if ($_POST['Q_NUM']=='N'&&isset($_POST['SV'])){
				 $PROP[101][$_POST['ID_LINE']]['stat']='denied=2';   
			 };
		 };
		 if ($_POST['WHO']=='M'){// менеджер
			 $PROP[101][$_POST['ID_LINE']]['yes_m']=$_POST['Q_NUM'];
			 $PROP[101][$_POST['ID_LINE']]['com_m']=$_POST['COMMENTS'];
			 if ($_POST['Q_NUM']=='Y'&&!isset($_POST['SV'])){
				 if ($PROP[101][$rpZZxxx["PROPERTY_OOO_VALUE_ID"]]['samov']=='yes'){
					 $PROP[101][$_POST['ID_LINE']]['stat']='sent';   
				 } else {
					 $PROP[101][$_POST['ID_LINE']]['stat']='pre_approved=11';
				 };   
			 } else if ($_POST['Q_NUM']=='Y'&&isset($_POST['SV'])){
				 if ($PROP[101][$rpZZxxx["PROPERTY_OOO_VALUE_ID"]]['samov']=='yes'){
				 	$PROP[101][$_POST['ID_LINE']]['stat']='sent';   
				 } else {
				 	$PROP[101][$_POST['ID_LINE']]['stat']='approved=1';
				 };   
			 } else if ($_POST['Q_NUM']=='N'&&!isset($_POST['SV'])){
			 	$PROP[101][$_POST['ID_LINE']]['stat']='Pre_denied=22';   
			 } else if ($_POST['Q_NUM']=='N'&&isset($_POST['SV'])){
			 	$PROP[101][$_POST['ID_LINE']]['stat']='Pre_denied=22';   
		 	 };
	 	};   
	 };

	 //тут обновление записи
	 $el = new CIBlockElement;
	 $arFields = array(              
	        "IBLOCK_ID"       => '19',
	        "NAME"            => $NAME,
	        "ACTIVE"          => 'Y',
		    "PROPERTY_VALUES" => $PROP,
	 );
	$res = $el->Update($ID_UP, $arFields);
	//Общее количество позици
	$Z=array();
	//Сбор количества статусов - Собран
	$Z2=array();
	//Сбор количества статусов - Отложен
	$Z3=array();
	$rpZZ2xx = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>19,"ID"=>$ID_UP), false, false, array("PROPERTY_OOO","ID",'NAME','PROPERTY_ORDER','PROPERTY_NAME_T','PROPERTY_SIZE','PROPERTY_SKLAD_O')); 
	while($rpZZ2xxx=$rpZZ2xx->GetNext()){
		//Количество элементов в позиции
			$Z[]=$rpZZ2xxx['PROPERTY_OOO_VALUE']['stat'];
		//Проверяем статусы  - Собран 
		if ($rpZZ2xxx['PROPERTY_OOO_VALUE']['stat']=='approved=1'||$rpZZ2xxx['PROPERTY_OOO_VALUE']['stat']=='sent'){
			$Z2[]=$rpZZ2xxx['PROPERTY_OOO_VALUE']['stat'];   
		};
		//Проверяем статусы  - Отложен
		if ($rpZZ2xxx['PROPERTY_OOO_VALUE']['stat']=='pre_approved=11'||$rpZZ2xxx['PROPERTY_OOO_VALUE']['stat']=='sent'){
			$Z3[]=$rpZZ2xxx['PROPERTY_OOO_VALUE']['stat'];   
		};
		
		if ($rpZZ2xxx['PROPERTY_OOO_VALUE']['stat']=='pre_approved=11'||$rpZZ2xxx['PROPERTY_OOO_VALUE']['stat']=='approved=1'||$rpZZ2xxx['PROPERTY_OOO_VALUE']['stat']=='sent'){
			$Z4[]=$rpZZ2xxx['PROPERTY_OOO_VALUE']['stat'];   
		};
		//Сбор позиций в статусе отправлен
		if ($rpZZ2xxx['PROPERTY_OOO_VALUE']['stat']=='sent'){
			$Z5[]=$rpZZ2xxx['PROPERTY_OOO_VALUE']['stat'];   
		};
	};
	$Zc=count($Z);
	$Z2c=count($Z2);
	$Z3c=count($Z3);
	$Z4c=count($Z4);
	$Z5c=count($Z5);
	$PROP=array();
	
	if ($Z5c==$Zc) {
		//Если все колличество позиции в статусе - Отправлен
		$PROP[94]=93;      
	} else if ($Z3c==$Zc) {
		//Если все колличество позиции в статусе - Отложен либо Отложен+Отправлен
		$PROP[94]=89;   
	} else if ($Zc==$Z2c){
		//Если все колличество позиции в статусе - Собран либо Отложен+Отправлен+Собран
		$PROP[94]=90;
	//Для конкретного случая - проверяем все статусы позиций в заказе (для изменения общего статуса) 
	} else if (in_array("denied=2", $Z)) {
		//Если хотя бы одна единица в статусе - Отменен
		$PROP[94]=91;
} else if (in_array("Pre_denied=22", $Z)) {
		//Если хотя бы одна единица в статусе - Нет в наличии
		$PROP[94]=91;
	} else if ($Zc==$Z4c) {
		$PROP[94]=89; 
	};
	
	
	
	CIBlockElement::SetPropertyValuesEx($ID_UP, false, $PROP);
	//Получаем общее колличество единиц в заказе если была разбивка по складам
	$STAT_Z_ALL=array();
	//Получаем общее колличество единиц в заказе если была разбивка по складам (статус - отправлен)
	$STAT_Z_SE=array();
	//Получаем общее колличество единиц в заказе если была разбивка по складам (статус - отложен)
	$STAT_Z_OT=array();
	//Получаем общее колличество единиц в заказе если была разбивка по складам (статус - собран)
	$STAT_Z_SB=array();
	//Получаем общее колличество единиц в заказе если была разбивка по складам (статус - нет в наличии)
	$STAT_Z_EX=array();
	
	$STAT_Z = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>19,"PROPERTY_ORDER"=>$_POST['ORDER']), false, false, array("PROPERTY_O_STAT","ID","IBLCOK_ID","PROPERTY_ORDER"));
	while($STAT_Z_Z=$STAT_Z->GetNext(false,false)){
		if ($STAT_Z_Z['PROPERTY_O_STAT_ENUM_ID']==93){
			$STAT_Z_SE[]=$STAT_Z_Z['PROPERTY_O_STAT_ENUM_ID'];   
		};
		if ($STAT_Z_Z['PROPERTY_O_STAT_ENUM_ID']==90||$STAT_Z_Z['PROPERTY_O_STAT_ENUM_ID']==93){
			$STAT_Z_SB[]=$STAT_Z_Z['PROPERTY_O_STAT_ENUM_ID'];   
		};
		if ($STAT_Z_Z['PROPERTY_O_STAT_ENUM_ID']==89||$STAT_Z_Z['PROPERTY_O_STAT_ENUM_ID']==90||$STAT_Z_Z['PROPERTY_O_STAT_ENUM_ID']==93){
			$STAT_Z_OT[]=$STAT_Z_Z['PROPERTY_O_STAT_ENUM_ID'];   
		};
		if ($STAT_Z_Z['PROPERTY_O_STAT_ENUM_ID']==91){
			$STAT_Z_EX[]=$STAT_Z_Z['PROPERTY_O_STAT_ENUM_ID'];   
		};
		$STAT_Z_ALL[] = $STAT_Z_Z; 
	};
	
	$STAT_Z_ALL_NUM = count($STAT_Z_ALL);
	$STAT_Z_SB_NUM = count($STAT_Z_SB);
	$STAT_Z_OT_NUM = count($STAT_Z_OT);
	$STAT_Z_SE_NUM = count($STAT_Z_SE);
	if ($STAT_Z_ALL_NUM==$STAT_Z_SE_NUM) {
	//Изменение общего статуса заказа на Отправлен
	$STATUS_Z = 'F';
	} else if ($STAT_Z_ALL_NUM==$STAT_Z_SB_NUM){
	//Изменение общего статуса заказа на собран
	$STATUS_Z = 'SZ';//16 - в старой системе 
	} else if ($STAT_Z_ALL_NUM==$STAT_Z_OT_NUM) {
	//Изменение общего статуса заказа на отложен 
	$STATUS_Z = 'OT'; 
	} else if ($STAT_Z_EX!=false){
	$STATUS_Z = 'NZ';//18 - в старой системе   
	} else {
	$STATUS_Z = 'N';//18 - в старой системе    
	};
	//$STATUS_Z = 'F';//3 - в старой системе 
	if (isset($STATUS_Z)){
		CSaleOrder::StatusOrder($_POST['ORDER'], $STATUS_Z);
	};
exit();
};
//END

//////UPDATE statuses
//Изменение трек номера
$track=htmlspecialchars($_POST['track']);
$id_track=htmlspecialchars($_POST['id-track']);
if(($USER->IsAdmin()||$arUser['UF_DOSTUP']==0) && $id_track){
	$prM = \Bitrix\Sale\Order::load($id_track);
	$shipmentCollection = $prM->getShipmentCollection();
	foreach($shipmentCollection as $shipment){
		//Пропуск системных значений
		if ($shipment->isSystem())
			continue;

		$shipment->setfield('DELIVERY_DOC_NUM', $track);	
	};
	
	if($prM->getField('STATUS_ID') == 'OF'){
		$prM->setField('STATUS_ID','F');
	}
	
	$prM->save();
	exit();
}
//END

///
///$USER->IsAdmin()||$arUser['UF_DOSTUP']==0

//Кнопка отмена
$OT=htmlspecialchars($_POST['OT']);
$id_OT=htmlspecialchars($_POST['id-OT']);
$commentOT=htmlspecialchars($_POST['commentOT']);
if(!empty($id_OT)){
	$prM = \Bitrix\Sale\Order::load($id_track);
	$shipmentCollection = $prM->getShipmentCollection();
	foreach($shipmentCollection as $shipment){
		//Пропуск системных значений
		if ($shipment->isSystem())
			continue;

		//ID магазина самовывоза
		$shop = $shipment->getStoreId();
	};
	if($USER->IsAdmin()||$arUser['UF_DOSTUP']==0 || $shop == $arUser['UF_DOSTUP']){
		$comment = $prM->getfield('COMMENTS');

		$prM->setfield('COMMENTS', $comment. '<br>'.$commentOT);
		//Изменение общего статуса заказа на выбранный
		$prM->setfield('STATUS_ID', $OT);
		$prM->save();
		
	};
	die();
}
//END

//Кнопка оплаченно
$commentOP=htmlspecialchars($_POST['commentOP']);
$id_OP=htmlspecialchars($_POST['id-OP']);
if(!empty($id_OP)){
	
	$prM = \Bitrix\Sale\Order::load($id_track);
	$shipmentCollection = $prM->getShipmentCollection();
	foreach($shipmentCollection as $shipment){
		//Пропуск системных значений
		if ($shipment->isSystem())
			continue;
	
		//ID магазина самовывоза
		$shop = $shipment->getStoreId();
	};
	if($USER->IsAdmin()||$arUser['UF_DOSTUP']==0 || $shop == $arUser['UF_DOSTUP']){
		$comment = $prM->getfield('COMMENTS');
		
		$paymentCollection = $prM->getPaymentCollection();
		foreach ($paymentCollection as $payment){

			$payment->setfield('COMMENTS', $comment. '<br>'.$commentOP);
			//Изменени статуса оплачен - в редактировании оплаты
			$payment->setfield('PAID', 'Y');
			//Изменение общего статуса заказа на оплаченно
			$prM->setfield('STATUS_ID', 'OP');
			$prM->save();
		
		
			//END
		};
		
		$prM->setfield('COMMENTS', $comment. '<br>'.$commentOP);
		//Изменение общего статуса заказа на выбранный
		$prM->setfield('STATUS_ID', 'OP');
		$prM->save();
		
	};
	die();
}



$sT=htmlspecialchars($_GET['sortT']);
if (isset($sT)){
  $sT=explode(',',$sT);  
} else {
  $sT[0]='ID';
  $sT[1]='asc';  
};


//Получаем список заказав для менеджеров интернет магазина - со статусом отправлен
//TODO добавить отбор по менеджерам/админ
var_dump($USER);
var_dump($arUser);
if(!$USER->IsAdmin()&&$arUser['UF_DOSTUP']!=0){
$roM = CSaleOrder::GetList(array($sT[0]=>$sT[1]), array('STATUS_ID'=>'F','DELIVERY_ID'=>3), false, false, array("ID","STATUS_ID","DELIVERY_ID",'ACCOUNT_NUMBER'));
$orderM = array();
while($orderOne = $roM->GetNext()){
	$orderMFull[] = $orderOne;
}
var_dump($orderMFull);

foreach($orderMFull as $orderM) {
	$prM = \Bitrix\Sale\Order::load($orderM['ID']);
	$shipmentCollection = $prM->getShipmentCollection();    
	foreach($shipmentCollection as $shipment){  
		//Пропуск системных значений
		if ($shipment->isSystem())
		continue;
		
		
		//Способ отправки
		$deliverystat=$shipment->getfields();
		//ID магазина
		$shop=$shipment->getStoreId();
		//Номер почтового отправления
		$numberpost=$shipment->getfields();
	};
	if($shop!=0){
		//Дата последнего изменения и Статус заказа
		$fields = $prM->getfields();
		$comment=$fields["COMMENTS"];

		$propertyCollection = $prM->getPropertyCollection();
		//Получение email заказа
		$email=$propertyCollection->getUserEmail();
		$email=$email->getfields();
		//Получение ФИО пользователя
		$FIO=$propertyCollection->getPayerName();
		$FIO=$FIO->getfields();
		//Получение телефона пользователя
		$phone=$propertyCollection->getPhone();
		$phone=$phone->getfields();

		if ($fields["STATUS_ID"]=='F'):
			$arResult['ITEMS-M'][$shop][]=array(  
			//$arResult['ITEMS-M'][]=array(
			'ID'=>$orderM['ID'],
			'ACCOUNT_NUMBER'=>$orderM['ACCOUNT_NUMBER'],
			'FIO'=>$FIO['VALUE'],
			'PHONE'=>$phone['VALUE'],
			'STATUS'=>$fields["STATUS_ID"],
			'DELIVERY'=>$deliverystat["DELIVERY_NAME"],
			'TRACK'=>$numberpost["DELIVERY_DOC_NUM"],
			'PRICE'=>$prM->getprice(),
			'DATE_UPDATE'=>$fields["DATE_UPDATE"]->toString()
			);
		endif;
		//Получаем список товаров запрошенного заказа
		$rbM = CSaleBasket::GetList(array("NAME"=>"ASC","ID"=>"ASC"), array("ORDER_ID"=>$orderM['ID']), false, false, array("ID","ORDER_ID","PRODUCT_ID","NAME","PRICE","QUANTITY","DISCOUNT_VALUE","STORE_ID"));
		while($itM = $rbM->GetNext()){
			$offerM = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>3,"ID"=>$itM["PRODUCT_ID"]), false, false, array("ID","IBLOCK_ID","PROPERTY_SIZES_SHOES","PROPERTY_CML2_LINK", "STORE_ID", "PROPERTY_C_CODE", "PROPERTY_ARTNUMBER_T","NAME","PROPERTY_ACCOUNT_NUMBER"))->GetNext(); 
			if ($offerM){
				$rpM = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>2,"ID"=>$offerM["PROPERTY_CML2_LINK_VALUE"]), false, false, array("ID","IBLOCK_ID","PREVIEW_PICTURE","PROPERTY_ARTNUMBER"))->GetNext();
				$sizeM = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>17,"ID"=>$offerM["PROPERTY_SIZES_SHOES_VALUE"]), false, false, array("NAME","ID"))->GetNext(); 
				$img = CFile::ResizeImageGet($rpM["PREVIEW_PICTURE"], array("width"=>40,"height"=>40), BX_RESIZE_IMAGE_EXACT, true);
				$arResult['Z-ITEM'][$itM["PRODUCT_ID"]]=array(
				'ID'=>$orderM['ID'],
				'IMG'=>$img,
				'ARTICLE'=>$offerM["PROPERTY_ARTNUMBER_T_VALUE"],
				'NAME'=>$offerM["NAME"],
				'QUANTITY'=>$itM["QUANTITY"],
				'ORDER_ID'=>$itM["ORDER_ID"],
				'SIZE'=>$sizeM["NAME"],
				'PRICE'=>$itM['PRICE'],
				'ACCOUNT_NUMBER'=>$offerM["PROPERTY_ACCOUNT_NUMBER_VALUE"]
				);
			};
		};
	};
};
}

var_dump($arResult['Z-ITEM']);


$arResult["ITEMS"] = array();
if ($_GET['sort']){
  $sort = explode('.',$_GET['sort']);
if ($sort[0]=='price'){
  $sort[0]='PROPERTY_PRICE';
} else if ($sort[0]=='article'){
  $sort[0]=='PROPERTY_ARTICLE';  
} else if ($sort[0]=='date'){
  $sort[0]=='DATE_CREATE';  
};
} else {
  $sort[0]=='DATE_CREATE';
  $sort[0]=='asc';  
};

//Получение масива колличественного разброса позиций по магазинам (таблица)   
$rpZ = CIBlockElement::GetList(array($sort[0]=>$sort[1]), array("IBLOCK_ID"=>19,'ACTIVE'=>"Y"), false, false, array("ID","IBLOCK_ID","PROPERTY_OOO","PROPERTY_ORDER","ACTIVE"));
$TABL=array();
$productZF = array();
while($productZFull = $rpZ->fetch()){
	$productZF[] = $productZFull;    
};
foreach($productZF as $productZ){
	//Проверка выполненных заказов
	$roDEL = CSaleOrder::GetList(array(), array('!STATUS_ID'=>array('N','OT','NZ','SZ','ZO','OF'),'ID'=>$productZ['PROPERTY_ORDER_VALUE']), false, false, array("ID","IBLOCK_ID"));
	while($DEL=$roDEL->Fetch()){
		//Если заказ выполнен - деактивируем элементы
		if ($DEL['ID']!=false){
		//$el = new CIBlockElement;
		//$arLoadProductArray = array(               
		//"ACTIVE" => 'N'
		//);
		//$res = $el->Update($productZ['ID'], $arLoadProductArray);
		//Удаляем позиции из инфоблока
		CIBlockElement::Delete($productZ['ID']); 
		};
	};
	$roSt = \Bitrix\Sale\Order::load($productZ['PROPERTY_ORDER_VALUE']);
	$roStSt = $roSt->getfield('STATUS_ID');
	
	//Создаем массив т.к. позиция может быть разбита поштучно на разные магазины
	//Не выводим позиции в статусе собран
	if ($productZ["PROPERTY_OOO_VALUE"]["stat"]!="approved=1" && $productZ["PROPERTY_OOO_VALUE"]["stat"]!="sent" && $productZ["PROPERTY_OOO_VALUE"]["stat"]!= "denied=2" && $roStSt != 'SZ' && $roStSt != 'OF'){

	$TABL[$productZ['ID']][0] = $productZ['ID'];
	$productZ['PROPERTY_OOO_VALUE'][] = array('id_line'=>$productZ['PROPERTY_OOO_VALUE_ID']);
	$TABL[$productZ['ID']][1][] = $productZ['PROPERTY_OOO_VALUE'];  
	};    
};


foreach ($TABL as $ttt){
	$rpZZ = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>19, "ID"=>$ttt[0], 'ACTIVE'=>"Y"), false, false, array("ID","PREVIEW_PICTURE","ACTIVE","IBLOCK_ID",'NAME',"PROPERTY_NAME_T","PROPERTY_SIZE","PROPERTY_ORDER","PROPERTY_SKLAD_O","PROPERTY_C_CODES","PROPERTY_PRICE","PROPERTY_ARTICLE",'DATE_CREATE','PROPERTY_ACCOUNT_NUMBER'))->Fetch();
	//Небольшой фикс в случае ошибки выставления статуса заказа
	if ($rpZZ['PROPERTY_ORDER_VALUE']!=false){
	$zItem = array();
	$obBasket = \Bitrix\Sale\Basket::getList(array('filter' => array('ORDER_ID' => $rpZZ["PROPERTY_ORDER_VALUE"])));
	while($bItem = $obBasket->Fetch()){
	    $zItem[] = $bItem['PRODUCT_ID'];
	}
	//var_dump($zItem);
	//Если заказ был изменен через административную панель - удаляем ненужные элементы
	foreach ($ttt[1] as $tt){
	    //echo $rpZZ['PROPERTY_NAME_T_VALUE'];
	if (in_array($rpZZ['PROPERTY_NAME_T_VALUE'],$zItem)==false){
		//CIBlockElement::Delete($rpZZ['ID']);   
	} else {
	$sizeM = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>17,"ID"=>$rpZZ["PROPERTY_SIZE_VALUE"]), false, false, array("NAME","ID","IBLOCK_ID"))->Fetch();    
	//Получаем свойство товара
	$arResult["ITEMS"][] = array(
			"ORDER_ID"      =>  $rpZZ["PROPERTY_ORDER_VALUE"],
	        "STORE_ID"      =>  $tt["out"],
	        "REAL_STORE"    =>  $rpZZ['PROPERTY_SKLAD_O_VALUE'],
			"ORDER_DATE"    =>  $rpZZ['DATE_CREATE'],
			"PICTURE"       =>  CFile::GetPath($rpZZ["PREVIEW_PICTURE"]),
			"NAME"          =>  $rpZZ['NAME'],
			"ARTNUMBER"     =>  $rpZZ["PROPERTY_ARTICLE_VALUE"],
			"PRICE"         =>  $rpZZ["PROPERTY_PRICE_VALUE"],
			"QUANTITY"      =>  $tt["col"],
	        "XML"           =>  $tt["moveds"],
			"SIZE"          =>  $sizeM["NAME"],
	        "ID_LINE"       =>  $tt[0]['id_line'],
	        "ID"            =>  $rpZZ['ID'],
	        "SAM"           =>  $tt["samov"],
	        "ADM_OTV"       =>  $tt["yes_a"],
	        "MAN_OTV"       =>  $tt["yes_m"],
	        "C_CODE"        =>  $rpZZ['PROPERTY_C_CODES_VALUE'],
	        "STAT_POS"      =>  $tt["stat"],
	        "ACCOUNT_NUMBER" => $rpZZ["PROPERTY_ACCOUNT_NUMBER_VALUE"]
	); 
	};
	};
	};       
};




date_default_timezone_set('UTC+3');
if ($_POST['STORE_ID']){
	$COL=array();
	$arResult["FLAG"]=array();
	foreach ($arResult["ITEMS"] as $oneVcol){
	if ($oneVcol["STORE_ID"]==$_POST['STORE_ID']&&!$USER->IsAdmin()&&$oneVcol['STAT_POS']=='pre_approved=11'&&$oneVcol['XML']!='yes'){
	  $COL[]=$oneVcol; 
	    };
	    };
	$COL_n = count($COL);
	if ($COL_n>0) {
	$arResult['XML'] = '<span>Выгружено ('.$COL_n.')</span>'; 
	//Создание xml файла при действии из логистического модуля
	$ah = CCatalogStore::GetList(array(),array('ID'=>$_POST['STORE_ID']),false,false,array('NAME','UF_1C','UF_V'));
	while($ahs=$ah->GetNext()){
	$c1 = $ahs['UF_1C'];
	$V = $ahs['UF_V'];    
	};
	$dom_xml= new DomDocument("1.0", "utf-8");
	$items = $dom_xml->createElement("items");
	$dom_xml->appendChild($items);
	$docNumber = $dom_xml->createElement("docNumber", 'snrk_'.$c1.'_'.date("d-m-Y H:i:s"));
	$items->appendChild($docNumber);
	$senderShop = $dom_xml->createElement("senderShop", $V);
	$items->appendChild($senderShop);
	$i=0;
	foreach ($arResult["ITEMS"] as $i=>$oneV){
	if ($oneV["STORE_ID"]==$_POST['STORE_ID']&&!$USER->IsAdmin()&&$oneV['STAT_POS']=='pre_approved=11'&&$oneV['XML']!='yes'){
	    $arResult["FLAG"][$i]['ID']=$oneV['ID'];
	    $arResult["FLAG"][$i]["ID_LINE"]=$oneV["ID_LINE"];
	    $DATE_CREATE = explode(' ', trim($oneV["ORDER_DATE"]));
	    $DATE_CREATE_DATE = $DATE_CREATE[0];
	    $DATE_CREATE_TIME = $DATE_CREATE[1];
	    $DATE_CREATE_DATE = explode('.',$DATE_CREATE_DATE);
	    $DATE_CREATE = $DATE_CREATE_DATE[2].'-'.$DATE_CREATE_DATE[1].'-'.$DATE_CREATE_DATE[0].' '.$DATE_CREATE_TIME;    
	$id = $i + 1; 
	$item = $dom_xml->createElement('item');
	$item->setAttribute("");
	$items->appendChild($item);
	$code1c=$dom_xml->createElement('code1c', $oneV["C_CODE"]);
	$item->appendChild($code1c);
	$article=$dom_xml->createElement('article', $oneV["ARTNUMBER"]);
	$item->appendChild($article); 
	$price=$dom_xml->createElement('price', $oneV["PRICE"]);
	$item->appendChild($price);  
	$quantity=$dom_xml->createElement('quantity', $oneV["QUANTITY"]);
	$item->appendChild($quantity); 
	$date=$dom_xml->createElement('date', $DATE_CREATE);
	$item->appendChild($date); 
	};
	};
	$dom_xml->preserveWhiteSpace = false;
	$dom_xml->formatOutput = true;
	//$path=$_SERVER["DOCUMENT_ROOT"].'/logistic/v/snrk_'.$c1.'.xml';
	$path = 'ftp://sneake01_ftp:6BjvOObrXT@ftp.sneake01.nichost.ru/fromHC/MoveDocs/snrk_'.$c1.'_'.date("Y-m-d H:i:s").'.xml';
	$dom_xml->save($path);
	foreach($arResult["FLAG"] as $flag){
	$ID_UP = $flag['ID'];
	$rpZZxx = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>19,"ID"=>$ID_UP), false, false, array("PROPERTY_OOO","IBLOCK_ID","PROPERTY_O_STAT","ID",'NAME','PROPERTY_ORDER','PROPERTY_NAME_T','PROPERTY_SIZE','PROPERTY_SKLAD_O','PROPERTY_C_CODES','PROPERTY_PRICE','PROPERTY_ARTICLE','PROPERTY_ACCOUNT_NUMBER')); 
	 $PROP = array(); 
	 while($rpZZxxx=$rpZZxx->Fetch()){
	 $NAME = $rpZZxxx["NAME"];
	 $PROP[92] = $rpZZxxx["PROPERTY_ORDER_VALUE"];
	 $PROP[93] = $rpZZxxx["PROPERTY_SIZE_VALUE"];
	 $PROP[94] = $rpZZxxx["PROPERTY_O_STAT_ENUM_ID"];
	 $PROP[89] = $rpZZxxx["PROPERTY_NAME_T_VALUE"];
	 $PROP[99] = $rpZZxxx["PROPERTY_SKLAD_O_VALUE"];
	 $PROP[95] = $rpZZxxx["PROPERTY_C_CODES_VALUE"];
	 $PROP[91] = $rpZZxxx["PROPERTY_PRICE_VALUE"];
	 $PROP[96] = $rpZZxxx["PROPERTY_ARTICLE_VALUE"];
	 $PROP[107] = $rpZZxxx["PROPERTY_ACCOUNT_NUMBER_VALUE"];
	 $PROP[101][$rpZZxxx["PROPERTY_OOO_VALUE_ID"]]['in']=$rpZZxxx["PROPERTY_OOO_VALUE"]['in'];
	 $PROP[101][$rpZZxxx["PROPERTY_OOO_VALUE_ID"]]['out']=$rpZZxxx["PROPERTY_OOO_VALUE"]['out'];
	 $PROP[101][$rpZZxxx["PROPERTY_OOO_VALUE_ID"]]['col']=$rpZZxxx["PROPERTY_OOO_VALUE"]['col'];
	 $PROP[101][$rpZZxxx["PROPERTY_OOO_VALUE_ID"]]['yes_m']=$rpZZxxx["PROPERTY_OOO_VALUE"]['yes_m'];
	 $PROP[101][$rpZZxxx["PROPERTY_OOO_VALUE_ID"]]['yes_a']=$rpZZxxx["PROPERTY_OOO_VALUE"]['yes_a'];
	 $PROP[101][$rpZZxxx["PROPERTY_OOO_VALUE_ID"]]['com_a']=$rpZZxxx["PROPERTY_OOO_VALUE"]['com_a'];
	 $PROP[101][$rpZZxxx["PROPERTY_OOO_VALUE_ID"]]['com_m']=$rpZZxxx["PROPERTY_OOO_VALUE"]['com_m'];
	 $PROP[101][$rpZZxxx["PROPERTY_OOO_VALUE_ID"]]['stat']=$rpZZxxx["PROPERTY_OOO_VALUE"]['stat'];
	 $PROP[101][$rpZZxxx["PROPERTY_OOO_VALUE_ID"]]['samov']=$rpZZxxx["PROPERTY_OOO_VALUE"]['samov'];  
	 $PROP[101][$rpZZxxx["PROPERTY_OOO_VALUE_ID"]]['moveds']=$rpZZxxx["PROPERTY_OOO_VALUE"]['moveds'];
	 };
	 $PROP[101][$flag["ID_LINE"]]['moveds']='yes';
	 $el = new CIBlockElement;
	 $arFields = array(                 
	        "IBLOCK_ID"       => '19',
	        "NAME"            => $NAME,
	        "ACTIVE"          => 'Y',
		    "PROPERTY_VALUES" => $PROP,
	 );
	$res = $el->Update($ID_UP, $arFields);   
	};
	//$APPLICATION->RestartBuffer();
	//$authData = array('errForm'=>'<span>'.$arResult['XML'].'</span>');
	//echo json_encode($authData);
	//exit(); 
	} else {
	//$APPLICATION->RestartBuffer();
	$arResult['XML'] = '<span>Нет товаров для выгрузки</span>';
	//$authData = array('errForm'=>'<span>'.$arResult['XML'].'</span>');
	//echo json_encode($authData);
	//exit(); 
	}
}

/*
/////принимаем ответ из 1с
if (scandir('ftp://sneake01_ftp:6BjvOObrXT@ftp.sneake01.nichost.ru/fromHC/ReceiveDocs/confirm_snrk_*.xml')!=false){
	foreach (scandir('ftp://sneake01_ftp:6BjvOObrXT@ftp.sneake01.nichost.ru/fromHC/ReceiveDocs/confirm_snrk_*.xml') as $filename) {

		 
		//if ($filename!='test.xml'){
		rename('ftp://sneake01_ftp:6BjvOObrXT@ftp.sneake01.nichost.ru/fromHC/ReceiveDocs/'.$filename, 'ftp://sneake01_ftp:6BjvOObrXT@ftp.sneake01.nichost.ru/fromHC/bitrix/'.str_replace(' ', '_',$filename));

		$PREN = simplexml_load_file('ftp://sneake01_ftp:6BjvOObrXT@ftp.sneake01.nichost.ru/fromHC/bitrix/'.str_replace(' ', '_',$filename));
		//var_dump($PREN);
		//Получаем название интернет магазина
		//$SHOP_P = $PREN->senderShop;
		//$docNumber_p = $PREN->docNumber;
		$docNumber_p = explode('_',$filename);
		$c1 = trim(str_replace('.xml','',$docNumber_p[1]));
		$ah = CCatalogStore::GetList(array(),array('UF_1C'=>$c1),false, false,array('NAME','UF_1C','UF_V'))->GetNext();
		$PREN=$PREN->Items;
		foreach($PREN as $item_p){
			$item_p = $item_p->Item;
			$PROP=array();
			//Получаем артикул товара
			$article_p=$item_p->article;
			$article_p = explode('р.',$article_p);
			$size = trim($article_p[1]);
			$article_p = trim($article_p[0]);
			//$date_c=$item_p->date;
			//Получаем колличество товара
			//$quantity_p=$item_p->quantity;
			//Получаем код 1С
			$code1c=(string)$item_p->code1c;

			//$date_ps=$item_p->date;

			$SZ = CIBlockElement::GetList(Array(),Array("IBLOCK_ID"=>17,"NAME"=>$size),false,false,Array("ID"))->GetNext();
			$SZ = $SZ['ID'];
			$DATE_CREATE = explode(' ', trim($date_c));
			$DATE_CREATE_DATE = $DATE_CREATE[0];
			$DATE_CREATE_TIME = $DATE_CREATE[1];
			$DATE_CREATE_DATE = explode('-',$DATE_CREATE_DATE);
			$DATE_CREATE = $DATE_CREATE_DATE[2].'.'.$DATE_CREATE_DATE[1].'.'.$DATE_CREATE_DATE[0].' '.$DATE_CREATE_TIME;
			//Получение всех полей - позиции выгруженного заказа
			$arElement_A = CIBlockElement::GetList(Array(),Array("IBLOCK_ID"=>19,"PROPERTY_ARTICLE"=>$article_p,"PROPERTY_C_CODES"=>$code1c),false,false,Array("PROPERTY_OOO","ID",'NAME','PROPERTY_ORDER','PROPERTY_NAME_T','PROPERTY_SIZE','PROPERTY_SKLAD_O','PROPERTY_C_CODES','PROPERTY_PRICE','PROPERTY_ARTICLE','PROPERTY_ACCOUNT_NUMBER'))->GetNext();
			//while($arElement_A=$rsElements_A->GetNext()){
			$ORDER_S=$arElement_A['PROPERTY_ORDER_VALUE'];
			$NAME_V = $arElement_A["NAME"];
			$PROP[92] = $arElement_A["PROPERTY_ORDER_VALUE"];
			$PROP[93] = $arElement_A["PROPERTY_SIZE_VALUE"];
			$PROP[89] = $arElement_A["PROPERTY_NAME_T_VALUE"];
			$PROP[99] = $arElement_A["PROPERTY_SKLAD_O_VALUE"];
			$PROP[95] = $arElement_A["PROPERTY_C_CODES_VALUE"];
			$PROP[91] = $arElement_A["PROPERTY_PRICE_VALUE"];
			$PROP[96] = $arElement_A["PROPERTY_ARTICLE_VALUE"];
			$PROP[107] = $arElement_A["PROPERTY_ACCOUNT_NUMBER_VALUE"];
			$PROP[101][$arElement_A["PROPERTY_OOO_VALUE_ID"]]['in']=$arElement_A["PROPERTY_OOO_VALUE"]['in'];
			$PROP[101][$arElement_A["PROPERTY_OOO_VALUE_ID"]]['out']=$arElement_A["PROPERTY_OOO_VALUE"]['out'];
			$PROP[101][$arElement_A["PROPERTY_OOO_VALUE_ID"]]['col']=$arElement_A["PROPERTY_OOO_VALUE"]['col'];
			$PROP[101][$arElement_A["PROPERTY_OOO_VALUE_ID"]]['yes_m']=$arElement_A["PROPERTY_OOO_VALUE"]['yes_m'];
			$PROP[101][$arElement_A["PROPERTY_OOO_VALUE_ID"]]['yes_a']=$arElement_A["PROPERTY_OOO_VALUE"]['yes_a'];
			$PROP[101][$arElement_A["PROPERTY_OOO_VALUE_ID"]]['com_a']=$arElement_A["PROPERTY_OOO_VALUE"]['com_a'];
			$PROP[101][$arElement_A["PROPERTY_OOO_VALUE_ID"]]['com_m']=$arElement_A["PROPERTY_OOO_VALUE"]['com_m'];
			$PROP[101][$arElement_A["PROPERTY_OOO_VALUE_ID"]]['stat']=$arElement_A["PROPERTY_OOO_VALUE"]['stat'];
			$PROP[101][$arElement_A["PROPERTY_OOO_VALUE_ID"]]['samov']=$arElement_A["PROPERTY_OOO_VALUE"]['samov'];
			$PROP[101][$arElement_A["PROPERTY_OOO_VALUE_ID"]]['moveds']=$arElement_A["PROPERTY_OOO_VALUE"]['moveds'];
			//};
			//$ah = CCatalogStore::GetList(array(),array('UF_V'=>(string)$SHOP_P),false,false,array('NAME','UF_1C','ID'))->GetNext();
			//Изменение позиции при принятии перемещения
			$arElement = CIBlockElement::GetList(Array(),Array("IBLOCK_ID"=>19,"PROPERTY_ARTICLE"=>$article_p,"PROPERTY_C_CODES"=>$code1c,"PROPERTY_OOO" => GPropertyTable::GetColumnFilter("out",$ah['ID'])),false,false,Array("ID","NAME",'PROPERTY_OOO',"DATE_CREATE",'PROPERTY_ORDER'))->GetNext();
			//while($arElement=$rsElements->GetNext()){
			if ($arElement["PROPERTY_OOO_VALUE"]['out']==$ah['ID']){
				$ID_V = $arElement['ID'];
				$PROP[101][$arElement["PROPERTY_OOO_VALUE_ID"]]['in']=$arElement["PROPERTY_OOO_VALUE"]['in'];
				$PROP[101][$arElement["PROPERTY_OOO_VALUE_ID"]]['out']=$arElement["PROPERTY_OOO_VALUE"]['out'];
				$PROP[101][$arElement["PROPERTY_OOO_VALUE_ID"]]['col']=$arElement["PROPERTY_OOO_VALUE"]['col'];
				$PROP[101][$arElement["PROPERTY_OOO_VALUE_ID"]]['yes_m']=$arElement["PROPERTY_OOO_VALUE"]['yes_m'];
				$PROP[101][$arElement["PROPERTY_OOO_VALUE_ID"]]['yes_a']=$arElement["PROPERTY_OOO_VALUE"]['yes_a'];
				$PROP[101][$arElement["PROPERTY_OOO_VALUE_ID"]]['com_a']=$arElement["PROPERTY_OOO_VALUE"]['com_a'];
				$PROP[101][$arElement["PROPERTY_OOO_VALUE_ID"]]['com_m']=$arElement["PROPERTY_OOO_VALUE"]['com_m'];
				$PROP[101][$arElement["PROPERTY_OOO_VALUE_ID"]]['stat']='approved=1';
				$PROP[101][$arElement["PROPERTY_OOO_VALUE_ID"]]['samov']=$arElement["PROPERTY_OOO_VALUE"]['samov'];
				$PROP[101][$arElement["PROPERTY_OOO_VALUE_ID"]]['moveds']=$arElement["PROPERTY_OOO_VALUE"]['moveds'];
			};
			//};
			//Сохранение с учетом перемещения
			$el = new CIBlockElement;
			$arFields = array(
					"IBLOCK_ID"       => '19',
					"NAME"            => $NAME_V,
					"ACTIVE"          => 'Y',
					"PROPERTY_VALUES" => $PROP,
			);
			$res = $el->Update($ID_V, $arFields);
			//Проверка всех статусов
			//Общее количество позици
			$Z=array();
			//Сбор количества статусов - Собран
			$Z2=array();
			//Сбор количества статусов - Отложен
			$Z3=array();
			//Сбор количества статусов - Отложен/Собран
			$Z4=array();
			$rpZZ2xx = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>19,"PROPERTY_ARTICLE"=>$article_p,"PROPERTY_C_CODES"=>$code1c,"PROPERTY_ORDER"=>$ORDER_S), false, false, array("PROPERTY_OOO","ID",'NAME','PROPERTY_ORDER','PROPERTY_NAME_T','PROPERTY_SIZE','PROPERTY_SKLAD_O'));
			while($rpZZ2xxx=$rpZZ2xx->GetNext()){
				$ID_UP = $rpZZ2xxx['ID'];
				//Количество элементов в позиции
				$Z[]=$rpZZ2xxx['PROPERTY_OOO_VALUE']['stat'];
				//Проверяем статусы  - Собран
				if ($rpZZ2xxx['PROPERTY_OOO_VALUE']['stat']=='approved=1'){
					$Z2[]=$rpZZ2xxx['PROPERTY_OOO_VALUE']['stat'];
				};
				//Проверяем статусы  - Отложен
				if ($rpZZ2xxx['PROPERTY_OOO_VALUE']['stat']=='pre_approved=11'){
					$Z3[]=$rpZZ2xxx['PROPERTY_OOO_VALUE']['stat'];
				};
				//Проверяем статусы  - Отложен/Собран
				if ($rpZZ2xxx['PROPERTY_OOO_VALUE']['stat']=='pre_approved=11'||$rpZZ2xxx['PROPERTY_OOO_VALUE']['stat']=='approved=1'){
					$Z4[]=$rpZZ2xxx['PROPERTY_OOO_VALUE']['stat'];
				};
			};
			$Zc=count($Z);
			$Z2c=count($Z2);
			$Z3c=count($Z3);
			$Z4c=count($Z4);
			$PROP=array();
			if ($Z3c==$Zc) {
				//Если все колличество позиции в статусе - Отложен
				$PROP[94]=89;
			} else if ($Zc==$Z2c){
				//Если все колличество позиции в статусе - Собран
				$PROP[94]=90;
				//Для конкретного случая - проверяем все статусы позиций в заказе (для изменения общего статуса)
			} else if ($Zc==$Z4c) {
				$PROP[94]=89;
			} else if (in_array("denied=2", $Z)) {
				//Если хотя бы одна единица в статусе - Отменен
				$PROP[94]=92;
			} else if (in_array("Pre_denied=22", $Z)) {
				//Если хотя бы одна единица в статусе - Нет в наличии
				$PROP[94]=91;
			};
			CIBlockElement::SetPropertyValuesEx($ID_UP, false, $PROP);
			//Получаем общее колличество единиц в заказе если была разбивка по складам
			$STAT_Z_ALL=array();
			//Получаем общее колличество единиц в заказе если была разбивка по складам (статус - отложен)
			$STAT_Z_OT=array();
			//Получаем общее колличество единиц в заказе если была разбивка по складам (статус - собран)
			$STAT_Z_SB=array();
			//Получаем общее колличество единиц в заказе если была разбивка по складам (статус - нет в наличии)
			$STAT_Z_EX=array();
			$STAT_Z = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>19,"PROPERTY_ORDER"=>$ORDER_S), false, false, array("PROPERTY_O_STAT","ID"));
			while($STAT_Z_Z=$STAT_Z->GetNext()){
				if ($STAT_Z_Z['PROPERTY_O_STAT_ENUM_ID']==90){
					$STAT_Z_SB[]=$STAT_Z_Z['PROPERTY_O_STAT_ENUM_ID'];
				};
				if ($STAT_Z_Z['PROPERTY_O_STAT_ENUM_ID']==89||$STAT_Z_Z['PROPERTY_O_STAT_ENUM_ID']==90){
					$STAT_Z_OT[]=$STAT_Z_Z['PROPERTY_O_STAT_ENUM_ID'];
				};
				if ($STAT_Z_Z['PROPERTY_O_STAT_ENUM_ID']==91){
					$STAT_Z_EX[]=$STAT_Z_Z['PROPERTY_O_STAT_ENUM_ID'];
				};
				$STAT_Z_ALL[] = $STAT_Z_Z;
			};
			$STAT_Z_ALL_NUM = count($STAT_Z_ALL);
			$STAT_Z_SB_NUM = count($STAT_Z_SB);
			$STAT_Z_OT_NUM = count($STAT_Z_OT);
			if ($STAT_Z_ALL_NUM==$STAT_Z_SB_NUM){
				//Изменение общего статуса заказа на собран
				$STATUS_Z = 'SZ';//16 - в старой системе
			} else if ($STAT_Z_ALL_NUM==$STAT_Z_OT_NUM) {
				//Изменение общего статуса заказа на отложен
				$STATUS_Z = 'OT';//16 - в старой системе
			} else if ($STAT_Z_EX!=false){
				$STATUS_Z = 'NZ';//18 - в старой системе
			} else {
				$STATUS_Z = 'N';//18 - в старой системе
			};
			//$STATUS_Z = 'F';//3 - в старой системе
			if (isset($STATUS_Z)){
				CSaleOrder::StatusOrder($ORDER_S, $STATUS_Z);
			};
		};
		rename('ftp://sneake01_ftp:6BjvOObrXT@ftp.sneake01.nichost.ru/fromHC/bitrix/'.$filename, 'ftp://sneake01_ftp:6BjvOObrXT@ftp.sneake01.nichost.ru/fromHC/bitrix/'.$filename.'_'.date("Y-m-d H:i:s"));
	};
	//};
};
*/





?>