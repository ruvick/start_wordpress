<?php

define("COMPANY_NAME", "Новый сайт");
define("MAIL_RESEND", "noreply@ultrakresla.ru");

//----Подключене carbon fields
//----Инструкции по подключению полей см. в комментариях themes-fields.php
include "carbon-fields/carbon-fields-plugin.php";

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'crb_attach_theme_options'); 
function crb_attach_theme_options()
{
	require_once __DIR__ . "/themes-fields.php";
}

add_action('after_setup_theme', 'crb_load');
function crb_load()
{
	require_once('carbon-fields/vendor/autoload.php');
	\Carbon_Fields\Carbon_Fields::boot();
}


// Menu ===========================================================================================================
//-----Блок описания вывода меню =========================================================================
// 1. Осмысленные названия для алиаса и для описания на русском.
// если это меню в подвали пишем - Меню в подвале 
// если в шапке то пишем - Меню в шапке 
// если 2 меню в шапке пишем  - Меню в шапке (верхняя часть)

add_action('after_setup_theme', function () {
	register_nav_menus([
		// 'menu_hot' => 'Меню актуальных предложений (рядом с каталогом)',
		'menu_main' => 'Меню основное',
		'menu_cat' => 'Меню каталог (в подвале)',
		'menu_company' => 'Меню о компании (в подвале)',
		// 'menu_corp' => 'Общекорпоративное меню (верхняя шапка)', 
	]);
});


// Добавление стилей к пунктам меню li
add_filter('nav_menu_css_class', 'change_menu_item_css_classes', 10, 4);

function change_menu_item_css_classes($classes, $item, $args, $depth)
{
	if ($item->ID  && 'menu_cat' === $args->theme_location) {
		$classes[] = 'footer-top-wrap-list-item-sublist-item';
	}

	if ($item->ID  && 'menu_company' === $args->theme_location) {
		$classes[] = 'footer-top-wrap-list-item-sublist-item';
	}

	if ($item->ID  && 'menu_main' === $args->theme_location) {
		$classes[] = 'header-bottom-wrap-menu-item';
	}

	return $classes;
}


// Добавляет атрибут class к ссылке в пунктах меню menu_main
add_filter('nav_menu_link_attributes', 'filter_nav_menu_link_attributes', 10, 4);
function filter_nav_menu_link_attributes($atts, $item, $args, $depth)
{
	if (in_array($args->theme_location, ['menu_main'])) {
		$atts['class'] = 'header-bottom-wrap-menu-item__link';

		if ($item->current) {
			$atts['class'] .= ' menu-link--active'; //активный пункт меню
		}
	}
	return $atts;
}


// Добавляет иконку к ссылкам меню, прикрепленное к области меню menu_main
// function change_menu_item_args($args)
// {
// 	if ($args->theme_location == 'menu_main') {
// 		$args->link_after = '<img src="' . get_template_directory_uri() . '/img/home/header-menu-arrow-down.svg" alt="" class="header-bottom-wrap-menu-item-down__img">';
// 	}

// 	return $args;
// }
// add_filter('nav_menu_item_args', 'change_menu_item_args');


// Добавляем класс к submenu, прикрепленное к области меню menu_main
// add_filter('nav_menu_submenu_css_class', 'change_wp_nav_menu', 10, 3);

// function change_wp_nav_menu($classes, $args, $depth)
// {
// 	if ($args->theme_location == 'menu_main') {
// 		$classes[] = 'header-bottom-wrap-menu-item-submenu';
// 		// $classes[] = 'my-css-2';
// 	}

// 	return $classes;
// }


// Изменить css класс submenu 
add_filter('nav_menu_submenu_css_class', 'change_wp_nav_menu', 10, 3);

function change_wp_nav_menu($classes, $args, $depth)
{
	foreach ($classes as $key => $class) {
		if ($class == 'sub-menu') {
			$classes[$key] = 'header-bottom-wrap-menu-item-submenu';
		}
	}

	return $classes;
}
// === Menu End ========================================================================================================



add_theme_support('post-thumbnails');
set_post_thumbnail_size(185, 185);

add_post_type_support('page', 'excerpt');

