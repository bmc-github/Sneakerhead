<?
header('Content-type: application/json');
require_once ($_SERVER['DOCUMENT_ROOT'] .
    "/bitrix/modules/main/include/prolog_before.php");

function createSalt()
{
    $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
    $numChars = strlen($chars);
    $string = '';
    $length = 10;
    for ($i = 0; $i < $length; $i++) {
        $string .= substr($chars, rand(1, $numChars) - 1, 1);
    }
    return $string;
}


$name = htmlspecialchars($_POST['USER_NAME']);
$email = trim(htmlspecialchars($_POST['USER_EMAIL']));
$pass = createSalt();
$gender = $_POST['GENDER'];

global $USER;
$filter = array("ACTIVE" => "Y", "=EMAIL" => $email);
$sql = CUser::GetList(($by = "id"), ($order = "desc"), $filter);

if ($sql->NavNext(true, "f_")) {
       $arResult['error'] = 'Данный email уже зарегистрирован';
}else{
        $arResult = $USER->Register($email, $name, "", $pass, $pass, $email);
    if ($USER->GetID()) {
        $arResult['success'] = true;
        $arAuthResult = $USER->Login($email, $pass, "Y");
        $user = new CUser;
        $fields = array("PERSONAL_GENDER" => $gender);
        $user->Update($USER->GetID(), $fields);

        $toSend = array(
            "EMAIL" => $email,
            "NAME" => $name,
            "LOGIN" => $email,
            "PASSWORD" => $pass);
        CEvent::SendImmediate("USER_INFO", "s1", $toSend, 'N', 2);

    }
    
}






echo json_encode($arResult);

?>