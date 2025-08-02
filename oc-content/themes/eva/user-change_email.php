<?php
 		   /*
 * Copyright 2018 osclass-pro.com
 *
 * You shall not distribute this theme and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
osc_enqueue_script('jquery');
osc_enqueue_script('jquery-ui');
osc_enqueue_script('select');
osc_enqueue_script('owl');
osc_enqueue_script('main');
osc_enqueue_script('date');
osc_enqueue_script('jquery-validate');
?>
<!DOCTYPE html>
<html lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
    <head>
        <?php osc_current_web_theme_path('head.php'); ?>
        <meta name="robots" content="noindex, nofollow" />
        <meta name="googlebot" content="noindex, nofollow" />
        <script type="text/javascript">
            $(document).ready(function() {
                $('form#change-email').validate({
                    rules: {
                        new_email: {
                            required: true,
                            email: true
                        }
                    },
                    messages: {
                        new_email: {
                            required: '<?php echo osc_esc_js(__("Email: this field is required", "eva")); ?>.',
                            email: '<?php echo osc_esc_js(__("Invalid email address", "eva")); ?>.'
                        }
                    },
                    errorLabelContainer: "#error_list",
                    wrapper: "li",
                    invalidHandler: function(form, validator) {
                        $('html,body').animate({ scrollTop: $('#error_list').offset().top }, { duration: 250, easing: 'swing'});
                    },
                    submitHandler: function(form){
                        $('button[type=submit], input[type=submit]').attr('disabled', 'disabled');
                        form.submit();
                    }
                });
            });
        </script>
    </head>
<body>
        <?php osc_current_web_theme_path('header.php'); ?>
		<div class="forcemessages-inline">
    <?php osc_show_flash_message(); ?>
</div>

            <!-- content -->
<div class="col-wrp">
						<div class="col-left">
                        <div class="left-menu">
                            <div class="profile-demo">
                                <img src="<?php echo osc_current_web_theme_url('img/profile.jpg'); ?>" alt="img">
                                <strong class="profile-demo__title"><?php _e('User account manager', 'eva'); ?></strong>
                                <a href="<?php echo osc_user_profile_url(); ?>"><strong><?php echo osc_logged_user_name(); ?></strong></a>
                            </div>
                            <ul>
<?php echo osc_private_user_menu(get_user_menu()); ?>
                            </ul>
                        </div>
                    </div>
<div class="col-main">
				                                     <h2 class="page-title">
                                                <?php _e('Change your e-mail', 'eva'); ?>
                                     </h2>
                                        <div id="error_list"></div>
                                            <form id="change-email" action="<?php echo osc_base_url(true); ?>" method="post" class="form">
                                                <input type="hidden" name="page" value="user" />
                                                <input type="hidden" name="action" value="change_email_post" />
                                                <div class="inp-group">

                                                    <h4 class="inp-group__title"><?php _e('Current e-mail', 'eva'); ?>:
                                                    <?php echo osc_logged_user_email(); ?></h4>

                                                    </div>

<div class="inp-group">
												<div class="input-row">
												 <div class="input-col">
                                                   <h4 class="inp-group__title"><?php _e('New e-mail', 'eva'); ?> <span>*</span></h4>
                                                        <input type="text" name="new_email" id="new_email" value="" class="form-control" />
                                                </div></div>   </div>
                                               <div class="inp-group">
                                                        <button class="btn btn-primary" type="submit">
                                                            <?php _e('Update', 'eva'); ?>
                                                        </button>
                                                </div> 
                                            </form>
                                    </div>
                                </div>
                            </div>
                        </div>
            <!-- content -->
        </div>
        <?php osc_current_web_theme_path('footer.php'); ?>
    </body>
</html>