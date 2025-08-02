<?php
 		   /*
 * Copyright 2018 osclass-pro.com and osclass-pro.ru
 *
 * You shall not distribute this theme and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
?>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />

<title><?php echo osc_esc_html(meta_title()); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php if( meta_description() != '' ) { ?>
<meta name="description" content="<?php echo osc_esc_html(meta_description()); ?>" />
<?php } ?>
<?php if( function_exists('meta_keywords') ) { ?>
<?php if( meta_keywords() != '' ) { ?>
<meta name="keywords" content="<?php echo osc_esc_html(meta_keywords()); ?>" />
<?php } ?>
<?php } ?>
<?php if( osc_get_canonical() != '' ) { ?>
<link rel="canonical" href="<?php echo osc_get_canonical(); ?>"/>
<?php } ?>
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Expires" content="Fri, Jan 01 1970 00:00:00 GMT" />
<!-- favicon -->
<link rel="shortcut icon" href="<?php echo eva_favicon_url(); ?>" type="image/x-icon">
<!-- /favicon -->
<?php  eva_style() ;  ?>
<link rel="stylesheet" href="<?php echo osc_current_web_theme_url('css/materialdesignicons.min.css') ; ?>">
<link rel="stylesheet" href="<?php echo osc_current_web_theme_url('css/select2.css') ; ?>">
<link rel="stylesheet" href="<?php echo osc_current_web_theme_url('css/owl.carousel.css') ; ?>">
<?php if( osc_get_preference('gallery', 'eva') == 'swiper') {?>
<link rel="stylesheet" href="<?php echo osc_current_web_theme_url('css/swiper.min.css') ; ?>">
<?php } else { ?>
<link rel="stylesheet" href="<?php echo osc_current_web_theme_url('css/jquery.bxslider.css') ; ?>">
<?php }?>
<link rel="stylesheet" href="<?php echo osc_current_web_theme_url('css/photoswipe.css') ; ?>">
<link rel="stylesheet" href="<?php echo osc_current_web_theme_url('css/main.css') ; ?>">


<?php
osc_register_script('jquery', osc_current_web_theme_js_url('jquery.min.js'));
osc_register_script('jquery-ui', osc_current_web_theme_js_url('jquery-ui.min.js'), 'jquery');
osc_register_script('fineuploader', osc_current_web_theme_js_url('fineuploader/jquery.fineuploader.min.js?i=' . rand(1, 10000)), 'jquery');
osc_register_script('jquery-validate', osc_current_web_theme_js_url('jquery.validate.min.js'), 'jquery');
osc_register_script('date', osc_current_web_theme_js_url('date.js'));
osc_register_script('select', osc_current_web_theme_js_url('select2.min.js'), 'jquery');
osc_register_script('bxslider', osc_current_web_theme_js_url('jquery.bxslider.min.js'), 'jquery');
osc_register_script('swiper', osc_current_web_theme_js_url('swiper.min.js'));
osc_register_script('owl', osc_current_web_theme_js_url('owl.carousel.min.js'), 'jquery');
osc_register_script('photoswipe', osc_current_web_theme_js_url('photoswipe.min.js'));
osc_register_script('photoswipe-ui', osc_current_web_theme_js_url('photoswipe-ui-default.min.js'));
osc_register_script('main', osc_current_web_theme_js_url('main.js'), 'jquery');
osc_register_script('jssocials', osc_current_web_theme_js_url('jssocials.min.js'));
osc_register_script('tabber', osc_current_web_theme_js_url('tabber-minimized.js'));
osc_register_script('touch', osc_current_web_theme_js_url('jquery.ui.touch-punch.min.js'), 'jquery');
osc_register_script('scrollreveal', osc_current_web_theme_js_url('scrollreveal.min.js'));
osc_register_script('rotate-js', osc_current_web_theme_js_url('jQueryRotate.js'), 'jquery');
?>


<?php
osc_run_hook('header');

FieldForm::i18n_datePicker();
?>