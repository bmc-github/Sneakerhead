<?require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
  CModule::IncludeModule("iblock");
  CModule::IncludeModule("catalog");
        
  $result["order_sum"] = 0;
  $dbBasket = CSaleBasket::GetList(($by="NAME"), ($order="ASC"), array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL"));
  while ($resBasket = $dbBasket->GetNext()){
            #CSaleBasket::UpdatePrice($resBasket["ID"], $resBasket["CALLBACK_FUNC"], $resBasket["MODULE"], $resBasket["PRODUCT_ID"], $resBasket["QUANTITY"]);
 
            $resUpdateBasket = CSaleBasket::GetByID($resBasket["ID"]);
 
            // считаем сумму всего заказа
            $result["order_sum"] = $result["order_sum"] + ($resUpdateBasket["QUANTITY"]*$resUpdateBasket["PRICE"]);
 
            // текущий элемент
            if($_REQUEST["BASKET_ID"] == $resBasket["ID"]){
                $result["basket_element"]["price"] = $resUpdateBasket["PRICE"];
                $result["basket_element"]["sum"] = ($resUpdateBasket["QUANTITY"]*$resUpdateBasket["PRICE"]);
                $result["basket_element"]["quantity"] = IntVal($resUpdateBasket["QUANTITY"]);
            }
  }
 
  $result["basket_element"]["price"] = FormatCurrency($result["basket_element"]["price"], "RUB");
  $result["basket_element"]["sum"] = FormatCurrency($result["basket_element"]["sum"], "RUB");
 
  //$result["order_sum"] = FormatCurrency($result["order_sum"], "RUB");
  echo $result["order_sum"];

?>	
