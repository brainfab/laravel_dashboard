{var pages_list = StructureItem::getPlainList() }
{var select_value = (isset($menu_item) ? $menu_item.custom_int_param : null)}

<label class="input_label" style="width: 200px; margin-bottom: 4px;">Выберите страницу:</label>
<div class="input_block">
    <div class="fleft">
        <div class="editable_field_block">
            <select id="pages-detail-list" class="editable_field input_text" name="data[custom_int_param]">
            {foreach from=$pages_list item=page}
            <option data-link="{$page.full_link}" value="{$page.id}" {if ($page.id == $select_value)} selected="selected"{/if}>{$page.padded_title}</option>
            {/foreach}
            </select>
        </div>
    </div>
</div>

