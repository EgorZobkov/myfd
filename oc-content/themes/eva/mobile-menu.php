<?php $blocks = ModelIM::newInstance()->getUserBlocks(osc_logged_user_id()); ?>

<?php if (osc_is_web_user_logged_in()): ?>
<!-- Меню для авторизованных пользователей -->
<div class="mobile-bottom-nav">
    <div class="BottomMenuItem">
        <a class="BottomMenuItem__link" href="/">
            <div class="BottomMenuItemIcon">
                <div class="svgIcon">
                    <!-- SVG иконка для главной страницы -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 27.02 27.02">
                        <g>
                            <path d="M3.674 24.876s-.024.604.566.604l6.811-.008.01-5.581s-.096-.92.797-.92h2.826c1.056 0 .991.92.991.92l-.012 5.563h6.667c.749 0 .715-.752.715-.752V14.413l-9.396-8.358-9.975 8.358v10.463z" fill="#ffffff"></path>
                            <path d="M0 13.635s.847 1.561 2.694 0l11.038-9.338 10.349 9.28c2.138 1.542 2.939 0 2.939 0L13.732 1.54 0 13.635zM23.83 4.275h-2.662l.011 3.228 2.651 2.249z" fill="#ffffff"></path>
                        </g>
                    </svg>
                </div>
            </div>
            <span class="BottomMenuItemLabel">Главная</span>
        </a>
    </div>

    <div class="BottomMenuItem">
        <a class="BottomMenuItem__link" href="https://my-fd.ru/index.php?page=custom&route=im-threads">
            <div class="BottomMenuItemIcon">
                <div class="svgIcon">
                    <!-- SVG иконка для чата -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 30.743 30.744">
                        <g>
                            <path d="M28.585 9.67h-.842v9.255c0 1.441-.839 2.744-2.521 2.744H8.743v.44c0 1.274 1.449 2.56 2.937 2.56h12.599l4.82 2.834-.699-2.834h.185c1.487 0 2.158-1.283 2.158-2.56V11.867c0-1.274-.671-2.197-2.158-2.197z" fill="#ffffff"></path>
                            <path d="M22.762 3.24H3.622C1.938 3.24 0 4.736 0 6.178v11.6c0 1.328 1.642 2.287 3.217 2.435l-1.025 3.891L8.76 20.24h14.002c1.684 0 3.238-1.021 3.238-2.462v-11.6c0-1.442-1.555-2.938-3.238-2.938zm-16.22 9.792a1.729 1.729 0 1 1 0-3.458 1.729 1.729 0 0 1 0 3.458zm6.458 0a1.729 1.729 0 1 1 0-3.458 1.729 1.729 0 0 1 0 3.458zm6.459 0a1.73 1.73 0 1 1 0-3.46 1.73 1.73 0 0 1 0 3.46z" fill="#ffffff"></path>
                        </g>
                    </svg>

                    <span class="im-user-account-count im-count-<?php echo im_count_unread(osc_logged_user_id()); ?>" 
                      style="position: absolute; top: 0; left: 20px; background-color: #7962E6; color: white; padding: 2px 5px; border-radius: 50%; font-size: 12px;">
                    <?php echo im_count_unread(osc_logged_user_id()); ?>
                </span>
                </div>
            </div>
            <span class="BottomMenuItemLabel">Сообщения
            </span>
        </a>
    </div>

    <div class="BottomMenuItem">
        <a class="BottomMenuItem__link" href="https://my-fd.ru/index.php?page=item&action=item_add">
            <div class="BottomMenuItemIcon">
                <div class="svgIcon">
                    <!-- SVG иконка для добавления -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 152 152">
                        <g>
                            <path d="M117 0H35A35.1 35.1 0 0 0 0 35v82a35.1 35.1 0 0 0 35 35h82a35.1 35.1 0 0 0 35-35V35a35.1 35.1 0 0 0-35-35zm-9.79 82.55H84.14a1.34 1.34 0 0 0-1.35 1.35V107a6.79 6.79 0 0 1-13.58 0V83.9a1.34 1.34 0 0 0-1.35-1.35H44.79a6.79 6.79 0 1 1 0-13.58h23.07a1.34 1.34 0 0 0 1.35-1.35V44.55a6.79 6.79 0 0 1 13.58 0v23.07A1.34 1.34 0 0 0 84.14 69h23.07a6.79 6.79 0 0 1 0 13.58z" fill="#ffffff"></path>
                        </g>
                    </svg>
                </div>
            </div>
            <span class="BottomMenuItemLabel">Добавить</span>
        </a>
    </div>

    <div class="BottomMenuItem">
        <a class="BottomMenuItem__link" href="https://my-fd.ru/index.php?page=user&action=dashboard">
            <div class="BottomMenuItemIcon">
                <div class="svgIcon">
                    <!-- SVG иконка для профиля -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 512 512">
                        <g>
                            <path d="M256 292.1c33 0 63.5-9.3 87.9-25.1 18.9-12.1 43.5-10.1 60.1 5 46.1 41.8 72.3 101.1 72.2 163.4v26.7c0 27.6-22.4 49.9-50 49.9H85.8c-27.6 0-50-22.3-50-49.9v-26.7c-.2-62.2 26-121.6 72.1-163.3 16.6-15.1 41.3-17.1 60.1-5 24.5 15.7 54.9 25 88 25z" fill="#ffffff"></path>
                            <circle cx="256" cy="123.8" r="123.8" fill="#ffffff"></circle>
                        </g>
                    </svg>
                </div>
            </div>
            <span class="BottomMenuItemLabel">Профиль</span>
        </a>
    </div>

    <div class="BottomMenuItem">
        <a class="BottomMenuItem__link" href="https://my-fd.ru/index.php?page=main&action=logout">
            <div class="BottomMenuItemIcon">
                <div class="svgIcon">
                    <!-- SVG иконка для выхода -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 447.674 447.674">
                        <g>
                            <path d="M182.725 379.151c-.572-1.522-.769-2.816-.575-3.863.193-1.04-.472-1.902-1.997-2.566-1.525-.664-2.286-1.191-2.286-1.567 0-.38-1.093-.667-3.284-.855-2.19-.191-3.283-.288-3.283-.288H82.224c-12.562 0-23.317-4.469-32.264-13.421-8.945-8.946-13.417-19.698-13.417-32.258V123.335c0-12.562 4.471-23.313 13.417-32.259 8.947-8.947 19.702-13.422 32.264-13.422h91.361c2.475 0 4.421-.614 5.852-1.854 1.425-1.237 2.375-3.094 2.853-5.568.476-2.474.763-4.708.859-6.707.094-1.997.048-4.521-.144-7.566-.189-3.044-.284-4.947-.284-5.712 0-2.474-.905-4.611-2.712-6.423-1.809-1.804-3.949-2.709-6.423-2.709H82.224c-22.648 0-42.016 8.042-58.101 24.125C8.042 81.323 0 100.688 0 123.338v200.994c0 22.648 8.042 42.018 24.123 58.095 16.085 16.091 35.453 24.133 58.101 24.133h91.365c2.475 0 4.422-.622 5.852-1.854 1.425-1.239 2.375-3.094 2.853-5.571.476-2.471.763-4.716.859-6.707.094-1.999.048-4.518-.144-7.563-.191-3.048-.284-4.95-.284-5.714z" fill="#ffffff"></path>
                            <path d="M442.249 210.989 286.935 55.67c-3.614-3.612-7.898-5.424-12.847-5.424s-9.233 1.812-12.851 5.424c-3.617 3.617-5.424 7.904-5.424 12.85v82.226H127.907c-4.952 0-9.233 1.812-12.85 5.424-3.617 3.617-5.424 7.901-5.424 12.85v109.636c0 4.948 1.807 9.232 5.424 12.847 3.621 3.61 7.901 5.427 12.85 5.427h127.907v82.225c0 4.945 1.807 9.233 5.424 12.847 3.617 3.617 7.901 5.428 12.851 5.428 4.948 0 9.232-1.811 12.847-5.428L442.249 236.69c3.617-3.62 5.425-7.898 5.425-12.848 0-4.948-1.808-9.236-5.425-12.853z" fill="#ffffff"></path>
                        </g>
                    </svg>
                </div>
            </div>
            <span class="BottomMenuItemLabel">Выйти</span>
        </a>
    </div>
