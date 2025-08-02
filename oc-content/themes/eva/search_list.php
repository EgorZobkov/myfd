<?php
 		   /*
 * Copyright 2018 osclass-pro.com
 *
 * You shall not distribute this theme and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
 ?>
<div class="list-item__inline">
<div class="list">
<?php  osc_get_premiums(10);
    if(osc_count_premiums() > 0) {
?>
		<h2 class="h2-bottom-linesearch"><?php _e("Premium items", 'eva'); ?></h2>
      <?php while(osc_has_premiums()) { ?>
		<?php  $index = 0;
				         
                ?>
				<div class="item-list-main">
<div class="item-inline">
							<?php if( osc_images_enabled_at_items() ) { ?>
													<?php if( osc_count_premium_resources() ) { ?>
									<a href="<?php echo osc_premium_url() ; ?>" class="item-inline__img-wrp">
									<img src="<?php echo osc_resource_thumbnail_url(); ?>" alt="<?php echo osc_highlight(osc_premium_title()); ?>">
										<?php } else { ?>
									<a href="<?php echo osc_premium_url() ; ?>" class="item-inline__img-wrp">
									<img src="<?php echo osc_current_web_theme_url('img/no_photo.gif') ; ?>">
													<?php } ?>
													<div class="premium_label">			
                                        <span class="item__favourites"><i class="mdi mdi-star-outline"></i><?php _e('Premium', 'eva'); ?></span>
                                    </div>
									<span class="purchased"><?php echo osc_format_date(osc_premium_pub_date()); ?></span>
									<div class="overlay"></div>
													</a>
												<?php } ?>
												
 <div class="item-inline__ins">
                                    <div class="item-inline__ins__in" id="<?php if(function_exists('upayments_premium_get_class_color')){echo upayments_premium_get_class_color(osc_premium_id());}?>">
                                        <div class="item-inline__desc">
										<?php if( osc_get_preference('item-icon', 'eva') == 'enable') {?>
                                            <a href="<?php echo osc_premium_url() ; ?>" class="item-inline__cat">
													<img src="<?php echo osc_current_web_theme_url('img/').eva_category_root(osc_premium_category_id()).'.png'; ?>">		
                                            </a>
											<?php } ?>
	<a href="<?php echo osc_premium_url() ; ?>" class="item-inline__title"><?php echo osc_highlight(osc_premium_title()); ?></a>
                                            <div class="item-inline__text">
                                                <p><?php echo osc_highlight(osc_premium_description()); ?></p>
                                            </div>
											<div class="item-inline__action">
											<span class="item-inline__place"><?php if( osc_premium_city()!= '' ) {?><i class="mdi mdi-map-marker"></i><?php } ?> <?php echo osc_premium_city() ; ?></span>									                                        
                                            <span class="item-inline__price"><?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled(osc_premium_category_id()) ) { echo osc_premium_formated_price() ; } ?></span>
                                        </div>
											</div>
                                    </div>
                                </div>
                            </div>
							 </div>
        <?php
                            $index++;
                            if($index == 10){
                                break; 
                            }
                        }
                    ?>  
<?php } ?>
		<?php $i = 0; ?>
		<?php if(osc_count_items() > 0) {?>
		<h2 class="h2-bottom-linesearch"><?php _e("Latest items", 'eva'); ?></h2>	
		<?php while(osc_has_items()) { $i++; ?>
		<div class="item-list-main">
                            <div class="item-inline">
							<?php if( osc_images_enabled_at_items() ) { ?>
													<?php if( osc_count_item_resources() ) { ?>
									<a href="<?php echo osc_item_url() ; ?>" class="item-inline__img-wrp">
									<img src="<?php echo osc_resource_thumbnail_url(); ?>" alt="<?php echo osc_highlight(osc_item_title()); ?>">
										<?php } else { ?>
									<a href="<?php echo osc_item_url() ; ?>" class="item-inline__img-wrp">
									<img src="<?php echo osc_current_web_theme_url('img/no_photo.gif') ; ?>">
													<?php } ?>
													<span class="purchased"><?php echo osc_format_date(osc_item_pub_date()); ?></span>
									<div class="overlay"></div>
													</a>
												<?php } ?>
 <div class="item-inline__ins">
                                    <div class="item-inline__ins__in"  id="<?php if(function_exists('upayments_get_class_color')){echo upayments_get_class_color(osc_item_id());}?>">
                                        <div class="item-inline__desc">
										<?php if( osc_get_preference('item-icon', 'eva') == 'enable') {?>
                                            <a href="<?php echo osc_item_url() ; ?>" class="item-inline__cat">
													<img src="<?php echo osc_current_web_theme_url('img/').eva_category_root(osc_item_category_id()).'.png'; ?>">		
                                            </a>
											<?php } ?>
	<a href="<?php echo osc_item_url() ; ?>" class="item-inline__title"><?php echo osc_highlight(osc_item_title()); ?></a>
                                            <div class="item-inline__text">
                                                <p><?php echo osc_highlight(osc_item_description()); ?></p>
                                            </div>
											<span class="item-inline__place"><?php if( osc_item_city()!= '' ) {?><i class="mdi mdi-map-marker"></i><?php } ?><?php echo osc_item_city() ; ?></span>
											         <div class="item-inline__action">
                                            <strong class="item-inline__price"><?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled(osc_item_category_id()) ) { echo osc_item_formated_price() ; } ?></strong>
                                        </div>
											</div>
                               
                                    </div>
                                </div>
                            </div>
							 </div>
			<?php if( $i == osc_get_preference('search-middle', 'eva') && osc_get_preference('search-middle', 'eva') !== '') { ?>
			                                            <div class="ads">
	<div class="container">
			<?php osc_run_hook('search_middle'); ?>
			</div></div>
<?php } ?>
        <?php } ?>
		<?php } ?>
			</div>
</div>