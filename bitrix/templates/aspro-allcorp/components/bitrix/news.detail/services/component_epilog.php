<?// projects links?>
<?if($templateData['LINK_PROJECTS']):?>
	<?$arProjects = CCache::CIBlockElement_GetList(array("CACHE" => array("TAG" => CCache::GetIBlockCacheTag(CCache::$arIBlocks[SITE_ID]["aspro_allcorp_content"]["aspro_allcorp_projects"][0]), "MULTI" => "Y")), array("ID" => $templateData['LINK_PROJECTS'], "ACTIVE" => "Y", "GLOBAL_ACTIVE" => "Y", "ACTIVE_DATE" => "Y"), false, false, array("ID", "NAME", "DETAIL_PAGE_URL", "PREVIEW_PICTURE", "DETAIL_PICTURE"));?>
	<div class="wraps nomargin">
		<h4><?=GetMessage("T_PROJECTS")?></h4>
		<div class="row projects">
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
				$('.detail.services .row.projects img').sliceHeight({ slice: 3 });
				$('.detail.services .row.projects .text').sliceHeight({ slice: 3 });
			}, 100)
		}
	});
	</script>
<?endif;?>

<?// reviews links?>
<?if($templateData['LINK_REVIEWS']):?>
	<?$arRevies = CCache::CIBlockElement_GetList(array("CACHE" => array("TAG" => CCache::GetIBlockCacheTag(CCache::$arIBlocks[SITE_ID]["aspro_allcorp_content"]["aspro_allcorp_reviews"][0]), "MULTI" => "Y")), array("ID" => $templateData['LINK_REVIEWS'], "ACTIVE" => "Y", "GLOBAL_ACTIVE" => "Y", "ACTIVE_DATE" => "Y"), false, false, array("ID", "NAME", "PROPERTY_POST", "PREVIEW_TEXT"));?>
	<div class="wraps nomargin">
		<h4><?=GetMessage("T_REVIEWS")?></h4>
		<div class="row reviews">
			<?$count = count($arRevies);?>
			<?foreach($arRevies as $arReview):?>
				<div class="col-md-12">
					<div class="item">
						<div class="review">
							<div class="row">
								<div class="col-md-2 col-sm-2 col-xs-2 review">
									<span class="icons"></span>
								</div>
								<div class="col-md-10 col-sm-10 col-xs-10 review">
									<?if($arReview["PREVIEW_TEXT"]):?>
										<div class="preview_text"><?=$arReview["PREVIEW_TEXT"];?></div>
									<?endif;?>
								</div>
							</div>
							<div class="borders"></div>
						</div>
						<div class="info">
							<div class="title"><?=$arReview["NAME"]?></div>
							<?if($arReview["PROPERTY_POST_VALUE"]):?>
								<div class="post"><?=$arReview["PROPERTY_POST_VALUE"]?></div>
							<?endif;?>
						</div>
					</div>
				</div>
			<?endforeach;?>
		</div>
	</div>
<?endif;?>

<?// staff links?>
<?if($templateData['LINK_STAFF']):?>
	<div class="wraps nomargin">
		<h4><?=(count($arElement["PROPERTY_LINK_STAFF_VALUE"]) > 1) ? GetMessage("T_STAFF2") : GetMessage("T_STAFF1")?></h4>
		<?global $arrrFilter; $arrrFilter = array("ID" => $templateData['LINK_STAFF']);?>
		<?$APPLICATION->IncludeComponent("bitrix:news.list", "staff-linked", array(
			"IBLOCK_TYPE" => "aspro_allcorp_content",
			"IBLOCK_ID" => CCache::$arIBlocks[SITE_ID]["aspro_allcorp_content"]["aspro_allcorp_staff"][0],
			"NEWS_COUNT" => "30",
			"SORT_BY1" => "SORT",
			"SORT_ORDER1" => "DESC",
			"SORT_BY2" => "",
			"SORT_ORDER2" => "ASC",
			"FILTER_NAME" => "arrrFilter",
			"FIELD_CODE" => array(
				0 => "NAME",
				1 => "PREVIEW_TEXT",
				2 => "PREVIEW_PICTURE",
				3 => "",
			),
			"PROPERTY_CODE" => array(
				0 => "EMAIL",
				1 => "POST",
				2 => "PHONE",
				3 => "",
			),
			"CHECK_DATES" => "Y",
			"DETAIL_URL" => "",
			"AJAX_MODE" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"AJAX_OPTION_HISTORY" => "N",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "360000",
			"CACHE_FILTER" => "Y",
			"CACHE_GROUPS" => "N",
			"PREVIEW_TRUNCATE_LEN" => "",
			"ACTIVE_DATE_FORMAT" => "d.m.Y",
			"SET_TITLE" => "N",
			"SET_STATUS_404" => "N",
			"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
			"ADD_SECTIONS_CHAIN" => "Y",
			"HIDE_LINK_WHEN_NO_DETAIL" => "N",
			"PARENT_SECTION" => "",
			"PARENT_SECTION_CODE" => "",
			"INCLUDE_SUBSECTIONS" => "Y",
			"PAGER_TEMPLATE" => "",
			"DISPLAY_TOP_PAGER" => "N",
			"DISPLAY_BOTTOM_PAGER" => "Y",
			"PAGER_TITLE" => "Новости",
			"PAGER_SHOW_ALWAYS" => "Y",
			"PAGER_DESC_NUMBERING" => "N",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
			"PAGER_SHOW_ALL" => "N",
			"VIEW_TYPE" => "table",
			"SHOW_TABS" => "N",
			"SHOW_SECTION_PREVIEW_DESCRIPTION" => "N",
			"IMAGE_POSITION" => "left",
			"COUNT_IN_LINE" => "3",
			"AJAX_OPTION_ADDITIONAL" => ""
			),
			false, array("HIDE_ICONS" => "N")
		);?>
	</div>
