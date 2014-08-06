@if (isset($field_info['items'][$field_value]))
    {{$field_info['items'][$field_value]}}
@else
    {{{ $field_value ? 'Да' : 'Нет' }}}
@endif