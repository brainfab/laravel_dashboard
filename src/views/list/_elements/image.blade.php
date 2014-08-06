@if (isset($object) && $object[$key_field])
    <div class="editable_field_block @if (isset($field_error) && $field_error) has_errors @endif">

        <div id="image-preview-{{$field_name}}-{{$object[$key_field]}}" class="col-sm-6 col-md-4" style="padding: 0;">
            @if (isset($field_value) && isset($field_value['link']))
                <div class="thumbnail">
                    @if (isset($field_value['sizes']))
                        <?php $size = array_shift($field_value['sizes']); ?>
                        <img onclick="openLightBox(this);" original-size="{{$field_value['link']}}" src="{{$size['link']}}" style="display:block;"/>
                    @else
                        <img onclick="openLightBox(this);" original-size="{{$field_value['link']}}" src="{{$field_value['link']}}" style="width:200px;display:block;"/>
                    @endif
                </div>
            @endif

            <div class="caption">
                @include("admin::files_upload_btn")
                @if (((!isset($field_info['delete'])) || (isset($field_info['delete']) && $field_info['delete'])) && (isset($field_value) && isset($field_value['link'])))
                    <div class="image_btn_container">
                        <span title="Удалить файл:::admin/{{$module['name']}}/delete_file/{{$object[$key_field]}}::image-preview-{{$field_name}}-{{$object[$key_field]}}::{{$field_name}}::{{$field_value['full_name']}}:::" class=" btn btn-xs btn-danger c_r delete_file_handler">удалить</span>
                    </div>
                @endif
                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="input_description"><small>@if (isset($field_info['description']))<i class="fa fa-info">&nbsp;&nbsp;</i>{{$field_info['description']}} @endif</small></div>
        <div class="errors_block">
            @if (isset($field_error) && $field_error)
                @foreach ($field_error as $item_error)
                    <div class="input_error">{{$item_error['message']}}</div>
                @endforeach
            @endif
        </div>
    </div>
@else
    <div class="editable_field_block @if (isset($field_error) && $field_error) has_errors @endif">
        Для добавления изображения нажмите кнопку "сохранить" или "применить"
    </div>
@endif

