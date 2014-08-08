@if (isset($field_info['model']))
    <?php $model_for_files_upload = $field_info['model']; ?>
@else
    <?php $model_for_files_upload = isset($module['model']) ? $module['model'] : ''; ?>
@endif

@if (isset($field_info['module']))
    <?php $module_for_files_upload = $field_info['module']; ?>
@else
    <?php $module_for_files_upload = isset($module['name']) ? $module['name'] : ''; ?>
@endif

@if (isset($field_info['field_name']))
    <?php $name_for_files_upload = $field_info['field_name']; ?>
@else
    <?php $name_for_files_upload = isset($field_input_name) ? $field_input_name : ''; ?>
@endif

@if (isset($field_info['action']))
    <?php $action_for_files_upload = $field_info['action']; ?>
@else
    <?php $action_for_files_upload = 'upload_files'; ?>
@endif