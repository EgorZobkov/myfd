<?php
/*
* Copyright 2018 osclass-pro.com and osclass-pro.ru
*
* You shall not distribute this theme and any its files (except third-party libraries) to third parties.
* Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
*/
$sCategoryArray = osc_search_category_id(); 

$sCategory=false;

if($sCategoryArray){

$sCategory = $sCategoryArray['0'];

}
?>
<a href="/" class="btn-pink btn-full-width btn-show-filter mobile-show upcase" data-back-text="<?php _e('Close Filters', 'eva'); ?>"><?php _e('Filters', 'eva'); ?></a>
    <form action="<?php echo osc_base_url(true); ?>" method="get" onsubmit="return doSearch()" class="l-search nocsrf" id="searchformblock" role="form" >
        <input type="hidden" name="page" value="search" />
        <input type="hidden" name="sOrder" value="<?php echo osc_esc_html(osc_search_order()); ?>" />
        <input type="hidden" name="iOrderType" value="<?php $allowedTypesForSorting = Search::getAllowedTypesForSorting(); echo osc_esc_html($allowedTypesForSorting[osc_search_order_type()]); ?>" />

        <?php foreach(osc_search_user() as $userId) { ?>
            <input type="hidden" name="sUser[]" value="<?php echo osc_esc_html($userId); ?>" />
        <?php } ?>
		<input type="hidden" name="sCompany" value="<?php echo Params::getParam('sCompany'); ?>">
		<input type="hidden" id="sRegion" name="sRegion" value="" />
			<div class="inp-group">
                <h4 class="inp-group__title"><?php _e('Your search', 'eva'); ?></h4>
                <div class="input-search-wrp">
                    <input type="text" class="input" name="sPattern" id="query" placeholder="<?php echo osc_esc_html(osc_get_preference('keyword_placeholder', 'eva')); ?>" value="<?php echo osc_esc_html( osc_search_pattern() ); ?>">
                </div>
            </div>
  
            

            <div class="inp-group">
			    <h4 class="inp-group__title"><?php _e('Category', 'eva'); ?></h4>
				<?php 
					if(isset($sCategory)) {
                         $category = array("pk_i_id" => $sCategory);
	                } else {
		                if(osc_is_search_page()){
	                        $category = 'null';
		                } else {$category = array("pk_i_id" => '0');}
	                }
	                
                    eva_categories_select('sCategory', $category , __('Categories', 'eva')) ; ?>
                </div>
		                
                <?php { ?>
						 <div class="inp-group">
                                <h4 class="inp-group__title"><?php _e('City', 'eva'); ?></h4>
                                <label>
				            <input type="text" class="input" id="sCity" name="sCity" placeholder="<?php echo osc_esc_html(__('Type a city', 'eva')); ?>" value="<?php echo osc_esc_html( osc_search_city() ); ?>">
                         </label>
                            </div>
			<?php } ?>
                     
            <?php if( osc_price_enabled_at_items() ) { ?>
                <div class="range">
                        <h4 class="inp-group__title"><?php _e('Price', 'eva'); ?></h4>
						<div class="razd"></div>
                                <div class="slider"></div>
								    <div class="slider-bottom">
                                    <input type="text" id="priceMin" class="input input2" name="sPriceMin" placeholder="<?php echo osc_esc_html(__('Min', 'eva') ); ?>" value="">
                                    <input type="text" id="priceMax" class="input input3" name="sPriceMax" placeholder="<?php echo osc_esc_html(__('Max', 'eva') ) ; ?>" value="">
                                </div>

                </div>
            <?php } ?>
		<div class="inp-group">
		<?php if(osc_search_category_id()) {
                                osc_run_hook('search_form', osc_search_category_id());
                            } else {
                                osc_run_hook('search_form');
                            }?>
							</div>
							<?php if( osc_images_enabled_at_items() ) { ?>
							<div class="inp-group">
                                <h4 class="inp-group__title"><?php _e('Show only', 'eva'); ?></h4>
                                <div class="checkbox-wrp">
									<input type="checkbox" name="bPic" id="withPicture" value="1" <?php echo (osc_search_has_pic() ? 'checked="checked"' : ''); ?> />
                                    <label for="withPicture">
                                        <span><?php _e('listings with pictures', 'eva'); ?></span>
                                    </label>
                                </div>
                            </div>
							<?php } ?>
            <button type="submit" id="search-btn" class="btn-full-width searchbutton upcase"><?php _e('SEARCH', 'eva'); ?></button>
    </form>
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

<script>
      $('#sCategory').on('change', function() {
        $('#search-btn').click();
});
    </script>