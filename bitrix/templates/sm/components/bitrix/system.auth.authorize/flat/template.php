<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
  if(!isset($_REQUEST['popup'])){
?>
     <div class="container_login">
       <div class="content">    
<?}?>
        <div class="login-content">
          <a href="/" class="loginpage-logo"></a>
<?if($success){?>
          <div class="success"></div>
<?}?>
          <form name="login" class="login_form" action="/login/" method="post" enctype="multipart/form-data">
            <input type="hidden" name="AUTH_FORM" value="Y" />
            <input type="hidden" name="TYPE" value="AUTH" />
            <input type="hidden" name="RESTORE" id="RESTORE" value="0" />
          <?if(strlen($arResult["BACKURL"]) > 0):?>
            <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
          <?endif?>
          <?foreach ($arResult["POST"] as $key => $value):?>
            <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
          <?endforeach?>

            <table class="login-table">
              <tbody>
                <tr>
                  <td class="new-password hidden-xs"></td>
                  <td>
                    <h2 class="login-title">ВХОД</h2>
                    <div class="login-table-content">
<?if(isset($_REQUEST['popup'])){?>
                      <p>или <a href="javascript:$.fancybox.open({href:'/create-account/?popup=1', wrapCSS:'login-bg',type:'ajax'});">регистрация</a><br>через соцсети</p>
<?}else{?>
                      <p>или <a href="/create-account/">регистрация</a><br>через соцсети</p>
<?}?>
                    </div>
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
                    <div class="login-table-content">
    		      <p>ИЛИ</p>
                    </div>
                  </td>
                  <td></td>
                </tr>
                <tr>
                  <td class="new-password hidden-xs"></td>
                  <td><input class="login-table-inputtext" type="text" name="USER_LOGIN" value="<?=$arResult["LAST_LOGIN"]?>" placeholder="Электронная почта" onblur="var regex = /^([a-zA-Z0-9_.+-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;if(regex.test(this.value)) { try {rrApi.setEmail(this.value);}catch(e){}}" /></td>
                  <td></td>
                </tr>
                <tr>
                  <td class="new-password hidden-xs"></td>
                  <td>
                    <input class="login-table-inputtext" type="password" name="USER_PASSWORD" value="" placeholder="Пароль" />
                    <input class="login-table-inputbutton login_submit_forgot" style="display:none;" type="submit" value="Восстановить пароль" />
                    <div class="new-password hidden-sm hidden-md hidden-lg repair-password" style="width:100%"><span class="forgotten_trigger">Восстановить пароль</span></div>
                  </td>
                  <td class="new-password hidden-xs"><span class="forgotten_trigger">Восстановить пароль</span></td>
                </tr>
<?if($arResult['ERROR_MESSAGE']){?>
		<tr>
		  <td colspan="3">
                    <div class="warning"><?=$arResult['ERROR_MESSAGE']?></div>
                  </td>
		</tr>
<?}?>
                <tr class="login_submit_login">
                  <td class="new-password hidden-xs"></td>
                  <td>
                    <input class="login-table-inputbutton" type="submit" value="Войти" />
<?/*if($arResult["BACKURL"]){?>
		    <input type="hidden" name="redirect" value="<?=$arResult['BACKURL']?>" />
<?}*/?>
                  </td>
                  <td></td>
                </tr>
                <tr>
                  <td class="hidden-xs"></td>
                  <td class="error_container"></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </form>
        </div>

      <script>
        $(document.body).on('click', '.login-table-inputbutton', function(event){
          $('.error_container').html("");
          event.preventDefault();
          var output = $(this).serializeArray();
          var url = $('form[name="login"]').attr('action');
          var backurl = $('form[name="login"]').find('input[name="backurl"]').val();
          $.ajax({
            type: "post",
            data: $('form[name="login"]').serialize(), //{ajaxdata: output},
            url: '/bitrix/templates/.default/ajax/login.php',//url,
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
              if(data.success && location.pathname == '/login/'){
		/*$('form[name="login"]').attr('action',url);
                $('input[name="backurl"]').val(backurl);
                $('.error_container').html(data.success);
                $.fancybox.update();*/
		location.pathname = '/personal/';
              }
            },
            error: function (xhr, ajaxOptions, thrownError){
              console.log(xhr.responseText);
            }
          });
        });
        $('.login_form input').keydown(function(e) {
          if (e.keyCode == 13) {
            $('.login_form').submit();
          }
        });
        $(document.body).on('click', '.forgotten_trigger', function(){
          $('#RESTORE').val(1);
          $('.login_form').attr('action','/forgot_password/');
          $('.login_submit_login').hide();
          $(".login-table-inputtext[name='USER_PASSWORD']").hide();
          $('.login_submit_forgot').show();
          $(".forgotten_trigger").addClass('remember_trigger');
          $(".forgotten_trigger").removeClass('forgotten_trigger');
          $(".remember_trigger").html('Вспомнил<br>пароль');
        });
        $(document.body).on('click', '.remember_trigger', function(){
          $('#RESTORE').val(0);
          $('.login_form').attr('action','/login/');
          $('.login_submit_forgot').hide();
          $('.login_submit_login').show();
          $(".login-table-inputtext[name='USER_PASSWORD']").show();
          $(".remember_trigger").addClass('forgotten_trigger');
          $(".remember_trigger").removeClass('remember_trigger');
          $(".forgotten_trigger").html('Восстановить<br>пароль');
        });
      </script>
      <script>
  	$("#exit-mobile-cross").on("click", function(){
	  $('html').removeClass('fancybox-margin').removeClass('fancybox-lock');
	  $('.fancybox-overlay.fancybox-overlay-fixed').remove()
	});
      </script>

      <script>
<?if (strlen($arResult["LAST_LOGIN"])>0):?>
try{document.login.USER_PASSWORD.focus();}catch(e){}
<?else:?>
try{document.login.USER_LOGIN.focus();}catch(e){}
<?endif?>
      </script>

<?if(!isset($_REQUEST['popup'])){?>
       </div>
     </div>
<?}?>
