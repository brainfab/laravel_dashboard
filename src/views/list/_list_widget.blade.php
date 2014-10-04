@if (!isset($just_content) || !$just_content)
<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-0" data-widget-editbutton="false" data-widget-sortable="false" data-widget-deletebutton="false">
<header>
    <span class="widget-icon"> <i class="fa fa-table"></i> </span>
    <h2>{{$module['title']}}</h2>
</header>

<div role="content">
@endif

    <form id="table-data-form" action="/{{$app_name}}/{{$module['name']}}/" method="post" enctype="multipart/form-data">
        <div>
            <div class="jarviswidget-editbox">
            </div>

            <div class="widget-body no-padding">
                {{ SmallTeam\Admin\AdminMessagesHelper::process() }}
                <div class="widget-body-toolbar">
                    <div class="btn-group">
                        @if (isset($module['parent']) && $module['parent'] == 'Inline')
                            <input id="inline_module_type" value="1" type="hidden">
                        @endif
                        <a class="list_tab_item list_item_filter list_item_active btn btn-sm btn-warning" href="/{{$app_name}}/"><i class="fa fa-reply"></i></a>
                        @if (isset($module['actions']['add']))
                            @if (isset($module['parent']) && $module['parent'] == 'Inline')
                                <span title="Добавить {{{ isset($module['single']) ? $module['single'] : '' }}}" id="add-empty-row" class="list_tab_item list_item_add cp btn-primary btn-sm btn" href="/{{$app_name}}/{{$module['name']}}/add/{{{ isset($id_category) ? 'c/'.$id_category : '' }}}">Добавить <i class="fa fa-plus"></i></span>
                            @else
                                <a title="Добавить {{{ isset($module['single']) ? $module['single'] : '' }}}" class="list_tab_item list_item_add btn-primary btn-sm btn" href="/{{$app_name}}/{{$module['name']}}/add/{{{ isset($id_category) ? 'c/'.$id_category : '' }}}">Добавить <i class="fa fa-plus"></i></a>
                            @endif
                        @endif
                        @if (isset($module['custom_default_top']) && count($module['custom_default_top']))
                            @foreach ($module['custom_default_top'] as $tpl)
                                @include ('admin::custom.'.$tpl)
                            @endforeach
                        @endif

                        @if (isset($module['top_actions']) && count($module['top_actions']))
                            @foreach ($module['top_actions'] as $item)
                                <a class="list_tab_item list_item_{{$item['icon']}}" href="/{{$app_name}}/{{$module['name']}}/{{{ isset($item['action']) ? $item['action'] : '' }}}">{{$item['title']}}</a>
                            @endforeach
                        @endif

                        @if (isset($module['custom_top_actions']) && count($module['custom_top_actions']))
                            @foreach( $module['custom_top_actions'] as $item)
                                <a class="list_tab_item list_item_{{$item['icon']}}" href="/{{$app_name}}/{{$item['module_name']}}/{{{ isset($item['action']) ? $item['action'] : '' }}}">{{$item['module_title']}}</a>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="table-responsive" style=" overflow-y: auto; padding-bottom: 107px;background-color: #f9f9f9;">

                    <table class="table table-bordered table-striped table-hover tablesorter table-data-list">
                        <thead>
                        <tr class="header_row warning">
                            @if (isset($module['sortability']))
                                <td class="sortability_icon_cell_h"></td>
                            @endif

                            <td class="td_left header tacw40"><input id="general-checkbox" type="checkbox"/></td>

                            @if (isset($module['parent']) && $module['parent'] != 'Inline')
                                <td class="tools-cell-in-list" style="text-align: center; width: 118px;"><div style="width: 98px;"></div></td>
                            @endif

                            @foreach( $module['fields'] as $field_name => $field_info)
                                @if (isset($field_info['_in_group']))
                                    <?php continue; ?>
                                @endif
                                <td class="header" @if ( $field_name==$key_field) style="width: 50px;" @endif>
                                    <span @if ( isset($field_info['sortable']))class="action cp htdn sort_handler_<?php if(isset($sort['field']) && $sort['field'] == $field_name): ?> sorted_{{$sort['dir']}}@endif" id="column-{{$field_name}}"@endif>{{$field_info['title']}}</span> @if ( isset($sort['field']) && $sort['field'] == $field_name) <i class="fa fa-sort-amount-{{$sort['dir']}}"></i>&nbsp;&nbsp; @endif
                                </td>
                            @endforeach
                        </tr>
                        </thead>
                        @if (count($table_data))
                            <tbody @if (isset($module['sortability']))id="sortable"@endif style="border-bottom: 1px solid #cdcdcd;">
                            <?php $table_data_i = 1; ?>
                            @foreach ($table_data as $row)
                                <tr el_key="{{$row[$key_field]}}" class="data_row @if ($table_data_i%2 == 0) data_row_odd @endif ">
                                    @if (isset($module['sortability']))
                                        <td class="sortability_icon_cell"></td>
                                    @endif
                                    <td class="td_left">
                                        <input name="items[{{$row[$key_field]}}]" type="checkbox" class="tacw40 row_item_id select_this_item_input" id="row-item-id-{{$row[$key_field]}}" />
                                    </td>
                                    @if (isset($module['parent']) && $module['parent'] != 'Inline')
                                        <td class="{{$module['name']}}_actions_cell">
                                            <div class="btn-group">
                                                @if (isset($module['parent']) && $module['parent'] == 'List' && isset($module['actions']['edit']))
                                                    <a class="edit_object btn btn-sm btn-success" title="редактировать" href="/{{$app_name}}/{{$module['name']}}/edit/{{$row[$key_field]}}/"><i class="fa fa-edit"></i></a>
                                                @endif

                                                @if (isset($module['parent']) && $module['parent'] == 'List' && isset($module['actions']['delete']) && $module['actions']['delete'])
                                                    <a onclick="if(!confirm('Удалить выбранный элемент?')) return false;" class="edit_object btn btn-sm btn-danger" title="удалить" href="/{{$app_name}}/{{$module['name']}}/delete_item/{{$row[$key_field]}}/"><i class="fa fa-times"></i></a>
                                                @endif
                                                <a href="#" style="width: 34px;" class="dropdown-toggle btn btn-info btn-sm tools-list-btn" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
                                                <ul class="dropdown-menu tal">
                                                    @if (isset($module['parent']) && $module['parent'] == 'List' && isset($module['actions']['edit']))
                                                        <li>
                                                            <a class="edit_object" title="редактировать" href="/{{$app_name}}/{{$module['name']}}/edit/{{$row[$key_field]}}/"><i class="fa fa-edit"></i> редактировать</a>
                                                        </li>
                                                    @endif
                                                    @if (isset($module['parent']) && $module['parent'] == 'List' && isset($module['actions']['delete']) && $module['actions']['delete'])
                                                        <li>
                                                            <a onclick="if(!confirm('Удалить выбранный элемент?')) return false;" class="edit_object" title="удалить" href="/{{$app_name}}/{{$module['name']}}/delete_item/{{$row[$key_field]}}/"><i class="fa fa-times"></i> удалить</a>
                                                        </li>
                                                    @endif
                                                    @if (isset($module['object_actions']) && is_array($module['object_actions']))
                                                        @foreach ($module['object_actions'] as $item)
                                                            @if (isset($item['secured']) || !isset($item['secured']))
                                                                <?php $obj_link = (isset($item['link']) ? $app_name ."/". str_replace('%id%',$row[$key_field], $item['link']) : ($app_name)."/".( $module['name'] )."/" . ($item['action']) . "/" . ($row[$key_field])); ?>
                                                                <li>
                                                                    <a class="{{$item['css_class']}}" href="/{{$obj_link}}" title="{{$item['title']}}"><i class="fa fa-circle"></i>{{{ isset($item['show_title']) ? $item['title'] : '' }}}</a>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    @endif
                                    @foreach ($module['fields'] as $field_name => $field_info)
                                        @if( isset($field_info['_in_group']))
                                            <?php continue; ?>
                                        @endif
                                        <td class="@if (isset($field_info['align']))data-cell-align-{{$field_info['align']}} @else tac @endif data_cell data_cell_{{$field_name}} {{$module['name']}}_data_cell_{{$field_name}}">
                                            @if(isset($module['parent']) &&  $module['parent'] != 'Inline')
                                                @if( isset($field_info['link']))<a href="/{{$app_name}}/{{$module['name']}}/edit/{{$row[$key_field]}}"> @endif
                                                <span<?php if(isset($field_info['max_height'])): ?> style="max-height: {{$field_info['max_height']}}px; overflow: hidden; display: block" @endif >
                                                <?php $object = $row; ?>
                                                <?php $field_value = (isset($object[$field_name]) ? $object[$field_name] : ''); ?>
                                                @include("admin::list._elements.readonly.".($field_info['type']))
                                        </span>
                                                @if (isset($field_info['link']))</a> @endif
                                            @else
                                                <?php $object = $row; ?>
                                                <?php $field_value = (isset($object[$field_name]) ? $object[$field_name] : ''); ?>
                                                @if( $key_field == $field_name && isset($object[$key_field]) && !intval($object[$key_field]))
                                                    <?php $field_value = ''; ?>
                                                @endif
                                                <?php $field_error = ((isset($errors) && is_array($errors) && isset($errors[$row[$key_field]][$field_name])) ? $errors[$row[$key_field]][$field_name] : null); ?>
                                                @if( in_array($field_info['type'], array('select','radioselect')) )
                                                    <?php $field_input_name = "data[".($row[$key_field])."][".($field_info['local_field'])."]"; ?>
                                                @elseif (in_array($field_info['type'], array('image', 'imagelist', 'file', 'filelist')))
                                                    <?php $field_input_name = ($field_name)."_".($row[$key_field]); ?>
                                                @else
                                                    <?php $field_input_name = "data[".($row[$key_field])."][".($field_name)."]"; ?>
                                                @endif
                                                @include ("admin::list._elements.".( isset($field_info['readonly']) ? "readonly.".$field_info['type'] : $field_info['type'] ))
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                                <?php $table_data_i++; ?>
                            @endforeach
                            </tbody>
                        @else
                            <tr id="no-data-cell">
                                <td colspan="100" style="text-align: center; padding: 0px;">
                                    <div class="alert alert-info no-margin fade in">
                                        <i class="fa-fw fa fa-info"></i>
                                        Нет данных для отображения
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </table>
                </div>

                <div class="widget-footer ">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="btn-group  pull-left">
                                @if (isset($module['actions']['delete']))
                                    <span class="group_delete_handler btn btn-danger btn-sm">удалить</span>
                                @endif
                                @if (isset($module['group_actions']) && count($module['group_actions']))
                                    @foreach ($module['group_actions'] as $item)
                                        <span class="group_action_handler  btn btn-default btn-sm" id="action{{{ isset($item['confirm']) ? '-confirm' : '' }}}-{{$item['action']}}">{{$item['title']}}</span>
                                    @endforeach
                                @endif
                                @if (isset($module['parent']) && $module['parent'] == 'Inline' && (isset($module['actions']['add']) || isset($module['actions']['edit'])))
                                    <span onclick="showLoader();$('#table-data-form').submit()" class="button ml20 cp inline_handler button btn btn-success btn-sm">сохранить</span>
                                    <a href="/{{$app_name}}/{{$module['name']}}/" class="button inline_handler cp ml20 btn-warning btn btn-sm">отмена</a>
                                @endif
                            </div>
                        </div>
                        @if (isset($module['per_page']) && isset($module['parent']) && $module['parent'] != 'Single')
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">@include ("admin::list._paging")</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
@if (!isset($just_content) || !$just_content)
</div>
</div>
@endif

@stop