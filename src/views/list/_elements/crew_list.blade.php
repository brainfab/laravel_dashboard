{var select_value = (isset($object[$field_name]) ? $object[$field_name] : array())}
<div class="editable_field_block">
    {foreach from=$crew item=pcat}
        <div class=""><strong>{$pcat.title}</strong></div>
        <div class="input_text editable_field mb10">
        {foreach from=$pcat.people item=p}
            <input name="{$field_input_name}[]" type="checkbox" value="{$p.id}" {if in_array($p.id, $select_value)} checked="checked"{/if}/>{$p.surname} {$p.name}<br/>
        {/foreach}
        </div>
    {/foreach}
</div>