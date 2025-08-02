<?php
/*
  Plugin Name: Cache Plugin
  Plugin URI: https://osclasspoint.com
  Description: Cache plugin drastically speed up osclass websites
  Version: 1.2.1
  Author: MB Themes
  Author URI: https://osclasspoint.com
  Author Email: info@osclasspoint.com
  Short Name: cache
  Plugin update URI: cache
  Support URI: https://forums.mb-themes.com/cache-plugin/
  Product Key: 
*/

require_once osc_plugins_path() . osc_plugin_folder(__FILE__) . 'model/ModelCAC.php';
require_once osc_plugins_path() . osc_plugin_folder(__FILE__) . 'functions.php';



// INSTALL FUNCTION - DEFINE VARIABLES
function cac_call_after_install() {
  osc_set_preference('enable', 0, 'plugin-cache', 'INTEGER');
  osc_set_preference('disable_admin', 1, 'plugin-cache', 'INTEGER');
  osc_set_preference('refresh_interval', 6, 'plugin-cache', 'INTEGER');
  osc_set_preference('clean_interval', 7, 'plugin-cache', 'INTEGER');
  osc_set_preference('home', 0, 'plugin-cache', 'INTEGER');
  osc_set_preference('search', 0, 'plugin-cache', 'INTEGER');
  osc_set_preference('item', 0, 'plugin-cache', 'INTEGER');
  osc_set_preference('static', 0, 'plugin-cache', 'INTEGER');
  osc_set_preference('register', 0, 'plugin-cache', 'INTEGER');
  osc_set_preference('contact', 0, 'plugin-cache', 'INTEGER');
  osc_set_preference('compress', 0, 'plugin-cache', 'INTEGER');

  ModelCAC::newInstance()->install();
}


function cac_call_after_uninstall() {
  ModelCAC::newInstance()->uninstall();
  cac_clean_dir(cac_upload_path());
}


// START MEASURE RUN TIME
function cac_init() {
  GLOBAL $cac_time_start; 
  $cac_time_start = microtime(true);

  GLOBAL $cac_messages;
  $cac_messages = Session::newInstance()->_getMessage('pubMessages');
}

osc_add_hook('init', 'cac_init');



// CACHE - START
function cac_start() {
  if(Params::getParam('fbLogin') == 1 || Params::getParam('gglLogin') == 1) {
    return false;
  }

  $cached_file = cac_upload_path() . cac_get_dir() . cac_get_name() . '.html';

  GLOBAL $cac_messages; 
  $cac_messages = Session::newInstance()->_getMessage('pubMessages');

  // Cache exists and is allright, use it!
  if(cac_use_cache($cached_file)) {
    include($cached_file);

    cac_admin_notification();    
    cac_admin_notification_check();
    
    echo PHP_EOL . "<!-- Cache used, created on " . date('j M. Y, H:i:s', @filemtime($cached_file)) . ", loaded in " . cac_time() . "s, file id " . @basename($cached_file) . " -->";
    exit;
  }


  if(cac_generate_check('', true)) {
    if(cac_param('compress') == 1) {
      ob_start('ob_gzhandler');
    } else {
      ob_start();
    }
  }
}


// CACHE - END
function cac_end() {
  if(Params::getParam('fbLogin') == 1 || Params::getParam('gglLogin') == 1) {
    return false;
  }

  cac_admin_notification();


  if(cac_generate_check()) {
    cac_check_dir(cac_upload_path());
    cac_check_dir(cac_upload_path() . cac_get_dir());

    $fp = fopen(cac_upload_path() . cac_get_dir() . cac_get_name() . '.html', 'w');

    if(cac_param('compress') == 1) {
      $content = cac_sanitize_output(ob_get_contents());
    } else {
      $content = ob_get_contents();
    }

    ob_end_flush();

    fwrite($fp, $content);
    fclose($fp);

    clearstatcache();
  }
}


osc_add_hook('before_html', 'cac_start', 10);
osc_add_hook('after_html', 'cac_end', 10);




