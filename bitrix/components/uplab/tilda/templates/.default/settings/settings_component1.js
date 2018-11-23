function OnMySettingsEdit(arParams)
{
var bigdata = eval("("+arParams.data+")");
var script = document.createElement('script');
script.type = 'text/javascript';
script.src = '/bitrix/components/uplab/tilda/templates/.default/settings/jquery-2.1.4.min.js';
document.getElementsByTagName('head')[0].appendChild(script);
script.addEventListener('load', function(){ 


    $(document).ready(function() {

        set_options = function (id){
            var page = $("[name=PAGE]");
            page.find("option").hide();
            $.each(bigdata[id].pages ,function( key , param ){
                page.find('option[value='+param.id+']').show();
            })
        }

        cl=$('<input>',{
                type:'button',
                value :arParams.propertyParams.CUSTOMLANG[0],
        }).on('click',function(){
            BX.ajax.get('/bitrix/tools/uplab.tilda/uplab_tilda_post.php?clearcache=true', function (res) {
             alert(res);                  
            });
        });

        $('[name=JSDATA]').parent().append(cl);
        //  подгружаем
        id = $('[name=PROJECT] option:selected').val();
        set_options(id);
        // swith
    	$('[name=PROJECT]').change(function() {
    		var id = $(this).val();    		
    		set_options(id);
            var page = $("[name=PAGE]").val('');
    	});


        span = $('<span></span>',{
                id:"clearprojectcache",
                title:arParams.propertyParams.CUSTOMLANG[1],
                style:"display:inline-block;vertical-align:middle;cursor:pointer;height:20px;width:20px;padding:3px 0;background:url('/bitrix/images/uplab.tilda/refresh16.png') center no-repeat;"
        }).on('click',function(){
            $.post("/bitrix/tools/uplab.tilda/uplab_tilda_post.php",{'clearprojectcache':'true','return':'true'}, function( datas ) {

                data = eval("("+datas+")");
                bigdata = data;
                idroj = $('[name=PROJECT] option:selected').val();
                idpage = $('[name=PAGE] option:selected').val();

                $("[name=PROJECT]").find('option').remove();
                $("[name=PAGE]").find('option').remove();
                $.each(data,function(id,val){
                    $("[name=PROJECT]").append(
                        $('<option>',{
                            value:val.id,
                            text:val.title
                        })
                    );
                    $.each(val.pages,function(n,value){
                        $("[name=PAGE]").append(
                            $('<option>',{
                            value:value.id,
                            text:value.title
                            })
                        );
                    });
                });
                set_options(idroj);
                $('[name=PROJECT]').find('option[value='+idroj+']').attr('selected','selected');
                $('[name=PAGE]').find('option[value='+idpage+']').attr('selected','selected');              
            });
        });

        $('[name=PROJECT]').after(span);
    });

}, false);
}