<?php
/*
* Copyright 2018 osclass-pro.com
*
* You shall not distribute this theme and any its files (except third-party libraries) to third parties.
* Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
*/
?>
<div class="list-item__table">
<div class="list">
<?php osc_get_premiums(20);
if(osc_count_premiums() > 0) {
	?>
	<?php while(osc_has_premiums()) { ?>
		<?php  $index = 0;

		?>
                               <div class="item-wrp">
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
											<span class="item__date"><?php if( osc_premium_city()!= '' ) {?><i class="mdi mdi-map-marker"></i><?php } ?> <?php echo osc_premium_city(); ?></span>
                                            <strong class="item__price"><?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled(osc_premium_category_id()) ) {?>
											<i class="mdi mdi-tag"></i> <?php echo osc_premium_formated_price() ; } ?></strong>
                                        </div>
                                    </div>
                                </div>
								</div>
		<?php
		$index++;
		if($index == 20){
			break;
		}
	}
	?>

<?php } ?>

<?php while(osc_has_items()) { ?>
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
								</div>
<?php } ?>
</div>
</div>