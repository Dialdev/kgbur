<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$this->setFrameMode(true);?>
<div class="item-views <?=$arParams["VIEW_TYPE"]?> <?=($arParams["IMAGE_POSITION"] ? "image_".$arParams["IMAGE_POSITION"] : "")?> <?=($templateName = $component->{"__parent"}->{"__template"}->{"__name"})?>">
	<?// top pagination?>
	<?if($arParams["DISPLAY_TOP_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?>
	<?endif;?>

	<?if($arResult["SECTIONS"]):?>
		<div class="group-content">
			<?// group elements by sections?>
			<?foreach($arResult["SECTIONS"] as $si => $arSection):?>

				<?if($arParams["SHOW_SECTION_PREVIEW_DESCRIPTION"] == "Y"):?>
					<?// section name?>
					<?if(strlen($arSection["NAME"])):?>
						<h4><?=$arSection["NAME"]?></h4>
					<?endif;?>
					
					<?// section description text/html?>
					<?if(strlen($arSection["DESCRIPTION"])):
						if($arSection["DESCRIPTION_TYPE"] == "text"):?>
							<p><?=$arSection["DESCRIPTION"]?></p>
						<?else:?>
							<p><?=$arSection["DESCRIPTION"]?></p>
						<?endif;?>
					<?endif;?>
				<?endif;?>
				
				<?// show section items?>
				<?$iCnt = 0;?>
				<?foreach($arSection["ITEMS"] as $i => $arItem):?>
					<?
					// edit/add/delete buttons for edit mode
					$this->AddEditAction($arItem["ID"], $arItem["EDIT_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($arItem["ID"], $arItem["DELETE_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage("CT_BNL_ELEMENT_DELETE_CONFIRM")));
					// use detail link?
					$bDetailLink = !($arParams["HIDE_LINK_WHEN_NO_DETAIL"] == "Y" && !strlen($arItem["DETAIL_TEXT"]));
					// show preview picture?
					$bPreviewPicture = in_array("PREVIEW_PICTURE", $arParams["FIELD_CODE"]);
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
						
						<?// element preview text?>
						<?if(strlen($arItem["PREVIEW_TEXT"])):?>
							<?if($arItem["PREVIEW_TEXT_TYPE"] == "text"):?>
								<p><?=$arItem["PREVIEW_TEXT"]?></p>
							<?else:?>
								<?=$arItem["PREVIEW_TEXT"]?>
							<?endif;?>
						<?endif;?>
						<?// element display properties?>
						<?if($arItem["DISPLAY_PROPERTIES"]):?>
							<div class="properties">
								<?foreach($arItem["DISPLAY_PROPERTIES"] as $PCODE => $arProperty):?>
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
					
					<?if($arParams["VIEW_TYPE"] == "list"):?>
						<div id="<?=$this->GetEditAreaId($arItem["ID"])?>" class="item">
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
					<?elseif($arParams["VIEW_TYPE"] == "table"):?>
						<?if(!($iCnt % $arParams["COUNT_IN_LINE"])):?>
							<div class="row sid-<?=$arSection["ID"]?>">
						<?endif;?>
							<div class="col-md-<?=floor(12 / $arParams["COUNT_IN_LINE"])?> col-sm-<?=floor(12 / round($arParams["COUNT_IN_LINE"] / 2))?>" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
								<div class="item">
									<?if(!in_array("PREVIEW_PICTURE", $arParams["FIELD_CODE"])):?>
										<div class="col-md-12"><div class="text"><?=$textPart?></div></div>
									<?else:?>
										<?=$imagePart?>
										<div class="text"><?=$textPart?></div>
									<?endif;?>
								</div>
							</div>
						<?if((($iCnt % $arParams["COUNT_IN_LINE"]) == ($arParams["COUNT_IN_LINE"] - 1)) || (($iCnt + 1) == count($arSection["ITEMS"]))):?>
							</div>
						<?endif;?>
						<?++$iCnt;?>
					<?endif;?>
					
				<?endforeach;?>
				
				<?// slice elements height?>
				<?if($arParams["VIEW_TYPE"] == "table"):?>
					<script>
					var templateName = '<?=$templateName?>';
					$(document).ready(function(){
						setTimeout(function(){
							$(".table." + templateName + " .row.sid-<?=$arSection["ID"]?> .image").sliceHeight({slice: <?=$arParams["COUNT_IN_LINE"]?>, lineheight:-3});
							$(".table." + templateName + " .row.sid-<?=$arSection["ID"]?> .text").sliceHeight({slice: <?=$arParams["COUNT_IN_LINE"]?>});
						}, 500)
					})
					</script>
				<?endif;?>
			<?endforeach;?>
		</div>
	<?endif;?>

	<?// bottom pagination?>
	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?>
	<?endif;?>
</div>