<?php

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
    <div class="col-wrp">
        <div class="col-left">
            <div class="left-menu">
                <ul>
                    <?php echo osc_private_user_menu(get_user_menu()); ?>
                </ul>
            </div>
        </div>

        <div class="col-main">
            <div class="profile">
                <div class="profile__main">
                    <div class="profile__photo">
                        <img src="<?php echo osc_current_web_theme_url('img/profile.jpg'); ?>" alt="profile">
                    </div>

                    <div class="profile__desc">
                        <span class="profile__name"><?php echo osc_user_name(); ?></span>
                        <span class=""><?php if (function_exists('ur_button_stars')) {
                                            echo ur_button_stars($user_id = osc_user_id(), $user_email = osc_item_contact_email(), $item_id = osc_item_id());
                                        } ?></span>
                        <br>
                        <?php $user_vkid = osc_user_vkid(); ?>
                        <span class="profile__vk" style="color: <?php echo ($user_vkid != '') ? '#7962E6' : '#999'; ?>;">
                            <i class="mdi mdi-vk mdi-18px mdipad"></i>
                            <?php if ($user_vkid != '') { ?>
                                <a href="https://vk.com/<?php echo $user_vkid; ?>" target="_blank"><?php echo $user_vkid; ?></a>
                            <?php } else { ?>
                                <span>не указано</span>
                            <?php } ?>
                        </span><br>

                        <span class="profile__red-date"><i
                                class="mdi mdi-calendar-text mdi-24px mdipad"></i><?php echo _e('Register date', 'eva') . ': ' . osc_format_date(osc_user()['dt_reg_date']); ?></span><br>

                        <span class="inp-group__title"><?php echo osc_user_info(); ?></span>


                        <?php if ($location != '') { ?>
                            <p class="profile__adress"><i
                                    class="mdi mdi-map-marker mdi-18px mdipad"></i><?php echo $location; ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>

        </div>

        <div class="user_profile">
            <div class="user_profile_block eva-shadow">
                <span class="profile__name">Контакты</span>
                <div>
                    <span class="user_profile__title"><?php _e('E-mail', 'eva'); ?>:</span>
                    <span class="inp-group__title"><b><?php echo osc_user_email(); ?></b></span>
                </div>

                <div>
                    <span class="user_profile__title"><?php _e('Cell phone', 'eva'); ?>:</span>
                    <span class="inp-group__title"><b><?php echo osc_user_phone(); ?></b></span>
                </div>

                <div>
                    <span class="user_profile__title"><?php _e('Vkontakte', 'eva'); ?>:</span>
                    <span class="inp-group__title"><b><?php echo osc_user_vkid(); ?></b></span>
                </div>

                <div>
                    <span class="user_profile__title"><?php _e('Website', 'eva'); ?>:</span>
                    <span class="inp-group__title"><b><?php echo osc_user_website(); ?></b></span>
                </div>
            </div>

            <div class="user_profile_block eva-shadow">
                <span class="profile__name">Адрес</span>
                <div>
                    <span class="user_profile__title"><?php _e('Country', 'eva'); ?>:</span>
                    <span class="inp-group__title"><b><?php echo osc_user_country(); ?></b></span>
                </div>

                <div>
                    <span class="user_profile__title"><?php _e('Region', 'eva'); ?>:</span>
                    <span class="inp-group__title"><b><?php echo osc_user_region(); ?></b></span>
                </div>

                <div>
                    <span class="user_profile__title"><?php _e('City', 'eva'); ?>:</span>
                    <span class="inp-group__title"><b><?php echo osc_user_city(); ?></b></span>
                </div>

                <div>
                    <span class="user_profile__title"><?php _e('Address', 'eva'); ?>:</span>
                    <span class="inp-group__title"><b><?php echo osc_user_address(); ?></b></span>
                </div>

            </div>
        </div>

        <div class="inp-group__btn">
            <button class="btn btn-transparent" type="button" onclick="location.href='<?php echo osc_user_profile_url(); ?>'">
                <?php _e('Edit', 'eva'); ?>
            </button>
            <button class="btn btn-transparent" type="button" onclick="location.href='<?php echo osc_user_logout_url(); ?>'">
                <?php _e('Logout', 'eva'); ?>
            </button>
        </div>

        <div class="col-main">
            <h2 class="page-title">
                <?php _e('Listings', 'eva'); ?>
            </h2>

            <?php if (osc_count_items() == 0) { ?>
                <h3><?php _e('No listings have been added yet', 'eva'); ?></h3>

            <?php } else { ?>
                <section class="board-list board-list--ins">
                    <div class="list-item__inline">
                        <div class="list">
                            <?php while (osc_has_items()) { ?>
                                <div class="item-list-main">
                                    <div class="item-inline">
                                        <?php if (osc_images_enabled_at_items()) { ?>
                                            <?php if (osc_count_item_resources()) { ?>
                                                <a href="<?php echo osc_item_url(); ?>" class="item-inline__img-wrp">
                                                    <img src="<?php echo osc_resource_thumbnail_url(); ?>" alt="<?php echo osc_highlight(osc_item_title()); ?>">
                                                </a>
                                            <?php } else { ?>
                                                <a href="<?php echo osc_item_url(); ?>" class="item-inline__img-wrp">
                                                    <img src="<?php echo osc_current_web_theme_url('img/no_photo.gif'); ?>">
                                                <?php } ?>

                                                <span class="purchased"><?php echo osc_format_date(osc_item_pub_date()); ?></span>
                                                <div class="overlay"></div>
                                                </a>
                                            <?php } ?>
                                            <div class="item-inline__ins">
                                                <div class="item-inline__ins__in" id="<?php if (function_exists('upayments_get_class_color')) {
                                                                                            echo upayments_get_class_color(osc_item_id());
                                                                                        } ?>">
                                                    <div class="item-inline__desc">
                                                        <?php if (osc_get_preference('item-icon', 'eva') == 'enable') { ?>
                                                            <a href="<?php echo osc_item_url(); ?>" class="item-inline__cat">
                                                                <img src="<?php echo osc_current_web_theme_url('img/') . eva_category_root(osc_item_category_id()) . '.png'; ?>">
                                                            </a>
                                                        <?php } ?>
                                                        <a href="<?php echo osc_item_url(); ?>" class="item-inline__title"><?php echo osc_highlight(osc_item_title()); ?></a>
                                                        <div class="item-inline__text">
                                                            <p><?php echo osc_highlight(osc_item_description()); ?></p>
                                                        </div>
                                                        <span class="item-inline__place"><?php if (osc_item_city() != '') { ?><i class="mdi mdi-map-marker"></i><?php } ?> <?php echo osc_item_city(); ?></span>
                                                        <div class="item-inline__action">
                                                            <strong class="item-inline__price"><?php if (osc_price_enabled_at_items() && osc_item_category_price_enabled(osc_item_category_id())) {
                                                                                                    echo osc_item_formated_price();
                                                                                                } ?></strong>
                                                        </div>
                                                    </div>
                                                    <span class="item-inline__date">
                                                        <?php if (osc_item_is_active()) {
                                                            echo __('Active', 'eva');
                                                        } else {
                                                            echo __('Inactivated', 'eva');
                                                        }; ?>
                                                        <?php if (osc_item_is_premium()) {
                                                            echo __('Premium', 'eva');
                                                        }; ?>
                                                        <?php if (osc_item_is_spam()) {
                                                            echo __('Spam', 'eva');
                                                        }; ?>
                                                    </span>
                                                    <div class="item__link-wrp">
                                                        <a href="<?php echo osc_item_edit_url(); ?>" class="edit-link"><i class="edit-link-ico"></i><?php _e('Edit', 'eva'); ?></a>
                                                        <a onclick="javascript:return confirm('<?php echo osc_esc_js(__('This action can not be undone. Are you sure you want to continue?', 'eva')); ?>')" href="<?php echo osc_item_delete_url(); ?>" class="del-link">
                                                            <i class="del-link-ico"></i><?php _e('Delete', 'eva'); ?>
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
        </div>

        </section>
    </div>
<?php } ?>
<?php if (osc_list_total_pages() > 1) { ?>
    <div class="pagination">
        <?php echo osc_pagination_items(); ?>
    </div>
<?php } ?>
<!--  -->
</div>
</div>
</div>
</div>
<?php osc_current_web_theme_path('footer.php'); ?>
</body>

</html>