// Подключение стилей и nonce для Ajax в админку 
add_action('admin_head', 'my_assets_admin');
function my_assets_admin()
{
	wp_enqueue_style("style-adm", get_template_directory_uri() . "/style-admin.css");

	wp_localize_script('jquery', 'allAjax', array(
		'nonce'   => wp_create_nonce('NEHERTUTLAZIT')
	));
}

// Подключение стилей и nonce для Ajax и скриптов во фронтенд 
add_action('wp_enqueue_scripts', 'my_assets');
function my_assets()
{

	// Подключение стилей 

	$style_version = "1.0.1";
	$scrypt_version = "1.0.1";

	// wp_enqueue_style("style-modal", get_template_directory_uri() . "/css/jquery.arcticmodal-0.3.css", array(), $style_version, 'all'); //Модальные окна (стили)
	// wp_enqueue_style("style-lightbox", get_template_directory_uri() . "/css/lightbox.min.css", array(), $style_version, 'all'); //Лайтбокс (стили)
	// wp_enqueue_style("style-slik", get_template_directory_uri() . "/css/slick.css", array(), $style_version, 'all'); //Слайдер (стили)
	// wp_enqueue_style("style-fancybox", get_template_directory_uri() . "/css/fancybox.css", array(), $style_version, 'all'); //fancybox (стили)

	wp_enqueue_style("main-style", get_stylesheet_uri(), array(), $style_version, 'all'); // Подключение основных стилей в самом конце

	// Подключение скриптов

	wp_enqueue_script('jquery'); 

	// wp_enqueue_script('amodal', get_template_directory_uri() . '/js/jquery.arcticmodal-0.3.min.js', array(), $scrypt_version, true); //Модальные окна
	// wp_enqueue_script('mask', get_template_directory_uri() . '/js/jquery.inputmask.bundle.js', array(), $scrypt_version, true); //маска для инпутов
	// wp_enqueue_script('lightbox', get_template_directory_uri() . '/js/lightbox.min.js', array(), $scrypt_version, true); //Лайтбокс
	// wp_enqueue_script('slick', get_template_directory_uri() . '/js/slick.min.js', array(), $scrypt_version, true); //Слайдер
	// wp_enqueue_script('fancybox', get_template_directory_uri() . '/js/jquery.fancybox.min.js', array(), $scrypt_version, true); //fancybox
	wp_enqueue_script('vendors', get_template_directory_uri() . '/js/vendors.min.js', array(), $scrypt_version, true); //Библиотеки
	// wp_enqueue_script('html2pdf', get_template_directory_uri() . '/js/html2pdf.bundle.js', array(), $scrypt_version, true); //Create PDF-page 

	wp_enqueue_script('main', get_template_directory_uri() . '/js/main.js', array(), $scrypt_version, true); // Подключение основного скрипта в самом конце

	if ( is_page(17)) // Корзина
	{
		wp_enqueue_script( 'vue', get_template_directory_uri().'/js/vue.js', array(), $scrypt_version, true);
		wp_enqueue_script( 'axios', get_template_directory_uri().'/js/axios.min.js', array(), $scrypt_version, true);
		wp_enqueue_script( 'bascet', get_template_directory_uri().'/js/bascet.js', array(), $scrypt_version, true); 
	}

	if ( is_page(219)) // Личный кабинет
	{
		wp_enqueue_script( 'vue', get_template_directory_uri().'/js/vue.js', array(), $scrypt_version, true);
		wp_enqueue_script( 'axios', get_template_directory_uri().'/js/axios.min.js', array(), $scrypt_version, true);
		wp_enqueue_script( 'cabinet', get_template_directory_uri().'/js/cabinet.js', array(), $scrypt_version, true);
	}

	wp_localize_script('main', 'allAjax', array(
		'ajaxurl' => admin_url('admin-ajax.php'),
		'nonce'   => wp_create_nonce('NEHERTUTLAZIT')
	));
}



// Заготовка для вызова ajax
add_action('wp_ajax_aj_fnc', 'aj_fnc');
add_action('wp_ajax_nopriv_aj_fnc', 'aj_fnc');

function aj_fnc()
{
	if (empty($_REQUEST['nonce'])) {
		wp_die('0');
	}

	if (check_ajax_referer('NEHERTUTLAZIT', 'nonce', false)) {
	} else {
		wp_die('НО-НО-НО!', '', 403);
	}
}



