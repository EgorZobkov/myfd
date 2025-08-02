<?php
 		   /*
 * Copyright 2018 osclass-pro.com
 *
 * You shall not distribute this theme and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
osc_enqueue_script('jquery');
osc_enqueue_script('jquery-ui');
osc_enqueue_script('owl');
osc_enqueue_script('main');
osc_enqueue_script('select');
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
    <div class="container">
        <div class="forcemessages-inline">
            <?php osc_show_flash_message(); ?>
        </div>
    <!-- content -->

    
    <div class="publish">
            <form id="register" action="<?php echo osc_base_url(true); ?>" method="post" class="form-publish"> 
            <h2 class="center"><?php _e('Recover your password', 'eva'); ?></h2>
            <div class="item_box">
                <input type="hidden" name="page" value="login" />
                <input type="hidden" name="action" value="recover_post" />
                
                <div class="inp-group">
                    <input id="s_email" type="email" name="s_email" value="" placeholder="<?php echo osc_esc_html(__('E-mail', 'eva')); ?>" class="input">
                </div>
                
                <div class="inp-captcha">
                    <?php osc_run_hook('advcaptcha_hook_recover'); ?>
                </div>
                <button class="btn btn-primary btn-center" type="submit"><?php _e('Send me a new password', 'eva'); ?></button>
            </div>
            </form>
                
        </div>	

<!-- content -->
        </div></div></div></div>
        <?php osc_current_web_theme_path('footer.php'); ?>
    </body>
</html>