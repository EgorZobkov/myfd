
<style>
    h2 {
        font-size: 18px;
        font-weight: 500;
        color: #333;
        line-height: 1.3;
    }
</style>

<h2>1. Login to Facebook Developers</h2>

<p>Go to <a href="https://developers.facebook.com/" target="_parent" >Facebook Developers</a> and login with your account. Select <b>Add a New App</b> from the dropdown in the upper right:</p>

<img style="border: 1px solid black;width:auto; max-width: 650px;" src="<?php echo osc_plugin_url('').'socialconnect/admin/images/1.png'; ?>"/>

<h2>2. Name your application</h2>

<p>Provide a <b>Display Name</b> and <b>Contact Email</b>.</p>

<p>Select a <b>Category</b> and click <b>Create App ID</b>:</p>

<img style="border: 1px solid black;width:auto; max-width: 650px;" src="<?php echo osc_plugin_url('').'socialconnect/admin/images/2.png'; ?>"/>

<p>Complete the <b>Security Check</b>.</p>

<h2>3. Enter your callback URL</h2>

<p>On the <b>Product Setup</b> page that follows, click Get Started next to Facebook Login:</p>

<img style="border: 1px solid black;width:auto; max-width: 650px;" src="<?php echo osc_plugin_url('').'socialconnect/admin/images/3.png'; ?>"/>

<p>On the <b>Settings</b> page, scroll down to the <b>Client OAuth Settings</b> section and enter the following URL in the <b>Valid OAuth redirect URIs</b> field:</p>

<p><code><?php echo osc_base_url(); ?></code></p>
<br>

<img style="border: 1px solid black;width:auto; max-width: 650px;" src="<?php echo osc_plugin_url('').'socialconnect/admin/images/4.png'; ?>"/>

<p>Click <b>Save Changes</b></p>

<h2>4. Get your App ID and App Secret</h2>

<p>Select <b>Settings</b> in the left nav.</p>

<p>Click <b>Show</b> to reveal the <code>App Secret</code>. (You may be required to re-enter your Facebook password.)</p>

<img style="border: 1px solid black;width:auto; max-width: 650px;" src="<?php echo osc_plugin_url('').'socialconnect/admin/images/5.png'; ?>"/>

<p>Save a copy of the <b>App ID</b> and <b>App Secret</b> to enter into the <b>Settings</b> page of your Osclass as described in <b>Step 7</b>.</p>

<h2>5. Enter your Site URL</h2>

<p>On the same <b>Basic Settings</b> page, scroll down and click <b>Add Platform</b>:</p>

<img style="border: 1px solid black;width:auto; max-width: 650px;" src="<?php echo osc_plugin_url('').'socialconnect/admin/images/6.png'; ?>"/>

<p>Select <b>Website</b> in the pop-up:</p>

<img style="border: 1px solid black;width:auto; max-width: 650px;" src="<?php echo osc_plugin_url('').'socialconnect/admin/images/7.png'; ?>"/>

<p>In the <b>Site URL</b> field, enter the following:</p>

<p><code><?php echo osc_base_url(); ?></code></p>
<br/>

<img style="border: 1px solid black;width:auto; max-width: 650px;" src="<?php echo osc_plugin_url('').'socialconnect/admin/images/8.png'; ?>"/>

<h2>6. Make your Facebook app public</h2>

<p>Click <b>Yes</b> on the <b>App Review</b> page of your app to make it available to the public.</p>

<img style="border: 1px solid black;width:auto; max-width: 650px;" src="<?php echo osc_plugin_url('').'socialconnect/admin/images/9.png'; ?>"/>

<h2>7. Copy your App ID and App Secret into Osclass Social Connect</h2>

<p>Login to the Osclass Dashboard and select Social Connect > Settings in the left navigation.</p>

<p>Copy the <b>App ID</b> and <b>App Secret</b> from the Settings of your app on Facebook into the fields on this page on Osclass Social Connect:</p>

<img style="border: 1px solid black;width:auto; max-width: 650px;" src="<?php echo osc_plugin_url('').'socialconnect/admin/images/10.png'; ?>"/>

<p>Click <b>Save changes</b>.</p>