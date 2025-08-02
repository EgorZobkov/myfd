<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

    $providers = SCClass::providers();

    if(Params::getParam('plugin_action')=='done') {
        osc_set_preference('autoregister', Params::getParam("autoregister")==1?1:0, 'socialconnect', 'STRING');
        osc_set_preference('fixed_width', Params::getParam("fixed_width")==1?1:0, 'socialconnect', 'STRING');
        osc_set_preference('debug', Params::getParam("debug")==1?1:0, 'socialconnect', 'STRING');

        foreach($providers as $key => $provider) {
            osc_set_preference('enabled_' . $key, Params::getParam("enabled_" . $key)==1?1:0, 'socialconnect', 'STRING');
            osc_set_preference($key . '_app_id', trim(Params::getParam($key . "_app_id")), 'socialconnect', 'STRING');
            osc_set_preference($key . '_app_secret', trim(Params::getParam($key . "_app_secret")), 'socialconnect', 'STRING');
        }

        // save order
        $order = Params::getParam('order');
        $sorder = '';
        foreach($order as $key => $v) {
            $sorder .= ','.$key;
        }
        osc_set_preference('order_providers', $sorder, 'socialconnect');

        // HACK : This will make possible use of the flash messages ;)
        ob_get_clean();
        osc_add_flash_ok_message(__('Congratulations, the plugin is now configured', 'socialconnect'), 'admin');
        osc_redirect_to(osc_route_admin_url('sc-conf'));
    }

    $show_debug_no_file = false;
    $debug = osc_get_preference('debug', 'socialconnect');
    $filename = osc_content_path() . 'socialconnect.log';
    if($debug==1) {
        if (!file_exists($filename)) {
            $show_debug_no_file = true;
        }
    }

?>
    <style>
        .uk-sortable .socialconnect-button {
            width: 150px;
        }
        .btn-social {
            height: 20px!important;
        }
        legend {
            border:none;
        }
    </style>
