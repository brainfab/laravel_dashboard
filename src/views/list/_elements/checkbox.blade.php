<div class="editable_field_block {{{ $field_error ? 'has_errors' : '' }}} checkbox_container">
    <input id="checkbox-handler-{{$field_name}}" class="checkbox_handler" type="checkbox" {{{ $field_value ? 'checked="checked"' : '' }}} />
    <input id="checkbox-input-{{$field_name}}" class="editable_field" type="hidden" name="{{$field_input_name}}" value="{{$field_value}}" />
    <div class="errors_block">
    @if ($field_error)
        @foreach ($field_error as $item_error)
        <div class="input_error">{{$item_error['message']}}</div>
        @endforeach
    @endif
    </div>
</div>