<?php
  // Create menu
  $title = __('Configure', 'rest');
  rest_menu($title);


  // GET & UPDATE PARAMETERS
  // $variable = mb_param_update( 'param_name', 'form_name', 'input_type', 'plugin_var_name' );
  // input_type: check or value
  
  $enable = mb_param_update('enable', 'plugin_action', 'check', 'plugin-rest');

  if(Params::getParam('plugin_action') == 'done') {
    message_ok( __('Settings were successfully saved', 'rest') );
  }

  if(Params::getParam('keyDeleteId') > 0) {
    ModelREST::newInstance()->removeKey(Params::getParam('keyDeleteId'));
    ModelREST::newInstance()->removeKeyLogs(Params::getParam('keyDeleteId'));
    message_ok( __('API Key successfully removed', 'rest') );
  }

  $keys = ModelREST::newInstance()->getKeys();

?>


<div class="mb-body">
 
  <!-- CONFIGURE SECTION -->
  <div class="mb-box">
    <div class="mb-head"><i class="fa fa-wrench"></i> <?php _e('Configure', 'rest'); ?></div>

    <div class="mb-inside mb-rest">
      <form name="promo_form" action="<?php echo osc_admin_base_url(true); ?>" method="POST" enctype="multipart/form-data" >
        <?php if(!rest_is_demo()) { ?>
        <input type="hidden" name="page" value="plugins" />
        <input type="hidden" name="action" value="renderplugin" />
        <input type="hidden" name="file" value="<?php echo osc_plugin_folder(__FILE__); ?>configure.php" />
        <input type="hidden" name="plugin_action" value="done" />
        <?php } ?>

        <div class="mb-row">
          <label for="enable" class=""><span><?php _e('Enable Rest API', 'rest'); ?></span></label> 
          <input name="enable" type="checkbox" class="element-slide" <?php echo ($enable == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('When enabled, API will be available.', 'rest'); ?></div>
        </div>

        <div class="mb-row">&nbsp;</div>

        <div class="mb-foot">
          <?php if(rest_is_demo()) { ?>
            <a class="mb-button mb-has-tooltip disabled" onclick="return false;" style="cursor:not-allowed;opacity:0.5;" title="<?php echo osc_esc_html(__('This is demo site', 'rest')); ?>"><?php _e('Save', 'rest');?></a>
          <?php } else { ?>
            <button type="submit" class="mb-button"><?php _e('Save', 'rest');?></button>
          <?php } ?>
        </div>
      </form>
    </div>
  </div>


  <!-- STATS SECTION -->
  <div class="mb-box">
    <div class="mb-head"><i class="fa fa-key"></i> <?php _e('API Keys', 'rest'); ?></div>

    <div class="mb-inside mb-rest">
      <div class="mb-table mb-table-stats">
        <div class="mb-table-head">
          <div class="mb-col-1"><?php _e('ID', 'rest');?></div>
          <div class="mb-col-3 mb-align-left"><?php _e('Name', 'rest');?></div>
          <div class="mb-col-4 mb-align-left"><?php _e('Description', 'rest');?></div>
          <div class="mb-col-6 mb-align-left"><?php _e('Key', 'rest');?></div>
          <div class="mb-col-3 mb-align-left"><?php _e('Privileges', 'rest');?></div>
          <div class="mb-col-2"><?php _e('Status', 'rest');?></div>
          <div class="mb-col-2"><?php _e('Date', 'rest');?></div>
          <div class="mb-col-3">&nbsp;</div>
        </div>
        
        <?php if(count($keys) > 0) { ?>
          <?php foreach($keys as $k) { ?>
            <div class="mb-table-row">
              <div class="mb-col-1"><?php echo $k['pk_i_id']; ?></div>
              <div class="mb-col-3 mb-align-left"><?php echo $k['s_name']; ?></div>
              <div class="mb-col-4 mb-align-left"><?php echo $k['s_description']; ?></div>
              <div class="mb-col-6 mb-align-left" style="font-weight:bold;"><?php echo $k['s_key']; ?></div>
              <div class="mb-col-3 mb-align-left"><?php echo $k['s_privilege']; ?></div>
              <div class="mb-col-2"><?php echo $k['s_status']; ?></div>
              <div class="mb-col-2" style="color:#888"><?php echo date('Y-m-d', strtotime($k['dt_datetime'])); ?></div>
              <div class="mb-col-3 mb-buttons">
                <a href="<?php echo osc_route_admin_url('rest-admin-edit', array('keyEditId' => $k['pk_i_id'])); ?>" class="mb-btn mb-rest-edit mb-button-white mb-has-tooltip-light" title="<?php echo osc_esc_html(__('Edit key', 'rest')); ?>"><i class="fa fa-pencil"></i> <span><?php _e('Edit', 'rest'); ?></span></a>
                
                <?php if(!rest_is_demo()) { ?>
                  <a href="<?php echo osc_route_admin_url('rest-admin-delete', array('keyDeleteId' => $k['pk_i_id'])); ?>" class="mb-btn mb-rest-remove mb-button-red mb-has-tooltip-light" title="<?php echo osc_esc_html(__('Remove key', 'rest')); ?>" onclick="return confirm('<?php echo osc_esc_js(__('Are you sure you want to remove this key? Action cannot be undone.', 'rest')); ?>')"><i class="fa fa-trash"></i></a>
                <?php } ?>
              </div>

            </div>
          <?php } ?>
        <?php } else { ?>
          <div class="mb-table-row mb-row-empty">
            <i class="fa fa-warning"></i><span><?php _e('No API Keys has been found', 'rest'); ?></span>
          </div>
        <?php } ?>
        
      </div>

      <div class="mb-row">
        <br/>
        <a class="mb-button-green mb-new-key" href="<?php echo osc_route_admin_url('rest-admin-new'); ?>"><i class="fa fa-plus-circle"></i> <?php _e('Create a new API Key', 'rest'); ?></a>
      </div>
    </div>
  </div>






  <!-- THEME CONFIG SECTION -->
  <div class="mb-box">
    <div class="mb-head"><i class="fa fa-wrench"></i> <?php _e('Available calls', 'rest'); ?></div>

    <div class="mb-inside mb-rest">
      <div class="mb-row mb-notes">
        <div class="mb-line"><?php _e('All calls point out to following url:', 'rest'); ?> <?php echo osc_base_url(); ?>oc-content/plugins/rest/api.php</div>
        <div class="mb-line"><?php _e('Parameters can be pushed to URL using OPTIONS, GET, POST, PUT or DELETE.', 'rest'); ?></div>
        <div class="mb-line"><?php _e('Parameters key (api key) and type (read,insert,update,delete) must be provided in URL.', 'rest'); ?></div>
        <div class="mb-line"><?php _e('Use optional parameter onlyResponse=1 to get just response as output. If not defined, output contains status (OK/ERROR), message, execution_seconds, block_id and response (content).', 'rest'); ?></div>
        <div class="mb-line"><?php _e('Sample API URL:', 'rest'); ?> <?php echo osc_base_url(); ?>oc-content/plugins/rest/api.php?key=test-api-key&type=read&object=search&action=items&bPremium=1</div>
      </div>

      <div class="mb-table mb-table-rest">
        <div class="mb-table-head">
          <div class="mb-col-12 mb-align-left"><?php _e('Call (incl. required parameters and default value if available)', 'rest');?></div>
          <div class="mb-col-6 mb-align-left"><?php _e('Parameters', 'rest');?></div>
          <div class="mb-col-6 mb-align-left"><?php _e('Description', 'rest');?></div>
        </div>


        <div class="mb-table-row"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: read', 'rest');?>, <?php _e('Single listing data', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=item&action=byId&itemId=</div>
          <div class="mb-col-6 mb-align-left">itemId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Listing data by item ID', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=item&action=resourcesById&itemId=</div>
          <div class="mb-col-6 mb-align-left">itemId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List of resources of listing', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=item&action=locationById&itemId=</div>
          <div class="mb-col-6 mb-align-left">itemId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Location data of listing', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=item&action=metaById&itemId=</div>
          <div class="mb-col-6 mb-align-left">itemId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List of meta data (custom fields) of listing', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=item&action=commentsById&itemId=&page=&perPage=</div>
          <div class="mb-col-6 mb-align-left">itemId, page (0), perPage (20)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List of comments of listing', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=item&action=countCommentsById&itemId=</div>
          <div class="mb-col-6 mb-align-left">itemId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Count comments on listing', 'rest');?></div>
        </div>



        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: read', 'rest');?>, <?php _e('Multiple listings data', 'rest');?></div></div>


        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=items&action=byCategoryId&categoryId=</div>
          <div class="mb-col-6 mb-align-left">categoryId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List of items by category', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=items&action=byEmail&userEmail=</div>
          <div class="mb-col-6 mb-align-left">userEmail</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List of listings by user (contact) email', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=items&action=byUserId&userId=&start=&end=</div>
          <div class="mb-col-6 mb-align-left">userId, start (0), end (20)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List of listings by user ID', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=items&action=byUserIdEnabled&userId=&start=&end=</div>
          <div class="mb-col-6 mb-align-left">userId, start (0), end (20)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List of enabled listings by user ID', 'rest');?></div>
        </div>


        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: read', 'rest');?>, <?php _e('Listing counter functions', 'rest');?></div></div>


        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=itemcount&action=total&categoryId=&active=</div>
          <div class="mb-col-6 mb-align-left">categoryId, active (1)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Count category active/inactive listings', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=itemcount&action=category&categoryId=&enabled=&active=</div>
          <div class="mb-col-6 mb-align-left">categoryId, enabled (1), active (1)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Count category active/inactive enabled/disabled listings', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=itemcount&action=byUserId&userId=</div>
          <div class="mb-col-6 mb-align-left">userId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Count user ID listings', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=itemcount&action=byUserIdEnabled&userId=</div>
          <div class="mb-col-6 mb-align-left">userId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Count user ID enabled listings', 'rest');?></div>
        </div>


        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: read', 'rest');?>, <?php _e('Category functions', 'rest');?></div></div>
        

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=category&action=byId&categoryId=</div>
          <div class="mb-col-6 mb-align-left">categoryId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Single category data', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=category&action=subcategoriesById&categoryId=</div>
          <div class="mb-col-6 mb-align-left">categoryId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List of subcategories of given category', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=category&action=root</div>
          <div class="mb-col-6 mb-align-left">-</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List of root categories', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=category&action=tree</div>
          <div class="mb-col-6 mb-align-left">-</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List of categories tree', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=category&action=listAll</div>
          <div class="mb-col-6 mb-align-left">-</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List all categories', 'rest');?></div>
        </div>


        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: read', 'rest');?>, <?php _e('City functions', 'rest');?></div></div>


        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=city&action=byId&cityId=</div>
          <div class="mb-col-6 mb-align-left">cityId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Single city data', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=city&action=byName&cityName=&amp;regionId=</div>
          <div class="mb-col-6 mb-align-left">cityName, regionId (null)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Single city data by city name (and region ID)', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=city&action=listAll</div>
          <div class="mb-col-6 mb-align-left">-</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List all cities (may be exhaustive)', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=city&action=statsById&cityId=</div>
          <div class="mb-col-6 mb-align-left">cityId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Statistics of single city (item count)', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=cities&action=byRegionId&amp;regionId=</div>
          <div class="mb-col-6 mb-align-left">regionId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List of cities by region ID', 'rest');?></div>
        </div>


        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: read', 'rest');?>, <?php _e('Region functions', 'rest');?></div></div>


        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=region&action=byId&amp;regionId=</div>
          <div class="mb-col-6 mb-align-left">regionId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Single region data', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=region&action=byName&regionName=&countryCode=</div>
          <div class="mb-col-6 mb-align-left">regionName, countryCode (null)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Single region data by region name (and country code)', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=region&action=listAll</div>
          <div class="mb-col-6 mb-align-left">-</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List of all regions', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=region&action=statsById&amp;regionId=</div>
          <div class="mb-col-6 mb-align-left">regionId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Statistics of single region (item count)', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=regions&action=byCountryCode&countryCode</div>
          <div class="mb-col-6 mb-align-left">countryCode</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List of regions by country code', 'rest');?></div>
        </div>


        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: read', 'rest');?>, <?php _e('Country functions', 'rest');?></div></div>


        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=country&action=byCode&countryCode=</div>
          <div class="mb-col-6 mb-align-left">countryCode</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Single country data', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=country&action=byName&countryName=</div>
          <div class="mb-col-6 mb-align-left">countryName</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Single country data by country name', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=country&action=listAll</div>
          <div class="mb-col-6 mb-align-left">-</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List of all countries', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=country&action=statsByCode&countryCode=</div>
          <div class="mb-col-6 mb-align-left">countryCode</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Statistics of single country (item count)', 'rest');?></div>
        </div>


        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: read', 'rest');?>, <?php _e('Currency functions', 'rest');?></div></div>


        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=currency&action=byId&currencyId=</div>
          <div class="mb-col-6 mb-align-left">currencyId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Single currency data', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=currencies&action=listAll</div>
          <div class="mb-col-6 mb-align-left">-</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List of all currencies', 'rest');?></div>
        </div>


        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: read', 'rest');?>, <?php _e('Locale functions', 'rest');?></div></div>


        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=locale&action=byCode&localeCode=</div>
          <div class="mb-col-6 mb-align-left">localeCode</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Single locale data', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=locales&action=listAll</div>
          <div class="mb-col-6 mb-align-left">-</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List of all locales', 'rest');?></div>
        </div>


        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: read', 'rest');?>, <?php _e('User functions', 'rest');?></div></div>


        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=user&action=byId&userId=&localeCode=</div>
          <div class="mb-col-6 mb-align-left">userId, localeCode (en_US)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Single user data', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=user&action=byEmail&userEmail=&localeCode=</div>
          <div class="mb-col-6 mb-align-left">userEmail, localeCode (en_US)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Single user data by email', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=user&action=count</div>
          <div class="mb-col-6 mb-align-left">-</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Count all users', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=user&action=commentsById&userId=</div>
          <div class="mb-col-6 mb-align-left">userId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List of all comments posted by user ID', 'rest');?></div>
        </div>


        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: read', 'rest');?>, <?php _e('Search functions', 'rest');?></div></div>



        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=search&action=sortColumns</div>
          <div class="mb-col-6 mb-align-left">-</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List of available sort columns', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=search&action=sortType</div>
          <div class="mb-col-6 mb-align-left">-</div>
          <div class="mb-col-6 mb-align-left"><?php _e('list of available sort options', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=search&action=premiumItems&limit=</div>
          <div class="mb-col-6 mb-align-left">limit (5)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List of premium items (randomized)', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=search&action=latestItems&limit=</div>
          <div class="mb-col-6 mb-align-left">limit (5)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List of latest items', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=search&action=items&sCategory=&sRegion=&sCity=&sPriceMin=&sCompany=...</div>
          <div class="mb-col-6 mb-align-left">sCategory, sPriceMin, sPriceMax, sCountry, sRegion, sCity, sOrder, iOrderType, ...</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Search items based on provided parameters. All parameters available in bender theme can be passed to URL', 'rest');?></div>
        </div>


        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: read', 'rest');?>, <?php _e('Latest search terms functions', 'rest');?></div></div>


        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=latestSearches&action=listAll&limit=</div>
          <div class="mb-col-6 mb-align-left">limit</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List of lately searched terms (storing must be enabled)', 'rest');?></div>
        </div>


        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: read', 'rest');?>, <?php _e('Static pages functions', 'rest');?></div></div>


        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=page&action=byId&pageId=&localeCode=en_US</div>
          <div class="mb-col-6 mb-align-left">pageId, localeCode (en_US)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Single static page data', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=page&action=listAll&localeCode=</div>
          <div class="mb-col-6 mb-align-left">localeCode (en_US)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List of all static pages', 'rest');?></div>
        </div>


        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: read', 'rest');?>, <?php _e('Plugin: Business Profile', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-business_profile&action=listAll</div>
          <div class="mb-col-6 mb-align-left">-</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List of all business profiles data', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-business_profile&action=byUserId&userId=</div>
          <div class="mb-col-6 mb-align-left">userId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Profile data by osclass user ID', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-business_profile&action=count=</div>
          <div class="mb-col-6 mb-align-left">-</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Count all enabled business profiles', 'rest');?></div>
        </div>


        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: read', 'rest');?>, <?php _e('Plugin: Make Offer', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-make_offer&action=byItemId&itemId=123&validate=1</div>
          <div class="mb-col-6 mb-align-left">itemId, validate (0-all, 1-validated only)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get all offers on listing', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-make_offer&action=byOfferId&offerId=123</div>
          <div class="mb-col-6 mb-align-left">offerId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get all offer data by offer ID', 'rest');?></div>
        </div>


        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: read', 'rest');?>, <?php _e('Plugin: Attributes', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-attributes&action=listAttributes&enabled=&categoryId=</div>
          <div class="mb-col-6 mb-align-left">enabled (default 0), categoryId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List all attributes by category Id', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-attributes&action=listRequiredAttributes&categoryId=</div>
          <div class="mb-col-6 mb-align-left">categoryId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List all required attributes by category Id', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-attributes&action=listSearchAttributes&categoryId=</div>
          <div class="mb-col-6 mb-align-left">categoryId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List all search attributes (add to search enabled) by category Id', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-attributes&action=getAttributeById&attributeId=</div>
          <div class="mb-col-6 mb-align-left">attributeId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get single attribute record by id', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-attributes&action=getAttributeValues&type2=&attributeId=&parentId=&idMod=</div>
          <div class="mb-col-6 mb-align-left">type, attributeId, parentId, idMod (default false)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get attribute values by attribute id', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-attributes&action=getAllAttributeValues&attributeId=&parentId=</div>
          <div class="mb-col-6 mb-align-left">attributeId, parentId (optional)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get all attribute values by attribute id and parentId', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-attributes&action=getItemAttributes&itemId=</div>
          <div class="mb-col-6 mb-align-left">itemId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get item attributes', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-attributes&action=getItemAttributeValues&itemId=&attributeId=</div>
          <div class="mb-col-6 mb-align-left">itemId, attributeId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get item attribute values', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-attributes&action=getAllItemAttributeValues&itemId=</div>
          <div class="mb-col-6 mb-align-left">itemId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get all item attribute values', 'rest');?></div>
        </div>


        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: read', 'rest');?>, <?php _e('Plugin: User Rating', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-user_rating&action=byUserId&userId=&userEmail=&type2=&validate=</div>
          <div class="mb-col-6 mb-align-left">userId, userEmail, type (0-buyer, 1-seller), validate (0-all, 1-validated only)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get all ratings of user', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-user_rating&action=avgByUserId&userId=&userEmail=&type2=&validate=</div>
          <div class="mb-col-6 mb-align-left">userId, userEmail, type (0-buyer, 1-seller), validate (0-all, 1-validated only)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get user average rating', 'rest');?></div>
        </div>


        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: read', 'rest');?>, <?php _e('Plugin: Youtube Video', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-youtube&action=byItemId&itemId=</div>
          <div class="mb-col-6 mb-align-left">itemId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get video record', 'rest');?></div>
        </div>


        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: read', 'rest');?>, <?php _e('Plugin: Forums', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-forums&action=listCategories</div>
          <div class="mb-col-6 mb-align-left">-</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List all categories', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-forums&action=listBoards&categoryId=&parentId=</div>
          <div class="mb-col-6 mb-align-left">categoryId (optional), parentId (optional)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get boards in category or parent', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-forums&action=listBoardChildren&boardId=</div>
          <div class="mb-col-6 mb-align-left">boardId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List board children (subboards)', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-forums&action=listTopics&boardId=&page=&perPage=</div>
          <div class="mb-col-6 mb-align-left">boardId, page, perPage</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List topics in board', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-forums&action=listPosts&topicId=&page=&perPage=</div>
          <div class="mb-col-6 mb-align-left">topicId, page, perPage</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List posts in topic', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-forums&action=listUserPosts&userId=&page=&perPage=</div>
          <div class="mb-col-6 mb-align-left">userId, page, perPage</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List user posts', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-forums&action=listSearchPosts&term=&page=&perPage=</div>
          <div class="mb-col-6 mb-align-left">term, page, perPage</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List posts based on search term', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-forums&action=userById&userId=</div>
          <div class="mb-col-6 mb-align-left">userId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get user record', 'rest');?></div>
        </div>



        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: read', 'rest');?>, <?php _e('Plugin: Blog', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-blog&action=listBlogs</div>
          <div class="mb-col-6 mb-align-left">-</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List all blogs/articles', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-blog&action=getBlogById&blogId=</div>
          <div class="mb-col-6 mb-align-left">blogId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get blog/article by blog ID', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-blog&action=getCommentsByBlogId&blogId=</div>
          <div class="mb-col-6 mb-align-left">blogId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List comments by blog ID', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-blog&action=getUserById&userId=&type2=</div>
          <div class="mb-col-6 mb-align-left">userId, type</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get user by ID', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-blog&action=getCategoryById&categoryId=</div>
          <div class="mb-col-6 mb-align-left">categoryId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get category details', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-blog&action=listCategories</div>
          <div class="mb-col-6 mb-align-left">-</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List categories', 'rest');?></div>
        </div>


        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: read', 'rest');?>, <?php _e('Plugin: Virtual products', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-virtual&action=lastFileByItemId&itemId=</div>
          <div class="mb-col-6 mb-align-left">itemId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Last active file by item ID', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-virtual&action=getDownloadsByUserId&userId=</div>
          <div class="mb-col-6 mb-align-left">userId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List of available (paid) files by user ID', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-virtual&action=freeFilesByUserId&userId=</div>
          <div class="mb-col-6 mb-align-left">userId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('List of free files by user ID', 'rest');?></div>
        </div>


        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: read', 'rest');?>, <?php _e('Plugin: Favorite Items', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-favorite_items&action=getListsByUserId&userId=</div>
          <div class="mb-col-6 mb-align-left">userId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get favorite lists by user ID', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-favorite_items&action=getItemsByListId&listId=</div>
          <div class="mb-col-6 mb-align-left">listId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get favorite items by list ID', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-favorite_items&action=getAllByUserIdAndItemId&itemId=&userId=</div>
          <div class="mb-col-6 mb-align-left">itemId, userId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get active favorite list and favorite item by user ID and item ID, good to check if user has favorited listing', 'rest');?></div>
        </div>

        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: read', 'rest');?>, <?php _e('Plugin: Instant Messenger', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-instant_messenger&action=getThreadsByUserId&userId=&limit=&page=</div>
          <div class="mb-col-6 mb-align-left">userId, limit (default 20), page (default 0)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get threads by user ID', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-instant_messenger&action=getMessagesByThreadId&threadId=</div>
          <div class="mb-col-6 mb-align-left">threadId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get messages by thread ID', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-instant_messenger&action=getBlocksByUserId&userId=</div>
          <div class="mb-col-6 mb-align-left">userId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get list of blocks by user ID', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-instant_messenger&action=checkBlockByUserIdAndEmail&userId=&email=</div>
          <div class="mb-col-6 mb-align-left">userId, email</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Check if user blocked particular email', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-instant_messenger&action=getThreadsByItemId&itemId=&userId=</div>
          <div class="mb-col-6 mb-align-left">itemId, userId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Check existing threads by user ID and item ID', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-instant_messenger&action=getThreadById&threadId=</div>
          <div class="mb-col-6 mb-align-left">threadId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get thread row by ID', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-instant_messenger&action=checkThreadIsRead&threadId=&userId=&secret=</div>
          <div class="mb-col-6 mb-align-left">threadId, userId, secret (default blank)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Check if thread has been read or it is unread', 'rest');?></div>
        </div>


        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: read', 'rest');?>, <?php _e('Plugin: Osclass Pay', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-osclass_pay&action=getPaymentsByUserId&userId=&history=</div>
          <div class="mb-col-6 mb-align-left">userId, history (1 = current month, 2 = current year)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get user payment history', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-osclass_pay&action=getPaymentRecord&type2=&itemId=&paid=</div>
          <div class="mb-col-6 mb-align-left">type (101, 201, ...), itemId, paid (default -1)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get payment/fee record', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-osclass_pay&action=checkFeeIsPaid&type2=&itemId=</div>
          <div class="mb-col-6 mb-align-left">type (101, 201, ...), itemId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Check if type of fee has been paid', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-osclass_pay&action=feeExists&type2=&itemId=&paid=</div>
          <div class="mb-col-6 mb-align-left">type (101, 201, ...), itemId, paid (default -1)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Check if fee record exists', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-osclass_pay&action=getUserWallet&userId=</div>
          <div class="mb-col-6 mb-align-left">userId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get user wallet record', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-osclass_pay&action=getFee&type2=&category=&country=&region=&hours=</div>
          <div class="mb-col-6 mb-align-left">type (101, 201, ...), category, country, region, hours</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get fee amount', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-osclass_pay&action=getCategoryFee&type2=&category=&hours=</div>
          <div class="mb-col-6 mb-align-left">type (101, 201, ...), category, hours</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get fee amount for category', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-osclass_pay&action=getLocationFee&type2=&country=&region=</div>
          <div class="mb-col-6 mb-align-left">type (101, 201, ...), country, region</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get fee amount for country & region', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-osclass_pay&action=getPacks</div>
          <div class="mb-col-6 mb-align-left">-</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get list of credit packs', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-osclass_pay&action=getPackById&packId=</div>
          <div class="mb-col-6 mb-align-left">packId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get credit pack record by ID', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-osclass_pay&action=getGroups</div>
          <div class="mb-col-6 mb-align-left">-</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get all user groups / memberships', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-osclass_pay&action=getGroupById&groupId=</div>
          <div class="mb-col-6 mb-align-left">groupId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get user group record by ID', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-osclass_pay&action=getUserGroup&userId=</div>
          <div class="mb-col-6 mb-align-left">userId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get user current membership group record by user ID', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-osclass_pay&action=getCart&userId=</div>
          <div class="mb-col-6 mb-align-left">userId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get user cart content by user ID', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-osclass_pay&action=getItemData&itemId=</div>
          <div class="mb-col-6 mb-align-left">itemId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get item data (if available for selling & quantity) records by item ID', 'rest');?></div>
        </div>
        
        
        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: read', 'rest');?>, <?php _e('Plugin: SMS Notification & Verification', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-sms&action=getVerification&phoneNumber=&email=</div>
          <div class="mb-col-6 mb-align-left">phoneNumber, email (optional)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Get SMS verification record for particular phone number (and email)', 'rest');?></div>
        </div>


        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: insert', 'rest');?>, <?php _e('Item & User functions', 'rest');?></div></div>


        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">object=item&action=add&catId=&contactName&contactEmail=&price=&countryId=&amp;regionId=...</div>
          <div class="mb-col-6 mb-align-left">catId, contactName, countryId, ...</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Add an new listing. Same form composition is required as on bender theme - publish form, sending parameters to API url', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">object=user&action=add&s_name=&s_email=...</div>
          <div class="mb-col-6 mb-align-left">s_name, s_email, ...</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Add an new user. Same form composition is required as on bender theme - registration form, sending parameters to API url', 'rest');?></div>
        </div>


        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: insert', 'rest');?>, <?php _e('Plugin: Make Offer', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-make_offer&action=insertOffer&item_id=&quantity=&price=&status=&validate=&comment=&user_id=&user_name=&user_email=&user_phone=</div>
          <div class="mb-col-6 mb-align-left">item_id, quantity, price, status, validate, comment, user_id, user_name, user_email, user_phone</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Insert new offer', 'rest');?></div>
        </div>

        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: insert', 'rest');?>, <?php _e('Plugin: User Rating', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-user_rating&action=insertRating&user_id=&email=&from_user_id=&type2=&cat0=&cat1=&cat2=&cat3=&cat4=&cat5=&response=</div>
          <div class="mb-col-6 mb-align-left">user_id, email, from_user_id, type, cat0, cat1, cat2, cat3, cat4, cat5, response</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Insert new rating', 'rest');?></div>
        </div>


        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: insert/update', 'rest');?>, <?php _e('Plugin: Youtube Video', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-youtube&action=insertVideo&itemId=&code=&url=</div>
          <div class="mb-col-6 mb-align-left">itemId, code, url</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Insert or update video record', 'rest');?></div>
        </div>

        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: insert', 'rest');?>, <?php _e('Plugin: Favorite Items', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-favorite_items&action=insertList&name=&current=&userId=&userLogged=&notification=</div>
          <div class="mb-col-6 mb-align-left">name, current (0/1), userId, userLogged (0/1), notification (0/1)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Insert new favorite list', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-favorite_items&action=insertFavoriteItem&listId=&itemId=</div>
          <div class="mb-col-6 mb-align-left">listId, itemId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Add listing as favorited into list', 'rest');?></div>
        </div>

        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: insert', 'rest');?>, <?php _e('Plugin: Instant Messenger', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-instant_messenger&action=insertThread&item_id=&from_user_id=&from_user_name=&from_user_email=&to_user_id=&to_user_name=&to_user_email=&title=&flag=</div>
          <div class="mb-col-6 mb-align-left">item_id, from_user_id, from_user_name, from_user_email, to_user_id, to_user_name, to_user_email, title, flag</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Insert new thread', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-instant_messenger&action=insertMessage&thread_id=&type2=&read=&message=&file=&email_sent=</div>
          <div class="mb-col-6 mb-align-left">thread_id, type, read, message, file, email_sent</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Insert new message', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-instant_messenger&action=insertBlock&user_id=&email=</div>
          <div class="mb-col-6 mb-align-left">user_id, email</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Insert new block', 'rest');?></div>
        </div>
        

        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: insert', 'rest');?>, <?php _e('Plugin: SMS Notification & Verification', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-sms&action=createVerification&phoneNumber=&email=&provider=&token=&status=</div>
          <div class="mb-col-6 mb-align-left">phoneNumber (required), email, provider, token, status</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Insert new SMS verification record', 'rest');?></div>
        </div>




        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: update', 'rest');?>, <?php _e('Item & User functions', 'rest');?></div></div>


        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=item&action=markById&itemId=&as=spam</div>
          <div class="mb-col-6 mb-align-left">itemId, as (spam, bad_category, expired, ...)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Mark listing as spam / bad_category / ...', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=item&action=activateById&itemId=&secret=</div>
          <div class="mb-col-6 mb-align-left">itemId, secret</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Activate listing by itemId using item secret code', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">object=item&action=edit&itemId=&catId=&contactName&contactEmail=&price=&countryId=&amp;regionId=...</div>
          <div class="mb-col-6 mb-align-left">itemId, catId, contactName, countryId, ...</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Edit listing. Same form composition is required as on bender theme - edit form, sending parameters to API url', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">object=user&action=edit&s_name=&s_email=&s_phone_mobile=...</div>
          <div class="mb-col-6 mb-align-left">s_name, s_email, s_phone_mobile ...</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Edit user. Same form composition is required as on bender theme - profile form, sending parameters to API url', 'rest');?></div>
        </div>


        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">object=user&action=recover&s_email=</div>
          <div class="mb-col-6 mb-align-left">s_email</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Recover user password', 'rest');?></div>
        </div>

        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: update', 'rest');?>, <?php _e('Plugin: Make Offer', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-make_offer&action=validateByOfferId&offerId=</div>
          <div class="mb-col-6 mb-align-left">offerId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Validate offer by offer ID', 'rest');?></div>
        </div>


        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: update', 'rest');?>, <?php _e('Plugin: Favorite Items', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-favorite_items&action=updateList&listId=&name=&current=&userId=&userLogged=&notification=</div>
          <div class="mb-col-6 mb-align-left">listId, name, current (0/1), userId, userLogged (0/1), notification (0/1)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Update existing favorite list', 'rest');?></div>
        </div>

        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: update', 'rest');?>, <?php _e('Plugin: Instant Messenger', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-instant_messenger&action=updateThreadIsRead&threadId=&type2=</div>
          <div class="mb-col-6 mb-align-left">threadId, type (0/1 ... from user / to user)</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Mark thread as read', 'rest');?></div>
        </div>

        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: update', 'rest');?>, <?php _e('Plugin: Osclass Pay', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-osclass_pay&action=payFee&type2=&item_id=&payment_id=&expire=&hours=&repeat=</div>
          <div class="mb-col-6 mb-align-left">type, item_id, payment_id, expire, hours, repeat</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Pay fee', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-osclass_pay&action=addWallet&userId=&amount=</div>
          <div class="mb-col-6 mb-align-left">userId, amount</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Add funds to wallet', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-osclass_pay&action=updateUserGroup&userId=&groupId=&expire=</div>
          <div class="mb-col-6 mb-align-left">userId, groupId, expire</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Update user group record', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-osclass_pay&action=updateCart&userId=&content=</div>
          <div class="mb-col-6 mb-align-left">userId, content</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Update card content', 'rest');?></div>
        </div>

        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: update', 'rest');?>, <?php _e('Plugin: SMS Notification & Verification', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-sms&action=updateVerification&phoneNumber=&email=&provider=&token=&status=</div>
          <div class="mb-col-6 mb-align-left">phoneNumber (required), email, provider, token, status</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Update SMS verification record', 'rest');?></div>
        </div>



        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: delete', 'rest');?>, <?php _e('Item & User functions', 'rest');?></div></div>


        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=item&action=byId&itemId=</div>
          <div class="mb-col-6 mb-align-left">itemId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Remove listing', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=item&action=resourcesById&itemId=</div>
          <div class="mb-col-6 mb-align-left">itemId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Remove listing resources', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=user&action=byId&userId=</div>
          <div class="mb-col-6 mb-align-left">userId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Remove user', 'rest');?></div>
        </div>



        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: delete', 'rest');?>, <?php _e('Plugin: Make Offer', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-make_offer&action=removeByOfferId&offerId=123</div>
          <div class="mb-col-6 mb-align-left">offerId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Remove offer by offer ID', 'rest');?></div>
        </div>


        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: delete', 'rest');?>, <?php _e('Plugin: User Rating', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-user_rating&action=removeByRatingId&ratingId=</div>
          <div class="mb-col-6 mb-align-left">ratingId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Remove single rating', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-user_rating&action=removeByUserId&userId=</div>
          <div class="mb-col-6 mb-align-left">userId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Remove single rating', 'rest');?></div>
        </div>


        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: delete', 'rest');?>, <?php _e('Plugin: Youtube Video', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-youtube&action=removeByItemId&itemId=</div>
          <div class="mb-col-6 mb-align-left">itemId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Remove video by item ID', 'rest');?></div>
        </div>

        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: delete', 'rest');?>, <?php _e('Plugin: Favorite Items', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-favorite_items&action=deleteListById&listId=</div>
          <div class="mb-col-6 mb-align-left">listId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Delete favorite list by list Id', 'rest');?></div>
        </div>

        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: delete', 'rest');?>, <?php _e('Plugin: Instant Messenger', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-instant_messenger&action=deleteMessageById&messageId=</div>
          <div class="mb-col-6 mb-align-left">messageId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Delete message by ID', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-instant_messenger&action=deleteUserBlockById&blockId=</div>
          <div class="mb-col-6 mb-align-left">blockId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Delete user block by ID', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-instant_messenger&action=deleteMessagesByThreadId&threadId=</div>
          <div class="mb-col-6 mb-align-left">threadId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Delete messages by thread ID', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-instant_messenger&action=deleteThreadById&threadId=</div>
          <div class="mb-col-6 mb-align-left">threadId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Delete thread by ID', 'rest');?></div>
        </div>

        <div class="mb-table-row" style="margin-top:40px;"><div class="mb-col-24 mb-align-left" style="font-weight:bold"><?php _e('Type: delete', 'rest');?>, <?php _e('Plugin: Osclass Pay', 'rest');?></div></div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-osclass_pay&action=deleteUserGroup&userId=</div>
          <div class="mb-col-6 mb-align-left">userId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Delete user group membership', 'rest');?></div>
        </div>

        <div class="mb-table-row">
          <div class="mb-col-12 mb-align-left">&object=plugin-osclass_pay&action=deleteCart&userId=</div>
          <div class="mb-col-6 mb-align-left">userId</div>
          <div class="mb-col-6 mb-align-left"><?php _e('Delete cart content', 'rest');?></div>
        </div>


      </div>        
    </div>        
  </div>        
</div>


<?php echo rest_footer(); ?>