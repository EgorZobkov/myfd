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
        <h2 class="h2-bottom-line"><?php _e('Contact us', 'eva'); ?></h2>
                 <!-- content -->
                 <div id="feedback">
                     <div class="container">
                         <div class="authentication__form disbox">
                             <ul id="error_list"></ul><h1></h1>
                             <form action="<?php echo osc_base_url(true); ?>" method="post" name="contact_form" id="contact" class="form">
   	<input type="hidden" name="page" value="contact" />
        <input type="hidden" name="action" value="contact_post" />
            <div class="inp-group">
                <h4 class="inp-group__title"><?php _e('Subject', 'eva'); ?></h4>
                <input id="subject" name="subject" type="text" value="" class="input">
            </div>
            <div class="inp-group">
                <h4 class="inp-group__title"><?php _e('Message', 'eva'); ?></h4>
                <textarea id="message" name="message" type="text" value="" placeholder="<?php  echo osc_esc_html(__('Detail description...', 'eva')); ?>"></textarea>
            </div>
            <div class="inp-group inp-group--no-margin">
                <div class="input-row">
                    <div class="input-col">
                        <h4 class="inp-group__title"><?php _e('Name', 'eva'); ?></h4>
                        <input id="yourName" name="yourName" type="text" class="input" value="" placeholder="<?php  echo osc_esc_html(__('Your name', 'eva')); ?>">
                    </div>
                    <div class="input-col">
                        <h4 class="inp-group__title"><?php _e('E-mail', 'eva'); ?></h4>
                        <input id="yourEmail" name="yourEmail" type="email" class="input" value="" placeholder="<?php  echo osc_esc_html(__('Your e-mail address', 'eva')); ?>">
                    </div>
                </div>
            </div>
 
            <input type="submit" value="<?php  echo osc_esc_html(__('Send', 'eva')); ?>" class="btn-center submit upcase">
			<?php osc_run_hook('admin_contact_form'); ?>
								 
                             </form>
                             <?php ContactForm::js_validation(); ?>
                         </div>
                     </div>
                 </div>
                 <!-- content -->
             </div></div>
        <?php osc_current_web_theme_path('footer.php'); ?>
    </body>
</html>