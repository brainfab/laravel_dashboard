<script type="text/javascript">
    {literal}
window.addEvent('domready',function(){
   var expand = function(handler) {
       var id = handler.get('id').split('-').pop();
       $('children-block-'+id).removeClass('none');
       handler.set('html','&ndash;');
   };
   var collapse = function(handler) {
       var id = handler.get('id').split('-').pop();
       $('children-block-'+id).addClass('none');
       handler.set('text','+');
   };
   var toggle = function(handler){
       var id = handler.get('id').split('-').pop();
       if ($('children-block-'+id).hasClass('none')) {
           expand(handler);
       } else {
           collapse(handler);
       }
   };
   $$('.children_handler').addEvent('click',function(evt){
       toggle(this);
   });

   $$('.right_title').each(function(item){
       item.store('original_value', item.get('text'));
   });

   var titles_matches = [];
   $$('.right_title').each(function(item){
        titles_matches.push({
            'element' : item,
            'original_text' : item.get('text'),
            'text_to_compare' : item.get('text').toLowerCase()
        });
   });

   var performFiltering = function() {
        var o = $('filter-right-value');
        var vo = o.get('value');
        var v = o.get('value').toLowerCase();
        if (v.length < 3) {
            titles_matches.each(function(o){
                 o.element.set('text',o.original_text);
            });
            $$('.right_block').removeClass('none');
            return;
        }

        $$('.right_block').addClass('none');

        titles_matches.each(function(o){
             var item = o.element;
             var tc = o.text_to_compare;
             var to = o.original_text;

             if (tc.indexOf(v) < 0) {
                 item.set('text',to);
                 return;
             }

             item.set('html',tc.split(vo).join('<span class="hl">'+vo+'</span>'));
             var i = item;
             while (i.getParent('.right_block')) {
                 var p = i.getParent('.right_block');
                 p.removeClass('none');
                 if (p.getElement('.children_handler')) {
                     expand(p.getElement('.children_handler'));
                 }
                 i = p;
             }
        });
   };
   var timeout = null;
   $('filter-right-value').addEvent('keyup',function(evt){
        clearTimeout(timeout);
        if (evt.key == 'enter') {
            performFiltering();
            return;
        }
        timeout = performFiltering.delay(200);
   });

   $('collapse-all').addEvent('click',function(){
       $$('.children_handler').each(function(item){
           collapse(item);
       })
   })
   $('expand-all').addEvent('click',function(){
       $$('.children_handler').each(function(item){
           expand(item);
       })
   })
});
    {/literal}
</script>

{if isset($object) && is_object($object)}
{var select_value = $object->getRights()}{*(isset($object[$field_name]) ? $object[$field_name] : array())}*}
{else}
{var select_value = array()}
{/if}
{if is_object($select_value)}{var select_value=$select_value->getPKs()}{/if}
<div class="editable_field_block{if $field_error} has_errors{/if}" style="padding: 10px;">
    Поиск: <input type="text" id="filter-right-value" style="border: 1px solid #E8E8E8; padding: 2px; font-size: 13px;"/>
    <span class="htdn ml10" id="collapse-all">Свернуть все</span>
    <span class="htdn ml10" id="expand-all">Развернуть все</span>
</div>
<div class="editable_field_block{if $field_error} has_errors{/if}">
    <div class="input_text editable_field" style="font-size: 10px;">
    {var current_depth = '0'}
    {var j = '0'}
    {foreach from=$field_info.items key=select_key item=right}
        {if $right.depth < $current_depth}
            {var close = $current_depth - $right.depth}
            {for loop=$close value=i start=0}
                </div></div>
                {*<div>&lt;/div&gt;</div>*}
                {*<div style="color: red">&lt;/rights_block_wrapper&gt;</div>*}
            {/for}
        {/if}

        {if $right.has_children}
            <div class="right_has_children_block right_block right_block{$right.depth}">
                <span id="children-handler-{$j}" class="children_handler">+</span>
            {*<div style="color: red">&lt;rights_block_wrapper&gt;</div>*}
            {*<span >+</span>*}
        {else}
            <div class="right_block right_block{$right.depth}">
        {/if}

        {*<span class="right_block{$right.depth}">*}
            <input name="{$field_input_name}[]" type="checkbox" value="{$right.id}" {if in_array($right.id, $select_value)} checked="checked"{/if}/><span class="right_title">{$right.title}</span><br/>
        {*</span>*}

        {if $right.has_children}
            <div id="children-block-{$j}" class="none">
            {var j = $j + 1}
            {*<div>&lt;div&gt;</div>*}
        {else}
            </div>
        {/if}

        {var current_depth = $right.depth}
    {/foreach}

    {for loop=$current_depth value=i start=0}
        </div></div>
        {*<div>&lt;/div&gt;</div>*}
        {*<div style="color: red">&lt;/rights_block_wrapper&gt;</div>*}
    {/for}

    </div>

    <div class="errors_block">
    {if $field_error}
        {foreach from=$field_error}
        <div class="input_error">{$item.message}</div>
        {/foreach}
    {/if}
    </div>
</div>