<!DOCTYPE html>
<html lang="ru">
<head>

  <title><?php wp_title(); ?></title>

  <meta charset="UTF-8">
  <meta name="format-detection" content="telephone=no">
  <meta name="description" content="Новый сайт"> 
  
  <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri();?>/img/favicons/icon256.png" sizes="256x256">
  <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri();?>/img/favicons/icon128.png" sizes="128x128">
  <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri();?>/img/favicons/icon64.png" sizes="64x64">
  <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri();?>/img/favicons/icon32.png" sizes="32x32">
  <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri();?>/img/favicons/icon16.png" sizes="16x16">
  <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri();?>/img/favicons/fav.svg" sizes="any">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">  

  <?php wp_head();?>  
  
  <!-- Yandex.Metrika counter -->
  <?php echo carbon_get_theme_option('code_yandex_metrica'); ?>
  <!-- /Yandex.Metrika counter -->

  <!-- Google.Metrika counter -->
  <?php echo carbon_get_theme_option('code_google_counter'); ?>
  <!-- /Google.Metrika counter -->

  <!-- Дополнительный код -->
  <?php echo carbon_get_theme_option('additional_code_head'); ?>
  <!-- /Дополнительный код -->

</head>
<body>

  <!-- Дополнительный код -->
  <?php echo carbon_get_theme_option('additional_code_body'); ?>
  <!-- /Дополнительный код -->

<!-- Скрипт корзины, отправка, личный кабинет -->
<script>  
  let main_page = "<?echo get_bloginfo("url"); ?>";
  let kabinet_page = "<?echo get_the_permalink(219); ?>";
  let bascet_page = "<?echo get_the_permalink(17); ?>"; 
  let thencs_page = "<?echo get_the_permalink(56); ?>"; 
  let nophoto_page = "<?echo get_bloginfo("template_url");?>/img/no-photo.jpg";
</script> 
  <div class="wrapper">  
    <!-- Подключение  модальных окон-->
    <? include "modal-win.php";?>