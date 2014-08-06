<div class="editable_field_block{if $field_error} has_errors{/if}">
    <input class="input_file editable_field" type="file" name="{$field_input_name}" />
    <div class="errors_block">
    {if $field_error}
        {foreach from=$field_error}
        <div class="input_error">{$item.message}</div>
        {/foreach}
    {/if}
    </div>
    <table class="imagelist_table">
    {foreach from=$field_value item=file iteration=it}
        <tr id="image-preview-{$field_name}-{$object.id}-{$it}">
            {if isset($file.sizes)}
                {var size = array_shift($file.sizes)}
                <td><img class="img-thumbnail" src="{$size.link}" style="margin-top:10px;display:block;"/></td>
            {else}
            <td><img src="{$file.link}" style="width:200px;margin-top:10px;display:block;"/></td>
            {/if}
            <td><small>({$file.size})</small></td>
            <td><span title="Удалить файл:::admin/{$module.name}/delete_file.json?id={$object.id}::image-preview-{$field_name}-{$object.id}-{$it}::{$field_name}::{$file.full_name}:::" class="c_r htdn delete_file_handler">удалить</span></td>
        </tr>
    {/foreach}
    </table>
</div>