<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
        <div id="rec8511508" class="r" style=" " data-animationappear="off" data-record-type="406">
          <div class="t406">
            <div class="t-container_100">   
              <div id="t-carousel8511508" class="t-carousel slide" data-ride="carousel" data-interval="3500">
                <div class="t-carousel__slides">
                  <div class="t-carousel__inner" style="height:650px;">                               
<?foreach(array_reverse($arResult["ITEMS"]) as $i=>$arItem){
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
?>
                    <div class="t-carousel__item item t-carousel__animation_fast<?if($i==0) echo ' active';?>" style="height:650px;background-image:url('<?=$arItem['PREVIEW_PICTURE']?>');" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                      <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">           
                        <div class="t406__table" style="height:650px;">
                          <div class="t406__cell t-align_center t-valign_middle">
                            <div class="t406__bg" data-bgimgfield="img" style="background-image:url('<?=$arItem[DETAIL_PICTURE][SRC]?>');"></div>
                            <div class="t406__overlay" style="background-image:-moz-linear-gradient(top, rgba(0,0,0,.20), rgba(0,0,0,.20)); background-image:-webkit-linear-gradient(top, rgba(0,0,0,0.20), rgba(0,0,0,0.20)); background-image: -o-linear-gradient(top, rgba(0,0,0,0.20), rgba(0,0,0,0.20)); background-image: -ms-linear-gradient(top, rgba(0,0,0,0.20), rgba(0,0,0,0.20));"></div>
                            <div class="t406__textwrapper t-container">
                              <div class="t406__textwrapper__content t-col t-col_8 t-prefix_2">                                
                                <div class="t406__title t-title t-title_md"><?=$arItem["NAME"]?></div>
                                <div class="t406__text t-descr t-descr_lg"><?=$arItem["PREVIEW_TEXT"];?></div>
                                <div class="t406__button-container">
                                  <div class="t406__button-wrapper">
                                    <div class="t406__submit t-btn" style="color:#fff;border:2px solid #fff;border-radius:30px;">Читать</div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </a>          
                    </div>
<?}?>
                  </div>
                  <a class="left t-carousel__control" href="#t-carousel8511508" data-slide="prev">
                    <div class="t-carousel__arrow__wrapper t-carousel__arrow__wrapper_left">
                      <div class="  t-carousel__arrow t-carousel__arrow_left" style="border-color:#fff;"></div>
                    </div>
                  </a>
                  <a class="right t-carousel__control" href="#t-carousel8511508" data-slide="next">
                    <div class="t-carousel__arrow__wrapper t-carousel__arrow__wrapper_right">
                      <div class="  t-carousel__arrow t-carousel__arrow_right" style="border-color:#fff;"></div>
                    </div>
                  </a>        
                  <ol class=" t-carousel__indicators t-carousel__indicators_inside carousel-indicators">                             
                    <li style="background-color:#fff;" class="t-carousel__indicator " data-target="#t-carousel8511508" data-slide-to="9"></li>
                    <li style="background-color:#fff;" class="t-carousel__indicator " data-target="#t-carousel8511508" data-slide-to="8"></li>
                    <li style="background-color:#fff;" class="t-carousel__indicator " data-target="#t-carousel8511508" data-slide-to="7"></li>
                    <li style="background-color:#fff;" class="t-carousel__indicator " data-target="#t-carousel8511508" data-slide-to="6"></li>
                    <li style="background-color:#fff;" class="t-carousel__indicator " data-target="#t-carousel8511508" data-slide-to="5"></li>
                    <li style="background-color:#fff;" class="t-carousel__indicator " data-target="#t-carousel8511508" data-slide-to="4"></li>
                    <li style="background-color:#fff;" class="t-carousel__indicator " data-target="#t-carousel8511508" data-slide-to="3"></li>
                    <li style="background-color:#fff;" class="t-carousel__indicator " data-target="#t-carousel8511508" data-slide-to="2"></li>
                    <li style="background-color:#fff;" class="t-carousel__indicator " data-target="#t-carousel8511508" data-slide-to="1"></li>
                    <li style="background-color:#fff;" class="t-carousel__indicator active" data-target="#t-carousel8511508" data-slide-to="0"></li>
                  </ol>
                </div>    
              </div>
            </div>   
          </div>        
        </div> 