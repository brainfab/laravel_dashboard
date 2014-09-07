<span class="datepicker_readonly">
    @if (isset($field_info['format']))
    <?php $format = $field_info['format']; ?>
    @elseif (isset($field_info['timepicker']))
    <?php $format="d-m-Y_H:i"; ?>
    @else
    <?php $format = "d-m-Y"; ?>
    @endif
{{{ SmallTeam\Admin\DateHelper::process($field_value, $format) }}}
</span>