
<div class="modal fade" id="b_lightbox">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <small>&nbsp;</small>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">закрыть</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="upload_files">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <small>&nbsp;</small>
            </div>
            <div class="select_files_wrapper">
                <div class="select_file_container">
                    <div class="select_files select_file_btn btn-lg btn btn-primary">Выбрать файлы</div>
                    <input id="file-upload" class="select_file_input input_file editable_field" type="file" name="" />
                </div>
            </div>
            <div class="modal-body">
                <div class="upload_files_list fade well" id="drag_n_drop_upload_files_container">
                    <div class="drag_n_drop_files_info">Или перетащите файлы сюда</div>
                </div>
                <div class="progress_bar_wrapper none">
                    <div class="progress progress-striped active">
                        <div class="progress-bar"  role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                            <span class="progress_bar_percent"></span>
                        </div>
                    </div>
                </div>
                <div class="success_upload"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">закрыть</button>
            </div>
        </div>
    </div>
</div>
