{if isset($field_value) && !empty($field_value)}
    {foreach from=$field_value item=property}
        <div class="prod_prop_item_wrapper">
        <div class="prod_prop_item">
            <div><strong>{$property.title}</strong></div>
            {if $property.multiple}
                {if isset($property.values) && !empty($property.values)}
                    {foreach from=$property.values item=value}
                        <div class="prod_prop_value"><input class="form-control fleft mr5" type="text" name="data[product_properties][{$property.id}][]" value="{$value}"><div class="btn btn-xs btn-danger" onclick="if(confirm('Вы уверены, что хотите удалить свойство?')) $(this).parent().remove();">удалить</div></div>
                    {/foreach}
                {/if}
                <div class="prod_prop_value"><input class="form-control" type="text" name="data[product_properties][{$property.id}][]" value=""></div>
            {else}
                <div class="prod_prop_value"><input class="form-control fleft mr5" type="text" name="data[product_properties][{$property.id}]" value="{$property.values}"></div>
            {/if}
        </div>
        {if $property.multiple}&nbsp;&nbsp;&nbsp;<div onclick="$(this).parent().find('.prod_prop_item').append('<div class=\'prod_prop_value\'><input  class=\'form-control\' type=\'text\' name=\'data[product_properties][{$property.id}][]\' value=\'\'></div>')" class="btn btn-primary btn-xs">еще +</div>{/if}
        </div>
    {/foreach}
{else}
    <div class="alert alert-danger">Свойства товаров данной категории не найдены</div>
{/if}
