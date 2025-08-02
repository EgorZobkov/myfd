<?php
/*
 * Copyright 2018 osclass-pro.com and osclass-pro.ru
 *
 * You shall not distribute this theme and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */

    define('EVA_THEME_VERSION', '1.1.3');


    function eva_region_select($class='') {
        View::newInstance()->_exportVariableToView('list_regions', Search::newInstance()->listRegions('%%%%', '>=', 'region_name ASC') ) ;


            echo '<select id="sRegion" name="sRegion" class="'.$class.'">' ;
			echo '<option value="">'.__('Select a region...', 'eva').'</option>' ;
            while( osc_has_list_regions() ) {

                echo '<option value="' . osc_list_region_id() . '">' . osc_list_region_name() . '</option>' ;
            }
            echo '</select>' ;

        View::newInstance()->_erase('list_regions') ;
    }
	function eva_region_select_items($class='') {
            echo '<select id="sRegion" name="sRegion" class="'.$class.'">' ;
            echo '<option value="">'.__('Select a region...', 'eva').'</option>' ;
            while( osc_has_list_regions() ) {

                echo '<option value="' . osc_esc_html(osc_list_region_name()) . '">' . osc_list_region_name() . '</option>' ;
            }
            echo '</select>' ;
    }
	function eva_city_select($class='') {
        View::newInstance()->_exportVariableToView('list_cities', Search::newInstance()->listCities('%%%%', '>=', 'city_name ASC') ) ;

            echo '<select id="sRegion" name="sCity" class="'.$class.'">' ;
            echo '<option value="">'.__('Select a city...', 'eva').'</option>' ;
            while( osc_has_list_cities() ) {

                echo '<option value="' . osc_esc_html(osc_list_city_name()) . '">' . osc_list_city_name() . '</option>' ;
            }
            echo '</select>' ;
        View::newInstance()->_erase('list_cities') ;
    }
	function eva_city_select_items($class='') {
            echo '<select id="sRegion" name="sCity" class="'.$class.'">' ;
            echo '<option value="">'.__('Select a city...', 'eva').'</option>' ;
            while( osc_has_list_cities() ) {

                echo '<option value="' . osc_esc_html(osc_list_city_name()) . '">' . osc_list_city_name() . '</option>' ;
            }
            echo '</select>' ;
    }
	function eva_country_select($class='') {
        View::newInstance()->_exportVariableToView('list_countries', Search::newInstance()->listCountries('>=', 'country_name ASC') ) ;

            echo '<select id="sRegion" name="sCountry" class="'.$class.'">' ;
            echo '<option value="">'.__('Select a country...', 'eva').'</option>' ;
            while( osc_has_list_countries() ) {

                echo '<option value="' . osc_esc_html(osc_list_country_name()) . '">' . osc_list_country_name() . '</option>' ;
            }
            echo '</select>' ;
        View::newInstance()->_erase('list_countries') ;
    }

class eva_BodyClass {

    private static $instance;

    private $class;


    private function __construct() {
     $this->class = array();

    }

