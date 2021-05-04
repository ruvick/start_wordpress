
$ = jQuery;
// ====================================================================================================


// Открытие модального окна
$(".popup-quest").on('click', function (e) {
	e.preventDefault();
	jQuery(".windows_form h2").html(jQuery(this).data("winheader"));
	jQuery(".windows_form .subtitle").html(jQuery(this).data("winsubheader"));
	jQuery("#question").arcticmodal();
});

//Валидация + Отправщик
$('.newButton').click(function (e) {

	e.preventDefault();
	var name = $("#form-question-name").val();
	var tel = $("#form-question-tel").val();

	if (jQuery("#form-question-tel").val() == "") {
		jQuery("#form-question-tel").css("border", "1px solid red");
		return;
	}

	// if (jQuery("#sig-inp-e").val() == ""){
	// 	jQuery("#sig-inp-e").css("border","1px solid red");
	// 	return;
	// }

	else {
		var jqXHR = jQuery.post(
			allAjax.ajaxurl,
			{
				action: 'sendphone',
				nonce: allAjax.nonce,
				name: name,
				tel: tel,
			}
		);

		jqXHR.done(function (responce) {
			jQuery(".headen_form_blk").hide();
			jQuery('.SendetMsg').show();
		});

		jqXHR.fail(function (responce) {
			alert("Произошла ошибка. Попробуйте позднее.");
		});

	}
});


