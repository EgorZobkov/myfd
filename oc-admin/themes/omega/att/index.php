<?php
if(!defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

function customPageHeader(){ ?>
  <h1><?php _e('Listings'); ?>
    <a href="#" class="btn ico ico-32 ico-help float-right"></a>
    <a href="#" class="btn btn-green ico ico-add-white float-right" id="add-button"><?php _e('Add attribute'); ?></a>
  </h1>
<?php }
osc_add_hook('admin_page_header','customPageHeader');

function customPageTitle($string) {
  return sprintf(__('Attributes - %s'), $string);
}
osc_add_filter('admin_title', 'customPageTitle');

osc_current_admin_theme_path('parts/header.php');
?>

<div class="flashmessage flashmessage-info">
  <p class="info"><?php _e('Drag & drop the attributes to reorder them the way you like. Click on edit link to edit the attribute'); ?></p>
</div>

<div class="header_title">
  <h2 class="render-title"><?php _e('Attributes'); ?> <a href="javascript:void(0);" class="btn btn-mini add-button"><?php _e('Add new'); ?></a></h2>
</div>

<div class="custom-fields">
  <div class="list-fields">
    <span id="fields-empty"><?php _e("You don't have any attributes yet"); ?></span>
  </div>
</div>

<div class="clear"></div>

<?php osc_current_admin_theme_path('parts/footer.php'); ?>