    public static function newInstance(){
        if (  !self::$instance instanceof self)   {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function add($class)   {

        $this->class[] = $class;

    }

    public function get()   {

        return $this->class;

    }

}
class eva_CategoryForm extends CategoryForm {
static public function eva_category_select($categories, $category, $default_item = null, $name = "sCategory")
        {
			$default = __('Category...','eva');
            echo '<select name="' . $name . '" id="' . $name . '" data-placeholder="' .$default . '">';
			
            if(isset($default_item)) {
                echo '<option value="">None</option>';
            }
            foreach($categories as $c) {
                echo '<option value="' . $c['pk_i_id'] . '"' . ( ($category['pk_i_id'] == $c['pk_i_id']) ? 'selected="selected"' : '' ) . '>' . $c['s_name'] . '</option>';
                if(isset($c['categories']) && is_array($c['categories'])) {
                    CategoryForm::subcategory_select($c['categories'], $category, $default_item, 1);
                }
            }
            echo '</select>';
        }
	}

	function eva_categories_select($name = 'sCategory', $category = null, $default = null) {

        if($default == null) $default = __('Category...','eva');

        eva_CategoryForm::eva_category_select(Category::newInstance()->toTree(), $category, $default, $name);

    }
	function eva_search_region_select($class="", $default_item = null, $name = "sRegion",$region=null){
			View::newInstance()->_exportVariableToView('list_regions', Search::newInstance()->listRegions('%%%%', '>=', 'region_name ASC') ) ;
			if($default_item==null) $default_item = __('Select a region...','eva');
			if( osc_count_list_regions() > 0 ) {
				echo '<select name="'.$name.'" id="'.$name.'" class="'.$class.' '.$name.'"  >' ;
				if(isset($default_item) && $default_item!='') {
					echo '<option value="">' . $default_item . '</option>';
				}
				while( osc_has_list_regions() ) {
					echo '<option value="' . osc_list_region_id() . '" ' . ( ($region == osc_list_region_name()) ? 'selected="selected"' : '' ) . '>' . osc_list_region_name() . '</option>' ;
				}
				echo '</select>' ;
			}
			View::newInstance()->_erase('list_regions') ;
		}



    if( !OC_ADMIN ) {
        if( !function_exists('add_close_button_action') ) {
            function add_close_button_action(){
                echo '<script type="text/javascript">';
                    echo '$(".flashmessage .ico-close").click(function(){';
                        echo '$(this).parent().hide();';
                    echo '});';
                echo '</script>';
            }
            osc_add_hook('footer', 'add_close_button_action');
        }
    }

    function theme_eva_actions_admin() {
        if( Params::getParam('file') == 'oc-content/themes/eva/admin/settings.php' ) {
            if( Params::getParam('donation') == 'successful' ) {
                osc_set_preference('donation', '1', 'eva');
                osc_reset_preferences();
            }
        }

        switch( Params::getParam('action_specific') ) {
            case('settings'):
                $footerLink  = Params::getParam('footer_link');
                $defaultLogo = Params::getParam('default_logo');
                osc_set_preference('keyword_placeholder', Params::getParam('keyword_placeholder'), 'eva');
                osc_set_preference('default_logo', ($defaultLogo ? '1' : '0'), 'eva');
				osc_set_preference('defaultShowAs@all', Params::getParam('defaultShowAs@all'), 'eva');
				osc_set_preference('main-search',      trim(Params::getParam('main-search', false, false, false)),              'eva');
				osc_set_preference('main-carousel',      trim(Params::getParam('main-carousel', false, false, false)),              'eva');
				osc_set_preference('main-carousel2',      trim(Params::getParam('main-carousel2', false, false, false)),              'eva');
                osc_set_preference('main-regcity',      trim(Params::getParam('main-regcity', false, false, false)),              'eva');
				osc_set_preference('item-icon',      trim(Params::getParam('item-icon', false, false, false)),              'eva');
				osc_set_preference('defaultShowAs@search', Params::getParam('defaultShowAs@all'));
				osc_set_preference('evaColor@all', Params::getParam('evaColor@all'), 'eva');
                osc_set_preference('inc-main',         trim(Params::getParam('inc-main', false, false, false)),                  'eva');
				osc_set_preference('sub',         trim(Params::getParam('sub', false, false, false)),                  'eva');
				osc_set_preference('subcategories',         trim(Params::getParam('subcategories', false, false, false)),                  'eva');
				osc_set_preference('categoriesmain',         trim(Params::getParam('categoriesmain', false, false, false)),                  'eva');
				osc_set_preference('main-map',  trim(Params::getParam('main-map', false, false, false)),       'eva');
				osc_set_preference('map-key',  trim(Params::getParam('map-key', false, false, false)),       'eva');
				osc_set_preference('map-key-geo',  trim(Params::getParam('map-key-geo', false, false, false)),       'eva');
				osc_set_preference('map_style',  trim(Params::getParam('map_style', false, false, false)),       'eva');

				if(is_numeric(Params::getParam('carousel_numads')))
					osc_set_preference('carousel_numads', Params::getParam('carousel_numads'), 'eva');
				if(is_numeric(Params::getParam('map_num_ads')))
					osc_set_preference('map_num_ads', Params::getParam('map_num_ads'), 'eva');

                osc_add_flash_ok_message(__('Theme settings updated correctly', 'eva'), 'admin');
                header('Location: ' . osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php')); exit;
            break;
            case('upload_logo'):
                $package = Params::getFiles('logo');
                if( $package['error'] == UPLOAD_ERR_OK ) {
                    if( move_uploaded_file($package['tmp_name'], WebThemes::newInstance()->getCurrentThemePath() . "img/logo.jpg" ) ) {
                        osc_add_flash_ok_message(__('The logo image has been uploaded correctly', 'eva'), 'admin');
                    } else {
                        osc_add_flash_error_message(__("An error has occurred, please try again", 'eva'), 'admin');
                    }
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again", 'eva'), 'admin');
                }
                header('Location: ' . osc_admin_render_theme_url('oc-content/themes/eva/admin/header.php')); exit;
            break;
            case('remove'):
                if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "img/logo.jpg" ) ) {
                    @unlink( WebThemes::newInstance()->getCurrentThemePath() . "img/logo.jpg" );
                    osc_add_flash_ok_message(__('The logo image has been removed', 'eva'), 'admin');
                } else {
                    osc_add_flash_error_message(__("Image not found", 'eva'), 'admin');
                }
                header('Location: ' . osc_admin_render_theme_url('oc-content/themes/eva/admin/header.php')); exit;
            break;
			case('ads_eva'):
                osc_set_preference('main-evarevo-top',         trim(Params::getParam('main-evarevo-top', false, false, false)),                  'eva');
                osc_set_preference('main-evarevo-under',       trim(Params::getParam('main-evarevo-under', false, false, false)),                'eva');
                osc_set_preference('main-evarevo-middle',       trim(Params::getParam('main-evarevo-middle', false, false, false)),                'eva');
                osc_set_preference('search-evarevo-top',     trim(Params::getParam('search-evarevo-top', false, false, false)),          'eva');
                osc_set_preference('search-evarevo_middle',  trim(Params::getParam('search-evarevo_middle', false, false, false)),       'eva');
				osc_set_preference('search-evarevo_under',  trim(Params::getParam('search-evarevo_under', false, false, false)),       'eva');
				osc_set_preference('item-evarevo_desc',  trim(Params::getParam('item-evarevo_desc', false, false, false)),       'eva');
				osc_set_preference('item-evarevo_desc2',  trim(Params::getParam('item-evarevo_desc2', false, false, false)),       'eva');
				osc_set_preference('item-evarevo_image',  trim(Params::getParam('item-evarevo_image', false, false, false)),       'eva');
				osc_set_preference('cat-evarevo',         trim(Params::getParam('cat-evarevo', false, false, false)),                  'eva');
				osc_set_preference('side-evarevo',         trim(Params::getParam('side-evarevo', false, false, false)),                  'eva');
				osc_set_preference('search-middle',  trim(Params::getParam('search-middle', false, false, false)),       'eva');
				osc_set_preference('main-middle',  trim(Params::getParam('main-middle', false, false, false)),       'eva');
                 osc_add_flash_ok_message(__("Settings updated correctly", 'eva'), 'admin');
				osc_redirect_to(osc_admin_render_theme_url( 'oc-content/themes/eva/admin/settings.php#ads' ));
			break;
			case('text_eva'):
				osc_set_preference('main-premium-text',  trim(Params::getParam('main-premium-text', false, false, false)),       'eva');
				osc_set_preference('main-bottom-text',  trim(Params::getParam('main-bottom-text', false, false, false)),       'eva');
				osc_set_preference('categories-text',         trim(Params::getParam('categories-text', false, false, false)),                  'eva');
				osc_set_preference('main-premiumh2-undertext',  trim(Params::getParam('main-premiumh2-undertext', false, false, false)),       'eva');
				osc_set_preference('main-premium-1text',  trim(Params::getParam('main-premium-1text', false, false, false)),       'eva');
                 osc_add_flash_ok_message(__("Settings updated correctly", 'eva'), 'admin');
				osc_redirect_to(osc_admin_render_theme_url( 'oc-content/themes/eva/admin/settings.php#text' ));
			break;
			case('color_eva'):
				osc_set_preference('primary_color',  trim(Params::getParam('primary_color', false, false, false)),       'eva');
				osc_set_preference('hover_color',  trim(Params::getParam('hover_color', false, false, false)),       'eva');
				osc_set_preference('button_color',  trim(Params::getParam('button_color', false, false, false)),       'eva');
				osc_set_preference('publish_color',  trim(Params::getParam('publish_color', false, false, false)),       'eva');
				osc_set_preference('publishhover_color',  trim(Params::getParam('publishhover_color', false, false, false)),       'eva');
                 osc_add_flash_ok_message(__("Settings updated correctly", 'eva'), 'admin');
				osc_redirect_to(osc_admin_render_theme_url( 'oc-content/themes/eva/admin/settings.php#color' ));
			break;
			 case('social_eva'):
			     osc_set_preference('footer-logo',         trim(Params::getParam('footer-logo', false, false, false)),                  'eva');
				 osc_set_preference('footer-categories',         trim(Params::getParam('footer-categories', false, false, false)),                  'eva');
				 osc_set_preference('contact-copy',         trim(Params::getParam('contact-copy', false, false, false)),                  'eva');
                 osc_set_preference('vk-evarevo',         trim(Params::getParam('vk-evarevo', false, false, false)),                  'eva');
                 osc_set_preference('odnoklassniki-evarevo',         trim(Params::getParam('odnoklassniki-evarevo', false, false, false)),                  'eva');
			 osc_set_preference('facebook-evarevo',         trim(Params::getParam('facebook-evarevo', false, false, false)),                  'eva');
				osc_set_preference('twitter-evarevo',         trim(Params::getParam('twitter-evarevo', false, false, false)),                  'eva');
				osc_set_preference('google-evarevo',         trim(Params::getParam('google-evarevo', false, false, false)),                  'eva');
                 osc_set_preference('in-evarevo',         trim(Params::getParam('in-evarevo', false, false, false)),                  'eva');
                 osc_set_preference('pinterest-evarevo',         trim(Params::getParam('pinterest-evarevo', false, false, false)),                  'eva');
		       osc_add_flash_ok_message(__("Settings updated correctly", 'eva'), 'admin');
				osc_redirect_to(osc_admin_render_theme_url( 'oc-content/themes/eva/admin/settings.php#social' ));
			break;
			case('items_eva'):
			    osc_set_preference('item-post',         trim(Params::getParam('item-post', false, false, false)),                  'eva');
				osc_set_preference('item-post-loc',         trim(Params::getParam('item-post-loc', false, false, false)),                  'eva');
				osc_set_preference('custom-fileds',         trim(Params::getParam('custom-fileds', false, false, false)),                  'eva');
				osc_set_preference('mark-as',         trim(Params::getParam('mark-as', false, false, false)),                  'eva');
				osc_set_preference('gallery',         trim(Params::getParam('gallery', false, false, false)),                  'eva');
				osc_set_preference('useful',         trim(Params::getParam('useful', false, false, false)),                  'eva');
				osc_set_preference('item-map',         trim(Params::getParam('item-map', false, false, false)),                  'eva');
				osc_set_preference('hide_digits',         trim(Params::getParam('hide_digits', false, false, false)),                  'eva');			
		        osc_add_flash_ok_message(__("Settings updated correctly", 'eva'), 'admin');
				osc_redirect_to(osc_admin_render_theme_url( 'oc-content/themes/eva/admin/settings.php#items' ));
			break;
			case('related_eva'):
		        osc_set_preference('related_eva_ra_numads'    	, '4','eva','INTEGER');
	            osc_set_preference('related_eva_ra_category'   , '1','eva','INTEGER');
				osc_add_flash_ok_message(__("Ads management updated correctly", 'eva'), 'admin');
				osc_redirect_to(osc_admin_render_theme_url( 'oc-content/themes/eva/admin/settings.php#related' ));
			break;
			case('welcome_eva'):
				osc_set_preference('mainh1-evarevo',         trim(Params::getParam('mainh1-evarevo', false, false, false)),                  'eva');
				osc_set_preference('maintext-evarevo',         trim(Params::getParam('maintext-evarevo', false, false, false)),                  'eva');
				osc_set_preference('main-block-middle',         trim(Params::getParam('main-block-middle', false, false, false)),                  'eva');
		        osc_add_flash_ok_message(__("Settings updated correctly", 'eva'), 'admin');
				osc_redirect_to(osc_admin_render_theme_url( 'oc-content/themes/eva/admin/settings.php#welcome' ));
			break;
			case('category_icons'):
					$catID = Params::getParam('category_id');
					$package = Params::getFiles('category_icon');
                if( $package['error'] == UPLOAD_ERR_OK ) {
                    $img = ImageResizer::fromFile($package['tmp_name']);
                    $path = osc_base_path().'oc-content/themes/eva/img/'.$catID.'.png' ;
                    $img->saveToFile($path);
                    osc_add_flash_ok_message(__('The icon has been uploaded correctly', 'eva'), 'admin');
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again", 'eva'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php#icons'));
            break;
			case('remove-icon'):
				$catID = Params::getParam('category_id');
                $path = osc_base_path().'oc-content/themes/eva/img/'.$catID.'.png' ;
                if(file_exists( $path ) ) {
                    @unlink( $path );
                    osc_add_flash_ok_message(__('The icon has been removed', 'eva'), 'admin');
                } else {
                    osc_add_flash_error_message(__("Image not found", 'eva'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php#icons'));
            break;
				case('upload_main_image');
					$mainimage = Params::getFiles('main_image');
                if( $mainimage['error'] == UPLOAD_ERR_OK ) {
                    $img = ImageResizer::fromFile($mainimage['tmp_name']);
                    $path = osc_base_path().'oc-content/themes/eva/img/main/'.$mainimage['name'] ;
                    $img->saveToFile($path);
                    osc_add_flash_ok_message(__('The image has been uploaded correctly', 'eva'), 'admin');
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again", 'eva'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php#welcome'));
			break;
			case('remove_main_image');
			$imgname = Params::getParam('main_name');
				$path = osc_base_path().'oc-content/themes/eva/img/main/'.$imgname ;
                if(file_exists( $path ) ) {
                    @unlink( $path );
                    osc_add_flash_ok_message(__('The image has been removed', 'eva'), 'admin');
                } else {
                    osc_add_flash_error_message(__("Image not found", 'eva'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php#welcome'));
			break;
			case('upload_main_image2');
					$mainimage = Params::getFiles('main_image2');
                if( $mainimage['error'] == UPLOAD_ERR_OK ) {
                    $img = ImageResizer::fromFile($mainimage['tmp_name']);
                    $path = osc_base_path().'oc-content/themes/eva/img/main2/'.$mainimage['name'] ;
                    $img->saveToFile($path);
                    osc_add_flash_ok_message(__('The image has been uploaded correctly', 'eva'), 'admin');
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again", 'eva'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php#welcome'));
			break;
			case('remove_main_image2');
			$imgname2 = Params::getParam('main_name2');
				$path2 = osc_base_path().'oc-content/themes/eva/img/main2/'.$imgname2 ;
                if(file_exists( $path2 ) ) {
                    @unlink( $path2 );
                    osc_add_flash_ok_message(__('The image has been removed', 'eva'), 'admin');
                } else {
                    osc_add_flash_error_message(__("Image not found", 'eva'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php#welcome'));
			break;
				case('upload_search_image');
					$mainimage = Params::getFiles('search_image');
                if( $mainimage['error'] == UPLOAD_ERR_OK ) {
                    $img = ImageResizer::fromFile($mainimage['tmp_name']);
                    $path = osc_base_path().'oc-content/themes/eva/img/search/'.$mainimage['name'] ;
                    $img->saveToFile($path);
                    osc_add_flash_ok_message(__('The image has been uploaded correctly', 'eva'), 'admin');
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again", 'eva'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php#search'));
			break;
			case('remove_search_image');
			$imgname = Params::getParam('search_name');
				$path = osc_base_path().'oc-content/themes/eva/img/search/'.$imgname ;
                if(file_exists( $path ) ) {
                    @unlink( $path );
                    osc_add_flash_ok_message(__('The image has been removed', 'eva'), 'admin');
                } else {
                    osc_add_flash_error_message(__("Image not found", 'eva'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php#search'));
			break;
			case('main_image_color');
			osc_set_preference('color-mainimage',Params::getParam('color-mainimage'),'eva');
			osc_add_flash_ok_message(__('Background color updated', 'eva'), 'admin');
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php#welcome'));
			break;
			case('search_map');
			osc_set_preference('search-map',  trim(Params::getParam('search-map', false, false, false)),       'eva');
			osc_set_preference('search-image',  trim(Params::getParam('search-image', false, false, false)),       'eva');
			osc_set_preference('adsearch-city',         trim(Params::getParam('adsearch-city', false, false, false)),                  'eva');
			osc_add_flash_ok_message(__('Settings updated correctly', 'eva'), 'admin');
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php#search'));
			break;
			case('upload_favicon'):
                $package = Params::getFiles('favicon');
                if( $package['error'] == UPLOAD_ERR_OK ) {
                    $img = ImageResizer::fromFile($package['tmp_name']);
                    $ext = $img->getExt();
                    $logo_name     = 'favicon';
                    $logo_name    .= '.'.$ext;
                    $path = osc_uploads_path() . $logo_name ;
                    $img->saveToFile($path);

                    osc_set_preference('favicon', $logo_name, 'eva');

                    osc_add_flash_ok_message(__('The favicon image has been uploaded correctly', 'eva'), 'admin');
                } else {
                    osc_add_flash_error_message(__("An error has occurred, please try again", 'eva'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php#favicon'));
            break;
			case('remove_favicon'):
                $logo = osc_get_preference('favicon','eva');
                $path = osc_uploads_path() . $logo ;
                if(file_exists( $path ) ) {
                    @unlink( $path );
                    osc_delete_preference('favicon','eva');
                    osc_reset_preferences();
                    osc_add_flash_ok_message(__('The favicon image has been removed', 'eva'), 'admin');
                } else {
                    osc_add_flash_error_message(__("Image not found", 'eva'), 'admin');
                }
                osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php#favicon'));
            break;
			
		}
    }
	osc_add_hook('init_admin', 'theme_eva_actions_admin');

	if( !function_exists('eva_show_as') ){
        function eva_show_as(){

            $p_sShowAs    = Params::getParam('sShowAs');
            $aValidShowAsValues = array('list', 'gallery');
            if (!in_array($p_sShowAs, $aValidShowAsValues)) {
                $p_sShowAs = eva_default_show_as();
            }

            return $p_sShowAs;
        }
    }

	if( !function_exists('eva_catshow_as') ){
        function eva_catshow_as(){

            $p_sShowAs    = Params::getParam('inc-main');
            $aValidShowAsValues = array('inc.main.category', 'inc.main.subcategory');
            if (!in_array($p_sShowAs, $aValidShowAsValues)) {
                $p_sShowAs = eva_category_main();
            }

            return $p_sShowAs;
        }
    }
	if( !function_exists('eva_regcity_as') ){
        function eva_regcity_as(){

            $p_sShowAs    = Params::getParam('main-search');
            $aValidShowAsValues = array('inc.search', 'inc.search.city', 'inc.search.hide');
            if (!in_array($p_sShowAs, $aValidShowAsValues)) {
                $p_sShowAs = eva_regioncity_main();
            }

            return $p_sShowAs;
        }
    }
    if( !function_exists('eva_default_show_as') ){
        function eva_default_show_as(){
            return getPreference('defaultShowAs@all','eva');
        }
    }
	if( !function_exists('eva_color') ){
        function eva_color(){
            return getPreference('evaColor@all','eva');
        }
    }
	if( !function_exists('eva_category_main') ){
        function eva_category_main(){
            return getPreference('inc-main','eva');
        }
    }
	if( !function_exists('eva_item_icon') ){
        function eva_item_icon(){
            return getPreference('item-icon','eva');
        }
    }
	if( !function_exists('eva_mark-as') ){
        function eva_mark(){
            return getPreference('mark-as','eva');
        }
    }
	if( !function_exists('eva_sub') ){
        function eva_sub(){
            return getPreference('sub','eva');
        }
    }
	if( !function_exists('eva_useful') ){
        function eva_useful(){
            return getPreference('useful','eva');
        }
    }
	if( !function_exists('eva_regioncity_main') ){
        function eva_regioncity_main(){
            return getPreference('main-search','eva');
        }
    }
	if( !function_exists('eva_categories_text') ){
        function eva_categories_text(){
            return getPreference('categories-text','eva');
        }
    }

	if( !function_exists('eva_main_carousel') ){
        function eva_main_carousel(){

            $p_sShowAs    = Params::getParam('main-carousel');
            $aValidShowAsValues = array('premium', 'popular', 'hide');
            if (!in_array($p_sShowAs, $aValidShowAsValues)) {
                $p_sShowAs = eva_main_carousel_as();
            }

            return $p_sShowAs;
        }
    }
	if( !function_exists('eva_main_carousel_as') ){
        function eva_main_carousel_as(){
            return getPreference('main-carousel','eva');
        }
    }


	if( !function_exists('get_categoriesHierarchy') ) {
        function get_categoriesHierarchy( ) {
            $location = Rewrite::newInstance()->get_location() ;
            $section  = Rewrite::newInstance()->get_section() ;

            if ( $location != 'search' ) {
                return false ;
            }

            $category_id = osc_search_category_id() ;

            if(count($category_id) > 1  || count($category_id) == 0) {
                return false;
            }

            $category_id = (int) $category_id[0] ;

            $categoriesHierarchy = Category::newInstance()->hierarchy($category_id) ;

            foreach($categoriesHierarchy as &$category) {
                $category['url'] = get_category_url($category) ;
            }

            return $categoriesHierarchy ;
         }
     }

     if( !function_exists('get_subcategories') ) {
         function get_subcategories( ) {
             $location = Rewrite::newInstance()->get_location() ;
             $section  = Rewrite::newInstance()->get_section() ;

             if ( $location != 'search' ) {
                 return false ;
             }

             $category_id = osc_search_category_id() ;
             if(count($category_id) > 1 ) {
                 return false ;
             }

             $category_id = (int) $category_id[0] ;

             $subCategories = Category::newInstance()->findSubcategories($category_id) ;

             foreach($subCategories as &$category) {
                 $category['url'] = get_category_url($category) ;
             }

             return $subCategories ;
         }
     }

     if ( !function_exists('get_category_url') ) {
         function get_category_url( $category ) {
             $path = '';
             if ( osc_rewrite_enabled() ) {
                if ($category != '') {
                    $category = Category::newInstance()->hierarchy($category['pk_i_id']) ;
                    $sanitized_category = "" ;
                    for ($i = count($category); $i > 0; $i--) {
                        $sanitized_category .= $category[$i - 1]['s_slug'] . '/' ;
                    }
                    $path = osc_base_url() . $sanitized_category ;
                }
            } else {
                $path = sprintf( osc_base_url(true) . '?page=search&sCategory=%d', $category['pk_i_id'] ) ;
            }

            return $path;
         }
     }

     if ( !function_exists('get_category_num_items') ) {
         function get_category_num_items( $category ) {
            $category_stats = CategoryStats::newInstance()->countItemsFromCategory($category['pk_i_id']) ;

            if( empty($category_stats) ) {
                return 0 ;
            }

            return $category_stats;
         }
     }
	 if( !function_exists('eva_item_title') ) {
        function eva_item_title() {
            $title = osc_item_title();
            foreach( osc_get_locales() as $locale ) {
                if( Session::newInstance()->_getForm('title') != "" ) {
                    $title_ = Session::newInstance()->_getForm('title');
                    if( @$title_[$locale['pk_c_code']] != "" ){
                        $title = $title_[$locale['pk_c_code']];
                    }
                }
            }
            return $title;
        }
    }
    if( !function_exists('eva_item_description') ) {
        function eva_item_description() {
            $description = osc_item_description();
            foreach( osc_get_locales() as $locale ) {
                if( Session::newInstance()->_getForm('description') != "" ) {
                    $description_ = Session::newInstance()->_getForm('description');
                    if( @$description_[$locale['pk_c_code']] != "" ){
                        $description = $description_[$locale['pk_c_code']];
                    }
                }
            }
            return $description;
        }
    }

    if( !function_exists('logo_header') ) {
        function logo_header() {
            $html = '<img border="0" alt="' . osc_esc_html(osc_page_title()) . '" src="' . osc_current_web_theme_url('img/logo.jpg') . '" />';
            if( file_exists( WebThemes::newInstance()->getCurrentThemePath() . "img/logo.jpg" ) ) {
                return $html;
            } else if( osc_get_preference('default_logo', 'eva') && (file_exists( WebThemes::newInstance()->getCurrentThemePath() . "img/default-logo.jpg")) ) {
                return '<img border="0" alt="' . osc_esc_html(osc_page_title()) . '" src="' . osc_current_web_theme_url('img/default-logo.jpg') . '" />';
            } else {
                return osc_page_title();
            }
        }
    }
	if( !function_exists('eva_parentcategory_id') ){
        function eva_parentcategory_id($categoryp){
            $apCategory = osc_get_category('id',$categoryp);
            $aparentCategory = osc_get_category('id', $apCategory['fk_i_parent_id']);
           return $aparentCategory['pk_i_id'] ;
        }
    }

if( !function_exists('eva_parentcategory_name') ){
    function eva_parentcategory_name($categoryp){
        $apCategory = osc_get_category('id', $categoryp);
        $aparentCategory = osc_get_category('id', $apCategory['fk_i_parent_id']);
        return $aparentCategory['s_name'] ;
    }
}
if( !function_exists('eva_parentcategory_url') ){
    function eva_parentcategory_url($categoryp){
		     $apCategory = osc_get_category('id', $categoryp);
            $aparentCategory = osc_get_category('id', $apCategory['fk_i_parent_id']);
		     if ( osc_rewrite_enabled() ) {
                if ($aparentCategory != '') {
                    $aparentCategory = Category::newInstance()->hierarchy($aparentCategory['pk_i_id']) ;
                    $sanitized_category = "" ;
                    for ($i = count($aparentCategory); $i > 0; $i--) {
                        $sanitized_category .= $aparentCategory[$i - 1]['s_slug'] . '/' ;
                    }
                    $path = osc_base_url() . $sanitized_category ;
                }
            } else {
                $path = sprintf( osc_base_url(true) . '?page=search&sCategory=%d', $aparentCategory['pk_i_id'] ) ;
            }
			return $path ;
    }
}
// USER MENU FIX
function eva_user_menu_fix() {
  $user = User::newInstance()->findByPrimaryKey( osc_logged_user_id() );
  View::newInstance()->_exportVariableToView('user', $user);
}

osc_add_hook('header', 'eva_user_menu_fix');

  if (!function_exists('get_user_menu')) {

    function get_user_menu() {
        $options = array();
        // $options[] = array(
		// 'name' => __('Public Profile'), 
		// 'url' => osc_user_public_profile_url(osc_logged_user_id()),
		// 'class' => 'opt_publicprofile');
        $options[] = array(
            'name' => __('Account'),
            'url' => osc_user_list_items_url(),
            'class' => 'opt_items'
        );
        // $options[] = array(
        //     'name' => __('Alerts'),
        //     'url' => osc_user_alerts_url(),
        //     'class' => 'opt_alerts'
        // );
        $options[] = array(
            'name' => __('Listings'),
            'url' => osc_user_profile_url(),
            'class' => 'opt_account'
        );
        $options[] = array(
            'name' => __('Logout'),
            'url' => osc_user_logout_url(),
            'class' => 'opt_logout'
        );
        return $options;
    }

}
    // install update options
    if( !function_exists('eva_theme_install') ) {
        function eva_theme_install() {
            osc_set_preference('keyword_placeholder', __('ie. car', 'eva'), 'eva');
            osc_set_preference('version', '1.1.3', 'eva');
            osc_set_preference('footer_link', true, 'eva');
            osc_set_preference('donation', '0', 'eva');
            osc_set_preference('default_logo', '1', 'eva');
			osc_set_preference('defaultShowAs@all', 'gallery', 'eva');
			osc_set_preference('evaColor@all', 'vivid-blue', 'eva');
			osc_set_preference('related_eva_ra_numads', '5','eva');
			osc_set_preference('carousel_numads', '8','eva');
			osc_set_preference('map_num_ads', '10','eva');
			osc_set_preference('inc-main', 'inc.main.subcategory', 'eva');
			osc_set_preference('main-search', 'inc.searchcitybyreg', 'eva');
			osc_set_preference('main-carousel', 'premium', 'eva');
			osc_set_preference('main-carousel2', 'popular', 'eva');
			osc_set_preference('categories-text', 'top', 'eva');
			osc_set_preference('main-regcity', 'hide', 'eva');
			osc_set_preference('primary_color', 'E30556', 'eva');
			osc_set_preference('button_color', 'E30556', 'eva');
			osc_set_preference('hover_color', '565D62', 'eva');
			osc_set_preference('publish_color', 'E30556', 'eva');
			osc_set_preference('publishhover_color', '565D62', 'eva');
			osc_set_preference('item-post', 'default', 'eva');
			osc_set_preference('item-post-loc', 'enable', 'eva');
			osc_set_preference('adsearch-city', 'enable', 'eva');
			osc_set_preference('item-icon', 'enable', 'eva');
			osc_set_preference('map-eva', 'enable', 'eva');
			osc_set_preference('map-style', 'eva', 'eva');
			osc_set_preference('mark-as', 'enable', 'eva');
			osc_set_preference('categoriesmain', 'enable', 'eva');
			osc_set_preference('sub', 'enable', 'eva');
			osc_set_preference('useful', 'enable', 'eva');
			osc_set_preference('custom-fileds', 'bottom', 'eva');
			osc_set_preference('search-middle', '6','eva');
			osc_set_preference('main-middle', '6','eva');
            osc_set_preference('vk-evarevo', 'https://vk.com','eva');
            osc_set_preference('odnoklassniki-evarevo', 'https://ok.ru','eva');
			osc_set_preference('facebook-evarevo', 'https://www.facebook.com/','eva');
			osc_set_preference('twitter-evarevo', 'https://twitter.com/','eva');
			osc_set_preference('google-evarevo', 'https://plus.google.com/','eva');
            osc_set_preference('in-evarevo', 'https://linkedin.com','eva');
            osc_set_preference('pinterest-evarevo', 'https://www.pinterest.com','eva');
			osc_set_preference('mainh1-evarevo', 'eva classifieds','eva');
			osc_set_preference('maintext-evarevo', 'Easy to buy, easy to sell','eva');
			osc_set_preference('main-premiumh2-undertext', 'Everything You Need in One Place','eva');
			osc_set_preference('main-premium-1text', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis dolor arcu, blandit et erat et, sollicitudin molestie justo. Pellentesque id eros eleifend, euismod massa sit amet, viverra augue. In eu enim bibendum, sodales justo quis, condimentum tellus. Ut magna felis, convallis blandit maximus vitae, auctor eget leo. Sed pharetra sollicitudin elit, ac blandit justo vulputate eu. Fusce eu mattis nisl. Donec nec finibus velit. Ut id urna eget est bibendum dapibus quis ac lorem. Phasellus at augue diam. Cras dictum ac orci in scelerisque. Duis volutpat imperdiet quam, eu maximus diam malesuada et. Sed ac velit sit amet massa sollicitudin dapibus. Etiam euismod lectus faucibus, dictum orci et, accumsan nisl. Fusce semper arcu ac molestie tincidunt. Mauris et tortor nibh. Etiam molestie a purus vel luctus. Praesent posuere ligula ut leo blandit sagittis.','eva');
			osc_set_preference('subcategories', 'enable', 'eva');
			osc_set_preference('color-mainimage', 'ffffff', 'eva');
			osc_set_preference('footer-logo', 'enable', 'eva');
			osc_set_preference('footer-categories', 'enable', 'eva');
			osc_set_preference('contact-copy', 'All rights reserved. Your Company Name', 'eva');
			osc_set_preference('main-map', 'disable', 'eva');
			osc_set_preference('search-map', 'disable', 'eva');
			osc_set_preference('item-map', 'disable', 'eva');
			osc_set_preference('gallery', 'swiper', 'eva');
			osc_set_preference('search-image', 'disable', 'eva');
			osc_set_preference('main-block-middle', 'enable', 'eva');
			osc_set_preference('hide_digits', '1', 'eva');
            osc_reset_preferences();
			if (!is_dir(osc_base_path().'oc-content/themes/eva/img/main')) {

    			@mkdir(osc_base_path().'oc-content/themes/eva/img/main', 0755, true);

			}
        }
    }

    if(!function_exists('check_install_eva_theme')) {
        function check_install_eva_theme() {
            $current_version = osc_get_preference('version', 'eva');
            //check if current version is installed or need an update
            if( !$current_version ) {
                eva_theme_install();
            }
        }
    }

   	if( !function_exists('eva_color') ){
        function eva_color(){
            return getPreference('evaColor@all','eva');
        }
    }
    check_install_eva_theme();
	/* ads  SEARCH */
    function search_ads_listing_top_evarevo() {
        if(osc_get_preference('search-evarevo-top', 'eva')!='') {
            echo '<div class="search_top">' . PHP_EOL;
            echo osc_get_preference('search-evarevo-top', 'eva');
            echo '</div>' . PHP_EOL;
        }
    }
    osc_add_hook('search_top', 'search_ads_listing_top_evarevo');

	function search_ads_listing_under_evarevo() {
        if(osc_get_preference('search-evarevo_under', 'eva')!='') {
            echo '<div class="clear"></div>' . PHP_EOL;
            echo '<div class="search_under">' . PHP_EOL;
            echo osc_get_preference('search-evarevo_under', 'eva');
            echo '</div>' . PHP_EOL;
        }
    }
    osc_add_hook('search_under', 'search_ads_listing_under_evarevo');

    function main_ads_listing_medium_evarevo() {
        if(osc_get_preference('main-evarevo-middle', 'eva')!='') {
            echo '<div class="clear"></div>' . PHP_EOL;
            echo '<div class="middle_main">' . PHP_EOL;
            echo osc_get_preference('main-evarevo-middle', 'eva');
            echo '</div>' . PHP_EOL;
        }
    }
    osc_add_hook('main_middle', 'main_ads_listing_medium_evarevo');
	
	function eva_style(){
    $primarycolor = osc_get_preference('primary_color', 'eva');
	$hovercolor = osc_get_preference('hover_color', 'eva');
	$publishcolor = osc_get_preference('publish_color', 'eva');
	$publishhovercolor = osc_get_preference('publishhover_color', 'eva');
    echo '<style type="text/css">button,input.submit,#btn_subscribe,.searchPaginationSelected,.tag-link.active,.searchbutton,.flashmessage-warning,.flashmessage-info, .flashmessage-ok,.ui-slider-handle,.qq-upload-button,.edit-link:hover,.del-link:hover,#select-country__wrap .dropdown-wrapper,.btn-blue:hover,.lang-list__ul,.submit-search,.item__cat,.about-item__ico-wrp span,.item-inline__cat,.btn-pink,.ui-slider-horizontal .ui-widget-header,.item__favourites,.select2-container--default .select2-results__option--highlighted[aria-selected],.category-inline-item:hover {background-color:#'. $primarycolor .'!important;}a:hover,.btn2,.breadcrumb a,.load-img-item span a,.profile-demo a,.options-form a,.modal a,.publish a,.item__date i,.item__price i,.item-inline__place i,.item-author__adress i,.item-tab-control a.active,.item-tab-control a:hover,.sort-btn:hover,.sort-btn.active,.sort-btn.active:hover,.header-page--ins nav a:hover,.header-page--ins nav a.active,.tag-link:hover{color:#'. $primarycolor .'!important;}.lang-list__ul,.item-tab-control a:hover,.flashmessage-warning,..edit-link:hover,.del-link:hover {border-color:#'. $primarycolor .'!important;}.select2-container--focus .select2-selection--single,.options-form .select2-container--default .select2-selection--single:focus,input.input-search:focus,.catpub select:focus,.meta select:focus,.row select:focus,input.input:focus,.l-search input:focus,input#alert_email:focus,.publish input:focus,.header-page--ins .short-search-form{border-bottom: 1px solid #'. $primarycolor .'!important;}.h2-bottom-line {border-left: 3px solid #'. $primarycolor .'!important;}.item-tab-control a.active,.sort-btn.active,.change-view a.active,.header-page--ins nav a:hover,.header-page--ins nav a.active {border-bottom: 2px solid #'. $primarycolor .'!important;}@media only screen and (max-width: 999px) {nav ul {border-color:#'. $primarycolor .'!important;background-color:#'. $primarycolor .'!important;}}button:hover,input.submit:hover,.submit-search:hover,.qq-upload-button:hover,#btn_subscribe:hover,.searchbutton:hover ,nav ul a:hover,.btn-blue,.lang-list__ul a:hover,.item__cat:hover,.about-item__ico-wrp:hover span,.item-inline__cat:hover,.btn-pink:hover{background-color: #'. $hovercolor .'!important;}.btn-publish{background-color: #'. $publishcolor .'!important;}.btn-publish:hover{background-color: #'. $publishhovercolor .'!important;}</style>';
    }
   osc_add_hook('header', 'eva_style');	

	function search_ads_listing_medium_evarevo() {
        if(osc_get_preference('search-evarevo_middle', 'eva')!='') {
            echo '<div class="clear"></div>' . PHP_EOL;
            echo '<div class="middle_search">' . PHP_EOL;
            echo osc_get_preference('search-evarevo_middle', 'eva');
            echo '</div>' . PHP_EOL;
        }
    }
    osc_add_hook('search_middle', 'search_ads_listing_medium_evarevo');

    /* remove theme */
  function eva_delete() {
Preference::newInstance()->delete(array('s_section' => 'eva'));
    }

osc_add_hook('theme_delete_eva', 'eva_delete');

if( !function_exists('eva_carousel_num_ads') ) {
		function eva_carousel_num_ads() {
			return(osc_get_preference('carousel_numads', 'eva')) ;
		}
	}
if( !function_exists('eva_map_num_ads') ) {
		function eva_map_num_ads() {
			return(osc_get_preference('map_num_ads', 'eva')) ;
		}
	}	
function eva__redirect_dashboard()
    {
        if( (Rewrite::newInstance()->get_location() === 'user') && (Rewrite::newInstance()->get_section() === 'dashboard') ) {
            header('Location: ' .osc_user_list_items_url());
            exit;
        }
}
osc_add_hook('init', 'eva__redirect_dashboard', 2);

function eva_popular_ads_start() {

			$num_ads1 = eva_carousel_num_ads(); // SETS HOW MANY POPULAR ADS TO DISPLAY
			 $conn = getConnection();
          $item_array=$conn->osc_dbFetchResults("SELECT i.*, l.*, t.*, total_views
    FROM %st_item i
    JOIN %st_item_location l ON i.pk_i_id = l.fk_i_item_id
	JOIN %st_item_description t ON i.pk_i_id = t.fk_i_item_id
    join (select fk_i_item_id as pk_i_id, sum(i_num_views) as total_views
    from %st_item_stats
    group by fk_i_item_id
    having total_views > 0 ) as aux_item_views on aux_item_views.pk_i_id = i.pk_i_id
    WHERE i.b_enabled = 1 AND i.b_active = 1 AND i.b_spam = 0 AND (i.b_premium = 1 || i.dt_expiration >= CURDATE())
    ORDER BY total_views DESC
    LIMIT 0, %d", DB_TABLE_PREFIX, DB_TABLE_PREFIX, DB_TABLE_PREFIX, DB_TABLE_PREFIX, $num_ads1);

    if(count($item_array) > 0) {
	View::newInstance()->_exportVariableToView('customItems', $item_array);
    }
}
function eva_most_popular($lim = 12){

	$Popular = Item::newInstance();

	$order = Search::newInstance();

	$order->dao->select();

	$order->dao->from(DB_TABLE_PREFIX . 't_item i, '.DB_TABLE_PREFIX.'t_item_location l, '.DB_TABLE_PREFIX.'t_item_stats s');

	$order->dao->where('l.fk_i_item_id = i.pk_i_id AND s.fk_i_item_id = i.pk_i_id');

	$order->dao->where('i.b_enabled', 1);

	$order->dao->where('i.b_active', 1);

	$order->dao->where('i.b_spam', 0);

	$order->dao->groupBy('s.fk_i_item_id');

	$order->dao->orderBy('SUM(s.i_num_views)', 'DESC');

    $order->dao->limit($lim);

    $result = $order->dao->get();

    if($result == false) {

        return array();

      }

    $items  = $result->result();

    return $Popular->extendData($items);
	
	}


    function osc_related_eva_ra_numads() {
        return(osc_get_preference('related_eva_ra_numads', 'eva')) ;
    }

    function osc_related_eva_category() {
        return(osc_get_preference('related_eva_ra_category', 'eva')) ;
    }

    function osc_related_eva_country() {
        return(osc_get_preference('related_eva_ra_country', 'eva')) ;
    }

    function osc_related_eva_region() {
        return(osc_get_preference('related_eva_ra_region', 'eva')) ;
    }

    function osc_related_eva_picOnly() {
        return(osc_get_preference('related_eva_picOnly', 'eva')) ;
    }

    function osc_related_eva_css() {
    	return(osc_get_preference('related_eva_css', 'eva')) ;
    }

    function osc_related_eva_autoembed() {
    	return(osc_get_preference('related_eva_autoembed', 'eva')) ;
    }
    function osc_related_eva_premiumOnly() {
    	return(osc_get_preference('related_eva_premiumonly', 'eva')) ;
    }
//function to show related Ads
function related_eva_start() {
    $rmItemId = osc_item_id() ;
    $ra_numads = (osc_related_eva_ra_numads() != '') ? osc_related_eva_ra_numads() : '' ;
    $country = (osc_related_eva_country() != '') ? osc_related_eva_country() : '' ;
    $region = (osc_related_eva_region() != '') ? osc_related_eva_region() : '' ;
    $category = (osc_related_eva_category() != '') ? osc_related_eva_category() : '' ;
    $picOnly = (osc_related_eva_picOnly() != '') ? osc_related_eva_picOnly() : '';
    $premiumonly = (osc_related_eva_premiumOnly() != '') ? osc_related_eva_premiumOnly() : '';

    $mSearch = new Search() ;

    //Excluding current item
    $mSearch->dao->where(sprintf("%st_item.pk_i_id <> $rmItemId", DB_TABLE_PREFIX));

    //Checking if item is premium
    if($premiumonly ==1){
    $mSearch->dao->where(sprintf("%st_item.b_premium = 1", DB_TABLE_PREFIX));
    }

    //Adding Country as condition
    if($country ==1){
    $mSearch->addCountry(osc_item_country()) ;
    }

    //Adding Region as condition
    if($region ==1) {
    $mSearch->addRegion(osc_item_region()) ;
    }

    //Adding Item Category as condition
    if($category ==1) {
    $mSearch->addCategory(osc_item_category_id()) ;
    }

    //Adding condition for item having pictures
    if($picOnly == 1 ) {
    $mSearch->withPicture(true); //Search only Item which have pictures
    }

    //limiting number of related ads
    $mSearch->limit(0, $ra_numads) ; // fetch number of ads to show set in preference

    //Searching with all enabled conditions
    $aItems = $mSearch->doSearch();




	$global_items = View::newInstance()->_get('items') ; //save existing item array
	View::newInstance()->_exportVariableToView('items', $aItems); //exporting our searched item array

    require_once WebThemes::newInstance()->getCurrentThemePath() . 'related_eva_ads.php';



     //calling stored item array
    View::newInstance()->_exportVariableToView('items', $global_items); //restore original item array
    }

	osc_add_hook('init_admin', 'theme_eva_actions_admin');
function eva_is_fineuploader() {
    return Scripts::newInstance()->registered['jquery-fineuploader'] && method_exists('ItemForm', 'ajax_photos');
}
if (function_exists('osc_admin_menu_appearance')) {
    osc_admin_menu_appearance(__('Header logo', 'eva'), osc_admin_render_theme_url('oc-content/themes/eva/admin/header.php'), 'header_eva');
    osc_admin_menu_appearance(__('Theme settings', 'eva'), osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php'), 'settings_eva');
} else {

    function eva_admin_menu() {
        echo '<h3><a href="#">' . __('eva theme', 'eva') . '</a></h3>
            <ul>
                <li><a href="' . osc_admin_render_theme_url('oc-content/themes/eva/admin/header.php') . '">&raquo; ' . __('Header logo', 'eva') . '</a></li>
                <li><a href="' . osc_admin_render_theme_url('oc-content/themes/eva/admin/settings.php') . '">&raquo; ' . __('Theme settings', 'eva') . '</a></li>
		   </ul>';
    }

    osc_add_hook('admin_menu', 'eva_admin_menu');
}
function eva_user_type() {
  if(Params::getParam('sCompany') <> '' and Params::getParam('sCompany') <> null) {
    Search::newInstance()->addJoinTable( 'pk_i_id', DB_TABLE_PREFIX.'t_user', DB_TABLE_PREFIX.'t_item.fk_i_user_id = '.DB_TABLE_PREFIX.'t_user.pk_i_id', 'LEFT OUTER' ) ; 

    if(Params::getParam('sCompany') == 1) {
      Search::newInstance()->addConditions(sprintf("%st_user.b_company = 1", DB_TABLE_PREFIX));
    } else {
      Search::newInstance()->addConditions(sprintf("coalesce(%st_user.b_company, 0) <> 1", DB_TABLE_PREFIX, DB_TABLE_PREFIX));
    }
  }
}

osc_add_hook('search_conditions', 'eva_user_type');

function eva_get_loc($loc = '', $country = '', $region = '', $city = ''){
  if( $loc == '') {
    if( $city =! '' && is_numeric($city) ) {
      $city_info = City::newInstance()->findByPrimaryKey( $city );
      $region_info = Region::newInstance()->findByPrimaryKey( $city_info['fk_i_region_id'] );
      return $city_info['s_name'] . ' - ' . $region_info['s_name'];
    }

 
    if( $region =! '' && is_numeric($region) ) {
      $region_info = Region::newInstance()->findByPrimaryKey( $region );
      return $region_info['s_name'];
    }

  } else {
    return $loc;
  }
}

function eva_category_root( $category_id ) {
  $category = Category::newInstance()->findRootCategory( $category_id );
  $catid = $category['pk_i_id'];
  return $catid;
}

function eva_category_root_name( $category_id ) {
  $category = Category::newInstance()->findRootCategory( $category_id );
  $catname = $category['s_name'];
  return $catname;
}
if( !function_exists('eva_item_category_url') ){
    function eva_item_category_url($category_id){
		     if ( osc_rewrite_enabled() ) {
                if ($category_id != '') {
					$Category = Category::newInstance()->findByPrimaryKey($category_id) ;
                    $sanitized_category = $Category['s_slug'] . '/' ;
                    $path = osc_base_url() . $sanitized_category ;
                }
            } else {
				$Category = Category::newInstance()->findByPrimaryKey($category_id) ;
                $path = sprintf( osc_base_url(true) . '?page=search&sCategory=%d', $Category['pk_i_id'] ) ;
            }
			return $path ;
    }
}

function eva_search_location($country = null, $region = null, $city = null, $address = null) {
    	$sAddress = (isset($address) ? $address : '');
        $sCity = (isset($city) ? $city : '');
        $sRegion = (isset($region) ? $region : '');
        $sCountry = (isset($country) ? $country : '');
        $fulladdress = sprintf('%s, %s, %s, %s', $sAddress, $sCity, $sRegion, $sCountry);
		$key =  osc_get_preference('map-key-geo', 'eva');
        $response = file_get_contents(sprintf('https://maps.googleapis.com/maps/api/geocode/json?address=%s&key=%s', urlencode($fulladdress), $key));
        $jsonResponse = json_decode($response);
        $coord = false;

    if (isset($jsonResponse->results[0]->geometry->location) && !empty($jsonResponse->results[0]->geometry->location)) {
        $location = $jsonResponse->results[0]->geometry->location;
        $coord['lat'] = $location->lat;
        $coord['lng'] = $location->lng;
    }
	return  $coord ;
}
function eva_add_location($item) {
        $itemId = $item['pk_i_id'];
        $aItem = Item::newInstance()->findByPrimaryKey($itemId);
        $sAddress = (isset($aItem['s_address']) ? $aItem['s_address'] : '');
        $sCity = (isset($aItem['s_city']) ? $aItem['s_city'] : '');
        $sRegion = (isset($aItem['s_region']) ? $aItem['s_region'] : '');
        $sCountry = (isset($aItem['s_country']) ? $aItem['s_country'] : '');
        $fulladdress = sprintf('%s, %s, %s, %s', $sAddress, $sCity, $sRegion, $sCountry);
        $key =  osc_get_preference('map-key-geo', 'eva');
        $response = file_get_contents(sprintf('https://maps.googleapis.com/maps/api/geocode/json?address=%s&key=%s', urlencode($fulladdress), $key));
        $jsonResponse = json_decode($response);
        if (isset($jsonResponse->results[0]->geometry->location) && !empty($jsonResponse->results[0]->geometry->location)) 		{
        $location = $jsonResponse->results[0]->geometry->location;
        ItemLocation::newInstance()->update (array('d_coord_lat' => $location->lat
                                                      ,'d_coord_long' => $location->lng)
                                                ,array('fk_i_item_id' => $itemId));
       }
    }

if(osc_get_preference('main-map', 'eva') == 'enable' || osc_get_preference('search-map', 'eva') == 'enable' || osc_get_preference('item-map', 'eva') == 'enable' ) {
osc_add_hook('posted_item', 'eva_add_location');
osc_add_hook('edited_item', 'eva_add_location');
}
function eva_mobile_number() {
    if (osc_item_id()) {
		$user = User::newInstance()->findByPrimaryKey( osc_item_user_id() );
		if($user['s_phone_mobile'] != ''){
			if (osc_get_preference('hide_digits', 'eva') == '1') {
                ?>
                <script type="text/javascript">
                    $(document).ready(function () {
                        var number = '<?php echo $user['s_phone_mobile']; ?>';
                        $('.set_<?php echo osc_item_id(); ?>').click(function () {
                            $(this).html(number);
                        });
                    });
                </script>
                <span class="disphone set_<?php echo osc_item_id(); ?>" title="<?php echo osc_esc_html(__('Click to show the number', 'eva')); ?>"><?php echo eva_replace_number_to_x($user['s_phone_mobile']); ?></span>
                <?php
            } else {
                ?>
                <?php echo $user['s_phone_mobile']; ?>
                <?php
            }
			
			}
        } else if (osc_user()) {
				if(osc_user_phone_mobile() != ''){
			if (osc_get_preference('hide_digits', 'eva') == '1') {
                ?>
                <script type="text/javascript">
                    $(document).ready(function () {
                        var number = '<?php echo osc_user_phone_mobile(); ?>';
                        $('.set_<?php echo osc_user_id(); ?>').click(function () {
                            $(this).html(number);
                        });
                    });
                </script>
                <span class="disphone set_<?php echo osc_user_id(); ?>" title="<?php echo osc_esc_html(__('Click to show the number', 'eva')); ?>"><?php echo eva_replace_number_to_x(osc_user_phone_mobile()); ?></span>
                <?php
            } else {
                ?>
                <?php echo osc_user_phone_mobile(); ?>
                <?php
            }
			
			}
		}
    }
function eva_phone_number() {
    if (osc_item_id()) {
		$user = User::newInstance()->findByPrimaryKey( osc_item_user_id() );
		if($user['s_phone_land'] != ''){
			if (osc_get_preference('hide_digits', 'eva') == '1') {
                ?>
                <script type="text/javascript">
                    $(document).ready(function () {
                        var number = '<?php echo $user['s_phone_land']; ?>';
                        $('.set2_<?php echo osc_item_id(); ?>').click(function () {
                            $(this).html(number);
                        });
                    });
                </script>
                <span class="disphone set2_<?php echo osc_item_id(); ?>" title="<?php echo osc_esc_html(__('Click to show the number', 'eva')); ?>"><?php echo eva_replace_number_to_x($user['s_phone_land']); ?></span>
                <?php
            } else {
                ?>
                <?php echo $user['s_phone_land']; ?>
                <?php
            }
			
        }
            } else if (osc_user()) {
	if(osc_user_phone_land() != ''){
			if (osc_get_preference('hide_digits', 'eva') == '1') {
                ?>
                <script type="text/javascript">
                    $(document).ready(function () {
                        var number = '<?php echo osc_user_phone_land(); ?>';
                        $('.set2_<?php echo osc_user_id(); ?>').click(function () {
                            $(this).html(number);
                        });
                    });
                </script>
                <span class="disphone set2_<?php echo osc_user_id(); ?>" title="<?php echo osc_esc_html(__('Click to show the number', 'eva')); ?>"><?php echo eva_replace_number_to_x(osc_user_phone_land()); ?></span>
                <?php
            } else {
                ?>
                <?php echo osc_user_phone_land(); ?>
                <?php
            }
			
        }
			}
}
function eva_replace_number_to_x($number) {
	
	 return substr($number,0,4).str_repeat("X", (strlen($number) - 4));
}
function eva_item_deactivate_url($secret = '', $id = '') {
        if ($id == '') { $id = osc_item_id(); };
        if ( osc_rewrite_enabled() ) {
            return osc_base_url() . 'item/deactivate' . '/' . $id . '/' . $secret;
        } else {
            return osc_base_url(true) . '?page=item&action=deactivate&id=' . $id . ($secret != '' ? '&secret=' . $secret : '');
        }
    }
	
if( !function_exists('osc_uploads_url') ){
    function osc_uploads_url($item = ''){
        return osc_base_url().'oc-content/uploads/'.$item;
    }
}

if( !function_exists('eva_favicon_url') ) {
        function eva_favicon_url() {
            $logo = osc_get_preference('favicon','eva');
            if( $logo ) {
                return osc_uploads_url($logo);
            }
			else
			{
				return osc_current_web_theme_url('img/favicon.png'); 
			}
        }
    }
?>