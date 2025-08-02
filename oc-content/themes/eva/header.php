<?php

$image_dir = osc_base_path() . 'oc-content/themes/eva/img/search/*';
$images = glob($image_dir);
foreach ($images as $image) {
	$img = basename($image);
}
?>
<!-- container -->
<div class="wrapper">
	<div class="wrapper-in">
		<header class="header-page header-page--ins">
			<div class="top-bar">
				<div class="container">
					<div class="top-bar__logo-wrp">
						<a href="<?php echo osc_base_url(); ?>"><?php echo logo_header(); ?></a>
					</div>
					<!-- Menu -->
					<div class="top-bar__left disleft">
						<a href="/" class="short-search-trigger"><i class="search-black-ico"></i></a>
						<form class="nocsrf short-search-form" action="<?php echo osc_base_url(true); ?>" method="post"
							<?php /* onsubmit="javascript:return doSearch();"*/ ?>>
							<input type="hidden" name="page" value="search" />
							<input type="text" name="sPattern"
								placeholder="<?php echo osc_esc_html(osc_get_preference('keyword_placeholder', 'eva')); ?>"
								class="input-search" id="search-example">
							<input type="submit" value="" class="submit-search">
						</form>
					</div>
					<div class="top-bar__action">
						<?php if (osc_count_web_enabled_locales() > 1) { ?>
							<?php osc_goto_first_locale(); ?>
							<div class="lang-list select-country select_font" id="select-country__wrap">
								<form name="select_language" action="<?php echo osc_base_url(true); ?>" method="post">
									<input type="hidden" name="page" value="language" />
									<select name="locale" id="select-country">
										<?php while (osc_has_web_enabled_locales()) { ?>
											<option value="<?php echo osc_locale_code(); ?>" <?php if (osc_locale_code() == osc_current_user_locale()) {
													echo 'selected';
												} ?>>
												<?php echo osc_locale_name(); ?></option>
										<?php } ?>
									</select>
								</form>
							</div>
						<?php } ?>
						<?php if (osc_users_enabled() || (!osc_users_enabled() && !osc_reg_user_post())) { ?>
							<a href="<?php echo osc_item_post_url_in_category(); ?>"
								class="btn-publish upcase"><strong><?php _e('Publish your ad', 'eva'); ?></strong></a>
						<?php } ?>
					</div>
					<nav class="heder_nav">
						<ul class="upcase">
							<li><a href="<?php echo osc_base_url(); ?>"><strong><?php _e('Home', 'eva'); ?></strong></a>
							</li>
							<?php if (osc_users_enabled()) { ?>
								<?php if (osc_is_web_user_logged_in()) { ?>
									<li><a href="<?php echo osc_user_profile_url(); ?>" <?php if (Params::getParam('page') == 'user') {
										   echo 'class="active"';
									   } ?>><strong><?php _e('My account', 'eva'); ?></strong></a></li>
									<li><?php if (function_exists('im_messages')) {
										echo im_messages();
									} ?></li>
									<li><a href="<?php echo osc_user_logout_url(); ?>"><?php _e('Logout', 'eva'); ?></a></li>
								<?php } else { ?>
									<li><a href="<?php echo osc_user_login_url(); ?>" <?php if (Params::getParam('page') == 'login') {
										   echo 'class="active"';
									   } ?>
											data-fancybox="modal2"
											data-src="#insign"><strong><?php _e('Sign in', 'eva'); ?></strong></a></li>
									<?php if (osc_user_registration_enabled()) { ?>
										<li><a href="<?php echo osc_register_account_url(); ?>" <?php if (Params::getParam('page') == 'register') {
											   echo 'class="active"';
										   } ?>><strong><?php _e('Sign up', 'eva'); ?></strong></a></li>
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
				</div>
			</div>
			<!--/.  Menu -->
			<?php
			if (osc_is_search_page() && osc_get_preference('search-image', 'eva') == 'enable') { ?>
				<div class="h-block h-block-paralax"
					style="<?php if ($img != '') { ?>background:url(<?php echo osc_base_url(); ?>oc-content/themes/eva/img/search/<?php echo $img; ?>) ;<?php } ?> center top;">
					<div class="container">
						<h1><?php echo search_title(); ?></h1>
					</div>
				</div>
			<?php } ?>
			<?php if (osc_is_search_page() && osc_get_preference('search-map', 'eva') == 'enable') { ?>
				<?php osc_current_web_theme_path('templates/map/search_map.php'); ?>
			<?php } ?>
			<?php
			if (osc_is_search_page() && osc_get_preference('search-image', 'eva') == 'disable') { ?>
				<div class="d-block">
					<div class="container">
						<h1><?php echo search_title(); ?></h1>
					</div>
				</div>
			<?php } ?>
		</header>
		<div
			class="container notmain <?php if (Params::getParam('page') == 'item' or Params::getParam('action') == 'pub_profile') {
				echo 'item-container';
			} ?>">
			<?php $breadcrumb = osc_breadcrumb('&raquo;', false);
			if ($breadcrumb != '') { ?>
				<?php echo $breadcrumb; ?>
			<?php } ?></div>