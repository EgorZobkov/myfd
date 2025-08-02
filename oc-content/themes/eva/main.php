<?php
/*
* Copyright 2018 osclass-pro.com and osclass-pro.ru
*
* You shall not distribute this theme and any its files (except third-party libraries) to third parties.
* Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
*/
osc_enqueue_script('jquery');
osc_enqueue_script('jquery-ui');
osc_enqueue_script('select');
osc_enqueue_script('owl');
osc_enqueue_script('scrollreveal');
osc_enqueue_script('main');
osc_enqueue_script('date');
osc_enqueue_script('jquery-validate');
?>
<!DOCTYPE html>
<html lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
	<?php osc_current_web_theme_path('head.php'); ?>
	<meta name="robots" content="index, follow" />
	<meta name="googlebot" content="index, follow" />
</head>
<body>

	    <script>
      (function(){

        var config = {
          viewFactor : 0.15,
          duration   : 800,
          distance   : "0px",
          scale      : 0.8,
        }

        window.sr = new ScrollReveal(config)
      })()
	$(document).ready(function(){
     var here = {
        origin   : "top",
        distance : "24px",
        duration : 1500,
        scale    : 1.05,
      }

      var intro = {
        origin   : "bottom",
        distance : "64px",
      }

      var maibox = {
        viewOffset: { top: 64 }
      }

      sr.reveal(".boxmi .maibox", maibox)
      sr.reveal(".here ", here )
      sr.reveal(".item-wrp", intro)
	  sr.reveal(".btn-all-items", intro)
      sr.reveal(".seq-1", maibox, 200)
	  

      var item = document.querySelector(".item-wrp")
      var boxmi  = document.querySelector(".boxmi")
	  });
    </script>
    <style>
      .here,
      .boxmi,.item-wrap {
        visibility: hidden;
      }

    </style>
