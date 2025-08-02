<?php
   /*
 * Copyright 2018 osclass-pro.com
 *
 * You shall not distribute this theme and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
osc_goto_first_category();
?>
    <footer class="footer-page">
        <div class="footer-main">
            <div class="container">
                <div class="footer-main__logo">
                <?php if( osc_get_preference('footer-logo', 'eva') == 'enable') { ?>
                    <a href="<?php echo osc_base_url(); ?>"><?php echo logo_header(); ?></a>
                <?php } ?>
                </div>          
                <div class="footer__contacts">
                <?php if( osc_get_preference('footer-categories', 'eva') == 'enable') { ?>
                <ul class="footer_list">
                    <?php while(osc_has_categories()){ ?>
                    <li class="list__item"><a href="<?php echo osc_search_category_url(); ?>" class="item__link"><?php if(strlen(osc_category_name()) > 25){ echo mb_substr(osc_category_name(), 0, 23,'UTF-8').'...'; } else { echo osc_category_name(); } ?></a></li>
                    <?php } ?>
                </ul>
                <?php } ?>
                </div>
            </div>
        </div>
        
        <div class="footer-widgets">
            <div class="container">
                <div class="footer-widgets__ins">
                    <article class="footer-widget">
                        <?php osc_show_widgets('footer1'); ?>
                    </article>
                    <article class="footer-widget">
                        <?php osc_show_widgets('footer2'); ?>
                    </article>
                    <article class="footer-widget">
                        <?php osc_show_widgets('footer3'); ?>
                    </article>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom__copyright">
                    <span>&copy;<?php echo date('Y'); ?>. <?php if(osc_get_preference('contact-copy', 'eva') != ''){ ?>
                    <?php echo osc_get_preference('contact-copy', 'eva'); ?>    
                    <?php } ?></span>      
                </div>
                <div class="footer-bottom__center">
                    <ul class="social-list">
                        <?php if( osc_get_preference('facebook-evarevo', 'eva') != '') { ?>
                            <li><a href="<?php echo osc_get_preference('facebook-evarevo', 'eva'); ?>" target="_blank" class="fc-link"><i class="mdi mdi-facebook"></i></a></li>
                        <?php } if( osc_get_preference('google-evarevo', 'eva') != '') { ?>
                            <li><a href="<?php echo osc_get_preference('google-evarevo', 'eva'); ?>" target="_blank" class="g-link"><i class="mdi mdi-google-plus"></i></a></li>
                        <?php } if( osc_get_preference('twitter-evarevo', 'eva') != '') { ?>
                            <li><a href="<?php echo osc_get_preference('twitter-evarevo', 'eva'); ?>" target="_blank" class="tw-ico"><i class="mdi mdi-twitter"></i></a></li>
                        <?php } if( osc_get_preference('vk-evarevo', 'eva') != '') { ?>
                            <li><a href="<?php echo osc_get_preference('vk-evarevo', 'eva'); ?>" target="_blank" class="vk-link"><i class="mdi mdi-vk"></i></a></li>
                        <?php } if( osc_get_preference('pinterest-evarevo', 'eva') != '') { ?>
                            <li><a href="<?php echo osc_get_preference('pinterest-evarevo', 'eva'); ?>" target="_blank" class="p-ico"><i class="mdi mdi-pinterest"></i></a></li>
                        <?php } if( osc_get_preference('in-evarevo', 'eva') != '') { ?>
                            <li><a href="<?php echo osc_get_preference('in-evarevo', 'eva'); ?>" target="_blank" class="in-ico"><i class="mdi mdi-instagram"></i></a></li>
                        <?php } if( osc_get_preference('odnoklassniki-evarevo', 'eva') != '') { ?>
                            <li><a href="<?php echo osc_get_preference('odnoklassniki-evarevo', 'eva'); ?>" target="_blank" class="ok-link"><i class="mdi mdi-odnoklassniki"></i></a></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="footer-bottom__text">
                    <?php if(osc_count_static_pages() > 0){ ?>
                    <?php osc_reset_static_pages(); ?>
                    <?php while(osc_has_static_pages()){ ?>
                        <span><a href="<?php echo osc_static_page_url(); ?>" title="<?php echo osc_esc_html(osc_static_page_title()); ?>"><?php echo osc_esc_html(osc_static_page_title()); ?></a> |  </span>
                    <?php } ?>
                    <?php } ?>
                    <span><a href="<?php echo osc_contact_url(); ?>" ><?php _e('Contact', 'eva'); ?></a></span>                    
                </div>
            </div>
        </div>

<?php osc_current_web_theme_path('mobile-menu.php'); ?>
    </footer>
