<?php
osc_enqueue_script('jquery');
osc_enqueue_script('jquery-ui');
osc_enqueue_script('fineuploader');
osc_enqueue_script('owl');
osc_enqueue_script('main');
osc_enqueue_script('select');
osc_enqueue_script('date');
osc_enqueue_script('jquery-validate');
osc_enqueue_script('rotate-js');

?>
<!DOCTYPE html>
<html lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
    <?php osc_current_web_theme_path('head.php'); ?>
    <meta name="robots" content="noindex, nofollow" />
    <meta name="googlebot" content="noindex, nofollow" />

    <!-- only item-post.php -->
    <?php ItemForm::location_javascript(); ?>
    <?php
    if(osc_images_enabled_at_items() && !eva_is_fineuploader()) {
        ItemForm::photos_javascript();
    }
    ?>
    <script type="text/javascript">
        function uniform_input_file(){
            photos_div = $('div.photos');
            $('div',photos_div).each(
                function(){
                    if( $(this).find('div.uploader').length == 0  ){
                        divid = $(this).attr('id');
                        if(divid != 'photos'){
                            divclass = $(this).hasClass('box');
                            if( !$(this).hasClass('box') & !$(this).hasClass('uploader') & !$(this).hasClass('row')){
                                $("div#"+$(this).attr('id')+" input:file").uniform({fileDefaultText: fileDefaultText,fileBtnText: fileBtnText});
                            }
                        }
                    }
                }
            );
        }

        <?php if(osc_locale_thousands_sep()!='' || osc_locale_dec_point() != '') { ?>
        $().ready(function(){
            $("#price").blur(function(event) {
                var price = $("#price").prop("value");
                <?php if(osc_locale_thousands_sep()!='') { ?>
                while(price.indexOf('<?php echo osc_esc_js(osc_locale_thousands_sep());  ?>')!=-1) {
                    price = price.replace('<?php echo osc_esc_js(osc_locale_thousands_sep());  ?>', '');
                }
                <?php }; ?>
                <?php if(osc_locale_dec_point()!='') { ?>
                var tmp = price.split('<?php echo osc_esc_js(osc_locale_dec_point())?>');
                if(tmp.length>2) {
                    price = tmp[0]+'<?php echo osc_esc_js(osc_locale_dec_point())?>'+tmp[1];
                }
                <?php }; ?>
                $("#price").prop("value", price);
            });
        });
        <?php } ?>
    </script>
    <!-- end only item-post.php -->
</head>
<body>
<?php osc_current_web_theme_path('header.php'); ?>

<div class="container">
    <div class="forcemessages-inline">
        <?php osc_show_flash_message(); ?>
    </div>
    <!-- content -->
