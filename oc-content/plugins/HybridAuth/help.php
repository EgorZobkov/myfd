<div style="padding: 20px;">
    <h2 class="render-title"><?php _e('Help / FAQ', 'MathCaptcha'); ?></h2>
	
	<div class="google">
		<h2 class="render-title separate-top">Google User guide</h2>
		<ul class="hybridauth-guide">
			<li>
			Go to <a href="https://code.google.com/apis/console/" target="_blank">https://code.google.com/apis/console/</a> and create a new project.
			</li>
			<li>
			Go to <strong>API Access</strong> under <strong>API Project</strong>. After that click on <strong>Create an OAuth 2.0 client ID</strong> to <strong>create a new application</strong>.
			</li>
			<li>
			A pop-up named <strong>"Create Client ID"</strong> will appear, fill out any required fields such as the application name and description.
			</li>
			<li>
			Click on <strong>Next</strong>.
			</li>
			<li>
			On the popup set <strong>Application type</strong> to <strong>Web application</strong> and switch to advanced settings by clicking on <strong>(more options)</strong>.
			</li>
			<li>
			Provide this URL as the Callback URL for your application: <span style="color:green"><?php echo osc_base_url(true).'?endpoint=true&hauth.done=Google'; ?></span>
			</li>
			<li>
			Once you have registered, copy and past the created application credentials (Client ID and Secret) into the HybridAuth OSclass plugin.
			</li>
		</ul>
		</strong><font color="red">IMPORTANT:</strong> enable Google+ and Contacts API in the APIs google console!</font>
	</div>
	
	<div class="facebook">
		<h2 class="render-title separate-top">Facebook User guide</h2>
		<ul class="hybridauth-guide">
            <li>
              Go to <a href="https://developers.facebook.com/apps" target="_blank">https://developers.facebook.com/apps</a> and <strong>create a new application</strong> by clicking "Create New App".
            </li>
            <li>
              Fill out any required fields such as the application name and description.
            </li>
            <li>
              Put your website domain in the <strong>Site Url</strong> field.
            </li>
            <li>
              Once you have registered, copy and past the created application credentials (App ID and Secret) into the HybridAuth OSclass plugin.
            </li>
            <li>
            	In application setting go to FACEBOOK LOGIN -> SETTINGS -> Valid OAuth Redirect URIs             	
            </li>
            <li>add this URI : <span style="color:green"><?php echo osc_base_url(true).'?endpoint=true&hauth_done=Facebook'; ?></span> </li>
            <li>NOTE: nowdays facebook only working on HTTPS </li>
          </ul>

	</div>

	<div class="twitter">
		<h2 class="render-title separate-top">Twitter User guide</h2>
		<ul class="hybridauth-guide">
            <li>
              Go to <a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a> and <strong>create a new application</strong>.
            </li>
            <li>
              Fill out any required fields such as the application name and description.
            </li>
            <li>
              Put your website domain in the <strong>Website</strong> field.
            </li>
            <li>
				Provide this URL as the Callback URL for your application: <span style="color:green"><?php echo osc_base_url(true).'?endpoint=true&hauth.done=Twitter'; ?></span>
			</li>
            <li>
              Once you have registered, copy and past the created application credentials (Consumer Key and Secret) into the HybridAuth OSclass plugin.
            </li>
		</ul>
	</div>
	
	<div class="modsz">
	   
		<h2 class="render-title separate-top">Vkontakte</h2>
		<ul class="hybridauth-guide">
		    
		     <li>Заходим в ВК developer console <a href="https://vk.com/apps?act=manage target="_blank">https://vk.com/apps?act=manage</a></li>
<li>Кликаем Создать Приложение</li>
<li>Заполняем :  Имя -> Веб-сайт -> Адрес сайта ->Базовый домен</li>
<li>Подтверждаем через СМС</li>
<li>Заходим в настройки берем ID приложения и Защищённый ключ, кидаем в админке плагина.</li>
<li>Наслаждаемся</li>

<li>Далее можно добавить лого сайта и т.д.</li>
		   
		</ul>
		
		<h2 class="render-title separate-top">Odnoklassniki</h2>
<ul class="hybridauth-guide">
<li>Игры -> Мои загруженные -> Добавить приложение -> указываем Название -> Подключить OAuth
</li>
		<li>
		В список разрешённых redirect_uri указываем: <span style="color:green"><?php echo osc_base_url(true).'?endpoint=true&hauth.done=Odnoklassniki'; ?></span>
		</li>
            <li>В админке плагина кидаем идентификаторы проложения полученные на email: 
            <br /> Application ID: XXXXXXXXXX
            <br /> Публичный ключ приложения: XXXXXXXXXX
            <br /> Секретный ключ приложения: XXXXXXXXXX  </li>
            </ul>
            </div>

	
	
	
	<div class="modsz">
		<h2 class="render-title separate-top">Mail ru</h2>
		<ul class="hybridauth-guide">
            <li>Заходим на <a href="http://api.mail.ru/sites/" target="_blank">http://api.mail.ru/sites/</a></li>
            <li>Выбираем подключить сайт</li>
            <li>Следуем инструкциям</li>
            <li>Скачиваем receiver.html и кидаем себе на сервер, в настройках указываем путь к серверу для этого фаила</li>
            <li>Кидам в настройки плагина:<br/>
