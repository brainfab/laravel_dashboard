<input type="hidden" value="{$object.id}" class="field_key">
<input type="hidden" value="{$module.name}" class="module_name">
<input type="hidden" value="{if isset($field_info.file_model_name)}{$field_info.file_model_name}{else}{$module.model}{/if}" class="field_model">

<div class="editable_field_block">
    {if isset($field_value) && !empty($field_value)}
    <div id="photo-list" class="photos_list sortable_gallery">
        {foreach from=$field_value item=photo}
            {if isset($photo[$field_info['filename']]['sizes'])}
                {var size = array_shift($photo[$field_info['filename']]['sizes'])}
            {else}
                {var size = $photo}
            {/if}
            {if !isset($size.link) || empty($size.link)}{continue}{/if}
            <div class="photo_item image_gallery_item_container" el_key="{$photo.id}">
                {*<img onclick="openLightBox(this);" original-size="/{$size.link}" class="img-thumbnail" src="/{$size.link}" />*}
                <div class="gallery_image_preview img-thumbnail" original-size="/{$size.link}" style="background-image: url('/{$size.link}');"></div>
                <div class="image_gallery_item_tools">
                    {*<label class="radio_handler">
                        <input type="radio" name="data[default_photo_id]" value="{$photo.id}"{if $photo.is_default} checked="checked"{/if} />
                        обложка
                    </label>*}

                    <input id="delete-from-photogallery-{$photo.id}" type="checkbox" name="data[photos][{$photo.id}][delete]" value="{$photo.id}" />
                    <label for="delete-from-photogallery-{$photo.id}" class="radio_handler"> удалить</label>

                    <input type="hidden" class="position_input" value="{$photo._position}" name="data[photos][{$photo.id}][_position]" />
                    <div class="photo_sort_handler">::::::::::::::::::::::::::::::::::::::::::::::</div>
                </div>
            </div>
        {/foreach}
    </div>
    {/if}
    <div class="clear"></div>
</div>

<link rel="stylesheet" href="/admin/files_upload/css/jquery.fileupload.css">

<div class="clear"></div>
<div>
    {include file="files_upload_btn.tpl"}
</div>
