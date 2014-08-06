{var select_value=(isset($field_info.local_field) && isset($object[$field_info.local_field]) ? $object[$field_info.local_field] : $field_value)}

<div class="editable_field_block{if $field_error} has_errors{/if}">
    <div class="input_radiogroup">
    {foreach from=$field_info.items key=select_key item=select_title}
        <span class="radio_button">
        <input name="{$field_input_name}" type="radio" value="{$select_key}" {if ($select_key == $select_value)} checked="checked"{/if} />{$select_title}
        </span>
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