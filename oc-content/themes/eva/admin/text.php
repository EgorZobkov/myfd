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
<h2 class="render-title <?php echo (osc_get_preference('footer_link', 'eva') ? '' : 'separate-top'); ?>"><b><i class="fa fa-file-text"></i> <?php _e('Text management', 'eva'); ?></b></h2>
	<form action="<?php echo osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php'); ?>" method="post" class="nocsrf">
    <input type="hidden" name="action_specific" value="text_eva" />
	 <fieldset>
	
    <div class="form-row">
        <div class="form-label"></div>
        <div class="form-controls">
            <p><?php _e('In this section you can add some text for SEO or just for users. The text can be with HTML tags. Or you can just use these places for banners or any HTML code.', 'eva'); ?></p>
        </div>
    </div>
	
        <div class="form-horizontal">
            <div class="form-row">
                <div class="form-label"><?php _e('Homepage - Under categories.', 'eva'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 115px; width: 500px;" name="main-premium-text"><?php echo osc_esc_html( osc_get_preference('main-premium-text', 'eva') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"><?php _e('This will be shown on the main page Above the premium listings.', 'eva'); ?></div>
                </div>
            </div>   </div>
					        <div class="form-horizontal">
            <div class="form-row">
                <div class="form-label"><?php _e('Homepage - Under the latest listings.', 'eva'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 115px; width: 500px;" name="main-bottom-text"><?php echo osc_esc_html( osc_get_preference('main-bottom-text', 'eva') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"><?php _e('This will be shown on the main page Under all listings.', 'eva'); ?></div>
                </div>
            </div>
			 <div class="form-row">
                <div class="form-label"><?php _e('Homepage - Before latest H2.', 'eva'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 115px; width: 500px;" name="main-premiumh2-undertext"><?php echo osc_esc_html( osc_get_preference('main-premiumh2-undertext', 'eva') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"><?php _e('This will be shown on the main Before latest listings.', 'eva'); ?></div>
                </div>
            </div>
			<div class="form-row">
                <div class="form-label"><?php _e('Homepage - Before latest H2 text.', 'eva'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 115px; width: 500px;" name="main-premium-1text"><?php echo osc_esc_html( osc_get_preference('main-premium-1text', 'eva') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"><?php _e('This will be shown on the main Before latest listings.', 'eva'); ?></div>
                </div>
            </div>
        </div>
<h2 class="render-title"><b><i class="fa fa-file-text-o"></i> <?php _e('Categories description', 'eva'); ?></b></h2>
    <div class="form-row">
        <div class="form-label"></div>
        <div class="form-controls">
            <p><?php _e('You can add for each Osclass category some text with HTML tags in Settings - Categories. This text can be displayed on the category page.', 'eva'); ?></p>
        </div>
    </div>
	<div class="form-controls">
                    <select name="categories-text">
                        <option value="top" <?php if(osc_get_preference('categories-text', 'eva') == 'top'){ echo 'selected="selected"' ; } ?>><?php _e('At the top of the page','eva'); ?></option>
                        <option value="bottom" <?php if(osc_get_preference('categories-text', 'eva') == 'bottom'){ echo 'selected="selected"' ; } ?>><?php _e('At the bottom of the page','eva'); ?></option>
						<option value="hide" <?php if(osc_get_preference('categories-text', 'eva') == 'hide'){ echo 'selected="selected"' ; } ?>><?php _e('Hide','eva'); ?></option>
</select>
                </div>
			<div class="form-actions">
                <input type="submit" value="<?php echo osc_esc_html( __('Save changes', 'eva')); ?>" class="btn btn-submit">
            </div>
		
    </fieldset>
</form>








