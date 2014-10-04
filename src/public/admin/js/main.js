var toggle_menu = 'open';
var submit_login_form = false;

$(document).ready(function(){
    if(typeof pageSetUp != 'undefined' && $.type(pageSetUp)=="function")
        pageSetUp();

    /* Sidebar tree view */

    $('input[type="checkbox"].checkbox_handler, input[type="radio"].checkbox_handler').bind('click', function(event){
        event.stopPropagation();
        if($(this).prop('checked')) {
            var id = $(this).attr('id').replace('checkbox-handler-', '');
            if($(this).parent().find('#checkbox-input-'+id).length) {
                $(this).parent().find('#checkbox-input-'+id).val(1).attr('value', 1);
            }
        } else {
            var id = $(this).attr('id').replace('checkbox-handler-', '');
            if($(this).parent().find('#checkbox-input-'+id).length) {
                $(this).parent().find('#checkbox-input-'+id).val(0).attr('value', 0);
            }
        }
    });

    if($('#sortable').length){
        $( "#sortable" ).sortable({
            cursor: "url('/admin/images/closedhand.cur'), default",
            distance: 10,
            grid: [ 20, 20 ],
            update: function( event, ui ) {
                var elements = $('.table-data-list tbody tr');
                var data = [];
                $.each(elements, function(key, item) {
                    data.push({
                        'el_id': $(item).attr('el_key'),
                        'el_pos': key+1
                    });
                });
                save_order_elements(data);
            }
        });
    }

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

    if($('.filter-wrapper').length) {
        $( ".filter-wrapper" ).draggable({
            containment: "parent",
            snap: true,
            snapMode: "both",
            opacity: 0.95,
            stack: "#page-wrapper"
        });
    }

    if($('.toggle-filter').length){
        $('.toggle-filter').click(function(){
            if($(this).hasClass('show')){
                $(this).removeClass('show').find('i').removeClass('fa-angle-double-up').addClass('fa-angle-double-down');
                $('#filter-data-form').hide();
                saveToggleAdminElements('filter', 0);
            }else{
                $(this).addClass('show').find('i').removeClass('fa-angle-double-down').addClass('fa-angle-double-up');
                $('#filter-data-form').show();
                saveToggleAdminElements('filter', 1);
            }
        });
    }
    if($('.left_nav_custom').length && false){
        $('.left_nav_custom').resizable({
            distance: 30,
            grid: [ 10, 10 ],
            minHeight: 600
        });
    }

    if($('#save-btn').length){
        $('#save-btn').click(function(){
            $('#save-btn').parents('form').submit();
        });
    }
    if($('.show-loader').length){
        $('.show-loader').click(function(){
            if($('.overlay_form_edit').length){
                $('.overlay_form_edit').css({'display': 'block'});
                $('body').css({'overflow': 'hidden'});
            }
        });
    }
    if($('.dropdown-toggle-custom').length){
        $('.dropdown-toggle-custom a.dropdown').click(function(){
            if($(this).parent('.dropdown-toggle-custom').length){
                var submenu = $(this).parent('.dropdown-toggle-custom');
                $('.dropdown-toggle-custom').removeClass('skip');
                $(submenu).addClass('skip');
                $('.dropdown-toggle-custom').each(function(key, item){
                    if(!$(item).hasClass('skip')){
                        $(item).removeClass('open').find('a.dropdown span.menu-arrow').removeClass('fa-angle-down').addClass('fa-angle-left');
                    }
                });

                if($(submenu).hasClass('open')){
                    $(submenu).removeClass('open').find('a.dropdown span.menu-arrow').removeClass('fa-angle-down').addClass('fa-angle-left');
                }else{
                    $(submenu).addClass('open').find('a.dropdown span.menu-arrow').removeClass('fa-angle-left').addClass('fa-angle-down');
                }
            }
            return false;
        });
    }

    if($('#ffacl-login-form').length){
        $('.small-team-copyright').show('slide',{direction:'down','distance':50},1000);

        $('.login_form_container').show('explode', {}, 1000, function() {
            if($('.shake_it').length) {
                $('.login_form_container input[type="text"], .login_form_container input[type="password"]').addClass('has_error_custom');
                $('.login_box').effect('shake',500);
            }
        });

        $('#ffacl-login-form').submit(function(e){
            if(submit_login_form)
                return true;
            var error = false;
            $('.login_form_container input[type="text"], .login_form_container input[type="password"]').removeClass('has_error_custom');
            $('.login_form_container input[type="text"], .login_form_container input[type="password"]').each(function(key, item){
                var value = $.trim($(item).val());
                if(value == ''){
                    $(item).addClass('has_error_custom');
                    error = true;
                }
            });
            if(error){
                $('.login_box').effect('shake',500);
                return false;
            }
            $('.login_form_container').effect( 'explode', {}, 1000, function(){
                submit_login_form = true;
                $('#ffacl-login-form').submit();
            });
            return false;
        });
    }

    if($('.tools-list-btn').length){
        $('.tools-list-btn').on('contextmenu', function() {
            $(this).parent().toggleClass('open');
            return false;
        });
    }

    if($('#general-checkbox').length){
        $('#general-checkbox').change(function(){
            if($('input[type="checkbox"].row_item_id').length){
                var value = this.checked ? true : false;

                $.each($('input[type="checkbox"].row_item_id'), function(key,item){
                    $(item).prop('checked', value);
                });
            }
        });
    }

    if($('.go-to-top-border').length){
        $( window ).scroll(function(e) {
            var scroll = $( window ).scrollTop();
            if(scroll>=600){
                $('.go-to-top-border').css('display', 'block');
            }else{
                $('.go-to-top-border').css('display', 'none');
            }
        });

        $('.go-to-top-border').click(function(){
            $("html, body").animate({ scrollTop: 0 }, "slow");
        });
    }

    if($('.toggle-main-menu').length){
        $('.toggle-main-menu').click(function(){
            if($(this).hasClass('open')){
                $('.left_nav_custom').animate({'left': -($('.left_nav_custom').width())},500);
                $('.toggle-main-menu').css({'left': -($('.left_nav_custom').width()+1)});
                $('.toggle-main-menu-btn').addClass('fa-angle-double-right');
                $('.toggle-main-menu-btn').removeClass('fa-angle-double-left');
                $('#wrapper').css({'padding-left':0});

                $(this).addClass('close').removeClass('open');
                saveToggleAdminElements('main_menu', 0);
            }else{
                $('.left_nav_custom').animate({'left': ($('.left_nav_custom').width())},500);
                $('.toggle-main-menu').animate({'left': 0},550);
                $('.toggle-main-menu-btn').removeClass('fa-angle-double-right');
                $('.toggle-main-menu-btn').addClass('fa-angle-double-left');
                $('#wrapper').css({'padding-left':225});
                $(this).addClass('open').removeClass('close');
                saveToggleAdminElements('main_menu', 1);
            }
        });
    }

    if($('.nav-tabs li a').length){
        $('.nav-tabs li a').click(function(){
            $('.nav.nav-tabs li').removeClass('active');
            $(this).parent().addClass('active');
            var tab = $(this).attr('href');
            if($(tab).length){
                $('.tab_item').addClass('none');
                $(tab).removeClass('none');
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

    if($('.group_delete_handler').length) {
        $('.group_delete_handler').click(function(evt) {
            if(!$('.select_this_item_input:checked').length){
                alert('Выберите хоть один элемент.');
                return false;
            }

            if (!confirm('Вы точно хотите удалить все выбранные элементы ?')) return false;
            $('#table-data-form').attr('action', $('#table-data-form').attr('action') + 'delete/');
            $('#table-data-form').submit();
        });
    }

    if($('.group_action_handler').length){
        $('.group_action_handler').click(function(){
            if ($(this).attr('id').indexOf('confirm') > -1) {
                if (!confirm('Вы уверены?')) return false;
            }

            $('#table-data-form').attr('action', $('#table-data-form').attr('action') + $(this).attr('id').split('-').pop() + '/');
            $('#table-data-form').submit();
        });
    }

    if($('.sort_handler_').length){
        $('.sort_handler_').each(function(key, item) {
            $(item).click(function() {
                var field = $(item).attr('id').split('-').pop();
                var uri = window.location.href;
                uri += window.location.search.length ? '&' : '?';
                uri += 'sort=' + field;
                window.location.href = uri;
            });
        });
    }

    if ($('#add-empty-row')) {
        $('#add-empty-row').click(function(){

            $.ajax({
                type: "POST",
                url: '/' + app_name + '/' + module_name + '/get_blank_row/',
                data: {},
                success: function(data){
                    if (data != 'false') {
                        if ($('#no-data-cell')) $('#no-data-cell').remove();
                        if($('.sortability_icon_cell').length){
                            data = '<td></td>'+data;
                        }
                        var tr = $('<tr class="'+ ($('table-data-form').find('tr').length % 2 == 0 ? 'data_row data_row_odd': 'data_row') +'">'+ data +'</tr>');
                        $('#table-data-form').find('table tbody').append(tr);
                        $('body').animate({'scrollTop': $('window').height()}, 100);

                        var checkboxes = tr.find('input[type="checkbox"].checkbox_handler, input[type="radio"].checkbox_handler');
                        if(checkboxes && checkboxes.length) {
                            checkboxes.bind('click', function(event) {
                                if($(this).prop('checked')) {
                                    var id = $(this).attr('id').replace('checkbox-handler-', '');
                                    if($(this).parent().find('#checkbox-input-'+id).length) {
                                        $(this).parent().find('#checkbox-input-'+id).val(1).attr('value', 1);
                                    }
                                } else {
                                    var id = $(this).attr('id').replace('checkbox-handler-', '');
                                    if($(this).parent().find('#checkbox-input-'+id).length) {
                                        $(this).parent().find('#checkbox-input-'+id).val(0).attr('value', 0);
                                    }
                                }
                            });
                        }
                    }
                },
                beforeSend: function(){
                },
                dataType: 'html'
            });


        });
    }

    if($('.checkbox_handler').length){
        $('.checkbox_handler').change(function(){
            $(this).parent().find('input.editable_field').attr('value', (this.checked ? 1 : 0));
        });
    }

});


function saveToggleAdminElements(el, val) {
    $.ajax({
        type: "POST",
        url: "/admin/save_toggle_elements/",
        data: {'element': el, 'value':val},
        success: function(data){
        },
        beforeSend: function(){
        },
        dataType: 'json'
    });
}

function save_order_elements(data) {
    $.ajax({
        type: "POST",
        url: "/admin/save_order_elements/",
        data: {'data': data, 'model': model_name},
        success: function(data){
        },
        beforeSend: function(){
        },
        dataType: 'json'
    });
}
function save_gallery_order_elements(data) {
    $.ajax({
        type: "POST",
        url: "/admin/save_order_gallery_elements/",
        data: {'data': data, 'model':'ProductImage'},
        success: function(data){
        },
        beforeSend: function(){
        },
        dataType: 'json'
    });
}

function openLightBox(_this) {
    var src = $(_this).attr('original-size');
    $('#b_lightbox.modal .modal-body').css('text-align', 'center').html('<img style="width: 538px;" src="'+src+'">');

    $('#b_lightbox').modal('toggle');
}


function removeFile(uri, id, rel, name) {
    $.ajax({
        type: "POST",
        url: '/'+uri+'/',
        data: {
            'name': name,
            'rel': rel
        },
        success: function() {
            document.location.reload();
        },
        beforeSend: function() {
        },
        dataType: 'json'
    });
}

function showLoader(){
    if($('.overlay_form_edit').length){
        $('.overlay_form_edit').css({'display': 'block'});
        $('body').css({'overflow': 'hidden'});
    }
}

function hideLoader(){
    if($('.overlay_form_edit').length){
        $('.overlay_form_edit').css({'display': 'none'});
        $('body').css({'overflow': 'auto'});
    }
}

function reloadFieldOnChange(field_container, action, _this) {
    $.ajax({
        type: "POST",
        url: '/admin/'+action+'/',
        data: {'value': $(_this).val()},
        success: function(data){
            var select = $('.'+field_container).find('select');
            select.html('');
            if(data) {
                var html = '';
                var i = 0;
                while(data[i]){
                    html += '<option '+(i==0 ? 'selected="selected"' : '')+' value="'+data[i].id+'">'+data[i].title+'</option>'
                    i++;
                }

                select.html(html);
            }
        },
        beforeSend: function(){
        },
        dataType: 'json'
    });
}