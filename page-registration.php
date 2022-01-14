<?php get_header();

/**
 * Template Name: Шаблон страницы Регистрация
 * Template Post Type: page
 */

 ?>

<?php get_template_part('template-parts/header-section');?>

	<main id="primary" class="page site-main main"> 

		<section class="header-sec">
  		<div class="_container">
				<?php
					if ( function_exists('yoast_breadcrumb') ) {
						yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );  
					}
				?> 
    		<h1 class="header-sec__title"><?php the_title();?></h1>
  		</div>
		</section>

		<section class="content"> 
			<div class="_container">
			  <form action="#" class="authoriz__form reviews__form">
				  <input type="text" name="name" placeholder="ФИО" id="form-namew" class="reviews__form-input input">
				  <input type="tel" name="tel" placeholder="Телефон*" id="form-telw" class="reviews__form-input input">
				  <input type="email" name="email" placeholder="Email" id="form-emailw" class="reviews__form-input input">
				  <input type="text" name="name" placeholder="Наименование организации" id="form-namew" class="reviews__form-input input">
				  <input type="password" name="password" placeholder="Пароль" id="form-telw" class="reviews__form-input input">
				  <input type="password" name="password" placeholder="Подтверждение пароля" id="form-telw" class="reviews__form-input input">
				  <button type="submit" class="authoriz__form-btn_register reviews__form-btn agriwind btn">Зарегистрироваться</button>
			  </form> 
			</div>
		</section>
	</main>

<?php get_footer();