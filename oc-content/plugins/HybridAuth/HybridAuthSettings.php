<h2 class="render-title"><?php _e('HybridAuth Settings', 'HybridAuth'); ?></h2>
<form action="<?php echo osc_admin_render_plugin_url('hybridauth/HybridAuth.php'); ?>" method="post">
    <input type="hidden" name="action_specific" value="HybridAuth" />
	<fieldset>
        <div class="form-horizontal">
            
            
			<h2 class="render-title separate-top">Google</h2>
			<div class="form-row">
                <div class="form-label">Client Id</div>
                <div class="form-controls">
					<input type="text" class="xlarge" name="GoogleId" value="<?php echo osc_get_preference('GoogleId', 'HybridAuth'); ?>" placeholder="Client Id">
                </div>
            </div>
			<div class="form-row">
                <div class="form-label">Client Secret</div>
                <div class="form-controls">
					<input type="text" class="xlarge" name="GoogleSecrect" value="<?php echo osc_get_preference('GoogleSecrect', 'HybridAuth'); ?>" placeholder="Client Secret">
                </div>
            </div>
			<div class="form-row">
                <div class="form-label">Enabled</div>
                <div class="form-controls">
					<select name="GoogleEnabled">
                        <option value="1" <?php echo (osc_get_preference('GoogleEnabled', 'HybridAuth'))?'selected="selected"':''; ?>>Yes</option>
						<option value="0" <?php echo (!osc_get_preference('GoogleEnabled', 'HybridAuth'))?'selected="selected"':''; ?>>No</option>
                    </select>
                </div>
            </div>
			<h2 class="render-title separate-top">Facebook</h2>
			<div class="form-row">
                <div class="form-label">Id</div>
                <div class="form-controls">
					<input type="text" class="xlarge" name="FacebookId" value="<?php echo osc_get_preference('FacebookId', 'HybridAuth'); ?>" placeholder="Id">
                </div>
            </div>
			<div class="form-row">
                <div class="form-label">Secret</div>
                <div class="form-controls">
					<input type="text" class="xlarge" name="FacebookSecrect" value="<?php echo osc_get_preference('FacebookSecrect', 'HybridAuth'); ?>" placeholder="Secrect">
                </div>
            </div>
			<div class="form-row">
                <div class="form-label">Enabled</div>
                <div class="form-controls">
					<select name="FacebookEnabled">
                        <option value="1" <?php echo (osc_get_preference('FacebookEnabled', 'HybridAuth'))?'selected="selected"':''; ?>>Yes</option>
						<option value="0" <?php echo (!osc_get_preference('FacebookEnabled', 'HybridAuth'))?'selected="selected"':''; ?>>No</option>
                    </select>
                </div>
            </div>
			<h2 class="render-title separate-top">Twitter</h2>
			<div class="form-row">
                <div class="form-label">Consumer Key (API Key)</div>
                <div class="form-controls">
					<input type="text" class="xlarge" name="TwitterId" value="<?php echo osc_get_preference('TwitterId', 'HybridAuth'); ?>" placeholder="Consumer Key (API Key)">
                </div>
            </div>
			<div class="form-row">
                <div class="form-label">Consumer Secret (API Secret)</div>
                <div class="form-controls">
					<input type="text" class="xlarge" name="TwitterSecrect" value="<?php echo osc_get_preference('TwitterSecrect', 'HybridAuth'); ?>" placeholder="Consumer Secret (API Secret)">
                </div>
            </div>
			<div class="form-row">
                <div class="form-label">Enabled</div>
                <div class="form-controls">
					<select name="TwitterEnabled">
                        <option value="1" <?php echo (osc_get_preference('TwitterEnabled', 'HybridAuth'))?'selected="selected"':''; ?>>Yes</option>
						<option value="0" <?php echo (!osc_get_preference('TwitterEnabled', 'HybridAuth'))?'selected="selected"':''; ?>>No</option>
                    </select>
                </div>
            </div>
			<h2 class="render-title separate-top">Vkontakte</h2>
			<div class="form-row">
                <div class="form-label">ID</div>
                <div class="form-controls">
					<input type="text" class="xlarge" name="VkontakteId" value="<?php echo osc_get_preference('VkontakteId', 'HybridAuth'); ?>" placeholder="id">
                </div>
            </div>
			<div class="form-row">
                <div class="form-label">Secret</div>
                <div class="form-controls">
					<input type="text" class="xlarge" name="VkontakteSecrect" value="<?php echo osc_get_preference('VkontakteSecrect', 'HybridAuth'); ?>" placeholder="secret">
                </div>
            </div>
			<div class="form-row">
                <div class="form-label">Enabled</div>
                <div class="form-controls">
					<select name="VkontakteEnabled">
                        <option value="1" <?php echo (osc_get_preference('VkontakteEnabled', 'HybridAuth'))?'selected="selected"':''; ?>>Yes</option>
						<option value="0" <?php echo (!osc_get_preference('VkontakteEnabled', 'HybridAuth'))?'selected="selected"':''; ?>>No</option>
                    </select>
                </div>
            </div>
            
            
            	<h2 class="render-title separate-top">Odnoklassniki</h2>
			<div class="form-row">
                <div class="form-label">ID</div>
                <div class="form-controls">
					<input type="text" class="xlarge" name="OdnoklassnikiId" value="<?php echo osc_get_preference('OdnoklassnikiId', 'HybridAuth'); ?>" placeholder="id">
                </div>
            </div>
			<div class="form-row">
                <div class="form-label">Public key</div>
                <div class="form-controls">
					<input type="text" class="xlarge" name="OdnoklassnikiSecrect" value="<?php echo osc_get_preference('OdnoklassnikiSecrect', 'HybridAuth'); ?>" placeholder="key">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-label">Secret Key</div>
                <div class="form-controls">
					<input type="text" class="xlarge" name="OdnoklassnikiPublic" value="<?php echo osc_get_preference('OdnoklassnikiPublic', 'HybridAuth'); ?>" placeholder="secret">
                </div>
            </div>
            
			<div class="form-row">
                <div class="form-label">Enabled</div>
                <div class="form-controls">
					<select name="OdnoklassnikiEnabled">
                        <option value="1" <?php echo (osc_get_preference('OdnoklassnikiEnabled', 'HybridAuth'))?'selected="selected"':''; ?>>Yes</option>
						<option value="0" <?php echo (!osc_get_preference('OdnoklassnikiEnabled', 'HybridAuth'))?'selected="selected"':''; ?>>No</option>
                    </select>
                </div>
            </div>
            
            
        
            
            
           
           	<h2 class="render-title separate-top">Instagram</h2>
			<div class="form-row">
                <div class="form-label">ID</div>
                <div class="form-controls">
					<input type="text" class="xlarge" name="InstagramId" value="<?php echo osc_get_preference('InstagramId', 'HybridAuth'); ?>" placeholder="id">
                </div>
            </div>
			<div class="form-row">
                <div class="form-label">Secret</div>
                <div class="form-controls">
					<input type="text" class="xlarge" name="InstagramSecrect" value="<?php echo osc_get_preference('InstagramSecrect', 'HybridAuth'); ?>" placeholder="secret">
                </div>
            </div>
			<div class="form-row">
                <div class="form-label">Enabled</div>
                <div class="form-controls">
					<select name="InstagramEnabled">
                        <option value="1" <?php echo (osc_get_preference('InstagramEnabled', 'HybridAuth'))?'selected="selected"':''; ?>>Yes</option>
						<option value="0" <?php echo (!osc_get_preference('InstagramEnabled', 'HybridAuth'))?'selected="selected"':''; ?>>No</option>
                    </select>
                </div>
            </div>
            
          
            
            
            
            
            	<h2 class="render-title separate-top">Mailru</h2>
			<div class="form-row">
                <div class="form-label">ID</div>
                <div class="form-controls">
					<input type="text" class="xlarge" name="MailruId" value="<?php echo osc_get_preference('MailruId', 'HybridAuth'); ?>" placeholder="id">
                </div>
            </div>
			<div class="form-row">
                <div class="form-label">Secret</div>
                <div class="form-controls">
					<input type="text" class="xlarge" name="MailruSecrect" value="<?php echo osc_get_preference('MailruSecrect', 'HybridAuth'); ?>" placeholder="secret">
                </div>
            </div>
			<div class="form-row">
                <div class="form-label">Enabled</div>
                <div class="form-controls">
					<select name="MailruEnabled">
                        <option value="1" <?php echo (osc_get_preference('MailruEnabled', 'HybridAuth'))?'selected="selected"':''; ?>>Yes</option>
						<option value="0" <?php echo (!osc_get_preference('MailruEnabled', 'HybridAuth'))?'selected="selected"':''; ?>>No</option>
                    </select>
                </div>
            </div>
            
            
            	<h2 class="render-title separate-top">Yandex</h2>
			<div class="form-row">
                <div class="form-label">ID</div>
                <div class="form-controls">
					<input type="text" class="xlarge" name="YandexId" value="<?php echo osc_get_preference('YandexId', 'HybridAuth'); ?>" placeholder="id">
                </div>
            </div>
			<div class="form-row">
                <div class="form-label">Secret</div>
                <div class="form-controls">
					<input type="text" class="xlarge" name="YandexSecrect" value="<?php echo osc_get_preference('YandexSecrect', 'HybridAuth'); ?>" placeholder="secret">
                </div>
            </div>
			<div class="form-row">
                <div class="form-label">Enabled</div>
                <div class="form-controls">
					<select name="YandexEnabled">
                        <option value="1" <?php echo (osc_get_preference('YandexEnabled', 'HybridAuth'))?'selected="selected"':''; ?>>Yes</option>
						<option value="0" <?php echo (!osc_get_preference('YandexEnabled', 'HybridAuth'))?'selected="selected"':''; ?>>No</option>
                    </select>
                </div>
            </div>
            
            
            
            
			<h2 class="render-title separate-top">Debug</h2>
			<div class="form-row">
                <div class="form-label">Enabled</div>
                <div class="form-controls">
					<select name="HybridAuthDebug">
                        <option value="1" <?php echo (osc_get_preference('HybridAuthDebug', 'HybridAuth'))?'selected="selected"':''; ?>>Yes</option>
						<option value="0" <?php echo (!osc_get_preference('HybridAuthDebug', 'HybridAuth'))?'selected="selected"':''; ?>>No</option>
                    </select>
                </div>
            </div>
            
            	<h2 class="render-title separate-top">Redirect after login</h2>
			<div class="form-row">
                <div class="form-label">Redirect to USER_PROFILE</div>
                <div class="form-controls">
					<select name="HybridRedirect">
                        <option value="1" <?php echo (osc_get_preference('HybridRedirect', 'HybridAuth'))?'selected="selected"':''; ?>>Yes</option>
						<option value="0" <?php echo (!osc_get_preference('HybridRedirect', 'HybridAuth'))?'selected="selected"':''; ?>>No</option>
                    </select>
                </div>
            </div>
            
            
            <div class="form-actions">
                <input type="submit" value="<?php _e('Save Changes', 'HybridAuth'); ?>" class="btn btn-submit">
            </div>
		</div>
    </fieldset>
    
</form>