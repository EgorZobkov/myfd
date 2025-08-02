<?php

$telegram_token = '12';
$telegram_channel = '@Errertrdf'; // Убедитесь, что название канала правильное и бот добавлен в него

// ID темы в группе (например, №2)
$topic_id = 1; // ID темы, в которую вы хотите отправить сообщение

// Функция для отправки сообщения в Telegram
function sendToTelegram($item) {
    global $telegram_token, $telegram_channel, $topic_id;
    
// Извлечение данных из массива $item
$item_title = $item['s_title']; // Заголовок объявления
$item_price = $item['i_price'] ? osc_format_price($item['i_price']) : 'Цена не указана'; // Цена
$item_category = Category::newInstance()->findByPrimaryKey($item['fk_i_category_id']); // Категория
$item_category_name = $item_category['s_name']; // Имя категории
$item_url = osc_item_url(); // Ссылка на объявление

    // Получаем первую картинку, если она есть
    $resources = ItemResource::newInstance()->getAllResourcesFromItem($item['pk_i_id']);
    $item_photo = isset($resources[0]) ? osc_base_url() . 'oc-content/uploads/' . $resources[0]['s_path'] . $resources[0]['pk_i_id'] . '.' . $resources[0]['s_extension'] : '';

    // Формируем текст для отправки
    $caption = "<b>Заголовок:</b> $item_title\n";
    $caption .= "<b>Цена:</b> $item_price\n";
    $caption .= "<b>Категория:</b> $item_category_name\n";
    $caption .= "<b>Ссылка:</b> <a href=\"$item_url\">Посмотреть объявление</a>\n";

    if ($item_photo && file_exists($item_photo)) {
        // Если есть фото и оно доступно, отправляем изображение
        $url = 'https://api.telegram.org/bot' . $telegram_token . '/sendPhoto';
        
        // Данные для отправки фото
        $data = [
            'chat_id' => $telegram_channel,
            'photo' => new CURLFile(realpath($item_photo)), // Отправка файла через cURL
            'caption' => $caption, // Текст к фото
            'parse_mode' => 'HTML',
            'message_thread_id' => $topic_id
        ];
        
        // Используем cURL для отправки фото
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

    } else {
        // Если фото нет или оно недоступно, отправляем обычное сообщение
        $url = 'https://api.telegram.org/bot' . $telegram_token . '/sendMessage';
        
        // Данные для отправки сообщения
        $data = [
            'chat_id' => $telegram_channel,
            'text' => $caption,
            'parse_mode' => 'HTML',
            'message_thread_id' => $topic_id
        ];

        // Настройки для запроса
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ],
        ];

        // Отправка данных
        $context = stream_context_create($options);
        file_get_contents($url, false, $context); // Выполняем запрос
    }
}

// Привязка функции к хуку, передаем 1 параметр - $item
osc_add_hook('sendToTelegram', 'sendToTelegram', 1);