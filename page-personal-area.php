<?php get_header();

/**
 * Template Name: Шаблон страницы Личный кабинет
 * Template Post Type: page
 */

?>

<?php get_template_part('template-parts/header-section');?>

<main id="primary" class="page site-main main"> 

	<template id = "autorisation">

		<section class = "header-sec-content">
			<div class="header-sec">
  			<div class="_container">
					<?php
						if ( function_exists('yoast_breadcrumb') ) {
							yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );   
						}
					?> 
    			<h1 class="header-sec__title">Авторизация</h1> 
  			</div>
			</div>
		<div class="content">
			<div class="_container">

				<form action="#" class="authoriz__form reviews__form">
					<input v-model="email" :class = "{dontz:emailNotEnter}" autocomplete="off" type="email" name="email" placeholder="Email" id="form-emailw" class="reviews__form-input input">
					<input v-model="password" :class = "{dontz:passwordNotEnter}" autocomplete="new-password" type="password" name="password" placeholder="Пароль" id="form-telw" class="reviews__form-input input">
					<div class = "btn_wrapper">
						<button @click.prevent  = "getAutorisation"  type="button" class="authoriz__form-btn reviews__form-btn agriwind btn">Войти</button>
						<button @click.prevent  = "toRegister" type="button" class="authoriz__form-btn_register reviews__form-btn agriwind btn btn-tr" id = "registerbtn">Регистрация</button>
					</div>

					<div class = "btn_wrapper" id = "passRecoveryWrapper">
						<a @click.prevent = "toPasRec" href = "#">Не можете войти в личный кабинет?</a>
					</div>

					<div v-show = "showMsgBlk" :class = "{messageFormBlkOk : msgOk}" class = "messageFormBlk">
						{{messageText}}
					</div>

				</form> 

			</div>
			</div>
		</section>
	</template>


	<template id = "registration">
	<section class = "header-sec-content">
			<div class="header-sec">
  			<div class="_container">
					<?php
						if ( function_exists('yoast_breadcrumb') ) {
							yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );  
						}
					?> 
    			<h1 class="header-sec__title">Регистрация</h1>
  			</div>
			</div>
		<div class="content">
			<div class="_container">

				<form autocomplete="off" action="#" class="authoriz__form reviews__form">
					<input v-model="name" :class = "{dontz:nameNotEnter}" autocomplete="off" type="text" name="name" placeholder="ФИО контактного лица*" id="form-namew" class="reviews__form-input input">
					<input v-model="nameorg" :class = "{dontz:nameorgNotEnter}" autocomplete="off" type="text" name="nameorg" placeholder="Наименование организации*" id="form-nameorgw" class="reviews__form-input input">
					<input v-model="inn" autocomplete="off" type="text" name="inn" placeholder="ИНН организации" id="form-innw" class="reviews__form-input input">
					<input v-model="email" :class = "{dontz:emailNotEnter}" autocomplete="off" type="email" name="email" placeholder="Email*" id="form-emailw" class="reviews__form-input input">
					<input v-model="tel" autocomplete="off" type="tel" name="tel" placeholder="Телефон" id="form-telw" class="reviews__form-input input">
					<input v-model="password" :class = "{dontz:passwordNotEnter}" type="password" name="password" autocomplete="new-password"  placeholder="Пароль*" id="form-telw" class="reviews__form-input input">
					<div class = "btn_wrapper">
						<button @click.prevent  = "registerUser" type="button" class="authoriz__form-btn_register reviews__form-btn agriwind btn">Зарегистрироваться</button>
						<button  @click.prevent  = "toAutorization" type="button" class="reviews__form-btn agriwind btn btn-tr" id = "registerbtn">Авторизация</button>
					</div>

					<div v-show = "showMsgBlk" :class = "{messageFormBlkOk : msgOk}" class = "messageFormBlk">
						{{messageText}}
					</div>
				</form> 

			</div>
			</div>
		</section>
	</template>

	<template id = "passrec">
	<section class = "header-sec-content">
			<div class="header-sec">
  			<div class="_container">
					<?php
						if ( function_exists('yoast_breadcrumb') ) {
							yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );  
						}
					?> 
    			<h1 class="header-sec__title">Восстановление пароля</h1>
  			</div>
			</div>
		<div class="content">
			<div class="_container">

				<form action="#" class="authoriz__form reviews__form">
					<input v-model="email"  :class = "{dontz:emailNotEnter}" type="email" name="email" placeholder="Email" id="form-emailw" class="reviews__form-input input">
					<div class = "btn_wrapper">
						<button @click.prevent = "getPassRec" type="submit" class="authoriz__form-btn_register reviews__form-btn agriwind btn">Восстановить</button>
						<button  @click.prevent  = "toAutorization" type="button" class="reviews__form-btn agriwind btn btn-tr" id = "registerbtn">Авторизация</button>
					</div>

					<div v-show = "showMsgBlk" :class = "{messageFormBlkOk : msgOk}" class = "messageFormBlk">
						{{messageText}}
					</div>
				</form> 

			</div>
			</div>
		</section>
	</template>
	
	<template id = "kabinet">
		<section class = "header-sec-content personal">
			<div class="header-sec">
  			<div class="_container">
					<?php
						if ( function_exists('yoast_breadcrumb') ) {
							yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );  
						}
					?> 
    			<h1 class="header-sec__title">Личный кабинет</h1>
  			</div>
			</div>
		<div class="content">
			<div class="_container">
				<div class = "kabinet_control_panel">
					<div class = "kabinet_register_info">
						<span class="company_name">
							<strong>Компания: </strong> {{company}}
						</span>
						<span class="company_inn">
							<strong>ИНН: </strong> {{inn}}
						</span>
						<span class="company_mail">
							<strong>e-mail: </strong> {{email}}
						</span>
					</div>
					<div class ="controllWrapper">
						<a @click.prevent = "relogin" class = "controlGrItem" href = "">Выйти из кабинета</a> 
					</div>
				</div>

				<div class="personal__row product__box product__row">
					<div v-for = "(item, index, key) in UsserZakaz" class="product__wr">
						<div class="product cabinet_wrapper">
							<h3 class="product__name"><strong>{{item.zak_info.zak_number}}</strong> от {{item.zak_info.zak_data}}</h3>
							<span class="db product__price">{{item.zak_info.zak_summ}} руб.</span>
							<div class="product__bottom">
								<a @click.prevent = "getZakDetales(item.zak_info.zak_number)" href="#" class="db btn btn__details">Подробнее</a>
								
							</div>
							
						</div>

						<div v-show = "item.open_detale" class = "zakazDetale">
								<div class="detail_tovar_elem detail_tovar_elem_head">
									<div class = "gridItem pwrapper">Товар</div>
									<span class ="gridItem  tName">
										Наименование
									</span>
									<span class ="gridItem tSKU">Артикул</span>
									<span class ="gridItem  tCount">Кол.во</span>
									<span class ="gridItem tPrice">Цена</span>
								</div>

								<div v-for = "(itemSub, indexSub, keySub) in item.zak_detale" class = "detail_tovar_elem">
									<div class = "gridItem pwrapper"><img :src = "itemSub.picture" /></div>
									<span class ="gridItem tName">
										<a :href = "itemSub.lnk">{{itemSub.name}}</a>
									</span>
									<span class ="gridItem tSKU">{{itemSub.sku}}</span>
									<span class ="gridItem tCount">{{itemSub.count}}</span>
									<span class ="gridItem tPrice">{{itemSub.price}}</span>
								</div>

								<button @click.prevent = "repeatZak(item.zak_detale, item.zak_info.zak_summ)" class="btn btn__zak_repeat ">Повторить</button>
							</div>
					</div>
					        
				</div>

			</div>
			</div>
		</section>
	</template>

	<div id = "main_cabinet">
		<autorisation v-show="showAutorize" ></autorisation>
		<registration v-show="showRegistration" ></registration>
		<passrec v-show="showPassRec" ></passrec>
		<kabinet v-show="showKabinet"></kabinet>
	</div>
</main>
<?php get_footer(); ?> 