// Пагинация
// function wp_corenavi() {
//   global $wp_query;
//   $total = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
//   $a['total'] = $total;
//   $a['mid_size'] = 3; // сколько ссылок показывать слева и справа от текущей
//   $a['end_size'] = 1; // сколько ссылок показывать в начале и в конце
//   $a['prev_text'] = ''; // текст ссылки "Предыдущая страница"
//   $a['next_text'] = ''; // текст ссылки "Следующая страница"

//   if ( $total > 1 ) echo '<nav class="pagination">';
//   echo paginate_links( $a );
//   if ( $total > 1 ) echo '</nav>';
// }


/* Отправка почты
		
			$headers = array(
				'From: Сайт '.COMPANY_NAME.' <MAIL_RESEND>',
				'content-type: text/html',
			);
		
			add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
			
			$adr_to_send = <Присваиваем поле карбона c адресами для отправки>;
			$mail_content = "<Тело письма>";
			$mail_them = "<Тема письма>";

			if (wp_mail($adr_to_send, $mail_them, $mail_content, $headers)) {
				wp_die(json_encode(array("send" => true )));
			}
			else {
				wp_die( 'Ошибка отправки!', '', 403 );
			}
	*/


/*	Заготовка шорткода
		function true_url_external( $atts ) {
			$params = shortcode_atts( array( // в массиве укажите значения параметров по умолчанию
				'anchor' => 'Миша Рудрастых', // параметр 1
				'url' => 'https://misha.blog', // параметр 2
			), $atts );
			return "<a href='{$params['url']}' target='_blank'>{$params['anchor']}</a>";
		}
		add_shortcode( 'trueurl', 'true_url_external' );
	*/


// // Регистрация кастомного поста

// add_action( 'init', 'create_taxonomies' );

// function create_taxonomies(){

// 	register_taxonomy('ultracat', array('ultra'), array(
// 		'hierarchical'  => true,
// 		'labels'        => array(
// 			'name'              => "Категория товара",
// 			'singular_name'     => "Категория товара",
// 			'search_items'      => "Найти категорию товара",
// 			'all_items'         => __( 'Все категории' ),
// 			'parent_item'       => __( 'Дочерние категории' ),
// 			'parent_item_colon' => __( 'Дочерние категории:' ),
// 			'edit_item'         => __( 'Редактировать категорию' ),
// 			'update_item'       => __( 'Обновить категорию' ),
// 			'add_new_item'      => __( 'Добавить новую категорию товара' ),
// 			'new_item_name'     => __( 'Имя новой категории товара' ),
// 			'menu_name'         => __( 'Категории товара' ),
// 		),
// 		'description' => "Категория товаров для магазина",
// 		'public' => true,
// 		'show_ui'       => true,
// 		'query_var'     => true,
// 		'show_in_rest'  => true,
// 		'show_admin_column'     => true,
// 	));

// 	register_taxonomy('ultrastyle', array('ultra'), array(
// 		'hierarchical'  => false,
// 		'labels'        => array(
// 			'name'              => "Стиль дизайна",
// 			'singular_name'     => "Стиль дизайна",
// 			'search_items'      => "Найти стиль",
// 			'all_items'         => __( 'Все стили' ),
// 			'parent_item'       => __( 'Дочерние стили' ),
// 			'parent_item_colon' => __( 'Дочерние стили:' ),
// 			'edit_item'         => __( 'Редактировать стиль' ),
// 			'update_item'       => __( 'Обновить стиль' ),
// 			'add_new_item'      => __( 'Добавить новый стиль' ),
// 			'new_item_name'     => __( 'Имя новго стиля товара' ),
// 			'menu_name'         => __( 'Стили товара' ),
// 		),
// 		'description' => "Стиль дизайна товаров",
// 		'public' => true,
// 		'show_ui'       => true,
// 		'query_var'     => true,
// 		'show_in_rest'  => true,
// 		'show_admin_column'     => true,
// 	));
// }


// add_action('init', 'ultra_custom_init');

