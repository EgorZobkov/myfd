<?php


// GET TYPE
function rest_get_type($type) { 
  if($type == 'read') {
    return __('Read', 'rest');
  } else if($type == 'insert') {
    return __('Insert', 'rest');
  } else if($type == 'update') {
    return __('Update', 'rest');
  } else if($type == 'delete') {
    return __('Delete', 'rest');
  } else {
    return __('Unknown', 'rest');
  }
}

// GET STATUS
function rest_get_status($status) { 
  if($status == 'OK') {
    return __('Ok', 'rest');
  } else if($status == 'ERROR') {
    return __('Error', 'rest');
  } else {
    return __('Unknown', 'rest');
  }
}


// CONSTRUCT SEARCH
// function rest_get_search_items($options) {
  // $src = new Search();
  
  // if(isset($options['bPic']) && $options['bPic'] > 0) {
    // $src->withPicture(true);
  // }

  // if(isset($options['sCategory'])) {
    // $src->addCategory($options['sCategory']);
  // }
  
  // if(isset($options['sCountry'])) {
    // $src->addCountry($options['sCountry']);
  // }
  
  // if(isset($options['sRegion'])) {
    // $src->addRegion($options['sRegion']);
  // }
  
  // if(isset($options['sCity'])) {
    // $src->addCity($options['sCity']);
  // }
  
  // if(isset($options['sCityArea'])) {
    // $src->addCityArea($options['sCityArea']);
  // }
  
  // if(isset($options['sUser'])) {
    // $src->fromUser($options['sUser']);
  // }
  
 
  // if(isset($options['sPriceMin'])) {
    // $src->priceMin($options['sPriceMin']);
  // }

  // if(isset($options['sPriceMax'])) {
    // $src->priceMax($options['sPriceMax']);
  // }
  
  // if(isset($options['bPremium']) && $options['bPremium'] > 0) {
    // $src->onlyPremium(true);
  // }
 
  // if(isset($options['sPattern'])) {
    // $src->addPattern($options['sPattern']);
  // } 
  
  // if(isset($options['sEmail'])) {
    // $src->addContactEmail($options['sEmail']);
  // }   

  // if(isset($options['userId'])) {
    // $src->fromUser($options['userId']);
  // }    

  // if(isset($options['itemId']) && $options['itemId'] > 0) {
    // $src->addItemId($options['itemId']);
  // }
  
  
  // if(isset($options['sPeriod']) && $options['sPeriod'] > 0) {
    // $date_from = date('Y-m-d', strtotime(' -' . $options['sPeriod'] . ' day', time()));
    // $src->addConditions(sprintf('cast(%st_item.dt_pub_date as date) > "%s"', DB_TABLE_PREFIX, $date_from));
  // }
 
 
  // if(isset($options['sCompany']) && $options['sCompany'] <> '' && $options['sCompany'] <> null) {
    // $src->addJoinTable( DB_TABLE_PREFIX.'t_user.pk_i_id', DB_TABLE_PREFIX.'t_user', DB_TABLE_PREFIX.'t_item.fk_i_user_id = '.DB_TABLE_PREFIX.'t_user.pk_i_id', 'LEFT OUTER' );

    // if($options['sCompany'] == 1) {
      // $src->addConditions(sprintf("%st_user.b_company = 1", DB_TABLE_PREFIX));
    // } else {
      // $src->addConditions(sprintf("coalesce(%st_user.b_company, 0) <> 1", DB_TABLE_PREFIX));
    // }
  // }
  
  // if(isset($options['sOrder']) && isset($options['iOrderType'])) {
    // $src->order($options['sOrder'], $options['iOrderType']);
  // }
  

  // $src->limit(@$options['iPage'] > 0 ? $options['iPage'] : 0, @$options['limit'] > 0 ? $options['limit'] : 12);
  
  // osc_run_hook('search_conditions', Params::getParamsAsArray());
  
  // $items = $src->doSearch();
  
  // return $items;
// }


