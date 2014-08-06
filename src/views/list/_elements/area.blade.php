<div class="editable_field_block @if($field_error) has_errors @endif">
    <textarea class="editable_field input_text form-control" style="height:150px;" name="{{$field_input_name}}">{{$field_value}}</textarea>
    <div class="errors_block">
    @if ($field_error && is_array($field_error))
        @foreach($field_error as $item_error)
        <div class="input_error">{{$item_error['message']}}</div>
        @endforeach
    @endif
    </div>
    <div class="input_description"><small>@if (isset($field_info['description']))}<i class="fa fa-info">&nbsp;&nbsp;</i>{{$field_info['description']}}@endif</small></div>
</div>