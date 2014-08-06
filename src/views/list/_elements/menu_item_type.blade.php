{var types = MenuItem::getTypeTitles(); }
{var select_value = ((isset($object)) ? $object.id_type : null ) }
<script type="text/javascript">
var id_object = '{$object.id}';
{literal}
window.addEvent('domready',function(){
    var href_input = $$('.menu_items_input_block_href').getElement('input');

    var initEvents = function() {
        if ($('news-detail-list')) {
            $('news-detail-list').addEvent('change',function(){
                href_input.set('value','/news/'+this.get('value')+'/');
            });
        }

        if ($('pages-detail-list')) {
            $('pages-detail-list').addEvent('change',function(){
                var val = $$('#pages-detail-list option:selected').pop().get('data-link');
                href_input.set('value',val);
            });
        }
    };

    $$('.menu_items_input_block_id_parent select').addEvent('change',function(){
        if (this.get('value') != 0) {
            $$('.menu_items_input_block_id_group').addClass('none');
        } else {
            $$('.menu_items_input_block_id_group').removeClass('none');
        }
    });
    $$('.menu_items_input_block_id_parent select').fireEvent('change');

    var req = new Request.JSON({
        'url' : '/admin/menu_items/load_type_template/',
        'onComplete': function(res) {
            $('menu-type-content').set('html',res.content);
            $('menu-type-select').set('disabled',false);

            if ($('menu-type-select').get('value') == 0) {
                $$('.menu_items_input_block_href').addClass('none');
                $$('.menu_items_input_block_is_target_blank input').set('disabled',true);
            } else {
                $$('.menu_items_input_block_is_target_blank input').set('disabled',false);
                $$('.menu_items_input_block_href').removeClass('none');
            }

            href_input.set('value',res.value);
            if ($('menu-type-select').get('value') != 1) {
                href_input.set('readonly', true);
                href_input.addClass('readonly');
            } else {
                href_input.set('readonly', false);
                href_input.removeClass('readonly');
            }
            initEvents();
        },
        'onRequest': function() {
            $('menu-type-select').set('disabled',true);
        },
        'onFailure': function() {
            $('menu-type-content').set('html','Ошибка. Перезагрузите страницу');
        },
        'onError' : function(res) {
            $('menu-type-content').set('html',res);
        }
    });
    $('menu-type-select').addEvent('change',function(){
        req.post({
            'type_name' : $('menu-type-select').get('value'),
            'id_object' : id_object
        });
    });

    $('menu-type-select').fireEvent('change');
});
{/literal}
</script>

<div class="editable_field_block{if $field_error} has_errors{/if}">
    <select id="menu-type-select" class="editable_field input_text" name="{$field_input_name}">
    {foreach from=$types key=select_key item=select_title}
    <option value="{$select_key}" {if ($select_key == $select_value)} selected="selected"{/if}>{$select_title}</option>
    {/foreach}
    </select>
    <div class="errors_block">
    {if $field_error}
        {foreach from=$field_error}
        <div class="input_error">{$item.message}</div>
        {/foreach}
    {/if}
    </div>
    <div class="clear"></div>
    <div id="menu-type-content">

    </div>
</div>