<?php if ( (!defined('ABS_PATH')) ) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if ( !OC_ADMIN ) exit('User access is not allowed.'); ?>

<form action="<?php echo osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php');?>" method="post" class="nocsrf">
    <input type="hidden" name="action_specific" value="mobmenu_1" />
   <fieldset>
   <div class="form-horizontal">
   

<h2 class="render-title"><i class="fa fa-arrow-down"></i> <?php _e('You can change colors with color picker', 'eva'); ?></h2>
		     <div class="form-row">
                <div class="form-label"><?php _e('Facebook', 'eva'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 18px; width: 500px;" name="mobmenu_1"><?php echo osc_esc_html( osc_get_preference('mobmenu_1', 'eva') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"><?php _e('This link to you Facebook page will be shown in footer.', 'eva'); ?></div>
                </div>
            </div>
			
			<div class="form-actions">
            <input id="button" type="submit" value="<?php echo osc_esc_html( __('Save changes', 'eva')); ?>" class="btn btn-submit">
			</div>
	
	</fieldset>
</form>