<div class="publish">
    <form name="item" action="<?php echo osc_base_url(true);?>" class="form-publish" method="post" enctype="multipart/form-data">
        <h2 class="center"><?php _e('Publish a listing', 'eva'); ?></h2>
        <div class="item_box">
            <input type="hidden" name="action" value="item_add_post" />
            <input type="hidden" name="page" value="item" />
            
            <div class="inp-group">
                <h4 class="inp-group__title"><?php _e('Title', 'eva'); ?> <span>*</span></h4>
                <div class="inp-counter titledis">
                    <?php ItemForm::title_input('title', osc_current_user_locale(), osc_esc_html( eva_item_title() )); ?>
                    <span class="inp-counter__count" data-val="<?php echo osc_max_characters_per_title(); ?>"><?php echo osc_max_characters_per_title(); ?></span>
                </div>
            </div>
            
            <div class="inp-group">
                <h4 class="inp-group__title"><?php _e('Category', 'eva')?> <span>*</span></h4>
                <div class="input-row catpub">
                    <?php ItemForm::category_multiple_selects(null, null, __('Select a category', 'eva')); ?>
                </div>
            </div>
        </div>

        <div class="item_box">
            <div class="inp-group">
                <h4 class="inp-group__title"><?php _e('Description', 'eva'); ?> <span>*</span></h4>
                <div class="inp-counter titledis">
                    <?php ItemForm::description_textarea('description',osc_current_user_locale(), osc_esc_html( eva_item_description() )); ?>
                    <span class="inp-counter__count bottom-count" data-val="<?php echo osc_max_characters_per_description(); ?>"><?php echo osc_max_characters_per_description(); ?></span>
                </div> 
            </div>
                    
            <?php if( osc_images_enabled_at_items() ) { ?>
                <div class="inp-group">
                    <h4 class="inp-group__title plus__image"><?php _e('Add images','eva')?></h4>
                    <span class="inp-group__sub-title"><?php _e('You can upload up to', 'eva'); ?> <?php echo osc_max_images_per_item(); ?> <?php _e('pictures per listing', 'eva'); ?></span>
                    <span class="inp-group__sub-title"><?php _e('Max size', 'eva'); ?> <?php echo osc_max_size_kb(); ?> <?php _e('Kb for each image', 'eva'); ?></span>
                    <div class="load-img">
                        <?php if(osc_images_enabled_at_items()) {
                            if(eva_is_fineuploader()) {
                                ItemForm::ajax_photos();
                            }
                        } else { ?>      
                            <div id="photos" class="load-img upload-images">
                                <div class="row">
                                    <input type="file" name="photos[]" />
                                </div>
                            </div>
                            <a href="#" onclick="addNewPhoto(); uniform_input_file(); return false;"><?php _e('Add new photo', 'eva'); ?></a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="item_box">    
            <?php if(osc_get_preference('custom-fileds', 'eva') == 'top'){ ?>
                <div class="inp-group">
                    <div class="box">
                        <?php ItemForm::plugin_post_item(); ?>
                    </div> 
                </div>
            <?php } ?>
        </div>

        <div class="item_box"> 
            <?php if( osc_price_enabled_at_items() ) { ?>
                <div class="inp-group">
                    <h4 class="inp-group__title plus__price"><?php _e('Price', 'eva'); ?></h4>
                    <div class="inp-select">
                        <div class="form-group-sm">
                            <?php ItemForm::price_input_text(); ?>
                        </div>

                        <div class="select_currency">
                            <?php ItemForm::currency_select(); ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
                        
            <?php if(osc_get_preference('item-post-loc', 'eva') == 'enable'){ ?>
                <div class="inp-group">
                    <div class="input-row">
                              <div class="input-col">
                            <h4 class="inp-group__title"><?php _e('City', 'eva'); ?></h4>
                            <?php ItemForm::city_text2( osc_item()); ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
                              
            <?php if(osc_get_preference('custom-fileds', 'eva') == 'bottom'){ ?>
                <div class="inp-group">
                    <?php ItemForm::plugin_post_item(); ?>
                </div>
            <?php } ?>
                        
            <?php if( osc_recaptcha_items_enabled() ) {?>
                <script type="text/javascript">
                    var RecaptchaOptions = {
                        theme : 'clean'
                    };
                </script>

                <div class="inp-group">
                    <div class="captch" style="transform:scale(0.8);transform-origin:0 0">
                        <?php osc_show_recaptcha(); ?>
                    </div>
                </div>
            <?php }?>
            
            <?php if( function_exists( "MyHoneyPot" )) { ?>		
                <?php MyHoneyPot(); ?>		
            <?php } ?>  			
                        
            <div class="inp-group">
                <?php osc_run_hook('advcaptcha_hook_item'); ?>
                <button type="submit" class="btn btn-center upcase">
                    <?php _e('Publish', 'eva'); ?>
                </button>
            </div>
    </form>
</div></div></div>
    <!-- content -->
                    </div>
</div>
<?php osc_current_web_theme_path('footer.php'); ?>
	<script type="text/javascript">
$(document).ready(function(){  
    $('body').on('click', 'i.mdi-rotate-right', function(){
        var img = $(this).parents('.qq-upload-success').find('img'),
            imgName = img.attr('alt'),
            url = '<?php echo osc_base_url();?>/oc-content/themes/eva/ajax-img.php',
            angle = parseInt(img.attr('img-angle'));
			if(isNaN(angle)){angle = 0};
			 
        angle += 90;
        
        setTimeout(function(){
            img.rotate({ 
                animateTo: angle,
                duration: 1000,
                callback: function() {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {"do" : "img-rotate", "imgName" : imgName},
                        error: function(){},
                        success: function(data){}
                    });
                }
            });
        }, 500);
        
        img.attr('img-angle', angle);
    });
});
</script>


<script type="text/javascript">
                $(function() {
                    function log( message ) {
                        $( "<div/>" ).text( message ).prependTo( "#log" );
                        $( "#log" ).attr( "scrollTop", 0 );
                    }

                    $( "#sCity" ).autocomplete({
                        source: "<?php echo osc_base_url(true); ?>?page=ajax&action=location",
                        minLength: 2,
                        select: function( event, ui ) {
                            $("#sRegion").attr("value", ui.item.region);
                            $('input[name="cityId"]').val(ui.item.id);
                            $('input[name="region"]').val(ui.item.region);
                            log( ui.item ?
                                "<?php _e('Selected', 'eva'); ?>: " + ui.item.value + " aka " + ui.item.id :
                                "<?php _e('Nothing selected, input was', 'eva'); ?> " + this.value );
                        }
                    });
                });

                function checkEmptyCategories() {
                    var n = $("input[id*=cat]:checked").length;
                    if(n>0) {
                        return true;
                    } else {
                        return false;
                    }
                }
            </script>


</body>
</html>