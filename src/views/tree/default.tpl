<div class="jarviswidget well" id="categories-tree">
<!-- widget div-->
<div>

<!-- widget edit box -->
<div class="jarviswidget-editbox">
    <!-- This area used as dropdown edit box -->

</div>
<!-- end widget edit box -->

<!-- widget content -->
<div class="widget-body">

<div id="nestable-menu">
    <a href="/admin/{$module_name}/add/" class="btn btn-success">
        Добавить&nbsp;<i class="fa fa-plus"></i>
    </a>
    <button type="button" class="btn btn-default" data-action="expand-all">
        Развернуть все
    </button>
    <button type="button" class="btn btn-default" data-action="collapse-all">
        Свернуть все
    </button>
</div>
<div class="row">
<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
    <div style="min-width: 472px;">

        <div class="dd" id="nestable">
            {$tree}
        </div>

    </div>
</div>
</div>

</div>
<!-- end widget content -->

</div>
<!-- end widget div -->

</div>
<script src="/admin/js/plugin/jquery-nestable/jquery.nestable.min.js"></script>

<script>
    {*var tree = {$tree_json};*}
    {literal}
    var updateOutput = function(e) {
        var list = e.length ? e : $(e.target);
        $.ajax({
            type: "POST",
            url: "/admin/"+ module_name +"/update_tree/",
            data: {'tree': list.nestable('serialize')},
            success: function(data){
            },
            beforeSend: function(){
            },
            dataType: 'json'
        });
    };

    $('#nestable').nestable({
        group : 1
    }).on('change', updateOutput);//.data('output', tree).trigger('change');

    // output initial serialised data
//    updateOutput($('#nestable').data('output', $('#nestable-output')));

    $('#nestable-menu').on('click', function(e) {
        var target = $(e.target), action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });
    {/literal}
</script>

<style>
    {literal}
    .dd3-content-title{
        display: inline-block;
        margin-bottom: -5px;
        max-width: 300px;
        overflow: hidden;
        white-space: nowrap;
    }
    {/literal}
</style>