<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */

?>

<script>
    var locationHref = location.href;
    $('.header-categories a').each(function(){
        if (locationHref.indexOf($(this).attr('href')) != -1) {
            $(this).parent().addClass('active');
        }
    });
</script>
