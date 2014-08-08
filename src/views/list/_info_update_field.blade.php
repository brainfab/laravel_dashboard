@foreach ($module['tabs'] as $tab_name => $tab_info)
<?php $i = 1; ?>
@foreach ($tab_info['fields'] as $field_name => $field_info)
    @if(!isset($update_field) || $update_field!=$field_name) <?php continue; ?> @endif
            <?php $field_value = (isset($object[$field_name]) ? $object[$field_name] : '') ?>
            <?php $field_error = ((isset($errors) && is_array($errors) && isset($errors[$field_name])) ? $errors[$field_name] : null) ?>
            @if(in_array($field_info['type'],array('select','radioselect')))
                <?php $field_input_name = "data[". $field_info['local_field'] ."]"; ?>
            @elseif (in_array($field_info['type'], array('image','imagelist','file','filelist')))
                <?php $field_input_name = $field_name; ?>
            @else
                <?php $field_input_name = "data[".($field_name)."]"; ?>
            @endif
            @include ("admin::list._elements.".( isset($field_info['readonly']) ? "readonly.".$field_info['type'] : $field_info['type'] ))
    <?php $i++; ?>
@endforeach
@endforeach