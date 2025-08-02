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
				       <div class="container content">
		<div class="forcemessages-inline">
    <?php osc_show_flash_message(); ?>
</div>

                           <!-- content -->
                           <div class="personal__area">
                               <div class="container">
                                   <div class="row">
                                       <div class="col-md-3 col-lg-3 disbox">
                                           <div class="sidebar">
                                               <div class="sidebar__personal">
                                                   <div class="personal__avatar">

                                                       <div class="avatar__name">
                                                           <p class="name__text"><?php _e('User account manager', 'eva')?></p>
                                                           <p class="name__text"><?php echo osc_logged_user_name()?></p>
                                                       </div>
                                                   </div>
                                                   <div class="personal__nav">
                                                       <ul class="nav__list" role="tablist">
                                                           <?php echo osc_private_user_menu(get_user_menu()); ?>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>

                                       <div class="col-md-9 col-lg-9">
                                           <div class="personal__tabs">
                                               <div class="tab-content">
                                                   <div role="tabpanel" class="tab-pane fade  in  active" id="listings">
                                                       <div class="tab__title">
                                                           <p class="title__text">
                                                               <?php echo sprintf(__('Latest listings from %s', 'eva') ,osc_logged_user_name()); ?>
                                                           </p>
                                                           <a href="<?php echo osc_item_post_url(); ?> " class="post__new">
                                                               <i class="fa fa-clone"></i>
															   <?php _e('Post a new listing', 'eva'); ?>
                                                           </a>
                                                       </div>
                                                       <div class="listings">
                                                           <?php if(osc_count_items() == 0) { ?>
                                                               <h3 class="block-title publish account"><?php _e('No listings have been added yet', 'eva'); ?></h3>
                                                           <?php } else { ?>
                                                           <?php while(osc_has_items()) { ?>
                                                           <div class="list__item">
                                                               <div class="item__title">
                                                                   <p class="title__text">
                                                                       <?php echo osc_item_title(osc_locale_code())?>
                                                                   </p>
											<span class="title__label">
												<?php if(osc_item_is_active()) { echo __('Activated', 'eva'); } else { echo __('Inactivated', 'eva'); }; ?>
                                                <?php if(osc_item_is_premium()) { echo __('Premium', 'eva'); }; ?>
                                                <?php if(osc_item_is_spam()) { echo __('Spam', 'eva'); }; ?>
											</span>
                                                               </div>
                                                               <div class="item__price">
                                                                   <p class="price__text">
                                                                       <?php echo osc_item_formated_price() ; ?>
                                                                   </p>
                                                               </div>
                                                               <div class="item__publication">
                                                                   <p class="publication__text">
                                                                       <span><?php __('Publication date', 'eva')?>: </span>
                                                                       <?php echo osc_format_date(osc_item_pub_date()); ?>
                                                                       <a href="<?php echo osc_item_url(osc_locale_code())?>">
                                                                           <?php echo osc_item_category(osc_locale_code())?>
                                                                       </a>
                                                                   </p>
                                                               </div>
                                                               <div class="item__actions">
                                                                   <a href="<?php echo osc_item_edit_url(); ?>" class="action__edit">
                                                                       <i class="fa fa-pencil-square-o"></i>
                                                                       <span><?php _e('Edit', 'eva'); ?></span>
                                                                   </a>
                                                                   <a onclick="javascript:return confirm('<?php echo osc_esc_js(__('This action can not be undone. Are you sure you want to continue?', 'eva')); ?>')" href="<?php echo osc_item_delete_url(); ?>" class="action__delete">
                                                                       <i class="fa fa-trash-o"></i>
                                                                   </a>
                                                               </div>
                                                           </div>
                                                           <?php } ?>
                                                           <?php } ?>


                                                       </div>
                                                       <!--  -->
                                                       <?php if(osc_list_total_pages() > 1){?>
                                                       <div class="pagination">
                                                           <?php echo osc_pagination_items(); ?>
                                                       </div>
                                                       <?php } ?>
                                                       <!--  -->
                                                   </div>

                                                   
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           <!-- content -->

        </div><div style="clear:both"></div>	
        <?php osc_current_web_theme_path('footer.php'); ?>
    </body>
</html>