<?php osc_current_web_theme_path('headermain.php'); ?>
<?php if( osc_get_preference('cat-evarevo', 'eva') != '') {?>
<div class="ads">
	<div class="container">
		<?php echo osc_get_preference('cat-evarevo', 'eva'); ?>
	</div>
</div>
<?php } ?>
	<?php if( osc_get_preference('main-premium-text', 'eva') != '') {?>
			<div class="container">
		<section>
		<div class="sub-h2top-text">
		<?php echo osc_get_preference('main-premium-text', 'eva'); ?>
		</div>
			</section>
</div>
<?php } ?>
<?php if( osc_get_preference('main-carousel', 'eva') == 'premium'){?>
	<?php $num_ads = eva_carousel_num_ads() ; ?>
	<?php osc_get_premiums($num_ads); ?>
	<?php if( osc_count_premiums() == 0) { ?>
		<br>
	<?php }else{ ?>


<section class="carousel-section">
                <div class="container">
                    <div class="carousel-section__ins">
					<h2 class="h2-bottom-line"><?php _e('Premium listings', 'eva'); ?></h2>
                        <div class="carousel-wrp">
                            <div class="carousel owl-carousel two-ca">

							<?php $index = 0; while(osc_has_premiums()){?>
								<div class="item">
									<?php if( osc_images_enabled_at_items() ) { ?>
													<?php if( osc_count_premium_resources() ) { ?>
									<a href="<?php echo osc_premium_url() ; ?>" class="item__photo">
									<img src="<?php echo osc_resource_thumbnail_url(); ?>" alt="<?php echo osc_highlight(osc_premium_title()); ?>">
										<?php } else { ?>
									<a href="<?php echo osc_premium_url() ; ?>" class="item__photo">
													<img src="<?php echo osc_current_web_theme_url('img/no_photo.gif') ; ?>">
													<?php } ?>
												<?php } ?>
									<div class="premium_label">			
                                        <span class="item__favourites"><i class="mdi mdi-star-outline"></i><?php _e('Premium', 'eva'); ?></span>
                                    </div>
									<span class="purchased"><?php echo osc_format_date(osc_premium_pub_date()); ?></span>
									<div class="overlay"></div>
									</a>
									                                        <?php if( osc_get_preference('item-icon', 'eva') == 'enable') {?>
										<div class="item__cat">
                                          <img src="<?php echo osc_current_web_theme_url('img/').eva_category_root(osc_premium_category_id()).'.png'; ?>"> 
										   </div>
											<?php } ?>
										<div class="item__ins" id="<?php if(function_exists('upayments_premium_get_class_color')){echo upayments_premium_get_class_color(osc_premium_id());}?>">
										<div class="item__middle-desc">
                                            <a href="<?php echo osc_premium_url() ; ?>" class="item__title"><?php echo osc_highlight(osc_premium_title()); ?></a>
                                            <div class="item__text">
                                                <div><?php echo osc_highlight(osc_premium_description()); ?></div>
                                            </div>
											<span class="item__date"><i class="mdi mdi-map-marker"></i> <?php echo osc_premium_city(); ?></span>
                                            <strong class="item__price"><?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled(osc_premium_category_id()) ) {?>
											<i class="mdi mdi-tag"></i> <?php echo osc_premium_formated_price() ; } ?></strong>
                                        </div>
                                    </div>
                                </div>
								<?php
								$index++;
								if($index == $num_ads){
									break;
								}
								?>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php } ?>

<?php }elseif(osc_get_preference('main-carousel', 'eva') == 'popular'){?>
	<?php $num_ads = eva_carousel_num_ads() ; ?>
	<?php $mostViewedAds = eva_most_popular($num_ads);?>
	<?php View::newInstance()->_exportVariableToView('items', $mostViewedAds);?>
	<?php if( osc_count_items() >0) { ?>
<section class="carousel-section">
                <div class="container">
                    <div class="carousel-section__ins">
					<h2 class="h2-bottom-line"><?php _e('Popular listings', 'eva'); ?></h2>
                        <div class="carousel-wrp">
                            <div class="carousel owl-carousel two-ca">
							<?php while(osc_has_items()){?>
								<div class="item">
								<?php if( osc_images_enabled_at_items() ) { ?>
													<?php if( osc_count_item_resources() ) { ?>
									<a href="<?php echo osc_item_url() ; ?>" class="item__photo">
									<img src="<?php echo osc_resource_thumbnail_url(); ?>" alt="<?php echo osc_highlight(osc_item_title()); ?>">
										<?php } else { ?>
									<a href="<?php echo osc_item_url() ; ?>" class="item__photo">
									<img src="<?php echo osc_current_web_theme_url('img/no_photo.gif') ; ?>">
													<?php } ?>
												<?php } ?>
									<div class="premium_label">			
                                        <span class="item__favourites"><i class="mdi mdi-star-outline"></i><?php _e('Popular', 'eva'); ?></span>
                                    </div>
									<span class="purchased"><?php echo osc_format_date(osc_item_pub_date()); ?></span>
									<div class="overlay"></div>
									</a>
									 <?php if( osc_get_preference('item-icon', 'eva') == 'enable') {?>
										<div class="item__cat">
                                          <img src="<?php echo osc_current_web_theme_url('img/').eva_category_root(osc_item_category_id()).'.png'; ?>"> 
										   </div>
											<?php } ?>
									<div class="item__ins" id="<?php if(function_exists('upayments_get_class_color')){echo upayments_get_class_color(osc_item_id());}?>">
                                        <div class="item__middle-desc">
                                            <a href="<?php echo osc_item_url() ; ?>" class="item__title"><?php echo osc_item_field('s_title'); ?></a>
                                            <div class="item__text">
                                                <div><?php echo osc_item_field('s_description'); ?></div>
                                            </div>
                                            <span class="item__date"><i class="mdi mdi-map-marker"></i> <?php echo osc_item_city(); ?></span>
                                            <strong class="item__price"><?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled(osc_item_category_id()) ) {?>
											<i class="mdi mdi-tag"></i> <?php  echo osc_item_formated_price() ; } ?></strong>
                                        </div>
                                    </div>
                                </div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php } ?>
<?php osc_reset_items(); ?>
<?php } ?>
<?php
if( osc_get_preference('main-block-middle', 'eva') == 'enable') { 
$image_dir2 = osc_base_path().'oc-content/themes/eva/img/main2/*';
$images2 = glob($image_dir2);
foreach($images2 as $image2){$img2 = basename($image2);} 
 ?>
            <section class="about about--paralax" style="<?php if( $img2 != '') {?>background-image:url(<?php echo osc_base_url(); ?>oc-content/themes/eva/img/main2/<?php echo $img2; ?>) ;<?php } ?> center top;">
                <div class="container">
                    <h2 class="h2-bottom-line"><?php if( osc_get_preference('main-premiumh2-undertext', 'eva') != '') { echo osc_get_preference('main-premiumh2-undertext', 'eva'); } ?></h2>
                    <div class="about-items-wrp">
                        <div class="about-item">
                            <p><?php if( osc_get_preference('main-premium-1text', 'eva') != '') { echo osc_get_preference('main-premium-1text', 'eva'); } ?></p>
                        </div>
                    </div>
                </div>
            </section>
			<?php } ?>
			<?php if( osc_get_preference('main-evarevo-top', 'eva') != '') {?>
<div class="ads">
	<div class="container">
			<?php echo osc_get_preference('main-evarevo-top', 'eva'); ?>
	</div>
</div>
<?php } ?>
<section class="board-list">
                <div class="container">
                    <h2 class="h2-bottom-line"><?php _e('Latest Listings', 'eva'); ?></h2>
		<?php osc_reset_latest_items(); ?>
		<?php if(osc_count_latest_items() == 0){ ?>
			<p class="empty"><?php _e('No Latest Listings', 'eva'); ?></p>
			<div style="min-height: 100px;"></div>
		<?php }else{ ?>
		<div class="list-item">
								<div class="list-item__table ">
								<div class="list ">
					<?php while(osc_has_latest_items()){?>
<div class="item-wrp">                            
<div class="item">
								<?php if( osc_images_enabled_at_items() ) { ?>
													<?php if( osc_count_item_resources() ) { ?>
									<a href="<?php echo osc_item_url() ; ?>" class="item__photo">
									<img src="<?php echo osc_resource_thumbnail_url(); ?>" alt="<?php echo osc_highlight(osc_item_title()); ?>">
										<?php } else { ?>
									<a href="<?php echo osc_item_url() ; ?>" class="item__photo">
									<img src="<?php echo osc_current_web_theme_url('img/no_photo.gif') ; ?>">
													<?php } ?>
												<?php } ?>

									<span class="purchased"><?php echo osc_format_date(osc_item_pub_date()); ?></span>
									<div class="overlay"></div>
									</a>
									 <?php if( osc_get_preference('item-icon', 'eva') == 'enable') {?>
										<div class="item__cat">
                                          <img src="<?php echo osc_current_web_theme_url('img/').eva_category_root(osc_item_category_id()).'.png'; ?>"> 
										   </div>
											<?php } ?>
									<div class="item__ins" id="<?php if(function_exists('upayments_get_class_color')){echo upayments_get_class_color(osc_item_id());}?>">
                                        <div class="item__middle-desc">
                                            <a href="<?php echo osc_item_url() ; ?>" class="item__title"><?php echo osc_item_field('s_title'); ?></a>
                                            <div class="item__text">
                                                <div><?php echo osc_item_field('s_description'); ?></div>
                                            </div>
                                            <span class="item__date"><i class="mdi mdi-map-marker"></i> <?php echo osc_item_city(); ?></span>
                                            <strong class="item__price"><?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled(osc_item_category_id()) ) {?>
											<i class="mdi mdi-tag"></i> <?php  echo osc_item_formated_price() ; } ?></strong>
                                        </div>
                                    </div>
                                </div>
								 </div>			
					<?php } ?>
					</div></div>	
			</div>
		<?php } ?>
                    </div>
                    </div>
                </div>
            </section>
			<?php if( osc_get_preference('main-bottom-text', 'eva') != '') {?>
			<div class="container">
		<section>
		<div class="sub-h2-text">
		<?php echo osc_get_preference('main-bottom-text', 'eva'); ?>
		</div>
			</section>
</div>
	<!-- /text-->
<?php } ?>
<?php if( osc_get_preference('main-map', 'eva') == 'enable') {?>
 <div id="map_eva"></div>
 <?php } ?>
