<?php
 /*
 * Copyright 2018 osclass-pro.com
 *
 * You shall not distribute this theme and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
?>

<?php if ( (!defined('ABS_PATH')) ) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if ( !OC_ADMIN ) exit('User access is not allowed.'); ?>
<h2 class="render-title <?php echo (osc_get_preference('footer_link', 'eva') ? '' : 'separate-top'); ?>"><b><i class="fa fa-money"></i> <?php _e('Ads management', 'eva'); ?></b></h2>
	<form action="<?php echo osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php'); ?>" method="post" class="nocsrf">
    <input type="hidden" name="action_specific" value="ads_eva" />
	 <fieldset>
	
    <div class="form-row">
        <div class="form-label"></div>
        <div class="form-controls">
            <p><?php _e('In this section you can configure your site to display ads and start generating revenue.', 'eva'); ?><br/><?php _e('If you are using an online advertising platform, such as Google Adsense, copy and paste here the provided code for ads.', 'eva'); ?><br/><?php _e('Important! Google Adsense allows you to place only three blocks in page ', 'eva'); ?></p>
        </div>
    </div>
	
   
        <div class="form-horizontal">
		     <div class="form-row">
                <div class="form-label"><?php _e('Main page under categories', 'eva'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 115px; width: 500px;"name="cat-evarevo"><?php echo osc_esc_html( osc_get_preference('cat-evarevo', 'eva') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"><?php _e('This ad will be shown at the Main page under categories. Note that the ad should be Responsive.', 'eva'); ?></div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-label"><?php _e('Homepage top of  latest listings', 'eva'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 115px; width: 500px;"name="main-evarevo-top"><?php echo osc_esc_html( osc_get_preference('main-evarevo-top', 'eva') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"><?php _e('This ad will be shown at the top of your latest listings in main page. Note that the  ad should be Responsive.', 'eva'); ?></div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-label"><?php _e('Homepage under of latest listings', 'eva'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 115px; width: 500px;" name="main-evarevo-under"><?php echo osc_esc_html( osc_get_preference('main-evarevo-under', 'eva') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"><?php _e('This ad will be shown on the main page under of your latest listings. Note that the  ad should be Responsive.', 'eva'); ?></div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-label"><?php _e('Homepage middle of latest listings(only list view).Read Help', 'eva'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 115px; width: 500px;" name="main-evarevo-middle"><?php echo osc_esc_html( osc_get_preference('main-evarevo-middle', 'eva') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"><?php _e('This ad will be shown on the main page middle of your latest listings. Note that the  ad should be Responsive.', 'eva'); ?></div>
                </div>
            </div>
			<div class="form-row">
                <div class="form-label"><b><?php _e('No. of item after Show - Homepage middle:', 'eva'); ?></b></div>
                <div class="form-controls">
					<input type="text" class="input-small" name="main-middle" value="<?php echo osc_get_preference('main-middle', 'eva'); ?>" />
                </div>
            </div>
			<div style="clear:both;"></div>
            <div class="form-row">
                <div class="form-label"><?php _e('Search results top', 'eva'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 115px; width: 500px;" name="search-evarevo-top"><?php echo osc_esc_html( osc_get_preference('search-evarevo-top', 'eva') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"><?php _e('This ad will be shown at the top search results of your site. Note that the  ad should be Responsive.', 'eva'); ?></div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-label"><?php _e('Search results middle(only list view).Read Help', 'eva'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 115px; width: 500px;" name="search-evarevo_middle"><?php echo osc_esc_html( osc_get_preference('search-evarevo_middle', 'eva') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"><?php _e('This ad will be shown at middle of search results of your website. Note that the  ad should be Responsive.', 'eva'); ?></div>
                </div>
            </div>
			<div class="form-row" >
                <div class="form-label"><b><?php _e('No. of item after Show - Search results middle:', 'eva'); ?></b></div>
                <div class="form-controls">
					<input type="text" class="input-small" name="search-middle" value="<?php echo osc_get_preference('search-middle', 'eva'); ?>" />
                </div>
            </div>
			<div style="clear:both;"></div>
			<div class="form-row">
                <div class="form-label"><?php _e('Search under of listings', 'eva'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 115px; width: 500px;" name="search-evarevo_under"><?php echo osc_esc_html( osc_get_preference('search-evarevo_under', 'eva') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"><?php _e('This ad will be shown on the search page under of your listings. Note that the  ad should be Responsive.', 'eva'); ?></div>
                </div>
            </div>
			<div class="form-row">
                <div class="form-label"><?php _e('Item under of listing description', 'eva'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 115px; width: 500px;" name="item-evarevo_desc"><?php echo osc_esc_html( osc_get_preference('item-evarevo_desc', 'eva') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"><?php _e('This ad will be shown on the item page under of listing description. Note that the  ad should be Responsive.', 'eva'); ?></div>
                </div>
            </div>
						<div class="form-row">
                <div class="form-label"><?php _e('Item under useful info', 'eva'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 115px; width: 500px;" name="item-evarevo_desc2"><?php echo osc_esc_html( osc_get_preference('item-evarevo_desc2', 'eva') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"><?php _e('This ad will be shown on the item page under useful info. Note that the ad should be Responsive.', 'eva'); ?></div>
                </div>
            </div>
			<div class="form-row">
                <div class="form-label"><?php _e('Item sidebar', 'eva'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 115px; width: 500px;" name="item-evarevo_image"><?php echo osc_esc_html( osc_get_preference('item-evarevo_image', 'eva') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"><?php _e('This ad will be shown on the item page sidebar. Note that the  ad should be Responsive.', 'eva'); ?></div>
                </div>
            </div>
			<div class="form-actions">
                <input type="submit" value="<?php _e('Save changes', 'eva'); ?>" class="btn btn-submit">
            </div>
        </div>
    </fieldset>
</form>