<?endif;?>

<?// goods links?>
<?if($templateData['LINK_GOODS']):?>
	<div class="wraps nomargin">
		<h4><?=GetMessage("T_GOODS")?></h4>
		<?global $arrrFilter; $arrrFilter = array("ID" => $templateData['LINK_GOODS']);?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:news.list",
			"catalog",
			Array(
				"DISPLAY" => "table",
				"VIEW_TYPE" => "table",
				"SHOW_TABS" => "N",
				"SHOW_IMAGE" => "Y",
				"SHOW_NAME" => "Y",
				"SHOW_DETAIL" => "Y",
				"IMAGE_POSITION" => "top",
				"COUNT_IN_LINE" => "3",
				"AJAX_MODE" => "N",
				"IBLOCK_TYPE" => "aspro_allcorp_catalog",
				"IBLOCK_ID" => CCache::$arIBlocks[SITE_ID]["aspro_allcorp_catalog"]["aspro_allcorp_catalog"][0],
				"NEWS_COUNT" => "20",
				"SORT_BY1" => "ACTIVE_FROM",
				"SORT_ORDER1" => "DESC",
				"SORT_BY2" => "SORT",
				"SORT_ORDER2" => "ASC",
				"FILTER_NAME" => "arrrFilter",
				"FIELD_CODE" => array(),
				"PROPERTY_CODE" => array("PRICE", "PRICEOLD"),
				"CHECK_DATES" => "Y",
				"DETAIL_URL" => "",
				"PREVIEW_TRUNCATE_LEN" => "",
				"ACTIVE_DATE_FORMAT" => "d.m.Y",
				"SET_TITLE" => "N",
				"SET_STATUS_404" => "N",
				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"ADD_SECTIONS_CHAIN" => "N",
				"HIDE_LINK_WHEN_NO_DETAIL" => "N",
				"PARENT_SECTION" => "",
				"PARENT_SECTION_CODE" => "",
				"INCLUDE_SUBSECTIONS" => "Y",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "36000000",
				"CACHE_FILTER" => "Y",
				"CACHE_GROUPS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"PAGER_TITLE" => "Новости",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "Y",
				"AJAX_OPTION_HISTORY" => "N"
			),
		false, array("HIDE_ICONS" => "N")
		);?>
	</div>
<?endif;?>

<?// services links?>
<?if($templateData['LINK_SERVICES']):?>
	<div class="wraps nomargin">
		<h4><?=GetMessage("T_SERVICES")?></h4>
		<?global $arrrFilter; $arrrFilter = array("ID" => $templateData['LINK_SERVICES']);?>
		<?$APPLICATION->IncludeComponent("bitrix:news.list", "services", array(
			"IBLOCK_TYPE" => "aspro_allcorp_content",
			"IBLOCK_ID" => CCache::$arIBlocks[SITE_ID]["aspro_allcorp_content"]["aspro_allcorp_services"][0],
			"NEWS_COUNT" => "20",
			"SORT_BY1" => "ACTIVE_FROM",
			"SORT_ORDER1" => "DESC",
			"SORT_BY2" => "SORT",
			"SORT_ORDER2" => "ASC",
			"FILTER_NAME" => "arrrFilter",
			"FIELD_CODE" => array(
				0 => "NAME",
				1 => "PREVIEW_TEXT",
				2 => "PREVIEW_PICTURE",
				3 => "",
			),
			"PROPERTY_CODE" => array(
				0 => "",
				1 => "",
			),
			"CHECK_DATES" => "Y",
			"DETAIL_URL" => "",
			"AJAX_MODE" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"AJAX_OPTION_HISTORY" => "N",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "36000000",
			"CACHE_FILTER" => "Y",
			"CACHE_GROUPS" => "N",
			"PREVIEW_TRUNCATE_LEN" => "",
			"ACTIVE_DATE_FORMAT" => "d.m.Y",
			"SET_TITLE" => "N",
			"SET_STATUS_404" => "N",
			"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
			"ADD_SECTIONS_CHAIN" => "N",
			"HIDE_LINK_WHEN_NO_DETAIL" => "N",
			"PARENT_SECTION" => "",
			"PARENT_SECTION_CODE" => "",
			"INCLUDE_SUBSECTIONS" => "Y",
			"PAGER_TEMPLATE" => ".default",
			"DISPLAY_TOP_PAGER" => "N",
			"DISPLAY_BOTTOM_PAGER" => "Y",
			"PAGER_TITLE" => "Новости",
			"PAGER_SHOW_ALWAYS" => "N",
			"PAGER_DESC_NUMBERING" => "N",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
			"PAGER_SHOW_ALL" => "N",
			"VIEW_TYPE" => "list",
			"SHOW_TABS" => "N",
			"SHOW_IMAGE" => "Y",
			"SHOW_NAME" => "Y",
			"SHOW_DETAIL" => "Y",
			"IMAGE_POSITION" => "top",
			"COUNT_IN_LINE" => "3",
			"AJAX_OPTION_ADDITIONAL" => ""
			),
		false, array("HIDE_ICONS" => "N")
		);?>
	</div>
<?endif;?>