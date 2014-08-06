<span class="datepicker_readonly">
    @if (isset($field_info['format']))
    <?php $format = $field_info['format']; ?>
    @elseif (isset($field_info['timepicker']))
    <?php $format="Y-m-d_H:i"; ?>
    @else
    <?php $format = "Y-m-d"; ?>
    @endif
{{{ DateHelper::process($field_value, $format) }}}
</span>