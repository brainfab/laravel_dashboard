@if (isset($object['id']) && intval($object['id']))

@include ('admin::files_upload_settings')


    <div class="editable_field_block @if (isset($field_error) && $field_error) has_errors @endif">

        @include("admin::files_upload_btn")

        @if (isset($field_value['link']))
            <div style="width: 370px;" class="well well-sm">
                <a href="{{$field_value['link']}}" class="c_b btn btn-sm btn-primary">{{$field_value['full_name']}}</a>
                @include("admin::file_delete_btn")
            </div>
        @endif

        <div class="errors_block">
            @if (isset($field_error) && is_array($field_error))
                @foreach ($field_error as $item_error)
                    <div class="input_error">{{$item_error}}</div>
                @endforeach
            @endif
        </div>
    </div>
@else
    <div class="editable_field_block{if $field_error} has_errors{/if}">
        Для добавления файла нажмите кнопку "сохранить" или "применить"
    </div>
@endif


