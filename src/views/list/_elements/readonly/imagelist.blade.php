@foreach ($field_value as $file)
    @if (isset($file['link']))
        @if (isset($file['sizes']))
            <?php $size = array_shift($file['sizes']); ?>
            <img height="40" alt="" src="{{$size['link']}}"/>
        @else
            <img height="40" alt="" src="{{$size['link']}}"/>
        @endif
    @else
    <img src="blank.gif" alt=""/>
    @endif
@endforeach