    {if count($field_info.columns) > 1}<div class="field_group">{/if}
    {foreach from=$field_info.columns item=column}
    {foreach from=$field_info.langs key=lang item=title iteration=i}
        <div class="field_row mlt_field_container" style="width: 400px;">
        <label>
            <img src="images/admin/flag_{$lang}.gif" alt="" class="flag"/>
        </label>
        {if isset($object) && $object}
        {var translate_object = ($object->getTranslateObject($lang)) }
        {/if}

            {var field_name = ($column.field_name)}
            {var filed_default_value        = ((isset($object_default_values[$field_name])) ? $object_default_values[$field_name] : '')}

            {var field_value                = ((isset($translate_object[$field_name])) ? $translate_object[$field_name] : $filed_default_value)}

            {var field_error_title          = ($lang . ('/') . $field_name)}

            {var field_error                = ((isset($errors[$lang]) && isset($errors[$lang][$field_error_title])) ? $errors[$lang][$field_error_title] : null) }
            {if is_null($field_error)}
                {var field_error=((isset($errors) && isset($errors[$row.id][$field_name])) ? $errors[$row.id][$field_name] : null) }
            {/if}
            {var field_input_name_prefix    = "data[".($row.id)."][".($lang)."]["}

            {if in_array($column.type, array('select','radioselect')) }
                {var field_input_name = ($field_input_name_prefix).($column.local_field)."]"}
            {elseif in_array($column.type, array('image','imagelist','file','filelist'))}
                {var field_input_name = $field_name}
            {else}
                {var field_input_name= ($field_input_name_prefix).($field_name).("]")}
            {/if}
            {var tmp = $field_info}
            {var field_info = $column}
        {var tpl=( (isset($column.readonly) || $lang==(ff::getProjectConfig('mlt/default_language'))) ? "readonly/".($column.type) : ($column.type) ).(".tpl")}
            {var field_name = ($field_name)."_".($lang)}
            {include file=("list/_elements/").($tpl)}
            {var field_info = $tmp}

    </div>
        <div style="height: 9px;" class="clear"></div>
    {/foreach}
    {/foreach}
    {if count($field_info.columns) > 1}</div>{/if}

