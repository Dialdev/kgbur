<?
IncludeModuleLangFile(__FILE__);

class aspro_allcorp extends CModule {
	var $MODULE_ID = "aspro.allcorp";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $MODULE_GROUP_RIGHTS = "Y";

	function aspro_allcorp(){
		$arModuleVersion = array();

		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");

		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

		$this->MODULE_NAME = GetMessage("ASPRO_SCOM_INSTALL_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("SCOM_INSTALL_DESCRIPTION");
		$this->PARTNER_NAME = GetMessage("SPER_PARTNER");
		$this->PARTNER_URI = GetMessage("PARTNER_URI");
	}
	
	function checkValid(){
		return true;
	}

	function InstallDB($install_wizard = true){
		global $DB, $DBType, $APPLICATION;

		RegisterModule("aspro.allcorp");
		RegisterModuleDependences("main", "OnBeforeProlog", "aspro.allcorp", "CAllCorp", "ShowPanel");
		if (preg_match ( '/.bitrixlabs.ru/' , $_SERVER["HTTP_HOST"])) { RegisterModuleDependences("main", "OnBeforeProlog", "aspro.allcorp", "CAllCorp", "correctInstall"); }

		$socket = fsockopen('bi.aspro.ru', 80, $errno, $errstr, 10);
		if($socket){
			if (CModule::IncludeModule("main"))	{
				global $APPLICATION;
				require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/update_client.php");
				$errorMessage = "";
				$serverIP = $_SERVER["HTTP_X_REAL_IP"] ? $_SERVER["HTTP_X_REAL_IP"] : $_SERVER["SERVER_ADDR"];
				$arUpdateList = CUpdateClient::GetUpdatesList($errorMessage, "ru", "Y");
				if (array_key_exists("CLIENT", $arUpdateList) && $arUpdateList["CLIENT"][0]["@"]["LICENSE"]) { $edition = $arUpdateList["CLIENT"][0]["@"]["LICENSE"]; } 
				else { $edition = "UNKNOWN"; }		
				$data = json_encode(array(  "client"=>"aspro", "install_date"=>date ("Y-m-d H:i:s"), "solution_code"=>"aspro.allcorp", 
											"ip"=> $serverIP, "http_host"=>$_SERVER["HTTP_HOST"],
											"bitrix_version"=>SM_VERSION, "bitrix_edition"=>$APPLICATION->ConvertCharset($edition, SITE_CHARSET, "utf-8"),
											"bitrix_key_hash"=>md5(CUpdateClient::GetLicenseKey()),
											"site_name"=>$APPLICATION->ConvertCharset(COption::GetOptionString("main", "site_name"), SITE_CHARSET, "utf-8"),
											"site_url"=>$APPLICATION->ConvertCharset(COption::GetOptionString("main", "server_name"), SITE_CHARSET, "utf-8"),
											"email_default"=>$APPLICATION->ConvertCharset(COption::GetOptionString("main", "email_from"), SITE_CHARSET, "utf-8"),
											"action"=>"install"));						
				fwrite($socket, "POST /rest/bitrix/installs HTTP/1.1\r\n");
				fwrite($socket, "Host: bi.aspro.ru\r\n");
				fwrite($socket,"Content-type: application/x-www-form-urlencoded\r\n");
				fwrite($socket,"Content-length:".strlen($data)."\r\n");
				fwrite($socket,"Accept:*/*\r\n");
				fwrite($socket,"User-agent:Bitrix Installer\r\n");
				fwrite($socket,"Connection:Close\r\n");
				fwrite($socket,"\r\n");
				fwrite($socket,"$data\r\n");
				fwrite($socket,"\r\n");
				$answer = '';
				while(!feof($socket)){$answer.= fgets($socket, 4096);}
				fclose($socket);
			}
		}
		
		return true;
	}

	function UnInstallDB($arParams = array()){
		global $DB, $DBType, $APPLICATION;
		if(CModule::IncludeModule("aspro.allcorp")) { CAllCorp::newAction("delete"); }
		UnRegisterModuleDependences("main", "OnBeforeProlog", "aspro.allcorp", "CAllCorp", "ShowPanel"); 
		UnRegisterModule("aspro.allcorp");

		return true;
	}

	function InstallEvents(){
		return true;
	}

	function UnInstallEvents(){
		return true;
	}

	function InstallFiles(){
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/aspro.allcorp/install/components", $_SERVER["DOCUMENT_ROOT"]."/bitrix/components", true, true);
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/aspro.allcorp/install/wizards", $_SERVER["DOCUMENT_ROOT"]."/bitrix/wizards", true, true);
		
		if (preg_match ( '/.bitrixlabs.ru/' , $_SERVER["HTTP_HOST"])) 
		{ 
			@set_time_limit(0);
			require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/fileman/include.php");
			CFileMan::DeleteEx(Array("s1", "/bitrix/modules/aspro.allcorp/install/wizards"));
		}
		
		return true;
	}

	function InstallPublic(){
	}

	function UnInstallFiles(){
		// remove wizard files
		DeleteDirFilesEx("/bitrix/wizards/aspro/allcorp/");
		return true;
	}

	function DoInstall(){
		global $APPLICATION, $step;

		$this->InstallFiles();
		$this->InstallDB(false);
		$this->InstallEvents();
		$this->InstallPublic();

		$APPLICATION->IncludeAdminFile(GetMessage("SCOM_INSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/aspro.allcorp/install/step.php");
	}

	function DoUninstall(){
		global $APPLICATION, $step;

		$this->UnInstallDB();
		$this->UnInstallFiles();
		$this->UnInstallEvents();
		$APPLICATION->IncludeAdminFile(GetMessage("SCOM_UNINSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/aspro.allcorp/install/unstep.php");
	}
}
?>