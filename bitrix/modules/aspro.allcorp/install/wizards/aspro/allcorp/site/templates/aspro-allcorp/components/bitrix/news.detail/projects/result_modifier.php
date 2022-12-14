<?
if( $arParams["DISPLAY_PICTURE"] != "N" ){
	if( is_array( $arResult["DETAIL_PICTURE"] ) ){
		$arResult["GALLERY"][] = array(
			"DETAIL" => $arResult["DETAIL_PICTURE"],
			"PREVIEW" => CFile::ResizeImageGet( $arResult["DETAIL_PICTURE"] , array('width' => 1000, 'height' => 1000), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true ),
			"THUMB" => CFile::ResizeImageGet( $arResult["DETAIL_PICTURE"] , array('width' => 126, 'height' => 86), BX_RESIZE_IMAGE_EXACT, true ),
			"TITLE" => $arResult["DETAIL_PICTURE"]
		);
	}

	if( !empty( $arResult["PROPERTIES"]["PHOTOS"]["VALUE"] ) ){
		foreach( $arResult["PROPERTIES"]["PHOTOS"]["VALUE"] as $img ){
			$arResult["GALLERY"][] = array(
				"DETAIL" => CFile::GetFileArray( $img ),
				"PREVIEW" => CFile::ResizeImageGet( $img, array('width' => 1000, 'height' => 1000), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true ),
				"THUMB" => CFile::ResizeImageGet( $img , array('width' => 126, 'height' => 86), BX_RESIZE_IMAGE_EXACT, true ),
				"TITLE" => CFile::GetFileArray( $img )
			);
		}
	}
}
$arSection=aspro::cacheSection(false, array("ID" => $arResult["IBLOCK_SECTION_ID"]), false, array("ID", "NAME"),true);
$arResult['SECTION_NAME'] = $arSection["NAME"];

$arResult["CHARACTERISTICS"] = array();
if( $arResult['SECTION_NAME'] ){
	$arResult["CHARACTERISTICS"][] = array( "NAME" => GetMessage("SECTION_NAME"), "VALUE" => $arResult['SECTION_NAME'], 'DISPLAY_VALUE' => $arResult['SECTION_NAME']);
}
if($arResult["DISPLAY_PROPERTIES"] ){

	foreach( $arResult["DISPLAY_PROPERTIES"] as $arProp ){
		if(!in_array($arProp["CODE"], array("PHOTOS", "FORM_PROJECT", "LINK_PROJECTS"))){
			if(strlen($arProp["VALUE"]) || $arProp["VALUE"]){
				if( $arProp["CODE"] == "DATE" ){
					$arProp["DISPLAY_VALUE"] = $arProp["VALUE"] = CIBlockFormatProperties::DateFormat($arParams["ACTIVE_DATE_FORMAT"], MakeTimeStamp($arProp["VALUE"], CSite::GetDateFormat()));
				}
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

if( !empty( $arResult["PROPERTIES"]["LINK_PROJECTS"]["VALUE"] ) && in_array("LINK_PROJECTS", $arParams["PROPERTY_CODE"])){
	$arResult["PROJECTS"] = aspro::getIBItems( $arResult["PROPERTIES"]["LINK_PROJECTS"]["VALUE"], "Y");
}
?>