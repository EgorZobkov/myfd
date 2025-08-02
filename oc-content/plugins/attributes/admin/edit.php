<?php
  // Create menu
  $title = __('Configure', 'attributes');
  atr_menu($title);

  // GET & UPDATE PARAMETERS
  // $variable = mb_param_update( 'param_name', 'form_name', 'input_type', 'plugin_var_name' );
  // input_type: check or value


  $attribute_id = (Params::getParam('id') > 0 ? Params::getParam('id') : Params::getParam('attribute_id'));

  if(Params::getParam('plugin_action') == 'attribute') {
    $attribute_id = Params::getParam('attribute_id');

    if($attribute_id > 0) {
      $params = Params::getParamsAsArray();

      $error = ModelATR::newInstance()->updateAttribute($params);

      if(count($params) > 0) {
        $updated_ids = array();

        foreach($params as $p => $d) { 
          $value = explode('-', $p);

          if(@$value[0] == 'val' && !in_array(@$value[1], $updated_ids)) {
            $data = array();

            $id = @$value[1];

            $data['pk_i_id'] = $id;
            $data['s_name'] = @$params['val-' . $id . '-s_name'];
            $data['s_image'] = @$params['val-' . $id . '-s_image'];
            $data['fk_c_locale_code'] = $params['fk_c_locale_code'];
            
            ModelATR::newInstance()->updateAttributeValue($data);

            $updated_ids[] = $id;
          }
        }
      }

      if(@$error['code'] > 0 && @$error['message'] <> '') {
        osc_add_flash_error_message(__('There was problem updating attribute, database structure for table t_attribute does not match! Disable/Enable plugin and if error still persist, reinstall plugin.', 'attributes') . '<br/>' . $error['code'] . ': ' . $error['message'], 'admin');
      } else {
        osc_add_flash_ok_message( __('Attribute successfully updated', 'attributes') . ' (' . atr_get_locale() . ')', 'admin');
      }

      header('Location:' . osc_admin_base_url(true) . '?page=plugins&action=renderplugin&file=attributes/admin/edit.php&id=' . $attribute_id);
      exit;
      ?>
        <script>
          $(document).ready(function(){ 
            $('.mb-field[data-id="<?php echo $attribute_id; ?>"] .mb-top-line').click(); 
            $('html, body').animate({ scrollTop: $('.mb-field[data-id="<?php echo $attribute_id; ?>"]').offset().top - 60 }, 0);
          });         
        </script>
      <?php
    }
  }

  $category_all = Category::newInstance()->listAll();
  $link_to_attr = ModelATR::newInstance()->getAttributesForLinkTo();
?>

