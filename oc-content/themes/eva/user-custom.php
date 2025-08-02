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
						<!-- <div class="col-left">
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
                    </div> -->
<div class="col-main">
                <?php osc_render_file(); ?>
            </div></div></div>		
        <?php osc_current_web_theme_path('footer.php'); ?>
    </body>
</html>