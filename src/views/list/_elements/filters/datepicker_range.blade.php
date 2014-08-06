{if isset($field_info.timepicker)}
    <script>
        var timePicker = true;
    </script>
    {var format="Y-m-d_H:i"}
{else}
    <script>
        var timePicker = false;
    </script>
    {var format="Y-m-d"}
{/if}
<script type="text/javascript" src="/admin/datepicker/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="/admin/datepicker/css/bootstrap-datetimepicker.min.css">
<script>
    {literal}
    $(document).ready(function(){
        $('.datetimepicker-range-filter').datetimepicker({
            language: 'ru',
            pickTime: timePicker,
            pick12HourFormat: false,
            format: timePicker ? 'yyyy-MM-dd hh:mm' : 'yyyy-MM-dd',
            weekStart: 1
        });
    });
    {/literal}
</script>
<div style="width: 135px;" class="datetimepicker-range-filter editable_field_block datepicker_holder fleft mr10 input-group">
    <div class="input_disable_container">
        <input class="form-control filter_datepicker {if isset($field_info.timepicker)} timepicker_input{/if} datepicker_input" name="{$field_input_name}[from]" type="text" value="{if !empty($field_value.from)}{date $field_value.from $format}{/if}"/>
        <div class="disable_overlay"></div>
    </div>

    <span style="width: 37px;" class="btn btn-default add-on input-group-addon"><i class="fa-calendar fa"></i></span>
    <div class="clear"></div>
</div>
<div style="width: 135px;" class="datetimepicker-range-filter editable_field_block datepicker_holder fright input-group">
    <div class="input_disable_container">
        <input class="form-control filter_datepicker {if isset($field_info.timepicker)} timepicker_input{/if} datepicker_input" name="{$field_input_name}[to]" type="text" value="{if !empty($field_value.to)}{date $field_value.to $format}{/if}"/>
        <div class="disable_overlay"></div>
    </div>
        <span style="width: 37px;" class="btn btn-default add-on input-group-addon"><i class="fa-calendar fa"></i></span>
    <div class="clear"></div>
</div>