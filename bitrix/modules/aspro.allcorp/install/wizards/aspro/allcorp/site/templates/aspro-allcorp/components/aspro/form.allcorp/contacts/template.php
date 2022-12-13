<?if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true ) die();?>
<div class="row">
	<div class="col-md-12">
		<div class="styled-block">
			<div class="form contacts">
				<?if( $arResult["isFormNote"] == "Y" ){?>
					<div class="form-header">
						<i class="icon icon-check"></i>
						<div class="text">
							<div class="title"><?=GetMessage("SUCCESS_TITLE")?></div>
							<?=$arResult["FORM_NOTE"]?>
						</div>
					</div>
					<script type="text/javascript">
					$(document).ready(function(){
						if(arAllcorpOptions['THEME']['USE_FORMS_GOALS'] !== 'NONE'){
							var eventdata = {goal: 'goal_webform_success' + (arAllcorpOptions['THEME']['USE_FORMS_GOALS'] === 'COMMON' ? '' : '_<?=$arParams["IBLOCK_ID"]?>'), params: <?=CUtil::PhpToJSObject($arParams, false)?>, result: <?=CUtil::PhpToJSObject($arResult, false)?>};
							BX.onCustomEvent('onCounterGoals', [eventdata]);
						}
					});
					</script>
					<?if( $arParams["DISPLAY_CLOSE_BUTTON"] ){?>
						<div class="form-footer" style="text-align: center;">
							<?=$arResult["CLOSE_BUTTON"]?>
						</div>
					<?}
				}else{?>
					<?=$arResult["FORM_HEADER"]?>
						<div class="row form-body">
							<div class="col-md-4">
								<?if( $arResult["isIblockTitle"] ){?>
									<div class="title"><?=$arResult["IBLOCK_TITLE"]?></div>
								<?}?>
								<?if( $arResult["isIblockDescription"] ){
									if( $arResult["IBLOCK_DESCRIPTION_TYPE"] == "text" ){?>
										<p><?=$arResult["IBLOCK_DESCRIPTION"]?></p>
									<?}else{?>
										<?=$arResult["IBLOCK_DESCRIPTION"]?>
									<?}
								}?>
							</div>
							<div class="col-md-4">
								<?if(is_array($arResult["QUESTIONS"])):?>
									<?foreach( $arResult["QUESTIONS"] as $FIELD_SID => $arQuestion ){
										if( $FIELD_SID == "MESSAGE" ) continue;
										if( $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden' ){
											echo $arQuestion["HTML_CODE"];
										}else{?>
											<div class="row" data-SID="<?=$FIELD_SID?>">
												<div class="form-group">
													<div class="col-md-12">
														<?=$arQuestion["CAPTION"]?>
														<div class="input">
															<?=$arQuestion["HTML_CODE"]?>
														</div>
														<?if( !empty( $arQuestion["HINT"] ) ){?>
															<div class="hint"><?=$arQuestion["HINT"]?></div>
														<?}?>
													</div>
												</div>
											</div>
										<?}
									}?>
								<?endif;?>
							</div>
							<div class="col-md-4">
								<div class="row" data-SID="MESSAGE">
									<div class="form-group">
										<div class="col-md-12">
											<?=$arResult["QUESTIONS"]["MESSAGE"]["CAPTION"]?>
											<div class="input">
												<?=$arResult["QUESTIONS"]["MESSAGE"]["HTML_CODE"]?>
											</div>
											<?if( !empty( $arResult["QUESTIONS"]["MESSAGE"]["HINT"] ) ){?>
												<div class="hint"><?=$arResult["QUESTIONS"]["MESSAGE"]["HINT"]?></div>
											<?}?>
										</div>
									</div>
								</div>
								<?
								$frame = $this->createFrame()->begin('');
								$frame->setBrowserStorage(true);
								?>
								<?if($arResult["isUseCaptcha"] === "Y"):?>
									<div class="row <?=($arResult["isUseReCaptcha"] === 'Y' ? 'recaptcha-row' : 'captcha-row')?>">
										<?if($arResult["isUseReCaptcha"] === "Y"):?>
											<div class="form-group">
												<div class="col-md-12">
													<?=$arResult["CAPTCHA_CAPTION"]?>
													<div class="input <?=($arResult['CAPTCHA_ERROR'] == 'Y' ? 'error' : '')?>">
														<input type="hidden" class="recaptcha" name="recaptcha" id="recaptcha">
														<div class="g-recaptcha" data-sitekey="<?=RECAPTCHA_SITE_KEY?>" data-callback="reCaptchaVerify" data-theme="light" data-size="normal"></div>
													</div>
												</div>
											</div>
										<?else:?>
											<div class="col-md-12">
												<div class="form-group margin-bottom-20">
													<?=$arResult["CAPTCHA_CAPTION"]?>
													<div>
														<?=$arResult["CAPTCHA_IMAGE"]?>
														<div class="refresh">
															<a href="javascript:;" rel="nofollow"><?=GetMessage("REFRESH")?></a>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="input <?=$arResult["CAPTCHA_ERROR"] == "Y" ? "error" : ""?>">
														<?=$arResult["CAPTCHA_FIELD"]?>
													</div>
												</div>
											</div>
										<?endif;?>
									</div>
								<?else:?>
									<div style="display:none;"></div>
								<?endif;?>
								<?$frame->end();?>
							</div>
						</div>
						<?if($arParams["DISPLAY_PROCESSING_NOTE"] == "Y"):?>
							<div class="row processing-block">
								<div class="form-group">
									<div class="col-md-4"></div>
									<div class="col-md-4">
										<div class="input">
											<input type="checkbox" class="processing_approval" <?=(COption::GetOptionString("aspro.allcorp", "LICENCE_CHECKED", "N") == "Y" ? "checked" : "");?> id="processing_approval" name="processing_approval" value="Y">
											<label for="processing_approval"><?$APPLICATION->IncludeFile(SITE_DIR."include/processing_note.php", Array(), Array("MODE" => "html"))?></label>
										</div>
									</div>
									<div class="col-md-4"></div>
								</div>
							</div>
						<?endif;?>
						<div class="row">
							<div class="col-md-12">
								<div class="pull-right">
									<?=$arResult["SUBMIT_BUTTON"]?>
								</div>
							</div>
						</div>
					<?=$arResult["FORM_FOOTER"]?>
				<?}?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	if(arAllcorpOptions['THEME']['USE_CAPTCHA_FORM'] == 'RECAPTCHA'){
		reCaptchaRender();
	}

	$('form[name="<?=$arResult["IBLOCK_CODE"]?>"]').validate({
		ignore: ".ignore",
		highlight: function( element ){
			$(element).parent().addClass('error');
		},
		unhighlight: function( element ){
			$(element).parent().removeClass('error');
		},
		submitHandler: function( form ){
			if( $('form[name="<?=$arResult["IBLOCK_CODE"]?>"]').valid() ){
				$(form).find('button[type="submit"]').attr("disabled", "disabled");
				form.submit();
			}
		},
		errorPlacement: function( error, element ){
			error.insertBefore(element);
		}
	});

	if(arAllcorpOptions['THEME']['PHONE_MASK'].length){
		var base_mask = arAllcorpOptions['THEME']['PHONE_MASK'].replace( /(\d)/g, '_' );
		$('form[name="<?=$arResult["IBLOCK_CODE"]?>"] input.phone').inputmask("mask", { "mask": arAllcorpOptions['THEME']['PHONE_MASK'] });
		$('form[name="<?=$arResult["IBLOCK_CODE"]?>"] input.phone').blur(function(){
			if( $(this).val() == base_mask || $(this).val() == '' ){
				if( $(this).hasClass('required') ){
					$(this).parent().find('div.error').html(BX.message("JS_REQUIRED"));
				}
			}
		});
	}

	$('form[name="<?=$arResult["IBLOCK_CODE"]?>"] input.date').inputmask(arAllcorpOptions['THEME']['DATE_MASK'], { "placeholder": arAllcorpOptions['THEME']['DATE_PLACEHOLDER'] });
	$('form[name="<?=$arResult["IBLOCK_CODE"]?>"] input.datetime').inputmask(arAllcorpOptions['THEME']['DATETIME_MASK'], { "placeholder": arAllcorpOptions['THEME']['DATETIME_PLACEHOLDER'] });

	$('.refresh-page').on('click', function(){
		location.reload();
	})

	$("input[type=file]").uniform({ fileButtonHtml: BX.message("JS_FILE_BUTTON_NAME"), fileDefaultHtml: BX.message("JS_FILE_DEFAULT") });
});
</script>