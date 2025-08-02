<?php
		   /*
 * Copyright 2018 osclass-pro.com
 *
 * You shall not distribute this theme and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
?>
<script type="text/javascript">
$(document).ready(function(){
    $("#btn_subscribe").click(function(){
        $.post('<?php echo osc_base_url(true); ?>', {email:$("#alert_email").val(), userid:$("#alert_userId").val(), alert:$("#alert").val(), page:"ajax", action:"alerts"}, 
            function(data){
                if(data==1) { alert('<?php echo osc_esc_js(__('You have sucessfully subscribed to the alert', 'eva')); ?>'); }
                else if(data==-1) { alert('<?php echo osc_esc_js(__('Invalid email address', 'eva')); ?>'); }
                else { alert('<?php echo osc_esc_js(__('There was a problem with the alert', 'eva')); ?>');
                };
        });
        return false;
    });

    var sQuery = '<?php echo osc_esc_js(AlertForm::default_email_text()); ?>';

    if($('input[name=alert_email]').val() == sQuery) {
        $('input[name=alert_email]').css('color', 'gray');
    }
    $('input[name=alert_email]').click(function(){
        if($('input[name=alert_email]').val() == sQuery) {
            $('input[name=alert_email]').val('');
            $('input[name=alert_email]').css('color', '');
        }
    });
    $('input[name=alert_email]').blur(function(){
        if($('input[name=alert_email]').val() == '') {
            $('input[name=alert_email]').val(sQuery);
            $('input[name=alert_email]').css('color', 'gray');
        }
    });
    $('input[name=alert_email]').keypress(function(){
        $('input[name=alert_email]').css('background','');
    })
});
</script>
<div class="subscribe">
        <div class="row center">
            <h4 class="subsribe__title text-center"><?php _e('Subscribe to this search', 'eva'); ?></h4>
            <p class="subscribe__info text-center"></p>
                <form action="<?php echo osc_base_url(true); ?>" method="post" name="sub_alert" id="sub_alert" class="subscribe__form">
                    <div class="form-block form-group">
                        <?php AlertForm::page_hidden(); ?>
                        <?php AlertForm::alert_hidden(); ?>

                        <?php if(osc_is_web_user_logged_in()) { ?>
                            <?php AlertForm::user_id_hidden(); ?>
                            <?php AlertForm::email_hidden(); ?>
                            <button type="submit" id="btn_subscribe" class="btn btn-primary"><?php _e('Subscribe', 'eva'); ?>!</button>

                        <?php } else { ?>
                            <?php AlertForm::user_id_hidden(); ?>
                            <?php AlertForm::email_text(); ?>
                            <button type="submit" id="btn_subscribe" class="btn btn-primary"><?php _e('Subscribe', 'eva'); ?>!</button>

                        <?php }; ?>
                    </div>
                </form>
        </div>
</div>
