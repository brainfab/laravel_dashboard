<?php
/**
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @copyright SmallTeam (c) 2014
 */
class FilesHelper {

    private $_aliases   = array();

    private $_base_path = null;

    /** @var Eloquent $object  */
    protected static $object = null;

    protected function __construct() {}

    /**
     * @param Eloquent $object
     * @return void
     * @throws Exception if Primary field not exists
     * */
    protected function setUp(&$object) {
        $this->_base_path = AdminConfig::getDirUpload() . StringTools::pluralize(strtolower(get_class($object))) . '/';

        File::makeDirectory($this->_base_path, 777, true, true);
        if (!$object->getKeyName()) {
            throw new Exception('Files ability can applies only for Models with Primary field specified');
        }
    }

    /**
     * @param Eloquent $object
     * @return void
     * */
    public static function unSetUp(&$object) {
        $obj = new self();
        $_base_path = AdminConfig::getDirUpload() . StringTools::pluralize(strtolower(get_class($object))) . '/';
        $path = $_base_path . $obj->_getFolderHash($object[$object->getKeyName()]);
        File::deleteDirectory($path);
    }

    /**
     * @param Eloquent $object
     * @return FilesHelper
     * */
    public static function create(&$object) {
        $obj = new self();
        $obj->init($object);
        self::$object = $object;
        return $obj;
    }

    /**
     * @param Eloquent $object
     * @return void
     * @throws Exception if no files config array defined
     * */
    protected function init(&$object) {
        $this->setUp($object);
        if(!isset($object->files)) {
            throw new Exception('No files config array defined for Model '.get_class($object));
        }
        $this->_aliases = $object->files;
    }
    
    public function getFilesFolder() {
        return $this->_base_path . $this->_getFolderHash(self::$object[self::$object->getKeyName()]) . '/';
    }

    public function removeFile($alias, $name) {
        $object = self::$object;
        if(!isset($object->files[$alias])) {
            return false;
        }
        $file_info = self::$object->files[$alias];
        if (isset($file_info['multiple'])) {
            foreach ($object[$alias] as $file_item) {
                if ($file_item['full_name'] == $name) {
                    @unlink($file_item['path']);
                    if (isset($image_item['sizes'])) {
                        foreach ($file_item['sizes'] as $size) {
                            @unlink($size['path']);
                        }
                    }
                }
            }
        } else {
            if (isset($file_info['sizes'])) {
                self::unlinkRecursive($this->getFilesFolder().$alias);
            } else {
                @unlink($this->getFilesFolder().$alias.'/'.$name);
            }
        }
    }

    static public function unlinkRecursive($path) {
        if (!file_exists($path)) return true;
        if (!is_dir($path) || is_link($path)) return unlink($path);

        foreach (scandir($path) as $item) {
            if ($item == '.' || $item == '..') continue;
            if (!self::unlinkRecursive($path . "/" . $item)) {
                chmod($path . "/" . $item, 0777);
                if (!self::unlinkRecursive($path . "/" . $item)) return false;
            };
        }
        return rmdir($path);
    }

    public function saveFiles() {
        $this->process(self::$object);
    }

    public function loadFiles() {
        $aliases = $this->_aliases;

        foreach($aliases as $alias=>$info) {
            $alias = strtolower($alias);
            $store_source = false;
            if (isset($info['store_source'])) {
                $store_source  = $info['store_source'];
            } elseif (isset($info['sizes'])) {
                $store_source = true;
            }
            $source_folder = $store_source ? 'source/' : '';

            $path = $this->_base_path . $this->_getFolderHash(self::$object[self::$object->getKeyName()]) . '/' . $alias . '/';
            $mask = isset($info['mask']) ? $info['mask'] : '*.*';
            $value = array();
            $files = GLOB($path.$source_folder.$mask);
            if (count($files)) {
                foreach($files as $file) {
                    $file_name = substr($file, strrpos($file, '/') + 1);
                    $file_ext = substr($file_name, ($ep = strrpos($file_name, '.')) + 1);
                    $file_name = substr($file_name, 0, $ep);

                    $item = self::getFileInfo($file);
                    if (isset($info['sizes'])) {
                        $item['sizes'] = $this->makeThumbnails($file, $info, $path, $file_name, $file_ext);
                    }
                    $value[] = $item;
                }
            }
            if (count($value)) {
                if (empty($info['multiple'])) $value = $value[0];
            } else {
                $value = null;
            }

            self::$object[$alias] = $value;
        }
    }

