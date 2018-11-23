<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?

if($arParams["INCLUDE_JS"]=="Y") {
	echo "<script>"; require $_SERVER["DOCUMENT_ROOT"].$templateFolder."/script.js"; echo "</script>";
}

if($arParams["INCLUDE_CSS"]=="Y") {
	echo "<style>"; require $_SERVER["DOCUMENT_ROOT"].$templateFolder."/style.css"; echo "</style>";
}

$arResult["TEMPLATE_IDENTIFIER"] = "GRAIN_TABLES_EDIT_DEFAULT";

foreach($arParams["SETTINGS"]["COLUMNS"] as $index=>$arColumn) {
	if(
		$arColumn["TYPE"]=="link" 
		&& is_array($arColumn["LINK"]) 
		&& $arColumn["LINK"]["DATA_SOURCE"]
		&& GPropertyTable::IsLinksInstalled()
	) {

		$arParams["SETTINGS"]["COLUMNS"][$index]["TEMPLATE_IDENTIFIER"] = "GRAIN_LINKS_EDIT_DEFAULT";
	
		$arParameters = $arColumn["LINK"];
	
		$arParameters["INPUT_NAME"] = "";
		$arParameters["USE_SEARCH"] = in_array($arColumn["INTERFACE"],Array("search","selectsearch"))?"Y":"N";
		$arParameters["USE_SEARCH_COUNT"] = "";
		$arParameters["EMPTY_SHOW_ALL"] = in_array($arColumn["INTERFACE"],Array("select","selectsearch"))?"Y":"N";
		$arParameters["NAME_TRUNCATE_LEN"] = "";
		$arParameters["USE_AJAX"] = $arColumn["INTERFACE"]=="ajax"?"Y":"N";
		$arParameters["VALUE"] = "";
		$arParameters["MULTIPLE"] = $arColumn["MULTIPLE"]=="Y"?"Y":"N";
		$arParameters["ADMIN_SECTION"] = "N";
		$arParameters["LEAVE_EMPTY_INPUTS"] = "N";
		$arParameters["USE_VALUE_ID"] = "N";
		
		$arParameters["INCLUDE_JS"] = $arParams["INCLUDE_JS"];
		$arParameters["INCLUDE_CSS"] = $arParams["INCLUDE_CSS"];
		$arParameters["BIND_DELAY"] = $arParams["BIND_DELAY"]; // just in case, do not affect there, see row_template.php

		$arParameters["SCRIPTS_ONLY"] = "Y";

		$arParams["SETTINGS"]["COLUMNS"][$index]["INSTANCE_IDENTIFIER"] = $GLOBALS["APPLICATION"]->IncludeComponent(
			"grain:links.edit",
			"",
			$arParameters,
			null,
			array('HIDE_ICONS' => 'Y')
		);
			
	}
}

?>

<?if($arParams["MULTIPLE"]=="Y"):?>
	<input type="hidden" name="<?=$arParams["NAME"]?>[GTEMPTY]" value="0" />
<?endif?>

