<?php
/*
Plugin Name: Telegram Reposter
Plugin URI: http://yourwebsite.com
Description: Плагин для репоста объявлений в Telegram
Version: 1.0
Author: Ваше имя
Author URI: http://yourwebsite.com
*/

require_once 'telegram_reposter.php';

// Функция для активации плагина
function telegram_reposter_install() {
    // Здесь можно добавить логику для установки плагина
}

// Функция для деактивации плагина
function telegram_reposter_uninstall() {
    // Здесь можно добавить логику для удаления плагина
}

// Регистрация хуков OsClass
osc_add_hook('item_published', 'onNewAdPublished');

// Активируем и деактивируем плагин
osc_register_plugin(osc_plugin_path(__FILE__), 'telegram_reposter_install');
osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'telegram_reposter_uninstall');