// function ultra_custom_init(){
// 	register_post_type('ultra', array(
// 		'labels'             => array(
// 			'name'               => 'Продукты', // Основное название типа записи
// 			'singular_name'      => 'Продукты', // отдельное название записи типа Book
// 			'add_new'            => 'Добавить новый',
// 			'add_new_item'       => 'Добавить новый товар',
// 			'edit_item'          => 'Редактировать товар',
// 			'new_item'           => 'Новый товар',
// 			'view_item'          => 'Посмотреть товар',
// 			'search_items'       => 'Найти товар',
// 			'not_found'          =>  'Товаров не найдено',
// 			'not_found_in_trash' => 'В корзине товаров не найдено',
// 			'parent_item_colon'  => '',
// 			'menu_name'          => 'Товары'

// 		  ),
// 		'taxonomies' => array('ultracat'), 
// 		'public'             => true,
// 		'publicly_queryable' => true,
// 		'show_ui'            => true,
// 		'show_in_menu'       => true,
// 		'query_var'          => true,
// 		'rewrite'            => true,
// 		'capability_type'    => 'post',
// 		'has_archive'        => true,
// 		'show_admin_column'        => true,
// 		'show_in_quick_edit'        => true,
// 		'hierarchical'       => false,
// 		'menu_position'      => 5,
// 		'supports'           => array('title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats')
// 	) );
// }

// // Колонки в таблицу админки

// add_filter('manage_posts_columns', 'posts_columns', 5);
// add_action('manage_posts_custom_column', 'posts_custom_columns', 5, 2);

// function posts_columns($defaults){
//     $defaults['riv_post_sku'] = __('Артикул');
// 	$defaults['riv_post_thumbs'] = __('Миниатюра');
// 	$defaults['riv_post_price'] = __('Цена');
// 	return $defaults;
// }

// function posts_custom_columns($column_name, $id){


// 	if($column_name === 'riv_post_sku'){
// 		$SKU_t = get_post_meta(get_the_ID(), "_offer_sku", true);
// 		echo empty($SKU_t)?"-":$SKU_t;
// 	}

// 	if($column_name === 'riv_post_thumbs'){	
// 		$img1 = get_the_post_thumbnail_url( get_the_ID(), "thumbnail");

// 		if (empty($img1))
// 			$img1 = get_bloginfo("template_url")."/img/no-photo.jpg";

// 		echo '<img width = "60" src = "'.$img1.'" />';


// 	}

// 	if($column_name === 'riv_post_price'){
// 		$PRICE = get_post_meta(get_the_ID(), "_offer_price", true);
// 		echo empty($PRICE)?"0 руб.":$PRICE." руб.";
// 	}


// }


// Отправка формы из модального окна
add_action('wp_ajax_sendphone', 'sendphone');
add_action('wp_ajax_nopriv_sendphone', 'sendphone');

function sendphone()
{
	if (empty($_REQUEST['nonce'])) {
		wp_die('0');
	}

	if (check_ajax_referer('NEHERTUTLAZIT', 'nonce', false)) {

		$headers = array(
			'From: Сайт ' . COMPANY_NAME . ' <' . MAIL_RESEND . '>',
			'content-type: text/html',
		);

		add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
		if (wp_mail(carbon_get_theme_option('as_email_send'), 'Заказ звонка', '<strong>Имя:</strong> ' . $_REQUEST["name"] . ' <br/> <strong>Телефон:</strong> ' . $_REQUEST["tel"], $headers))
			wp_die("<span style = 'color:green;'>Мы свяжемся с Вами в ближайшее время.</span>");
		else wp_die("<span style = 'color:red;'>Сервис недоступен попробуйте позднее.</span>");
	} else {
		wp_die('НО-НО-НО!', '', 403);
	}
}


// Отправка корзины ================================================
function tovarTo1c($bascetElem) {
	return 
	"<Товар>\n\r".
		"<Ид>".$bascetElem->sku1c."</Ид>\n\r".
		'<Наименование>'.$bascetElem->name.'</Наименование>\n\r'.
		'<БазоваяЕдиница Код="796" НаименованиеПолное="Штука" МеждународноеСокращение="PCE">шт</БазоваяЕдиница>\n\r'.
		"<ЦенаЗаЕдиницу>".$bascetElem->price."</ЦенаЗаЕдиницу>\n\r".
		"<Количество>".$bascetElem->count."</Количество>\n\r".
		"<Сумма>".$bascetElem->subtotal."</Сумма>\n\r".
		"<ЗначенияРеквизитов>\n\r".
			"<ЗначениеРеквизита>\n\r".
				"<Наименование>ВидНоменклатуры</Наименование>\n\r".
				"<Значение>Товар</Значение>\n\r".
			"</ЗначениеРеквизита>\n\r".
			
			"<ЗначениеРеквизита>\n\r".
				"<Наименование>ТипНоменклатуры</Наименование>\n\r".
				"<Значение>Товар</Значение>\n\r".
			"</ЗначениеРеквизита>\n\r".
		"</ЗначенияРеквизитов>\n\r".
	"</Товар>\n\r";
}	

