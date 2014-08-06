<div class="editable_field_block{if $field_error} has_errors{/if}">
    {*<textarea class="editable_field input_text" style="height:550px;" name="{$field_input_name}">{html $subs_list}</textarea>*}
    <div class="well" style="padding: 15px; width: 700px; min-height: 550px;">{$subs_list}</div>
    <div class="input_description"><small>{if isset($field_info.description)}<i class="fa fa-info">&nbsp;&nbsp;</i>{$field_info.description}{/if}</small></div>
</div>