// ADMIN MENU
function cac_menu($title = NULL) {
  echo '<link href="' . osc_base_url() . 'oc-content/plugins/cache/css/admin.css?v=' . date('YmdHis') . '" rel="stylesheet" type="text/css" />';
  echo '<link href="' . osc_base_url() . 'oc-content/plugins/cache/css/bootstrap-switch.css" rel="stylesheet" type="text/css" />';
  echo '<link href="' . osc_base_url() . 'oc-content/plugins/cache/css/tipped.css" rel="stylesheet" type="text/css" />';
  echo '<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />';
  echo '<script src="' . osc_base_url() . 'oc-content/plugins/cache/js/admin.js?v=' . date('YmdHis') . '"></script>';
  echo '<script src="' . osc_base_url() . 'oc-content/plugins/cache/js/tipped.js"></script>';
  echo '<script src="' . osc_base_url() . 'oc-content/plugins/cache/js/bootstrap-switch.js"></script>';



  if( $title == '') { $title = __('Configure', 'cache'); }

  $text  = '<div class="mb-head">';
  $text .= '<div class="mb-head-left">';
  $text .= '<h1>' . $title . '</h1>';
  $text .= '<h2>Cache Plugin</h2>';
  $text .= '</div>';
  $text .= '<div class="mb-head-right">';
  $text .= '<ul class="mb-menu">';
  $text .= '<li><a href="' . osc_admin_base_url(true) . '?page=plugins&action=renderplugin&file=cache/admin/configure.php"><i class="fa fa-wrench"></i><span>' . __('Configure', 'cache') . '</span></a></li>';
  $text .= '</ul>';
  $text .= '</div>';
  $text .= '</div>';

  echo $text;
}



// ADMIN FOOTER
function cac_footer() {
  $pluginInfo = osc_plugin_get_info('cache/index.php');
  $text  = '<div class="mb-footer">';
  $text .= '<a target="_blank" class="mb-developer" href="https://osclasspoint.com"><img src="https://osclasspoint.com/favicon.ico" alt="OsclassPoint Market" /> OsclassPoint Market</a>';
  $text .= '<a target="_blank" href="' . $pluginInfo['support_uri'] . '"><i class="fa fa-bug"></i> ' . __('Report Bug', 'cache') . '</a>';
  $text .= '<a target="_blank" href="https://forums.osclasspoint.com/"><i class="fa fa-handshake-o"></i> ' . __('Support Forums', 'cache') . '</a>';
  $text .= '<a target="_blank" class="mb-last" href="mailto:info@osclasspoint.com"><i class="fa fa-envelope"></i> ' . __('Contact Us', 'cache') . '</a>';
  $text .= '<span class="mb-version">v' . $pluginInfo['version'] . '</span>';
  $text .= '</div>';

  return $text;
}



// ADD MENU LINK TO PLUGIN LIST
function cac_admin_menu() {
echo '<h3><a href="#">Cache Plugin</a></h3>
<ul> 
  <li><a style="color:#2eacce;" href="' . osc_admin_render_plugin_url(osc_plugin_path(dirname(__FILE__)) . '/admin/configure.php') . '">&raquo; ' . __('Configure', 'cache') . '</a></li>
</ul>';
}


// ADD MENU TO PLUGINS MENU LIST
osc_add_hook('admin_menu','cac_admin_menu', 1);



// DISPLAY CONFIGURE LINK IN LIST OF PLUGINS
function cac_conf() {
  osc_admin_render_plugin( osc_plugin_path( dirname(__FILE__) ) . '/admin/configure.php' );
}

osc_add_hook( osc_plugin_path( __FILE__ ) . '_configure', 'cac_conf' );	


// CALL WHEN PLUGIN IS ACTIVATED - INSTALLED
osc_register_plugin(osc_plugin_path(__FILE__), 'cac_call_after_install');

// SHOW UNINSTALL LINK
osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'cac_call_after_uninstall');

?>