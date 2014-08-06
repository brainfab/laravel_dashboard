<div class="list-data-wrapper">
    <div class="module_info_tab_content">
{if isset($categories) && !empty($categories) && is_array($categories)}
    <form method="post" id="delete-props-form" action="/admin/properties/delete/">
    <table class="table table-responsive">
        <thead>
            <tr>
                <th><a class="btn btn-primary btn-xs" href="/admin/properties/add/">Добавить свойство</a></th>
            </tr>
        </thead>
        <tbody>
        {foreach from=$categories key=id}
            <tr>
                <td>
                    <a href="/admin/properties/category/{$id}/" title="{$item}"><strong>{$item}</strong></a>
                </td>
            </tr>
            <tr>
                <td>
                    {foreach from=$props_list[$id] item=prop}
                        <div class="mb5" style="padding-left: 30px;">
                            <input class="delete-prop-checkbox" type="checkbox" name="items[{$prop.id}]" value="{$prop.id}" >&nbsp;<a href="/admin/properties/edit/{$prop.id}/" title="{$prop.title}">{$prop.title}</a>
                        </div>
                    {/foreach}
                </td>
            </tr>
        {/foreach}
        <tr>
            <td>
                <div class="btn btn-danger btn-xs" onclick="if(!$('#delete-props-form input.delete-prop-checkbox:checked').length)return false; if(confirm('Вы уверены, что хотите удалить выбранные свойства?')) $('#delete-props-form').submit();">удалить</div>
            </td>
        </tr>
        </tbody>
    </table>
    </form>
{else}
    <div class="alert alert-danger">Добавьте категории!</div>
{/if}
    </div>
</div>