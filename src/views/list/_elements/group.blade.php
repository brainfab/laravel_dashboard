<table style="width:100%" class="group_table">
    <tr>
        {foreach from=$field_info.columns item=column}
            {if !isset($column.fields)}
                <td>
                    <div class="input_label"><strong>{$column.title}:</strong></div>
                    <div class="clear"></div>
                    <div class="well">
                        {var field_value=(isset($object[$column.field_name]) ? $object[$column.field_name] : '')}
                        {var field_error=((isset($errors) && isset($errors[$column.field_name])) ? $errors[$column.field_name] : null) }

                        {if in_array($column.type,array('select','radioselect')) }
                            {var field_input_name = "data[".($column.local_field)."]"}
                        {elseif in_array($column.type,array('image','imagelist','file','filelist'))}
                            {var field_input_name = $column.field_name}
                        {else}
                            {var field_input_name = "data[".($column.field_name)."]"}
                        {/if}

                        {var field_info = $column}
                        {var field_name = $column.field_name}
                        {include file="list/_elements/".( isset($column.readonly) ? "readonly/".$column.type : $column.type).".tpl"}
                    </div>
                </td>
            {else}
                <td>
                    <div class="input_label"><strong>{$column.title}</strong></div>
                    <div class="clear"></div>
                    <div class="well">
                        {foreach from=$column.fields item=field}
                            <div class="group_vertical_column_item">
                                <label class="input_label">{$field.title}{if isset($field.translatable)} <img src="images/admin/flag_{$current_lang}.gif" alt=""/>{/if}:</label>
                                {var field_value=(isset($object[$field.field_name]) ? $object[$field.field_name] : '')}
                                {var field_error=((isset($errors) && isset($errors[$field.field_name])) ? $errors[$field.field_name] : null) }

                                {if in_array($field.type,array('select','radioselect')) }
                                    {var field_input_name = "data[".($field.local_field)."]"}
                                {elseif in_array($field.type,array('image','imagelist','file','filelist'))}
                                    {var field_input_name = $field.field_name}
                                {else}
                                    {var field_input_name = "data[".($field.field_name)."]"}
                                {/if}

                                {var field_info = $field}
                                {var field_name = $field.field_name}
                                {if isset($field.readonly)}<span class="readonly">{/if}
                                    {include file="list/_elements/".( isset($field.readonly) ? "readonly/".$field.type : $field.type).".tpl"}
                                    {if isset($field.readonly)}</span>{/if}
                                <div class="clear"></div>
                            </div>
                            <div class="clear"></div>
                            <br>
                        {/foreach}
                    </div>
                </td>
            {/if}
        {/foreach}
    </tr>
</table>