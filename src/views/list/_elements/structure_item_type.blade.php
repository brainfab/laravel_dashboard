<script type="text/javascript">
var st_i_url = 'admin/structure_items/load_type_editor_block{if isset($object) && !$object->exists}/{$object.id}{/if}/';
var mAttachEvents, mRemoveEvents;
{literal}
window.addEvent('domready',function(){
    var request = new Request({
        'link': 'cancel',
        'url' : st_i_url,
        'evalScripts': true,
        'onComplete': function(){

        },
        'onSuccess': function(res){
            $('structure-item-editing-content').set('html',res);
            if (typeOf(mAttachEvents) == 'function') {
                mAttachEvents();
                mAttachEvents = null;
            }
        },
        'onRequest': function(){
            if (typeOf(mRemoveEvents) == 'function') {
                mRemoveEvents();
                mRemoveEvents = null;
            }
            $('structure-item-editing-content').set('html','');
        }
    });

    var s = $$('.structure_items_input_block_type select').pop();
    if (s) {
        s.addEvent('change', function(){
            request.post({
                'type' : this.get('value')
            })
        });
    }
});
{/literal}
</script>
<div id="structure-item-editing-content">
{if $object && in_array($object.type, array_keys(StructureItem::getTypeList()))}
    {var file = ("/list/_elements/structure_item_types/") . StringTools::directorize($object.type) . ('.tpl')}
    {include file=$file}
    {literal}
    <script type="text/javascript">
    window.addEvent('load',function(){
        if (typeOf(mAttachEvents) == 'function') {
            mAttachEvents();
            mAttachEvents = null;
        }
    });
    </script>
    {/literal}
{else}
    Выберите тип из списка
{/if}
</div>