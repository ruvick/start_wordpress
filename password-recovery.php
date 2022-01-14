<?php get_header();

/**
 * Template Name: Шаблон страницы Восстановление пароля
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
        <?
				global $wpdb;
				  $user_feeld =  $wpdb->get_results("SELECT * FROM `shop_users` WHERE `id` = '".$_REQUEST["id"]."'");
			  ?>
			  <h1 class="header-sec__title"><?php the_title();?> для пользователя: <?echo $user_feeld[0]->mail?></h1>	
  		</div>
		</section>

	<section class = "content">
		<div class="_container">

			<form action="#" class="authoriz__form reviews__form">
				<input type="hidden" name = "id" value = "<?echo $_REQUEST["id"];?>" >
				<input type="hidden" name = "k" value = "<?echo $_REQUEST["k"];?>" >
				<input type="password" name="password1" autocomplete="new-password"  placeholder="Пароль*" id="form-pass1" class="reviews__form-input input">
				<input type="password" name="password2" autocomplete="new-password"  placeholder="Пароль еще раз*" id="form-pass2" class="reviews__form-input input">
				
				<div class = "btn_wrapper">	
					<input type="submit" name = "pass_rec_sub" class="btn" value = "Восстановить">
				</div>
			</form> 

			<?
			if (isset($_REQUEST["pass_rec_sub"]))  
			{
			if (empty($_REQUEST["password1"])||empty($_REQUEST["password2"])) {
				?>
					<div class = "messageFormBlk">
						Введенные пароли пусты!
					</div>
				<?
			} else 
			if (($_REQUEST["password1"] !== $_REQUEST["password2"]))
			{
				?>
					<div class = "messageFormBlk">
						Введенные пароли не совпадают!
					</div>
				<?
			} else
				if ($_REQUEST["k"] !== $user_feeld[0]->autorizeKey) {
					?>
						<div class = "messageFormBlk">
							Ключи безопасности не совпадают!
						</div>
					<?
				} else

				
				{
					$updateRez = $wpdb->update("shop_users",
                                   array(
									   "autorizeKey" => 0,
									   "password" => md5($_REQUEST["password1"]."agrib")
                                   ), 
                                   array(
                                       "id" => $user_feeld[0]->id, 
                                   )
                                ); 
				if (empty ($updateRez)) {				  
			?>
				<div class = "messageFormBlk">
						Не удалось обновить пароль попробуйте позднее
				</div>
			<?		
				} else {
					?>
						<div class = "messageFormBlk messageFormBlkOk">
								Пароль успешно изменен!
						</div>
					<?
				}
			}
		}
			?>

		</div>
	</section>

</main>
<?php get_footer(); ?> 