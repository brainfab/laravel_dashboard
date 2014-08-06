<div class="editable_field_block">
    <script type="text/javascript">
        {literal}
            $(window).ready(function() {
                $( "#actors-list" ).sortable({
                    cursor: "move",
                    distance: 10,
                    grid: [ 20, 20 ],
                    update: function( event, ui ) {
                        $('#actors-list input.position_input').each(function(key, item) {
                            $(item).attr('value',key+1);
                        });
                    }
                });
            });

        function deleteItem(_this){
            $(_this).parents('.actor_item').remove();
        }
        var iterator = 1;
        function addRoleItem() {
            var cont = $('#tmp-role').clone();
            cont.find('input, select').each(function(key, item) {
                $(item).attr('name',$(item).attr('name').replace('%newid%','new-'+iterator));
            });
            cont.removeClass('none');
            $('#actors-list').append(cont);
            iterator++;
        }
        {/literal}
    </script>

    <div id="actors-list" class="actors_list">
    {foreach from=$field_value item=role}
        <div class="actor_item mb5">
            <div class="sort_handler fleft cp"><i class="fa fa-arrows-v"></i></div>
            <div class="name fleft pr5">
                <select style="width: 270px;" class="form-control input-sm" name="data[roles][{$role.id}][id_person]">
                    {foreach from=$persons item=p}
                        <option value="{$p.id}" {if $p.id == $role.id_person}selected="selected"{/if}>{$p.surname} {$p.name} ({$p.category_title})</option>
                    {/foreach}
                </select>
            </div>
            <div class="title fleft pr5"><input style="width: 180px;" class="form-control input-sm" type="text" value="{$role.title}" name="data[roles][{$role.id}][title]"/></div>
            <div class="descr fleft pr5"><input style="width: 180px;" class="form-control input-sm" type="text" value="{$role.description}" name="data[roles][{$role.id}][description]"/> </div>
            <div class="act fleft">
                <input style="margin-top: 7px;" id="delete-item-checkbox-{$role.id}" type="checkbox" name="data[roles][{$role.id}][delete]" value="{$role.id}" />
                <label class="radio_handler cp" for="delete-item-checkbox-{$role.id}">
                    <small>удалить</small>
                </label>
            </div>
            <input type="hidden" class="position_input" value="{$role.show_position}" name="data[roles][{$role.id}][show_position]" />
            <div class="clear"></div>
        </div>
        {var lastpos = $role.show_position}
    {/foreach}
    </div>
<div title="Добавить" class="add_role cp btn-primary btn" onclick="addRoleItem();"><i class="fa fa-plus"></i></div>
    <div class="none actor_item mb5" id="tmp-role">
        <div class="sort_handler fleft cp"><i class="fa fa-arrows-v"></i></div>
        <div class="name fleft pr5">
            <select style="width: 270px;" class="form-control input-sm" name="date[roles][%newid%][id_person]">
            {foreach from=$persons item=p}
                <option value="{$p.id}">{$p.surname} {$p.name} ({$p.category_title})</option>
            {/foreach}
            </select>
        </div>
        <div class="title fleft pr5"><input class="form-control input-sm" style="width: 180px;" type="text" value="" name="data[roles][%newid%][title]"/></div>
        <div class="title fleft pr5"><input class="form-control input-sm" style="width: 180px;" type="text" value="" name="data[roles][%newid%][description]"/> </div>
        <div class="act fleft">
            <label class="radio_handler">
                <span class="del_tmp_handler" onclick="deleteItem(this);"><small>удалить</small></span>
            </label>
        </div>
        <input type="hidden" class="position_input" value="{$lastpos+1}" name="data[roles][%newid%][show_position]" />
        <div class="clear"></div>
    </div>
</div>