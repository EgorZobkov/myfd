<?php
/*
  Plugin Name: Rest API Plugin
  Plugin URI: https://osclasspoint.com/osclass-plugins/extra-fields-and-other/rest-api-osclass-plugin_i114
  Description: Create API to provide data to external applications and process data from external applications
  Version: 1.3.5
  Author: MB Themes
  Author URI: https://osclasspoint.com
  Author Email: info@osclasspoint.com
  Short Name: rest
  Plugin update URI: rest
  Support URI: https://forums.osclasspoint.com/rest-api-osclass-plugin/
  Product Key: 
*/

require_once osc_plugins_path() . osc_plugin_folder(__FILE__) . 'model/ModelREST.php';
require_once osc_plugins_path() . osc_plugin_folder(__FILE__) . 'functions.php';


osc_add_route('rest-admin-new', 'rest/admin/new', 'rest/admin/new', osc_plugin_folder(__FILE__).'admin/key.php');
osc_add_route('rest-admin-edit', 'rest/admin/edit/([0-9]+)', 'rest/admin/edit/{keyEditId}', osc_plugin_folder(__FILE__).'admin/key.php');
osc_add_route('rest-admin-delete', 'rest/admin/delete/([0-9]+)', 'rest/admin/delete/{keyDeleteId}', osc_plugin_folder(__FILE__).'admin/configure.php');



// INSTALL FUNCTION - DEFINE VARIABLES
function rest_call_after_install() {
  osc_set_preference('enable', 0, 'plugin-rest', 'INTEGER');

  ModelREST::newInstance()->install();
}


function rest_call_after_uninstall() {
  ModelREST::newInstance()->uninstall();
}


// ADMIN MENU
function rest_menu($title = NULL) {
  echo '<link href="' . osc_base_url() . 'oc-content/plugins/rest/css/admin.css?v=' . date('YmdHis') . '" rel="stylesheet" type="text/css" />';
  echo '<link href="' . osc_base_url() . 'oc-content/plugins/rest/css/bootstrap-switch.css" rel="stylesheet" type="text/css" />';
  echo '<link href="' . osc_base_url() . 'oc-content/plugins/rest/css/tipped.css" rel="stylesheet" type="text/css" />';
  echo '<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet" type="text/css" />';
  echo '<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />';
  echo '<script src="' . osc_base_url() . 'oc-content/plugins/rest/js/admin.js?v=' . date('YmdHis') . '"></script>';
  echo '<script src="' . osc_base_url() . 'oc-content/plugins/rest/js/tipped.js"></script>';
  echo '<script src="' . osc_base_url() . 'oc-content/plugins/rest/js/bootstrap-switch.js"></script>';



  if( $title == '') { $title = __('Configure', 'rest'); }

  $text  = '<div class="mb-head">';
  $text .= '<div class="mb-head-left">';
  $text .= '<h1>' . $title . '</h1>';
  $text .= '<h2>Rest API Plugin</h2>';
  $text .= '</div>';
  $text .= '<div class="mb-head-right">';
  $text .= '<ul class="mb-menu">';
  $text .= '<li><a href="' . osc_base_url() . 'oc-admin/index.php?page=plugins&action=renderplugin&file=rest/admin/configure.php"><i class="fa fa-wrench"></i><span>' . __('Configure', 'rest') . '</span></a></li>';
  $text .= '<li><a href="' . osc_base_url() . 'oc-admin/index.php?page=plugins&action=renderplugin&file=rest/admin/logs.php"><i class="fa fa-database"></i><span>' . __('Logs', 'rest') . '</span></a></li>';
  $text .= '</ul>';
  $text .= '</div>';
  $text .= '</div>';

  echo $text;
}



// ADMIN FOOTER
function rest_footer() {
  $pluginInfo = osc_plugin_get_info('rest/index.php');
  $text  = '<div class="mb-footer">';
  $text .= '<a target="_blank" class="mb-developer" href="https://osclasspoint.com"><img src="https://osclasspoint.com/favicon.ico" alt="OsclassPoint Market" /> OsclassPoint Market</a>';
  $text .= '<a target="_blank" href="' . $pluginInfo['support_uri'] . '"><i class="fa fa-bug"></i> ' . __('Report Bug', 'rest') . '</a>';
  $text .= '<a target="_blank" href="https://forums.osclasspoint.com/"><i class="fa fa-handshake-o"></i> ' . __('Support Forums', 'rest') . '</a>';
  $text .= '<a target="_blank" class="mb-last" href="mailto:info@osclasspoint.com"><i class="fa fa-envelope"></i> ' . __('Contact Us', 'rest') . '</a>';
  $text .= '<span class="mb-version">v' . $pluginInfo['version'] . '</span>';
  $text .= '</div>';

  return $text;
}



// ADD MENU LINK TO PLUGIN LIST
function rest_admin_menu() {
echo '<h3><a href="#">Rest API Plugin</a></h3>
<ul> 
  <li><a style="color:#2eacce;" href="' . osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/admin/configure.php') . '">&raquo; ' . __('Configure', 'rest') . '</a></li>
  <li><a style="color:#2eacce;" href="' . osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/admin/logs.php') . '">&raquo; ' . __('Logs', 'rest') . '</a></li>
</ul>';
}


// ADD MENU TO PLUGINS MENU LIST
osc_add_hook('admin_menu','rest_admin_menu', 1);



// DISPLAY CONFIGURE LINK IN LIST OF PLUGINS
function rest_conf() {
  osc_admin_render_plugin( osc_plugin_path( dirname(__FILE__) ) . '/admin/configure.php' );
}

osc_add_hook( osc_plugin_path( __FILE__ ) . '_configure', 'rest_conf' );	


// CALL WHEN PLUGIN IS ACTIVATED - INSTALLED
osc_register_plugin(osc_plugin_path(__FILE__), 'rest_call_after_install');

// SHOW UNINSTALL LINK
osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'rest_call_after_uninstall');

?>