function rest_get_search_items2() {
  // this is from oc-includes/osclass/controller/search.php
  
  //require_once(osc_lib_path() . 'osclass/controller/search.php');
  //$src = new CWebSearch();
  
  class RestSearch{};
  $src = new RestSearch();
  $src->mSearch = Search::newInstance();

  if(osc_rewrite_enabled()) {
    // IF rewrite is not enabled, skip this part, preg_match is always time&resources consuming task
    $p_sParams = '/' . Params::getParam('sParams', false, false);
    
    if(preg_match_all('|\/([^,]+),([^\/]*)|', $p_sParams, $m)) {
      $l = count($m[0]);
      for($k = 0;$k<$l;$k++) {
        switch($m[1][$k]) {
          case osc_get_preference('rewrite_search_country'):
            $m[1][$k] = 'sCountry';
            break;
          case osc_get_preference('rewrite_search_region'):
            $m[1][$k] = 'sRegion';
            break;
          case osc_get_preference('rewrite_search_city'):
            $m[1][$k] = 'sCity';
            break;
          case osc_get_preference('rewrite_search_city_area'):
            $m[1][$k] = 'sCityArea';
            break;
          case osc_get_preference('rewrite_search_category'):
            $m[1][$k] = 'sCategory';
            break;
          case osc_get_preference('rewrite_search_user'):
            $m[1][$k] = 'sUser';
            break;
          case osc_get_preference('rewrite_search_pattern'):
            $m[1][$k] = 'sPattern';
            break;
          default :
            // custom fields
            if( preg_match("/meta(\d+)-?(.*)?/", $m[1][$k], $results) ) {
              $meta_key   = $m[1][$k];
              $meta_value = $m[2][$k];
              $array_r  = array();
              if(Params::existParam('meta')) {
                $array_r = Params::getParam('meta');
              }
              if($results[2]=='') {
                // meta[meta_id] = meta_value
                $meta_key = $results[1];
                $array_r[$meta_key] = $meta_value;
              } else {
                // meta[meta_id][meta_key] = meta_value
                $meta_key  = $results[1];
                $meta_key2 = $results[2];
                $array_r[$meta_key][$meta_key2]  = $meta_value;
              }
              $m[1][$k] = 'meta';
              $m[2][$k] = $array_r;
            }
            break;
        }

        Params::setParam($m[1][$k], $m[2][$k]);
      }
      Params::unsetParam('sParams');
    }
  }



  ////////////////////////////////
  //GETTING AND FIXING SENT DATA//
  ////////////////////////////////
  $p_sCategory  = Params::getParam('sCategory');
  if(!is_array($p_sCategory)) {
    if($p_sCategory == '') {
      $p_sCategory = array();
    } else {
      $p_sCategory = explode( ',' , $p_sCategory);
    }
  }

  $p_sCityArea  = Params::getParam('sCityArea');
  if(!is_array($p_sCityArea)) {
    if($p_sCityArea == '') {
      $p_sCityArea = array();
    } else {
      $p_sCityArea = explode( ',' , $p_sCityArea);
    }
  }

  $p_sCity    = Params::getParam('sCity');
  if(!is_array($p_sCity)) {
    if($p_sCity == '') {
      $p_sCity = array();
    } else {
      $p_sCity = explode( ',' , $p_sCity);
    }
  }

  $p_sRegion  = Params::getParam('sRegion');
  if(!is_array($p_sRegion)) {
    if($p_sRegion == '') {
      $p_sRegion = array();
    } else {
      $p_sRegion = explode( ',' , $p_sRegion);
    }
  }

  $p_sCountry   = Params::getParam('sCountry');
  if(!is_array($p_sCountry)) {
    if($p_sCountry == '') {
      $p_sCountry = array();
    } else {
      $p_sCountry = explode( ',' , $p_sCountry);
    }
  }

  $p_sUser    = Params::getParam('sUser');
  if(!is_array($p_sUser)) {
    if($p_sUser == '') {
      $p_sUser = '';
    } else {
      $p_sUser = explode( ',' , $p_sUser);
    }
  }

  $p_sLocale   = Params::getParam('sLocale');
  if(!is_array($p_sLocale)) {
    if($p_sLocale == '') {
      $p_sLocale = '';
    } else {
      $p_sLocale = explode( ',' , $p_sLocale);
    }
  }

  $p_sPattern   = osc_apply_filter('search_pattern', trim(strip_tags(Params::getParam('sPattern'))));

  $p_bPic     = Params::getParam('bPic');
  $p_bPic = ($p_bPic == 1) ? 1 : 0;

  $p_bPremium   = Params::getParam('bPremium');
  $p_bPremium = ($p_bPremium == 1) ? 1 : 0;

  $p_sPriceMin  = Params::getParam('sPriceMin');
  $p_sPriceMax  = Params::getParam('sPriceMax');

  //WE CAN ONLY USE THE FIELDS RETURNED BY Search::getAllowedColumnsForSorting()
  $p_sOrder   = Params::getParam('sOrder');
  if(!in_array($p_sOrder, Search::getAllowedColumnsForSorting())) {
    $p_sOrder = osc_default_order_field_at_search();
  }
  $old_order = $p_sOrder;

  //ONLY 0 ( => 'asc' ), 1 ( => 'desc' ) AS ALLOWED VALUES
  $p_iOrderType = Params::getParam('iOrderType');
  $allowedTypesForSorting = Search::getAllowedTypesForSorting();
  $orderType = osc_default_order_type_at_search();
  foreach($allowedTypesForSorting as $k => $v) {
    if($p_iOrderType==$v) {
      $orderType = $k;
      break;
    }
  }
  $p_iOrderType = $orderType;

  $p_iPage    = 0;
  if( is_numeric(Params::getParam('iPage')) && Params::getParam('iPage') > 0 ) {
    $p_iPage = (int) Params::getParam( 'iPage' ) - 1;
  }


  // search results: it's blocked with the maxResultsPerPage@search defined in t_preferences
  $p_iPageSize = (int) Params::getParam( 'iPagesize' );
  if($p_iPageSize <= 0) {
    $p_iPageSize = 1000;
  }

  //FILTERING CATEGORY
  $bAllCategoriesChecked = false;
  $successCat = false;
  if(count($p_sCategory) > 0) {
    foreach($p_sCategory as $category) {
      try {
        $successCat = ( $src->mSearch->addCategory( $category ) || $successCat );
      } catch ( Exception $e ) {
      }
    }
  } else {
    $bAllCategoriesChecked = true;
  }

  //FILTERING CITY_AREA
  foreach($p_sCityArea as $city_area) {
    $src->mSearch->addCityArea($city_area);
  }
  $p_sCityArea = implode( ', ' , $p_sCityArea);

  //FILTERING CITY
  foreach($p_sCity as $city) {
    $src->mSearch->addCity($city);
  }
  $p_sCity = implode( ', ' , $p_sCity);

  //FILTERING REGION
  foreach($p_sRegion as $region) {
    $src->mSearch->addRegion($region);
  }
  $p_sRegion = implode( ', ' , $p_sRegion);

  //FILTERING COUNTRY
  foreach($p_sCountry as $country) {
    $src->mSearch->addCountry($country);
  }
  $p_sCountry = implode( ', ' , $p_sCountry);

  // FILTERING PATTERN
  if($p_sPattern != '') {
    $src->mSearch->addPattern($p_sPattern);
    $osc_request['sPattern'] = $p_sPattern;
  } else {
    // hardcoded - if there isn't a search pattern, order by dt_pub_date desc
    if($p_sOrder == 'relevance') {
      $p_sOrder = 'dt_pub_date';
      foreach($allowedTypesForSorting as $k => $v) {
        if($p_iOrderType=='desc') {
          $orderType = $k;
          break;
        }
      }
      $p_iOrderType = $orderType;
    }
  }

  // FILTERING USER
  if($p_sUser != '') {
    $src->mSearch->fromUser($p_sUser);
  }

  // FILTERING LOCALE
  $src->mSearch->addLocale($p_sLocale);

  // FILTERING IF WE ONLY WANT ITEMS WITH PICS
  if($p_bPic) {
    $src->mSearch->withPicture(true);
  }

  // FILTERING IF WE ONLY WANT PREMIUM ITEMS
  if($p_bPremium) {
    $src->mSearch->onlyPremium(true);
  }

  //FILTERING BY RANGE PRICE
  $src->mSearch->priceRange($p_sPriceMin, $p_sPriceMax);

  //ORDERING THE SEARCH RESULTS
  $src->mSearch->order( $p_sOrder, $allowedTypesForSorting[$p_iOrderType]);

  //SET PAGE
  $src->mSearch->page($p_iPage, $p_iPageSize);

  // CUSTOM FIELDS
  $custom_fields = Params::getParam('meta');
  try {
    $fields = Field::newInstance()->findIDSearchableByCategories( $p_sCategory );
  } catch ( Exception $e ) {
  }
  $table = DB_TABLE_PREFIX.'t_item_meta';
  if(is_array($custom_fields)) {
    foreach($custom_fields as $key => $aux) {
      if(in_array($key, $fields)) {
        $field = Field::newInstance()->findByPrimaryKey($key);
        switch ($field['e_type']) {
          case 'TEXTAREA':
          case 'TEXT':
          case 'URL':
            if($aux!='') {
              $aux = "%$aux%";
              $sql = "SELECT fk_i_item_id FROM $table WHERE ";
              $str_escaped = Search::newInstance()->dao->escape($aux);
              $sql .= $table.'.fk_i_field_id = '.$key.' AND ';
              $sql .= $table . '.s_value LIKE ' . $str_escaped;
              $src->mSearch->addConditions(DB_TABLE_PREFIX.'t_item.pk_i_id IN ('.$sql.')');
            }
            break;
          case 'DROPDOWN':
          case 'RADIO':
            if($aux!='') {
              $sql = "SELECT fk_i_item_id FROM $table WHERE ";
              $str_escaped = Search::newInstance()->dao->escape($aux);
              $sql .= $table.'.fk_i_field_id = '.$key.' AND ';
              $sql .= $table . '.s_value = ' . $str_escaped;
              $src->mSearch->addConditions(DB_TABLE_PREFIX.'t_item.pk_i_id IN ('.$sql.')');
            }
            break;
          case 'CHECKBOX':
            if($aux!='') {
              $sql = "SELECT fk_i_item_id FROM $table WHERE ";
              $sql .= $table.'.fk_i_field_id = '.$key.' AND ';
              $sql .= $table . '.s_value = 1';
              $src->mSearch->addConditions(DB_TABLE_PREFIX.'t_item.pk_i_id IN ('.$sql.')');
            }
            break;
          case 'DATE':
            if($aux!='') {
              $y = (int)date('Y', $aux);
              $m = (int)date('n', $aux);
              $d = (int)date('j', $aux);
              $start = mktime('0', '0', '0', $m, $d, $y);
              $end   = mktime('23', '59', '59', $m, $d, $y);
              $sql = "SELECT fk_i_item_id FROM $table WHERE ";
              $sql .= $table.'.fk_i_field_id = '.$key.' AND ';
              $sql .= $table . '.s_value >= ' . $start . ' AND ';
              $sql .= $table . '.s_value <= ' . $end;
              $src->mSearch->addConditions(DB_TABLE_PREFIX.'t_item.pk_i_id IN ('.$sql.')');
            }
            break;
          case 'DATEINTERVAL':
            if( is_array($aux) && (!empty($aux['from']) && !empty($aux['to'])) ) {
              $from = $aux['from'];
              $to   = $aux['to'];
              $start = $from;
              $end   = $to;
              $sql = "SELECT fk_i_item_id FROM $table WHERE ";
              $sql .= $table.'.fk_i_field_id = '.$key.' AND ';
              $sql .= $start . ' >= ' . $table . ".s_value AND s_multi = 'from'";
              $sql1 = "SELECT fk_i_item_id FROM $table WHERE ";
              $sql1 .= $table . '.fk_i_field_id = ' . $key . ' AND ';
              $sql1 .= $end . ' <= ' . $table . ".s_value AND s_multi = 'to'";
              $sql_interval = 'select a.fk_i_item_id from (' . $sql . ') a where a.fk_i_item_id IN (' . $sql1 . ')';
              $src->mSearch->addConditions(DB_TABLE_PREFIX.'t_item.pk_i_id IN ('.$sql_interval.')');
            }
            break;
          default:
            break;
        }

      }
    }
  }

  osc_run_hook('search_conditions', Params::getParamsAsArray());

  // RETRIEVE ITEMS AND TOTAL
  $key  = md5(osc_base_url().$src->mSearch->toJson());
  $found  = null;
  try {
    $cache = osc_cache_get( $key , $found );
  } catch ( Exception $e ) {
  }

  $aItems     = null;
  $iTotalItems  = null;
  if($cache) {
    $aItems     = $cache['aItems'];
    $iTotalItems  = $cache['iTotalItems'];
  } else {
    $aItems    = $src->mSearch->doSearch();
    $iTotalItems = $src->mSearch->count();
    $_cache['aItems']    = $aItems;
    $_cache['iTotalItems'] = $iTotalItems;
    try {
      osc_cache_set( $key , $_cache , OSC_CACHE_TTL );
    } catch ( Exception $e ) {
    }
  }
  
  $aItems = osc_apply_filter('pre_show_items', $aItems);

  $iStart  = $p_iPage * $p_iPageSize;
  $iEnd    = min(($p_iPage+1) * $p_iPageSize, $iTotalItems);
  $iNumPages = ceil($iTotalItems / $p_iPageSize);

  // works with cache enabled ?
  osc_run_hook('search', $src->mSearch);

  //preparing variables...
  $countryName = $p_sCountry;
  if( strlen($p_sCountry)==2 ) {
    $c = Country::newInstance()->findByCode($p_sCountry);
    if( $c ) {
      $countryName = $c['s_name'];

      if(osc_get_current_user_locations_native() == 1) {
        if($c['s_name_native'] <> '') {
          $countryName = $c['s_name_native'];
        }
      }
    }
  }
  $regionName = $p_sRegion;
  if( is_numeric($p_sRegion) ) {
    $r = Region::newInstance()->findByPrimaryKey($p_sRegion);
    if( $r ) {
      $regionName = $r['s_name'];

      if(osc_get_current_user_locations_native() == 1) {
        if($r['s_name_native'] <> '') {
          $regionName = $r['s_name_native'];
        }
      }
    }
  }
  $cityName = $p_sCity;
  if( is_numeric($p_sCity) ) {
    $c = City::newInstance()->findByPrimaryKey($p_sCity);
    if( $c ) {
      $cityName = $c['s_name'];

      if(osc_get_current_user_locations_native() == 1) {
        if($c['s_name_native'] <> '') {
          $cityName = $c['s_name_native'];
        }
      }
    }
  }

  // calling the view...
  if( count($aItems) === 0 ) {
    return array();
  }

  return $aItems;
}
  


