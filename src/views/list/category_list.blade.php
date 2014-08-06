<script type="text/javascript">
function deleteItem(event) {ls}
    var item = event.target;
    item.getParent('div.category_item').destroy();
}
var iterator = 1;
function add{$field_name}Item() {ls}
    var cont = $('tmp-category-{$field_name}').clone();
    cont.getElements('input, select').each(function(item) {ls}
        item.set('name',item.get('name').replace('%newid%','new-'+iterator));
    });
//    cont.getElements('label').each(function(item) {ls}
//        if (item.get('for'))
//            item.set('for',item.get('for').replace('%newid%','new-'+iterator));
//    });
    cont.removeClass('none');
    cont.inject($('category-list-{$field_name}'),'bottom');
    iterator++;
}
</script>
<div  id="category-list-{$field_name}" class="category_list none">
<div class="add_category cp list_tab_item add_category" onclick="add{$field_name}Item(event);">Добавить категорию</div>
{if isset($categories)}
    {foreach from=$categories item=cat key=id}
<div class="clear"></div>
    <div class="none category_item" id="tmp-category-{$field_name}">
        <input type="hidden" class="position_input" value="{$cat['_position']}" name="data[{$field_name}][id][_position]" />
        <div class="title fleft">
            <label>Заголовок</label><br/>
            <input class="input_text editable_field" type="text" value="{$cat}" name="data[{$field_name}][id][title]"/>
        </div>
        <div class="clear"></div>
        <div class="title fleft">
            <label>Содержимое</label><br/>
            <select  class="editable_field input_text" name="data[{$field_name}][%newid%][question_type]">
                <option value="0" {if ($field_value == 0)} selected="selected"{/if}>Категории</option>
                <option value="1" {if ($field_value == 1)} selected="selected"{/if}>Книги</option>
            </select>
        </div>
        <div class="clear"></div>

        <div class="clear"></div>
        <div class="act ">
            <label class="radio_handler fright">
                <span class="del_tmp_handler" onclick="deleteItem(event);">удалить</span>
            </label>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
    {/foreach}
{/if}
<div class="clear"></div>
    <div class="none category_item" id="tmp-category-{$field_name}">
        <input type="hidden" class="position_input" value="{$lastpos+1}" name="data[{$field_name}][%newid%][_position]" />
        <div class="title fleft">
            <label>Заголовок</label><br/>
            <input class="input_text editable_field" type="text" value="" name="data[{$field_name}][%newid%][title]"/>
        </div>
        <div class="clear"></div>
        <div class="title fleft">
            <label>Содержимое</label><br/>
            <select  class="editable_field input_text" name="data[{$field_name}][%newid%][question_type]">
                <option value="0" {if ($field_value == 0)} selected="selected"{/if}>Категории</option>
                <option value="1" {if ($field_value == 1)} selected="selected"{/if}>Книги</option>
            </select>
        </div>
        <div class="clear"></div>

        <div class="clear"></div>
        <div class="act ">
            <label class="radio_handler fright">
                <span class="del_tmp_handler" onclick="deleteItem(event);">удалить</span>
            </label>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
</div>