<table class="grain-tables-table-edit" id="grain_table_<?=$arParams["NAME"]?>" cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<?foreach($arParams["SETTINGS"]["COLUMNS"] as $arColumn):?>
				<td>
					<?=$arColumn["LANG"][LANGUAGE_ID]["NAME"]?><?if($arColumn["REQUIRED"]=="Y"):?><span class="grain-tables-table-edit-star-required">*</span><?endif?>
					<?if($arColumn["LANG"][LANGUAGE_ID]["TOOLTIP"]):?>
						<div class="grain-tables-table-edit-tooltip"><?=$arColumn["LANG"][LANGUAGE_ID]["TOOLTIP"]?></div>
					<?endif?>
				</td>
			<?endforeach?>
			<?if($arParams["MULTIPLE"]=="Y"):?><td>&nbsp;</td><td>&nbsp;</td><?endif?>
		</tr>
	</thead>
	<tbody<?if($arParams["MULTIPLE"]=="Y" && !$arParams["VALUE"]):?> style="display: none"<?endif?>>
		<?if($arParams["MULTIPLE"]=="Y"):?>
			<?foreach($arParams["VALUE"] as $value_id=>$arValues):?>
			<tr>
				<?foreach($arParams["SETTINGS"]["COLUMNS"] as $arColumn):?>
					<?
					$name=$arParams["NAME"]."[".$value_id."][".$arColumn["NAME"]."]";
					$id = rand(1000,1000000000);
					$value=$arValues[$arColumn["NAME"]];
					$bTemplate=false;
					?>
					<td<?if($arColumn["TYPE"]=="link" && $arColumn["INSTANCE_IDENTIFIER"]):?> data-grain-links-instance-id="<?=$arColumn["INSTANCE_IDENTIFIER"]?>" data-grain-links-field-id="grain_table_link_field_<?=$id?>" data-grain-links-name="<?=$name?>"<?endif?>>
						<?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/row_template.php")?>
					</td>
				<?endforeach?>
				<td><img src="/bitrix/images/grain.tables/gtables_icon_drag_tablerow.png" width="16" height="16" border="0" alt="<?=GetMessage("GRAIN_TABLES_TE_TEMPLATE_DRAG_ROW")?>" title="<?=GetMessage("GRAIN_TABLES_TE_TEMPLATE_DRAG_ROW")?>" /></td>
				<td><a href="#" onclick="window.top.<?=$arResult["TEMPLATE_IDENTIFIER"]?>.TableRemoveRow(this); return false;" title="<?=GetMessage("GRAIN_TABLES_TE_TEMPLATE_DELETE_ROW")?>"><img src="/bitrix/images/grain.tables/gtables_icon_remove_tablerow.gif" width="16" height="16" border="0" /></a></td>
			</tr>
			<?endforeach?>
		<?else:?>
			<tr>
				<?foreach($arParams["SETTINGS"]["COLUMNS"] as $arColumn):?>
					<?
					$name=$arParams["NAME"]."[".$arColumn["NAME"]."]";
					$id = rand(1000,1000000000);
					if(is_array($arParams["VALUE"]) && array_key_exists($arColumn["NAME"],$arParams["VALUE"]))
						$value=$arParams["VALUE"][$arColumn["NAME"]];
					else
						$value=$arColumn["DEFAULT_VALUE"];
					$bTemplate=false;
					?>
	    			<td>
	    				<?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/row_template.php")?>
	    			</td>
	    		<?endforeach?>
			</tr>
		<?endif?>
	</tbody>
	<?if($arParams["MULTIPLE"]=="Y"):?>
	<tfoot>
		<tr>
			<td colspan="<?=count($arParams["SETTINGS"]["COLUMNS"])+2?>"><a onclick="window.top.<?=$arResult["TEMPLATE_IDENTIFIER"]?>.TableAddRow('<?=$arParams["NAME"]?>','<?=$arParams["USER_FIELDS"]=="Y"?"Y":"N"?>'); return false;" href="#"><img width="16" height="16" border="0" src="/bitrix/images/grain.tables/gtables_icon_add_tablerow.gif">&nbsp;&nbsp;<span><?=GetMessage("GRAIN_TABLES_TE_TEMPLATE_ADD_ROW")?></span></a>
</td>
		</tr>	
	</tfoot>
	<?endif?>
</table>

<?if($arParams["MULTIPLE"]=="Y"):?>
	<table style="display: none">
		<tr id="grain_table_row_template_<?=$arParams["NAME"]?>">
			<?foreach($arParams["SETTINGS"]["COLUMNS"] as $arColumn):?>
				<?
				$name="--NAME--"."[".$arColumn["NAME"]."]";
				$id="--ID--";
				$value=$arColumn["DEFAULT_VALUE"];
				$bTemplate=true;
				?>
				<td<?if($arColumn["TYPE"]=="link" && $arColumn["INSTANCE_IDENTIFIER"]):?> data-grain-links-instance-id="<?=$arColumn["INSTANCE_IDENTIFIER"]?>" data-grain-links-field-id="grain_table_link_field_<?=$id?>" data-grain-links-name="<?=$name?>"<?endif?>>
					<?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/row_template.php")?>
				</td>
			<?endforeach?>
			<td><img src="/bitrix/images/grain.tables/gtables_icon_drag_tablerow.png" width="16" height="16" border="0" alt="<?=GetMessage("GRAIN_TABLES_TE_TEMPLATE_DRAG_ROW")?>" title="<?=GetMessage("GRAIN_TABLES_TE_TEMPLATE_DRAG_ROW")?>" /></td>
			<td><a href="#" onclick="window.top.<?=$arResult["TEMPLATE_IDENTIFIER"]?>.TableRemoveRow(this); return false;" title="<?=GetMessage("GRAIN_TABLES_TE_TEMPLATE_DELETE_ROW")?>"><img src="/bitrix/images/grain.tables/gtables_icon_remove_tablerow.gif" width="16" height="16" border="0" /></a></td>
		</tr>
	</table>
	<script type="text/javascript">
		window.top.<?=$arResult["TEMPLATE_IDENTIFIER"]?>.TableInitSort('<?=$arParams["NAME"]?>','<?=$arParams["USER_FIELDS"]=="Y"?"Y":"N"?>',<?=intval($arParams["BIND_DELAY"])?>);
	</script>
<?endif?>
