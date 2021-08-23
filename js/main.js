// Файлы Java Script -----------------------------------------------------------------------------------------------------

// возвращает куки с указанным name,
// или undefined, если ничего не найдено
function getCookie(name) {
	let matches = document.cookie.match(new RegExp(
		"(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
	));
	return matches ? decodeURIComponent(matches[1]) : undefined;
}


function number_format() {
	let elements = document.querySelectorAll('.price_formator');
	for (let elem of elements) {
		elem.dataset.realPrice = elem.innerHTML;
		elem.innerHTML = Number(elem.innerHTML).toLocaleString('ru-RU');
	}
}

function set_size(sizeName) {
	let btn = document.getElementById('btn__to-card');
	btn.dataset.size = sizeName;
	console.log(sizeName);
}

document.addEventListener("DOMContentLoaded", () => {
	number_format();
	cart_recalc();
});

//--- Корзина -------------------------------------------------------------------------------------------------------------

let cart = [];
let cartCount = 0;

function cart_recalc() {
	cart = JSON.parse(localStorage.getItem("cart"));
	if (cart == null) cart = [];
	cartCount = 0;
	cartSumm = 0;
	for (let i = 0; i < cart.length; i++) {
		cartCount += Number(cart[i].count);

		cartSumm += Number(cart[i].count) * parseFloat(cart[i].price);
	}

	localStorage.setItem("cartcount", cartCount);
	localStorage.setItem("cartsumm", cartSumm);

	let elements = document.querySelectorAll('.bascet_counter');
	for (let elem of elements) {
		elem.innerHTML = cartCount;
	}

}

function add_tocart(elem, countElem) {


	let cartElem = {
		sku: elem.dataset.sku,
		size: elem.dataset.size,
		lnk: elem.dataset.lnk,
		price: elem.dataset.price,
		priceold: elem.dataset.oldprice,
		subtotal: elem.dataset.price,
		name: elem.dataset.name,
		count: (countElem == 0) ? elem.dataset.count : countElem,
		picture: elem.dataset.picture
	};

	if (cart.length == 0) {
		cart.push(cartElem);
	} else {
		let addet = true;
		for (let i = 0; i < cart.length; i++) {
			if ((cart[i].sku == cartElem.sku) && (cart[i].size == cartElem.size)) {
				cart[i].count++;
				cart[i].subtotal = Number(cart[i].count) * parseFloat(cart[i].price);
				addet = false;
				break;
			}
		}

		if (addet)
			cart.push(cartElem);
	}

	localStorage.setItem("cart", JSON.stringify(cart));
	cart_recalc();

	console.log(cartElem);
}
//------------------------------------------------------------------------------------------------------------

// Отправка на печать -------------------------------------------------------------------------------------------------------------
function printit() {
	if (window.print) {
		window.print();
	} else {
		var WebBrowser =
			'<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
		document.body.insertAdjacentHTML("beforeEnd", WebBrowser);
		WebBrowser1.ExecWB(6, 2); //Use a 1 vs. a 2 for a prompting dialog box WebBrowser1.outerHTML = "";
	}
}

// Отправка на генерацию PDF -------------------------------------------------------------------------------------------------------------
function generatePDF() {
	const element = document.getElementById('body');
	const opt = {
		margin: 1,
		filename: 'file.pdf',
		image: { type: 'jpeg', quality: 0.98 },
		html2canvas: { scale: 1 },
		jsPDF: { unit: 'in', format: 'a2', orientation: 'portrait' }
	};

	// New Promise-based usage:
	html2pdf().set(opt).from(element).save();
}

{/* <a href="#" class="card-wrap-properties-links-link" onclick="generatePDF();">Скачать страницу в PDF</p></a> */ }
// ----------------------------------------------------------------------------------------------------------------------------------------

