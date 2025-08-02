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

<h2 class="render-title <?php echo (osc_get_preference('footer_link', 'eva') ? '' : 'separate-top'); ?>"><b><i class="fa fa-picture-o"></i> <?php _e('Search Header Background Image', 'eva'); ?></b></h2>
<form action="<?php echo osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php');?>" method="post" enctype="multipart/form-data" class="nocsrf">
    <input type="hidden" name="action_specific" value="upload_search_image" />
	<?php 
$image_dir1 = osc_base_path().'oc-content/themes/eva/img/search/*';
$images1 = glob($image_dir1); ?>
  <?php if($images1){ ?>
<h2 class="render-title"><?php _e('Loaded image', 'eva'); ?></h2>
  <table style="width:100%">
    <tr>
      <?php $i=0; foreach($images1 as $image1) { if($i%5===0){echo '</tr><tr><td>&nbsp;</td></tr><tr>';} ?>
      <td style="width:20%; padding:5px;"><img style="max-width:400px; max-height:200px;background-color:#474749;" src="<?php echo osc_base_url().'oc-content/themes/eva/img/search/'.basename($image1); ?>"/><br />
        <strong><?php echo basename($image1); ?></strong>&nbsp;&nbsp;&nbsp;<a href="<?php echo osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php'); ?>&action_specific=remove_search_image&search_name=<?php echo basename($image1); ?>">
        <?php _e('Delete', 'eva'); ?>
        </a></td>
      <?php $i++; }  ?>
   </tr>
   <br/>             
  </table>
  <?php } ?>
			   <div class="help-box"><?php _e('Recommended image size - 1920x500px or higher', 'eva'); ?></div>
			   <div class="help-box"><?php _e('IMPORTANT!Before downloading new pictures - delete the old.', 'eva'); ?></div>
  <input type="file" name="search_image" id="search_image" accept="image/*"  />
   			<div class="form-actions">
				<input id="button" type="submit" value="<?php echo osc_esc_html(__('Upload','eva')); ?>" class="btn btn-submit">
			</div>
	
	</form>
	<h2 class="render-title <?php echo (osc_get_preference('footer_link', 'eva') ? '' : 'separate-top'); ?>"><b><i class="fa fa-cog"></i> <?php _e('Settings', 'eva'); ?></b></h2>
<form action="<?php echo osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php');?>" method="post" class="nocsrf">
    <input type="hidden" name="action_specific" value="search_map" />
	<div class="form-horizontal">
            <div class="form-row">
	<div class="form-label"><?php _e('Google Map', 'eva'); ?></div>
	<div class="form-controls">
                    <select name="search-map">
                        <option value="disable" <?php if(osc_get_preference('search-map', 'eva') == 'disable'){ echo 'selected="selected"' ; } ?>><?php _e('Disable','eva'); ?></option>
                        <option value="enable" <?php if(osc_get_preference('search-map', 'eva') == 'enable'){ echo 'selected="selected"' ; } ?>><?php _e('Enable','eva'); ?></option>
					</select>
    </div></div></div>
	<div class="form-horizontal">
            <div class="form-row">
	<div class="form-label"><?php _e('Header image', 'eva'); ?></div>
	<div class="form-controls">
                    <select name="search-image">
                        <option value="disable" <?php if(osc_get_preference('search-image', 'eva') == 'disable'){ echo 'selected="selected"' ; } ?>><?php _e('Disable','eva'); ?></option>
                        <option value="enable" <?php if(osc_get_preference('search-image', 'eva') == 'enable'){ echo 'selected="selected"' ; } ?>><?php _e('Enable','eva'); ?></option>
					</select>
    </div></div></div><div class="form-horizontal">
										<div class="form-row">
                <div class="form-label"><?php _e('Advanced search City field', 'eva'); ?></div>

<div class="form-controls">
                    <select name="adsearch-city">
                        <option value="enable" <?php if(osc_get_preference('adsearch-city', 'eva') == 'enable'){ echo 'selected="selected"' ; } ?>><?php _e('Enable','eva'); ?></option>
                        <option value="disable" <?php if(osc_get_preference('adsearch-city', 'eva') == 'disable'){ echo 'selected="selected"' ; } ?>><?php _e('Disable','eva'); ?></option>
</select>
                </div>
            </div></div>
   			<div class="form-actions">
				<input type="submit" value="<?php echo osc_esc_html( __('Save changes', 'eva') ); ?>" class="btn btn-submit btn-success">
			</div>
	
	</form>