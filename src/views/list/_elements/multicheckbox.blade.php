{var select_value = (isset($object[$field_name]) ? $object[$field_name] : array())}
{if is_object($select_value)}{var select_value=$select_value->getPKs()}{/if}

<div class="editable_field_block{if $field_error} has_errors{/if}">
    <div class="input_text editable_field">
    {foreach from=$field_info.items key=select_key item=select_title}
        <input name="{$field_input_name}[]" type="checkbox" value="{$select_key}" {if in_array($select_key, $select_value)} checked="checked"{/if}/> {$select_title}<br/>
    {/foreach}
    </div>

    <div class="errors_block">
    {if $field_error}
        {foreach from=$field_error}
        <div class="input_error">{$item.message}</div>
        {/foreach}
    {/if}
    </div>
</div>