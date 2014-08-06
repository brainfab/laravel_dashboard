<div class="editable_field_block{if $field_error} has_errors{/if}">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-right">
                    <label class="input_label">{$field_info.title}:</label>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 text-left">
                    <input class="form-control input_text editable_field" type="password" name="{$field_input_name}" value=""/>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt10">
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-right">
                    <label class="input_label">{$field_info.re_title}:</label>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 text-left">
                    <input class="form-control input_text" type="password" name="data[re_password]" value=""/>
                    <div class="clear"></div>
                    <div class="input_description"><small>{if isset($field_info.description)}<i class="fa fa-info">&nbsp;&nbsp;</i>{$field_info.description}{/if}</small></div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            {if $field_error}
                {foreach from=$field_error}
                    <div class="input_error text-danger">{$item.message}</div>
                {/foreach}
            {/if}
        </div>
    </div>
</div>