{if isset($field_value[$field_info.key]) && isset($field_value[$field_info.key]['link'])}
    {if isset($field_value[$field_info.key]['sizes'])}
        {var size = array_shift($field_value[$field_info.key]['sizes'])}
        <img height="40" alt="" src="{$size.link}"/>
    {else}
        <img height="40" alt="" src="{$field_value[$field_info.key]['link']}"/>
    {/if}
{else}
    <img src="images/blank.gif" alt=""/>
{/if}