// GET KEY ACCESS
function rest_key_access($key) {
  $data = ModelREST::newInstance()->getKey($key);

  if($data !== false) {
    $access = explode(',', $data['s_privilege']);
    return $access;
  }

  return array();
}

// CREATE RESPONSE
function rest_response($status, $message = 'Ok', $execution_time = 0, $block = 0, $response = array()) {

  if($status == 'OK') {
    http_response_code(200);
  } else if($status == 'ERROR') {
    http_response_code(404);
  }

  $data = array(
    'status' => $status,
    'message' => $message,
    'execution_seconds' => (string)$execution_time,
    'block_id' => $block,
    'response' => $response  
  );

  return json_encode($data); 
}


// CORE FUNCTIONS
function rest_param($name) {
  return osc_get_preference($name, 'plugin-rest');
}


if(!function_exists('mb_param_update')) {
  function mb_param_update( $param_name, $update_param_name, $type = NULL, $plugin_var_name = NULL ) {
  
    $val = '';
    if( $type == 'check') {

      // Checkbox input
      if( Params::getParam( $param_name ) == 'on' ) {
        $val = 1;
      } else {
        if( Params::getParam( $update_param_name ) == 'done' ) {
          $val = 0;
        } else {
          $val = ( osc_get_preference( $param_name, $plugin_var_name ) != '' ) ? osc_get_preference( $param_name, $plugin_var_name ) : '';
        }
      }
    } else {

      // Other inputs (text, password, ...)
      if( Params::getParam( $update_param_name ) == 'done' && Params::existParam($param_name)) {
        $val = Params::getParam( $param_name );
      } else {
        $val = ( osc_get_preference( $param_name, $plugin_var_name) != '' ) ? osc_get_preference( $param_name, $plugin_var_name ) : '';
      }
    }


    // If save button was pressed, update param
    if( Params::getParam( $update_param_name ) == 'done' ) {

      if(osc_get_preference( $param_name, $plugin_var_name ) == '') {
        osc_set_preference( $param_name, $val, $plugin_var_name, 'STRING');  
      } else {
        $dao_preference = new Preference();
        $dao_preference->update( array( "s_value" => $val ), array( "s_section" => $plugin_var_name, "s_name" => $param_name ));
        osc_reset_preferences();
        unset($dao_preference);
      }
    }

    return $val;
  }
}


