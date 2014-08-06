/**
 * Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {

    // Just put the name of your custom skin here.
//    config.skin = 'moono-light';
//    config.skin = 'moono-dark';
    config.skin = 'office2013';
//    config.skin = 'kama';
//    config.skin = 'Moono_blue';
    config.toolbar = 'Basic';
    config.language = 'ru';
    config.resize_enabled = false;
    config.height = 500;

    config.toolbar = [
        [ 'Source', 'Preview','-', 'Undo', 'Redo','-', 'Find', 'Replace', '-', 'SelectAll', 'RemoveFormat' ],'/',
        ['Bold', 'Italic', 'Underline', 'Strike','-','Subscript','Superscript','-','NumberedList','BulletedList', '-','Outdent','Indent','Blockquote','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','Link','Unlink','Anchor','-',"Image", 'Table','SpecialChar', 'HorizontalRule' ],'/',
        ['Format', 'Font', 'FontSize','-','TextColor','BGColor','Maximize','ShowBlocks','About' ]
    ];
//    config.filebrowserWindowWidth = '900';
//    config.filebrowserWindowHeight = '480';
    config.filebrowserBrowseUrl = '/admin/kcfinder-master/browse.php?opener=ckeditor&type=files';
    config.filebrowserImageBrowseUrl = '/admin/kcfinder-master/browse.php?opener=ckeditor&type=images';
    config.filebrowserFlashBrowseUrl = '/admin/kcfinder-master/browse.php?opener=ckeditor&type=flash';
    config.filebrowserUploadUrl = '/admin/kcfinder-master/upload.php?opener=ckeditor&type=files';
    config.filebrowserImageUploadUrl = '/admin/kcfinder-master/upload.php?opener=ckeditor&type=images';
    config.filebrowserFlashUploadUrl = '/admin/kcfinder-master/upload.php?opener=ckeditor&type=flash';
};

