<?php
// Default event values
$event = isset($event) ? $event : array(
  'title' => '',
  'date_start' => '',
  'date_end' => '',
  'submission_start' => '',
  'submission_end' => '',
  'description' => '',
  'logo' => '',
  'city' => '',
  'link_vk' => '',
  'link_tickets' => '',
  'link_telegram' => ''
);
?>
<div class="form-horizontal">
  <div class="form-row">
    <div class="form-label"><?php _e('Название', 'my_events'); ?></div>
    <div class="form-controls"><input type="text" name="title" class="input-text" value="<?php echo osc_esc_html($event['title']); ?>" /></div>
  </div>
  <div class="form-row">
    <div class="form-label"><?php _e('Дата начала', 'my_events'); ?></div>
    <div class="form-controls"><input type="date" name="date_start" class="input-text" value="<?php echo osc_esc_html($event['date_start']); ?>" /></div>
  </div>
  <div class="form-row">
    <div class="form-label"><?php _e('Дата окончания', 'my_events'); ?></div>
    <div class="form-controls"><input type="date" name="date_end" class="input-text" value="<?php echo osc_esc_html($event['date_end']); ?>" /></div>
  </div>
  <div class="form-row">
    <div class="form-label"><?php _e('Дата начала приёма заявок', 'my_events'); ?></div>
    <div class="form-controls"><input type="date" name="submission_start" class="input-text" value="<?php echo osc_esc_html($event['submission_start']); ?>" /></div>
  </div>
  <div class="form-row">
    <div class="form-label"><?php _e('Дата окончания приёма заявок', 'my_events'); ?></div>
    <div class="form-controls"><input type="date" name="submission_end" class="input-text" value="<?php echo osc_esc_html($event['submission_end']); ?>" /></div>
  </div>
  <div class="form-row">
    <div class="form-label"><?php _e('Описание', 'my_events'); ?></div>
    <div class="form-controls"><textarea name="description" class="input-text"><?php echo osc_esc_html($event['description']); ?></textarea></div>
  </div>
  <div class="form-row">
    <div class="form-label"><?php _e('Логотип', 'my_events'); ?></div>
    <div class="form-controls"><input type="text" name="logo" class="input-text" value="<?php echo osc_esc_html($event['logo']); ?>" /></div>
  </div>
  <div class="form-row">
    <div class="form-label"><?php _e('Город', 'my_events'); ?></div>
    <div class="form-controls"><input type="text" name="city" class="input-text" value="<?php echo osc_esc_html($event['city']); ?>" /></div>
  </div>
  <div class="form-row">
    <div class="form-label"><?php _e('Ссылка VK', 'my_events'); ?></div>
    <div class="form-controls"><input type="url" name="link_vk" class="input-text" value="<?php echo osc_esc_html($event['link_vk']); ?>" /></div>
  </div>
  <div class="form-row">
    <div class="form-label"><?php _e('Ссылка на билеты', 'my_events'); ?></div>
    <div class="form-controls"><input type="url" name="link_tickets" class="input-text" value="<?php echo osc_esc_html($event['link_tickets']); ?>" /></div>
  </div>
  <div class="form-row">
    <div class="form-label"><?php _e('Ссылка Telegram', 'my_events'); ?></div>
    <div class="form-controls"><input type="url" name="link_telegram" class="input-text" value="<?php echo osc_esc_html($event['link_telegram']); ?>" /></div>
  </div>
</div>