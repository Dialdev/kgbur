<?
if($arParams["DISPLAY_PICTURE"] != "N"){
	if(is_array($arResult["DETAIL_PICTURE"])){
		$arResult["GALLERY"][] = array(
			"DETAIL" => $arResult["DETAIL_PICTURE"],
			"PREVIEW" => CFile::ResizeImageGet($arResult["DETAIL_PICTURE"] , array('width' => 310, 'height' => 255), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true),
			"THUMB" => CFile::ResizeImageGet($arResult["DETAIL_PICTURE"] , array('width' => 86, 'height' => 66), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true),
			"TITLE" => $arResult["DETAIL_PICTURE"],
		);
	}
	
	if(!empty($arResult["PROPERTIES"]["PHOTOS"]["VALUE"])){
		foreach($arResult["PROPERTIES"]["PHOTOS"]["VALUE"] as $img){
			$arResult["GALLERY"][] = array(
				"DETAIL" => CFile::GetFileArray($img),
				"PREVIEW" => CFile::ResizeImageGet($img, array('width' => 310, 'height' => 255), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true),
				"THUMB" => CFile::ResizeImageGet($img , array('width' => 86, 'height' => 66), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true),
				"TITLE" => CFile::GetFileArray($img),
			);
		}
	}
}
$arSection = aspro::cacheSection(false, array("ID" => $arResult["IBLOCK_SECTION_ID"]), false, array("ID", "NAME"), true);
$arResult['SECTION_NAME'] = $arSection["NAME"];

if($arResult["DISPLAY_PROPERTIES"]){
	$arResult["CHARACTERISTICS"] = $arResult['VIDEO'] = array();
	foreach($arResult["DISPLAY_PROPERTIES"] as $arProp){
		if(!in_array($arProp["CODE"], array('PERIOD', 'PHOTOS', 'DOCUMENTS', 'LINK_GOODS', 'LINK_STAFF', 'LINK_REVIEWS', 'LINK_PROJECTS', 'LINK_SERVICES', 'FORM_ORDER', 'FORM_QUESTION', 'PHOTOPOS'))){
			if(strlen($arProp["VALUE"]) || $arProp["VALUE"]){
				if($arProp['USER_TYPE'] == 'video'){
					if (is_array($arProp['VALUE'])) {
						foreach($arProp['VALUE'] as $val){
							if($val['path']){
								$arResult['VIDEO'][] = $val;
							}
						}
					}
					elseif($arProp['VALUE']['path']){
						$arResult['VIDEO'][] = $arProp['VALUE'];
					}					
				}
				else{
					$arResult["CHARACTERISTICS"][] = $arProp;
				}
			}
		}
	}
}

if(!empty($arResult["PROPERTIES"]["LINK_PROJECTS"]["VALUE"])){
	$arResult["PROJECTS"] =aspro:: getIBItems( $arResult["PROPERTIES"]["LINK_PROJECTS"]["VALUE"], "Y");
}
?>