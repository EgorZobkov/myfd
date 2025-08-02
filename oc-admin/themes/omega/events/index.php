<?php
osc_enqueue_script('jquery-ui');
osc_current_admin_theme_path('parts/header.php');
$events = View::newInstance()->_get('events');
?>

<h2 class="render-title">
  <?php _e('Мероприятия', 'my_events'); ?>
  <a href="javascript:void(0);" id="add-event-btn" class="btn btn-mini btn-green"><?php _e('Добавить', 'my_events'); ?></a>
</h2>

<div class="table-responsive">
  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th><?php _e('ID', 'my_events'); ?></th>
        <th><?php _e('Название', 'my_events'); ?></th>
        <th><?php _e('Дата начала', 'my_events'); ?></th>
        <th><?php _e('Дата окончания', 'my_events'); ?></th>
        <th><?php _e('Дата начала приёма заявок', 'my_events'); ?></th>
        <th><?php _e('Дата окончания приёма заявок', 'my_events'); ?></th>
        <th><?php _e('Описание', 'my_events'); ?></th>
        <th><?php _e('Логотип', 'my_events'); ?></th>
        <th><?php _e('Город', 'my_events'); ?></th>
        <th><?php _e('Ссылка VK', 'my_events'); ?></th>
        <th><?php _e('Ссылка на билеты', 'my_events'); ?></th>
        <th><?php _e('Ссылка Telegram', 'my_events'); ?></th>
        <th><?php _e('Создано', 'my_events'); ?></th>
        <th><?php _e('Обновлено', 'my_events'); ?></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($events)) : ?>
        <?php foreach ($events as $event) : ?>
          <tr>
            <td><?php echo osc_esc_html($event['id']); ?></td>
            <td><?php echo osc_esc_html($event['title']); ?></td>
            <td><?php echo osc_esc_html($event['date_start']); ?></td>
            <td><?php echo osc_esc_html($event['date_end']); ?></td>
            <td><?php echo osc_esc_html($event['submission_start']); ?></td>
            <td><?php echo osc_esc_html($event['submission_end']); ?></td>
            <td>
              <?php
                $desc = strip_tags($event['description']);
                $short = strlen($desc) > 100 ? substr($desc, 0, 100) . '…' : $desc;
                echo osc_esc_html($short);
              ?>
            </td>
            <td><?php echo osc_esc_html($event['logo']); ?></td>
            <td><?php echo osc_esc_html($event['city']); ?></td>
            <td>
              <?php if (!empty($event['link_vk'])) : ?>
                <a href="<?php echo osc_esc_html($event['link_vk']); ?>" target="_blank">VK</a>
              <?php endif; ?>
            </td>
            <td>
              <?php if (!empty($event['link_tickets'])) : ?>
                <a href="<?php echo osc_esc_html($event['link_tickets']); ?>" target="_blank"><?php _e('Билеты', 'my_events'); ?></a>
              <?php endif; ?>
            </td>
            <td>
              <?php if (!empty($event['link_telegram'])) : ?>
                <a href="<?php echo osc_esc_html($event['link_telegram']); ?>" target="_blank">Telegram</a>
              <?php endif; ?>
            </td>
            <td><?php echo osc_esc_html($event['created_at']); ?></td>
            <td><?php echo osc_esc_html($event['updated_at']); ?></td>
            <td>
              <a href="#" class="edit-event-btn" title="<?php echo osc_esc_html(__('Редактировать', 'my_events')); ?>"
                 data-id="<?php echo osc_esc_html($event['id']); ?>"
                 data-title="<?php echo osc_esc_html($event['title']); ?>"
                 data-date_start="<?php echo osc_esc_html($event['date_start']); ?>"
                 data-date_end="<?php echo osc_esc_html($event['date_end']); ?>"
                 data-submission_start="<?php echo osc_esc_html($event['submission_start']); ?>"
                 data-submission_end="<?php echo osc_esc_html($event['submission_end']); ?>"
                 data-description="<?php echo osc_esc_html($event['description']); ?>"
                 data-logo="<?php echo osc_esc_html($event['logo']); ?>"
                 data-city="<?php echo osc_esc_html($event['city']); ?>"
                 data-link_vk="<?php echo osc_esc_html($event['link_vk']); ?>"
                 data-link_tickets="<?php echo osc_esc_html($event['link_tickets']); ?>"
                 data-link_telegram="<?php echo osc_esc_html($event['link_telegram']); ?>">
                <i class="fa fa-pencil"></i>
              </a>
              &nbsp;
              <a href="<?php echo osc_admin_base_url(true); ?>?page=events&amp;action=delete&amp;id=<?php echo $event['id']; ?>&amp;<?php echo osc_csrf_token_url(); ?>" onclick="return confirm('<?php echo osc_esc_js(__('Вы уверены, что хотите удалить мероприятие?', 'my_events')); ?>');" title="<?php echo osc_esc_html(__('Удалить', 'my_events')); ?>">
                <i class="fa fa-trash"></i>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else : ?>
        <tr>
          <td colspan="14" class="text-center"><?php _e('Мероприятия не найдены', 'my_events'); ?></td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<form id="dialog-event-form" method="post" action="<?php echo osc_admin_base_url(true); ?>?page=events" class="has-form-actions hide">
  <input type="hidden" name="action" value="add" />
  <input type="hidden" name="id" value="" />
  <?php osc_current_admin_theme_path('events/form_fields.php'); ?>
  <div class="form-actions">
    <div class="wrapper">
      <input type="submit" value="<?php echo osc_esc_html(__('Сохранить', 'my_events')); ?>" class="btn btn-submit" />
      <a class="btn" href="javascript:void(0);" onclick="$('#dialog-event-form').dialog('close');"><?php _e('Отмена', 'my_events'); ?></a>
    </div>
  </div>
</form>

<script type="text/javascript">
  $(function(){
    var $dialog = $('#dialog-event-form');
    $dialog.dialog({ autoOpen: false, modal: true, width: 600 });

    $('#add-event-btn').on('click', function(e){
      e.preventDefault();
      $dialog.find('input[name=action]').val('add');
      $dialog.find('input[name=id]').val('');
      $dialog.find('input[type=text], input[type=url], input[type=date], textarea').val('');
      $dialog.dialog('open');
    });

    $('.edit-event-btn').on('click', function(e){
      e.preventDefault();
      var d = $(this).data();
      $dialog.find('input[name=action]').val('edit');
      $dialog.find('input[name=id]').val(d.id);
      $dialog.find('input[name=title]').val(d.title);
      $dialog.find('input[name=date_start]').val(d.date_start);
      $dialog.find('input[name=date_end]').val(d.date_end);
      $dialog.find('input[name=submission_start]').val(d.submission_start);
      $dialog.find('input[name=submission_end]').val(d.submission_end);
      $dialog.find('textarea[name=description]').val(d.description);
      $dialog.find('input[name=logo]').val(d.logo);
      $dialog.find('input[name=city]').val(d.city);
      $dialog.find('input[name=link_vk]').val(d.link_vk);
      $dialog.find('input[name=link_tickets]').val(d.link_tickets);
      $dialog.find('input[name=link_telegram]').val(d.link_telegram);
      $dialog.dialog('open');
    });
  });
</script>

<?php osc_current_admin_theme_path('parts/footer.php'); ?>