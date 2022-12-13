<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$this->setFrameMode(true);?>
<div class="project detail">
	<?// element name?>
	<?if($arParams["DISPLAY_NAME"] != "N" && strlen($arResult["NAME"])):?>
		<h2><?=$arResult["NAME"]?></h2>
	<?endif;?>
	
	<div class="row">
		<?if($arResult["GALLERY"]){?>
			<div class="col-md-6 item_slider">
				<div class="thmb flexslider unstyled" id="slider">
					<ul class="slides">					
						<?foreach( $arResult["GALLERY"] as $key => $arPhoto ){?>
							<li id="photo-<?=$key?>" <?=$key == 0 ? 'class="current"' : ''?> data-thumb="<?=$arPhoto["THUMB"]["src"]?>">
								<a href="<?=$arPhoto["DETAIL"]["SRC"]?>" target="_blank" alt="<?=($arPhoto["TITLE"]["DESCRIPTION"] ? $arPhoto["TITLE"]["DESCRIPTION"] : $arResult["NAME"])?>" title="<?=($arPhoto["TITLE"]["DESCRIPTION"] ? $arPhoto["TITLE"]["DESCRIPTION"] : $arResult["NAME"])?>" rel="item_slider" class="fancybox">
									<span class="lupa" style="display: none;" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>"></span>
									<img border="0" class="img-responsive inline" src="<?=$arPhoto["PREVIEW"]["src"]?>" alt="<?=($arPhoto["TITLE"]["DESCRIPTION"] ? $arPhoto["TITLE"]["DESCRIPTION"] : $arResult["NAME"])?>" title="<?=($arPhoto["TITLE"]["DESCRIPTION"] ? $arPhoto["TITLE"]["DESCRIPTION"] : $arResult["NAME"])?>" />
								</a>
							</li>
						<?}?>
						<?if( count($arResult["GALLERY"] ) == 0 ){?>
							<li class="current">
								<img border="0" class="img-responsive inline" src="<?=SITE_TEMPLATE_PATH?>/images/noimage.png" alt="<?=($arPhoto["TITLE"]["DESCRIPTION"] ? $arPhoto["TITLE"]["DESCRIPTION"] : $arResult["NAME"])?>" title="<?=($arPhoto["TITLE"]["DESCRIPTION"] ? $arPhoto["TITLE"]["DESCRIPTION"] : $arResult["NAME"])?>" />
							</li>
						<?}?>
					</ul>
					<?/*if( count($arResult["GALLERY"] ) > 1 ){?>
						<div class="thumbs">
							<div class="row item">
								<?foreach( $arResult["GALLERY"] as $key => $arPhoto ){?>
									<div class="col-md-4 col-sm-3 thumb">
										<div class="item <?=$key == 0 ? 'current' : ''?>">
											<a href="#photo-<?=$key?>">
												<img border="0" src="<?=$arPhoto["THUMB"]["src"]?>" alt="<?=($arPhoto["TITLE"]["DESCRIPTION"] ? $arPhoto["TITLE"]["DESCRIPTION"] : $arResult["NAME"])?>" title="<?=($arPhoto["TITLE"]["DESCRIPTION"] ? $arPhoto["TITLE"]["DESCRIPTION"] : $arResult["NAME"])?>" />
											</a>
										</div>
									
									</div>
								<?}?>
							</div>
						</div>
					<?}*/?>
				</div>
				<?if( count($arResult["GALLERY"] ) > 1 ){?>
					<div class="thmb flexslider unstyled " id="carousel">
						<ul class="slides">	
							<?foreach( $arResult["GALLERY"] as $key => $arPhoto ){?>
								<li>
									<img class="img-responsive inline" border="0" src="<?=$arPhoto["THUMB"]["src"]?>" alt="<?=($arPhoto["TITLE"]["DESCRIPTION"] ? $arPhoto["TITLE"]["DESCRIPTION"] : $arResult["NAME"])?>" title="<?=($arPhoto["TITLE"]["DESCRIPTION"] ? $arPhoto["TITLE"]["DESCRIPTION"] : $arResult["NAME"])?>" />
								</li>
							<?}?>
						</ul>
					</div>
				<?}?>
			</div>
		<?}?>
		<?if( $arResult["CHARACTERISTICS"] ){?>
			<div class="col-md-6 props">
				<h6 class="title"><?=GetMessage("TITLE_PROP")?></h6>
				<div class="wrap">
					<table>
						<?foreach( $arResult["CHARACTERISTICS"] as $arProp){?>
							<tr class="prop">
								<td class="title"><div><?=$arProp["NAME"]?>:</div></td>
								<td class="value">
									<div>
										<?if(is_array($arProp["DISPLAY_VALUE"])){
											foreach($arProp["DISPLAY_VALUE"] as $key => $value) { if ($arProp["DISPLAY_VALUE"][$key+1]) {echo $value.", ";} else {echo $value;} }} 
										else{ 
											if($arProp["CODE"] == "SITE"){?>
												<!--noindex-->
												<a href="<?=$arProp["VALUE"];?>" target="_blank" rel="nofollow"><?=$arProp["VALUE"];?></a>
												<!--/noindex-->
											<?}else{
												echo $arProp["DISPLAY_VALUE"]; 
											}
										}
										?>
									</div>
								</td>
							</tr>
						<?}?>
					</table>
				</div>
			</div>
		<?}?>
		<?if( $arResult["DETAIL_TEXT"] ){?>
			<div class="detail">
				<h6 class="title"><?=GetMessage("TITLE_DETAIL")?></h6>
				<div class="text"><?=$arResult["DETAIL_TEXT"];?></div>
			</div>
		<?}?>
	</div>
	<?if($arResult["PROPERTIES"]["FORM_PROJECT"]["VALUE_XML_ID"]=="YES"){?>
		<div class="styled-block project">
			<div class="row">
				<div class="col-md-3 col-sm-3 valign">
					<span class="btn btn-primary btn-sm" data-event="jqm" data-param-id="<?=CCache::$arIBlocks[SITE_ID]["aspro_allcorp_form"]["aspro_allcorp_order_project"][0]?>" data-autoload-project="<?=$arResult["NAME"]?>" data-name="project"><span><?=GetMessage("TO_CALL")?></span></span>
				</div>
				<div class="col-md-9 col-sm-9 valign">
					<div class="right">
						<?$APPLICATION->IncludeComponent(
							 "bitrix:main.include",
							 "",
							 Array(
								  "AREA_FILE_SHOW" => "file",
								  "PATH" => SITE_DIR."include/ask_project.php",
								  "EDIT_TEMPLATE" => ""
							 )
						);?>
					</div>
				</div>
			</div>
		</div>
	<?}?>
	
	<?if( !empty( $arResult["PROPERTIES"]["LINK_PROJECTS"]["VALUE"] ) && in_array("LINK_PROJECTS", $arParams["PROPERTY_CODE"])):?>
		<?// projects links?>
		<?$arProjects = CCache::CIBlockElement_GetList(array("CACHE" => array("TAG" => CCache::GetIBlockCacheTag(CCache::$arIBlocks[SITE_ID]["aspro_allcorp_content"]["aspro_allcorp_projects"][0]), "MULTI" => "Y")), array("ID" => $arResult["PROPERTIES"]["LINK_PROJECTS"]["VALUE"], "ACTIVE" => "Y", "GLOBAL_ACTIVE" => "Y", "ACTIVE_DATE" => "Y"), false, false, array("ID", "NAME", "DETAIL_PAGE_URL", "PREVIEW_PICTURE", "DETAIL_PICTURE"));?>
		<div class="wraps nomargin">
			<h4><?=GetMessage("T_PROJECTS")?></h4>
			<div class="row projects">
				<div class="col-md-12"><h4><?=GetMessage("LINK_PROJECTS")?></h4></div>
				<?foreach($arProjects as $arProject):?>
					<div class="col-md-4 col-sm-6 project">
						<div class="item">
							<?$thumb = CFile::GetPath($arProject["PREVIEW_PICTURE"] ? $arProject["PREVIEW_PICTURE"] : $arProject["DETAIL_PICTURE"]);?>
							<a href="<?=$arProject["DETAIL_PAGE_URL"]?>" class="fancybox" rel="gallery" title="<?=$arProject["NAME"]?>">
								<?if($thumb):?>
									<img src="<?=$thumb?>" class="img-responsive inline" alt="<?=$arProject["NAME"]?>"/>
								<?else:?>
									<img src="<?=SITE_TEMPLATE_PATH?>/images/noimage.png" class="img-responsive inline" alt="<?=$arProject["NAME"]?>"/>
								<?endif;?>
								<div class="text">
									<span class="icons"></span>
									<div class="title"><?=$arProject["NAME"]?></div>
								</div>
							</a>
						</div>
					</div>
				<?endforeach;?>
			</div>
		</div>
		<script>
		$(document).ready(function(){
			if($(document).width() > 980){
				setTimeout(function(){
					$('.detail.project .row.projects img').sliceHeight({ slice: 3 });
					$('.detail.project .row.projects .text').sliceHeight({ slice: 3 });
				}, 100)
			}
		});
		</script>
	<?endif;?>
	
	<div class="row bottom">
		<div class="col-md-6 back">
			<a href="<?=$arResult["LIST_PAGE_URL"];?>" title="<?=GetMessage("BACK")?>" ><i class="icon icon-chevron-left bg"></i><?=GetMessage("BACK")?></a>
		</div>
		<?if($arParams['USE_SHARE'] == 'Y'):?>
			<div class="col-md-6 text-right share">
				<span class="text"><?=GetMessage('SHARE_TEXT')?></span>
				<script type="text/javascript">
				$(document).ready(function() {
					var script = document.createElement('script');
					script.type = 'text/javascript';
					script.src = '//yandex.st/share/share.js';
					$('.detail').append(script);
				});
				</script>
				<?/*<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>*/?>
				<span class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir"></span>
			</div>
		<?endif;?>
	</div>
	
	<?
	$frame = $this->createFrame('video')->begin('');
	$frame->setAnimation(true);
	?>
	<?// video?>
	<?if($arResult['VIDEO']):?>
		<div class="wraps">
			<h4 class="underline"><?=(strlen($arParams['T_VIDEO']) ? $arParams['T_VIDEO'] : GetMessage('T_VIDEO'))?></h4>
			<div class="row video">
				<?foreach($arResult['VIDEO'] as $i => $arVideo):?>
					<div class="col-md-6 item">
						<div class="video_body">
							<video id="js-video_<?=$i?>" width="350" height="217"  class="video-js" controls="controls" preload="metadata" data-setup="{}">
								<source src="<?=$arVideo["path"]?>" type='video/mp4' />
								<p class="vjs-no-js">
									To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video
								</p>
							</video>
						</div>
						<div class="title"><?=(strlen($arVideo["title"]) ? $arVideo["title"] : $i)?></div>
					</div>
				<?endforeach;?>
			</div>
		</div>
	<?endif;?>
	<?$frame->end();?>
</div>