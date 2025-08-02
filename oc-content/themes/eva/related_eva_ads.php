<?php if( osc_count_items() == 0) { ?>
		<?php } else { ?>
	                <section class="carousel-section related-sec">
                    <div class="container">
                        <div class="carousel-section__ins">
		<h2 class="h2-bottom-line"><?php _e('Related Ads', 'eva'); ?></h2>
 <div class="carousel-wrp">
 <div class="carousel owl-carousel one-ca">
		<?php while ( osc_has_items() ) { ?>
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
												<?php if( osc_item_is_premium() ) { ?>
									<div class="premium_label">			
                                        <span class="item__favourites"><i class="mdi mdi-star-outline"></i><?php _e('Premium', 'eva'); ?></span>
                                    </div><?php } ?>
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
                                            <a href="<?php echo osc_item_url() ; ?>" class="item__title"><?php echo osc_highlight(osc_item_title()); ?></a>
                                            <div class="item__text">
                                                <div><?php echo osc_highlight(osc_item_description()); ?></div>
                                            </div>
                                            <span class="item__date"><?php if( osc_item_city()!= '' ) {?><i class="mdi mdi-map-marker"></i><?php } ?> <?php echo osc_item_city(); ?></span>
                                            <strong class="item__price"><?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled(osc_item_category_id()) ) {?>
											<i class="mdi mdi-tag"></i> <?php echo osc_item_formated_price() ; } ?></strong>
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