{var select_value = (isset($object[$field_name]) ? $object[$field_name] : array())}
{if is_object($select_value)}{var select_value=$select_value->getPKs()}{/if}

<div class="editable_field_block{if $field_error} has_errors{/if}">
    <select class="input_text form-control editable_field" name="{$field_input_name}[]" multiple="true">
    {foreach from=$field_info.items key=select_key item=select_title}
    <option value="{$select_key}" {if in_array($select_key, $select_value)} selected="selected"{/if}>{$select_title}</option>
    {/foreach}
    </select>

    <div class="errors_block">
    {if $field_error}
        {foreach from=$field_error}
        <div class="input_error">{$item.message}</div>
        {/foreach}
    {/if}
    </div>
</div>