<div class="uk-grid">
        <div class="uk-width-medium-1-5 ">
            <div class="uk-sticky-placeholder uk-margin-top">
                <ul class="uk-nav uk-nav-side" data-uk-sticky="{top:65, media: 768}" data-uk-scrollspy-nav="{closest:'li', smoothscroll:true}" style="    z-index: 1;">
                    <li class="uk-nav-header">Social Connect</li>
                    <li><a href="#sc-settings">Settings</a></li>
                    <li><a href="#sc-preview">Preview/Order buttons</a></li>
                    <li class="uk-nav-header">Networks</li>
                    <li><a href="#sc-facebook">Facebook<?php if(osc_get_preference('enabled_fb', 'socialconnect')==1) { ?><div class="uk-badge uk-badge-success uk-float-right"><?php _e('Enabled', 'socialconnect'); ?></div><?php } ?></a></li>
                    <li><a href="#sc-google">Google Plus<?php if(osc_get_preference('enabled_google', 'socialconnect')==1) { ?><div class="uk-badge uk-badge-success uk-float-right"><?php _e('Enabled', 'socialconnect'); ?></div><?php } ?></a></li>
                    <li><a href="#sc-twitter">Twitter<?php if(osc_get_preference('enabled_twitter', 'socialconnect')==1) { ?><div class="uk-badge uk-badge-success uk-float-right"><?php _e('Enabled', 'socialconnect'); ?></div><?php } ?></a></li>
                    <li><a href="#sc-linkedin">Linkedin<?php if(osc_get_preference('enabled_linkedin', 'socialconnect')==1) { ?><div class="uk-badge uk-badge-success uk-float-right"><?php _e('Enabled', 'socialconnect'); ?></div><?php } ?></a></li>
                    <li><a href="#sc-instagram">Instagram<?php if(osc_get_preference('enabled_instagram', 'socialconnect')==1) { ?><div class="uk-badge uk-badge-success uk-float-right"><?php _e('Enabled', 'socialconnect'); ?></div><?php } ?></a></li>
                    <li><a href="#sc-live">Windows Live<?php if(osc_get_preference('enabled_live', 'socialconnect')==1) { ?><div class="uk-badge uk-badge-success uk-float-right"><?php _e('Enabled', 'socialconnect'); ?></div><?php } ?></a></li>
                </ul>
            </div>
        </div>

        <div class="uk-width-medium-4-5">
            <form class="uk-form uk-form-horizontal" action="<?php echo osc_admin_base_url(true); ?>" method="post">
                <input type="hidden" name="page" value="plugins" />
                <input type="hidden" name="action" value="renderplugin" />
                <input type="hidden" name="route" value="sc-conf" />
                <input type="hidden" name="plugin_action" value="done" />
                <h2><?php _e('General Settings', 'socialconnect'); ?></h2>
                <div id="sc-settings" style="position: relative; top: -155px;"></div>
                <div>
                    <div class="uk-form-row">
                        <label class="uk-form-label"><?php _e('Enable autoregister', 'socialconnect'); ?></label>
                        <div class="uk-form-controls" style="margin-top: 5px;">
                            <label><input type="checkbox" <?php echo (osc_get_preference('autoregister', 'socialconnect')==1 ? 'checked="true"' : ''); ?> name="autoregister" value="1" /> <?php _e('Enabled', 'socialconnect'); ?></label>
                            <p class="uk-form-help-block"><?php _e('An account will be created for users login through any social media if they don\' have one already.', 'socialconnect'); ?></p>
                        </div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label"><?php _e('Button width', 'socialconnect'); ?></label>
                        <div class="uk-form-controls" style="margin-top: 5px;">
                                <label><input type="checkbox" <?php echo (osc_get_preference('fixed_width', 'socialconnect')==1 ? 'checked="true"' : ''); ?> name="fixed_width" value="1" /> <?php _e('Fixed width', 'socialconnect'); ?></label>
                            <p class="uk-form-help-block"><?php _e('Choose button width between <b>fixed width</b> or <b>100% width</b>.', 'socialconnect'); ?></p>
                        </div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label"><?php _e('Enable Debug', 'socialconnect'); ?></label>
                        <div class="uk-form-controls" style="margin-top: 5px;">
                            <label><input type="checkbox" <?php echo (osc_get_preference('debug', 'socialconnect')==1 ? 'checked="true"' : ''); ?> name="debug" value="1" /> <?php _e('Debug enabled', 'socialconnect'); ?></label>
                            <p class="uk-form-help-block"><?php _e('If you are having problems, it could help identify the root of the cause. Log files could grow very fast, remember to disable this option if not using it.', 'socialconnect'); ?></p>
                            <?php if($show_debug_no_file) { ?>
                                <div class="uk-badge uk-badge-danger"><?php echo sprintf(__('Debug file not found:  %s', 'socialconnect'), $filename); ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="uk-form-row">
                        <button type="submit" class="uk-button uk-button-primary"><?php echo osc_esc_html( __('Save changes', 'socialconnect') ); ?></button>
                    </div>
                </div>

                <div class="clear"></div>
                <hr class="uk-margin-large">



                <h2 class="uk-margin-large-top"><?php _e('Preview - Order buttons', 'socialconnect'); ?></h2>
                <div id="sc-preview" style="position: relative; top: -155px;"></div>
                <ul class="uk-sortable uk-list uk-float-left" data-uk-sortable>
                    <?php foreach($providers as $key => $v) { ?>
                    <li>
                        <input type="hidden" name="order[<?php echo $key; ?>]"/>
                        <?php sc_button($key, $key); ?></li>
                    <?php } ?>
                </ul>
                <p class="uk-float-left uk-margin-left uk-alert uk-display-inline-block"><?php _e('Simply drag and drop the button into the desired position. It’s that simple.', 'socialconnect'); ?>
                    <br><?php _e('Note: Only enabled networks will appear at frontend (login/register).', 'socialconnect'); ?>
                </p>
                <div class="clear"></div>
                <div class="uk-margin-top">
                    <button type="submit" class="uk-button uk-button-primary"><?php echo osc_esc_html( __('Save changes', 'socialconnect') ); ?></button>
                </div>
                <div class="clear"></div>
                <hr class="uk-margin-large">



                <h2 class="uk-margin-large-top"><?php _e('Social networks', 'socialconnect'); ?></h2>

                <div id="sc-facebook" style="position: relative; top: -55px;"></div>
                <div>
                    <fieldset>
                        <legend>Facebook</legend>
                        <div class="uk-display-inline uk-float-left">
                            <div class="uk-form-row">
                                <label class="uk-form-label"><?php _e('Enable Facebook login', 'socialconnect'); ?></label>
                                <div class="uk-form-controls" style="margin-top: 5px;">
                                    <label><input type="checkbox" <?php echo (osc_get_preference('enabled_fb', 'socialconnect')==1 ? 'checked="true"' : ''); ?> name="enabled_fb" value="1" /> <?php _e('Enabled', 'socialconnect'); ?></label>
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <div class="uk-form-label"><?php _e('Facebook App ID', 'socialconnect'); ?></div>
                                <div class="uk-form-controls"><input type="text" class="xlarge" name="fb_app_id" value="<?php echo osc_get_preference('fb_app_id', 'socialconnect'); ?>" /></div>
                            </div>
                            <div class="uk-form-row">
                                <div class="uk-form-label"><?php _e('Facebook App Secret', 'socialconnect'); ?></div>
                                <div class="uk-form-controls"><input type="text" class="xlarge" name="fb_app_secret" value="<?php echo osc_get_preference('fb_app_secret', 'socialconnect'); ?>" /></div>
                            </div>
                            <div class="uk-form-row">
                                <button type="submit" class="uk-button uk-button-primary"><?php echo osc_esc_html( __('Save changes', 'socialconnect') ); ?></button>
                                <a class="uk-button uk-button-danger" data-uk-modal="{target:'#sc-help-facebook'}"><i class="uk-icon-question-circle"></i>&nbsp;<?php _e('Help', 'socialconnect'); ?></a>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div id="sc-google" style="position: relative; top: -55px;"></div>
                <div class="uk-margin-large-top">
                    <fieldset>
                        <legend>Google</legend>

                        <div class="uk-display-inline uk-float-left">
                            <div class="uk-form-row">
                                <label class="uk-form-label"><?php _e('Enable Google login', 'socialconnect'); ?></label>
                                <div class="uk-form-controls" style="margin-top: 5px;">
                                    <label><input type="checkbox" <?php echo (osc_get_preference('enabled_google', 'socialconnect')==1 ? 'checked="true"' : ''); ?> name="enabled_google" value="1" /> <?php _e('Enabled', 'socialconnect'); ?></label>
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <div class="uk-form-label"><?php _e('Facebook App ID', 'socialconnect'); ?></div>
                                <div class="uk-form-controls"><input type="text" class="xlarge" name="google_app_id" value="<?php echo osc_get_preference('google_app_id', 'socialconnect'); ?>" /></div>
                            </div>
                            <div class="uk-form-row">
                                <div class="uk-form-label"><?php _e('Facebook App Secret', 'socialconnect'); ?></div>
                                <div class="uk-form-controls"><input type="text" class="xlarge" name="google_app_secret" value="<?php echo osc_get_preference('google_app_secret', 'socialconnect'); ?>" /></div>
                            </div>
                            <div class="uk-form-row">
                                <button type="submit" class="uk-button uk-button-primary"><?php echo osc_esc_html( __('Save changes', 'socialconnect') ); ?></button>
                                <a class="uk-button uk-button-danger" data-uk-modal="{target:'#sc-help-google'}"><i class="uk-icon-question-circle"></i>&nbsp;<?php _e('Help', 'socialconnect'); ?></a>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div id="sc-twitter" style="position: relative; top: -55px;"></div>
                <div class="uk-margin-large-top">
                    <fieldset>
                        <legend>Twitter</legend>

                        <div class="uk-display-inline uk-float-left">
                            <div class="uk-form-row">
                                <label class="uk-form-label"><?php _e('Enable Twitter login', 'socialconnect'); ?></label>
                                <div class="uk-form-controls" style="margin-top: 5px;">
                                    <label><input type="checkbox" <?php echo (osc_get_preference('enabled_twitter', 'socialconnect')==1 ? 'checked="true"' : ''); ?> name="enabled_twitter" value="1" /> <?php _e('Enabled', 'socialconnect'); ?></label>
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <div class="uk-form-label"><?php _e('Consumer Key (API Key)', 'socialconnect'); ?></div>
                                <div class="uk-form-controls"><input type="text" class="xlarge" name="twitter_app_id" value="<?php echo osc_get_preference('twitter_app_id', 'socialconnect'); ?>" /></div>
                            </div>
                            <div class="uk-form-row">
                                <div class="uk-form-label"><?php _e('Consumer Secret (API Secret)', 'socialconnect'); ?></div>
                                <div class="uk-form-controls"><input type="text" class="xlarge" name="twitter_app_secret" value="<?php echo osc_get_preference('twitter_app_secret', 'socialconnect'); ?>" /></div>
                            </div>
                            <div class="uk-form-row">
                                <button type="submit" class="uk-button uk-button-primary"><?php echo osc_esc_html( __('Save changes', 'socialconnect') ); ?></button>
                                <a class="uk-button uk-button-danger" data-uk-modal="{target:'#sc-help-twitter'}"><i class="uk-icon-question-circle"></i>&nbsp;<?php _e('Help', 'socialconnect'); ?></a>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div id="sc-linkedin" style="position: relative; top: -55px;"></div>
                <div class="uk-margin-large-top">
                    <fieldset>
                        <legend>Linkedin</legend>
                        <div class="uk-display-inline uk-float-left">
                            <div class="uk-form-row">
                                <label class="uk-form-label"><?php _e('Enable Linkedin login', 'socialconnect'); ?></label>
                                <div class="uk-form-controls" style="margin-top: 5px;">
                                    <label><input type="checkbox" <?php echo (osc_get_preference('enabled_linkedin', 'socialconnect')==1 ? 'checked="true"' : ''); ?> name="enabled_linkedin" value="1" /> <?php _e('Enabled', 'socialconnect'); ?></label>
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <div class="uk-form-label"><?php _e('Consumer Key (ID)', 'socialconnect'); ?></div>
                                <div class="uk-form-controls"><input type="text" name="linkedin_app_id" class="xlarge" value="<?php echo osc_get_preference('linkedin_app_id', 'socialconnect'); ?>" /></div>
                            </div>
                            <div class="uk-form-row">
                                <div class="uk-form-label"><?php _e('Consumer Secret (Secret)', 'socialconnect'); ?></div>
                                <div class="uk-form-controls"><input type="text" class="xlarge" name="linkedin_app_secret" value="<?php echo osc_get_preference('linkedin_app_secret', 'socialconnect'); ?>" /></div>
                            </div>
                            <div class="uk-form-row">
                                <button type="submit" class="uk-button uk-button-primary"><?php echo osc_esc_html( __('Save changes', 'socialconnect') ); ?></button>
                                <a class="uk-button uk-button-danger" data-uk-modal="{target:'#sc-help-linkedin'}"><i class="uk-icon-question-circle"></i>&nbsp;<?php _e('Help', 'socialconnect'); ?></a>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div id="sc-instagram" style="position: relative; top: -55px;"></div>
                <div class="uk-margin-large-top">
                    <fieldset>
                        <legend>Instagram</legend>
                        <div class="uk-display-inline uk-float-left">
                            <div class="uk-form-row">
                                <label class="uk-form-label"><?php _e('Enable Instagram login', 'socialconnect'); ?></label>
                                <div class="uk-form-controls" style="margin-top: 5px;">
                                    <label><input type="checkbox" <?php echo (osc_get_preference('enabled_instagram', 'socialconnect')==1 ? 'checked="true"' : ''); ?> name="enabled_instagram" value="1" /> <?php _e('Enabled', 'socialconnect'); ?></label>
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <div class="uk-form-label"><?php _e('Client Id (ID)', 'socialconnect'); ?></div>
                                <div class="uk-form-controls"><input type="text" name="instagram_app_id" class="xlarge" value="<?php echo osc_get_preference('instagram_app_id', 'socialconnect'); ?>" /></div>
                            </div>
                            <div class="uk-form-row">
                                <div class="uk-form-label"><?php _e('Client Secret (Secret)', 'socialconnect'); ?></div>
                                <div class="uk-form-controls"><input type="text" class="xlarge" name="instagram_app_secret" value="<?php echo osc_get_preference('instagram_app_secret', 'socialconnect'); ?>" /></div>
                            </div>
                            <div class="uk-form-row">
                                <button type="submit" class="uk-button uk-button-primary"><?php echo osc_esc_html( __('Save changes', 'socialconnect') ); ?></button>
                                <a class="uk-button uk-button-danger" data-uk-modal="{target:'#sc-help-instagram'}"><i class="uk-icon-question-circle"></i>&nbsp;<?php _e('Help', 'socialconnect'); ?></a>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div id="sc-live" style="position: relative; top: -55px;"></div>
                <div class="uk-margin-large-top">
                    <fieldset>
                        <legend>Windows Live</legend>
                        <div class="uk-display-inline uk-float-left">
                            <div class="uk-form-row">
                                <label class="uk-form-label"><?php _e('Enable Windows Live login', 'socialconnect'); ?></label>
                                <div class="uk-form-controls" style="margin-top: 5px;">
                                    <label><input type="checkbox" <?php echo (osc_get_preference('enabled_live', 'socialconnect')==1 ? 'checked="true"' : ''); ?> name="enabled_live" value="1" /> <?php _e('Enabled', 'socialconnect'); ?></label>
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <div class="uk-form-label"><?php _e('Application Id (ID)', 'socialconnect'); ?></div>
                                <div class="uk-form-controls"><input type="text" name="live_app_id" class="xlarge" value="<?php echo osc_get_preference('live_app_id', 'socialconnect'); ?>" /></div>
                            </div>
                            <div class="uk-form-row">
                                <div class="uk-form-label"><?php _e('Password', 'socialconnect'); ?></div>
                                <div class="uk-form-controls"><input type="text" class="xlarge" name="live_app_secret" value="<?php echo osc_get_preference('live_app_secret', 'socialconnect'); ?>" /></div>
                            </div>
                            <div class="uk-form-row">
                                <button type="submit" class="uk-button uk-button-primary"><?php echo osc_esc_html( __('Save changes', 'socialconnect') ); ?></button>
                                <a class="uk-button uk-button-danger" data-uk-modal="{target:'#sc-help-live'}"><i class="uk-icon-question-circle"></i>&nbsp;<?php _e('Help', 'socialconnect'); ?></a>
                            </div>
                        </div>
                    </fieldset>
                    <p class="uk-float-left uk-margin-left uk-alert uk-display-inline-block"><?php _e('Notice: SSL is required if you want to use Windows Live.', 'socialconnect');  ?></p>
                </div>
            </div>
        </form>
    </div>

    <style>
        .help-block h2 {
            font-size: 18px;
            font-weight: 500;
            color: #333;
            line-height: 1.3;
        }
        .help-block p {
            line-height: 3em;
        }
        .ui-dialog {
            margin-top:70px;
            margin-bottom: 50px;
        }
    </style>

<form id="sc-help-facebook" method="get" action="#" class="uk-modal has-form-actions uk-margin-top">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <div class="form-row">
            <div class="help-block fb">
                <h2>1. Login to Facebook Developers</h2>

                <p>Go to <a href="https://developers.facebook.com/" target="_blank" >Facebook Developers</a> and login with your account. Select <b>Add a New App</b> from the dropdown in the upper right:</p>

                <img style="border: 1px solid black;width:auto;" src="<?php echo osc_plugin_url('').'socialconnect/admin/images/1.png'; ?>"/>

                <h2>2. Name your application</h2>

                <p>Provide a <b>Display Name</b> and <b>Contact Email</b>.</p>

                <p>Select a <b>Category</b> and click <b>Create App ID</b>:</p>

                <img style="border: 1px solid black;width:auto; " src="<?php echo osc_plugin_url('').'socialconnect/admin/images/2.png'; ?>"/>

                <p>Complete the <b>Security Check</b>.</p>

                <h2>3. Enter your callback URL</h2>

                <p>On the <b>Product Setup</b> page that follows, click Get Started next to Facebook Login:</p>

                <img style="border: 1px solid black;width:auto; " src="<?php echo osc_plugin_url('').'socialconnect/admin/images/3.png'; ?>"/>

                <p>On the <b>Settings</b> page, scroll down to the <b>Client OAuth Settings</b> section and enter the following URL in the <b>Valid OAuth redirect URIs</b> field:</p>

                <p><code><?php echo osc_base_url(); ?></code></p>
                <br>

                <img style="border: 1px solid black;width:auto; " src="<?php echo osc_plugin_url('').'socialconnect/admin/images/4.png'; ?>"/>

                <p>Click <b>Save Changes</b></p>

                <h2>4. Get your App ID and App Secret</h2>

                <p>Select <b>Settings</b> in the left nav.</p>

                <p>Click <b>Show</b> to reveal the <code>App Secret</code>. (You may be required to re-enter your Facebook password.)</p>

                <img style="border: 1px solid black;width:auto; " src="<?php echo osc_plugin_url('').'socialconnect/admin/images/5.png'; ?>"/>

                <p>Save a copy of the <b>App ID</b> and <b>App Secret</b> to enter into the <b>Settings</b> page of your Osclass as described in <b>Step 7</b>.</p>

                <h2>5. Enter your Site URL</h2>

                <p>On the same <b>Basic Settings</b> page, scroll down and click <b>Add Platform</b>:</p>

                <img style="border: 1px solid black;width:auto; " src="<?php echo osc_plugin_url('').'socialconnect/admin/images/6.png'; ?>"/>

                <p>Select <b>Website</b> in the pop-up:</p>

                <img style="border: 1px solid black;width:auto;" src="<?php echo osc_plugin_url('').'socialconnect/admin/images/7.png'; ?>"/>

                <p>In the <b>Site URL</b> field, enter the following:</p>

                <p><code><?php echo osc_base_url(); ?></code></p>
                <br/>

                <img style="border: 1px solid black;width:auto;" src="<?php echo osc_plugin_url('').'socialconnect/admin/images/8.png'; ?>"/>

                <h2>6. Make your Facebook app public</h2>

                <p>Click <b>Yes</b> on the <b>App Review</b> page of your app to make it available to the public.</p>

                <img style="border: 1px solid black;width:auto; " src="<?php echo osc_plugin_url('').'socialconnect/admin/images/9.png'; ?>"/>

                <h2>7. Copy your App ID and App Secret into Osclass Social Connect</h2>

                <p>Login to the Osclass Dashboard and select Social Connect > Settings in the left navigation.</p>

                <p>Copy the <b>App ID</b> and <b>App Secret</b> from the Settings of your app on Facebook into the fields on this page on Osclass Social Connect:</p>

                <img style="border: 1px solid black;width:auto;" src="<?php echo osc_plugin_url('').'socialconnect/admin/images/10.png'; ?>"/>

                <p>Click <b>Save changes</b>.</p>
            </div>
        </div>
    </div>
</form>


<form id="sc-help-google" method="get" action="#" class="uk-modal has-form-actions uk-margin-top">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <div class="form-row">


            <div class="help-block gp">
                <h2>1. Access the Google API Manager</h2>

                <p>While logged in to your Google account, go to the <a target="_blank" href="https://console.developers.google.com/projectselector/apis/credentials">API Manager</a>.</p>

                <h2>2. Create Your New App</h2>

                <p>To create your new app, navigate to <b>Credentials</b> using the left-hand menu:</p>

                <img style="border: 1px solid black;width:auto; " src="<?php echo osc_plugin_url('').'socialconnect/admin/images/g_1.png'; ?>"/>

                <p>While you are on the <b>Credentials</b> page, click on <b>Create a project</b>.</p>

                <p>In the dialog box that appears, provide a Project name and click <b>Create</b>:</p>

                <img style="border: 1px solid black;width:auto; " src="<?php echo osc_plugin_url('').'socialconnect/admin/images/g_2.png'; ?>"/>

                <p>Google will take a moment to create your project. When the process completes, Google will prompt you to create the credentials you need.</p>

                <img style="border: 1px solid black;width:auto; " src="<?php echo osc_plugin_url('').'socialconnect/admin/images/g_3.png'; ?>"/>

                <p>Click on <b>Create credentials</b> to display a pop-up menu listing the types of credentials you can create. Select the <b>OAuth client ID</b> option.</p>

                <h2>3. Set Up the Consent Screen</h2>

                <p>At this point, Google will display a warning banner that says, "To create an OAuth client ID, you must first set a product name on the consent screen." Click <b>Configure consent screen</b> to begin this process.</p>

                <img style="border: 1px solid black;width:auto; " src="<?php echo osc_plugin_url('').'socialconnect/admin/images/g_4.png'; ?>"/>

                <p>Provide a <b>Product Name</b> that will be shown to users when they log in through Google.</p>

                <img style="border: 1px solid black;width:auto; " src="<?php echo osc_plugin_url('').'socialconnect/admin/images/g_5.png'; ?>"/>

                <p>Click <b>Save</b>:</p>

                <h2>4. Create your Client Id and Client Secret</h2>

                <p>At this point, you will be prompted to provide additional information about your app.</p>

                <img style="border: 1px solid black;width:auto; " src="<?php echo osc_plugin_url('').'socialconnect/admin/images/g_6.png'; ?>"/>

                <p>Select <b>Web application</b>, and provide a name for your app.</p>

                <p>Under <b>Restrictions</b>, enter the following information:</p>

                <ul>
                    <li style="line-height: 3em;"><b>Authorized JavaScript origins</b>: <code><?php echo htmlentities(osc_base_url()); ?></code></li>
                    <li style="line-height: 3em;"><b>Authorized redirect URI</b>: <code><?php echo htmlentities(osc_route_url('sc-endpoint') . '?hauth.done=Google'); ?></code></li>
                </ul>


                <p>Click <b>Create</b>. Your <code>Client Id</code> and <code>Client Secret</code> will be displayed:</p>

                <img style="border: 1px solid black;width:auto; " src="<?php echo osc_plugin_url('').'socialconnect/admin/images/g_7.png'; ?>"/>

                <p>Save your <code>Client Id</code> and <code>Client Secret</code> to enter into the connection settings in Osclass in Step 7.</p>

                <h2>6. Enable the Google+ API</h2>

                <p>Navigate to the <b>Library</b> page of the API Manager.</p>

                <p>Select <b>Google+ API</b> from the list of APIs:</p>

                <img style="border: 1px solid black;width:auto; " src="<?php echo osc_plugin_url('').'socialconnect/admin/images/g_8.png'; ?>"/>

                <p>On the <b>Google+ API</b> page, click <b>Enable</b>.</p>

                <img style="border: 1px solid black;width:auto; " src="<?php echo osc_plugin_url('').'socialconnect/admin/images/g_9.png'; ?>"/>

                <h2>7. Enable the Connection</h2>

                <p>Login to the Osclass Dashboard and select Social Connect > Settings in the left navigation.</p>

                <p>Copy the <b>Client Id</b> and <b>Client Secret</b> from the Credentials page of your project in the Google API.</p>

                <img style="border: 1px solid black;width:auto; " src="<?php echo osc_plugin_url('').'socialconnect/admin/images/g_10.png'; ?>"/>

                <p>Click <b>Save changes</b>.</p>
            </div>
        </div>
    </div>
</form>

<form id="sc-help-twitter" method="get" action="#" class="uk-modal has-form-actions uk-margin-top">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <div class="form-row">
            <h2>1. Access the Twitter developers</h2>
            <p><?php printf(__('Go to <a href="%s">%s</a> and create a new application.', 'socialconnect'), 'https://dev.twitter.com/apps', 'https://dev.twitter.com/apps'); ?></p>
            <h2>2. Create Your New App</h2>
            <p><?php _e('Fill out any required fields such as the application name and description.', 'socialconnect'); ?></p>
            <p><?php printf(__('Put your website (%s) domain in the Website field.', 'socialconnect'), osc_base_url()); ?></p>
            <p><?php printf(__('Provide this URL as the Callback URL for your application: %s', 'socialconnect'), osc_route_url('sc-endpoint') . '?hauth.done=Twitter' ); ?></p>
            <h2>3. Enable the Connection</h2>
            <p>Login to the Osclass Dashboard and select Social Connect > Settings in the left navigation.</p>
            <p>Copy the <b>Consumer Key</b> and <b>Consumer Secret</b>.</p>
        </div>
    </div>
</form>

<form id="sc-help-linkedin" method="get" action="#" class="uk-modal has-form-actions uk-margin-top">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <div class="form-row">
            <h2>1. Access Linkedin developers website</h2>
            <p>Go to <a href="https://www.linkedin.com/secure/developer" target="_blank">https://www.linkedin.com/secure/developer</a> (or <a href="https://www.linkedin.com/secure/developer?newapp=">https://www.linkedin.com/secure/developer?newapp=</a>) and create a new application.</p>
            <h2>2. Create Your New App</h2>
            <p><?php _e('Fill out any required fields such as the application name and description.', 'socialconnect'); ?></p>
            <p>Put your website domain in the Integration URL.</p>
            <p><code><?php echo osc_base_url(); ?></code></p>
            <p>Put the following url at OAuth Redirect URL.</p>
            <p><code><?php echo osc_route_url('sc-endpoint') . '?hauth.done=Linkedin' ?></code></p>
            <h2>3. Enable the Connection</h2>
            <p>Login to the Osclass Dashboard and select Social Connect > Settings in the left navigation.</p>
            <p>Copy the <b>Consumer Key</b> and <b>Consumer Secret</b>.</p>
        </div>
    </div>
</form>

<form id="sc-help-instagram" method="get" action="#" class="uk-modal has-form-actions uk-margin-top">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <div class="form-row">
            <h2>1. Access Instagram API Platform</h2>
            <p>Go to <a href="https://instagram.com/developer/clients/manage/" target="_blank">instagram.com/developer/clients/manage/</a> and create a new application (Register new Client).</p>
            <h2>2. Create Your New App</h2>
            <p>Fill out any required fields such as the application name and description.</p>
            <p>Provide this URL as the OAuth redirect_uri (callback url) for your application:</p>
            <p><code><?php echo osc_route_url('sc-endpoint') . '?hauth.done=Instagram' ?></code></p>
            <h2>3. Enable the Connection</h2>
            <p>Login to the Osclass Dashboard and select Social Connect > Settings in the left navigation.</p>
            <p>Copy the <b>Client ID</b> and <b>Client Secret</b>.</p>
        </div>
    </div>
</form>

<form id="sc-help-live" method="get" action="#" class="uk-modal has-form-actions uk-margin-top">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <div class="form-row">
            <h2>1. Access Microsoft Live Platform</h2>
            <p>Go to <a href="https://account.live.com/developers/applications/index" target="_blank">https://account.live.com/developers/applications/index</a> and create a new application (Add an App).</p>
            <h2>2. Create Your New App</h2>
            <p>Fill out any required fields such as the application name.</p>
            <p>Add a new Platform, type 'Web'</p>
            <p>Provide this URL as the Redirect url for your application ('Allow Implicit Flow' must be checked):</p>
            <p><code><?php echo osc_route_url('sc-live'); ?></code></p>
            <p>Generate a new password by clicking 'Generate new Password' button.</p>
            <h2>3. Enable the Connection</h2>
            <p>Login to the Osclass Dashboard and select Social Connect > Settings in the left navigation.</p>
            <p>Copy the <b>Application ID</b> and <b>Password</b>.</p>
        </div>
    </div>
</form>


<script type="text/javascript" >
    $(document).ready(function(){
        <?php foreach($providers as $key => $provider) { ?>
        $("#dialog-<?php echo $key; ?>").dialog({
            autoOpen: false,
            modal: true,
            width: 900,
            height: 650,
            title: '<?php echo osc_esc_js( sprintf(__('How to configure %s login', 'socialconnect'), $provider) ); ?>'
        });
        <?php }; ?>
    });
</script>