@if (isset($object) && $object[$key_field])

@include ('admin::files_upload_settings')

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
                        @include("admin::file_delete_btn")
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
                    <div class="input_error">{{$item_error}}</div>
                @endforeach
            @endif
        </div>
    </div>
@else
    <div class="editable_field_block @if (isset($field_error) && $field_error) has_errors @endif">
        Для добавления изображения нажмите кнопку "сохранить" или "применить"
    </div>
@endif