<div class="mb-body">
  <div class="mb-message-js"></div>

  <!-- ATTRIBUTES SECTION -->
  <div class="mb-box">
    <div class="mb-head">
      <i class="fa fa-wrench"></i> <?php _e('Edit attribute', 'attributes'); ?>
      <?php echo atr_locale_box('edit.php', $attribute_id); ?>
    </div>

    <div class="mb-inside mb-attributes">
      <?php $a = ModelATR::newInstance()->getAttributeDetail($attribute_id); ?>

      <div id="mb-attr">
        <?php //if(count($attributes) > 0) { ?>
          <?php //foreach($attributes as $a) { ?>
            <?php $category_array = explode(',', (@$a['s_category_id'] <> '' ? $a['s_category_id'] : '')); ?>

            <form name="promo_form" id="atr_<?php echo $a['pk_i_id']; ?>" action="<?php echo osc_admin_base_url(true); ?>" method="POST" enctype="multipart/form-data" >
              <input type="hidden" name="page" value="plugins" />
              <input type="hidden" name="action" value="renderplugin" />
              <input type="hidden" name="file" value="<?php echo osc_plugin_folder(__FILE__); ?>edit.php" />
              <input type="hidden" name="plugin_action" value="attribute" />
              <input type="hidden" name="attribute_id" value="<?php echo $a['pk_i_id']; ?>" />
              <input type="hidden" name="pk_i_id" value="<?php echo $a['pk_i_id']; ?>" />
              <input type="hidden" name="fk_c_locale_code" value="<?php echo atr_get_locale(); ?>" />
              <input type="hidden" name="atrLocale" value="<?php echo Params::getParam('atrLocale'); ?>" />


              <div class="mb-field edit" data-id="<?php echo $a['pk_i_id']; ?>">
                <div class="mb-details">
                  <div class="mb-setup">
                    <div class="mb-line">
                      <label for="atr_id" class="h1"><span class="mb-has-tooltip"><?php _e('ID атрибута', 'attributes'); ?></span></label>
                      <input name="atr_id" type="text" class="attr-field attr-id" disabled="disabled" value="<?php echo $a['pk_i_id']; ?>" />
                    </div>

                    <div class="mb-line">
                      <label for="s_name" class="h2"><span class="mb-has-tooltip"><?php _e('Наименование', 'attributes'); ?></span></label>
                      <input name="s_name" type="text" class="attr-field attr-name" value="<?php echo $a['s_name']; ?>" />
                    </div>

                    <div class="mb-line">
                      <label for="s_identifier" class="h3"><span class="mb-has-tooltip"><?php _e('Идентификатор для CSS', 'attributes'); ?></span></label>
                      <input name="s_identifier" type="text" class="attr-field attr-identifier" value="<?php echo $a['s_identifier']; ?>" />
                    </div>

                    <div class="mb-line">
                      <label for="s_type" class="h4"><span class="mb-has-tooltip"><?php _e('Тип', 'attributes'); ?></span></label>
                      <select name="s_type" class="attr-field attr-type">
                        <option value="SELECT" <?php echo ($a['s_type'] == 'SELECT' ? 'selected="selected"' : ''); ?>><?php _e('Select box', 'attributes'); ?></option>
                        <option value="RADIO" <?php echo ($a['s_type'] == 'RADIO' ? 'selected="selected"' : ''); ?>><?php _e('Radio buttons', 'attributes'); ?></option>
                        <option value="CHECKBOX" <?php echo ($a['s_type'] == 'CHECKBOX' ? 'selected="selected"' : ''); ?>><?php _e('Checkboxes', 'attributes'); ?></option>
                        <option value="CLR" <?php echo ($a['s_type'] == 'CLR' ? 'selected="selected"' : ''); ?>><?php _e('Цвет', 'attributes'); ?></option>
                        <option value="TEXT" <?php echo ($a['s_type'] == 'TEXT' ? 'selected="selected"' : ''); ?>><?php _e('Строка', 'attributes'); ?></option>
                        <option value="NUMBER" <?php echo ($a['s_type'] == 'NUMBER' ? 'selected="selected"' : ''); ?>><?php _e('Число', 'attributes'); ?></option>
                        <option value="TEXTAREA" <?php echo ($a['s_type'] == 'TEXTAREA' ? 'selected="selected"' : ''); ?>><?php _e('Текстовое поле', 'attributes'); ?></option>
                        <option value="DATE" <?php echo ($a['s_type'] == 'DATE' ? 'selected="selected"' : ''); ?>><?php _e('Дата', 'attributes'); ?></option>
                        <option value="DATERANGE" <?php echo ($a['s_type'] == 'DATERANGE' ? 'selected="selected"' : ''); ?>><?php _e('Диапазон дат', 'attributes'); ?></option>
                        <option value="URL" <?php echo ($a['s_type'] == 'URL' ? 'selected="selected"' : ''); ?>><?php _e('Ссылка', 'attributes'); ?></option>
                        <option value="PHONE" <?php echo ($a['s_type'] == 'PHONE' ? 'selected="selected"' : ''); ?>><?php _e('Телефонный номер', 'attributes'); ?></option>
                        <option value="EMAIL" <?php echo ($a['s_type'] == 'EMAIL' ? 'selected="selected"' : ''); ?>><?php _e('Email адрес', 'attributes'); ?></option>
                        <option value="DIVIDER" <?php echo ($a['s_type'] == 'DIVIDER' ? 'selected="selected"' : ''); ?>><?php _e('Разделитель', 'attributes'); ?></option>
                      </select>
                    </div>


                    <div class="mb-line mb-row-select-multiple">
                      <label for="category_multiple" class="h5"><span class="mb-has-tooltip"><?php _e('Категории', 'attributes'); ?></span></label> 

                      <input type="hidden" name="s_category_id" id="category" value="<?php echo $a['s_category_id']; ?>"/>
                      <select id="category_multiple" name="category_multiple" multiple>
                        <?php echo atr_cat_list($category_array, $category_all); ?>
                      </select>

                      <div class="mb-explain"><?php _e('Если категория не выбрана, инпут отображается во всех категориях.', 'attributes'); ?></div>
                    </div>

                    <div class="mb-line">
                      <label for="b_enabled" class="h6"><span class="mb-has-tooltip"><?php _e('Включить', 'attributes'); ?></span></label>
                      <input name="b_enabled" type="checkbox" class="element-slide attr-field attr-enabled" <?php echo ($a['b_enabled'] == 1 ? 'checked' : ''); ?> />
                    </div>

                    <div class="mb-line">
                      <label for="b_required" class="h7"><span class="mb-has-tooltip"><?php _e('Обязательный', 'attributes'); ?></span></label>
                      <input name="b_required" type="checkbox" class="element-slide attr-field attr-required" <?php echo ($a['b_required'] == 1 ? 'checked' : ''); ?> />
                    </div>

                    <div class="mb-line">
                      <label for="b_hook" class="h9"><span class="mb-has-tooltip"><?php _e('Показать в характеристиках', 'attributes'); ?></span></label>
                      <input name="b_hook" type="checkbox" class="element-slide attr-field attr-hook" <?php echo ($a['b_hook'] == 1 ? 'checked' : ''); ?> />
                    </div>

                    <div class="mb-line atr-show-all" <?php if(!in_array($a['s_type'], array('SELECT', 'RADIO', 'CHECKBOX', 'CLR'))) { ?>style="display:none;"<?php } ?>>
                      <label for="b_values_all" class="h10"><span class="mb-has-tooltip"><?php _e('Показать все значения', 'attributes'); ?></span></label>
                      <input name="b_values_all" type="checkbox" class="element-slide attr-field attr-values-all" <?php echo ($a['b_values_all'] == 1 ? 'checked' : ''); ?> />
                    </div>

                    <div class="mb-line">
                      <label for="b_search" class="h8"><span class="mb-has-tooltip"><?php _e('Добавить в поиск', 'attributes'); ?></span></label>
                      <input name="b_search" type="checkbox" class="element-slide attr-field attr-search" <?php echo ($a['b_search'] == 1 ? 'checked' : ''); ?> />
                    </div>

                    <div class="mb-line" <?php if(!in_array($a['s_type'], array('SELECT', 'RADIO', 'CHECKBOX'))) { ?>style="display:none;"<?php } ?>>
                      <label for="s_search_type" class="h11"><span class="mb-has-tooltip"><?php _e('Тип поиска', 'attributes'); ?></span></label>
                      <select name="s_search_type" class="attr-field attr-search-type">
                        <option value="" <?php echo ($a['s_search_type'] == '' ? 'selected="selected"' : ''); ?>><?php _e('По умолчанию', 'attributes'); ?></option>
                        <option value="SELECT" <?php echo ($a['s_search_type'] == 'SELECT' ? 'selected="selected"' : ''); ?> <?php if(!in_array($a['s_type'], array('SELECT', 'RADIO', 'CHECKBOX'))) { ?>disabled<?php } ?>><?php _e('Выпадающий список', 'attributes'); ?></option>
                        <option value="RADIO" <?php echo ($a['s_search_type'] == 'RADIO' ? 'selected="selected"' : ''); ?> <?php if(!in_array($a['s_type'], array('SELECT', 'RADIO', 'CHECKBOX'))) { ?>disabled<?php } ?>><?php _e('Radio buttons', 'attributes'); ?></option>
                        <option value="CHECKBOX" <?php echo ($a['s_search_type'] == 'CHECKBOX' ? 'selected="selected"' : ''); ?> <?php if(!in_array($a['s_type'], array('SELECT', 'RADIO', 'CHECKBOX'))) { ?>disabled<?php } ?>><?php _e('Checkbox', 'attributes'); ?></option>
                        <option value="BOXED" <?php echo ($a['s_search_type'] == 'BOXED' ? 'selected="selected"' : ''); ?> <?php if(!in_array($a['s_type'], array('RADIO', 'CHECKBOX'))) { ?>disabled<?php } ?>><?php _e('Boxed layout (radio/check)', 'attributes'); ?></option>
                      </select>
                    </div>

                    <div class="mb-line" <?php if(!in_array($a['s_type'], array('SELECT', 'RADIO', 'CHECKBOX', 'CLR'))) { ?>style="display:none;"<?php } ?>>
                      <label for="s_search_engine" class="h14"><span class="mb-has-tooltip"><?php _e('Настройка поиска', 'attributes'); ?></span></label>
                      <select name="s_search_engine" class="attr-field attr-search-engine">
                        <option value="AND" <?php if ($a['s_search_engine'] == '' || $a['s_search_engine'] == 'AND') { ?>selected="selected"<?php } ?>><?php _e('Включает все значения', 'attributes'); ?></option>
                        <option value="OR" <?php if ($a['s_search_engine'] == 'OR') { ?>selected="selected"<?php } ?>><?php _e('Поиск по любому из выбранных', 'attributes'); ?></option>
                      </select>
                    </div>

                    <div class="mb-line" <?php if(!in_array($a['s_type'], array('SELECT', 'RADIO', 'CHECKBOX', 'CLR'))) { ?>style="display:none;"<?php } ?>>
                      <label for="s_search_values_all" class="h15"><span class="mb-has-tooltip"><?php _e('Отображение вариантов', 'attributes'); ?></span></label>
                      <select name="s_search_values_all" class="attr-field attr-search-values-all">
                        <option value="0" <?php if ($a['s_search_values_all'] == '' || $a['s_search_engine'] == 0) { ?>selected="selected"<?php } ?>><?php _e('Все варианты', 'attributes'); ?></option>
                        <option value="1" <?php if ($a['s_search_values_all'] == 1) { ?>selected="selected"<?php } ?>><?php _e('Только имеющиеся', 'attributes'); ?></option>
                      </select>
                    </div>

                    <div class="mb-line" <?php if(in_array($a['s_type'], array('DATE', 'DATERANGE', 'URL', 'PHONE', 'EMAIL'))) { ?>style="display:none;"<?php } ?>>
                      <label for="b_search_range" class="h12"><span class="mb-has-tooltip"><?php _e('Диапазон', 'attributes'); ?></span></label>
                      <input name="b_search_range" type="checkbox" class="element-slide attr-field attr-hook" <?php echo ($a['b_search_range'] == 1 ? 'checked' : ''); ?> />
                    </div>

                    <div class="mb-line" <?php if(!in_array($a['s_type'], array('CHECKBOX', 'CLR'))) { ?>style="display:none;"<?php } ?>>
                      <label for="b_check_single" class="h13"><span class="mb-has-tooltip"><?php _e('Single Selection', 'attributes'); ?></span></label>
                      <input name="b_check_single" type="checkbox" class="element-slide attr-field attr-hook" <?php echo ($a['b_check_single'] == 1 ? 'checked' : ''); ?> />
                    </div>
                    
                    <?php if(atr_param('attribute_icon') == 1) { ?>
                      <div class="mb-line">
                        <label for="s_icon" class="h16"><span class="mb-has-tooltip"><?php _e('Путь к иконке', 'attributes'); ?></span></label>
                        <input name="s_icon" type="text" class="attr-field attr-icon" size="40" value="<?php echo osc_esc_html(@$a['s_icon']); ?>" />
                      </div>
                    <?php } ?>
                    
                    <div class="mb-line" <?php if(!in_array($a['s_type'], array('SELECT','TEXT','NUMBER','DATE','URL','PHONE','EMAIL'))) { ?>style="display:none;"<?php } ?>>
                      <label for="fk_i_linked_to_attr_id" class="h18"><span class="mb-has-tooltip"><?php _e('Связан с', 'attributes'); ?></span></label>
                      <select name="fk_i_linked_to_attr_id" class="attr-field attr-is-linked-to">
                        <option value="" <?php if($a['fk_i_linked_to_attr_id'] == '') { ?>selected="selected"<?php } ?>><?php _e('Не связан ни с каким атрибутом', 'attributes'); ?></option>
                        
                        <?php if(is_array($link_to_attr) && count($link_to_attr) > 0) { ?>
                          <?php foreach($link_to_attr as $link_attr) { ?>
                            <?php if($link_attr['pk_i_id'] != $a['pk_i_id']) { ?>
                              <option value="<?php echo $link_attr['pk_i_id']; ?>" <?php if($a['fk_i_linked_to_attr_id'] == $link_attr['pk_i_id']) { ?>selected="selected"<?php } ?>><?php echo ($link_attr['s_name'] <> '' ? $link_attr['s_name'] : '#' . $link_attr['pk_i_id']); ?></option>
                            <?php } ?>
                          <?php } ?>
                        <?php } ?>                      
                      </select>
                    </div>
                    
                    <div class="mb-line">
                      <label for="s_restrict_type" class="h19"><span class="mb-has-tooltip"><?php _e('Доступен', 'attributes'); ?></span></label>
                      <select name="s_restrict_type" class="attr-field attr-restrict-type">
                        <option value="" <?php echo ($a['s_restrict_type'] == '' ? 'selected="selected"' : ''); ?>><?php _e('No restriction', 'attributes'); ?></option>
                        <option value="LOGGED" <?php echo ($a['s_restrict_type'] == 'LOGGED' ? 'selected="selected"' : ''); ?>><?php _e('Только зарегистрированные пользователи', 'attributes'); ?></option>
                        <option value="PERSONAL" <?php echo ($a['s_restrict_type'] == 'PERSONAL' ? 'selected="selected"' : ''); ?>><?php _e('Только пользователи', 'attributes'); ?></option>
                        <option value="COMPANY" <?php echo ($a['s_restrict_type'] == 'COMPANY' ? 'selected="selected"' : ''); ?>><?php _e('Только компании', 'attributes'); ?></option>
                        <option value="BUSINESS" <?php echo ($a['s_restrict_type'] == 'BUSINESS' ? 'selected="selected"' : ''); ?>><?php _e('Пользователи только с бизнес-профилем', 'attributes'); ?></option>
                        <option value="BUSINESS_VERIF" <?php echo ($a['s_restrict_type'] == 'BUSINESS_VERIF' ? 'selected="selected"' : ''); ?>><?php _e('Только пользователи с подтвержденным бизнес-профилем', 'attributes'); ?></option>
                        <option value="MEMBERSHIP" <?php echo ($a['s_restrict_type'] == 'MEMBERSHIP' ? 'selected="selected"' : ''); ?>><?php _e('Только пользователи с платным членством в Osclass', 'attributes'); ?></option>
                        <option value="ADMIN" <?php echo ($a['s_restrict_type'] == 'ADMIN' ? 'selected="selected"' : ''); ?>><?php _e('Только Админы', 'attributes'); ?></option>
                      </select>
                    </div>
                  </div>

                  
                  <div class="mb-values">
                    <div class="mb-val-title"><?php _e('Attribute values', 'attributes'); ?></div>
                    <div class="mb-val-empty" <?php if(count($a['values']) > 0 || !in_array($a['s_type'], array('SELECT', 'RADIO', 'CHECKBOX', 'CLR'))) { ?>style="display:none;"<?php } ?>><?php _e('No values added yet', 'attributes'); ?></div>
                    <div class="mb-val-notallowed" <?php if(in_array($a['s_type'], array('SELECT', 'RADIO', 'CHECKBOX', 'CLR'))) { ?>style="display:none;"<?php } ?>><?php _e('Custom values are not allowed for this type of attribute', 'attributes'); ?></div>

                    <ol class="sortable<?php if($a['s_type'] == 'SELECT') { ?> is-tree<?php } ?>">
                      <?php atr_list_values_ol($a['values']); ?>
                    </ol>

                    <div class="mb-val-footer" <?php if(!in_array($a['s_type'], array('SELECT', 'RADIO', 'CHECKBOX', 'CLR'))) { ?>style="display:none;"<?php } ?>>
                      <a href="#" class="add" data-attribute-id="<?php echo $a['pk_i_id']; ?>" data-locale="<?php echo atr_get_locale(); ?>"><i class="fa fa-plus-circle"></i><?php _e('Add value', 'attributes'); ?></a>

                      <div class="add-box">
                        <input id="add-list" type="text" placeholder="<?php echo osc_esc_html(__('... or create from list: val1;val2;val3;...', 'attributes')); ?>"/>
                        <a href="#" class="submit-list" data-attribute-id="<?php echo $a['pk_i_id']; ?>" data-locale="<?php echo atr_get_locale(); ?>"><i class="fa fa-check"></i> <?php echo __('Ok', 'attributes'); ?></a>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="mb-foot">
                  <button type="submit" class="mb-button"><?php _e('Update attribute', 'attributes');?></button>
                </div>
              </div>
            </form>

          <?php //} ?>
        <?php //} ?>

      </div>
    </div>
  </div>




  <!-- PLUGIN INTEGRATION -->
  <div class="mb-box">
    <div class="mb-head"><i class="fa fa-wrench"></i> <?php _e('Plugin Setup', 'attributes'); ?></div>

    <div class="mb-inside">

      <div class="mb-row"><?php _e('Для использования всех функций плагина на 100% не требуется изменять тему, однако, если вы хотите разместить некоторые атрибуты на странице элемента (или циклы) в другом месте, кроме позиции подключения, вы можете показать, что каждое поле вызывает следующую функцию.', 'attributes'); ?></div>
      <div class="mb-row">
        <span class="mb-code">&lt;?php if(function_exists('atr_show_attribute')) { echo atr_show_attribute( {attribute id} ); } ?&gt;</span>
      </div>
      <div class="mb-row"><?php _e('{attribute id} заменить на идентификатор атрибута. Пример: atr_show_attribute( 7 );', 'attributes'); ?></div>
    </div>
  </div>




  <!-- HELP TOPICS -->
  <div class="mb-box" id="mb-help">
    <div class="mb-head"><i class="fa fa-question-circle"></i> <?php _e('Help', 'attributes'); ?></div>

    <div class="mb-inside">
      <div class="mb-row mb-help"><span class="sup">(1)</span> <div class="h1"><?php _e('Уникальный идентификатор атрибута, который не может быть изменен и автоматически генерируется плагином.', 'attributes'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(2)</span> <div class="h2"><?php _e('Название используется в качестве ярлыка и может быть многоязычным - для каждого языка оно разное.', 'attributes'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(3)</span> <div class="h3"><?php _e('Идентификатор используется в качестве идентификатора в строке, которая хранит данные атрибута в шаблоне "atr-{identifier}", чтобы вы могли ссылаться на него в таблицах стилей.', 'attributes'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(4)</span> <div class="h4"><?php _e('Тип атрибута. Поле выбора может содержать вложенные значения до 8 уровней. Флажки Radio & могут иметь значения и быть многоязычными. Другие инпуты не могут содержать значений.', 'attributes'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(5)</span> <div class="h5"><?php _e('Выберите, в каких категориях будет отображаться атрибут. Это вступает в силу на странице поиска и публикации. Если категория не выбрана, атрибут отображается во всех категориях.', 'attributes'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(6)</span> <div class="h6"><?php _e('Если атрибут отключен, он не отображается на странице публикации, редактирования и поиска', 'attributes'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(7)</span> <div class="h7"><?php _e('При необходимости на странице публикации и редактирования пользователь должен ввести значение. Это также работает для флажков (должен быть установлен хотя бы 1).', 'attributes'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(8)</span> <div class="h8"><?php _e('Добавить поле в поиск, чтобы пользователи могли искать по этому атрибуту. Текстовые значения  (текст, телефон, email, ...) ищутся по любым совпадающим знакам.', 'attributes'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(9)</span> <div class="h9"><?php _e('Включите возможность добавления атрибута в hook. Этот атрибут будет отображаться на странице товара без необходимости изменять тему. Вы можете отключить его и добавить атрибут вручную в item.php в любом удобном для вас месте.', 'attributes'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(10)</span> <div class="h10"><?php _e('Если этот параметр включен, на странице элемента отображаются все значения переключателей и флажков. Те, которые не были выбраны пользователем, заштрихованы. Для полей выбора отображается вся иерархия, а не самый нижний уровень.', 'attributes'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(11)</span> <div class="h11"><?php _e('Для поля выбора, переключателей и чекбоксов вы можете выбрать другой формат, который будет использоваться на странице поиска: поле выбора или переключатели. Хотя эта функция включена и для многоуровневых полей выбора, мы рекомендуем использовать ее только для 1-уровневого поля выбора.', 'attributes'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(12)</span> <div class="h12"><?php _e('Если эта опция включена, на странице поиска будет созданы два поля для поиска по диапазону. Эта опция включена для типов атрибутов select box, переключателей, флажков, текста и текстовой области. Когда атрибут имеет предопределенные значения, для сравнения используются идентификаторы этих значений, в противном случае используется значение поля. Рекомендуется использовать только для полей с числовыми значениями, однако плагин также преобразует строки в целые числа (например, 5 мест преобразуется в число 5)', 'attributes'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(13)</span> <div class="h13"><?php _e('Когда этот флажок включен, на странице публикации для типа атрибута checkbox можно выбрать одно и только одно значение (аналогично кнопке radion).', 'attributes'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(14)</span> <div class="h14"><?php _e('Если список должен соответствовать всем выбранным значениям, в поиске будут отображаться только те списки, в которых действительно выбраны все значения (во время публикации). Если активировано какое-либо из выбранных значений, в поиске будут отображаться все списки, которые соответствуют хотя бы одному выбранному значению.', 'attributes'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(15)</span> <div class="h15"><?php _e('Выберите, будут ли отображаться все значения атрибутов или будет выполнен поиск, или будут отображаться только те значения, которые были выбраны по крайней мере в 1 списке.', 'attributes'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(16)</span> <div class="h16"><?php _e('При включении атрибуты могут иметь определенные значки для самих атрибутов. Не влияет на значки значений атрибутов. Может быть полезно, если вы хотите создать необычный дизайн атрибутов на странице товара. Значки будут видны только на странице товара, но не на страницах публикации или поиска.', 'attributes'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(17)</span> <div class="h17">
        <?php _e('Выберите "родительский" атрибут, с которым этот атрибут будет связан.', 'attributes'); ?><br/>
        <?php _e('Этот атрибут может иметь только тип Select или стандартное поле ввода (текст, число, дата, ...).', 'attributes'); ?><br/>
        <?php _e('Родительский атрибут, с которым связан этот атрибут, может иметь тип Select или стандартное поле ввода (текст, число, дата, ...).', 'attributes'); ?>
      </div></div>

      <div class="mb-row mb-help"><span class="sup">(18)</span> <div class="h18"><?php _e('Свяжите атрибут с другим подобным ему свойством (например, с пробегом, мерами, типами, ...).', 'attributes'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(19)</span> <div class="h19"><?php _e('Ограничить использование атрибута на странице публикации. Только ограниченные типы пользователей смогут видеть и использовать атрибут. Для остальных атрибут будет скрыт. Для участия в программе требуется плагин Osclass Pay - функция подписки на пользователя. Для бизнес-профиля требуется Business Profile Plugin.', 'attributes'); ?></div></div>

      <div class="mb-row mb-help"><div><?php _e('Значки значений / атрибуты значков - вы можете указать полную ссылку на изображение или ссылку на значки, поставляемые с плагином, расположенные в папке /img/default. Чтобы использовать один из этих значков, вам не нужно указывать полный путь, достаточно указать короткий путь к папке, плагин распознает его. Пример: default/cars/engine.png', 'attributes'); ?></div></div>
      <div class="mb-row mb-help"><div><?php _e('Плагин поставляется с сотнями значков, которые можно использовать для значений и находить в папке:', 'attributes'); ?> <?php echo osc_base_url(); ?>oc-content/plugins/attributes/img/default/</div></div>
    </div>
  </div>
</div>


<script type="text/javascript">
  var atr_remove_value_url = "<?php echo osc_admin_base_url(true); ?>?page=ajax&action=runhook&hook=atr_remove_value&id=";
  var atr_add_value_url = "<?php echo osc_admin_base_url(true); ?>?page=ajax&action=runhook&hook=atr_add_value&attributeId=";
  var atr_val_position_url = "<?php echo osc_admin_base_url(true); ?>?page=ajax&action=runhook&hook=atr_val_position";


  var atr_message_ok = "<?php echo osc_esc_html(__('Success!', 'attributes')); ?>";
  var atr_message_wait = "<?php echo osc_esc_html(__('Updating, please wait...', 'attributes')); ?>";
  var atr_message_error = "<?php echo osc_esc_html(__('Error!', 'attributes')); ?>";


  var val_list = '';

  // SORTABLE VALUES
  $(document).ready(function(){
    $('ol.sortable').nestedSortable({
      forcePlaceholderSize: true,
      handle: 'div',
      helper: 'clone',
      items: 'li',
      opacity: .8,
      placeholder: 'placeholder',
      revert: 100,
      tabSize: 5,
      tolerance: 'intersect',
      toleranceElement: '> div',
      maxLevels: 8,
      isTree: true,
      startCollapsed: false,
      start: function(event, ui) {
        val_list = $(this).nestedSortable('serialize');
        ui.placeholder.height(ui.item.find('>div').innerHeight() - 2);
      },
      stop: function (event, ui) {
        var c_val_list = $(this).nestedSortable('serialize');
        var c_array_list = $(this).nestedSortable('toArray');

        var c_array_list = c_array_list.reduce(function(total, current, index) {
          total[index] = {'c' : current.id, 'p' : current.parent_id};
          return total;
        }, {});


        atr_message(atr_message_wait, 'info');

        if(val_list != c_val_list) {
          $.ajax({
            url: atr_val_position_url,
            type: "POST",
            data: {'list' : JSON.stringify(c_array_list)},
            success: function(response){
              //console.log(response);
              atr_message(atr_message_ok, 'ok');
            },
            error: function(response) {
              atr_message(atr_message_error, 'error');
              console.log(response);
            }
          });
        }
      }
    });

  });
</script>


<?php echo atr_footer(); ?>