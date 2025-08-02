<?php

$locales = osc_get_locales();
$user = osc_user();

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
</head>

<body>
    <?php osc_current_web_theme_path('header.php'); ?>
    <div class="forcemessages-inline">
        <?php osc_show_flash_message(); ?>
    </div>
    <!-- content -->
     <div class="container">
    <div class="col-wrp_edit">
        <div class="col-main eva-shadow toppixel">

            <?php UserForm::location_javascript(); ?>
            <script type="text/javascript">
                $(document).ready(function() {
                    $("#delete_account").click(function() {
                        if (confirm("<?php _e('All your listings and alerts will be removed, this action can not be undone.', 'eva'); ?>")) {
                            window.location = '<?php echo osc_base_url(true) . '?page=user&action=delete&id=' . osc_user_id() . '&secret=' . $user['s_secret']; ?>';
                        } else {
                            return false;
                        }
                    });

                });
            </script>
            <form action="<?php echo osc_base_url(true); ?>" method="post" class="options-form">

                <?php echo osc_csrf_token_form(); ?>
                <input type="hidden" name="page" value="user" />
                <input type="hidden" name="action" value="profile_post" />

                <div class="inp-group">
                    <div class="input-row">
                        <div class="input-col">
                            <h4 class="inp-group__title"><?php _e('Name', 'eva'); ?></h4>

                            <?php UserForm::name_text(osc_user()); ?>
                        </div>
                    </div>
                    <div class="input-row">
                        <div class="input-col">
                            <h4 class="inp-group__title"><?php _e('E-mail', 'eva'); ?></h4>

                            <input id="s_email" type="text" name="s_email" class="form-control"
                                placeholder="<?php echo osc_user_email(); ?>">

                            <div class="email-actions">
                                <a href="<?php echo osc_change_user_email_url(); ?>">
                                    <?php _e('Modify e-mail', 'eva'); ?>
                                </a>
                                <a href="<?php echo osc_change_user_password_url(); ?>">
                                    <?php _e('Modify password', 'eva'); ?>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="input-row">
                        <div class="input-col">
                            <h4 class="inp-group__title"><?php _e('Vkontakte', 'eva'); ?></h4>

                            <div class="form-control imul">
                                <?php echo osc_user_vkid(); ?></div>

                            <div class="">
                            Для привязки VK пришлите в 
                            <a href="https://vk.com/myfdru?from=groups">сообщения сообщества</a> e-mail, который привязан к текущему аккаунту.
                            </div>
                        </div>
                    </div>



                    <div class="input-row">
                        <div class="input-col">
                            <h4 class="inp-group__title"><?php _e('Cell phone', 'eva'); ?></h4>
                            <?php UserForm::mobile_text(osc_user()); ?>
                        </div>
                    </div>



                    <div class="input-row">
                        <div class="input-col">
                            <h4 class="inp-group__title"><?php _e('Website', 'eva'); ?></h4>

                            <div class="select">
                                <?php UserForm::website_text(osc_user()); ?>
                                </select>
                            </div>
                        </div>

                    </div>

                </div>



                <div class="inp-group">

                    <div class="input-row">
                        <div class="input-col">
                            <h4 class="inp-group__title"><?php _e('Country', 'eva'); ?></h4>
                            <div class="select">
                                <?php UserForm::country_select(osc_get_countries(), osc_user()); ?>
                            </div>
                        </div>
                    </div>


                    <div class="input-row">
                        <div class="input-col">
                            <h4 class="inp-group__title"><?php _e('Region', 'eva'); ?></h4>
                            <div class="select">
                                <?php UserForm::region_select(osc_get_regions(), osc_user()); ?>
                            </div>
                        </div>
                    </div>

                    <div class="input-row">
                        <div class="input-col">
                            <h4 class="inp-group__title"><?php _e('City', 'eva'); ?></h4>
                            <div class="select">
                                <?php UserForm::city_select(osc_get_cities(), osc_user()); ?>
                            </div>
                        </div>
                    </div>

                    <div class="input-row">
                        <div class="input-col">
                            <h4 class="inp-group__title"><?php _e('Address', 'eva'); ?></h4>
                            <?php UserForm::address_text(osc_user()); ?>
                        </div>
                    </div>
                </div>



                <div class="inp-group">
                    <div class="input-row">
                        <div class="input-col">
                            <h4 class="inp-group__title"><?php _e('User Description', 'eva'); ?></h4>

                            <?php UserForm::multilanguage_info($locales, osc_user()); ?>
                        </div>
                    </div>

                    <button class="btn btn-primary" type="submit">
                        <?php _e('Update', 'eva'); ?>
                    </button>
                    <button class="btn btn-transparent" id="delete_account" type="button">
                        <i class="fa fa-close"></i>
                        <?php _e('Delete my account', 'eva'); ?>
                    </button>
                    <?php osc_run_hook('user_form'); ?>
                </div>
            </form>
        </div>
    </div>
     </div>
    </div>
    </div>
    <!-- content -->
    </div>
    <?php osc_current_web_theme_path('footer.php'); ?>
</body>

</html>