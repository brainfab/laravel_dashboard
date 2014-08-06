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
        $('.datetimepicker-filter').datetimepicker({
            language: 'ru',
            pickTime: timePicker,
            pick12HourFormat: false,
            format: timePicker ? 'yyyy-MM-dd hh:mm' : 'yyyy-MM-dd',
            weekStart: 1
        });
    });
    {/literal}
</script>

<div style="width: 134px;" class="editable_field_block datepicker_holder datetimepicker-filter input-group">
    <div class="input_disable_container">
    <input style="width: 180px!important;" class="form-control filter_datepicker {if isset($field_info.timepicker)} timepicker_input{/if} datepicker_input" type="text" name="{$field_input_name}" value="{if !empty($field_value)}{date $field_value $format}{/if}"/>
    <div class="disable_overlay"></div>
    </div>
    <span class="btn btn-default add-on input-group-addon"><i class="fa-calendar fa"></i></span>
    <div class="date_toggler"></div>
    <div class="clear"></div>
</div>