//BodyLock для Popup на JS
function body_lock(delay) {
	let body = document.querySelector("body");
	if (body.classList.contains('lock')) {
		body_lock_remove(delay);
	} else {
		body_lock_add(delay);
	}
}
function body_lock_remove(delay) {
	let body = document.querySelector("body");
	if (unlock) {
		let lock_padding = document.querySelectorAll("._lp");
		setTimeout(() => {
			for (let index = 0; index < lock_padding.length; index++) {
				const el = lock_padding[index];
				el.style.paddingRight = '0px';
			}
			body.style.paddingRight = '0px';
			body.classList.remove("lock");
		}, delay);

		unlock = false;
		setTimeout(function () {
			unlock = true;
		}, delay);
	}
}
function body_lock_add(delay) {
	let body = document.querySelector("body");
	if (unlock) {
		let lock_padding = document.querySelectorAll("._lp");
		for (let index = 0; index < lock_padding.length; index++) {
			const el = lock_padding[index];
			el.style.paddingRight = window.innerWidth - document.querySelector('.wrapper').offsetWidth + 'px';
		}
		body.style.paddingRight = window.innerWidth - document.querySelector('.wrapper').offsetWidth + 'px';
		body.classList.add("lock");

		unlock = false;
		setTimeout(function () {
			unlock = true;
		}, delay);
	}
}

// Popup JS
let unlock = true;
let popup_link = document.querySelectorAll('._popup-link');
let popups = document.querySelectorAll('.popup');
for (let index = 0; index < popup_link.length; index++) {
	const el = popup_link[index];
	el.addEventListener('click', function (e) {
		if (unlock) {
			let item = el.getAttribute('href').replace('#', '');
			let video = el.getAttribute('data-video');
			popup_open(item, video);
		}
		e.preventDefault();
	})
}
for (let index = 0; index < popups.length; index++) {
	const popup = popups[index];
	popup.addEventListener("click", function (e) {
		if (!e.target.closest('.popup__body')) {
			popup_close(e.target.closest('.popup'));
		}
	});
}
function popup_open(item, video = '') {
	let activePopup = document.querySelectorAll('.popup._active');
	if (activePopup.length > 0) {
		popup_close('', false);
	}
	let curent_popup = document.querySelector('.popup_' + item);
	if (curent_popup && unlock) {
		if (video != '' && video != null) {
			let popup_video = document.querySelector('.popup_video');
			popup_video.querySelector('.popup__video').innerHTML = '<iframe src="https://www.youtube.com/embed/' + video + '?autoplay=1"  allow="autoplay; encrypted-media" allowfullscreen></iframe>';
		}
		if (!document.querySelector('.menu__body._active')) {
			body_lock_add(500);
		}
		curent_popup.classList.add('_active');
		history.pushState('', '', '#' + item);
	}
}
function popup_close(item, bodyUnlock = true) {
	if (unlock) {
		if (!item) {
			for (let index = 0; index < popups.length; index++) {
				const popup = popups[index];
				let video = popup.querySelector('.popup__video');
				if (video) {
					video.innerHTML = '';
				}
				popup.classList.remove('_active');
			}
		} else {
			let video = item.querySelector('.popup__video');
			if (video) {
				video.innerHTML = '';
			}
			item.classList.remove('_active');
		}
		if (!document.querySelector('.menu__body._active') && bodyUnlock) {
			body_lock_remove(500);
		}
		history.pushState('', '', window.location.href.split('#')[0]);
	}
}
let popup_close_icon = document.querySelectorAll('.popup__close,._popup-close');
if (popup_close_icon) {
	for (let index = 0; index < popup_close_icon.length; index++) {
		const el = popup_close_icon[index];
		el.addEventListener('click', function () {
			popup_close(el.closest('.popup'));
		})
	}
}
document.addEventListener('keydown', function (e) {
	if (e.code === 'Escape') {
		popup_close();
	}
});
// Файлы Java Script End -----------------------------------------------------------------------------------------------------

$ = jQuery;

// Файлы jQuery---------------------------------------------------------------------------------------------------------------

// Маска телефона
var inputmask_phone = { "mask": "+9(999)999-99-99" };
jQuery("input[type=tel]").inputmask(inputmask_phone);


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
	const name = $("#form-callback-name").val();
	const tel = $("#form-callback-tel").val();
	const email = $("#form-callback-email").val();

	if (jQuery("#form-callback-tel").val() == "") {
		jQuery("#form-callback-tel").css("border", "1px solid red");
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
				email: email,
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

