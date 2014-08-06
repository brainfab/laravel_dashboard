{var select_value=(isset($field_info.local_field) && isset($object[$field_info.local_field]) ? $object[$field_info.local_field] : $field_value)}
{if isset($field_info.items[$select_value])}
<span class="readonly_text_field">{$field_info.items[$select_value]}</span>
{else}
    {if isset($field_info.undefined_text)}
    <span class="readonly_text_field">{$field_info.undefined_text}</span>
    {else}
    <span class="readonly_text_field">неопределено</span>
    {/if}
{/if}