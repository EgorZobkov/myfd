<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$locales = osc_get_locales();
$user = osc_user();

osc_enqueue_script('jquery');
osc_enqueue_script('jquery-ui');
osc_enqueue_script('select');
osc_enqueue_script('owl');
osc_enqueue_script('main');
osc_enqueue_script('date');
osc_enqueue_script('jquery-validate');
?>
<!DOCTYPE html>
<html lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">

<head>
    <?php osc_current_web_theme_path('head.php'); ?>
    <meta name="robots" content="noindex, nofollow" />
    <meta name="googlebot" content="noindex, nofollow" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>


    </style>
</head>

<body>
    <?php osc_current_web_theme_path('header.php'); ?>

    <div class="d-block">
        <div class="container">
            <h1>Мероприятия</h1>
        </div>
    </div>

    <div class="container py-4">
        <?php
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $mysqli->set_charset('utf8');

        if ($mysqli->connect_errno) {
            echo "<div class='container'><p>Ошибка подключения к базе данных: " . $mysqli->connect_error . "</p></div>";
        } else {
            $query = "SELECT * FROM oc_t_events WHERE date_end >= CURDATE() ORDER BY date_start ASC";
            $result = $mysqli->query($query);

            if ($result && $result->num_rows > 0): ?>
                <div class="col-wrp obj-wrapper ">
                    <?php while ($event = $result->fetch_assoc()): ?>
                        <div class="obj-inline">
                            <div class="obj-list-main-left">
                                <?php if (!empty($event['logo'])): ?>
                                    <img src="/oc-content/uploads/events/<?php echo $event['logo']; ?>" alt="Логотип" class="obj-inline-img">
                                <?php endif; ?>

                                <div class="obj-inline__header only-mob">
                                    <span class="obj-inline__title"><?php echo $event['title']; ?></span>
                                    <div class="obj-inline__place">
                                        <?php
                                        $dateStart = strtotime($event['date_start']);
                                        $dateEnd = strtotime($event['date_end']);

                                        if (date('Y-m-d', $dateStart) === date('Y-m-d', $dateEnd)) {
                                            // Если даты совпадают - выводим только дату начала с годом
                                            echo date('d.m.Y', $dateStart);
                                        } else {
                                            // Если даты разные - выводим диапазон (начало без года, конец с годом)
                                            echo date('d.m', $dateStart) . ' — ' . date('d.m.Y', $dateEnd);
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="obj-list-main-right">
                                <div class="obj-inline-right-mine">
                                    <div class="obj-inline__header">
                                        <span class="obj-inline__title"><?php echo $event['title']; ?></span>
                                        <div class="obj-inline__place">
                                            <?php
                                            $dateStart = strtotime($event['date_start']);
                                            $dateEnd = strtotime($event['date_end']);

                                            if (date('Y-m-d', $dateStart) === date('Y-m-d', $dateEnd)) {
                                                // Если даты совпадают - выводим только дату начала с годом
                                                echo date('d.m.Y', $dateStart);
                                            } else {
                                                // Если даты разные - выводим диапазон (начало без года, конец с годом)
                                                echo date('d.m', $dateStart) . ' — ' . date('d.m.Y', $dateEnd);
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <p class="obj-inline__descr"><?php echo $event['description']; ?></p>
                                    <div class="obj-inline__footer">
                                        <span class="event-submission">
                                            Заявки принимаются до <b><?php echo date('d.m.Y', strtotime($event['submission_end'])); ?></b>
                                        </span>
                                        <span class="obj-inline__place"><i class="place-ico"></i><?php echo $event['city']; ?></span>
                                    </div>
                                </div>
                                <div class="obj-inline-right-side">
                                    <div class="event-links">
                                        <?php if (!empty($event['link_vk'])): ?>
                                            <a href="<?php echo $event['link_vk']; ?>" target="_blank" title="ВКонтакте" class="mdi mdi-vk mdi-24px"></a>
                                        <?php endif; ?>
                                        <?php if (!empty($event['link_telegram'])): ?>
                                            <a href="<?php echo $event['link_telegram']; ?>" target="_blank" title="Telegram" class="mdi mdi-telegram mdi-24px"></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>Пока нет мероприятий.</p>
        <?php endif;

            $mysqli->close();
        }
        ?>
    </div>

    <?php osc_current_web_theme_path('footer.php'); ?>
</body>

</html>