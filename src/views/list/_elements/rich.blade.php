<div class="rich_container editable_field_block @if( $field_error ) has_errors @endif" @if( isset($field_info['block_styles'])) style="{{$field_info['block_styles']}}" @endif >
    <textarea id="rich-{{$field_name}}" class="ckeditor editable_field input_text rich_field" style="height: {{{ isset($field_info['height']) ? $field_info['height'].'px' : '600px' }}}; @if( isset($field_info['width'])) width: {{$field_info['width']}}px; @endif " name="{{$field_input_name}}">{{$field_value}}</textarea>
    <div class="errors_block">
    @if( $field_error)
        @foreach ($field_error as $item_error)
        <div class="input_error">{{$item_error}}</div>
        @endforeach
    @endif
    </div>
    <div class="input_description"><small>@if( isset($field_info['description']))<i class="fa fa-info">&nbsp;&nbsp;</i>{{$field_info['description']}}@endif</small></div>
</div>