<?php $select_value = (isset($object[$field_name]) ? $object[$field_name] : array()); ?>

<div class="editable_field_block @if (isset($field_error) && $field_error) has_errors @endif">
    <div class="input_text editable_field">
    @foreach ($field_info['items'] as $select_key => $select_title)
        <input name="{{$field_input_name}}" type="radio" value="{{$select_key}}" @if (in_array($select_key, $select_value)) checked="checked" @endif /> {{$select_title}}<br/>
    @endforeach
    </div>

    <div class="errors_block">
        @if (isset($field_error) && is_array($field_error))
            @foreach ($field_error as $item_error)
                <div class="input_error">{{$item_error}}</div>
            @endforeach
        @endif
    </div>
</div>