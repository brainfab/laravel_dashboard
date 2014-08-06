<div class="editable_field_block">
    <script type="text/javascript">
        {literal}
        $(window).ready(function() {
            $( "#roles-list" ).sortable({
                cursor: "move",
                distance: 10,
                grid: [ 20, 20 ],
                update: function( event, ui ) {
                    $('#roles-list input.position_input').each(function(key, item) {
                        $(item).attr('value',key+1);
                    });
                }
            });
        });

        function deleteItem(_this){
            $(_this).parents('.role_item').remove();
        }
        var iterator = 1;
        function addRoleItem() {
            var cont = $('#tmp-role').clone();
            cont.find('input, select').each(function(key, item) {
                $(item).attr('name',$(item).attr('name').replace('%newid%','new-'+iterator));
            });
            cont.removeClass('none');
            $('#roles-list').append(cont);
            iterator++;
        }
        {/literal}
    </script>

    <div id="roles-list" class="roles_list">
    {foreach from=$field_value item=role}
        <div class="role_item mb5">
            <div class="sort_handler fleft cp"><i class="fa fa-arrows-v"></i></div>
            <div class="name fleft pr5">
                <select style="width: 270px;" class="form-control input-sm" name="data[roles][{$role.id}][id_show]">
                    {foreach from=$shows item=s}
                        <option value="{$s.id}" {if $s.id == $role.id_show}selected="selected"{/if}>{$s.title} ({$s.category_title})</option>
                    {/foreach}
                </select>
            </div>
            <div class="title fleft pr5"><input style="width: 180px;" class="form-control input-sm" type="text" value="{$role.title}" name="data[roles][{$role.id}][title]"/></div>
            <div class="descr fleft pr5"><input style="width: 180px;" class="form-control input-sm" type="text" value="{$role.description}" name="data[roles][{$role.id}][description]"/> </div>
            <div class="act fleft">
                <input style="margin-top: 7px;" type="checkbox" name="data[roles][{$role.id}][delete]" value="{$role.id}" />
                <label class="radio_handler cp">
                    <small>удалить</small>
                </label>
            </div>
            <input type="hidden" class="position_input" value="{$role.person_position}" name="data[roles][{$role.id}][person_position]" />
            <div class="clear"></div>
        </div>
        {var lastpos = $role.show_position}
    {/foreach}
    </div>
    <div title="Добавить" class="add_role cp btn-primary btn" onclick="addRoleItem();"><i class="fa fa-plus"></i></div>
    <div class="none role_item mb5" id="tmp-role">
        <div class="sort_handler fleft cp"><i class="fa fa-arrows-v"></i></div>
        <div class="name fleft pr5">
            <select style="width: 270px;" class="form-control input-sm" name="data[roles][%newid%][id_show]">
            {foreach from=$shows item=s}
                <option value="{$s.id}" {if $s.id == $role.id_show}selected="selected"{/if}>{$s.title} ({$s.category_title})</option>
            {/foreach}
            </select>
        </div>
        <div class="title fleft pr5"><input class="form-control input-sm" style="width: 180px;"  class="form-control " type="text" value="" name="data[roles][%newid%][title]"/></div>
        <div class="title fleft pr5"><input class="form-control input-sm" style="width: 180px;"  class="form-control " type="text" value="" name="data[roles][%newid%][description]"/> </div>
        <div class="act fleft">
            <label class="radio_handler">
                <span class="del_tmp_handler" onclick="deleteItem(this);"><small>удалить</small></span>
            </label>
        </div>
        <input type="hidden" class="position_input" value="{$lastpos+1}" name="data[roles][%newid%][person_position]" />
        <div class="clear"></div>
    </div>

</div>