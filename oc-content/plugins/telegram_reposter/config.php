<?php
// Telegram bot token
$telegram_token = '12';

// Telegram channel ID
$telegram_channel = '@Errertrdf';

// Функция для получения токена и канала
function getTelegramConfig() {
    global $telegram_token, $telegram_channel;
    return [
        'token' => $telegram_token,
        'channel' => $telegram_channel
    ];
}

// Привязка функции к хуку для получения значений токена и канала
osc_add_hook('get_telegram_config', 'getTelegramConfig');
