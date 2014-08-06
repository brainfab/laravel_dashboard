<table style="width: 768px" class="group_table translate_group_table">
<tr>
{foreach from=$field_info.langs key=lang item=title iteration=i}
    <th>
        <img src="images/admin/flag_{$lang}.gif" alt=""/>
        {$title}</th>
{/foreach}
</tr>
<tr>
{foreach from=$field_info.langs key=lang item=title iteration=i}
    <td class="group_vertical_column">
    {if isset($object) && $object}
    {var translate_object = ($object->getTranslateObject($lang)) }
    {/if}
    <div>
        {foreach from=$field_info.columns item=column}
            <label class="input_label">{$column.title}:</label>
            {var field_name = ($column.field_name)}
            {var filed_default_value        = ((isset($object_default_values[$field_name])) ? $object_default_values[$field_name] : '')}

            {var field_value                = ((isset($translate_object[$field_name])) ? $translate_object[$field_name] : $filed_default_value)}

            {var field_error_title          = ($lang . ('/') . $field_name)}

            {var field_error                = ((isset($errors[$lang]) && isset($errors[$lang][$field_error_title])) ? $errors[$lang][$field_error_title] : null) }

            {var field_input_name_prefix    = "data[".($lang)."]["}

            {if in_array($column.type, array('select','radioselect')) }
                {var field_input_name = ($field_input_name_prefix).($column.local_field)."]"}
            {elseif in_array($column.type, array('image','imagelist','file','filelist'))}
                {var field_input_name = $field_name}
            {else}
                {var field_input_name= ($field_input_name_prefix).($field_name).("]")}
            {/if}
            {var tmp = $field_info}
            {var field_info = $column}
            {var tpl=( ( isset($column.readonly) || $lang==(ff::getProjectConfig('mlt/default_language')))? "readonly/".($column.type) : ($column.type) ).(".tpl")}
            {var field_name = ($field_name)."_".($lang)}
            {include file=("list/_elements/").($tpl)}
            {var field_info = $tmp}
        {/foreach}
    </div>
    </td>
{/foreach}
</tr>
</table>