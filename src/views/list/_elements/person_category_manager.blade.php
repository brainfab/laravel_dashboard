<script type="text/javascript">
    {literal}
window.addEvent('domready',function(){
    $$('.category_checkbox').addEvent('change',function(){
        var el = this.getParent('tr').getElement('.category_title');
        if (this.get('checked')) {
            el.removeClass('none');
        } else {
            el.addClass('none');
        }
    });
});
    {/literal}
</script>
{var people_categories = (PersonCategory::getPlainList()) }
{var selected_categories = array()}
{if isset($object)}
    {var selected_categories = $object->categories->getPKs()}
{/if}
<table style="width: 500px;">
<tr>
    <th>
    </th>
    <th>
        Категория
    </th>
    <th style="width: 190px;">
        Должность&nbsp;в&nbsp;категории&nbsp;<img src="images/admin/flag_{$current_lang}.gif" alt=""/>
    </th>
</tr>
{foreach from=$people_categories item=category}
<tr>
    <td style="vertical-align: top;">
        <input class="category_checkbox" type="checkbox"{if in_array($category.id, $selected_categories)} checked="checked"{/if} name="data[categories_ids][]" value="{$category.id}"/>
    </td>
    {var padding = ($category.depth * 8 + 3)}
    <td style="padding: 3px 5px; vertical-align: top; padding-left: {$padding}px;">
        {$category.title}
    </td>
    <td style="padding: 3px 5px; vertical-align: top;">
        {var title = null}
        {if $object}
            {var title = $object->getCategoryTitle($category.id) }
        {/if}
        <input style="font-size: 12px; width: 170px;" class="form-control input_text category_title{if !in_array($category.id, $selected_categories)} none{/if}" type="text" name="data[category_positions][{$category.id}]" value="{$title}" />
    </td>
</tr>
{/foreach}
</table>