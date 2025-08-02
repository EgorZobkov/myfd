<?php
//require_once dirname(__FILE__).'/../../../oc-load.php';

//require_once SC_PATH . 'lib/vendor/hybridauth/hybridauth/hybridauth/live.php';



$_REQUEST['hauth_done'] = 'Live';
Params::setParam('hauth_done', 'Live');
SCClass::newInstance()->endpoint();

?>