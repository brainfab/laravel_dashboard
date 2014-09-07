@if ($module['action_name'] == 'add' && isset($filter_values[$field_info['local_field']]))
    <?php $select_value = $filter_values[$field_info['local_field']]; ?>
@else
    <?php $select_value = (isset($field_info['local_field']) && isset($object[$field_info['local_field']]) ? $object[$field_info['local_field']] : $field_value); ?>
@endif

<div class="editable_field_block @if (isset($field_error) && $field_error) has_errors @endif">
    <select @if (isset($field_info['onchange_update'])) onchange="reloadFieldOnChange('{{$module['name']}}_input_block_{{$field_info['onchange_update']['field']}}', '{{$module['name']}}/{{$field_info['onchange_update']['action']}}', this)" @endif class="form-control editable_field input_text" name="{{$field_input_name}}">
    @foreach ($field_info['items'] as $select_key => $select_title)
    <option value="{{$select_key}}" @if ($select_key == $select_value) selected="selected" @endif>{{$select_title}}</option>
    @endforeach
    </select>
    <div class="errors_block">
    @if (isset($field_error) && $field_error)
        @foreach ($field_error as $item_error)
        <div class="input_error">{{$item_error}}</div>
        @endforeach
    @endif
    </div>
</div>