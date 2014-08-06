<div class="editable_field_block">
    <select class="form-control editable_field input_text" name="{$field_input_name}">
    <option value=""></option>
    {foreach from=$field_info.items key=select_key item=select_title}
    <option value="{$select_key}" {if ($select_key == $field_value && $field_value != null)} selected="selected"{/if}>{$select_title}</option>
    {/foreach}
    </select>
</div>