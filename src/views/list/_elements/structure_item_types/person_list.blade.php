<table class="group_table" style="width:100%">
    <tbody>
    <tr>
        <td class="group_vertical_column">

            <div id="news-type-id-category-block" class="group_vertical_column_item">
                <label class="input_label">Категория:</label>

                <div class="editable_field_block">
                    <select id="person-list-id-category" class="editable_field input_text"
                            name="data[person_list_id_category]">
                    {var items = PersonCategory::getPlainList() }
                    {var select_value = (isset($object.person_list_id_category) ? $object.person_list_id_category : null)}
                    {foreach from=$items item=category}
                        <option value="{$category.id}" {if ($category.id == $select_value)}
                                selected="selected"{/if}>{$category.padded_title}</option>
                    {/foreach}
                    </select>
                </div>
                <div class="clear"></div>
            </div>

        </td>
    </tr>
    </tbody>
</table>