    protected function process(&$object) {
        $aliases = $this->_aliases;
        foreach($aliases as $alias=>$info) {
            $alias = strtolower($alias);
            $store_source = false;
            if (isset($info['store_source'])) {
                $store_source  = $info['store_source'];
            } elseif (isset($info['sizes'])) {
                $store_source = true;
            }
            $source_folder = $store_source ? 'source/' : '';
            if (isset($_FILES[$alias]) && !empty($_FILES[$alias]['name'])) {
                $path = $this->_base_path . $this->_getFolderHash($object[$object->getKeyName()]) . '/' . $alias . '/';
                $mask = isset($info['mask']) ? $info['mask'] : '*.*';

                if (is_array($_FILES[$alias]['name'])) {
                    $files = array();
                    foreach($_FILES[$alias]['name'] as $key=>$name) {
                        $files[] = array(
                            'name'	=> $name,
                            'type'	=> $_FILES[$alias]['type'][$key],
                            'tmp_name'	=> $_FILES[$alias]['tmp_name'][$key],
                            'error'	=> $_FILES[$alias]['error'][$key],
                            'size'	=> $_FILES[$alias]['size'][$key],
                        );
                    }
                } else {
                    $files = array($_FILES[$alias]);
                }

                File::makeDirectory($path.$source_folder, 777, true, true);
                foreach($files as $file) {
                    $original_name = substr($file['name'], 0, strrpos($file['name'], '.'));
                    $original_ext = substr($file['name'], strlen($original_name)+1);
                    $value = array();

                    // remove old files
                    $files_unlink = array();
                    if (empty($info['multiple']) && !($object == 'preview')) {
                        if ($store_source) {
                            $tmp = GLOB($path.$source_folder.$mask);
                            $files_unlink = array_merge($files_unlink, $tmp);
                        }
                        $tmp = GLOB($path.$mask);
                        $files_unlink = array_merge($files_unlink, $tmp);
                    }

                    if (isset($_POST['update_file'])) {
                        $del_file = $_POST['update_file'];
                        $del_name = substr($del_file, 0, strrpos($del_file, '.'));
                        $del_ext =  substr($del_file, strlen($del_name));
                        $files_unlink[] = $path.$source_folder.trim($_POST['update_file']);
                    }
                    foreach($files_unlink as $file_unlink) {
                        @unlink($file_unlink);
                    }

                    if (isset($info['extension'])) {
                        $ext = $info['extension'];
                    } else {
                        $ext = $original_ext;
                    }

                    if (isset($info['name'])) {
                        if ($info['name'] == 'native') {
                            $name = $original_name;
                            $ext = $original_ext;
                            while (is_file($path.$source_folder.$name.'.'.$ext)) {
                                $name .= '_1';
                            }
                        }  else {
                            $name = $info['name'];
                        }
                    } else {
                        $name = md5(time());
                    }

                        // save source
                    copy($file['tmp_name'], $path.$source_folder.$name. '.' .$ext);
                        // create thumbnails if specified
                    if (isset($info['sizes'])) {
                        $value['sizes'] = $this->makeThumbnails($path.$source_folder.$name. '.' .$ext, $info, $path, $name, $ext);
                    }

                    $value = self::getFileInfo($path.$source_folder.$name. '.' .$ext);
                        // unlink old files
                    @unlink($file['tmp_name']);
                    if (isset($file['after_preview']) && isset($info['sizes'])) $this->removeThumbnails($path.$source_folder.$file['tmp_name'], $info, $path);

                    $object[$alias] = $value;
                }
            }
        }
    }

    private function makeThumbnails($file, $info, $path, $name, $ext) {
		$res = array();
        $default_process = !empty($info['process']) ? $info['process'] : 'fitIn';
		foreach($info['sizes'] as $alias=>$info) {
            $process = $default_process;
            if (is_array($info)) {
                if (isset($info['process'])) $process = $info['process'];
                if( isset($info['additional_process']) ) $additional_process =  $info['additional_process'];
                if( isset($info['additional_process']['extension']) ) $ext =  $info['additional_process']['extension'];
                $info = $info['size'];
            }
            $to = $path.$name. '_' .$alias. '.' .$ext;
			if (!is_file($to)) {
                if( isset($additional_process) ) {
                    Image::getInstance()->{$process}( $file, $to, $info, 'center', $additional_process);
                } else {
                    Image::getInstance()->{$process}( $file, $to, $info);
                }
			}
			$res[$alias] = self::getFileInfo($to);
		}
		return $res;
	}

    private function removeThumbnails($file, $info, $path) {
		$res = false;

		$file_name = substr($file, strrpos($file, '/') + 1);
		$file_ext = substr($file_name, ($ep = strrpos($file_name, '.')) + 1);
		$file_name = substr($file_name, 0, $ep);

		foreach($info['dimensions'] as $alias=>$dimension) {
			$to = $path.$file_name. '_' .$alias. '.' .$file_ext;
			if (is_file($to)) {
				@unlink($to);
				$res = true;
			}
		}
		return $res;
    }

    private function _getFolderHash($value) {
        if (!intval($value[0])) {
            $int = ord($value[0]) % 10;
        } else {
            $int = $value[0] % 10;
        }
        return $int . '/' . $value;
    }

    static 	public function getFileInfo($path) {
        if (!is_file($path)) return array(
            'is_exists' => false
        );

        $last_slash = strrpos($path, '/');
        $folder     = '';
        $file       = $path;

        if ($last_slash !== false) {
            $folder = substr($path, 0, $last_slash);
            $file = substr($path, $last_slash+1);
        }
        $ext_pos    = strrpos($file, '.');
        $file_name  = $file;
        $ext        = '';
        if ($ext_pos !== false) {
            $file_name  = substr($file, 0, $ext_pos);
            $ext        = substr($file, $ext_pos);
        }

        $mess = array('b', 'Kb', 'Mb', 'Gb', 'Tb');
        $i = 0;
        $link_folder = substr($folder, mb_strlen(public_path())) . '/';
        $value = array(
            'size'      => @filesize(realpath($path)),
            'is_exists' => true,
            'link'      => $link_folder.$file_name.$ext,
            'path'      => $path,
            'full_name' => $file_name.$ext,
            'name'      => $file_name,
            'ext'       => $ext
        );
        while(($i < count($mess) - 1) && ($value['size'] > 1024)) {
            $i++;
            $value['size'] = $value['size'] / 1024;
        }
        $value['size'] = ceil($value['size']).' '.$mess[$i];
        return $value;
    }

}
