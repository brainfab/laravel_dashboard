<div class="@if(isset($field_info['autovalidate'])) auto_validate_block @endif editable_field_block @if($field_error) has-error @endif">
    <input id="{{$module['name']}}-{{$field_name}}-{{{ isset($object['id']) ? $object['id'] : '' }}}" class="form-control input-sm input_text editable_field" type="text" name="{{$field_input_name}}" value="{{$field_value}}"/>
    <div class="clear"></div>
    <div class="input_description"><small>@if(isset($field_info['description']))<i class="fa fa-info">&nbsp;&nbsp;</i>{{$field_info['description']}} @endif</small></div>
    <div class="errors_block">

    @if(isset($field_error) && is_array($field_error))
        @foreach($field_error as $item_error)
        <div class="text-danger note note-error">{{$item_error}}</div>
        @endforeach
    @endif
    </div>
</div>