<ul class="list-group" >
{foreach from=$field_value item=file}
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
    <li style="width: 130px;" class="list-group-item">файл загружен <a href="{$file.link}" class="c_b btn btn-xs btn-primary">скачать</a></li>
{/foreach}
</ul>