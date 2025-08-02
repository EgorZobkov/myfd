<?php
  /*
 * Copyright 2018 osclass-pro.com
 *
 * You shall not distribute this theme and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */

osc_enqueue_script('jquery');
osc_enqueue_script('jquery-ui');
osc_enqueue_script('select');
osc_enqueue_script('owl');
osc_enqueue_script('main');
osc_enqueue_script('date');
osc_enqueue_script('jquery-validate');
?>
<!DOCTYPE html>
<html lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
    <head>
        <?php osc_current_web_theme_path('head.php'); ?>
        <meta name="robots" content="noindex, nofollow" />
        <meta name="googlebot" content="noindex, nofollow" />
    </head>
    <body>
        <?php osc_current_web_theme_path('header.php'); ?>
		<div class="forcemessages-inline">
    <?php osc_show_flash_message(); ?>
</div>
<div class="col-wrp">
						<div class="col-left">
                        <div class="left-menu">
                            <div class="profile-demo">
                                <img src="<?php echo osc_current_web_theme_url('img/profile.jpg'); ?>" alt="img">
                                <strong class="profile-demo__title"><?php _e('User account manager', 'eva'); ?></strong>
                                <a href="<?php echo osc_user_profile_url(); ?>"><strong><?php echo osc_logged_user_name(); ?></strong></a>
                            </div>
                            <ul>
<?php echo osc_private_user_menu(get_user_menu()); ?>
                            </ul>
                        </div>
                    </div>
<div class="col-main">
                 <h2 class="page-title">
                  <?php _e('Your alerts', 'eva'); ?>
                 </h2>
				 <section class="board-list board-list--ins">
<div class="list-item__inline">
<div class="list">
                                           <?php if(osc_count_alerts() == 0) { ?>
                                               <h3><?php _e('You do not have any alerts yet', 'eva'); ?>.</h3>
                                           <?php } else { ?>
                                           <?php while(osc_has_alerts()) { ?>

                                                                   <div class="">
                                                                       <h4>
                                                                           <?php _e('Alert', 'eva'); ?> | <a onclick="javascript:return confirm('<?php echo osc_esc_js(__('This action can\'t be undone. Are you sure you want to continue?', 'eva')); ?>');" href="<?php echo osc_user_unsubscribe_alert_url(); ?>"><?php _e('Delete this alert', 'eva'); ?></a>
                                                                       </h4>
                                                                   </div>
                                                                   <div class="listings">
                                                                       <?php if(osc_count_items() == 0) { ?>
                                                                           <p class="title__text"><?php _e('No listings have been added yet', 'eva'); ?></p>
                                                                       <?php } else { ?>
                                                                           <?php while(osc_has_items()) { ?>
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
													<span class="purchased"><?php echo osc_format_date(osc_premium_pub_date()); ?></span>
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
											<span class="item-inline__place"><i class="mdi mdi-map-marker"></i> <?php echo osc_item_city() ; ?></span>
											         <div class="item-inline__action">
                                            <strong class="item-inline__price"><?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled(osc_item_category_id()) ) { echo osc_item_formated_price() ; } ?></strong>
                                        </div>
											</div>
                               
                                    </div>
                                </div>
                            </div>
							 </div>
                                                                           <?php } ?>
                                                                       <?php } ?>
                                                                   </div>
                                           <?php } ?>
                                           <?php } ?>
                                                               </div>
                                                           </div>
                                                  </section>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                   <!-- content -->
                 </div>
               </div><div style="clear:both"></div>

        <?php osc_current_web_theme_path('footer.php'); ?>
    </body>
</html>