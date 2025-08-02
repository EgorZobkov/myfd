
<style>
    .help-block h2 {
        font-size: 18px;
        font-weight: 500;
        color: #333;
        line-height: 1.3;
    }
    .help-block {
        display: none;
    }
    .help-block p {
        line-height: 3em;
    }
</style>
<h2><?php _e('Help', 'socialconnect'); ?></h2>
<div>
    <h3><?php _e('Add social buttons', 'socialconnect'); ?></h3>
    <p><?php _e('Once your plugin is configured you only need to add one line of code to your theme:', 'socialconnect'); ?></p>
    <p>user-login.php, user-register.php</p>
    <code><?php echo htmlentities('<?php osc_run_hook(\'sc_buttons\'); ?>'); ?></code>


    <h3><?php _e('Profile picture', 'socialconnect'); ?></h3>
    <p><?php _e('Some providers as Facebook, Twitter and Google+ provide a profile picture that you can use.', 'socialconnect'); ?></p>
    <p><?php _e('You can get the first imported profile picture using this function helper:', 'socialconnect'); ?></p>
    <p><code>sc_profile_picture( osc_user_id() )</code></p>
    <p><?php _e('Note, if there is not an imported profile picture, no image will be shown.', 'socialconnect'); ?></p>
    <p><?php _e('Note, latest imported image will be used.', 'socialconnect'); ?></p>


</div>