</div> 

<?php else : ?>
<!-- Меню для неавторизованных пользователей -->
<div class="mobile-bottom-nav">
    <div class="BottomMenuItem">
        <a class="BottomMenuItem__link" href="/">
            <div class="BottomMenuItemIcon">
                <!-- SVG иконка для главной страницы -->
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 27.02 27.02">
                    <g>
                        <path d="M3.674 24.876s-.024.604.566.604l6.811-.008.01-5.581s-.096-.92.797-.92h2.826c1.056 0 .991.92.991.92l-.012 5.563h6.667c.749 0 .715-.752.715-.752V14.413l-9.396-8.358-9.975 8.358v10.463z" fill="#ffffff"></path>
                        <path d="M0 13.635s.847 1.561 2.694 0l11.038-9.338 10.349 9.28c2.138 1.542 2.939 0 2.939 0L13.732 1.54 0 13.635zM23.83 4.275h-2.662l.011 3.228 2.651 2.249z" fill="#ffffff"></path>
                    </g>
                </svg>
            </div>
            <span class="BottomMenuItemLabel">Главная</span>
        </a>
    </div>

    <div class="BottomMenuItem">
        <a class="BottomMenuItem__link" href="<?php echo osc_user_login_url(); ?>">
            <div class="BottomMenuItemIcon">
                <!-- SVG иконка для входа -->
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 32 32">
  <g fill="#ffffff">
    <path d="M16.5 3c.276 0 .5.224.5.5v1c0 .276-.224.5-.5.5H12v3.5c0 .276-.224.5-.5.5h-1c-.276 0-.5-.224-.5-.5V5H5c-1.105 0-2-.895-2-2z"/>
    <path d="M12 23.5v3.5h4.5c.276 0 .5.224.5.5v1c0 .276-.224.5-.5.5h-4.5c-1.105 0-2-.895-2-2v-3.5c0-.276.224-.5.5-.5h1c.276 0 .5.224.5.5z"/>
    <path d="M2 17v-2c0-.276.224-.5.5-.5h9.5v-3.146c0-.131.158-.196.25-.104l4.638 4.638c.061.061.061.161 0 .222l-4.638 4.64c-.092.092-.25.026-.25-.104v-3.146H2.5c-.276 0-.5-.224-.5-.5z"/>
    <path d="M29.22 4.854l-9.512-2.831c-.352-.105-.708.153-.708.513v26.919c0 .365.36.626.717.52l9.503-2.829c.463-.138.78-.556.78-1.03V5.884c0-.474-.317-.892-.78-1.03zm-6.22 12.146c0 .553-.447 1-1 1s-1-.447-1-1v-2c0-.552.447-1 1-1s1 .448 1 1z"/>
  </g>
</svg>
            </div>
            <span class="BottomMenuItemLabel">Войти</span>
        </a>
    </div>
</div>
<?php endif; ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var mobileNav = document.querySelector('.mobile-bottom-nav');

    function handleResize() {
        if (window.innerWidth <= 768) {
            mobileNav.style.display = 'flex';
        } else {
            mobileNav.style.display = 'none';
        }
    }

    handleResize(); // Вызываем функцию при загрузке страницы
    window.onresize = handleResize; // Вызываем функцию при изменении размера окна
});
</script>
