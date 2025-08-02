<?php

$image_dir = osc_base_path().'oc-content/themes/eva/img/main/*';
$images = glob($image_dir);
foreach($images as $image){$img = basename($image);} 
?>
<!-- container -->
<div class="wrapper">
<?php if ( OSC_DEBUG || OSC_DEBUG_DB ) { ?>
  <div id="maintenance"><?php _e('You have enabled DEBUG MODE, autocomplete for locations will not work! Disable it in your config.php.', 'eva'); ?></div>
<?php } ?>
        <div class="wrapper-in">
            <header class="header-page header-page--paralax-bg" style="<?php if( $img != '') {?>background-image:url(<?php echo osc_base_url(); ?>oc-content/themes/eva/img/main/<?php echo $img; ?>) ;<?php } ?> center top;">
                <div class="top-bar">
                    <div class="container">
                        <div class="top-bar__logo-wrp">
                            <a href="<?php echo osc_base_url();?>"><?php echo logo_header(); ?></a>
                        </div>
						<!-- Menu -->
						                    <div class="top-bar__left disleft">
                            <a href="/" class="short-search-trigger"><i class="search-ico"></i></a>
							                            <form class="nocsrf short-search-form" action="<?php echo osc_base_url(true); ?>" method="post" <?php /* onsubmit="javascript:return doSearch();"*/ ?>>
							    <input type="hidden" name="page" value="search"/>
                                <input type="text" name="sPattern" placeholder="<?php echo osc_esc_html(osc_get_preference('keyword_placeholder', 'eva')); ?>" class="input-search" id="search-example">
                                <input type="submit" value="" class="submit-search">
                            </form>
							</div>
						                        <div class="top-bar__action">
<?php if ( osc_count_web_enabled_locales() > 1) { ?>
                <?php osc_goto_first_locale() ; ?>
	 <div class="lang-list select-country select_font" id="select-country__wrap" >
		<form name="select_language" action="<?php echo osc_base_url(true);?>" method="post">
			<input type="hidden" name="page" value="language" />
		<select name="locale" id="select-country" >
			<?php while ( osc_has_web_enabled_locales() ) { ?>
				<option value="<?php echo osc_locale_code() ; ?>" <?php if(osc_locale_code() == osc_current_user_locale()){echo 'selected';} ?>><?php echo osc_locale_name() ; ?></option>
			<?php } ?>
		</select>
		</form>
	</div>
            <?php } ?>
			<?php if( osc_users_enabled() || ( !osc_users_enabled() && !osc_reg_user_post() )) { ?>	 
				 <a href="<?php echo osc_item_post_url_in_category(); ?>" class="btn-publish upcase"><strong><?php _e('Publish your ad', 'eva'); ?></strong></a>
				 <?php } ?>
				</div>
                        <nav class="heder_nav">
                            <ul class="upcase">
                                <li><a href="<?php echo osc_base_url(); ?>" <?php if(!Params::getParam('page')){echo 'class="active"';} ?>><strong><?php _e('Home', 'eva'); ?></strong></a></li>
								<?php if(osc_users_enabled()) { ?>
								<?php if( osc_is_web_user_logged_in() ) { ?>
                                <li><a href="<?php echo osc_user_profile_url(); ?>"><strong><?php _e('My account', 'eva'); ?></strong></a></li>
								<li><?php if(function_exists('im_messages')) { echo im_messages(); } ?></li>
			        <li><a href="<?php echo osc_user_logout_url(); ?>"><?php _e('Logout', 'eva'); ?></a></li>	
<?php } else { ?>									
                                <li><a href="<?php echo osc_user_login_url(); ?>" data-fancybox="modal2" data-src="#insign"><strong><?php _e('Sign in', 'eva'); ?></strong></a></li>
								<?php if(osc_user_registration_enabled()) { ?>
                                <li><a href="<?php echo osc_register_account_url(); ?>"><strong><?php _e('Sign up', 'eva'); ?></strong></a></li>
								  <?php } ?>
	 <?php } ?>
	 <?php } ?>
                            </ul>
                            <div class="mobile-menu-trigger">
                                <i></i>
                                <i></i>
                                <i></i>
                            </div>
                        </nav>
</div></div>
			<!--/.  Menu -->
			<div class="forcemessages-inline">
	<?php osc_show_flash_message(); ?>
</div>
<div class="header__ins">
                    <div class="container">
					<!--Header Text -->
                        <h1 class="upcase"><?php if( osc_get_preference('mainh1-evarevo', 'eva') != '') {
            echo osc_get_preference('mainh1-evarevo', 'eva');
        } ?></h1>
<p class="sub-h1-text"><?php if( osc_get_preference('maintext-evarevo', 'eva') != '') {?><?php echo osc_get_preference('maintext-evarevo', 'eva'); ?>
    <?php } ?></p>
	<!---/. Header Text -->
<?php osc_current_web_theme_path('templates/mainsearch/'.osc_get_preference('main-search', 'eva').'.php') ; ?>  
<!--Categories -->
<?php if( osc_get_preference('categoriesmain', 'eva') == 'enable') {?>
<div class="category-inline boxmi">
<?php $i = 1; while(osc_has_categories()){?>
<a href="<?php echo osc_search_category_url()?>" class="category-inline-item seq-1 maibox">
<span class="category-inline-item__ico-wrp">
<img src="<?php echo osc_current_web_theme_url('img/').osc_category_id().'.png'?>" alt="<?php echo osc_esc_html(osc_category_name()); ?>">
</span>
<span class="category-inline-item__title"><?php if(strlen(osc_category_name()) > 25){ echo mb_substr(osc_category_name(), 0, 23,'UTF-8').'...'; } else { echo osc_category_name(); } ?></span>
</a>
<?php $i++; } ?>
</div>
<?php } ?>
<!--/. Categories -->
</div>
</div>
</header>