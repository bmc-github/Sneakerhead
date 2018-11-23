<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if($USER->IsAuthorized()){
header('Location: /personal/orders/');
exit;   
};
  if(!isset($_REQUEST['popup'])){
?>
     <div class="container_login">
       <div class="content">    
<?}?>
         <div class="login-content register-page">
           <a href="/" class="loginpage-logo"></a>
           <h2 class="login-title">Регистрация</h2>
	   <div class="login-table-content">
<?if(isset($_REQUEST['popup'])){?>
             <p>или <a href="javascript:$.fancybox.open({href:'/login/?popup=1',wrapCSS:'login-bg',type:'ajax'});" style="color: #F20113;font-weight: bold;">Вход</a><br>через соцсети</p>
<?}else{?>
             <p>или <a href="/login/" style="color: #F20113;font-weight: bold;">вход</a><br>через соцсети</p>
<?}?>
<?$APPLICATION->IncludeComponent(
    "ulogin:auth",
    "",
    Array(
       "PROVIDERS" => "vkontakte,facebook,twitter",
       "HIDDEN" => "other",
       "TYPE" => "small",
       "SEND_MAIL" => "N",
       "SOCIAL_LINK" => "N",
       "GROUP_ID" => array("5"),
       "ULOGINID1" => "84383a81",
       "ULOGINID2" => "",
       "REDIRECT_PAGE"=>"/"
   ) 
);?>
             <p>или</p>
           </div>
           <form name="register" action="/create-account/" class="login_form" method="post" enctype="multipart/form-data">
<?if($arResult["BACKURL"] <> ''):?>
             <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?endif?>
	     <input type="hidden" name="AUTH_FORM" value="Y" />
	     <input type="hidden" name="TYPE" value="REGISTRATION" />

             <div class="content">
               <table class="login-table form">
                 <tr>
                   <td>
                     <input class="login-table-inputtext" type="text" name="USER_NAME" value="<?=$arResult["USER_NAME"]?>" placeholder="Имя, Отчество:" />
                   </td>
                 </tr>
                 <tr>
                   <td>
		     <input class="login-table-inputtext" type="text" name="USER_EMAIL" value="<?=$arResult["USER_EMAIL"]?>" placeholder="Электронная почта" onblur="var regex = /^([a-zA-Z0-9_.+-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;if(regex.test(this.value)) { try {rrApi.setEmail(this.value);}catch(e){}}" />
                   </td>
                 </tr>
                 <tr>
                   <td>
                     <div class="gender">
                       <input type="radio" value="M" id="male" name="GENDER" checked />
                       <label for="male" class="radio">Мужчина</label>
                       <input type="radio" value="F" id="female" name="GENDER" />
                       <label for="female" class="radio">Женщина</label>
                     </div>
                   </td>
                 </tr>
<?if($arResult['ERROR_MESSAGE']){?>
		 <tr>
                   <td><div class="warning"><?=$arResult['ERROR_MESSAGE']?></div></td>
 		 </tr>
<?}?>            <tr>
		   <td class="error_container"></td>
		 </tr>
		 <tr>
		   <td>
		     <div class="buttons">
		       <input type="hidden" name="agree" value="1" checked="checked" />
		       <input class="login-table-inputbutton" type="submit" value="Продолжить" class="button" />
 		     </div>
		     <p class="text_agree">Нажимая кнопку «Продолжить» или совершая регистрацию через социальную сеть,<br />
                     вы подтверждаете свое согласие с <a href="/privacy/">условиями</a><br />
                     предоставляемых услуг</p>
 		   </td>
		 </tr>
               </table>
             </div>
           </form>
         </div>

         <script>          
          $(document.body).on('click', '.login-table-inputbutton', function(event){
            $('.error_container').html("");
            var output = $('form[name="register"]').serializeArray();
            var url = $('form[name="register"]').attr('action');
	    var backurl = $('form[name="register"]').find('input[name="backurl"]').val();
            $.ajax({
              type: "post",
              data: $('form[name="register"]').serialize(), //{ajaxdata: output},
              url: '/bitrix/templates/.default/ajax/reg.php', //url,
	      dataType:'json',
	      success: function(data){
		console.log(data);
		if(data.error){
		  $('.error_container').html(data.error);
		  $.fancybox.update();
		}
		if(data.success === true){
		  $('.error_container').html(data.success);
		  window.location.reload();
		}
                if(data.success){
		  $('form[name="register"]').attr('action', url);
                  $('input[name="backurl"]').val(backurl);
		  $('.error_container').html(data.success);
		  $.fancybox.update();
		}
	      },
	      error: function (xhr, ajaxOptions, thrownError){
		console.log(xhr.responseText);
	      }
	    });
 	    event.preventDefault();
	    //fbq('track', 'CompleteRegistration');
          });
        </script>



<?if(!isset($_REQUEST['popup'])){?>
      </div>
    </div>
<?}?>