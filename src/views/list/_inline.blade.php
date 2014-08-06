<td class="td_left">
    <input name="items[{{$row['id']}}]" type="checkbox" class="row_item_id" id="row-item-id-{{$row['id']}}" />
</td>
@foreach ($module['fields'] as $field_name => $field_info)
    @if( isset($field_info['_in_group']) || empty($field_name) || empty($field_info))
    <?php continue; ?>
    @endif
    <td class="data_cell data_cell_{{$field_name}}">
        <?php  $object = $row; ?>
        <?php  $field_value= ''; ?>
        <?php  $field_error= null; ?>
        @if (in_array($field_info['type'], array('select','radioselect')))
            <?php  $field_input_name = "data[".($row['id'])."][".($field_info['local_field'])."]"; ?>
        @elseif(in_array($field_info['type'], array('image','imagelist','file','filelist')))
            <?php  $field_input_name = ($field_name)."_".($row['id']); ?>
        @else
            <?php  $field_input_name = "data[".($row['id'])."][".($field_name)."]"; ?>
        @endif
        @include ("admin::list._elements.".( isset($field_info['readonly']) ? "readonly.".$field_info['type'] : $field_info['type']))
    </td>
@endforeach