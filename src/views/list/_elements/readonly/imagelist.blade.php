{foreach from=$field_value item=file}
    {if isset($file.link)}
        {if isset($file.sizes)}
            {var size = array_shift($file.sizes)}
            <img height="40" alt="" src="{$size.link}"/>
        {else}
            <img height="40" alt="" src="{$file.link}"/>
        {/if}
    {else}
    <img src="blank.gif" alt=""/>
    {/if}
{/foreach}