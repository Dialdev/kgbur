<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$this->setFrameMode(true);?>
<div class="item-views list <?=($arParams["IMAGE_POSITION"] ? "image_".$arParams["IMAGE_POSITION"] : "")?> <?=($templateName = $component->{"__parent"}->{"__template"}->{"__name"})?>">
	<?// top pagination?>
	<?if($arParams["DISPLAY_TOP_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?>
	<?endif;?>

	<?if($arResult["ITEMS"]):?>
		<div class="<?=($arParams["SHOW_TABS"] == "Y" ? "tab-content" : "group-content")?>">
			<?// show section items?>
			<?foreach($arResult["ITEMS"] as $i => $arItem):?>
				<?
				// edit/add/delete buttons for edit mode
				$this->AddEditAction($arItem["ID"], $arItem["EDIT_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem["ID"], $arItem["DELETE_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage("CT_BNL_ELEMENT_DELETE_CONFIRM")));
				// use detail link?
				$bDetailLink = !($arParams["HIDE_LINK_WHEN_NO_DETAIL"] == "Y" && !strlen($arItem["DETAIL_TEXT"]));
				// show preview picture?
				$bPreviewPicture = in_array("PREVIEW_PICTURE", $arParams["FIELD_CODE"]);
				// show active date period
				$bActiveDate = strlen($arItem["DISPLAY_PROPERTIES"]["PERIOD"]["VALUE"]) || ($arItem["DISPLAY_ACTIVE_FROM"] && in_array("DATE_ACTIVE_FROM", $arParams["FIELD_CODE"]));
				?>
				
				<?ob_start();?>
					<?// element name?>
					<?if(strlen($arItem["FIELDS"]["NAME"])):?>
						<div class="title">
							<?if(!$bDetailLink):?>
								<?=$arItem["NAME"]?>
							<?else:?>
								<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
							<?endif;?>
						</div>
					<?endif;?>
					
					<?// date active period?>
					<?if($bActiveDate):?>
						<div class="period">
							<?if(strlen($arItem["DISPLAY_PROPERTIES"]["PERIOD"]["VALUE"])):?>
								<span class="label label-info"><?=$arItem["DISPLAY_PROPERTIES"]["PERIOD"]["VALUE"]?></span>
							<?else:?>
								<span class="label"><?=$arItem["DISPLAY_ACTIVE_FROM"]?></span>
							<?endif;?>
						</div>
					<?endif;?>
					
					<?// section title?>
					<?/*if(strlen($arResult["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]]["NAME"])):?>
						<span class="section_name">
							<?=$arResult["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]]["NAME"]?>
						</span>
					<?endif;*/?>
					
					<?// element preview text?>
					<?if(strlen($arItem["FIELDS"]["PREVIEW_TEXT"])):?>
						<?if($arItem["PREVIEW_TEXT_TYPE"] == "text"):?>
							<p><?=$arItem["FIELDS"]["PREVIEW_TEXT"]?></p>
						<?else:?>
							<?=$arItem["FIELDS"]["PREVIEW_TEXT"]?>
						<?endif;?>
					<?endif;?>
										
					<?// element display properties?>
					<?if($arItem["DISPLAY_PROPERTIES"]):?>
						<div class="properties">
							<?foreach($arItem["DISPLAY_PROPERTIES"] as $PCODE => $arProperty):?>
								<?if(in_array($PCODE, array("PERIOD", "TITLE_BUTTON", "LINK_BUTTON"))) continue;?>
								<div class="property">
									<?if($arProperty["XML_ID"]):?>
										<i class="icon <?=$arProperty["XML_ID"]?>"></i>&nbsp;
									<?else:?>
										<?=$arProperty["NAME"]?>:&nbsp;
									<?endif;?>
									<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
										<?$val = implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
									<?else:?>
										<?$val = $arProperty["DISPLAY_VALUE"];?>
									<?endif;?>
									<?if($PCODE == "SITE"):?>
										<!--noindex-->
										<?=str_replace("href=", "rel='nofollow' target='_blank' href=", $val);?>
										<!--/noindex-->
									<?elseif($PCODE == "EMAIL"):?>
										<a href="mailto:<?=$val?>"><?=$val?></a>
									<?else:?>
										<?=$val?>
									<?endif;?>
								</div>
							<?endforeach;?>
						</div>
					<?endif;?>
					<?if($bDetailLink):?>
						<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="btn btn-primary btn-sm"><?=GetMessage("TO_ALL")?>&nbsp;&nbsp;<i class="icon icon-angle-right"></i></a>
					<?endif;?>
				<?$textPart = ob_get_clean();?>
				
				<?if($bPreviewPicture):?>
					<?ob_start();?>
						<div class="image">
							<?if($bDetailLink):?>
								<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
							<?elseif($arItem["FIELDS"]["DETAIL_PICTURE"]):?>
								<a href="<?=$arItem["FIELDS"]["DETAIL_PICTURE"]["SRC"]?>" class="img-inside fancybox">
							<?endif;?>
							
								<?if($arItem["FIELDS"]["PREVIEW_PICTURE"]):?>
									<img src="<?=$arItem["FIELDS"]["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["FIELDS"]["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arItem["FIELDS"]["PREVIEW_PICTURE"]["TITLE"]?>" class="img-responsive" />
								<?else:?>
									<img src="<?=SITE_TEMPLATE_PATH?>/images/noimage.png" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" class="img-responsive" />
								<?endif;?>
								
							<?if($bDetailLink):?>
								</a>
							<?elseif($arItem["FIELDS"]["DETAIL_PICTURE"]):?>
									<span class="zoom"><i class="icon icon-16 icon-white-shadowed icon-search"></i></span>
								</a>
							<?endif;?>
						</div>
					<?$imagePart = ob_get_clean();?>
				<?endif;?>
				
				<div id="<?=$this->GetEditAreaId($arItem["ID"])?>" class="item <?=($bActiveDate ? "wdate" : "")?>">
					<div class="row">
						<?if(!$bPreviewPicture):?>
							<div class="col-md-12"><div class="text"><?=$textPart?></div></div>
						<?elseif($arParams["IMAGE_POSITION"] == "right"):?>
							<div class="col-md-9 col-sm-9 col-xs-12"><div class="text"><?=$textPart?></div></div>
							<div class="col-md-3 col-sm-3 col-xs-12"><?=$imagePart?></div>
						<?else:?>
							<div class="col-md-3 col-sm-3 col-xs-12"><?=$imagePart?></div>
							<div class="col-md-9 col-sm-9 col-xs-12"><div class="text"><?=$textPart?></div></div>
						<?endif;?>
					</div>
				</div>
				<hr />
			<?endforeach;?>
		</div>
	<?endif;?>

	<?// bottom pagination?>
	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?>
	<?endif;?>
	
	<?// section description?>
	<?if(is_array($arResult["SECTION"]["PATH"])):?>
		<?$arCurSectionPath = end($arResult["SECTION"]["PATH"]);?>
		<?if(strlen($arCurSectionPath["DESCRIPTION"]) && strpos($_SERVER["REQUEST_URI"], "PAGEN") === false):?>
			<div class="cat-desc"><?=$arCurSectionPath["DESCRIPTION"]?></div>
		<?endif;?>
	<?endif;?>
</div>