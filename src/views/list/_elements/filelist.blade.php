{include file="files_upload_settigs.tpl"}

{if $object.id}
    <div class="editable_field_block{if $field_error} has_errors{/if}">
        {include file="files_upload_btn.tpl"}
        <div class="errors_block">
            {if $field_error}
                {foreach from=$field_error}
                    <div class="input_error">{$item.message}</div>
                {/foreach}
            {/if}
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <ul class="list-group gp_files_list">
                    {foreach from=$field_value item=file iteration=it}
                        {if isset($field_info['filename'])}
                            {var file_info = $file}
                            {var file = $file[$field_info['filename']]}
                        {else}
                            {var file_info = $object}
                        {/if}
                        {if isset($field_info.filename)}
                            {var filename = $field_info.filename}
                        {else}
                            {var filename = $field_name}
                        {/if}
                        {if !isset($file.link) || empty($file.link)}{continue}{/if}
                        <li class="list-group-item">
                            <a class="" href="/{$file.link}" >{$file.full_name}<small>({$file.size})</small></a>
                            <span style="margin-left: 10px;" title="Удалить файл:::admin/{$field_name}/delete_file.json?id={$file_info.id}::file-preview-{$field_name}-{$file_info.id}::{$filename}::{$file.full_name}:::" class="c_r delete_file_handler btn btn-xs btn-danger">удалить</span>
                        </li>
                    {/foreach}
                </ul>
            </div>
        </div>
    </div>
{else}
    <div class="editable_field_block{if $field_error} has_errors{/if}">
        Для добавления файлов нажмите кнопку "сохранить" или "применить"
    </div>
{/if}


