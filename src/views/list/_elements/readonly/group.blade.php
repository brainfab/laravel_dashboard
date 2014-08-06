<div class="group">
    {foreach from=$field_info.all_fields item=field}
        <div class="group_item">
            {var field_value=(isset($object[$field]) ? $object[$field] : '')}
            {var field_info = $fields[$field]}
            {$field_info.title}
            {include file="list/_elements/readonly/".($field_info.type).".tpl"}
        </div>
    {/foreach}
</div>