function sendToFtp($fileAdr, $zak_number) {
	$ftp_server = "81.177.141.133";
	$ftp_user_name = "asmi046_1s";
	$ftp_user_pass = "!#(yTY)uz9d8";

	$conn_id = ftp_connect($ftp_server);
	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
	ftp_pasv($conn_id, true);
	if ((!$conn_id) || (!$login_result)) {
		return false;
	} else {
		$upload = ftp_put ($conn_id, "orders/".$zak_number.".xml", $fileAdr, FTP_ASCII);
		return true;
	}
	ftp_close($conn_id);
}

add_action( 'wp_ajax_send_cart', 'send_cart' );
add_action( 'wp_ajax_nopriv_send_cart', 'send_cart' );

function send_cart() {
	if ( empty( $_REQUEST['nonce'] ) ) {
		wp_die( '0' );
	}
	
	if ( check_ajax_referer( 'NEHERTUTLAZIT', 'nonce', false ) ) {

		$headers = array(
			'From: Сайт '.COMPANY_NAME.' <'.MAIL_RESEND.'>',
			'content-type: text/html',
		);
	
		add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
		
		$adr_to_send = carbon_get_theme_option("as_email_send");
		$adr_to_send = (empty($adr_to_send))?"asmi046@gmail.com":$adr_to_send;
		
		$zak_number = "A".date("H").date("i").date("s").rand(100,999);

		$mail_content = "<h1>Заказ на сайте №".$zak_number."</h1>";
		
		$bscet_dec = json_decode(stripcslashes ($_REQUEST["bascet"]));
		
		// Отправка в базу основного заказа

		global $wpdb;
		$wpdb->insert( "shop_zakhistory", array(
			"agent" => empty($_COOKIE["agriautorise"])?"":$_COOKIE["agriautorise"],
			"zak_number" => $zak_number,
			"zak_summ" => $_REQUEST["bascetsumm"],
			"zak_count" => count($bscet_dec),
			"client_name" => $_REQUEST["name"],
			"client_phone" => $_REQUEST["phone"],
			"client_mail" => $_REQUEST["mail"],
			"client_adr" => $_REQUEST["adres"],
			"client_comment" => $_REQUEST["comment"],
		) );


		$mail_content .= "<table style = 'text-align: left;' width = '100%'>";
			$mail_content .= "<tr>";
				$mail_content .= "<th></th>";
				$mail_content .= "<th>ТОВАР</th>";
				$mail_content .= "<th>КОЛИЧЕСТВО</th>";
				$mail_content .= "<th>СУММА</th>";
			$mail_content .= "</tr>";

			$toXMLstr = "";

			for ($i = 0; $i<count($bscet_dec); $i++) {
				$toXMLstr .= tovarTo1c($bscet_dec[$i]);
				$mail_content .= "<tr>";
					$mail_content .= "<td><img src = '".$bscet_dec[$i]->picture."' width = '70' height = '70'></td>";
					$mail_content .= "<td><a href = '".$bscet_dec[$i]->lnk."'>".$bscet_dec[$i]->name." / ".$bscet_dec[$i]->sku."</a></td>";
					$mail_content .= "<td>".$bscet_dec[$i]->count."</td>";
					$mail_content .= "<td>".$bscet_dec[$i]->subtotal." р.</td>";
				$mail_content .= "</tr>";

				// Отправка в базу содержимого корзины

				$wpdb->insert( "shop_zaktovar", array(
					"zak_number" => $zak_number,
					 "price" => $bscet_dec[$i]->price,
					 "price_old" => empty($bscet_dec[$i]->oldprice)?"":$bscet_dec[$i]->oldprice,
					 "subtotal" => $bscet_dec[$i]->subtotal,
					"sku" => $bscet_dec[$i]->sku,
					"lnk" => $bscet_dec[$i]->lnk,
					"name" => $bscet_dec[$i]->name,
					"count" => $bscet_dec[$i]->count,
					"picture" => $bscet_dec[$i]->picture,
				) );

			}

		$mail_content .= "</table>";
		$mail_content .= "<h2>Сумма: ".$_REQUEST["bascetsumm"]." р.</h2>";


		 $zaktpl = file_get_contents(__DIR__.'/zaktempl.xml', true);
		// ---- Формирование файла для 1С

		$clname = 	explode(" ", $_REQUEST["name"])[0];
		$clnames = 	explode(" ", $_REQUEST["name"])[1];

		 $zaktpl = str_replace("{zaknum}", $zak_number, $zaktpl);
		 $zaktpl = str_replace("{zakdata}", date("Y-m-d"), $zaktpl);
		 $zaktpl = str_replace("{zaksumm}", $_REQUEST["bascetsumm"], $zaktpl);
		 $zaktpl = str_replace("{zaktime}", date("H:i:s"), $zaktpl);
		 $zaktpl = str_replace("{name}", $clname, $zaktpl);
		 $zaktpl = str_replace("{inn}", ($_REQUEST["inn"] == "null")?"":$_REQUEST["inn"], $zaktpl);
		 $zaktpl = str_replace("{sname}", $clnames, $zaktpl);
		 $zaktpl = str_replace("{adr}", $_REQUEST["adres"], $zaktpl);
		 $zaktpl = str_replace("{clientname}", $clname." ".$clnames, $zaktpl);
		 $zaktpl = str_replace("{clientnamefull}", $clname." ".$clnames, $zaktpl);
		 $zaktpl = str_replace("{clienphone}",  $_REQUEST["phone"], $zaktpl);
		 $zaktpl = str_replace("{clientmail}", $_REQUEST["mail"], $zaktpl);
		 $zaktpl = str_replace("{zakcomment}", $_REQUEST["comment"], $zaktpl);
		 $zaktpl = str_replace("{tovars}", $toXMLstr, $zaktpl);
		
		 $fileAdr = __DIR__."/1s/orders/".$zak_number.".xml";
		 file_put_contents($fileAdr, $zaktpl);
		
		 $ftprez = sendToFtp($fileAdr, $zak_number);

		$mail_content .= "<strong>Имя:</strong> ".$_REQUEST["name"]."<br/>";
		$mail_content .= "<strong>Телефон:</strong> ".$_REQUEST["phone"]."<br/>";
		$mail_content .= "<strong>e-mail:</strong> ".$_REQUEST["mail"]."<br/>";
		$mail_content .= "<strong>Адрес:</strong> ".$_REQUEST["adres"]."<br/>";
		$mail_content .= "<strong>Комментарий:</strong> ".$_REQUEST["comment"]."<br/>";
		// $mail_content .= "<strong>FTP:</strong> ".($ftprez)?"Загружен":"Не загружен"."<br/>";

		$mail_them = "Заказ на сайте Strader";


		
		if (wp_mail($adr_to_send, $mail_them, $mail_content, $headers)) 
		{

			wp_die(json_encode(array("send" => true )));
		}
		else {
			wp_die( 'Ошибка отправки!', '', 403 );
		}
		
	} else {
		wp_die( 'НО-НО-НО!', '', 403 );
	}
}


