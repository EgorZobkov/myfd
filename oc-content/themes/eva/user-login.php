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
            <form action="<?php echo osc_base_url(true); ?>" method="post" class="form-publish">
                <h2 class="center"><?php _e('Access to your account', 'eva'); ?></h2>
                <div class="item_box">  
                    <input type="hidden" name="page" value="login" />
                    <input type="hidden" name="action" value="login_post" />
                                        <div class="inp-group">
                        <input type="email" name="email" id="email" class="input" placeholder="<?php echo osc_esc_html(__('E-mail', 'eva')); ?>" class="form-control form-control__big">
                    </div>
                            
                    <div class="inp-group">
                        <input type="password" name="password" id="password" class="input" placeholder="<?php echo osc_esc_html(__('Password', 'eva')); ?>" class="form-control form-control__big">
                    </div>
                                
                    <div class="checkbox-wrp">
                        <input id="remember" type="checkbox" name="remember" value="1" checked>
                            <label for="remember">
                                <?php _e('Remember me', 'eva'); ?>
                            </label>
                    </div>

                        <?php if (function_exists('HybridAuth_Login')) { HybridAuth_Login(); } ?>

                    <div class="inp-captcha">
                        <?php osc_run_hook('advcaptcha_hook_login'); ?>
                    </div>
                        
                    <button class="btn btn-primary btn-center" type="submit"><?php _e("Log in", 'eva');?></button>
                            
                    <a href="<?php echo osc_register_account_url(); ?>" class="help__link">
                        <?php _e("Register for a free account", 'eva'); ?>
                    </a>
                                
                    <a href="<?php echo osc_recover_user_password_url(); ?>" class="help__link">
                        <?php _e("Forgot password?", 'eva'); ?>
                    </a>
                </div>
            </form>
                
        </div>		
    </div>
</div>
</div>
                </div>
        <!-- content -->
    </div>
    <?php osc_current_web_theme_path('footer.php'); ?>
</body>
</html>