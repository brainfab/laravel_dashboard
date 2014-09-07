<ul class="list-group" >
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
    @if (!isset($file['link']) || empty($file['link']))<?php continue; ?> @endif
    <li style="width: 130px;" class="list-group-item">файл загружен <a href="{{$file['link']}}" class="c_b btn btn-xs btn-primary">скачать</a></li>
@endforeach
</ul>