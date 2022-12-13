<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
CModule::IncludeModule('aspro.allcorp');
$id = (isset($_REQUEST["id"]) ? $_REQUEST["id"] : false);
aspro::getParam($arFrontParametrs, "USE_CAPTCHA_FORM");
aspro::getParam($arFrontParametrs, "DISPLAY_PROCESSING_NOTE");
$captcha = (in_array($arFrontParametrs['USE_CAPTCHA_FORM']['CURRENT'], array('HIDDEN', 'IMAGE', 'RECAPTCHA')) ? $arFrontParametrs['USE_CAPTCHA_FORM']['CURRENT'] : 'NONE');
$processing = ($arFrontParametrs['DISPLAY_PROCESSING_NOTE']['CURRENT'] === 'Y' ? 'Y' : 'N');
$isCallBack = $id == CCache::$arIBlocks[SITE_ID]["aspro_allcorp_form"]["aspro_allcorp_callback"][0];
$successMessage = ($isCallBack ? "<p>Наш менеджер перезвонит вам в ближайшее время.</p><p>Спасибо за ваше обращение!</p>" : "Спасибо! Ваше сообщение отправлено!");
?>
<span class="jqmClose top-close icon icon-times"></span>
<?$APPLICATION->IncludeComponent(
	"aspro:form.allcorp",
	$isCallBack ? "callback" : "popup",
	Array(
		"IBLOCK_TYPE" => "aspro_allcorp_form",
		"IBLOCK_ID" => $id,
		"USE_CAPTCHA" => $captcha,
		"DISPLAY_PROCESSING_NOTE" => $processing,
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_JUMP" => "Y",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "100000",
		"AJAX_OPTION_ADDITIONAL" => "",
		//"IS_PLACEHOLDER" => "Y",
		"SUCCESS_MESSAGE" => $successMessage,
		"SEND_BUTTON_NAME" => "Отправить",
		"SEND_BUTTON_CLASS" => "btn btn-primary",
		"DISPLAY_CLOSE_BUTTON" => "Y",
		"POPUP" => "Y",
		"CLOSE_BUTTON_NAME" => "Закрыть",
		"CLOSE_BUTTON_CLASS" => "jqmClose btn btn-primary bottom-close"
	)
);?>