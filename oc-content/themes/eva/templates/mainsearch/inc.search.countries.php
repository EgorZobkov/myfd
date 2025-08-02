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
		<div class="input-row">
                              <div class="input-3-col">
												<select name="sCategory" id="sCategory" class="form-select-2" data-placeholder="<?php echo osc_esc_html(__('Select a category...', 'eva')); ?>">
				<option value=""><?php _e('None', 'eva'); ?></option>
				<?php foreach (Category::newInstance()->toTree() as $category){ ?>
				<option value="<?php echo $category['pk_i_id']?>"><?php echo $category['s_name']?></option>
				<?php
					if(isset($category['categories']) && is_array($category['categories']) && osc_get_preference('subcategories', 'eva') == 'enable')
						CategoryForm::subcategory_select($category['categories'], null, __('Select a category...', 'eva'), 2);
				?>
				<?php } ?>
			</select>
            </div>
		<div class="input-3-col" id="regionChoose">
			<?php eva_country_select('form-select-2') ; ?>
		</div>
		<div class="input-3-col">
<div class="form-search-action">
<input type="text" name="sPattern" placeholder="<?php echo osc_esc_html(__(osc_get_preference('keyword_placeholder', 'eva'), 'eva')); ?>" class="input-search">
<input type="submit" value="" class="submit-search">
</div>
</div>
</div>
</form>