<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

$aProviders     = SCClass::providers();
$providers = array_values($aProviders);
$provider = explode("?", Params::getParam('provider'));
$provider = $provider[0];
ob_get_clean();

if (in_array($provider, $providers)) {
    $success = SCClass::newInstance()->login($provider);
    if($success) {
        $url = Session::newInstance()->_get('sc_rd_' . Params::getParam('rd'));
        Session::newInstance()->_drop('sc_rd_' . Params::getParam('rd'));
        if($url!='') {
            osc_redirect_to($url);
        } else {
            osc_redirect_to(osc_user_dashboard_url());
        }
    } else {
        osc_redirect_to(osc_user_login_url());
    }
    exit;
}
