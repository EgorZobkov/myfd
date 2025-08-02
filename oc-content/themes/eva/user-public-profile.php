<?php

    $location_array = array();
    if(trim(osc_user_city()." ".osc_user_zip())!='') {
        $location_array[] = trim(osc_user_city()." ".osc_user_zip());
    }
    if(osc_user_region()!='') {
        $location_array[] = osc_user_region();
    }
    if(osc_user_country()!='') {
        $location_array[] = osc_user_country();
    }
	if(osc_user_address()!='') {
        if(osc_user_city_area()!='') {
            $location_array[] = osc_user_address().", ".osc_user_city_area();
        } else {
            $location_array[] = osc_user_address();
        }
    }
    $location = implode(", ", $location_array);
    unset($location_array);
    $user_vkid = osc_user_vkid();
	$user_keep = osc_user();
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
<?php View::newInstance()->_exportVariableToView('user', $user_keep); ?>
        <?php osc_current_web_theme_path('header.php'); ?>
		<div class="forcemessages-inline">
    <?php osc_show_flash_message(); ?>
</div>
                    <!-- content -->
                    <div class="col-wrp public__profile">
                    <div class="col-main">
					<div class="profile">
                            <div class="profile__main">
                                <div class="profile__photo">
                                    <img src="<?php echo osc_current_web_theme_url('img/profile.jpg'); ?>" alt="profile">
                                </div>
                                <div class="profile__desc">
                                    <span class="profile__name"><?php echo osc_user_name(); ?></span>
                                    <span class=""><?php if(function_exists('ur_button_stars')) { echo ur_button_stars($user_id = osc_user_id(), $user_email = osc_item_contact_email(), $item_id = osc_item_id()); } ?></span>
                                   <br>
                                   <?php if($user_vkid !=''){?><p class="profile__vk" style="color: #7962E6;"><i class="mdi mdi-vk mdi-18px mdipad"></i><a href="https://vk.com/<?php echo $user_vkid; ?>" target="_blank"><?php echo $user_vkid; ?></p><?php } ?>


                                    <?php if(osc_user_phone_land() !=''){?><span class="profile__phone"><i class="mdi mdi-deskphone mdi-24px mdipad"></i><?php if(function_exists('eva_phone_number')){ eva_phone_number();}?></span><?php } ?>
									<span class="profile__red-date"><i class="mdi mdi-calendar-text mdi-24px mdipad"></i><?php echo _e('Register date', 'eva').': '.osc_format_date(osc_user()['dt_reg_date']); ?></span>



                                    <?php if($location !=''){?><p class="profile__adress"><i class="mdi mdi-map-marker mdi-18px mdipad"></i><?php echo $location; ?></p><?php } ?>
									<?php if(osc_user_website() !=''){?><p class="profile__adress"><i class="mdi mdi-link mdi-18px mdipad"></i><?php echo osc_user_website(); ?></p><?php } ?>
                                </div>
                            </div>
                            <div class="profile__text">
                                <p><?php echo osc_user_info(); ?> </p>
                            </div>
																														<aside class="col-contact">
                       
                                    <?php if(osc_logged_user_id()!=  osc_user_id()) { ?>
                                    <?php if(osc_reg_user_can_contact() && osc_is_web_user_logged_in() || !osc_reg_user_can_contact() ) { ?>
									<a id="myBtn" class="btn-pink upcase"><strong><?php _e('Write', 'eva'); ?></strong></a>      
                                    <?php if(function_exists('ur_button_add')) { echo ur_button_add($user_id = osc_user_id(), $item_id = osc_item_id()); } ?>                                    
                                    <?php } ?>
                                    <?php } ?>
									
                         </aside>
                        </div>
																<section class="board-list board-list--ins">
																										<h2><?php _e('Latest listings', 'eva')?></h2>
										<div class="list-item__inline">
<div class="list">
										<?php while ( osc_has_items() ) { ?>

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
							 </div><?php } ?></div>
							 </div>
							</section>
							       <?php if(osc_list_total_pages() > 1){?>
                                        <div class="pagination">
                                            <?php echo osc_pagination_items(); ?>
                                        </div>
                                        <?php } ?>
                                        </div>
                </div>
				                                        <!--  -->
										                                    <?php if(osc_logged_user_id()!=  osc_user_id()) { ?>
                                    <?php if(osc_reg_user_can_contact() && osc_is_web_user_logged_in() || !osc_reg_user_can_contact() ) { ?>
									 <div class="widget-form modalcontact" id="myModal">
									 						<div class="modal-content">
						<span class="closemodal">&times;</span>
						<ul id="error_list"></ul>
                                            <form action="<?php echo osc_base_url(true); ?>"  role="form" method="post" name="contact_form"  class="form" id="contact_form">
                                                <input type="hidden" name="action" value="contact_post" />
                                                <input type="hidden" name="page" value="user" />
                                                <input type="hidden" name="id" value="<?php echo osc_user_id();?>" />
                                     <span class="widget-form__title"><?php _e("Contact publisher", 'eva'); ?></span>
									 <?php osc_prepare_user_info(); ?>
									 <label>
                                                            <input class="input" type="text" name="yourName" id="yourName" placeholder="<?php echo osc_esc_html(__('Your name', 'eva')); ?>">
                                        </label><label>                    
															<input class="input" type="email" id="yourEmail" name="yourEmail" placeholder="<?php echo osc_esc_html(__('Your e-mail*', 'eva')); ?>" required>
                                                          </label> <label>
														   <input class="input" type="text" id="phoneNumber" name="phoneNumber" placeholder="<?php echo osc_esc_html(__('Phone number', 'eva')); ?> (<?php echo osc_esc_html(__('optional', 'eva')); ?>)">
                                                      </label> <label>
													   <textarea class="textarea" id="message" name="message" placeholder="<?php echo osc_esc_html(__('Message*', 'eva')); ?>" required></textarea>
														</label><?php if( osc_item_attachment() ) { ?>
														<div class="attach">
                                            <label for="contact-attachment"><?php _e('Attachment', 'eva'); ?> (<?php _e('optional', 'eva'); ?>)</label>
                                            <?php ContactForm::your_attachment() ; ?>


											</div>
                                        <?php } ?>
                                                    <?php osc_run_hook('item_contact_form', osc_item_id()); ?>
                                                    <?php osc_show_recaptcha(); ?>
                                                <div class="form-group text-center">
                                                    <button type="submit" class="submit btn-center upcase"><?php _e('Send', 'eva'); ?></button>
                                                </div>
                                            </form>

											</div>   </div>  
											   <?php } ?>
                                    <?php } ?>
                             
                                        <!--  -->
                    <!-- content -->
        </div></div>	
        <?php osc_current_web_theme_path('footer.php'); ?>
		<script text="text/javascript">
var modal = document.getElementById('myModal');

var modalbtn = document.getElementById("myBtn");

var modalspan = document.getElementsByClassName("closemodal")[0];

modalbtn.onclick = function() {
    modal.style.display = "block";
}

modalspan.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
    </body>
</html>
