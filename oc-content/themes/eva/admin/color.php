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
<h2 class="render-title <?php echo (osc_get_preference('footer_link', 'eva') ? '' : 'separate-top'); ?>"><b><i class="fa fa-magic"></i> <?php _e('Color management', 'eva'); ?></b></h2>
	<form action="<?php echo osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php'); ?>" method="post" class="nocsrf">
    <input type="hidden" name="action_specific" value="color_eva" />
	 <fieldset>
	
    <div class="form-row">
        <div class="form-label"></div>
        <div class="form-controls">
            <p><?php _e('In this section you can select theme colors', 'eva'); ?></p>
        </div>
    </div>
	
        <div class="form-horizontal">
					<div class="form-row">
                <div class="form-label"><b><?php _e('Select color:', 'eva'); ?></b></div>
            </div>
				 </div>
				 <div class="form-horizontal">
	<h2 class="render-title"><i class="fa fa-arrow-down"></i> <?php _e('You can change colors with color picker', 'eva'); ?></h2>
					<div class="form-row">
                        <div class="form-label"><?php _e('Primary color', 'eva'); ?></div>
                        <div class="form-controls">
                            <input class="jscolor" type="text" class="xlarge" name="primary_color" value="<?php echo osc_esc_html(osc_get_preference('primary_color', 'eva')); ?>" style="background:<?php echo osc_esc_html(osc_get_preference('primary_color', 'eva')); ?>;"/><span>
			    
                        </div>
                    </div></br>
                    <div class="form-row">
                        <div class="form-label"><?php _e('Second color - Hover', 'eva'); ?></div>
                        <div class="form-controls">
                            <input class="jscolor" type="text" class="xlarge" name="hover_color" value="<?php echo osc_esc_html(osc_get_preference('hover_color', 'eva')); ?>" style="background:<?php echo osc_esc_html(osc_get_preference('hover_color', 'eva')); ?>;"/><span>
			    
                        </div>
                    </div></br>
                   <div class="form-row">
                        <div class="form-label"><?php _e('Publish your ad - button color', 'eva'); ?></div>
                        <div class="form-controls">
                            <input class="jscolor" type="text" class="xlarge" name="publish_color" value="<?php echo osc_esc_html(osc_get_preference('publish_color', 'eva')); ?>" style="background:<?php echo osc_esc_html(osc_get_preference('publish_color', 'eva')); ?>;"/><span>
			    
                        </div>
                    </div>
					</br></br>
<div class="form-row">
                        <div class="form-label"><?php _e('Publish your ad - button hover color', 'eva'); ?></div>
                        <div class="form-controls">
                            <input class="jscolor" type="text" class="xlarge" name="publishhover_color" value="<?php echo osc_esc_html(osc_get_preference('publishhover_color', 'eva')); ?>" style="background:<?php echo osc_esc_html(osc_get_preference('publishhover_color', 'eva')); ?>;"/><span>
			    
                        </div>
                    </div>   					
			<div class="form-actions">
                <input type="submit" value="<?php echo osc_esc_html( __('Save changes', 'eva')); ?>" class="btn btn-submit">
            </div>
		 </div>
    </fieldset>
</form>