<?php if( osc_get_preference('main-carousel2', 'eva') == 'premium'){?>
	<?php $num_ads = eva_carousel_num_ads() ; ?>
	<?php osc_get_premiums($num_ads); ?>
	<?php if( osc_count_premiums() == 0) { ?>
		<br>
	<?php }else{ ?>

<section class="carousel-section">
                <div class="container">
                    <div class="carousel-section__ins">
					<h2 class="h2-bottom-line"><?php _e('Premium listings', 'eva'); ?></h2>
				<p class="sub-h2-text"><?php _e('See the best offers from our users.', 'eva'); ?></p>
                        <div class="carousel-wrp">
                            <div class="carousel owl-carousel two-ca">
							<?php $index = 0; while(osc_has_premiums()){?>
								<div class="item">
									<?php if( osc_images_enabled_at_items() ) { ?>
													<?php if( osc_count_premium_resources() ) { ?>
									<a href="<?php echo osc_premium_url() ; ?>" class="item__photo">
									<img src="<?php echo osc_resource_thumbnail_url(); ?>" alt="<?php echo osc_highlight(osc_premium_title()); ?>">
										<?php } else { ?>
									<a href="<?php echo osc_premium_url() ; ?>" class="item__photo">
									<img src="<?php echo osc_current_web_theme_url('img/no_photo.gif') ; ?>">
													<?php } ?>
												<?php } ?>
									<div class="premium_label">			
                                        <span class="item__favourites"><i class="mdi mdi-star-outline"></i><?php _e('Premium', 'eva'); ?></span>
                                    </div>
									<span class="purchased"><?php echo osc_format_date(osc_premium_pub_date()); ?></span>
									<div class="overlay"></div>
									</a>
									                                        <?php if( osc_get_preference('item-icon', 'eva') == 'enable') {?>
										<div class="item__cat">
                                          <img src="<?php echo osc_current_web_theme_url('img/').eva_category_root(osc_premium_category_id()).'.png'; ?>"> 
										   </div>
											<?php } ?>
										<div class="item__ins" id="<?php if(function_exists('upayments_premium_get_class_color')){echo upayments_premium_get_class_color(osc_premium_id());}?>">
										<div class="item__middle-desc">
                                            <a href="<?php echo osc_premium_url() ; ?>" class="item__title"><?php echo osc_highlight(osc_premium_title()); ?></a>
                                            <div class="item__text">
                                                <div><?php echo osc_highlight(osc_premium_description()); ?></div>
                                            </div>
											<span class="item__date"><i class="mdi mdi-map-marker"></i> <?php echo osc_premium_city(); ?></span>
                                            <strong class="item__price"><?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled(osc_premium_category_id()) ) {?>
											<i class="mdi mdi-tag"></i> <?php echo osc_premium_formated_price() ; } ?></strong>
                                        </div>
                                    </div>
                                </div>
								<?php
								$index++;
								if($index == $num_ads){
									break;
								}
								?>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

<?php }elseif(osc_get_preference('main-carousel2', 'eva') == 'popular'){?>
<?php $num_ads = eva_carousel_num_ads() ; ?>
	<?php $mostViewedAds = eva_most_popular($num_ads);?>
	<?php View::newInstance()->_exportVariableToView('items', $mostViewedAds);?>
	<?php if( osc_count_items() >0) { ?>
<section class="carousel-section">
                <div class="container">
                    <div class="carousel-section__ins">
					<h2 class="h2-bottom-line"><?php _e('Popular listings', 'eva'); ?></h2>
                        <div class="carousel-wrp">
                            <div class="carousel owl-carousel two-ca">
							<?php while(osc_has_items()){?>
								<div class="item">
								<?php if( osc_images_enabled_at_items() ) { ?>
													<?php if( osc_count_item_resources() ) { ?>
									<a href="<?php echo osc_item_url() ; ?>" class="item__photo">
									<img src="<?php echo osc_resource_thumbnail_url(); ?>" alt="<?php echo osc_highlight(osc_item_title()); ?>">
										<?php } else { ?>
									<a href="<?php echo osc_item_url() ; ?>" class="item__photo">
									<img src="<?php echo osc_current_web_theme_url('img/no_photo.gif') ; ?>">
													<?php } ?>
												<?php } ?>
									<div class="premium_label">			
                                        <span class="item__favourites"><i class="mdi mdi-star-outline"></i><?php _e('Popular', 'eva'); ?></span>
                                    </div>
									<span class="purchased"><?php echo osc_format_date(osc_item_pub_date()); ?></span>
									<div class="overlay"></div>
									</a>
									 <?php if( osc_get_preference('item-icon', 'eva') == 'enable') {?>
										<div class="item__cat">
                                          <img src="<?php echo osc_current_web_theme_url('img/').eva_category_root(osc_item_category_id()).'.png'; ?>"> 
										   </div>
											<?php } ?>
									<div class="item__ins" id="<?php if(function_exists('upayments_get_class_color')){echo upayments_get_class_color(osc_item_id());}?>">
                                        <div class="item__middle-desc">
                                            <a href="<?php echo osc_item_url() ; ?>" class="item__title"><?php echo osc_item_field('s_title'); ?></a>
                                            <div class="item__text">
                                                <div><?php echo osc_item_field('s_description'); ?></div>
                                            </div>
                                            <span class="item__date"><i class="mdi mdi-map-marker"></i> <?php echo osc_item_city(); ?></span>
                                            <strong class="item__price"><?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled(osc_item_category_id()) ) {?>
											<i class="mdi mdi-tag"></i> <?php  echo osc_item_formated_price() ; } ?></strong>
                                        </div>
                                    </div>
                                </div>
							<?php } ?>
						
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php } ?>
	<?php osc_reset_items(); ?>
<?php } ?>
			<a href="<?php echo osc_search_show_all_url();?>" class="btn-pink btn-all-items upcase"><strong><?php _e("All offers", 'eva'); ?></strong></a>
	         		</div>
			 </section>
			</div>
    </div>
<div class="clearfix"></div>
<?php if( osc_get_preference('main-evarevo-under', 'eva') != '') {?>
	<div class="ads">
		<div class="container">
			<div class="row">
				<?php echo osc_get_preference('main-evarevo-under', 'eva'); ?>
			</div>
		</div>
	</div>
<?php } ?>

     </div>
    </div>

<?php osc_current_web_theme_path('footer.php'); ?>
<?php if( osc_get_preference('main-map', 'eva') == 'enable') {?>
<?php osc_current_web_theme_path('templates/map/main_map.php'); ?>
  <?php } ?>