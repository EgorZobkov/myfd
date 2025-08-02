<?php
  define('ABS_PATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');
  require_once ABS_PATH . 'oc-load.php';
  
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  $status = 'OK';
  $message = __('Successful', 'rest');
  $response = array();
  $only_response = (Params::getParam('onlyResponse') == 1 ? 1 : 0);

  $time_start = microtime(true);

  $key = Params::getParam('key');
  $key_row = ModelREST::newInstance()->getKey($key);


  $params = Params::getParamsAsArray();
  //print_r($params);

  
  $type = Params::getParam('type');
  $object = Params::getParam('object');
  $action = Params::getParam('action');
  $block = 0;

  if(rest_param('enable') <> 1) {
    $status = 'ERROR';
    $message = __('Rest API is not enabled', 'rest');

  } else if($key == '') {
    $status = 'ERROR';
    $message = sprintf(__('%s is not defined', 'rest'), 'key');

  } else if(@$key_row['pk_i_id'] <= 0) {
    $status = 'ERROR';
    $message = __('Invalid API key', 'rest');

  } else if(@$key_row['s_status'] != 'active') {
    $status = 'ERROR';
    $message = __('This API Key has been deactivated', 'rest');

  } else if($type == '') {
    $status = 'ERROR';
    $message = sprintf(__('%s is not defined', 'rest'), 'type');

  } else if($object == '') {
    $status = 'ERROR';
    $message = sprintf(__('%s is not defined', 'rest'), 'object');

  } else if($action == '') {
    $status = 'ERROR';
    $message = sprintf(__('%s is not defined', 'rest'), 'action');

  }
  

  if($status != 'ERROR') {
    if($type == 'read') {

      // check read permissions here
      if(!in_array('read', rest_key_access($key))) {
        $status = 'ERROR';
        $message = sprintf(__('This key does not have %s access', 'rest'), __('read', 'rest'));

      } else if($object == 'item' && $action == 'byId') {
        // &object=item&action=byId&itemId=123
        $response = Item::newInstance()->findByPrimaryKey(Params::getParam('itemId'));
        $block = 1;

      } else if($object == 'item' && $action == 'resourcesById') {
        // &object=item&action=resourcesById&itemId=123
        $response = Item::newInstance()->findResourcesByID(Params::getParam('itemId'));
        $block = 2;

      } else if($object == 'item' && $action == 'locationById') {
        // &object=item&action=locationById&itemId=123
        $response = Item::newInstance()->findLocationByID(Params::getParam('itemId'));
        $block = 3;

      } else if($object == 'item' && $action == 'metaById') {
        // &object=item&action=metaById&itemId=123
        $response = Item::newInstance()->metaFields(Params::getParam('itemId'));
        $block = 4;

      } else if($object == 'item' && $action == 'commentsById') {
        // &object=item&action=commentsById&itemId=123&page=0&perPage=20
        $response = ItemComment::newInstance()->findByItemID(Params::getParam('itemId'), Params::getParam('page'), Params::getParam('perPage'));
        $block = 5;

      } else if($object == 'item' && $action == 'countCommentsById') {
        // &object=item&action=countCommentsById&itemId=123
        $response = ItemComment::newInstance()->count(Params::getParam('itemId'));
        $block = 6;



        
      } else if($object == 'items' && $action == 'byCategoryId') {
        // &object=items&action=byCategoryId&categoryId=123
        $response = Item::newInstance()->findByCategoryID(Params::getParam('categoryId'));
        $block = 7;

      } else if($object == 'items' && $action == 'byEmail') {
        // &object=items&action=byEmail&userEmail=abc@avc.com
        $response = Item::newInstance()->findByEmail(Params::getParam('userEmail'));
        $block = 8;

      } else if($object == 'items' && $action == 'byUserId') {
        // &object=items&action=byUserId&userId=123&start=0&end=20
        $response = Item::newInstance()->findByUserID(Params::getParam('userId'), Params::getParam('start'), Params::getParam('end'));
        $block = 9;

      } else if($object == 'items' && $action == 'byUserIdEnabled') {
        // &object=items&action=byUserIdEnabled&userId=123&start=0&end=20
        $response = Item::newInstance()->findByUserIDEnabled(Params::getParam('userId'), Params::getParam('start'), Params::getParam('end'));
        $block = 10;




      
      } else if($object == 'itemcount' && $action == 'total') {
        // &object=itemcount&action=total&categoryId=123&active=1
        $response = Item::newInstance()->totalItems(Params::getParam('categoryId'), Params::getParam('active'));
        $block = 11;

      } else if($object == 'itemcount' && $action == 'category') {
        // &object=itemcount&action=category&categoryId=123&enabled=1&active=1
        $response = Item::newInstance()->numItems(Params::getParam('categoryId'), Params::getParam('enabled'), Params::getParam('active'));
        $block = 12;

      } else if($object == 'itemcount' && $action == 'byUserId') {
        // &object=itemcount&action=byUserId&userId=123
        $response = Item::newInstance()->countByUserID(Params::getParam('userId'));
        $block = 13;

      } else if($object == 'itemcount' && $action == 'byUserIdEnabled') {
        // &object=itemcount&action=byUserIdEnabled&userId=123
        $response = Item::newInstance()->countByUserIDEnabled(Params::getParam('userId'));
        $block = 14;




      } else if($object == 'category' && $action == 'byId') {
        // &object=category&action=byId&categoryId=123
        $response = Category::newInstance()->findByPrimaryKey(Params::getParam('categoryId'));
        $block = 15;

      } else if($object == 'category' && $action == 'subcategoriesById') {
        // &object=category&action=subcategoriesById&categoryId=123
        $response = Category::newInstance()->findSubcategoriesEnabled(Params::getParam('categoryId'));
        $block = 16;

      } else if($object == 'category' && $action == 'root') {
        // &object=category&action=root
        $response = Category::newInstance()->findRootCategoriesEnabled();
        $block = 17;

      } else if($object == 'category' && $action == 'tree') {
        // &object=category&action=tree
        $response = Category::newInstance()->toTreeAll();
        $block = 18;

      } else if($object == 'category' && $action == 'listAll') {
        // &object=category&action=listAll
        $response = Category::newInstance()->listAll();
        $block = 19;




      } else if($object == 'city' && $action == 'byId') {
        // &object=city&action=byId&cityId=123
        $response = City::newInstance()->findByPrimaryKey(Params::getParam('cityId'));
        $block = 20;

      } else if($object == 'city' && $action == 'byName') {
        // &object=city&action=byName&cityName=Bremen&regionId=12
        $response = City::newInstance()->findByName(Params::getParam('cityName'), Params::getParam('regionId'));
        $block = 21;

      } else if($object == 'city' && $action == 'listAll') {
        // &object=city&action=listAll
        $response = City::newInstance()->listAll();
        $block = 22;

      } else if($object == 'city' && $action == 'statsById') {
        // &object=city&action=statsById&cityId=123
        $response = CityStats::newInstance()->findByCityId(Params::getParam('cityId'));
        $block = 23;

      } else if($object == 'cities' && $action == 'byRegionId') {
        // &object=cities&action=byRegionId&regionId=123
        $response = City::newInstance()->findByRegion(Params::getParam('regionId'));
        $block = 24;



      } else if($object == 'region' && $action == 'byId') {
        // &object=region&action=byId&regionId=123
        $response = Region::newInstance()->findByPrimaryKey(Params::getParam('regionId'));
        $block = 25;

      } else if($object == 'region' && $action == 'byName') {
        // &object=region&action=byName&regionName=Bremen&countryCode=us
        $response = Region::newInstance()->findByName(Params::getParam('regionName'), Params::getParam('countryCode'));
        $block = 26;

      } else if($object == 'region' && $action == 'listAll') {
        // &object=region&action=listAll
        $response = Region::newInstance()->listAll();
        $block = 27;

      } else if($object == 'region' && $action == 'statsById') {
        // &object=region&action=statsById&regionId=123
        $response = RegionStats::newInstance()->findByRegionId(Params::getParam('regionId'));
        $block = 28;

      } else if($object == 'regions' && $action == 'byCountryCode') {
        // &object=regions&action=byCountryCode&countryCode=us
        $response = Region::newInstance()->findByCountry(Params::getParam('countryCode'));
        $block = 29;



      } else if($object == 'country' && $action == 'byCode') {
        // &object=country&action=byCode&countryCode=us
        $response = Country::newInstance()->findByCode(Params::getParam('countryCode'));
        $block = 30;

      } else if($object == 'country' && $action == 'byName') {
        // &object=country&action=byName&countryName=Canada
        $response = Country::newInstance()->findByName(Params::getParam('countryName'));
        $block = 31;

      } else if($object == 'country' && $action == 'listAll') {
        // &object=country&action=listAll
        $response = Country::newInstance()->listAll();
        $block = 32;

      } else if($object == 'country' && $action == 'statsByCode') {
        // &object=country&action=statsByCode&countryCode=Canada
        $response = CountryStats::newInstance()->findByCountryCode(Params::getParam('countryCode'));
        $block = 33;



      } else if($object == 'currency' && $action == 'byId') {
        // &object=currency&action=byId&currencyId=eur
        $response = Currency::newInstance()->findByPrimaryKey(Params::getParam('currencyId'));
        $block = 34;

      } else if($object == 'currencies' && $action == 'listAll') {
        // &object=currencies&action=listAll
        $response = Currency::newInstance()->listAll();
        $block = 35;



      } else if($object == 'locale' && $action == 'byCode') {
        // &object=locale&action=byCode&localeCode=123
        $response = OSCLocale::newInstance()->findByCode(Params::getParam('localeCode'));
        $block = 36;

      } else if($object == 'locales' && $action == 'listAll') {
        // &object=locales&action=listAll
        $response = OSCLocale::newInstance()->listAll();
        $block = 37;




      } else if($object == 'user' && $action == 'byId') {
        // &object=user&action=byId&userId=123&localeCode=en_US
        $response = User::newInstance()->findByPrimaryKey(Params::getParam('userId'), Params::getParam('localeCode'));
        $block = 38;

      } else if($object == 'user' && $action == 'byEmail') {
        // &object=user&action=byEmail&userEmail=abc@abc.com&localeCode=en_US
        $response = User::newInstance()->findByEmail(Params::getParam('userEmail'), Params::getParam('localeCode'));
        $block = 39;

      } else if($object == 'user' && $action == 'count') {
        // &object=user&action=count
        $response = User::newInstance()->countUsers();
        $block = 40;

      } else if($object == 'user' && $action == 'commentsById') {
        // &object=user&action=commentsById&userId=123
        $response = ItemComment::newInstance()->findByAuthorID(Params::getParam('userId'));
        $block = 41;






      } else if($object == 'search' && $action == 'sortColumns') {
        // &object=search&action=sortColumns
        $response = Search::newInstance()->getAllowedColumnsForSorting();
        $block = 50;

      } else if($object == 'search' && $action == 'sortTypes') {
        // &object=search&action=sortType
        $response = Search::newInstance()->getAllowedTypesForSorting();
        $block = 51;

      } else if($object == 'search' && $action == 'premiumItems') {
        // &object=search&action=premiumItems&limit=5
        $response = Search::newInstance()->getPremiums(Params::getParam('limit') > 0 ? Params::getParam('limit') : 2);
        $block = 52;

      } else if($object == 'search' && $action == 'latestItems') {
        // &object=search&action=latestItems&limit=5
        $response = Search::newInstance()->getLatestItems(Params::getParam('limit') > 0 ? Params::getParam('limit') : 2);
        $block = 53;

      } else if($object == 'search' && $action == 'items') {
        // &object=search&action=items&sCategory=1&sRegion=5&sCity=2&sPriceMin=10&....
        $response = rest_get_search_items2();
        $block = 54;




      } else if($object == 'latestSearches' && $action == 'listAll') {
        // &object=latestSearches&action=listAll&limit=20
        $response = LatestSearches::newInstance()->getSearches(Params::getParam('limit') > 0 ? Params::getParam('limit') : 20);
        $block = 60;




      } else if($object == 'page' && $action == 'byId') {
        // &object=page&action=byId&pageId=123&localeCode=en_US
        $response = Page::newInstance()->findByPrimaryKey(Params::getParam('pageId'), Params::getParam('localeCode'));
        $block = 61;

      } else if($object == 'page' && $action == 'listAll') {
        // &object=page&action=listAll&localeCode=en_US
        $response = Page::newInstance()->listAll(0, null, Params::getParam('localeCode'));
        $block = 62;


      // PLUGINS COMING HERE

      // Business profile
      } else if($object == 'plugin-business_profile' && $action == 'listAll') {
        // &object=plugin-business_profile&action=listAll
        if(function_exists('bpr_call_after_install')) {
          $response = ModelBPR::newInstance()->getSellers(1, -1, -1, array(5000, 0));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-business_profile' && $action == 'byUserId') {
        // &object=plugin-business_profile&action=byUserId&userId=123
        if(function_exists('bpr_call_after_install')) {
          $response = ModelBPR::newInstance()->getSellerByUserId(Params::getParam('userId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-business_profile' && $action == 'count') {
        // &object=plugin-business_profile&action=count
        if(function_exists('bpr_call_after_install')) {
          $response = ModelBPR::newInstance()->countSellers(1);
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }


      // Make offer
      } else if($object == 'plugin-make_offer' && $action == 'byItemId') {
        // &object=plugin-make_offer&action=byItemId&itemId=123&validate=1
        if(function_exists('mo_call_after_install')) {
          $response = ModelMO::newInstance()->getOffersByItemId(Params::getParam('itemId'), Params::getParam('validate'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-make_offer' && $action == 'byOfferId') {
        // &object=plugin-make_offer&action=byOfferId&offerId=123
        if(function_exists('mo_call_after_install')) {
          $response = ModelMO::newInstance()->getOfferById(Params::getParam('offerId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }



      // User Rating
      } else if($object == 'plugin-user_rating' && $action == 'byUserId') {
        // &object=plugin-user_rating&action=byUserId&userId=123&userEmail=jo@do.com&type2=0&validate=1
        if(function_exists('ur_call_after_install')) {
          $response = ModelUR::newInstance()->getRatingByUserId(Params::getParam('userId'), Params::getParam('userEmail'), Params::getParam('type2'), Params::getParam('validate'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-user_rating' && $action == 'avgByUserId') {
        // &object=plugin-user_rating&action=avgByUserId&userId=123&userEmail=jo@do.com&type2=0&validate=1
        if(function_exists('ur_call_after_install')) {
          $response = ModelUR::newInstance()->getRatingAverageByUserId(Params::getParam('userId'), Params::getParam('userEmail'), Params::getParam('type2'), Params::getParam('validate'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }


      // Youtube Video
      } else if($object == 'plugin-youtube' && $action == 'byItemId') {
        // &object=plugin-youtube&action=byItemId&itemId=123
        if(function_exists('ytb_call_after_install')) {
          $response = ModelYTB::newInstance()->getVideoByItemId(Params::getParam('itemId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }


      // Forums plugin
      } else if($object == 'plugin-forums' && $action == 'listCategories') {
        // &object=plugin-forums&action=listCategories
        if(function_exists('frm_call_after_install')) {
          $response = ModelFRM::newInstance()->getCategories();
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-forums' && $action == 'listBoards') {
        // &object=plugin-forums&action=listBoards&categoryId=123&parentId=123
        if(function_exists('frm_call_after_install')) {
          $response = ModelFRM::newInstance()->getBoards(Params::getParam('categoryId'), Params::getParam('parentId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-forums' && $action == 'listBoardChildren') {
        // &object=plugin-forums&action=listBoardChildren&boardId=123
        if(function_exists('frm_call_after_install')) {
          $response = ModelFRM::newInstance()->getBoardChildren(Params::getParam('boardId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-forums' && $action == 'listTopics') {
        // &object=plugin-forums&action=listTopics&boardId=123&page=0&perPage=20
        if(function_exists('frm_call_after_install')) {
          $response = ModelFRM::newInstance()->getTopics(Params::getParam('boardId'), array(Params::getParam('perPage'), Params::getParam('page')));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-forums' && $action == 'listPosts') {
        // &object=plugin-forums&action=listPosts&topicId=123&page=0&perPage=20
        if(function_exists('frm_call_after_install')) {
          $response = ModelFRM::newInstance()->getPosts(Params::getParam('topicId'), array(Params::getParam('perPage'), Params::getParam('page')));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }
        
      } else if($object == 'plugin-forums' && $action == 'listUserPosts') {
        // &object=plugin-forums&action=listUserPosts&userId=123&page=0&perPage=20
        if(function_exists('frm_call_after_install')) {
          $response = ModelFRM::newInstance()->getPostsByUser(Params::getParam('userId'), array(Params::getParam('perPage'), Params::getParam('page')));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-forums' && $action == 'listSearchPosts') {
        // &object=plugin-forums&action=listSearchPosts&term=abc&page=0&perPage=20
        if(function_exists('frm_call_after_install')) {
          $response = ModelFRM::newInstance()->getPostsBySearchTerm(Params::getParam('term'), array(Params::getParam('perPage'), Params::getParam('page')));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-forums' && $action == 'userById') {
        // &object=plugin-forums&action=userById&userId=123
        if(function_exists('frm_call_after_install')) {
          $response = ModelFRM::newInstance()->getUser(Params::getParam('userId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }



      // Blog plugin
      } else if($object == 'plugin-blog' && $action == 'listBlogs') {
        // &object=plugin-blog&action=listBlogs
        if(function_exists('blg_call_after_install')) {
          $response = ModelBLG::newInstance()->getBlogs(Params::getParam('status'), Params::getParam('category_id'), Params::getParam('author_id'), Params::getParam('type2'), Params::getParam('keyword'), Params::getParam('view'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }


      } else if($object == 'plugin-blog' && $action == 'getBlogById') {
        // &object=plugin-blog&action=getBlogById&blogId=123
        if(function_exists('blg_call_after_install')) {
          $response = ModelBLG::newInstance()->getBlogDetail(Params::getParam('blogId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-blog' && $action == 'getCommentsByBlogId') {
        // &object=plugin-blog&action=getCommentsByBlogId&blogId=123
        if(function_exists('blg_call_after_install')) {
          $response = ModelBLG::newInstance()->getBlogComments(Params::getParam('blogId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-blog' && $action == 'getUserById') {
        // &object=plugin-blog&action=getUserById&userId=123&type2=
        if(function_exists('blg_call_after_install')) {
          $response = ModelBLG::newInstance()->getUser(Params::getParam('userId'), Params::getParam('type2'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-blog' && $action == 'getCategoryById') {
        // &object=plugin-blog&action=getCategoryById&categoryId=123
        if(function_exists('blg_call_after_install')) {
          $response = ModelBLG::newInstance()->getCategoryDetail(Params::getParam('categoryId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-blog' && $action == 'listCategories') {
        // &object=plugin-blog&action=listCategories
        if(function_exists('blg_call_after_install')) {
          $response = ModelBLG::newInstance()->getCategories();
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }


      // Virtual products
      } else if($object == 'plugin-virtual' && $action == 'lastFileByItemId') {
        // &object=plugin-virtual&action=lastFileByItemId&itemId=123
        if(function_exists('vrt_call_after_install')) {
          $response = ModelVRT::newInstance()->getLastFileByItemId(Params::getParam('itemId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-virtual' && $action == 'filesByUserId') {
        // &object=plugin-virtual&action=getDownloadsByUserId&userId=123
        if(function_exists('vrt_call_after_install')) {
          $response = ModelVRT::newInstance()->getDownloadsByUserId(Params::getParam('userId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-virtual' && $action == 'freeFilesByUserId') {
        // &object=plugin-virtual&action=freeFilesByUserId&userId=123
        if(function_exists('vrt_call_after_install')) {
          $response = ModelVRT::newInstance()->getFreeDownloads(Params::getParam('userId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }


      // Attributes
      } else if($object == 'plugin-attributes' && $action == 'listAttributes') {
        // &object=plugin-attributes&action=listAttributes&enabled=0&categoryId=123
        if(function_exists('atr_call_after_install')) {
          $response = ModelATR::newInstance()->getAttributes(Params::getParam('enabled'), Params::getParam('categoryId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-attributes' && $action == 'listRequiredAttributes') {
        // &object=plugin-attributes&action=listRequiredAttributes&categoryId=123
        if(function_exists('atr_call_after_install')) {
          $response = ModelATR::newInstance()->getRequiredAttributes(Params::getParam('categoryId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }


      } else if($object == 'plugin-attributes' && $action == 'listSearchAttributes') {
        // &object=plugin-attributes&action=listSearchAttributes&categoryId=123
        if(function_exists('atr_call_after_install')) {
          $response = ModelATR::newInstance()->getSearchAttributes2(Params::getParam('categoryId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }


      } else if($object == 'plugin-attributes' && $action == 'getAttributeById') {
        // &object=plugin-attributes&action=getAttributeById&attributeId=123
        if(function_exists('atr_call_after_install')) {
          $response = ModelATR::newInstance()->getAttributeDetail(Params::getParam('attributeId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-attributes' && $action == 'getAttributeValues') {
        // &object=plugin-attributes&action=getAttributeValues&type2=&attributeId=123&parentId=&idMod=false
        if(function_exists('atr_call_after_install')) {
          $response = ModelATR::newInstance()->getAttributeValues(Params::getParam('type2'), Params::getParam('attributeId'), Params::getParam('parentId'), Params::getParam('idMod'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-attributes' && $action == 'getAllAttributeValues') {
        // &object=plugin-attributes&action=getAllAttributeValues&attributeId=123&parentId=
        if(function_exists('atr_call_after_install')) {
          $response = ModelATR::newInstance()->getAllAttributeValues(Params::getParam('attributeId'), Params::getParam('parentId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-attributes' && $action == 'getItemAttributes') {
        // &object=plugin-attributes&action=getItemAttributes&itemId=123
        if(function_exists('atr_call_after_install')) {
          $response = ModelATR::newInstance()->getItemAttributes(Params::getParam('itemId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-attributes' && $action == 'getItemAttributeValues') {
        // &object=plugin-attributes&action=getItemAttributeValues&itemId=123&attributeId=123
        if(function_exists('atr_call_after_install')) {
          $response = ModelATR::newInstance()->getItemAttributeValues(Params::getParam('itemId'), Params::getParam('attributeId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-attributes' && $action == 'getAllItemAttributeValues') {
        // &object=plugin-attributes&action=getAllItemAttributeValues&itemId=123
        if(function_exists('atr_call_after_install')) {
          $response = ModelATR::newInstance()->getAllItemAttributeValuesWithLocale(Params::getParam('itemId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      // Favorite items
      } else if($object == 'plugin-favorite_items' && $action == 'getListsByUserId') {
        // &object=plugin-favorite_items&action=getListsByUserId&userId=123
        if(function_exists('fi_call_after_install')) {
          $response = ModelFI::newInstance()->getAllFavoriteListsByUserId(Params::getParam('userId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-favorite_items' && $action == 'getItemsByListId') {
        // &object=plugin-favorite_items&action=getItemsByListId&listId=123
        if(function_exists('fi_call_after_install')) {
          $response = ModelFI::newInstance()->getFavoriteItemsByListId(Params::getParam('listId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-favorite_items' && $action == 'getAllByUserIdAndItemId') {
        // &object=plugin-favorite_items&action=getAllByUserIdAndItemId&itemId=123&userId=123
        if(function_exists('fi_call_after_install')) {
          $response = ModelFI::newInstance()->getFavoriteAll(Params::getParam('itemId'), Params::getParam('userId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }


      // Instant messenger
      } else if($object == 'plugin-instant_messenger' && $action == 'getThreadsByUserId') {
        // &object=plugin-instant_messenger&action=getThreadsByUserId&userId=123&limit=20&page=0
        if(function_exists('im_call_after_install')) {
          $response = ModelIM::newInstance()->getThreadsByUserId(Params::getParam('userId'), Params::getParam('limit'), Params::getParam('page'));
          $block = __LINE__;

        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-instant_messenger' && $action == 'getMessagesByThreadId') {
        // &object=plugin-instant_messenger&action=getMessagesByThreadId&threadId=123
        if(function_exists('im_call_after_install')) {
          $response = ModelIM::newInstance()->getMessagesByThreadId(Params::getParam('threadId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-instant_messenger' && $action == 'getBlocksByUserId') {
        // &object=plugin-instant_messenger&action=getBlocksByUserId&userId=123
        if(function_exists('im_call_after_install')) {
          $response = ModelIM::newInstance()->getUserBlocks(Params::getParam('threadId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-instant_messenger' && $action == 'checkBlockByUserIdAndEmail') {
        // &object=plugin-instant_messenger&action=checkBlockByUserIdAndEmail&userId=123&email=fd@do.com
        if(function_exists('im_call_after_install')) {
          $response = ModelIM::newInstance()->checkUserBlocks(Params::getParam('userId'), Params::getParam('email'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-instant_messenger' && $action == 'getThreadsByItemId') {
        // &object=plugin-instant_messenger&action=getThreadsByItemId&itemId=123&userId=123
        if(function_exists('im_call_after_install')) {
          $response = ModelIM::newInstance()->getThreadsByItemId(Params::getParam('itemId'), Params::getParam('userId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-instant_messenger' && $action == 'getThreadById') {
        // &object=plugin-instant_messenger&action=getThreadById&threadId=123
        if(function_exists('im_call_after_install')) {
          $response = ModelIM::newInstance()->getThreadById(Params::getParam('threadId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-instant_messenger' && $action == 'checkThreadIsRead') {
        // &object=plugin-instant_messenger&action=checkThreadIsRead&threadId=123&userId=123&secret=
        if(function_exists('im_call_after_install')) {
          $response = ModelIM::newInstance()->getThreadIsRead(Params::getParam('threadId'), Params::getParam('user_id'), Params::getParam('secret'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }




      // Osclass Pay
      } else if($object == 'plugin-osclass_pay' && $action == 'getPaymentsByUserId') {
        // &object=plugin-osclass_pay&action=getPaymentsByUserId&userId=123&history=1
        if(function_exists('osp_install')) {
          $response = ModelOSP::newInstance()->getPaymentsByUser(Params::getParam('userId'), Params::getParam('history'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-osclass_pay' && $action == 'getPaymentRecord') {
        // &object=plugin-osclass_pay&action=getPaymentRecord&type2=101&itemId=123&paid=-1
        if(function_exists('osp_install')) {
          $response = ModelOSP::newInstance()->getItem(Params::getParam('type2'), Params::getParam('itemId'), Params::getParam('paid'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }
        

      } else if($object == 'plugin-osclass_pay' && $action == 'checkFeeIsPaid') {
        // &object=plugin-osclass_pay&action=checkFeeIsPaid&type2=101&itemId=123
        if(function_exists('osp_install')) {
          $response = ModelOSP::newInstance()->feeIsPaid(Params::getParam('type2'), Params::getParam('itemId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-osclass_pay' && $action == 'feeExists') {
        // &object=plugin-osclass_pay&action=feeExists&type2=101&itemId=123&paid=-1
        if(function_exists('osp_install')) {
          $response = ModelOSP::newInstance()->feeExists(Params::getParam('type2'), Params::getParam('itemId'), Params::getParam('paid'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-osclass_pay' && $action == 'getUserWallet') {
        // &object=plugin-osclass_pay&action=getUserWallet&userId=123
        if(function_exists('osp_install')) {
          $response = ModelOSP::newInstance()->getWallet(Params::getParam('userId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-osclass_pay' && $action == 'getFee') {
        // &object=plugin-osclass_pay&action=getFee&type2=101&category=123&country=&region=&hours=
        if(function_exists('osp_install')) {
          $response = ModelOSP::newInstance()->getFee(Params::getParam('type2'), Params::getParam('category'), Params::getParam('country'), Params::getParam('region'), Params::getParam('hours'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-osclass_pay' && $action == 'getCategoryFee') {
        // &object=plugin-osclass_pay&action=getCategoryFee&type2=101&category=123&hours=
        if(function_exists('osp_install')) {
          $response = ModelOSP::newInstance()->getCategoryFee(Params::getParam('type2'), Params::getParam('category'), Params::getParam('hours'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-osclass_pay' && $action == 'getLocationFee') {
        // &object=plugin-osclass_pay&action=getLocationFee&type2=101&country=123&region=
        if(function_exists('osp_install')) {
          $response = ModelOSP::newInstance()->getLocationFee(Params::getParam('type2'), Params::getParam('country'), Params::getParam('region'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-osclass_pay' && $action == 'getPacks') {
        // &object=plugin-osclass_pay&action=getPacks
        if(function_exists('osp_install')) {
          $response = ModelOSP::newInstance()->getPacks();
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-osclass_pay' && $action == 'getPackById') {
        // &object=plugin-osclass_pay&action=getPackById&packId=123
        if(function_exists('osp_install')) {
          $response = ModelOSP::newInstance()->getPack(Params::getParam('packId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-osclass_pay' && $action == 'getGroups') {
        // &object=plugin-osclass_pay&action=getGroups
        if(function_exists('osp_install')) {
          $response = ModelOSP::newInstance()->getGroups();
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-osclass_pay' && $action == 'getGroupById') {
        // &object=plugin-osclass_pay&action=getGroupById&groupId=123
        if(function_exists('osp_install')) {
          $response = ModelOSP::newInstance()->getGroup(Params::getParam('groupId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-osclass_pay' && $action == 'getUserGroup') {
        // &object=plugin-osclass_pay&action=getUserGroup&userId=123
        if(function_exists('osp_install')) {
          $response = ModelOSP::newInstance()->getUserGroup(Params::getParam('userId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-osclass_pay' && $action == 'getCart') {
        // &object=plugin-osclass_pay&action=getCart&userId=123
        if(function_exists('osp_install')) {
          $response = ModelOSP::newInstance()->getCart(Params::getParam('userId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-osclass_pay' && $action == 'getItemData') {
        // &object=plugin-osclass_pay&action=getItemData&itemId=123
        if(function_exists('osp_install')) {
          $response = ModelOSP::newInstance()->getItemData(Params::getParam('itemId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }
        

      // SMS Notification & Verification
      } else if($object == 'plugin-sms' && $action == 'getVerification') {
        // &object=plugin-sms&action=getVerification&phoneNumber=123&email=abc@efg.com
        if(function_exists('sms_call_after_install')) {
          $response = ModelSMS::newInstance()->getVerification(Params::getParam('phoneNumber'), Params::getParam('email'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }


      } else {
        $status = 'ERROR';
        $message = __('Unrecognized parameters', 'rest');
        $block = 42;
      }


    } else if($type == 'insert') {
    
      // check insert permissions here
      if(!in_array('insert', rest_key_access($key))) {
        $status = 'ERROR';
        $message = sprintf(__('This key does not have %s access', 'rest'), __('insert', 'rest'));
        $block = 43;

      } else if($object == 'item' && $action == 'add') {
        // object=item&action=add&s_contact_email=a@b.com&i_price=5&sRegion=....
        // publish form is sent as POST to object=item&action=add
        require_once LIB_PATH . 'osclass/ItemActions.php';
        $item_actions = new ItemActions(true);
        $item_actions->prepareData(true);

        $response = $item_actions->add();

        if($response != 1 && $response != 2) {
          $status = 'ERROR';
          $message = __('There was problem adding listing', 'rest');
        }

        $block = 55;

      } else if($object == 'user' && $action == 'add') {
        // object=user&action=add&s_name=John&s_email=a@b.com....
        // registration form is sent as POST to object=item&action=add
        require_once LIB_PATH . 'osclass/UserActions.php';
        $model = new UserActions(false);
        $response = $model->add();

        if($response != 1 && $response != 2) {
          $status = 'ERROR';
          $message = __('There was problem adding user', 'rest');
        }

        $block = 56;



      // PLUGINS COMING HERE

      // Make offer
      } else if($object == 'plugin-make_offer' && $action == 'insertOffer') {
        // &object=plugin-make_offer&action=insertOffer&item_id=&quantity=&price=&status=&validate=&comment=&user_id=&user_name=&user_email=&user_phone=

        if(function_exists('mo_call_after_install')) {
          $response = ModelMO::newInstance()->insertOffer(Params::getParam('item_id'),Params::getParam('quantity'),Params::getParam('price'),Params::getParam('status'),Params::getParam('validate'),Params::getParam('comment'),Params::getParam('user_id'),Params::getParam('user_name'),Params::getParam('user_email'),Params::getParam('user_phone'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }


      // User Rating
      } else if($object == 'plugin-user_rating' && $action == 'insertRating') {
        // &object=plugin-user_rating&action=insertRating&user_id=&email=&from_user_id=&type2=&cat0=&cat1=&cat2=&cat3=&cat4=&cat5=&response=
        if(function_exists('ur_call_after_install')) {   
          $response = ModelUR::newInstance()->insertRating(Params::getParam('user_id'), Params::getParam('email'), Params::getParam('from_user_id'), Params::getParam('type'), Params::getParam('cat0'), Params::getParam('cat1'), Params::getParam('cat2'), Params::getParam('cat3'), Params::getParam('cat4'), Params::getParam('cat5'), Params::getParam('response'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }


      // Youtube Video
      } else if($object == 'plugin-youtube' && $action == 'insertVideo') {
        // &object=plugin-youtube&action=insertVideo&itemId=123&code=fda&url=https...
        if(function_exists('ytb_call_after_install')) {
          $response = ModelYTB::newInstance()->updateVideoByItemId(Params::getParam('itemId'), Params::getParam('code'), Params::getParam('url'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      // Favorite items
      } else if($object == 'plugin-favorite_items' && $action == 'insertList') {
        // &object=plugin-favorite_items&action=insertList&name=&current=1&userId=123&userLogged=1&notification=1
        if(function_exists('fi_call_after_install')) {
          $response = ModelFI::newInstance()->addFavoriteList(Params::getParam('name'), Params::getParam('current'), Params::getParam('userId'), Params::getParam('userLogged'), Params::getParam('notification'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-favorite_items' && $action == 'insertFavoriteItem') {
        // &object=plugin-favorite_items&action=insertFavoriteItem&listId=123&itemId=123
        if(function_exists('fi_call_after_install')) {
          $response = ModelFI::newInstance()->addFavoriteItem(Params::getParam('listId'), Params::getParam('itemId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      // Instant messenger
      } else if($object == 'plugin-instant_messenger' && $action == 'insertThread') {
        // &object=plugin-instant_messenger&action=insertThread&item_id=&from_user_id=&from_user_name=&from_user_email=&to_user_id=&to_user_name=&to_user_email=&title=&flag=
        if(function_exists('im_call_after_install')) {
          $response = ModelIM::newInstance()->createThread(Params::getParam('item_id'), Params::getParam('from_user_id'), Params::getParam('from_user_name'), Params::getParam('from_user_email'), Params::getParam('to_user_id'), Params::getParam('to_user_name'), Params::getParam('to_user_email'), Params::getParam('title'), Params::getParam('flag'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-instant_messenger' && $action == 'insertMessage') {
        // &object=plugin-instant_messenger&action=insertMessage&thread_id=&type2=&read=&message=&file=&email_sent=
        if(function_exists('im_call_after_install')) {
          $response = ModelIM::newInstance()->createThread(Params::getParam('thread_id'), Params::getParam('type2'), Params::getParam('read'), Params::getParam('message'), Params::getParam('file'), Params::getParam('email_sent'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-instant_messenger' && $action == 'insertBlock') {
        // &object=plugin-instant_messenger&action=insertBlock&user_id=&email=
        if(function_exists('im_call_after_install')) {
          $response = ModelIM::newInstance()->insertUserBlock(Params::getParam('user_id'), Params::getParam('email'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      // SMS Notification & Verification
      } else if($object == 'plugin-sms' && $action == 'createVerification') {
        // &object=plugin-sms&action=createVerification&phoneNumber=123&email=abc@efg.com&provider=twilio&token=1223&status=VERIFIED
        if(function_exists('sms_call_after_install')) {
          $arr = array(
            's_phone_number' => Params::getParam('phoneNumber'),
            's_email' => Params::getParam('email'),
            's_provider' => Params::getParam('provider'),
            's_token' => Params::getParam('token'),
            's_status' => Params::getParam('status')
          );
          
          $response = ModelSMS::newInstance()->createVerification($arr);
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }


      }      
    



    } else if($type == 'update') {
    
      // check update permissions here
      if(!in_array('update', rest_key_access($key))) {
        $status = 'ERROR';
        $message = sprintf(__('This key does not have %s access', 'rest'), __('update', 'rest'));
        $block = 44;

      } else if($object == 'item' && $action == 'markById') {
        // &object=item&action=markById&itemId=123&as=spam
        require_once LIB_PATH . 'osclass/ItemActions.php';
        $item_actions = new ItemActions(false);
        $response = $item_actions->mark(Params::getParam('itemId'), Params::getParam('as'));
        $block = 45;

      } else if($object == 'item' && $action == 'activateById') {
        // &object=item&action=activateById&itemId=123&secret=fajlfjdlak
        require_once LIB_PATH . 'osclass/ItemActions.php';
        $item_actions = new ItemActions(false);
        $response = $item_actions->activate(Params::getParam('itemId'), Params::getParam('secret'));
        $block = 46;

      } else if($object == 'item' && $action == 'edit') {
        // object=item&action=edit&itemId=123&s_contact_email=a@b.com&i_price=5&sRegion=....
        // publish form is sent as POST to object=item&action=edit, itemId is required
        require_once LIB_PATH . 'osclass/ItemActions.php';
        $item_actions = new ItemActions(false);
        $response = $item_actions->edit();
        $block = 57;

      } else if($object == 'user' && $action == 'edit') {
        // object=user&action=edit&s_name=John&s_email=a@b.com....
        // registration form is sent as POST to object=item&action=edit, userId is required
        require_once LIB_PATH . 'osclass/UserActions.php';
        $model = new UserActions(true);
        $response = $model->edit(Params::getParam('userId'));
        $block = 58;

      } else if($object == 'user' && $action == 'recover') {
        // object=user&action=recover&s_email=a@b.com
        require_once LIB_PATH . 'osclass/UserActions.php';
        $model = new UserActions(false);
        $response = $model->recover_password();
        $block = 59;



      // PLUGINS COMING HERE

      // Make offer
      } else if($object == 'plugin-make_offer' && $action == 'validateByOfferId') {
        // &object=plugin-make_offer&action=validateByOfferId&offerId=123
        if(function_exists('mo_call_after_install')) {
          $response = ModelMO::newInstance()->validateOfferById(Params::getParam('offerId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }


      // Favorite items
      } else if($object == 'plugin-favorite_items' && $action == 'updateList') {
        // &object=plugin-favorite_items&action=updateList&listId=123&name=&current=1&userId=123&userLogged=1&notification=1
        if(function_exists('fi_call_after_install')) {
          $response = ModelFI::newInstance()->updateFavoriteList(Params::getParam('listId'), Params::getParam('name'), Params::getParam('current'), Params::getParam('userId'), Params::getParam('userLogged'), Params::getParam('notification'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      // Instant messenger
      } else if($object == 'plugin-instant_messenger' && $action == 'updateThreadIsRead') {
        // &object=plugin-instant_messenger&action=updateThreadIsRead&threadId=&type2=
        if(function_exists('im_call_after_install')) {
          $response = ModelIM::newInstance()->updateMessagesRead(Params::getParam('threadId'), Params::getParam('type2'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      // Osclass Pay
      } else if($object == 'plugin-osclass_pay' && $action == 'payFee') {
        // &object=plugin-osclass_pay&action=payFee&type2=&item_id=&payment_id=&expire=&hours=&repeat=
        if(function_exists('osp_install')) {
          $response = ModelOSP::newInstance()->payFee(Params::getParam('type2'), Params::getParam('item_id'), Params::getParam('payment_id'), Params::getParam('expire'), Params::getParam('hours'), Params::getParam('repeat'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-osclass_pay' && $action == 'addWallet') {
        // &object=plugin-osclass_pay&action=addWallet&userId=&amount=
        if(function_exists('osp_install')) {
          $response = ModelOSP::newInstance()->addWallet(Params::getParam('userId'), Params::getParam('amount'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-osclass_pay' && $action == 'updateUserGroup') {
        // &object=plugin-osclass_pay&action=updateUserGroup&userId=&groupId=&expire=
        if(function_exists('osp_install')) {
          $response = ModelOSP::newInstance()->updateUserGroup(Params::getParam('userId'), Params::getParam('groupId'), Params::getParam('expire'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-osclass_pay' && $action == 'updateCart') {
        // &object=plugin-osclass_pay&action=updateCart&userId=&content=
        if(function_exists('osp_install')) {
          $response = ModelOSP::newInstance()->updateCart(Params::getParam('userId'), Params::getParam('content'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      // SMS Notification & Verification
      } else if($object == 'plugin-sms' && $action == 'updateVerification') {
        // &object=plugin-sms&action=updateVerification&phoneNumber=123&email=abc@efg.com&provider=twilio&token=1223&status=VERIFIED
        if(function_exists('sms_call_after_install')) {
          $arr = array();
          $arr['s_phone_number'] = Params::getParam('phoneNumber');
          if(Params::existParam('s_email')) { $arr['s_email'] = Params::getParam('email'); }
          if(Params::existParam('s_provider')) { $arr['s_provider'] = Params::getParam('provider'); }
          if(Params::existParam('s_token')) { $arr['s_token'] = Params::getParam('token'); }
          if(Params::existParam('s_status')) { $arr['s_status'] = Params::getParam('status'); }
          
          $response = ModelSMS::newInstance()->updateVerification($arr);
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }


      }   


    } else if($type == 'delete') {
    
      // check delete permissions here
      if(!in_array('delete', rest_key_access($key))) {
        $status = 'ERROR';
        $message = sprintf(__('This key does not have %s access', 'rest'), __('delete', 'rest'));
        $block = 47;

      } else if($object == 'item' && $action == 'byId') {
        // &object=item&action=byId&itemId=123
        $response = Item::newInstance()->deleteByPrimaryKey(Params::getParam('itemId'));
        $block = 48;

      } else if($object == 'item' && $action == 'resourcesById') {
        // &object=item&action=resourcesById&itemId=123
        require_once LIB_PATH . 'osclass/ItemActions.php';
        $item_actions = new ItemActions(false);
        $response = $item_actions->deleteResourcesFromHD(Params::getParam('itemId'));
        $block = 49;

      } else if($object == 'user' && $action == 'byId') {
        // &object=user&action=byId&userId=123
        $response = User::newInstance()->deleteUser(Params::getParam('userId'));
        $block = 59;


      
      // PLUGINS COMING HERE

      // Make offer
      } else if($object == 'plugin-make_offer' && $action == 'removeByOfferId') {
        // &object=plugin-make_offer&action=removeByOfferId&offerId=123
        if(function_exists('mo_call_after_install')) {
          $response = ModelMO::newInstance()->removeOfferById(Params::getParam('offerId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }


      // User Rating
      } else if($object == 'plugin-user_rating' && $action == 'removeByRatingId') {
        // &object=plugin-user_rating&action=removeByRatingId&ratingId=123
        if(function_exists('ur_call_after_install')) {
          $response = ModelUR::newInstance()->removeRatingById(Params::getParam('ratingId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }


      } else if($object == 'plugin-user_rating' && $action == 'removeByUserId') {
        // &object=plugin-user_rating&action=removeByUserId&userId=123
        if(function_exists('ur_call_after_install')) {
          $response = ModelUR::newInstance()->removeRatingByUser(Params::getParam('userId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      // Youtube Video
      } else if($object == 'plugin-youtube' && $action == 'removeByItemId') {
        // &object=plugin-youtube&action=removeByItemId&itemId=123
        if(function_exists('ytb_call_after_install')) {
          $response = ModelYTB::newInstance()->removeVideoByItemId(Params::getParam('itemId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      // Favorite items
      } else if($object == 'plugin-favorite_items' && $action == 'deleteListById') {
        // &object=plugin-favorite_items&action=deleteListById&listId=123
        if(function_exists('fi_call_after_install')) {
          $response = ModelFI::newInstance()->deleteFavoriteListById(Params::getParam('listId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }
      
      // Instant messenger
      } else if($object == 'plugin-instant_messenger' && $action == 'deleteMessageById') {
        // &object=plugin-instant_messenger&action=deleteMessageById&messageId=
        if(function_exists('im_call_after_install')) {
          $response = ModelIM::newInstance()->deleteMessageById(Params::getParam('messageId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-instant_messenger' && $action == 'deleteUserBlockById') {
        // &object=plugin-instant_messenger&action=deleteUserBlockById&blockId=
        if(function_exists('im_call_after_install')) {
          $response = ModelIM::newInstance()->removeUserBlock(Params::getParam('blockId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-instant_messenger' && $action == 'deleteThreadById') {
        // &object=plugin-instant_messenger&action=deleteThreadById&threadId=
        if(function_exists('im_call_after_install')) {
          $response = ModelIM::newInstance()->removeThreadById(Params::getParam('threadId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-instant_messenger' && $action == 'deleteMessagesByThreadId') {
        // &object=plugin-instant_messenger&action=deleteMessagesByThreadId&threadId=
        if(function_exists('im_call_after_install')) {
          $response = ModelIM::newInstance()->removeMessagesByThreadId(Params::getParam('threadId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      // Osclass Pay
      } else if($object == 'plugin-osclass_pay' && $action == 'deleteUserGroup') {
        // &object=plugin-osclass_pay&action=deleteUserGroup&userId=
        if(function_exists('osp_install')) {
          $response = ModelOSP::newInstance()->deleteUserGroup(Params::getParam('userId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }

      } else if($object == 'plugin-osclass_pay' && $action == 'deleteCart') {
        // &object=plugin-osclass_pay&action=deleteCart&userId=
        if(function_exists('osp_install')) {
          $response = ModelOSP::newInstance()->deleteCart(Params::getParam('userId'));
          $block = __LINE__;
        } else {
          $response = sprintf(__('Plugin not installed (%s)', 'rest'), __LINE__);
          $status = 'ERROR';
        }



      }

    }

  }


  $execution_time = round(floatval(microtime(true) - $time_start), 6);
  
  if($status == 'ERROR') {
    // KEEP MESSAGE AS IT IS
  } else if ($block == 0) {
    $status = 'ERROR';
    $message = __('Unrecognized parameters', 'rest');
  }


  $log = array(
    'fk_i_key_id' => @$key_row['pk_i_id'],
    's_type' => $type,
    's_action' => $object . ' > ' . $action . ' [#' . $block . ']',
    's_detail' => $message,
    'd_time' => $execution_time,
    's_status' => $status,
    'dt_datetime' => date('Y-m-d H:i:s')
  );

  ModelREST::newInstance()->insertLog($log);

  if($only_response == 1) {
    echo json_encode($response);
  } else {
    echo rest_response($status, $message, $execution_time, $block, $response);
  }

  exit;
?>