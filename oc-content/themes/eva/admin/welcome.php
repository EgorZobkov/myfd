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

  <h2 class="render-title <?php echo (osc_get_preference('footer_link', 'eva') ? '' : 'separate-top'); ?>"><b><i class="fa fa-file-text"></i> <?php _e('Main Welcome Text and Search Background Image', 'eva'); ?></b></h2>
<form action="<?php echo osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php');?>" method="post" class="nocsrf">
    <input type="hidden" name="action_specific" value="welcome_eva" />
   <fieldset>
   <div class="form-horizontal">
		     <div class="form-row">
                <div class="form-label"><?php _e('Main page H1 Welcome Text ', 'eva'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 59px; width: 500px;" name="mainh1-evarevo"><?php echo osc_esc_html( osc_get_preference('mainh1-evarevo', 'eva') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"><?php _e('This  H1 Welcome Text be shown at the Main page.', 'eva'); ?></div>
                </div>
            </div>
			<div class="form-row">
                <div class="form-label"><?php _e('Main page under H1 Welcome Text ', 'eva'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 115px; width: 500px;" name="maintext-evarevo"><?php echo osc_esc_html( osc_get_preference('maintext-evarevo', 'eva') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"><?php _e('This Welcome Text under H1 be shown at the Main page.', 'eva'); ?></div>
                </div>
            </div>
			</div>
			<div class="form-horizontal">
            <div class="form-row">
	<div class="form-label"><?php _e('Middle block image with text', 'eva'); ?></div>
	<div class="form-controls">
                    <select name="main-block-middle">
                        <option value="disable" <?php if(osc_get_preference('main-block-middle', 'eva') == 'disable'){ echo 'selected="selected"' ; } ?>><?php _e('Disable','eva'); ?></option>
                        <option value="enable" <?php if(osc_get_preference('main-block-middle', 'eva') == 'enable'){ echo 'selected="selected"' ; } ?>><?php _e('Enable','eva'); ?></option>
					</select>
    </div></div></div>
    
			<div class="form-actions">
				<input id="button" type="submit" value="<?php echo osc_esc_html(__('Save changes','eva')); ?>" class="btn btn-submit">
			</div>
	
	</fieldset>
</form>
<h2 class="render-title"><b><i class="fa fa-picture-o"></i> <?php _e('Main Search Background Image', 'eva'); ?></b></h2>
<form action="<?php echo osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php');?>" method="post" enctype="multipart/form-data" class="nocsrf">
    <input type="hidden" name="action_specific" value="upload_main_image" />
	<?php 
$image_dir = osc_base_path().'oc-content/themes/eva/img/main/*';
$images = glob($image_dir); ?>
  <?php if($images){ ?>
<h2 class="render-title"><?php _e('Loaded image', 'eva'); ?></h2>
  <table style="width:100%">
    <tr>
      <?php $i=0; foreach($images as $image) { if($i%5===0){echo '</tr><tr><td>&nbsp;</td></tr><tr>';} ?>
      <td style="width:20%; padding:5px;"><img style="max-width:400px; max-height:200px;background-color:#474749;" src="<?php echo osc_base_url().'oc-content/themes/eva/img/main/'.basename($image); ?>"/><br />
        <strong><?php echo basename($image); ?></strong>&nbsp;&nbsp;&nbsp;<a href="<?php echo osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php'); ?>&action_specific=remove_main_image&main_name=<?php echo basename($image); ?>">
        <?php _e('Delete', 'eva'); ?>
        </a></td>
      <?php $i++; }  ?>
   </tr>
   <br/>             
  </table>
  <?php } ?>
			   <div class="help-box"><?php _e('Recommended image size ~ 1920x900px or higher', 'eva'); ?></div>
			   <div class="help-box"><?php _e('IMPORTANT!Before downloading new pictures - delete the old.', 'eva'); ?></div>
  <input type="file" name="main_image" id="main_image" accept="image/*"  />
   			<div class="form-actions">
				<input id="button" type="submit" value="<?php echo osc_esc_html(__('Upload','eva')); ?>" class="btn btn-submit">
			</div>
	
	</form>
<h2 class="render-title"><b><i class="fa fa-picture-o"></i> <?php _e('Main Middle Image', 'eva'); ?></b></h2>
<form action="<?php echo osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php');?>" method="post" enctype="multipart/form-data" class="nocsrf">
    <input type="hidden" name="action_specific" value="upload_main_image2" />
	<?php 
$image_dir2 = osc_base_path().'oc-content/themes/eva/img/main2/*';
$images2 = glob($image_dir2); ?>
  <?php if($images2){ ?>
<h2 class="render-title"><?php _e('Loaded image', 'eva'); ?></h2>
  <table style="width:100%">
    <tr>
      <?php $i=0; foreach($images2 as $image2) { if($i%5===0){echo '</tr><tr><td>&nbsp;</td></tr><tr>';} ?>
      <td style="width:20%; padding:5px;"><img style="max-width:400px; max-height:200px;background-color:#474749;" src="<?php echo osc_base_url().'oc-content/themes/eva/img/main2/'.basename($image2); ?>"/><br />
        <strong><?php echo basename($image2); ?></strong>&nbsp;&nbsp;&nbsp;<a href="<?php echo osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php'); ?>&action_specific=remove_main_image2&main_name2=<?php echo basename($image2); ?>">
        <?php _e('Delete', 'eva'); ?>
        </a></td>
      <?php $i++; }  ?>
   </tr>
   <br/>             
  </table>
  <?php } ?>
			   <div class="help-box"><?php _e('Recommended image size ~ 1920x1200px or higher', 'eva'); ?></div>
			   <div class="help-box"><?php _e('IMPORTANT!Before downloading new pictures - delete the old.', 'eva'); ?></div>
  <input type="file" name="main_image2" id="main_image2" accept="image/*"  />
   			<div class="form-actions">
				<input id="button" type="submit" value="<?php echo osc_esc_html(__('Upload','eva')); ?>" class="btn btn-submit">
			</div>
	
	</form>
