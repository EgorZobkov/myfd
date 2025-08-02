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
            <!-- content -->
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
                                             <h2 class="page-title"><?php _e('Change your password', 'eva'); ?></h2>
                                            <form action="<?php echo osc_base_url(true); ?>" method="post" class="form">
                                                <input type="hidden" name="page" value="user" />
                                                <input type="hidden" name="action" value="change_password_post" />
                                                <div class="inp-group">
												<div class="input-row">
												 <div class="input-col">
                                                 <h4 class="inp-group__title"><?php _e('Current password', 'eva'); ?> <span>*</span></h4>
                                               <input type="password" name="password" id="password" value="" class="form-control" >
                                                </div></div></div>
                                                <div class="form-group">
												<div class="input-row">
												<div class="input-col">
                                                    <h4 class="inp-group__title"><?php _e('New password', 'eva'); ?> <span>*</span></h4>
                                                    <div class="group__content">
                                                        <input type="password" name="new_password" id="new_password" value="" class="form-control" >
                                                    </div>
                                                </div>
<div class="input-col">
                                                    <h4 class="inp-group__title"><?php _e('Repeat new password', 'eva'); ?> <span>*</span></h4>
                                                        <input type="password" name="new_password2" id="new_password2" value="" class="form-control" >
                                                </div></div></div>
                                                <div class="form-group">
                                                        <button class="btn btn-primary" type="submit">
                                                            <?php _e('Update', 'eva'); ?>
                                                        </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
            <!-- content -->
        </div><div style="clear:both"></div>
        <?php osc_current_web_theme_path('footer.php'); ?>
    </body>
</html>