// Личный кабинет ==================================================
// Регистрация
add_action( 'wp_ajax_user_register', 'user_register' );
add_action( 'wp_ajax_nopriv_user_register', 'user_register' );

function user_register() {
	if ( empty( $_REQUEST['nonce'] ) ) {
		wp_die( '0' );
	}
	
	if ( check_ajax_referer( 'NEHERTUTLAZIT', 'nonce', false ) ) {
	
	global $wpdb;
		
	$email_key = rand(10000, 99999);

	$insert_rez = $wpdb->insert( "shop_users", array(
		"name" => $_REQUEST["name"],
		"company_name" => $_REQUEST["nameorg"],
		"mail" => $_REQUEST["email"],
		"phone" => $_REQUEST["tel"],
		"inn" => $_REQUEST["inn"],
		"password" => md5($_REQUEST["password"]."agrib"),
		"autorize" => 0,
		"autorizeKey" => $email_key
	) );

	if (!empty($insert_rez)) {
		$headers = array(
			'From: Сайт '.COMPANY_NAME.' <'.MAIL_RESEND.'>', 
			'content-type: text/html',
		);
		
		add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
	 
		$mail_message = 
		"<h1>Подтверждение регистрации в личном кабинете Agribest.ru</h1>".
		"<p>Уважаемый клиент, для подтверждения учетной записи перейдите по ссылке:<p>".
		"<a href = '".get_the_permalink(230)."?id=".$wpdb->insert_id."&k=".$email_key."'>Активировать учетную запись.</a>";
	
		if (wp_mail($_REQUEST["email"], "Подтверждение регистрации", $mail_message, $headers))
		{
			$mail_message = 
			"<h1>В личном кабинете зарегистрированна компания:</h1>".
			"Представитель: <strong>".$_REQUEST["name"]."</strong> <br/>".
			"Организация: <strong>".$_REQUEST["nameorg"]."</strong> <br/>".
			"ИНН: <strong>".$_REQUEST["inn"]."</strong> <br/>".
			"E-mail: <strong>".$_REQUEST["email"]."</strong> <br/>".
			"Телефон: <strong>".$_REQUEST["tel"]."</strong> <br/>";

			wp_mail(carbon_get_theme_option( 'as_email_send' ), "Регистрация в личном кабинете", $mail_message, $headers);

			wp_die(json_encode(array("send" => true )));
		}
		else 
			 wp_die( 'Mail no send!', '', 403 );	

	} else {
		wp_die( 'Bad insert to base!', '', 403 );		
	}

		
		
	} else {
		wp_die( 'НО-НО-НО!', '', 403 );
	}
}

