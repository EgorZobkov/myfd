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
        <meta name="robots" content="index, follow" />
        <meta name="googlebot" content="index, follow" />
    </head>
    <body>
        <?php osc_current_web_theme_path('header.php'); ?>
        <div class="container">
            <h2 class="h2-bottom-line"><?php echo osc_static_page_title(); ?></h2>
            <div class="content_page description__text"><?php echo osc_static_page_text(); ?></div>
        </div></div>	
        <?php osc_current_web_theme_path('footer.php'); ?>
    </body>
</html>