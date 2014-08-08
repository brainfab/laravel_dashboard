<?php $select_value = (isset($object[$field_name]) ? $object[$field_name] : array()); ?>

<div class="editable_field_block @if (isset($field_error) && $field_error) has_errors @endif">
    <select class="input_text form-control editable_field" name="{{$field_input_name}}" multiple="true">
    @foreach ($field_info['items'] as $select_key => $select_title)
        <option value="{{$select_key}}" @if (in_array($select_key, $select_value)) selected @endif >{{$select_title}}</option>
    @endforeach
    </select>

    <div class="errors_block">
        @if (isset($field_error) && is_array($field_error))
            @foreach ($field_error as $item_error)
                <div class="input_error">{{$item_error}}</div>
            @endforeach
        @endif
    </div>
</div>