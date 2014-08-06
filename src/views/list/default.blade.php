@extends('admin::default')
@section('content')

<input id="model" value="{{$module['model']}}" type="hidden">

@if (isset($module['filters']))
    <div class="filter-wrapper">
        <div>
            <div class="filter-title">
                <p>
                    Фильтр
                </p>
            </div>
            <form id="filter-data-form" method="post" @if (isset($_toggle_admin_elements['filter']) && $_toggle_admin_elements['filter']==false)style="display: none;"@endif
                <div id="filter-to-hide" >
                    <table class="table">
                        @foreach ($module['filters']  as $field_name => $field_info)
                            <tr>
                                <td class="tar vam filter-item-title">{{$field_info['title']}}</td>
                                <td>
                                    <?php $field_input_name = "filters[".($field_name)."]"; ?>
                                     <?php $field_value = (isset($filter_values[$field_name]) ? $filter_values[$field_name] : null); ?>
                                    @include ("admin::list._elements.filters.". ( $field_info['type'] ))
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="filter-tools-bar">
                        <input class="btn btn-sm btn-info" type="submit" value="Фильтр"/>
                        <a style="height: 27px;" class="btn btn-sm btn-danger" href="/{{$app_name}}/{{$module['name']}}/?filter_reset=true">Сброс</a>
                    </div>
                </div>
                <div class="clear"></div>
            </form>
        </div>
        <div class="toggle-filter cp @if (!isset($_toggle_admin_elements['filter']) || $_toggle_admin_elements['filter']==true) show @endif "><i class="fa fa-angle-double-@if (isset($_toggle_admin_elements['filter']) && $_toggle_admin_elements['filter']==false) down @else up @endif "></i></div>
    </div>
@endif

<div class="row">

    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        @include ("admin::list._list_widget")
    </article>

</div>

@stop