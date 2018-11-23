<? if (stristr($_SERVER['REQUEST_URI'], '/bitrix/admin/sale_order.php')):?>
<td class="adm-list-table-cell" style="text-align: center;vertical-align: initial;padding: 10px;">
                                  <a data-id="<?=$this->id?>" class="pp" onclick="popupOK($(this))" style="cursor: pointer;"><img title="Отправлен" src="/images/send.png"></a>
                  <a data-id="<?=$this->id?>" class="open_popupOT pp" onclick="popupOT($(this))" style="cursor: pointer;"><img title="Отмена заказа" src="/images/cancel.png"></a>
                  <a data-id="<?=$this->id?>" class="open_popupOP pp" onclick="popupOP($(this))" style="cursor: pointer;"><img title="Сумма оплаты" src="/images/coins.png"></a>
                  <a class="open_popupOP pp" target="_blank" href="/bitrix/admin/sale_print.php?PROPS_ENABLE=Y&doc=russianpost-cod&ORDER_ID=<?=$this->id?>" style="cursor: pointer;"><img title="Печать" src="/images/stamp.png"></a>
                              </td>
                             
                              <td class="adm-list-table-cell zzz-<?=$this->id?>" style="text-align: center;vertical-align: initial;padding: 10px;">
                              <span class="num-z"><? if ($this->aFields["DELIVERY_DOC_NUM"]["view"]["value"]!='Нет'):?>
              <?=$this->aFields["DELIVERY_DOC_NUM"]["view"]["value"]?>
              <? endif; ?></span>
              <br/>
              <br/>
                              <span style="border: 1px solid #ccc;padding: 4px 5px;font-weight: bold;display:  block;width:  120px;text-align: center;background: white;">
                              <? if ($this->aFields["DELIVERY_DOC_NUM"]["view"]["value"]!='Нет'):?>
            <a data-id="<?=$this->id?>" style="cursor: pointer;" class="open_popupT" onclick="popupT($(this))">Изменить номер</a></span>
            <? else: ?>
            <a data-id="<?=$this->id?>" style="cursor: pointer;" class="open_popupT" onclick="popupT($(this))">Добавить номер</a></span>
            <? endif; ?>
</td>
<? endif;?>