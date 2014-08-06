<?php
/**
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @copyright SmallTeam (c) 2014
 */

class GDImageEngine {

    public function resize($source, $destination, $dimension, $params) {
        if (!is_file($source)) {
            throw new Exception('Source file not exists');
        }
    }

    public function fitOut($from, $to, $dimensions, $gravity = 'center'){
        $from_sizes = getimagesize($from);
        $to_sizes = explode('x',$dimensions);
        $xpos = 0; $ypos = 0;

        $to_ratio = $to_sizes[0]/$to_sizes[1]; //viewport ratio

        $dwp = round($from_sizes[0] / $to_sizes[0],5); //diff by width in percents
        $dhp = round($from_sizes[1] / $to_sizes[1],5); //diff by height in percents

        if ($dwp > $dhp) {

            $new_w = $from_sizes[1] * $to_ratio;
//            gravity
            if (strpos($gravity,'left')) { $xpos = 0;}
            else if (strpos($gravity,'right')) { $xpos = abs($from_sizes[0] - $new_w);}
            else { $xpos = abs($from_sizes[0] - $new_w)/2; }

            $from_sizes[0] = $new_w;

        } else if ( $dwp < $dhp){
            
            $new_h = $from_sizes[0] / $to_ratio;
//            gravity
            if (strpos($gravity,'top')) { $ypos = 0;}
            else if (strpos($gravity,'bottom')) { $ypos = abs($from_sizes[1] - $new_h);}
            else { $ypos = abs($from_sizes[1] - $new_h)/2; }
            
            $from_sizes[1] = $new_h;

        }
//        now in $from_sizes we have images dimentions fitted to viewport ratio
        $this->saveImage($from, $to, $from_sizes, $to_sizes, $xpos, $ypos, 0, 0);
        
    }

    public function fitIn($from, $to, $dimensions, $gravity = 'center'){

        $from_sizes = getimagesize($from);
        $to_sizes = explode('x',$dimensions);

        $from_ratio = $from_sizes[0]/$from_sizes[1]; //image ratio
        $dwp = round($from_sizes[0] / $to_sizes[0],5); //diff by width in percents
        $dhp = round($from_sizes[1] / $to_sizes[1],5); //diff by height in percents
//        in there we`ll need to rescale viewport to images` ratio
        if ($dwp > $dhp) {

            $to_sizes[1] = $to_sizes[0] / $from_ratio;

        } else if ( $dwp < $dhp){

            $to_sizes[0] = $to_sizes[1] * $from_ratio;

        }
//        now in $to_sizes we have images dimentions fitted to image ratio
        $this->saveImage($from, $to, $from_sizes, $to_sizes, 0, 0, 0, 0);

    }

    public function fitInFull($from, $to, $dimensions, $gravity = 'center', $rgb = array(255, 255, 255)){
         $xpos = 0; $ypos = 0;

        //create fittedIn image
        $this->fitIn($from, $to, $dimensions, $gravity = 'center');
        //now in $to we have fitted image. its tmp image
        $tmp_img = $to;

        $from_sizes = getimagesize($tmp_img);
        $to_sizes = explode('x',$dimensions);

        $dwp = round($from_sizes[0] / $to_sizes[0],5); //diff by width in percents
        $dhp = round($from_sizes[1] / $to_sizes[1],5); //diff by height in percents

        if ($dwp < $dhp) {
//            gravity
            if (strpos($gravity,'left')) { $xpos = 0;}
            else if (strpos($gravity,'right')) { $xpos = abs($from_sizes[0] - $to_sizes[0]);}
            else { $xpos = abs($from_sizes[0] - $to_sizes[0])/2; }

        } else if ( $dwp > $dhp){
//            gravity
            if (strpos($gravity,'top')) { $ypos = 0;}
            else if (strpos($gravity,'bottom')) { $ypos = abs($from_sizes[1] - $to_sizes[1]);}
            else { $ypos = abs($from_sizes[1] - $to_sizes[1])/2; }

        }

//        now save image with $fill_empty
        $this->saveImage($tmp_img, $to, $from_sizes, $to_sizes, 0, 0, $xpos, $ypos, true, $rgb);

    }

    private function saveImage($from, $to, $from_sizes, $to_sizes, $from_x, $from_y, $to_x, $to_y, $fill_empty = false, $rgb_fill = array(255,255,255) ) {

        $new_image = imagecreatetruecolor($to_sizes[0],$to_sizes[1]);

        $type = image_type_to_extension($from_sizes[2],false);
        $old_image = call_user_func('imagecreatefrom'.$type, $from);

        if ($fill_empty) {
            $color_id = imagecolorallocate($new_image, $rgb_fill[0], $rgb_fill[1], $rgb_fill[2]);
            imagefill($new_image,0,0,$color_id);
            imagecopymerge($new_image,$old_image, $to_x, $to_y, $from_x, $from_y, $from_sizes[0], $from_sizes[1], 100);

        } else {
            imagecopyresampled($new_image, $old_image, $to_x, $to_y, $from_x, $from_y, $to_sizes[0], $to_sizes[1], $from_sizes[0], $from_sizes[1]);
        }

        call_user_func('image'.$type, $new_image,$to, 100);
    }
}