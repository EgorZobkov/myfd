<?php if ( (!defined('ABS_PATH')) ) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if ( !OC_ADMIN ) exit('User access is not allowed.'); ?>
<h2 class="render-title <?php echo (osc_get_preference('footer_link', 'eva') ? '' : 'separate-top'); ?>"><b><i class="fa fa-file-text"></i> <?php _e('Help', 'eva'); ?></b></h2>
<div id="form-horizontal">

    <ul>
    <strong><?php _e('Control of the size of images', 'eva'); ?></strong>
    <li><?php _e('The panel of the administrator - Settings - Media:', 'eva'); ?></li>
     <li> <?php _e('The miniature size - 270x204', 'eva'); ?></li>
	 <li><?php _e('The preview size - 770x514', 'eva'); ?></li>
	 <li><?php _e('The normal size - 935x640( For normal size you can setup bigger size. This is image used in item page in Popup wondow)', 'eva'); ?></li>
	 <li><?php _e('Disable - Force image aspect. No white background will be added to keep the size.', 'eva'); ?></li>
	 <li><?php _e('Enable - Use ImageMagick instead of GD library', 'eva'); ?></li>
    <br />
    
    <br />
    <strong><?php _e('Ads management', 'eva'); ?></strong>
	<li><?php _e('Manage advertising platform, such as Google Adsense', 'eva'); ?> </li>
	<li><?php _e('Homepage and search middle of latest listings work only for list view', 'eva'); ?></li>
	<li><?php _e('Default - Middle calculated that on page 10 listing and show after 5 listing', 'eva'); ?></li>
	<li><?php _e('You can change this in Ads tab.', 'eva'); ?></li>
	 <br />
	<strong><?php _e('Icons for categories', 'eva'); ?></strong>
    <li><?php _e('If you change standart Osclass categories (or add new), it is necessary for you to make the icons for the changed categories.', 'eva'); ?></li>
	 <li><?php _e('The size of images should be ~ 30x30 px', 'eva'); ?></li>
	 <li><?php _e('Images, for example, can be taken here:', 'eva'); ?></li> <strong><a href="http://www.flaticon.com/free-icon/black-car_16301" class="underlink" target="_blank">http://www.flaticon.com/free-icon/black-car_16301</a></strong>
	 <li><?php _e('Go to Category icons tab and upload or replace icons.', 'eva'); ?></li>
     <br />
	 <strong><?php _e('Search Max-Min price edit', 'eva'); ?></strong>
	<li><?php _e('Open eva/js/main.js in 137 line min = 0; min price to select.', 'eva'); ?></li>
	<li><?php _e('In 138 line max = 1000000; max price.', 'eva'); ?></li>
	 <br />	
	 <br />
    <strong><?php _e('Google Map in Main and Search pages', 'eva'); ?></strong>
	<li><?php _e('All ads on the map are added by the coordinates', 'eva'); ?></li>
	<li><?php _e('If your site already had ads, but the Google map plugin was not installed before:each time the map is loaded, the coordinates will be calculated', 'eva'); ?></li>
	<li><?php _e('The map can be loaded long if you configure a lot of ads to display on the map.', 'eva'); ?> </li>
	<li><?php _e('But if you turn on the theme Map or install the Google map plugin:when user adding new ads to the site, the coordinates will be immediately calculated and saved to the database for each new ad', 'eva'); ?></li>
	<li><?php _e('The map will be loaded much faster, so the coordinates will be taken from the database.', 'eva'); ?></li>
	<li><?php _e('If the user specified an incorrect address, the ad will not be shown on the map.', 'eva'); ?></li>
	<br />
	<strong><?php _e('Google Map keys', 'eva'); ?></strong>
	<li><?php _e('Enable Google Maps and Places Api', 'eva'); ?></li>
	<img src="<?php echo osc_base_url();?>oc-content/themes/eva/admin/img/QIP Shot - Screen 1410.jpg" />
	<br />
	<li><?php _e('Unfortunately Google not allow limit access to Google Map Api for domain and IP together', 'eva'); ?></li>
	<li><?php _e('In this one, you can either restrict access by domain, or by IP', 'eva'); ?></li>
	<li><?php _e('Google Maps JavaScript Api work with URLS and in can be restricted by domain name', 'eva'); ?></li>
	<li><?php _e('But Google Geocoding Api Key send request to API from server IP and in can be restricted by IP only', 'eva'); ?></li>
	<li><?php _e('That is why we recommend creating two keys. First key for Google Maps JavaScript Api and restrict it by your domain name', 'eva'); ?></li>
	<img src="<?php echo osc_base_url();?>oc-content/themes/eva/admin/img/QIP Shot - Screen 1278.jpg" />
	<br />
	<li><strong><?php _e('Second key for Google Geocoding Api and restrict it by your server IP', 'eva'); ?></strong></li>
	<br />
    <img src="<?php echo osc_base_url();?>oc-content/themes/eva/admin/img/QIP Shot - Screen 1279.jpg" />
		 <br />
		 <br />
	 <strong><?php _e('Translation', 'eva'); ?></strong>
	 <li><?php _e('You can translate or edit theme translations with Poedit.', 'eva'); ?></li>
	 <?php if( osc_current_admin_locale () == 'ru_RU') { ?>
	 <strong><a href="https://osclass.pro/perevod-shablonov-i-plaginov/" class="underlink" target="_blank">https://osclass.pro/perevod-shablonov-i-plaginov/</a></strong>
	 <?php } else { ?>
	 <strong><a href="https://doc.osclass.org/Translating_and_editing_language_files_(.po_and_.mo)" class="underlink" target="_blank">Osclass DOCS:https://doc.osclass.org/Translating_and_editing_language_files_(.po_and_.mo)</a></strong>
	 <?php } ?>
</ul>

  <br /><br />
</div>