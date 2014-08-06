/**
 * User: Max Kovpak
 * Date: 02.02.14
 * Time: 16:30
 */

function uploadFiles(settings) {
    $('.progress_bar_wrapper .progress-bar').css({'width': 0});
    $('input#file-upload').attr('name', settings.name);
    $('.success_upload').html('');
    $('.progress_bar_wrapper').addClass('none');
    $('#upload_files').modal('show');
    var multiple = settings.multiple==1 ? true : false;
    $('input#file-upload').attr('multiple', multiple);
    if(!multiple){
        $('#drag_n_drop_upload_files_container .drag_n_drop_files_info').text('Или перетащите файл сюда');
        $('.select_files_wrapper .select_file_btn').text('Выбрать файл');
    }else{
        $('#drag_n_drop_upload_files_container .drag_n_drop_files_info').text('Или перетащите файлы сюда');
        $('.select_files_wrapper .select_file_btn').text('Выбрать файлы');
    }
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = '/admin/'+settings.module+'/'+settings.action+'/?id='+settings.id+'&model='+settings.model;
    $('#file-upload').fileupload({
        url: url,
        dataType: 'json',
        dropZone: $('#drag_n_drop_upload_files_container'),
        recalculateProgress: true,
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true,
        limitMultiFileUploads: (multiple ? undefined : 1),
//        multipart: false,
        done: function (e, data) {
            var res_text = !multiple ? 'Файл успешно загружен!' : 'Файлы успешно загружены!';
            var success = '<div class="alert alert-success tac">' +
                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                res_text +
                '</div>';
            $('.success_upload').html('');
            //{$module.name}_input_block_{$field_name}
            updateField($('.'+settings.module+'_input_block_'+settings.name), settings.name);
        },
        fail: function (e, data) {
            $('.progress_bar_wrapper .progress-bar').css({'width': 0});
            var res_text = !multiple ? 'При загрузке файла произошла ошибка!' : 'При загрузке файлов произошла ошибка!';
            var fail = '<div class="alert alert-danger tac">' +
                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                res_text +
                '</div>';
            $('.success_upload').html(fail);
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('.progress_bar_wrapper .progress-bar').css(
                'width',
                progress + '%'
            ).find('.progress_bar_percent').html(progress + '%');
        },
        'start': function(e, data){
            $('.progress_bar_wrapper').removeClass('none');
            $('.progress_bar_wrapper .progress-bar').css({'width': 0});
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
}


$(document).ready(function(){

    $(document).bind('dragover', function (e) {
        var dropZone = $('#drag_n_drop_upload_files_container'),
            timeout = window.dropZoneTimeout;
        if (!timeout) {
            dropZone.addClass('in');
        } else {
            clearTimeout(timeout);
        }
        var found = false,
            node = e.target;
        do {
            if (node === dropZone[0]) {
                found = true;
                break;
            }
            node = node.parentNode;
        } while (node != null);
        if (found) {
            dropZone.addClass('hover');
        } else {
            dropZone.removeClass('hover');
        }
        window.dropZoneTimeout = setTimeout(function () {
            window.dropZoneTimeout = null;
            dropZone.removeClass('in hover');
        }, 100);
    });

    $(document).bind('drop dragover', function (e) {
        e.preventDefault();
    });
});


function updateField(field_container, field_name){
    $.ajax({
        type: "POST",
        url: window.location.href,
        data: {'update_field': field_name},
        success: function(data){
            if(field_container && field_container.length){
                field_container.find('.input_field').html(data);
                onUpdatedField();
            }
        },
        beforeSend: function(){
        },
        dataType: 'html'
    });
}

function onUpdatedField(){
    if($('.sortable_gallery').length){
        $( ".sortable_gallery" ).sortable({
            cursor: "url('/admin/images/closedhand.cur'), default",
            distance: 0,
            grid: [ 5, 5 ],
            update: function( event, ui ) {
                var elements = $('.sortable_gallery .image_gallery_item_container');
                var data = [];
                $.each(elements, function(key, item) {
                    data.push({
                        'el_id': $(item).attr('el_key'),
                        'el_pos': key+1
                    });
                });
                save_gallery_order_elements(data);
            }
        });
    }

    if($('.delete_file_handler').length){
        $('.delete_file_handler').each(function(key, item) {
            var title = $(item).attr('title');
            if (title.indexOf(':::') !== -1) {
                var start_index = title.indexOf(':::');
                var end_index   = title.lastIndexOf(':::');
                var params      = title.substr(start_index+3, end_index-start_index-3).split('::');
                var title       = title.substr(0, start_index) + title.substr(end_index+3);
                $(item).attr('title', title);
                $(item).attr('onclick', 'removeFile(\''+params[0]+'\',\''+params[1]+'\',\''+params[2]+'\',\''+params[3]+'\');');
            }
        });
    }
}