// Восстановление пароля
add_action( 'wp_ajax_pass_rec', 'pass_rec' );
add_action( 'wp_ajax_nopriv_pass_rec', 'pass_rec' );

function pass_rec() {
	if ( empty( $_REQUEST['nonce'] ) ) {
		wp_die( '0' );
	}
	
	if ( check_ajax_referer( 'NEHERTUTLAZIT', 'nonce', false ) ) {
	
	global $wpdb;
		
	$email_key = rand(1000, 9999);

	$user_feeld =  $wpdb->get_results("SELECT * FROM `shop_users` WHERE `mail` = '".$_REQUEST["email"]."'");
	if (!empty($user_feeld)) {
		
		$updateRez = $wpdb->update("shop_users",
																 array(
									 "autorizeKey" => $email_key,
																 ), 
																 array(
																		 "id" => $user_feeld[0]->id, 
																 )
															);   

		$headers = array(
			'From: Сайт '.COMPANY_NAME.' <'.MAIL_RESEND.'>', 
			'content-type: text/html',
		);
		
		add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
	 
		$mail_message = 
		"<h1>Восстановление пароля</h1>".
		"<p>Для восстановления пароля к Вашей учетной записи перейдите по ссылке:<p>".
		"<a href = '".get_the_permalink(226)."?id=".$user_feeld[0]->id."&k=".$email_key."'>Восстановить пароль.</a>";
	
		if (wp_mail($user_feeld[0]->mail, "Восстановление пароля", $mail_message, $headers))
		{
			wp_die(json_encode(array("send" => true )));
		}
		else 
			 wp_die( 'Mail no send!', '', 403 );	

	} else {
		wp_die( 'No user in base!', '', 403 );		
	}

		
		
	} else {
		wp_die( 'НО-НО-НО!', '', 403 );
	}
}

// Авторизация
add_action( 'wp_ajax_user_autorization', 'user_autorization' );
add_action( 'wp_ajax_nopriv_user_autorization', 'user_autorization' );

