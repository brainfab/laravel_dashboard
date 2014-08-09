<div class="editable_field_block @if (isset($field_error) && $field_error) has_errors @endif">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-right">
                    <label class="input_label">{{$field_info['title']}}:</label>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 text-left">
                    <input class="form-control input_text editable_field" type="password" name="{{$field_input_name}}" value=""/>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt10">
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-right">
                    <label class="input_label">{{{ isset($field_info['re_title']) ? $field_info['re_title'] : 'Повторите пароль'  }}}:</label>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 text-left">
                    <input class="form-control input_text" type="password" name="data[re_password]" value=""/>
                    <div class="clear"></div>
                    <div class="input_description"><small>@if (isset($field_info['description']))<i class="fa fa-info">&nbsp;&nbsp;</i>{{$field_info['description']}} @endif </small></div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        @if (isset($field_error) && is_array($field_error))
            @foreach ($field_error as $item_error)
                <div class="input_error">{{$item_error}}</div>
            @endforeach
        @endif
        </div>
    </div>
</div>