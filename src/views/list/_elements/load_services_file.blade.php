<div class="editable_field_block @if (isset($field_error) && $field_error) has_errors @endif">

    <input type="file" name="services_list" >

    <a class="btn btn-warning btn-xs mt10" href="example">Скачать пример файла</a>

    <div class="errors_block">
        @if (isset($field_error) && is_array($field_error))
            @foreach ($field_error as $item_error)
                <div class="input_error">{{$item_error}}</div>
            @endforeach
        @endif
    </div>
</div>