function user_autorization() {
	if ( empty( $_REQUEST['nonce'] ) ) {
		wp_die( '0' );
	}
	
	if ( check_ajax_referer( 'NEHERTUTLAZIT', 'nonce', false ) ) {
	$mail = $_REQUEST["email"];
	$password = $_REQUEST["password"];
	$passwordSalt = md5($_REQUEST["password"]."agrib");

	$token = rand(200000, 300000);

	global $wpdb;
	$user_feeld =  $wpdb->get_results("SELECT * FROM `shop_users` WHERE `mail` = '".$mail."' AND `password` =  '".$passwordSalt."'");

	if (!empty($user_feeld)) {
		if (empty($user_feeld[0]->autorize))
			wp_die(json_encode(array("error" => "Учетная запись не активирована. Проверьте e-amil в том числе и папку 'Спам'" )), '', 403);
		
		$updateRez = $wpdb->update("shop_users",
			array(
				"autorizeKey" => $token,
			), 
			array(
				"id" => $user_feeld[0]->id, 
			)
		 );   

		wp_die(json_encode(array(
			"name" => $user_feeld[0]->name,
			"company_name" => $user_feeld[0]->company_name,
			"mail" => $user_feeld[0]->mail,
			"phone" => $user_feeld[0]->phone,
			"inn" => $user_feeld[0]->inn,
			"token" => $token
		)));
		

	} else {
		wp_die(json_encode(array("error" => "Пользователь с таким E-mail не найден.", "q" => "" )), '', 403);
	}

		
		
	} else {
		wp_die( 'НО-НО-НО!', '', 403 );
	}
}

// Подтверждение
add_action( 'wp_ajax_relogin', 'relogin' );
add_action( 'wp_ajax_nopriv_relogin', 'relogin' );

function relogin() {
	if ( empty( $_REQUEST['nonce'] ) ) {
		wp_die( '0' );
	}
	
	if ( check_ajax_referer( 'NEHERTUTLAZIT', 'nonce', false ) ) {
	
	$mail = $_REQUEST["email"];
	
	global $wpdb;

	
	$updateRez = $wpdb->update("shop_users",
			array(
				"autorizeKey" => 0,
			), 
			array(
				"mail" => $mail, 
			)
		 );  
		 wp_die(json_encode(array("dell"=> true))); 
		
	} else {
		wp_die( 'НО-НО-НО!', '', 403 );
	}
}

add_action( 'wp_ajax_get_zakinfo', 'get_zakinfo' );
add_action( 'wp_ajax_nopriv_get_zakinfo', 'get_zakinfo' );

function get_zakinfo() {
	if ( empty( $_REQUEST['nonce'] ) ) {
		wp_die( '0' );
	}
	
	if ( check_ajax_referer( 'NEHERTUTLAZIT', 'nonce', false ) ) {
	
	$token = $_COOKIE["agritoken"];
	$email = $_COOKIE["agriautorise"];
	

	global $wpdb;
	$userVerefy = $wpdb->get_results("SELECT * FROM `shop_users` WHERE `mail` = '".$email."' AND `autorizeKey` = '".$token."'");

	if (empty($userVerefy)) {
		wp_die(json_encode(array("error"=> "Верификация не пройденав")), '', 403); 
	}

	$klientZak = $wpdb->get_results("SELECT * FROM `shop_zakhistory` WHERE `agent` = '".$email."'");

	$compileResult = array();

	foreach($klientZak as $elem)
		$compileResult[$elem->zak_number] = array(
			"zak_info" => $elem,
			"open_detale" => false,
			"zak_detale" => array()
		);	 

	wp_die(json_encode($compileResult)); 	
		
	} else {
		wp_die( 'НО-НО-НО!', '', 403 );
	}
}

add_action( 'wp_ajax_get_zak_detail', 'get_zak_detail' );
add_action( 'wp_ajax_nopriv_get_zak_detail', 'get_zak_detail' );

function get_zak_detail() {
	if ( empty( $_REQUEST['nonce'] ) ) {
		wp_die( '0' );
	}
	
	if ( check_ajax_referer( 'NEHERTUTLAZIT', 'nonce', false ) ) {
	
	$token = $_COOKIE["agritoken"];
	$email = $_COOKIE["agriautorise"];
	

	global $wpdb;
	$userVerefy = $wpdb->get_results("SELECT * FROM `shop_users` WHERE `mail` = '".$email."' AND `autorizeKey` = '".$token."'");

	if (empty($userVerefy)) {
		wp_die(json_encode(array("error"=> "Верификация не пройденав")), '', 403); 
	}

	$klientZakDetale = $wpdb->get_results("SELECT * FROM `shop_zaktovar` WHERE `zak_number` = '".$_REQUEST["zaknumber"]."'");
 

	wp_die(json_encode($klientZakDetale)); 	
		
	} else {
		wp_die( 'НО-НО-НО!', '', 403 );
	}
}

	
?>