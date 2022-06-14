<?php get_header();

/**
 * Template Name: Шаблон страницы Авторизация
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
    		<h1 class="header-sec__title">Авторизация</h1>
  		</div>
		</section>

		<section class="content"> 
			<div class="_container">
				<form action="#" class="authoriz__form reviews__form">
					<input type="email" name="email" placeholder="Email" id="form-emailw" class="reviews__form-input input">
					<input type="password" name="password" placeholder="Пароль" id="form-telw" class="reviews__form-input input">
					<button type="submit" class="reviews__form-btn product-sec__info-btn-bascet agriwind btn">Войти</button>
				</form> 
			</div>
		</section>
	</main>

<?php get_footer();