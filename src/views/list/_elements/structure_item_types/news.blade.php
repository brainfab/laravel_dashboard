<script type="text/javascript">
    {literal}
    mAttachEvents = function(){
        $('news-type').addEvent('change',function(){
            $$('#news-type-id-category-block, #news-type-tags-block').addClass('none');
            switch (this.get('value')){
                case 'tag' :
                    $('news-type-tags-block').removeClass('none');
                    break;
                case 'category':
                    $('news-type-id-category-block').removeClass('none');
                    break;
            }
        });
        $('news-type').fireEvent('change');
    };
    {/literal}
</script>

<table class="group_table" style="width:100%">
    <tbody>
    <tr>
        <td class="group_vertical_column">

            <div class="group_vertical_column_item">
                <label class="input_label">Тип отображения:</label>

                <div class="editable_field_block">
                    <select id="news-type" class="editable_field input_text" name="data[news_type]">
                    {var items = NewsStructureItemType::getTypeList() }
                    {var select_value = (isset($object.news_type) ? $object.news_type : null)}
                    {foreach from=$items key=type_key item=type_title}
                        <option value="{$type_key}" {if ($type_key == $select_value)}
                                selected="selected"{/if}>{$type_title}</option>
                    {/foreach}
                    </select>
                </div>
                <div class="clear"></div>
            </div>

            <div id="news-type-id-category-block" class="group_vertical_column_item">
                <label class="input_label">Категория:</label>

                <div class="editable_field_block">
                    <select id="news-type-id-category" class="editable_field input_text"
                            name="data[news_type_id_category]">
                    {var items = NewsCategory::loadList() }
                    {var select_value = (isset($object.news_type_id_category) ? $object.news_type_id_category : null)}
                    {foreach from=$items item=category}
                        <option value="{$category.id}" {if ($category.id == $select_value)}
                                selected="selected"{/if}>{$category.title}</option>
                    {/foreach}
                    </select>
                </div>
                <div class="clear"></div>
            </div>

            <div id="news-type-tags-block" class="group_vertical_column_item">
                <label class="input_label">Теги:</label>

                <div class="editable_field_block">
                    <input id="news-type-tags" class="input_text editable_field" type="text" name="data[news_type_tags]"
                           value="{html $object.news_type_tags}"/>
                </div>
                <div class="clear"></div>
            </div>

        </td>
    </tr>
    </tbody>
</table>