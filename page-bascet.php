<?php 
/**
 * Template Name: Корзина
 * Template Post Type: page
 */

get_header(); ?>

<!-- События на кнопке -->
<button class="btn btn__to-card" id = "btn__to-card" onclick = "add_tocart(this, 0); return false;"
  data-price = "<?echo carbon_get_post_meta(get_the_ID(),"offer_price"); ?>"
  data-sku = "<? echo carbon_get_post_meta(get_the_ID(),"offer_sku")?>"
  data-size = ""
  data-oldprice = "<? echo carbon_get_post_meta(get_the_ID(),"offer_old_price")?>"
  data-lnk = "<? echo  get_the_permalink(get_the_ID());?>"
  data-name = "<? echo  get_the_title();?>"
  data-count = "1"
  data-picture = "<?php echo wp_get_attachment_image_src($item['gal_img'], 'large')[0];?>"

  data-picture = "<?php  $imgTm = get_the_post_thumbnail_url( get_the_ID(), "tominiatyre" ); echo empty($imgTm)?get_bloginfo("template_url")."/img/no-photo.jpg":$imgTm; ?>">
    Добавить в корзину
</button> 

<?php get_template_part('template-parts/header-section');?>

<main class="main page">	

<section class = "content">
		<div class="_container">

			<div class="bread-crumbs-box">
				<?php
					if ( function_exists('yoast_breadcrumb') ) {
					yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
					}
				?>  
			</div>
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <h1><?php the_title();?></h1>
        <?php the_content();?>
      <?php endwhile;?>
      <?php endif; ?>
		</div>
	</section>

        
        
        <template id = "bascet">
            
            <table v-if = "bascet.length > 0" class = "bascet_page_table">
                    <thead>
                        <tr>   
                            <th class = "prev"></th>
                            <th class = "name">Название</th>
                            <th class = "count">Колличество</th>
                            <th class = "price">Цена</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr  v-for = "(item, index, key) in bascet" >
                            <td> <img :src = "item.picture" /> </td>
                            <td class = "name">
                                <div class = "b_tov_name">{{item.name}}</div>
                                <div class = "b_tov_sku">Артикул: {{item.sku}} Размер: {{item.size}}</div>
                            </td>
                            <td>
                                <input type = "number"  @change = "recalcBascet" v-model="item.count" min = "0" />
                            </td>
                            <td class = "price">
                                <span class = "subtotalprice">{{item.subtotal}}</span>р
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>   
                            <td></td>
                            <td class = "name">Итого:</td>
                            <td>{{bascetCount}}</td>
                            <td class = "price"><span class = "totalprice">{{bascetSumm}}</span>р</td>
                        </tr>
                    </tfoot>
            </table>
            <strong class = "bascet_empty_string" v-else>Ваша корзина пуста</strong>
           
        </template>

        <template id = "bascet-form">
            <form v-show = "shoved" class = "bascet_form">
                <h2>Оформить заказ</h2>    
                <div class = "form-line">
                    <label for = "id_fio">Имя, Фамилия*</label>
                    <div class="form-item">    
                        <input id="id_fio" class="bascet-form__input" maxlength="255" name="fio" v-model="name" type="text" placeholder="Например, Александр">
                        
                    </div>
                </div>

                <div class="form-line">
                    <label for="id_email" id="p_id_email" class="form-label">E-mail*</label>
                    <div class="form-item">    
                        <input id="id_email" class="bascet-form__input" maxlength="255" name="email" v-model="mail"  type="email" placeholder="alex-ivanov@gmail.com">
                        
                    </div>
                </div>

                <div class="form-line">
                    <label for="id_phone" id="p_id_phone" class="form-label">Телефон*</label>
                    <div class="form-item">    
                        <input id="id_phone" class="bascet-form__input" maxlength="255" name="phone" v-model="phone" type="tel" placeholder="+7-991-441-48-43">
                        
                    </div>
                </div>

                <div class="form-line">
                    <label for="id_address" id="p_id_address" class="form-label">Адрес</label>
                    <div class="form-item">    
                        <textarea cols="40" class="bascet-form__textarea" id="id_address" name="address" v-model="adres" rows="10"></textarea>
                        <div class="form-help-text">ул. Строителей, д. 10, корп. 12, кв. 38, под. 3, код: 58а</div>
                    </div>
                </div>

                <div class="form-line">
                    <label for="id_comment" id="p_id_comment" class="form-label">Комментарии</label>
                    <div class="form-item">    
                        <textarea cols="40" class="bascet-form__textarea" id="id_comment" name="comment" v-model="comment" rows="10"></textarea>
                        <div class="form-help-text">Позвонить курьеру за час до выезда.</div>  
                    </div>
                </div>

                <div class="form-line">
                    <label>    
                        <input v-model="checpolicy" id="id_i_agree" name="i_agree" type="checkbox">
                        <div class="form-help-text-main">Ставя отметку, я даю своё согласие на обработку моих персональных данных в соответствии с законом №152-ФЗ "О персональных данных" от 27.07.2006 и <a href="/page/i-agree/">принимаю условия пользовательского соглашения и политики в области обработки персональных данных</a>.</div>
                    </label>
                </div>

                <div class = "form_submit_line btn-wrapper">
                    <button @click.self  = "sendBascet" type = "button" class = "bascet-form__btn btn">Оформить заказ</button>
                    <div v-show = "formNoValid" class = "no_feild">
                        Заполните все обязательные поля помеченные "*"
                    </div>
                </div>
                
            </form>
        </template>

        <section>   
            <div class="_container">
                <div id = "bascet_vue">

                    <div class = "bascet_content" >
                        <bascet></bascet>
                    </div>

                    <bascetform></bascetform>
                </div>
            </div>
        </section>   
	</main>
<?php get_footer(); ?>