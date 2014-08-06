<div class="editable_field_block">
    <input id="checkbox-handler-{{$field_name}}" class="checkbox_handler" type="checkbox" @if ($field_value) checked="checked" @endif />
    <input id="checkbox-input-{{$field_name}}" class="editable_field" type="hidden" name="{{$field_input_name}}" value="{{$field_value}}" />
</div>