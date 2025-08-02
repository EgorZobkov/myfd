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
		     <div class="container">		
        <meta name="robots" content="noindex, nofollow" />
        <meta name="googlebot" content="noindex, nofollow" />
    </head>
    <body>
        <?php osc_current_web_theme_path('header.php'); ?>
		<div class="col-md-6 col-md-offset-3">
            <h1 class="block-title publish account" style="text-align:center;font-size: 28px;padding-top:40px;"><?php _e('Page not found', 'eva'); ?></h1>
        </div>
		<div id="feedback">
		                     <div class="container">
                         <div class="authentication__form disbox">
    <p class="person__register"><?php _e("Let us help you, we have got a few tips for you to find it.", 'eva') ; ?></p>
 <p class="person__register">
            <?php _e("<strong>Search</strong> for it:", 'eva') ; ?>
			 </p>
            <form action="<?php echo osc_base_url(true) ; ?>" method="get" class="search">
                <input type="hidden" name="page" value="search" />
                    <input type="text" name="sPattern"  id="query" value="" />
                    <button type="submit" class="btn btn-center"><?php _e('Search', 'eva') ; ?></button>
            </form>
			<br>
<p class="person__register">
       <?php _e("<strong>Look</strong> for it in the most popular categories.", 'eva') ; ?>
 </p>
                <?php osc_goto_first_category() ; ?>
                <?php while ( osc_has_categories() ) { ?>
				<ul class="categoryside">
                        <li class="subcatside"><a class="<?php echo osc_category_slug() ; ?>" href="<?php echo osc_search_category_url() ; ?>"><?php echo osc_category_name() ; ?> <span class="views">(<?php echo osc_category_total_items() ; ?>)</span></a></li>
                        <?php if ( osc_count_subcategories() > 0 ) { ?>
                            <?php while ( osc_has_subcategories() ) { ?>
                                <?php if( osc_category_total_items() > 0 ) { ?>
                                    <li class="subcatside"><a class="<?php echo osc_category_slug() ; ?> mcolor" href="<?php echo osc_search_category_url() ; ?>"><?php echo osc_category_name() ; ?> <span class="views">(<?php echo osc_category_total_items() ; ?>)</span></a></li>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
						</ul>
                <?php } ?>
           </div> 
</div>
		</div></div></div></div></div>
        <?php osc_current_web_theme_path('footer.php'); ?>
    </body>
</html>