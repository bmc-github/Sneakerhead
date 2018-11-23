<? header('Content-type: application/json');
require_once ($_SERVER['DOCUMENT_ROOT'] .
    "/bitrix/modules/main/include/prolog_before.php");

//Флаг восстановления пароля
$r = $_POST['RESTORE'];


$login = htmlspecialchars($_POST['USER_LOGIN']);
$pass = htmlspecialchars($_POST['USER_PASSWORD']);
global $USER;
global $APPLICATION;


$filter = array("ACTIVE" => "Y", "=EMAIL" => $login);
$sql = CUser::GetList(($by = "id"), ($order = "desc"), $filter);


if ($sql->NavNext(true, "f_")) {


    if ($r == 0) {


        if (!is_object($USER))
            $USER = new CUser;
        $login = $f_LOGIN;
        $arAuthResult = $USER->Login($login, $pass, "Y");
        $APPLICATION->arAuthResult = $arAuthResult;

        if ($arAuthResult["TYPE"] == 'ERROR' && $arAuthResult["ERROR_TYPE"] == 'LOGIN') {
            $arResult['error'] = 'Неверный логин или пароль';
        } else {
            $arResult['success'] = $arAuthResult;
        }


    } else {

        /*Восстановление пароля */
        $filter = array("ACTIVE" => "Y", "=EMAIL" => $login);
        $sql = CUser::GetList(($by = "id"), ($order = "desc"), $filter);


        $id_user = $f_ID;

        $pass = substr(md5(mt_rand()), 0, 7);


        $USER->Update($id_user, array("PASSWORD" => $pass));
        $arResult['success'] = 'Пароль для пользователя с логином ' . $login .
            ' был успешно изменен. Новый пароль отправлен на электронную почту.';


        $mailFields = array('USERNAME' => $login, 'PASSWORD' => $pass);


        /* дальше используем метод CEvent::Send() или CEvent::SendImmediate()*/

        CEvent::SendImmediate('USER_PASS_REQUEST', "s1", $mailFields, 'N', 3);

    }

} else {

    //

    $arResult['error'] = 'Пользователь с указанным email не найден';


}
echo json_encode($arResult);



?>