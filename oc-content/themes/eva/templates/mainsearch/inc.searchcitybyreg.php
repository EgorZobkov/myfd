<?php
 		   /*
 * Copyright 2018 osclass-pro.com and osclass-pro.ru
 *
 * You shall not distribute this theme and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
$sCountry = Params::getParam('sCountry');
$sRegion = Params::getParam('sRegion');
$sCity = Params::getParam('sCity');
$path = false;
if(OC_ADMIN) {
$path='admin';
}
?>
	<form class="nocsrf form" action="<?php echo osc_base_url(true); ?>" method="post" <?php /* onsubmit="javascript:return doSearch();"*/ ?>>
		<input type="hidden" name="page" value="search"/>
		<div class="input-row here">
         <div class="input-4-col middlesearch">
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
	<div class="input-4-col middlesearch">
    <?php $aRegions = Region::newInstance()->listAll(); ?>
    <?php if(count($aRegions) > 0 ) { ?>
	<?php function cmp($a, $b) { return strcmp($a["s_name"], $b["s_name"]); } usort($aRegions, "cmp"); ?>	
    <div class="large-12 columns">
      <select name="sRegion" id="sRegion" class="form-select-2" data-placeholder="<?php echo osc_esc_html(__('Select a region...', 'eva')); ?>">
        <option value=""><?php _e('None', 'eva'); ?></option>
        <?php foreach($aRegions as $region) {  ?>
        <option value="<?php echo $region['pk_i_id'] ; ?>" <?php if (isset($sRegion) && $sRegion==$region['pk_i_id']){ echo "selected";}?>> <?php echo $region['s_name'] ; ?> </option>
        <?php } ?>
      </select>
    </div>
    <?php } ?>
</div>
<div class="input-4-col middlesearch">
      <?php
  if(isset($sCity)||isset($sRegion)){
	$aCityes = City::newInstance()->findByRegion($sRegion);  ?>
      <select name="sCity" id="sCity" class="form-select-2" data-placeholder="<?php echo osc_esc_html(__('Select a region first...', 'eva')); ?>">
        <option value=""><?php _e('None', 'eva'); ?></option>
        <?php foreach($aCityes as $c ) { ?>
        <option value="<?php echo $c['pk_i_id']; ?>" <?php if($sCity==$c['pk_i_id']){ echo "selected";}?>><?php echo $c['s_name']; ?></option>
        <?php } ?>
      </select>
      <?php } else { ?>
      <select style="display:none;" name="sCity" id="sCity" >
      </select>
      <?php } ?>
 </div>		
<div class="input-4-col middlesearch dislast">
<div class="form-search-action">
<input type="text" name="sPattern" placeholder="<?php echo osc_esc_html(__(osc_get_preference('keyword_placeholder', 'eva'), 'eva')); ?>" class="input-search">
<input type="submit" value="" class="submit-search">
</div>
</div>
		</div>
	</form>
<script>
$(document).ready(function() {    
$("body").on("change","#sRegion",function(){
            var pk_c_code = $(this).val();
            <?php if($path=="admin") { ?>
                var url = '<?php echo osc_admin_base_url(true)."?page=ajax&action=cities&regionId="; ?>' + pk_c_code;
            <?php } else { ?>
                var url = '<?php echo osc_base_url(true)."?page=ajax&action=cities&regionId="; ?>' + pk_c_code;
            <?php }; ?>
            var result = '';
            if(pk_c_code != '') {
				$("#sCity").show();
                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: 'json',
                    success: function(data){
                        var length = data.length;
                        if(length > 0) {
                            result += '<option selected value=""><?php _e('Select a city...', 'eva'); ?></option>';
                            for(key in data) {
                               result += '<option value="' + data[key].pk_i_id + '">' + data[key].s_name + '</option>';
                            }
                            $("#city").before('<select name="sRegion" id="sRegion" ></select>');
                            $("#city").remove();
                        } else {
                            result += '<option value=""><?php _e('No result', 'eva') ?></option>';
                             $("#sCity").before('<select name="sCity" id="sCity" ></select>');
                            $("#sCity").remove();
							$("#sCity").hide();
                        }
                        $("#sCity").html(result);
                    }
                 });
             } else {
               $("#sCity").hide();
             }
        });
		if( $("#sRegion").val() == '')  {
        $('#sCity').prop('disabled',true);
        }
$('#sRegion').change(function(){
if($(this).val() == '' ){
$('#sCity').prop('disabled',true);
}else{
$('#sCity').prop('disabled',false);
$("select[name='sCity']").data('placeholder', '<?php _e('Select a city...', 'eva'); ?>').select2();
}
 }) ;
});
 </script>