<?php if ( (!defined('ABS_PATH')) ) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if ( !OC_ADMIN ) exit('User access is not allowed.'); ?>

<form action="<?php echo osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php');?>" method="post" class="nocsrf">
    <input type="hidden" name="action_specific" value="social_eva" />
   <fieldset>
   <div class="form-horizontal">
   
       <h2 class="render-title <?php echo (osc_get_preference('footer_link', 'eva') ? '' : 'separate-top'); ?>"><b><i class="fa fa-cog"></i> <?php _e('Settings', 'eva'); ?></b></h2>
<div class="form-label"><b><?php _e('Logo:', 'eva'); ?></b></div>
	   <div class="form-controls">
                    <select name="footer-logo">
                        <option value="enable" <?php if(osc_get_preference('footer-logo', 'eva') == 'enable'){ echo 'selected="selected"' ; } ?>><?php _e('Enable','eva'); ?></option>
                        <option value="disable" <?php if(osc_get_preference('footer-logo', 'eva') == 'disable'){ echo 'selected="selected"' ; } ?>><?php _e('Disable','eva'); ?></option>
</select>
                </div>
				<br/>
<div class="form-label"><b><?php _e('Categories:', 'eva'); ?></b></div>
	   <div class="form-controls">
                    <select name="footer-categories">
                        <option value="enable" <?php if(osc_get_preference('footer-categories', 'eva') == 'enable'){ echo 'selected="selected"' ; } ?>><?php _e('Enable','eva'); ?></option>
                        <option value="disable" <?php if(osc_get_preference('footer-categories', 'eva') == 'disable'){ echo 'selected="selected"' ; } ?>><?php _e('Disable','eva'); ?></option>
</select>
                </div>				
<br/>
<h2 class="render-title"><b><i class="fa fa-info-circle"></i> <?php _e('Copyright', 'eva'); ?></b></h2>

       <div class="form-row">
           <div class="form-label"><?php _e('Your Copyright', 'eva'); ?></div>
           <div class="form-controls">
               <input maxlength="200" class="input_contact" name="contact-copy" value="<?php echo osc_esc_html( osc_get_preference('contact-copy', 'eva') ); ?>">
               <br/><br/>
               <div class="help-box"><?php _e('This text will be displayed in the footer', 'eva'); ?></div>
           </div>
       </div>
<h2 class="render-title"><b><i class="fa fa-info-circle"></i> <?php _e('Social links in footer', 'eva'); ?></b></h2>
		     <div class="form-row">
                <div class="form-label"><?php _e('Facebook', 'eva'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 18px; width: 500px;" name="facebook-evarevo"><?php echo osc_esc_html( osc_get_preference('facebook-evarevo', 'eva') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"><?php _e('This link to you Facebook page will be shown in footer.', 'eva'); ?></div>
                </div>
            </div>
			<div class="form-row">
                <div class="form-label"><?php _e('Twitter', 'eva'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 18px; width: 500px;" name="twitter-evarevo"><?php echo osc_esc_html( osc_get_preference('twitter-evarevo', 'eva') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"><?php _e('This link to you Twitter page will be shown in footer.', 'eva'); ?></div>
                </div>
            </div>
			<div class="form-row">
                <div class="form-label"><?php _e('Google+', 'eva'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 18px; width: 500px;" name="google-evarevo"><?php echo osc_esc_html( osc_get_preference('google-evarevo', 'eva') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"><?php _e('This link to you Google+ page will be shown in footer.', 'eva'); ?></div>
                </div>
            </div>
       <div class="form-row">
           <div class="form-label"><?php _e('Instagram', 'eva'); ?></div>
           <div class="form-controls">
               <textarea style="height: 18px; width: 500px;" name="in-evarevo"><?php echo osc_esc_html( osc_get_preference('in-evarevo', 'eva') ); ?></textarea>
               <br/><br/>
               <div class="help-box"><?php _e('This link to you Instagram page will be shown in footer.', 'eva'); ?></div>
           </div>
       </div>
       <div class="form-row">
           <div class="form-label"><?php _e('Pinterest', 'eva'); ?></div>
           <div class="form-controls">
               <textarea style="height: 18px; width: 500px;" name="pinterest-evarevo"><?php echo osc_esc_html( osc_get_preference('pinterest-evarevo', 'eva') ); ?></textarea>
               <br/><br/>
               <div class="help-box"><?php _e('This link to you Pinterest page will be shown in footer.', 'eva'); ?></div>
           </div>
       </div>
	   <div class="form-row">
           <div class="form-label"><?php _e('Vkontakte', 'eva'); ?></div>
           <div class="form-controls">
               <textarea style="height: 18px; width: 500px;" name="vk-evarevo"><?php echo osc_esc_html( osc_get_preference('vk-evarevo', 'eva') ); ?></textarea>
               <br/><br/>
               <div class="help-box"><?php _e('This link to you Vkontakte page will be shown in footer.', 'eva'); ?></div>
           </div>
       </div>
       <div class="form-row">
           <div class="form-label"><?php _e('Odnoklassniki', 'eva'); ?></div>
           <div class="form-controls">
               <textarea style="height: 18px; width: 500px;" name="odnoklassniki-evarevo"><?php echo osc_esc_html( osc_get_preference('odnoklassniki-evarevo', 'eva') ); ?></textarea>
               <br/><br/>
               <div class="help-box"><?php _e('This link to you Odnoklassniki page will be shown in footer.', 'eva'); ?></div>
           </div>
       </div>

			<div class="form-actions">
				<input id="button" type="submit" value="<?php echo osc_esc_html( __('Save changes', 'eva')); ?>" class="btn btn-submit">
			</div>



	
	</fieldset>
</form>
