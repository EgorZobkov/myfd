<?php
 		   /*
 * Copyright 2018 osclass-pro.com and osclass-pro.ru
 *
 * You shall not distribute this theme and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
$user_keep = osc_user();
osc_enqueue_script('jquery');
osc_enqueue_script('jquery-ui');
osc_enqueue_script('select');
osc_enqueue_script('owl');
if( osc_get_preference('gallery', 'eva') == 'swiper') {
osc_enqueue_script('swiper');
} else {
osc_enqueue_script('bxslider');
}
osc_enqueue_script('photoswipe');
osc_enqueue_script('photoswipe-ui');
osc_enqueue_script('main');
osc_enqueue_script('jssocials');
osc_enqueue_script('date');
osc_enqueue_script('jquery-validate');
?>
<!DOCTYPE html>
<html lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
    <?php osc_current_web_theme_path('head.php'); ?>
    <meta name="robots" content="index, follow" />
    <meta name="googlebot" content="index, follow" />
</head>
    
<body>
    <?php osc_current_web_theme_path('header.php'); ?>
    <div class="forcemessages-inline">
        <?php osc_show_flash_message(); ?>
    </div>
<!-- content -->
<!-- new -->
	<div class="container col-wrp">
        <div class="col-main item-main">
            <div class="item-main-info">
                <div class="item-main-title">
                    <div class="item-main-sutitle">
				        <h1 class="item-ins-name"><?php echo osc_esc_html(osc_item_title()); ?></h1><strong class="item-ins__price"><?php if( osc_price_enabled_at_items() && osc_item_category_price_enabled() ) { echo osc_item_formated_price(); } ?></strong>
                    </div>
                </div>

				<div class="item-under-sutitle">
					<?php if( osc_get_preference('item-icon', 'eva') == 'enable') {?>
						<a href="<?php echo eva_item_category_url(osc_item_category_id()) ; ?>" class="small_icon">
							<span class="item-ins__cat"><i class="mdi mdi-bookmark mdi-24px"></i><?php echo osc_item_category(); ?></span>
						</a>
					<?php } ?><span class="item-ins__date"><i class="mdi mdi-calendar-text mdi-24px"></i><?php if ( osc_item_pub_date() != "" ) { ?><?php echo osc_format_date( osc_item_pub_date() );?><?php } ?></span>
                    
                    <span class="item-ins__view"><i class="mdi mdi-eye-off mdi-24px"></i><?php echo osc_item_views(); ?></span>
                </div>
                    
                <?php if( osc_images_enabled_at_items() ) { ?>
                    <?php if( osc_count_item_resources() > 0 ) { 
                        if( osc_get_preference('gallery', 'eva') == 'swiper') { ?>
                            <div class="swiper-container gallery-top">
                                <div class="swiper-wrapper picture"  itemscope itemtype="http://schema.org/ImageGallery">
                                    <?php for ( $i = 1; osc_has_item_resources(); $i++ ) { ?>
                                        <figure class="swipdis swiper-slide" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">																	
                                            <a href="<?php echo osc_resource_url() ; ?>" class="imgswipurl" itemprop="contentUrl" data-size="<?php echo osc_esc_html( osc_normal_dimensions() ); ?>" data-index="<?php echo $i ; ?>" >
                                                <img src="<?php echo osc_resource_preview_url(); ?>" class="imgswipdis" alt="<?php echo osc_esc_html(osc_item_title()); ?>" itemprop="thumbnail">
                                            </a>
                                        </figure>			                     
                                    <?php } ?> 
                                </div>
                            
                                <?php if( osc_count_item_resources() > 1 ) { ?>
                                    <div class="swiper-button-next swiper-button-dis"></div>
                                    <div class="swiper-button-prev swiper-button-dis"></div>
                                <?php } ?>
                            </div> 
                        <?php osc_reset_resources(); ?>

                    <?php if( osc_count_item_resources() > 1 ) { ?>
                        <div class="swiper-container gallery-thumbs">
                            <div class="swiper-wrapper">
                                <?php for( $i = 0; osc_has_item_resources(); $i++ ) { ?>
                                    <div class="swiper-slide slide_no" style="background-image:url(<?php echo osc_resource_thumbnail_url(); ?>)">
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                            			
                        <?php } else { ?>
    						<div class="slider bxslider picture" style="display:none" itemscope itemtype="http://schema.org/ImageGallery">
								<?php for ( $i = 0; osc_has_item_resources(); $i++ ) { ?>
									<div class="slider-item" class="photos">
										<figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                                            <a href="<?php echo osc_resource_url() ; ?>" itemprop="contentUrl" data-size="<?php echo osc_esc_html( osc_normal_dimensions() ); ?>" data-index="<?php echo $i ; ?>" >
                                                <img src="<?php echo osc_resource_preview_url(); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>" itemprop="thumbnail">
                                            </a>
								        </figure>								
                                    </div>				                     
                                <?php } ?> 
                            </div>   

                            <div class="slider-thumbnails"> 
                            </div>	
                        <?php } 
                    } 
                } ?>
            </div> 
              
            <aside class="col-right">
				<?php if(osc_get_preference('item-evarevo_image', 'eva') != ''){?>
                    <div class="sidead">
                        <?php echo osc_get_preference('item-evarevo_image', 'eva');?>
					</div>
                <?php } ?>	

                <div class="item-author">
					<div class="item-author__user">
                        <a href="<?php if(osc_item_user_id() != null){ ?><?php echo osc_user_public_profile_url( osc_item_user_id() ); ?><?php } ?>" class="item-author__photo"><img src="<?php echo osc_current_web_theme_url('img/profile.jpg'); ?>" alt="profile"></a>
                        <a href="<?php if(osc_item_user_id() != null){ ?><?php echo osc_user_public_profile_url( osc_item_user_id() ); ?><?php } ?>" class="item-author__name"><?php echo osc_item_contact_name(); ?></a>
                    </div>

				    <div class="item-author__details">
                        <?php  if(osc_item_show_email() ){?>
					        <span class="item-author__phone"><i class="mdi mdi-email mdi-24px mdipad"></i><?php echo osc_item_contact_email(); ?>
                            </span>
                        <?php } ?>

				        <?php
                            $location_array = array(osc_item_country(), osc_item_region(), osc_item_city(), osc_item_city_area(), osc_item_address());
                            $location_array = array_filter($location_array);
                            $item_loc = implode(', ', $location_array);
                        ?>

                        <?php if($item_loc <> '') { ?>
			                <p class="item-author__adress"><i class="mdi mdi-map-marker mdi-24px mdipad"></i><?php echo $item_loc; ?> </p>
                        <?php } ?>

		                <?php if(function_exists('im_contact_button')) { im_contact_button(); } ?>
			                <p></p>
                         <?php if(osc_item_user_id() != null){ ?><a href="<?php echo osc_user_public_profile_url( osc_item_user_id() ); ?>" class="btn-pink btn-full-width upcase"><strong><?php _e('Profile', 'eva'); ?></strong></a><?php } ?>
                    </div>
                </div>

                <div class="item-info">
                    <div id="nicedis"></div>

					<script>
                        $("#nicedis").jsSocials({
                        showLabel: false,
                        showCount: false,
                        shareIn: "popup",
                                shares: [{share: "facebook",
                            logo: "shared-fc"
                        },  {share:"twitter",
                        logo: "shared-tw"
                        },
                        {share:"googleplus",
                        logo: "shared-g"
                        },
                        {share:"linkedin",
                        logo: "shared-in"
                        },
                        {share:"pinterest",
                        logo: "shared-p"
                        }]
                            });
                    </script>

					<?php if(osc_is_web_user_logged_in() && osc_logged_user_id()==osc_item_user_id()) { ?>
		                <div class="sidebar__form" >
                            <div class="form-group">
                                <div class="row center sidebar_move">
                                    <a href="<?php echo osc_item_edit_url(); ?>" rel="nofollow" class="btn2"><?php _e('Edit item', 'eva'); ?></a>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <?php if( osc_get_preference('mark-as', 'eva') == 'enable') {?>
                            <div class="markform">
                                <form action="<?php echo osc_base_url(true); ?>" method="post" name="mask_as_form" id="mask_as_form">
                                    <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>" />
                                    <input type="hidden" name="as" value="spam" />
                                    <input type="hidden" name="action" value="mark" />
                                    <input type="hidden" name="page" value="item" />
                                    
                                    <select name="as" id="as" class="form-control" style="width: 100%">
                                        <option> <?php _e("Mark as...", 'eva'); ?></option>
                                        <option value="spam"><?php _e("Mark as spam", 'eva'); ?></option>
                                        <option value="badcat"><?php _e("Mark as misclassified", 'eva'); ?></option>
                                        <option value="repeated"><?php _e("Mark as duplicated", 'eva'); ?></option>
                                        <option value="expired"><?php _e("Mark as expired", 'eva'); ?></option>
                                        <option value="offensive"><?php _e("Mark as offensive", 'eva'); ?></option>
                                    </select>
                                </form>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
						 
				<?php if( osc_get_preference('useful', 'eva') == 'enable') {?>
                    <div class="info-b">
                        <h5><?php _e('Useful information', 'eva'); ?></h5>
                        <ul>
                        <li><?php _e('Avoid scams by acting locally or paying with PayPal', 'eva'); ?></li>
                        <li><?php _e('Never pay with Western Union, Moneygram or other anonymous payment services', 'eva'); ?></li>
                        <li><?php _e('Don\'t buy or sell outside of your country. Don\'t accept cashier cheques from outside your country', 'eva'); ?></li>
                        <li><?php _e('This site is never involved in any transaction, and does not handle payments, shipping, guarantee transactions, provide escrow services, or offer "buyer protection" or "seller certification"', 'eva'); ?></li>
                        </ul>
                    </div>
                <?php } ?>
               
            </aside>

			<?php if( osc_get_preference('useful', 'eva') == 'enable') {?>
                <div class="info-b">
                    <h5><?php _e('Useful information', 'eva'); ?></h5>
                    <ul>
                        <li><?php _e('Avoid scams by acting locally or paying with PayPal', 'eva'); ?></li>
                        <li><?php _e('Never pay with Western Union, Moneygram or other anonymous payment services', 'eva'); ?></li>
                        <li><?php _e('Don\'t buy or sell outside of your country. Don\'t accept cashier cheques from outside your country', 'eva'); ?></li>
                        <li><?php _e('This site is never involved in any transaction, and does not handle payments, shipping, guarantee transactions, provide escrow services, or offer "buyer protection" or "seller certification"', 'eva'); ?></li>
                    </ul>
                </div>
            <?php } ?>                
        </div>


        <div class="col-main item-main col-main_2">
            <div class="item-tabs">
                <div class="item-tab-control">
                    <a href="/" data-tab="1" class="active"><i class="mdi mdi-tooltip-text mdi-24px"></i><?php _e('Description', 'eva'); ?></a>
                    <a href="/" data-tab="2" class=""><i class="mdi mdi-tooltip-text2 mdi-24px"></i><?php _e('Характеристики', 'eva'); ?></a>
                </div>

                <div class="tab active" data-tab="1">
                    <div class="text">
                        <h3><?php _e('Description', 'eva'); ?></h3>
                        <?php echo osc_item_description(); ?>
                    </div>
                </div>

                <div class="tab" data-tab="2">
                    <div class="text">
                        <?php if( osc_count_item_meta() >= 1 ) { ?> 
                                <div class="meta_list">

                                    <?php while ( osc_has_item_meta() ) { ?>
                                        <?php if(osc_item_meta_value()!='') { ?>
                                            <div class="meta">
                                                        <div class="atr_name-2"><?php echo osc_item_meta_name(); ?></div> <div class="atr-value-2"><?php echo osc_item_meta_value(); ?></div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                        <?php } ?>
                    
                    
                        <?php osc_run_hook('item_detail', osc_item() ); ?>
                        <?php if( osc_get_preference('item-evarevo_desc', 'eva') != '') {?>
                            <div class="ads">
                                <div class="itemtextad">
                                    <?php echo osc_get_preference('item-evarevo_desc', 'eva'); ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>            
            </div>
		</div>


            <!-- Related items -->
            <?php if (function_exists('related_eva_start')) {related_eva_start();} ?>
                        <!-- Related items -->
                        <?php if( osc_get_preference('item-evarevo_desc2', 'eva') != '') {?>
                            <div class="ads">
                                <div class="container">
                                    <?php echo osc_get_preference('item-evarevo_desc2', 'eva'); ?>
                                </div>
                            </div>
                        <?php } ?>
        
</div></div>
    
    <?php osc_current_web_theme_path('footer.php'); ?>
	<!-- Root element of PhotoSwipe. Must have class pswp. -->
    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="pswp__bg"></div>
            <div class="pswp__scroll-wrap">
                <div class="pswp__container">
                    <div class="pswp__item"></div>
                    <div class="pswp__item"></div>
                    <div class="pswp__item"></div>
                </div>

                <div class="pswp__ui pswp__ui--hidden">
                    <div class="pswp__top-bar">
                        <div class="pswp__counter"></div>
                        <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                        <button class="pswp__button pswp__button--share" title="Share"></button>
                        <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                        <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                        <div class="pswp__preloader">
                            <div class="pswp__preloader__icn">
                                <div class="pswp__preloader__cut">
                                    <div class="pswp__preloader__donut"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                        <div class="pswp__share-tooltip"></div> 
                    </div>

                    <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                    </button>

                    <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                    </button>

                    <div class="pswp__caption">
                        <div class="pswp__caption__center"></div>
                    </div>
                </div>
            </div>
												
            <script text="text/javascript">
				<?php if( osc_get_preference('gallery', 'eva') == 'swiper') { ?>
                    $(document).ready(function(){
                    var galleryTop = new Swiper('.gallery-top', {
                        spaceBetween: 10,
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                    });
	                $(".gallery-thumbs .swiper-wrapper div:first-child").addClass("active");
	                <?php if( osc_count_item_resources() > 1 ) { ?>
                            var galleryThumbs = new Swiper('.gallery-thumbs', {
                            spaceBetween: 10,
                            centeredSlides: false,
                            slidesPerView: 5,
                            touchRatio: 0.2,
                            slideToClickedSlide: true,
                            });
                            $('.slide_no').each(function (i) {
                                $(this).click(function (e) {
                                    e.preventDefault();
                                    var thumb = i;
                                    galleryTop.slideTo( thumb,1000,false );
                                    $('.slide_no').removeClass('active');
                                    $(this).addClass('active');

                                });
                            });
                            galleryTop.controller.control = galleryThumbs;
                            galleryThumbs.controller.control = galleryTop;

                            <?php } ?>
                            });											
                                                                    
                                                                    <?php } else { ?>
                        $(document).ready(function(){
                            $('.slider').show().bxSlider({
                                preloadImages: 'all'
                            });
                            });
                            <?php } ?>
            </script>
                
            <script text="text/javascript">
            (function($) {
                var $pswp = $('.pswp')[0];
                var image = [];

                $('.picture').each( function() {
                    var $pic     = $(this),
                        getItems = function() {
                            var items = [];
                            $pic.find('a').each(function() {
                                var $href   = $(this).attr('href'),
                                    $size   = $(this).data('size').split('x'),
                                    $width  = $size[0],
                                    $height = $size[1];

                                var item = {
                                    src : $href,
                                    w   : $width,
                                    h   : $height
                                }

                                items.push(item);
                            });
                            return items;
                        }

                    var items = getItems();

                    $.each(items, function(index, value) {
                        image[index]     = new Image();
                        image[index].src = value['src'];
                    });

                    $pic.on('click', 'figure', function(event) {
                        event.preventDefault();
                        
                        var $index = $(this).index();
                        var options = {
                            index: $index,
                            bgOpacity: 0.7,
                            showHideOpacity: true
                        }

                        var lightBox = new PhotoSwipe($pswp, PhotoSwipeUI_Default, items, options);
                        lightBox.listen('gettingData', function (index, item) {

                    var img = new Image();
                    img.onload = function () {
                        item.w = this.width;
                        item.h = this.height;
                        lightBox.updateSize(true);
                    };
                    img.src = item.src;

                    });
                        lightBox.init();
                    });
                });
                })(jQuery);
            </script>

            <script text="text/javascript">
                var modal = document.getElementById('myModal');

                var modalbtn = document.getElementById("myBtn");

                var modalspan = document.getElementsByClassName("closemodal")[0];

                modalbtn.onclick = function() {
                    modal.style.display = "block";
                }

                modalspan.onclick = function() {
                    modal.style.display = "none";
                }

                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }
            </script>
            </div>
            </div>
</body>
</html>