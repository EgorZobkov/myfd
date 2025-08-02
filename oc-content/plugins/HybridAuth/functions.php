<?php 


function redirect_url() {
  if(osc_get_bool_preference('HybridRedirect', 'HybridAuth') == 1) {
      osc_redirect_to(osc_user_dashboard_url());
  }
  else {
      osc_redirect_to(osc_base_url());
  }
}




?>