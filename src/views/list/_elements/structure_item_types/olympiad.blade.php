<table class="group_table" style="width:100%">
    <tbody>
    <tr>
        <td class="group_vertical_column">

            <div id="news-type-id-category-block" class="group_vertical_column_item">
                <label class="input_label">Олимпиада:</label>

                <div class="editable_field_block">
                    <select id="olympiad-id" class="editable_field input_text"
                            name="data[olympiad_id]">
                    {var items = Olympiad::loadList() }
                    {var select_value = (isset($object.olympiad_id) ? $object.olympiad_id : null)}
                    {foreach from=$items item=olympiad}
                        <option value="{$olympiad.id}" {if ($olympiad.id == $select_value)}
                                selected="selected"{/if}>{$olympiad.title}</option>
                    {/foreach}
                    </select>
                </div>
                <div class="clear"></div>
            </div>

        </td>
    </tr>
    </tbody>
</table>