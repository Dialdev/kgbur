<?
if($arResult["DISPLAY_PROPERTIES"]["PHOTOS"]["VALUE"]){
	foreach($arResult["DISPLAY_PROPERTIES"]["PHOTOS"]["VALUE"] as $img){
		$arResult["GALLERY"][] = array(
			"DETAIL" => CFile::GetFileArray($img),
			"PREVIEW" => CFile::ResizeImageGet($img, array("width" => 325, "height" => 230), BX_RESIZE_IMAGE_EXACT, true),
		);
	}
}

if($arResult["DISPLAY_PROPERTIES"]){
	$arResult['VIDEO'] = array();
	foreach($arResult["DISPLAY_PROPERTIES"] as $key => $arProp){
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
				unset($arResult["DISPLAY_PROPERTIES"][$key]);
			}
		}
		
	}
}
?>