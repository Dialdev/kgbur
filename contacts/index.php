<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Контакты - «КГБ»");
$APPLICATION->SetPageProperty("description", "Контактные данные компании «КГБ»");
$APPLICATION->SetTitle("Контакты");
?><div class="row">
	<div class="col-md-4">
		 <? /* <div>
            <span class="grey_light">
                В салонах компании представлены не только технические новинки рынка мобильной электроники, но и широкий выбор дополнительных услуг. Сегодня можно приобрести и оплатить авиабилеты, туристические путевки, билеты на развлекательные и спортивные мероприятия.
            </span>
            </div>
            <div>
                <br/>
            </div>
            <div>
                <br/>
            </div> */ ?>
		<table cellpadding="0" cellspasing="0">
		<tbody>
		<tr>
			<td align="left" valign="top">
 <i class="icon colored icon-map-marker"></i>
			</td>
			<td align="left" valign="top">
 <span class="dark_light_table">Адрес:</span> <br>
				<p>
 <span class="grey_dark"><span style="font-size: 11pt;">248000, Россия, г. Калуга,</span><br>
 <span style="font-size: 11pt;"> </span><span style="font-size: 11pt;">
					ул. Георгиевская, д. 39, офис 210</span></span>
				</p>
			</td>
		</tr>
		<tr>
			<td align="left" valign="top">
 <i class="icon colored icon-phone"></i>
			</td>
			<td align="left" valign="top">
 <span style="font-size: 12pt;"> </span><span class="dark_light_table" style="font-size: 12pt;">Телефон:</span><span style="font-size: 12pt;"> </span><br>
 <span style="font-size: 12pt;"> </span>
				<p>
 <span style="font-size: 12pt;"> </span><span class="grey_dark"><span style="font-size: 11pt;">
					г. Калуга&nbsp; <a style="font-size: 11pt;" href="tel:79108617153">+7 (910) 861-71-53</a></span><br>
 <span style="font-size: 11pt;"> </span><span style="font-size: 11pt;"> </span><span style="font-size: 11pt;">
					г. Брянск&nbsp;</span></span><a style="font-size: 11pt;" href="tel:79529661144">+7 (952)&nbsp;966-11-44</a>
				</p>
			</td>
		</tr>
		<tr>
			<td align="left" valign="top">
 <i class="icon colored icon-envelope"></i>
			</td>
			<td align="left" valign="top">
 <span class="dark_light_table">E-mail:</span> <br>
				<p>
 <span class="grey_dark"><a href="mailto:kgbur@mail.ru"><span style="font-size: 11pt;">kgbur@mail.ru</span></a></span>
				</p>
			</td>
		</tr>
		<tr>
			<td align="left" valign="top">
 <i class="icon colored icon-clock-o"></i>
			</td>
			<td align="left" valign="top">
 <span class="dark_light_table">Режим работы:</span> <br>
				<p>
 <span class="grey_dark"><span style="font-size: 11pt;">Пн. – Пт.: с 9:00 до 18:00</span><br>
 <span style="font-size: 11pt;">
					Сб. - Вс.: выходные</span></span>
				</p>
			</td>
		</tr>
		<tr>
			<td align="left" valign="top">
			</td>
			<td align="left" valign="top">
 <span class="dark_light_table">Реквизиты:</span> <br>
 <span style="font-size: 11pt;">ИНН 5030051001<br>
 </span><span style="font-size: 11pt;">ОГРН 1055005623738</span><br>
 <span style="font-size: 11pt;">Дата регистрации 06.12.2005</span>
			</td>
		</tr>
		</tbody>
		</table>
	</div>
 <a href="#" name="map"></a>
	<div class="col-md-8">
		 <?$APPLICATION->IncludeComponent(
	"bitrix:map.yandex.view",
	".default",
	Array(
		"API_KEY" => "",
		"COMPONENT_TEMPLATE" => ".default",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"CONTROLS" => array(0=>"ZOOM",1=>"TYPECONTROL",2=>"SCALELINE",),
		"INIT_MAP_TYPE" => "MAP",
		"MAP_DATA" => "a:4:{s:10:\"yandex_lat\";d:54.51243826374894;s:10:\"yandex_lon\";d:36.24655622897445;s:12:\"yandex_scale\";i:16;s:10:\"PLACEMARKS\";a:1:{i:0;a:3:{s:3:\"LON\";d:36.24721579896347;s:3:\"LAT\";d:54.51221516689084;s:4:\"TEXT\";s:91:\"248000 Россия, г. Калуга, ул. Георгиевская, д. 39, офис 210\";}}}",
		"MAP_HEIGHT" => "500",
		"MAP_ID" => "",
		"MAP_WIDTH" => "100%",
		"OPTIONS" => array(0=>"ENABLE_DBLCLICK_ZOOM",1=>"ENABLE_DRAGGING",)
	)
);?>
	</div>
</div>
<? Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("form-block"); ?>
<? $captcha = (in_array($arTheme['USE_CAPTCHA_FORM'], array('HIDDEN', 'IMAGE', 'RECAPTCHA')) ? $arTheme['USE_CAPTCHA_FORM'] : 'NONE'); ?>
<? $processing = ($arTheme['DISPLAY_PROCESSING_NOTE'] === 'Y' ? 'Y' : 'N'); ?>
<?$APPLICATION->IncludeComponent(
	"aspro:form.allcorp",
	"contacts",
	Array(
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "Y",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_TIME" => "100000",
		"CACHE_TYPE" => "A",
		"CLOSE_BUTTON_CLASS" => "btn btn-primary refresh-page",
		"CLOSE_BUTTON_NAME" => "Обновить страницу",
		"DISPLAY_CLOSE_BUTTON" => "Y",
		"DISPLAY_PROCESSING_NOTE" => $processing,
		"IBLOCK_ID" => "21",
		"IBLOCK_TYPE" => "aspro_allcorp_form",
		"IS_PLACEHOLDER" => "N",
		"SEND_BUTTON_CLASS" => "btn btn-primary",
		"SEND_BUTTON_NAME" => "Отправить",
		"SUCCESS_MESSAGE" => "<p>Спасибо! Ваше сообщение отправлено!</p>",
		"USE_CAPTCHA" => $captcha
	)
);?>
<? Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("form-block", ""); ?><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>