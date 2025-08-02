<?php
		   /*
 * Copyright 2016 osclass-pro.com
 *
 * You shall not distribute this theme and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
?>

<div class="categories">
    <div class="container">
        <div class="row">
            <ul class="categories__list">
                <?php $i = 1; while(osc_has_categories()){?>
                <li class="categories__item menu_list categories__item-<?php echo $i?>">
                    <a href="<?php echo osc_search_category_url()?>" class="categoreis__link categoreis__link_menu">
                        <b class="icon icon-1"><img src="<?php echo osc_current_web_theme_url('img/').osc_category_id().'.png'?>" alt=""></b>
                        <span><?php if(strlen(osc_category_name()) > 25){ echo mb_substr(osc_category_name(), 0, 23,'UTF-8').'...'; } else { echo osc_category_name(); } ?></span>
                    </a>
                </li>
                <?php $i++; } ?>
            </ul>
        </div>
    </div>
</div>

