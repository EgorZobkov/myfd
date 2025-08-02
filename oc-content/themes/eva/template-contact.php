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
        <?php osc_current_web_theme_path('head.php') ; ?>
        <meta name="robots" content="noindex, nofollow" />
        <meta name="googlebot" content="noindex, nofollow" />
    </head>
    <body>
        <?php osc_current_web_theme_path('header.php') ; ?>
		<div class="forcemessages-inline">
    <?php osc_show_flash_message(); ?>
</div>
<div class="col-wrp">
                    <div class="col-main">
            <h2 class="h2-bottom-line"><?php echo osc_static_page_title(); ?></h2>
            <div class="content_page description__text"><?php echo osc_static_page_text(); ?></div>
</div>
        <aside class="col-right">
		<div class="widget-form">					
                <ul id="error_list"></ul>
                <form action="<?php echo osc_base_url(true) ; ?>" method="post" name="contact" id="contact">
                    <input type="hidden" name="page" value="contact" />
                    <input type="hidden" name="action" value="contact_post" />
					<span class="widget-form__title"><?php _e('Contact us', 'eva'); ?></span>	
                        <label for="subject"><?php _e('Subject', 'eva') ; ?> (<?php _e('optional', 'eva'); ?>)</label> <?php ContactForm::the_subject() ; ?><br />
                        <label for="message"><?php _e('Message', 'eva') ; ?></label> <?php ContactForm::your_message() ; ?><br />
                        <label for="yourName"><?php _e('Your name', 'eva') ; ?> (<?php _e('optional', 'eva'); ?>)</label> <?php ContactForm::your_name() ; ?><br />
                        <label for="yourEmail"><?php _e('Your e-mail address', 'eva') ; ?></label> <?php ContactForm::your_email(); ?><br />
						<div class="captch" style="transform:scale(0.8);transform-origin:0 0">
                        <?php osc_show_recaptcha(); ?></div>
						<?php osc_run_hook('admin_contact_form'); ?>
						<div class="form-group text-center">
                        <button type="submit" class="submit btn-center upcase"><?php _e('Send', 'eva') ; ?></button>
						</div>
                       
                </form></div></aside>
        </div></div></div>
        <?php osc_current_web_theme_path('footer.php') ; ?>
    </body>
</html>