<?php
namespace SmallTeam\Admin;
/**
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @copyright SmallTeam (c) 2014
 */

abstract class AbststractImageEngine {

    public function getImageInfo($path) {
        if (!is_file($path)) return null;
        
        $image_info = array();
        list($width, $height, $type, $attr) = getimagesize($path, $image_info);

        $info = FilesHelper::getFileInfo($path);
        $info['width'] = $width;
        $info['height'] = $height;
        return $info;
    }



}