ID: XXXXXXXXXX<br/>
Секретный ключ: XXXXXXXXXX</li>
		</ul>
	</div>

<div class="modsz">
		<h2 class="render-title separate-top">Yandex</h2>
		<ul class="hybridauth-guide">
            <li>Заходим на <a href="https://oauth.yandex.ru/" target="_blank">https://oauth.yandex.ru/</a></li>
            <li>Выбираем <b>Зарегистрировать новое приложение</b></a></li>
            <li>Следуем инструкциям</li>
            <li>Выбираем - <b>API Яндекс.Паспорта</b>, ставим галочки на:<br/>
            <b>Доступ к адресу электронной почты</b><br/>
            <b>Доступ к логину, имени и фамилии, полу</b></li>
            <li>В поле Callback URL записываем адрес: <span style="color:green"><?php echo osc_base_url(true).'?endpoint=true&hauth.done=Yandex'; ?></span> </li>
            <li>Кидам в настройки плагина:<br/>
ID:ХХХХХХХХХХ<br/>
Пароль::ХХХХХХХХХХ</li>
		</ul>
	</div>



	<div class="instagram">
		<h2 class="render-title separate-top">Instagram User guide</h2>
		<ul class="hybridauth-guide">
            <li>
              Login with your <a href="https://www.instagram.com/" target="_blank">Instagram</a> account or create a new account first.
            </li>
            <li>
               Open your <a href="https://www.instagram.com/developer/clients/manage/" target="_blank">Instagram clients </a>and click on the <b>Register a New Client</b> button. ( You might have to fill out your developer details when you login for the first time to the developer section. You can fill them out at your convenience. )
            </li>
            <li>
              Fill out the form with the following values and then click on the Register button.<br>
              <pre>
    Application Name: <?php echo osc_base_url(); ?>
    
    Description: <?php echo osc_base_url(); ?> Social Login
    Company name: Your company name
    Website: Enter the URL of your own website, i.e. <?php echo osc_base_url(true); ?>
    
    Valid redirect URIs: <b><span style="color:green"><?php echo osc_base_url(true).'?endpoint=true&hauth_done=Instagram'; ?></span></b>
    Privacy Policy URL: <?php echo osc_base_url(true); ?>/privacy-policy/
    Contact email : Your contact email
              </pre>
              
            </li>
            <li>
               Your client has been registred. Click on the <b>Manage</b> button.
            </li>
            <li>
            	Copy&paste your client keys in the fields into plugin <b>Client ID + Client Secret</b>      	
            </li>
            <li>Submissions.<br>
The application is now in SandBox mode. You can use it, but only with Sandbox users (see Sandbox Tab).
Once your integration is done, you can submit your application. Click on the <b>Permissions tab</b>, ensure all requirements for a submissions are done, check Instagram Permissions Review and click the <b>Start a submission</b> button.</li>
            <li><font color="red">NOTE: Instagram not sharing the mai, therefore registered user will be with ID@instagram.com </font></li>
          </ul>

	</div>




	
	
	</div>
	
	  
	 <div class="function-placement">
		<h2 class="render-title separate-top">Function Placement</h2>
            Place the functions on both user-register.php, user-login.php at the end of the form tag.
			<pre>&lt;?php if (function_exists('HybridAuth_Login')) { HybridAuth_Login(); } ?&gt;</pre>
	  </div>
	  
	  
	  <div> <h2> Change Log </h2> 
	  
	  <pre>
Mod 1.1.6 :
# Загрузка аватарки с соц.сетей (для этого нужно установить дополнительно плагин - Profile Picture )
# Новый ВК api 2019 - вылечено
# Подключен Instagram
# Опция перехода на главную страницу после авторизации или на страницу пользователя


Mod 1.0.5 :
# Исправлен Facebook, работает с последним API v2.12 По новым правилам Фа-Цебука работает только на https.
В настройках Фа-Цебука надо добавтиь Valid OAuth Redirect URIs 
https://йоур-домайн.ком/index.php?endpoint=true&hauth_done=Facebook
Подробно смотрите в помощи плагина.

Mod 1.0.4 :
# Подлечен ВК- добавлен новый метод (для тех у кого стоит плагин, можно просто обновить файлы, не забываем про бэк-ап)

Mod 1.0.3 :
# Добавлено Яндекс 

Mod 1.0.2 :
# Добавлено MailRU 

Mod 1.0.1 :
# исправлен баг сохранения в форме админки для ключей
# исправлены Одноклассники (ОК дает доступ к мылу API только, если запросить тех. поддержку, но это долго и т.д., поэтому вместо мыла присваивается такой mail - userID@ok.ru)
</pre>
</div>
</div>
<style>
	.hybridauth-guide li{
		line-height: 22px;
		padding: 5px 0;
	}
	.hybridauth-guide{
		list-style: decimal
	}
</style>