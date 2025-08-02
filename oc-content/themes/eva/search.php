<?php
/*
* Copyright 2018 osclass-pro.com
*
* You shall not distribute this theme and any its files (except third-party libraries) to third parties.
* Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
*/
osc_enqueue_script('jquery');
osc_enqueue_script('jquery-ui');
osc_enqueue_script('touch');
osc_enqueue_script('select');
osc_enqueue_script('owl');
osc_enqueue_script('scrollreveal');
osc_enqueue_script('main');
osc_enqueue_script('date');
osc_enqueue_script('jquery-validate');
$sCategoryArray = osc_search_category_id();
$sCategory = false;
if ($sCategoryArray) {
    $sCategory = $sCategoryArray['0'];
}
?>
<!DOCTYPE html>
<html lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">

<head>
    <?php osc_current_web_theme_path('head.php'); ?>
    <?php if (osc_count_items() == 0 || Params::getParam('iPage') > 0) { ?>
        <meta name="robots" content="noindex, nofollow" />
        <meta name="googlebot" content="noindex, nofollow" />
    <?php } else { ?>
        <meta name="robots" content="index, follow" />
        <meta name="googlebot" content="index, follow" />
    <?php } ?>
</head>

<body>
    <script>
        (function() {

            var config = {
                viewFactor: 0.15,
                duration: 800,
                distance: "0px",
                scale: 0.8,
            }

            window.sr = new ScrollReveal(config)
        })()
        $(document).ready(function() {
            var here = {
                origin: "top",
                distance: "24px",
                duration: 1500,
                scale: 1.05,
            }

            var intro = {
                origin: "bottom",
                distance: "64px",
            }

            var maibox = {
                viewOffset: {
                    top: 64
                }
            }

            sr.reveal(".boxmi .maibox", maibox)
            sr.reveal(".here ", here)
            sr.reveal(".item-wrp", intro)
            sr.reveal(".item-list-main", intro)
            sr.reveal(".btn-all-items", intro)
            sr.reveal(".seq-1", maibox, 200)


            var item = document.querySelector(".item-wrp")
            var item = document.querySelector(".item-list-main")
            var boxmi = document.querySelector(".boxmi")
        });
    </script>
    <style>
        .here,
        .boxmi,
        .item-wrap,
        .item-list-main {
            visibility: hidden;
        }
    </style>
    <?php osc_current_web_theme_path('header.php'); ?>
    <div class="forcemessages-inline">
        <?php osc_show_flash_message(); ?>
    </div>
    <div class="container">
        <div class="col-wrp">
            <aside class="col-left">
                <!-- Module Search -->
                <?php osc_current_web_theme_path('search_module.php'); ?>
                <!-- Alert -->
                <a href="/" class="btn-pink btn-full-width btn-show-subscribe mobile-show upcase" data-back2-text="<?php _e('Close subscription', 'eva'); ?>"><?php _e('Subscription', 'eva'); ?></a>
                <!-- <div class="subscription">
                    <?php osc_alert_form(); ?>
                </div> -->
            </aside>

            <div class="col-main">
                <div class="tags">
                    <?php $spubcat = get_categoriesHierarchy(); ?>
                    <?php if (!isset($spubcat[2]) && !isset($spubcat[1]) && isset($spubcat[0])) { ?>
                        <div class="tags">
                            <a href="<?php echo osc_search_url(); ?>" rel="nofollow" class="tag-link active"><?php echo osc_category_name(); ?><span class="tag-del"></span></a>
                            <?php foreach (get_subcategories() as $subcat) {
                                echo "<a class=\"tag-link\" href='" . $subcat["url"] . "'>" . $subcat["s_name"] . " <span class=\"tag-del\"></span></a>";
                            }
                            echo '</div>';
                        } elseif (!isset($spubcat[2]) && isset($spubcat[1]) && isset($spubcat[0])) { ?>
                            <div class="tags">
                                <a href="<?php echo eva_parentcategory_url(osc_category_id()); ?>" class="tag-link active"><?php echo osc_category_name(); ?><span class="tag-del"></span></a>
                                <?php foreach (get_subcategories() as $subcat) {
                                    echo "<a class=\"tag-link\" href='" . $subcat["url"] . "'>" . $subcat["s_name"] . " <span class=\"tag-del\"></span></a>";
                                }
                                echo '</div>';
                            } elseif (isset($spubcat[2]) && isset($spubcat[1]) && isset($spubcat[0])) { ?>
                                
                                <div class="tags">
                                    <a href="<?php echo eva_parentcategory_url(osc_category_id()); ?>" class="tag-link active"><?php echo osc_category_name(); ?><span class="tag-del"></span></a>
                                    <?php foreach (get_subcategories() as $subcat) {
                                        echo "<a class=\"tag-link\" href='" . $subcat["url"] . "'>" . $subcat["s_name"] . " <span class=\"tag-del\"></span></a>";
                                    }
                                    echo '</div>';
                                } else { ?>
                                <?php } ?>
                                </div>

                                <div class="sort-wrp">
                                    <div class="sort-type">
                                        <!-- <a href="#" class="sort-btn all <?php if (Params::getParam('sCompany') == '' or Params::getParam('sCompany') == null) { ?>active<?php } ?>"><?php _e('All', 'eva'); ?></a> -->
                                        <!-- <a href="#" class="sort-btn individual <?php if (Params::getParam('sCompany') == '0') { ?>active<?php } ?>"><?php _e('Individual', 'eva'); ?></a> -->
                                        <!-- <a href="#" class="sort-btn company <?php if (Params::getParam('sCompany') == '1') { ?>active<?php } ?>"><?php _e('Companies', 'eva'); ?></a> -->
                                        <select name="forma" onchange="location = this.value;">
                                            <?php $orders = osc_list_orders(); ?>
                                            <?php $i = 0; ?>
                                            <?php foreach ($orders as $label => $params) { ?>
                                                <?php $orderType = ($params['iOrderType'] == 'asc') ? '0' : '1'; ?>
                                                <?php if (osc_search_order() == $params['sOrder'] && osc_search_order_type() == $orderType) { ?>
                                                    <option selected value="<?php echo osc_update_search_url($params); ?>"><?php echo $label; ?></option>
                                                <?php } else { ?>
                                                    <option value="<?php echo osc_update_search_url($params); ?>"><?php echo $label; ?></option>
                                                <?php } ?>
                                                <?php $i++; ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="sort-view">
                                        <?php $default_view = osc_get_preference('defaultShowAs@all', 'eva'); ?>
                                        <div class="change-view">
                                            <?php $params1['sShowAs'] = 'gallery'; ?><a href="<?php echo osc_update_search_url($params1); ?>" class="change-view__table <?php if (Params::getParam('sShowAs') == null && $default_view == 'gallery' || Params::getParam('sShowAs') == 'gallery') {
                                                                                                                                                                            echo 'active';
                                                                                                                                                                        } ?>"></a>
                                            <?php $params1['sShowAs'] = 'list'; ?><a href="<?php echo osc_update_search_url($params1); ?>" class="change-view__inline <?php if (Params::getParam('sShowAs') == null && $default_view == 'list' || Params::getParam('sShowAs') == 'list') {
                                                                                                                                                                            echo 'active';
                                                                                                                                                                        } ?>"></a>
                                        </div>
                                    </div>
                                </div>
                                <?php if (eva_categories_text() == 'top' && osc_category_description($locale = "") != '') { ?>
                                    <div class="disbox">
                                        <?php echo osc_category_description($locale = ""); ?>
                                    </div><?php } ?>

                                <?php if (osc_get_preference('search-evarevo-top', 'eva') != '') { ?>
                                    <div class="ads">
                                        <div class="container">
                                            <?php echo osc_get_preference('search-evarevo-top', 'eva'); ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="board-list board-list--ins">
                                    <?php if (osc_count_items() == 0) { ?>
                                        <div class="list-item">
                                            <p class="empty"><?php printf(__('There are no results matching "%s"', 'eva'), osc_search_pattern()); ?></p>
                                        </div>
                                    <?php } else { ?>
                                        <div class="list-item">
                                            <?php require(eva_show_as() == 'list' ? 'search_list.php' : 'search_gallery.php'); ?>
                                        <?php } ?>
                                        <!--  -->
                                        </div>
                                        <?php if (osc_get_preference('search-evarevo_under', 'eva') != '') { ?>
                                            <div class="ads">
                                                <div class="container">
                                                    <?php echo osc_get_preference('search-evarevo_under', 'eva'); ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php if (osc_search_total_pages() > 1) { ?>
                            <div class="pagination">
                                <?php echo osc_search_pagination(); ?>
                            </div>
                        <?php } ?>
                        <?php if (eva_categories_text() == 'bottom' && osc_category_description($locale = "") != '') { ?>
                            <div class="disbox">
                                <?php echo osc_category_description($locale = ""); ?>
                            </div>
                        <?php } ?>
                </div>
                <?php osc_current_web_theme_path('footer.php'); ?>
                <script>
                    $(document).ready(function() {
                        $('.sort-type .all').click(function() {
                            $('[name=sCompany]').val('');
                            document.getElementById('searchformblock').submit();

                        });
                        $('.sort-type .individual').click(function() {
                            $('[name=sCompany]').val('0');
                            document.getElementById('searchformblock').submit();
                        });
                        $('.sort-type .company').click(function() {
                            $('[name=sCompany]').val('1');
                            document.getElementById('searchformblock').submit();
                        });
                    });
                </script>

</body>

</html>