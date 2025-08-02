<?php
 		   /*
 * Copyright 2018 osclass-pro.com and osclass-pro.ru
 *
 * You shall not distribute this theme and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
?>
<form class="nocsrf form" action="<?php echo osc_base_url(true); ?>" method="post" <?php /* onsubmit="javascript:return doSearch();"*/ ?>>
		<input type="hidden" name="page" value="search"/>
		<input type="hidden" id="sRegion" name="sRegion" value="" />
		<div class="input-row">
                              <div class="input-3-col">
												<select name="sCategory" id="sCategory" class="form-select-2" data-placeholder="<?php echo osc_esc_html(__('Select a category...', 'eva')); ?>">
				<option value=""><?php _e('None', 'eva'); ?></option>
				<?php foreach (Category::newInstance()->toTree() as $category){ ?>
				<option value="<?php echo $category['pk_i_id']?>"><?php echo $category['s_name']?></option>
				<?php
					if(isset($category['categories']) && is_array($category['categories']) && osc_get_preference('subcategories', 'eva') == 'enable')
						CategoryForm::subcategory_select($category['categories'], null, __('Select a category', 'eva'), 2);
				?>
				<?php } ?>
			</select>
            </div>
		<div class="input-3-col" id="regionChoose">
		         				<input type="text" class="input" id="sCity" name="sCity" class="form-select-2" placeholder="<?php echo osc_esc_html(__('Type a city', 'eva')); ?>" value="<?php echo osc_esc_html( osc_search_city() ); ?>">
		</div>
		<div class="input-3-col">
<div class="form-search-action">
<input type="text" name="sPattern" placeholder="<?php echo osc_esc_html(__(osc_get_preference('keyword_placeholder', 'eva'), 'eva')); ?>" class="input-search">
<input type="submit" value="" class="submit-search">
</div>
</div>
</div>
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
            </script>