// CHECK IF RUNNING ON DEMO
function rest_is_demo() {
  if(osc_logged_admin_username() == 'admin') {
    return false;
  } else if(isset($_SERVER['HTTP_HOST']) && (strpos($_SERVER['HTTP_HOST'],'mb-themes') !== false || strpos($_SERVER['HTTP_HOST'],'abprofitrade') !== false)) {
    return true;
  } else {
    return false;
  }
}


if(!function_exists('message_ok')) {
  function message_ok( $text ) {
    $final  = '<div class="flashmessage flashmessage-ok flashmessage-inline">';
    $final .= $text;
    $final .= '</div>';
    echo $final;
  }
}


if(!function_exists('message_error')) {
  function message_error( $text ) {
    $final  = '<div class="flashmessage flashmessage-error flashmessage-inline">';
    $final .= $text;
    $final .= '</div>';
    echo $final;
  }
}



// COOKIES WORK
if(!function_exists('mb_set_cookie')) {
  function mb_set_cookie($name, $val) {
    Cookie::newInstance()->set_expires( 86400 * 30 );
    Cookie::newInstance()->push($name, $val);
    Cookie::newInstance()->set();
  }
}


if(!function_exists('mb_get_cookie')) {
  function mb_get_cookie($name) {
    return Cookie::newInstance()->get_value($name);
  }
}

if(!function_exists('mb_drop_cookie')) {
  function mb_drop_cookie($name) {
    Cookie::newInstance()->pop($name);
  }
}


if(!function_exists('mb_generate_rand_string')) {
  function mb_generate_rand_string($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
  }
}


?>