<?php
if(!defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

class CAdminAtt extends AdminSecBaseModel {
  function __construct() {
    parent::__construct();
  }

  function doModel() {
    parent::doModel();

    switch($this->action) {
      default:
        $this->doView('att/index.php');
        break;
    }
  }

  function doView($file) {
    osc_run_hook('before_admin_html');
    osc_current_admin_theme_path($file);
    Session::newInstance()->_clearVariables();
    osc_run_hook('after_admin_html');
  }
}

/* file end: ./oc-admin/att.php */