<style>#required_form_special {overflow:hidden;width:1px;height:1px;float:left;background:transparent;max-width:1px;max-height:1px;}</style>

<div id="required_form_special">
  <input type="hidden" name="plugin_action" value="triple_check" />
  <label for="required_what">What to sell</label><input value="selling-stuffs" type="text" name="required_what" id="required_what" /><br />
  <label for="required_to">What to buy</label><input value="" type="text" name="required_to" id="required_to" /><br />
  <label for="required_stuff">Stuff</label><input value="" type="text" name="required_stuff" id="required_stuff" />
  <label for="required_fill">Fill</label><input value="" type="text" name="required_fill" id="required_fill" />
</div>

<script>
$(document).ready(function() {
  var what = $('#required_what').val();
  $('#required_to').val( what );
  $('#required_fill').val((new Date).getFullYear());
});
</script>
