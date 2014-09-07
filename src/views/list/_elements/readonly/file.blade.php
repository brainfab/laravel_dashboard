@if (isset($field_value) && isset($field_value['link']))
файл загружен <a href="{{$field_value['link']}}" class="c_b btn btn-xs btn-primary">скачать</a><br/>
@else
<span>No file</span>
@endif