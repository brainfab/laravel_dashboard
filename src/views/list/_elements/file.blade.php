{if isset($field_info.model)}
    {var model_for_files_upload = $field_info.model}
{else}
    {var model_for_files_upload = $module.model}
{/if}
{if isset($field_info.module)}
    {var module_for_files_upload = $field_info.module}
{else}
    {var module_for_files_upload = $module.name}
{/if}
{if isset($field_info.field_name)}
    {var name_for_files_upload = $field_info.field_name}
{else}
    {var name_for_files_upload = $field_input_name}
{/if}

{if $object.id}
    <div class="editable_field_block{if $field_error} has_errors{/if}">
        <div style="height: 23px;  width: 65px; margin-bottom: 20px" onclick="uploadFiles({print_upload_files_setting $model_for_files_upload $object.id $module_for_files_upload $name_for_files_upload})" class="select_file_btn btn btn-info btn-xs">выбрать</div>

        {if isset($field_value.link)}
            <div style="width: 370px;" class="well well-sm">
                <a href="{$field_value.link}" class="c_b btn btn-sm btn-primary">{$field_value.full_name}</a>
                <span title="Удалить файл:::admin/{$module.name}/delete_file.json?id={$object.id}::file-preview-{$field_name}-{$object.id}::{$field_name}::{$field_value.full_name}:::" class="c_r delete_file_handler btn btn-xs btn-danger">удалить</span>
            </div>
        {/if}
        <div class="errors_block">
            {if $field_error}
                {foreach from=$field_error}
                    <div class="input_error">{$item.message}</div>
                {/foreach}
            {/if}
        </div>
    </div>
{else}
    <div class="editable_field_block{if $field_error} has_errors{/if}">
        Для добавления файла нажмите кнопку "сохранить" или "применить"
    </div>
{/if}


