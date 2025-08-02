<div class="hybrid_login">
	<?php 
		echo (osc_get_preference('GoogleEnabled', 'HybridAuth'))? HybridAuthClass::newInstance()->googleurl():'';
		
		echo (osc_get_preference('FacebookEnabled', 'HybridAuth'))? HybridAuthClass::newInstance()->facebookurl():'';
		
		echo (osc_get_preference('TwitterEnabled', 'HybridAuth'))? HybridAuthClass::newInstance()->twitterurl():'';
		
		echo (osc_get_preference('VkontakteEnabled', 'HybridAuth'))? HybridAuthClass::newInstance()->vkontakteurl():'';
		
		echo (osc_get_preference('OdnoklassnikiEnabled', 'HybridAuth'))? HybridAuthClass::newInstance()->odnoklassnikiurl():'';
		
			echo (osc_get_preference('DraugiemEnabled', 'HybridAuth'))? HybridAuthClass::newInstance()->draugiemurl():'';
			
			echo (osc_get_preference('MailruEnabled', 'HybridAuth'))? HybridAuthClass::newInstance()->mailruurl():'';
			
			echo (osc_get_preference('YandexEnabled', 'HybridAuth'))? HybridAuthClass::newInstance()->yandexurl():'';

			echo (osc_get_preference('InstagramEnabled', 'HybridAuth'))? HybridAuthClass::newInstance()->instaurl():'';
	?>
</div>