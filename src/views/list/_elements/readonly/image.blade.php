@if (isset($field_value) && isset($field_value['link']))
    @if (isset($field_value['sizes']))
        <?php $size = array_shift($field_value['sizes']); ?>
        <img height="40" alt="" src="{{$size['link']}}"/>
    @else
        <img height="40" alt="" src="{{$field_value['link']}}"/>
    @endif
@else
    <img src="/admin/images/blank.gif" alt=""/>
@endif