<?if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true ) die();?>
<?$this->setFrameMode(true);?>
<?
if($arParams["DISPLAY_PICTURE"] != "N"){
	$arPicture = ($arResult["FIELDS"]["DETAIL_PICTURE"] ? $arResult["FIELDS"]["DETAIL_PICTURE"] : $arResult["FIELDS"]["PREVIEW_PICTURE"]);
	if($arPicture){
		$arImgs[] = array(
			"DETAIL" => $arPicture,
			//"PREVIEW" => CFile::ResizeImageGet($arPicture["ID"], array('width' => 300, 'height' => 300), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true)
		);
	}
	/*if($arResult["PROPERTIES"]["GALLERY"]["VALUE"]){
		foreach($arResult["PROPERTIES"]["GALLERY"]["VALUE"] as $arImg){
			$arImgs[] = array(
				"DETAIL" => CFile::GetFileArray($arImg),
				"PREVIEW" => CFile::ResizeImageGet($arImg, array('width' => 300, 'height' => 300), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true),
			);
		}
	}*/
}
?>
<div class="detail <?=($templateName = $component->{"__parent"}->{"__template"}->{"__name"})?>">
	<article>
		<?// images?>
		<?if($arImgs):?>
			<div class="image image-right bordered col-md-3 col-sm-3 col-xs-12">
				<?// images slider?>
				<?/*
				<div class="flexslider" data-plugin-options='{"directionNav":false, "animation":"slide", "slideshow": false}'>
					<ul class="slides">
						<?foreach($arImgs as $arImg):?>
							<li>
								<a class="img-thumbnail fancybox" href="<?=$arImg["DETAIL"]["SRC"]?>" rel="galery">
									<img class="img-rounded" src="<?=$arImg["PREVIEW"]["src"]?>" border="0" width="<?=$arImg["PREVIEW"]["width"]?>" height="<?=$arImg["PREVIEW"]["height"]?>" alt="<?=$arImg["DETAIL"]["ALT"]?>" title="<?=$arImg["DETAIL"]["TITLE"]?>" />
									<span class="zoom"><i class="icon icon-16 icon-white-shadowed icon-search"></i></span>
								</a>
							</li>
						<?endforeach;?>
					</ul>
				</div>
				*/?>
				<?// or single detail image?>
				<?if($arImgs):?>
					<img src="<?=$arImgs[0]["DETAIL"]["SRC"]?>" alt="<?=$arImgs[0]["DETAIL"]["ALT"]?>" title="<?=$arImgs[0]["DETAIL"]["TITLE"]?>" class="img-responsive" />
				<?endif;?>
			</div>
		<?endif;?>
		
		<?// date active from or dates period active?>
		<?if(strlen($arResult["DISPLAY_PROPERTIES"]["PERIOD"]["VALUE"]) || ($arResult["DISPLAY_ACTIVE_FROM"] && in_array("DATE_ACTIVE_FROM", $arParams["FIELD_CODE"]))):?>
			<div class="period">
				<?if(strlen($arResult["DISPLAY_PROPERTIES"]["PERIOD"]["VALUE"])):?>
					<span class="label label-info"><?=$arResult["DISPLAY_PROPERTIES"]["PERIOD"]["VALUE"]?></span>
				<?else:?>
					<span class="label"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></span>
				<?endif;?>
			</div>
		<?endif;?>
		
		<div class="post-content">
			<?if($arParams["DISPLAY_NAME"] != "N" && strlen($arResult["NAME"])):?>
				<h2><?=$arResult["NAME"]?></h2>
			<?endif;?>
			<div class="content">
				<?// text?>
				<?if(strlen($arResult["FIELDS"]["PREVIEW_TEXT"].$arResult["FIELDS"]["DETAIL_TEXT"])):?>
					<div class="text">
						<?if($arResult["PREVIEW_TEXT_TYPE"] == "text"):?>
							<p><?=$arResult["FIELDS"]["PREVIEW_TEXT"];?></p>
						<?else:?>
							<?=$arResult["FIELDS"]["PREVIEW_TEXT"];?>
						<?endif;?>
						<?if($arResult["DETAIL_TEXT_TYPE"] == "text"):?>
							<p><?=$arResult["FIELDS"]["DETAIL_TEXT"];?></p>
						<?else:?>
							<?=$arResult["FIELDS"]["DETAIL_TEXT"];?>
						<?endif;?>
					</div>
				<?endif;?>
				
				<?// display properties?>
				<?if($arResult["DISPLAY_PROPERTIES"]):?>
					<div class="properties">
						<?foreach($arResult["DISPLAY_PROPERTIES"] as $PCODE => $arProperty):?>
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
			</div>
		</div>
	</article>
</div>