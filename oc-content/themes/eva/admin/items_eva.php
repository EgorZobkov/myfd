<?php 
 		   /*
 * Copyright 2016 osclass-pro.com
 *
 * You shall not distribute this theme and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
?>

<?php if ( (!defined('ABS_PATH')) ) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if ( !OC_ADMIN ) exit('User access is not allowed.'); ?>

<form action="<?php echo osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php');?>" method="post" class="nocsrf">
    <input type="hidden" name="action_specific" value="items_eva" />
   <fieldset>
   <h2 class="render-title <?php echo (osc_get_preference('footer_link', 'eva') ? '' : 'separate-top'); ?>"><b><i class="fa fa-cog"></i> <?php _e('Item-post options', 'eva'); ?></b></h2>
   <div class="form-horizontal">
   <div class="form-row">
                <div class="form-label"><b><?php _e('Location option:', 'eva'); ?></b></div>
<div class="form-controls">
                    <select name="item-post-loc">
                        <option value="enable" <?php if(osc_get_preference('item-post-loc', 'eva') == 'enable'){ echo 'selected="selected"' ; } ?>><?php _e('Enable','eva'); ?></option>
                        <option value="disable" <?php if(osc_get_preference('item-post-loc', 'eva') == 'disable'){ echo 'selected="selected"' ; } ?>><?php _e('Disable','eva'); ?></option>
</select>
                </div>

				<div class="form-controls">
                    <select name="item-post">
                        <option value="countries" <?php if(osc_get_preference('item-post', 'eva') == 'countries'){ echo 'selected="selected"' ; } ?>><?php _e('With Countries','eva'); ?></option>
                        <option value="default" <?php if(osc_get_preference('item-post', 'eva') == 'default'){ echo 'selected="selected"' ; } ?>><?php _e('Without Countries','eva'); ?></option>
</select>
                </div>
</br>				
				<div class="form-label"><b><?php _e('Custom fileds postion:', 'eva'); ?></b></div>
				<div class="form-controls">
                    <select name="custom-fileds">
                        <option value="top" <?php if(osc_get_preference('custom-fileds', 'eva') == 'top'){ echo 'selected="selected"' ; } ?>><?php _e('After categories','eva'); ?></option>
                        <option value="bottom" <?php if(osc_get_preference('custom-fileds', 'eva') == 'bottom'){ echo 'selected="selected"' ; } ?>><?php _e('Bottom','eva'); ?></option>
</select>
                </div>
            </div>
</div>
<div style="clear:both;"></div>
<h2 class="render-title"><b><i class="fa fa-cog"></i> <?php _e('Item page', 'eva'); ?></b></h2>
<p><b><?php _e('Custom setting for item page.', 'eva'); ?></b></p>
   <div class="form-horizontal">
      									<div class="form-row">
                <div class="form-label"><b><?php _e('Gallery:', 'eva'); ?></b></div>

<div class="form-controls">
                    <select name="gallery">
                        <option value="swiper" <?php if(osc_get_preference('gallery', 'eva') == 'swiper'){ echo 'selected="selected"' ; } ?>><?php _e('Swiper','eva'); ?></option>
                        <option value="bxslider" <?php if(osc_get_preference('gallery', 'eva') == 'bxslider'){ echo 'selected="selected"' ; } ?>><?php _e('Bxslider','eva'); ?></option>
</select>
                </div>
            </div>
			<br>
   									<div class="form-row">
                <div class="form-label"><b><?php _e('Hide phones to XXXX:', 'eva'); ?></b></div>

<div class="form-controls">
                    <select name="hide_digits">
                        <option value="1" <?php if(osc_get_preference('hide_digits', 'eva') == '1'){ echo 'selected="selected"' ; } ?>><?php _e('Hide','eva'); ?></option>
                        <option value="0" <?php if(osc_get_preference('hide_digits', 'eva') == '0'){ echo 'selected="selected"' ; } ?>><?php _e('No','eva'); ?></option>
</select>
                </div>
            </div>
			<br>
									<div class="form-row">
                <div class="form-label"><b><?php _e('Mark as in item page:', 'eva'); ?></b></div>

<div class="form-controls">
                    <select name="mark-as">
                        <option value="enable" <?php if(osc_get_preference('mark-as', 'eva') == 'enable'){ echo 'selected="selected"' ; } ?>><?php _e('Enable','eva'); ?></option>
                        <option value="disable" <?php if(osc_get_preference('mark-as', 'eva') == 'disable'){ echo 'selected="selected"' ; } ?>><?php _e('Disable','eva'); ?></option>
</select>
                </div>
            </div>
			<br>
												<div class="form-row">
                <div class="form-label"><b><?php _e('Show useful info in item page:', 'eva'); ?></b></div>

<div class="form-controls">
                    <select name="useful">
                        <option value="enable" <?php if(osc_get_preference('useful', 'eva') == 'enable'){ echo 'selected="selected"' ; } ?>><?php _e('Enable','eva'); ?></option>
                        <option value="disable" <?php if(osc_get_preference('useful', 'eva') == 'disable'){ echo 'selected="selected"' ; } ?>><?php _e('Disable','eva'); ?></option>
</select>
                </div>
            </div>
</br>
				<div class="form-label"><b><?php _e('Google Map.', 'eva'); ?></b></div>
				<div class="form-controls">
                    <select name="item-map">
                        <option value="enable" <?php if(osc_get_preference('item-map', 'eva') == 'enable'){ echo 'selected="selected"' ; } ?>><?php _e('Enable','eva'); ?></option>
                        <option value="disable" <?php if(osc_get_preference('item-map', 'eva') == 'disable'){ echo 'selected="selected"' ; } ?>><?php _e('Disable','eva'); ?></option>
</select>
                </div>
				</br>
				<p><?php _e('Install Api key first in Theme settings tab.', 'eva'); ?></p>
<p><?php _e('You can disable this Map and use any other map plugin.', 'eva'); ?></p>
<p><?php _e('Do not use Google map plugin and this option both.', 'eva'); ?></p>

</div>
</fieldset>
			<div class="form-actions">
				<input id="button" type="submit" value="<?php echo osc_esc_html(__('Save changes','eva')); ?>" class="btn btn-submit">
			</div>
	
	
</form>