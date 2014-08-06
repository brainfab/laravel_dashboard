@extends('admin::default')
@section('content')

<div class="row mb10">
    <div class="col-sm-12">
        {{{AdminMessagesHelper::process()}}}
    </div>
</div>
<div class="jarviswidget jarviswidget-color-white" id="wid-id-0" data-widget-editbutton="false" data-widget-sortable="false"  data-widget-deletebutton="false">
    <header>
        <h2 class=""></h2>
        <?php  if(isset($module['tabs']) && count($module['tabs']) > 1): ?>
            <ul class="nav nav-tabs" id="widget-tab-1">
                <?php  foreach($module['tabs'] as $key => $item): ?>
                    <li <?php  if($key == 'default'): ?> class="active"<?php endif ?> id="module-tab-<?=$key?>">
                        <a onclick="event.preventDefault();return false;" href="#module-tab-content-<?=$key?>"> <span class="hidden-mobile hidden-tablet"> <?=$item['title']?> </span> </a>
                    </li>
                <?php endforeach ?>
            </ul>
            <?php  $remainder = "0"; ?>
        <?php else: ?>
            <?php  $remainder = "1"; ?>
        <?php endif ?>

    </header><!-- widget div-->

    <div>
        <!-- widget edit box -->
        <div class="jarviswidget-editbox">

        </div><!-- end widget edit box -->

        <!-- widget content -->
        <div class="widget-body no-padding">
            <?php  if(isset($module['detail_top_actions']) && count($module['detail_top_actions'])): ?>
                <div class="widget-body-toolbar">
                    <div class="btn-group">
                        <?php foreach($module['detail_top_actions'] as $item): ?>
                            <a class="list_tab_item list_item_<?=$item['icon']?> btn btn-primary btn-sm" href="/<?=$app_name?>/<?=$module['name']?>/<?=$item['action']?>/<?=$object['id']?>"><?=$item['title']?></a>
                        <?php endforeach ?>
                    </div>
                </div>
            <?php endif ?>
            <div class="list-data-wrapper">
                <form id="form-info" method="post" enctype="multipart/form-data" class="form_info">
                    <?php  foreach($module['tabs'] as $tab_name => $tab_info) { ?>
                        <div id="module-tab-content-<?=$tab_name?>" class="module_info_tab_content<?php  if($tab_name != 'default'): ?> none <?php endif ?> tab_item">
                            <?php  $i = 1; ?>
                            <?php  foreach($tab_info['fields'] as $field_name => $field_info) { ?>
                                <div class="form-group input_block<?php  if ($i%2 == $remainder){ echo '_odd'; } ?> <?=$module['name']?>_input_block_<?=$field_name?> row">
                                    <?php  if($field_info['type']=='group') { ?>
                                        <?php if($field_info['type'] != 'translategroup' &&  $field_info['type'] != 'group' && $field_info['type'] != 'separator' && $field_info['type'] != 'password'): ?>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-right">
                                                <label class="input_label"><?=$field_info['title']?><?php if(isset($field_info['translatable'])): ?> <img src="images/admin/flag_{{$current_lang}}.gif" alt=""/><?php endif ?>:</label>
                                            </div>
                                        <?php endif ?>
                                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 text-left">
                                            <?php
                                                $field_value = isset($object[$field_name]) ? $object[$field_name] : '';
                                                $field_error = isset($errors) && is_array($errors) && isset($errors[$field_name]) ? $errors[$field_name] : null;

                                                if(in_array($field_info['type'], array('select','radioselect'))) {
                                                    $field_input_name = "data[".($field_info['local_field'])."]";
                                                } elseif(in_array($field_info['type'], array('image','imagelist','file','filelist'))) {
                                                    $field_input_name = $field_name;
                                                } else {
                                                    $field_input_name = "data[".($field_name)."]";
                                                }
                                            ?>
                                            @include ("admin::list._elements.".( isset($field_info['readonly']) ? "readonly.".$field_info['type'] : $field_info['type'] ))
                                            <div class="clear"></div>
                                        </div>
                                    <?php  } else { ?>
                                        <?php if($field_info['type'] != 'translategroup' &&  $field_info['type'] != 'group' && $field_info['type'] != 'separator' && $field_info['type'] != 'password'): ?>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-right">
                                                <label class="input_label"><?=$field_info['title']?><?php if(isset($field_info['translatable'])): ?> <img src="images/admin/flag_{{$current_lang}}.gif" alt=""/><?php endif ?>:</label>
                                            </div>
                                        <?php endif ?>
                                        <div class="@if ($field_info['type']=='password') col-xs-12 col-sm-12 col-md-12 col-lg-12 @else col-xs-8 col-sm-8 col-md-8 col-lg-8 text-left @endif">
                                            <div class="input_field">
                                                <?php
                                                    $field_value = isset($object[$field_name]) ? $object[$field_name] : '';
                                                    $field_error = isset($errors) && is_array($errors) && isset($errors[$field_name]) ? $errors[$field_name] : null;

                                                    if(in_array($field_info['type'] ,array('select','radioselect'))) {
                                                        $field_input_name = "data[".($field_info['local_field'])."]";
                                                    } elseif(in_array($field_info['type'], array('image','imagelist','file','filelist'))) {
                                                        $field_input_name = $field_name;
                                                    } else {
                                                        $field_input_name = "data[".($field_name)."]";
                                                    }
                                                ?>
                                                @include ("admin::list._elements.".( isset($field_info['readonly']) ? "readonly.".$field_info['type'] : $field_info['type'] ))
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    <?php  } ?>
                                </div>
                            <?php  } ?>
                            <?php if(isset($tab_info['includes'])): ?>
                                <?php foreach($tab_info['includes'] as $include_file_name): ?>
                                    @include('admin::'.$include_file_name)
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>
                    <?php  } ?>
                </form>
            </div>

            <div class="widget-footer ">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="btn-group  pull-left">
                            <?php if($module['parent'] == 'List'): ?>
                                <a style="padding: 7px;" href="/<?=$app_name?>/<?=$module['name']?>/" class="action fa fa-reply btn btn-info btn-sm">&nbsp;</a>
                            <?php endif ?>

                            <?php if(!isset($hide_apply_button) && $module['parent'] != 'Single'): ?>
                                <div style="padding: 4px;" data-loading-text="сохранение..." title="Сохранить изменения и продолжить редактирование" class="button btn btn-warning btn-sm" onclick="$(this).addClass('disabled');showLoader();$('#form-info').submit();" >применить</div>
                            <?php endif ?>
                            <div style="padding: 4px;" title="Сохранить изменения и вернуться в список" onclick="$(this).addClass('disabled');showLoader();$('#form-info').attr('action', window.location.href + '?back_to_list=true').submit();return false;" class="button ml20 btn btn-success btn-sm" id="save-btn">сохранить</div>
                        </div>
                    </div>
                </div>
            </div>


        </div><!-- end widget content -->
    </div><!-- end widget div -->

</div>

@stop