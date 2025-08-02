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
    <?php UserForm::js_validation(); ?>
    <?php osc_current_web_theme_path('header.php'); ?>
    <div class="container">
	<div class="forcemessages-inline">
    <?php osc_show_flash_message(); ?>
    </div>
<!-- content -->
	<div class="publish">
        <form name="register" id="register" class="form-publish" action="<?php echo osc_base_url(true); ?>" method="post">
            <h2 class="center"><?php _e('Register an account for free', 'eva'); ?></h2>
            <div class="item_box">
                <input type="hidden" name="page" value="register" />
                <input type="hidden" name="action" value="register_post" />
                
                <div class="inp-group">
                    <input id="s_name" type="text" name="s_name" value="" placeholder="<?php echo osc_esc_html(__('Name *', 'eva')); ?>" class="input">
                </div>

                <div class="inp-group">
                    <input id="s_password" type="password" name="s_password" value="" placeholder="<?php echo osc_esc_html(__('Password *', 'eva')); ?>" class="input">
                </div>

                <div class="inp-group">
                    <input id="s_password2" type="password" name="s_password2" value="" placeholder="<?php echo osc_esc_html(__('Re-type password *', 'eva')); ?>" class="input">
                </div>
                
                <p id="password-error" style="display:none;">
                    <?php _e('Passwords don\'t match', 'eva'); ?>.
                </p>
                
                <div class="inp-group">
                    <input id="s_email" type="email" name="s_email" value="" placeholder="<?php echo osc_esc_html(__('E-mail *', 'eva')); ?>" class="input">
                </div>

                <div class="inp-group">
                    <input id="s_phone_mobile" type="text" name="s_phone_mobile" value="" placeholder="<?php echo osc_esc_html(__('Mobile Phone','eva')); ?>" class="input">
                </div>
            
                <?php if (function_exists('HybridAuth_Login')) { HybridAuth_Login(); } ?>

                <?php osc_run_hook('user_register_form'); ?>
                <script type="text/javascript">
                    var RecaptchaOptions = {
                        theme : 'clean'
                    };
                </script>
                
                <div class="inp-captcha">
                    <?php osc_show_recaptcha('register'); ?>
                </div>
                
                <?php if( function_exists( "MyHoneyPot" )) { ?>		
                    <?php MyHoneyPot(); ?>		
                <?php } ?>  

                <button class="btn btn-primary btn-center" type="submit"><?php _e('Create', 'eva'); ?></button>
            </div>
            <div class="inp-group">
                    <p><?php _e('* This field is required', 'eva'); ?></p>
                </div>
        </form>
    </div>
</div>
                    <!-- content -->
                </div></div></div>
        <?php osc_current_web_theme_path('footer.php'); ?>
    </body>
</html>