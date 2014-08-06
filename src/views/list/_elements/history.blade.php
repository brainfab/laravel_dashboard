<div
    class="editable_field_block{if $field_error} has_errors{/if}{if isset($field_info.css.class)} {$field_info.css.class}{/if}"
    style="{if isset($field_info.css.style)} {$field_info.css.style}{/if}"
    name="{$field_input_name}"
>
    {if is_array($object.history)}

        {foreach from=$object.history item=hi}
    {*        <a href="info/{$object.id}?version={$hi.version}"> {$hi.datetime} {model_field user $hi.id_user name}</a><br/>*}
            <span> {$hi.datetime} {$hi.user_name}</span><br/>
                {foreach from=$hi.data key=hik item=hiv}
                    {if isset($module.fields[$hik]) }
                        {var tmp_field_structure    = $module.fields[$hik]}
                    {else}
                        {var tmp_field_structure    = array('title'=>$hik,'type'=>'text')}
                    {/if}
                    <div class="fleft" style="width: 110px;">{$tmp_field_structure.title}:</div>
                    <div class="fleft" style="width: 580px;">{if $tmp_field_structure.type != 'rich'}{$hiv}{/if}</div>
                    <div class="clear"></div>
                {/foreach}
                <br/><br/>
        {/foreach}
    {else}
        <span>Изменений пока нет.</span><br/>
    {/if}
</div>