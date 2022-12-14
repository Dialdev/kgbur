<?
IncludeModuleLangFile(__FILE__);

if(!class_exists("aspro")){
	class aspro{
		function cacheElement($arOrder = Array("SORT"=>"ASC"), $arrFilter = Array(), $arGroupBy = false, $arNavStartParams = false, $arSelectFields = Array(), $tag_cache = ""){
			if(!is_array($arOrder)){
				$arOrder = Array("SORT" => "ASC");
			}

			CModule::IncludeModule('iblock');

			$cache = new CPHPCache();
			$cache_time = 250000;
			$cache_path = 'aspro_cache_element';

			$cache_id = 'aspro_cache_element_'.serialize($arOrder).serialize($arrFilter).serialize($arGroupBy).serialize($arNavStartParams).serialize($arSelectFields);
			if(COption::GetOptionString("main", "component_cache_on", "Y") == "Y" && $cache->InitCache($cache_time, $cache_id, $cache_path)){
				$res = $cache->GetVars();
				$arRes = $res["arRes"];
			}else{
				$rsRes = CIBlockElement::GetList($arOrder, $arrFilter, $arGroupBy, $arNavStartParams, $arSelectFields);
				while($obj = $rsRes->GetNextElement()){
					$res = $obj->GetFields();
					$res["PROPERTIES"] = $obj->GetProperties();
					$arRes[$res["ID"]] = $res;
				}
				if(COption::GetOptionString("main", "component_cache_on", "Y") == "Y" && $cache_time > 0){
					$cache->StartDataCache($cache_time, $cache_id, $cache_path);

					if(!empty($tag_cache)){
						global $CACHE_MANAGER;
						$CACHE_MANAGER->StartTagCache($cache_path);
						$CACHE_MANAGER->RegisterTag($tag_cache);
						$CACHE_MANAGER->EndTagCache();
					}

					$cache->EndDataCache(
						array(
							"arRes" => $arRes
						)
					);
				}
			}
			return $arRes;
		}

		function cacheSection($arOrder = Array("SORT"=>"ASC"), $arrFilter = Array(), $bincCount = false, $arSelect = Array(), $single = false, $tag_cache = ""){
			if(!is_array($arOrder)){
				$arOrder = Array("SORT" => "ASC");
			}

			CModule::IncludeModule('iblock');

			$cache = new CPHPCache();
			$cache_time = 250000;
			$cache_path = 'aspro_cache_section';

			$cache_id = 'aspro_cache_section_'.serialize($arOrder).serialize($arrFilter).$bincCount.serialize($arSelect);
			if(COption::GetOptionString("main", "component_cache_on", "Y") == "Y" && $cache->InitCache($cache_time, $cache_id, $cache_path)){
				$res = $cache->GetVars();
				$arRes = $res["arRes"];
			}else{
				$rsRes = CIBlockSection::GetList($arOrder, $arrFilter, $bincCount, $arSelect);
				if($single){
					$arRes = $rsRes->GetNext();
				}else{
					while($res = $rsRes->GetNext()){
						$arRes[$res["ID"]] = $res;
					}
				}

				if(COption::GetOptionString("main", "component_cache_on", "Y") == "Y" && $cache_time > 0){
					$cache->StartDataCache($cache_time, $cache_id, $cache_path);

					if(!empty($tag_cache)){
						global $CACHE_MANAGER;
						$CACHE_MANAGER->StartTagCache($cache_path);
						$CACHE_MANAGER->RegisterTag($tag_cache);
						$CACHE_MANAGER->EndTagCache();
					}

					$cache->EndDataCache(
						array(
							"arRes" => $arRes
						)
					);
				}
			}
			return $arRes;
		}

		function getParam(&$arResult, $code){
			static $active;
			if($active == NULL){
				$active = COption::GetOptionString("aspro.allcorp", "THEME_SWITCHER");
			}
			$arr = COption::GetOptionString("aspro.allcorp", strtoupper($code)."_LIST");
			$arr = unserialize(stripslashes($arr));
			if(is_array($arr)){
				foreach($arr as $id => $name){
					$arResult[strtoupper($code)]["LIST"][$id] = array("CODE" => $id, "NAME" => trim($name));
				}
			}
			$arResult[strtoupper($code)]["DEFAULT"] = COption::GetOptionString("aspro.allcorp", strtoupper($code));
			$cur = $arResult[strtoupper($code)]["DEFAULT"];

			if($active == "Y"){
				if(!isset($_REQUEST["theme"]) || $_REQUEST["theme"] != "default"){
					if(isset($_SESSION["THEME"][$code]) && strlen($_SESSION["THEME"][$code])){
						$cur = $_SESSION["THEME"][$code];
					}

					if(isset($_REQUEST[$code]) && strlen($_REQUEST[$code])){
						if(isset($arr[$_REQUEST[$code]])){
							$cur = $_REQUEST[$code];
							$_SESSION["THEME"][$code] = $cur;
						}
					}
				}
				else{
					$_SESSION["THEME"][$code] = $cur;
				}
			}

			$arResult[strtoupper($code)]["CURRENT"] = $cur;

			if(is_array($arr)){
				foreach($arr as $id => $name){
					$arResult[strtoupper($code)]["LIST"][$id]["CURRENT"] = ($id == $cur ? "Y" : "N");
				}
			}
		}

		function get_file_info($fileID){
			$file = CFile::GetFileArray($fileID);
			$pos = strrpos($file["FILE_NAME"], '.');
			$file["FILE_NAME"] = substr($file["FILE_NAME"], $pos);
			$frm = explode('.', $file["FILE_NAME"]);
			$frm = $frm[1];
			if($frm == 'doc' || $frm == 'docx'){
				$type = 'word';
			}
			elseif($frm == 'xls' || $frm == 'xlsx'){
				$type = 'excel';
			}
			else{
				$type = 'pdf';
			}
			return $arr = array("TYPE" => $type, "FILE_SIZE" => $file['FILE_SIZE'], "SRC" => $file["SRC"], "DESCRIPTION" => $file["DESCRIPTION"], "ORIGINAL_NAME" => $file["ORIGINAL_NAME"]);
		}

		function filesize_format($filesize){
			$formats = array(GetMessage('CT_NAME_b'), GetMessage('CT_NAME_KB'), GetMessage('CT_NAME_MB'), GetMessage('CT_NAME_GB'), GetMessage('CT_NAME_TB'));
			$format = 0;
			while($filesize > 1024 && count($formats) != ++$format){
				$filesize = round($filesize / 1024, 1);
			}
			$formats[] = GetMessage('CT_NAME_TB');
			return $filesize.' '.$formats[$format];
		}

		function getChilds($input, &$start = 0, $level = 0) {
			if(!$level){
				$lastDepthLevel = 1;
				if(is_array($input)){
					foreach($input as $i => $arItem){
						if($arItem["DEPTH_LEVEL"] > $lastDepthLevel){
							if($i > 0){
								$input[$i - 1]["IS_PARENT"] = 1;
							}
						}
						$lastDepthLevel = $arItem["DEPTH_LEVEL"];
					}
				}
			}
			$childs = array();
			$count = count($input);
			for($i = $start; $i < $count; $i++) {
				$item = $input[$i];
				if($level > $item['DEPTH_LEVEL'] - 1) {
					break;
				} elseif(!empty($item['IS_PARENT'])) {
					$i++;
					$item['CHILD'] = aspro::getChilds($input, $i, $level+1);
					$i--;
				}
				$childs[] = $item;
			}
			$start = $i;
			return $childs;
		}

		function sort_sections_by_field($arr, $name){
			$count = count($arr);
			for($i = 0; $i < $count; $i++){
				for($j = 0; $j < $count; $j++){
					if(strtoupper($arr[$i]["NAME"]) < strtoupper($arr[$j]["NAME"])){
						$tmp = $arr[$i];
						$arr[$i] = $arr[$j];
						$arr[$j] = $tmp;
					}
				}
			}
			return $arr;
		}

		function getIBItems($prop, $checkNoImage){
			$arID = $arItems = $arAllItems = array();

			if(is_array($prop)){
				foreach($prop as $reviewID){
					$arID[]=$reviewID;
				}
			}

			if($checkNoImage){
				$empty=false;
			}

			$arItems = aspro::cacheElement(false, array("ID" => $arID, "ACTIVE" => "Y"));
			if(is_array($arItems)){
				foreach($arItems as $key => $arItem){
					if($checkNoImage){
						if(empty($arProject["PREVIEW_PICTURE"])){
							$empty=true;
						}
					}
					$arAllItems["ITEMS"][$key] = $arItem;
					if($arItem["DETAIL_PICTURE"]){
						$arAllItems["ITEMS"][$key]["DETAIL"] = CFile::GetFileArray($arItem["DETAIL_PICTURE"]);
					}
					if($arItem["PREVIEW_PICTURE"]){
						$arAllItems["ITEMS"][$key]["PREVIEW"] = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], array('width' => 425, 'height' => 330), BX_RESIZE_IMAGE_EXACT, true);
					}
				}
			}

			if($checkNoImage){
				$arAllItems["NOIMAGE"] = "YES";
			}

			return $arAllItems;
		}

		function getSectionChilds($PSID, &$arSections, &$arSectionsByParentSectionID, &$arItemsBySectionID, &$aMenuLinksExt){
			if($arSections && is_array($arSections)){
			foreach($arSections as $arSection){
				if($arSection['IBLOCK_SECTION_ID'] == $PSID){
					$arItem = array($arSection['NAME'], $arSection['SECTION_PAGE_URL'], array(), array('FROM_IBLOCK' => 1, 'DEPTH_LEVEL' => $arSection['DEPTH_LEVEL']));
					$arItem[3]['IS_PARENT'] = (isset($arItemsBySectionID[$arSection['ID']]) || isset($arSectionsByParentSectionID[$arSection['ID']]) ? 1 : 0);
					$aMenuLinksExt[] = $arItem;
					if($arItem[3]['IS_PARENT']){
						// subsections
						self::getSectionChilds($arSection['ID'], $arSections, $arSectionsByParentSectionID, $arItemsBySectionID, $aMenuLinksExt);
						// section elements
						if($arItemsBySectionID[$arSection['ID']] && is_array($arItemsBySectionID[$arSection['ID']])){
							foreach($arItemsBySectionID[$arSection['ID']] as $arItem){
								if(is_array($arItem['DETAIL_PAGE_URL'])){
									if(isset($arItem['CANONICAL_PAGE_URL'])){
										$arItem['DETAIL_PAGE_URL'] = $arItem['CANONICAL_PAGE_URL'];
									}
									else{
										$arItem['DETAIL_PAGE_URL'] = $arItem['DETAIL_PAGE_URL'][key($arItem['DETAIL_PAGE_URL'])];
									}
								}
								$aMenuLinksExt[] = array($arItem['NAME'], $arItem['DETAIL_PAGE_URL'], array(), array('FROM_IBLOCK' => 1, 'DEPTH_LEVEL' => ($arSection['DEPTH_LEVEL'] + 1), 'IS_ITEM' => 1));
							}
						}
					}
				}
			}
		}
		}

		function isChildsSelected($arChilds){
			if(is_array($arChilds)){
				foreach($arChilds as $arChild){
					if($arChild["SELECTED"]){
						return $arChild;
					}
				}
			}
			return false;
		}
	}
}
?>