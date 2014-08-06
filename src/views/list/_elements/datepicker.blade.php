@if (isset($field_info['timepicker']))
    <script>
        var timePicker = true;
    </script>
    <?php $format = "d-m-Y H:i"; ?>
@else
    <script>
        var timePicker = false;
    </script>
    <?php $format = "d-m-Y"; ?>
@endif

<script type="text/javascript" src="/admin/datepicker/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="/admin/datepicker/css/bootstrap-datetimepicker.min.css">
<script>
    $(document).ready(function(){
        $('.datetimepicker').datetimepicker({
            language: 'ru',
            pickTime: timePicker,
            pick12HourFormat: false,
            format: timePicker ? 'dd-MM-yyyy hh:mm' : 'dd-MM-yyyy',
            weekStart: 1
        });
    });
</script>

<div class="editable_field_block datepicker_holder @if (isset($field_error) && $field_error)) has_errors @endif">
    <div class="datetimepicker  input-group" style="width: 200px;">
        <div class="input_disable_container">
        <input style="width: 331px" data-format="@if (isset($field_info['timepicker']))dd.MM.yyyy hh:mm:ss @else dd.MM.yyyy @endif"  class="form-control @if (isset($field_info['timepicker'])) timepicker_input @endif datepicker_input" name="{{$field_input_name}}" type="text" value="@if (empty($field_value)) {{{CurdateHelper::process()}}} @else {{{ DateHelper::process($field_value, $format) }}} @endif"/>
        <div class="disable_overlay"></div>
        </div>
        <span class="btn btn-default add-on input-group-addon"><i class="fa-calendar fa"></i></span>
    </div>

    <div class="clear"></div>
    <div class="input_description"><small>@if (isset($field_info['description']))<i class="fa fa-info">&nbsp;&nbsp;</i>{{$field_info['description']}} @endif</small></div>
    <div class="errors_block">
    @if (isset($field_error) && $field_error)
        @foreach ($field_error as $item_error)
        <div class="input_error">{{$item_error['message']}}</div>
        @endforeach
    @endif
    </div>
</div>
