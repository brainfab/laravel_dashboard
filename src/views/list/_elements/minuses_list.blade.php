
<input type="hidden" value="{$object.id}" class="field_key">
<input type="hidden" value="{$module.name}" class="module_name">
<input type="hidden" value="{if isset($field_info.file_model_name)}{$field_info.file_model_name}{else}{$module.model}{/if}" class="field_model">

<div class="editable_field_block panel panel-default">
    <div class="panel-body">
        <ul class="list-group minuses_files_list">
            {if isset($object.minuses_files) && !empty($object.minuses_files)}
                {foreach from=$object.minuses_files item=file}
                    {if !isset($file.gp.link) || empty($file.gp.link)}{continue}{/if}
                        <li class="list-group-item">
                            <a class="" href="/{$file.gp.link}" >{$file.gp.full_name}</a>
                            <span style="margin-left: 10px;" title="Удалить файл:::admin/minuses/delete_file.json?id={$file.id}::file-preview-{$field_name}-{$file.id}::gp::{$file.gp.full_name}:::" class="c_r delete_file_handler btn btn-xs btn-danger">удалить</span>
                        </li>
                {/foreach}
            {/if}
        </ul>
    </div>

    <div class="clear"></div>
</div>

<link rel="stylesheet" href="/admin/files_upload/css/jquery.fileupload.css">

<div class="clear"></div>
<div>
    <div class="image_btn_container">
        <div style="position: relative; height: 24px;  width: 65px;">
            <div class="select_file_container">
                <div class="select_file_btn btn btn-info btn-xs">выбрать</div>
                <input id="minuses_upload" class="fileupload select_file_input input_file editable_field" type="file" name="gp[]" multiple />
            </div>
        </div>
    </div>
    <br>
    <br>
    <div style="width: 400px;" class="progress">
        <div class="progress-bar progress-bar-success"></div>
    </div>
    <div id="files" class="files"></div>
</div>



<script src="/admin/files_upload/js/vendor/jquery.ui.widget.js"></script>
<script src="/admin/files_upload/js/jquery.iframe-transport.js"></script>
<script src="/admin/files_upload/js/jquery.fileupload.js"></script>

{literal}
    <script type="text/javascript">
        /*jslint unparam: true */
        /*global window, $ */
        $(function () {
            'use strict';
            // Change this to the location of your server-side upload handler:
            var url = '/admin/'+$('.module_name').attr('value')+'/upload_minus/?id='+$('.field_key').attr('value')+'&model='+$('.field_model').attr('value');
            $('#minuses_upload').fileupload({
                url: url,
                dataType: 'json',
                done: function (e, data) {
                    var new_file = '<li class="list-group-item"><a class="" href="/'+data.result.link+'" >'+data.result.title+'</a></li>'
                    $('.minuses_files_list').append(new_file);
                },
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('.progress .progress-bar').css(
                            'width',
                            progress + '%'
                    );
                }
            }).prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
        });
    </script>
{/literal}