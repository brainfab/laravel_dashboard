@if (isset($object['id']) && intval($object['id']))
    <div class="editable_field_block @if (isset($field_error) && $field_error) has_errors @endif">

        @include("admin::files_upload_btn")

        <div class="errors_block">
            @if (isset($field_error) && is_array($field_error))
                @foreach ($field_error as $item_error)
                    <div class="input_error">{{$item_error}}</div>
                @endforeach
            @endif
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <ul class="list-group gp_files_list">
                    <?php $it = 1; ?>
                    @foreach ($field_value as $file)
                        @if (isset($field_info['filename']))
                            <?php $file_info = $file; ?>
                            <?php $file = $file[$field_info['filename']]; ?>
                        @else
                            <?php $file_info = $object; ?>
                        @endif

                        @if (isset($field_info['filename']))
                            <?php $filename = $field_info['filename']; ?>
                        @else
                            <?php $filename = $field_name; ?>
                        @endif
                        @if (!isset($file['link']) || empty($file['link'])) <?php continue; ?> @endif
                        <li class="list-group-item">
                            <a class="" href="/{{$file['link']}}" >{{$file['full_name']}}<small>({{$file['size']}})</small></a>
                            @include("admin::file_delete_btn")
                        </li>
                        <?php $it++; ?>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@else
    <div class="editable_field_block {{{ isset($field_error) && !empty($field_error) ? 'has_errors' : '' }}}">
        Для добавления файлов нажмите кнопку "сохранить" или "применить"
    </div>
@endif