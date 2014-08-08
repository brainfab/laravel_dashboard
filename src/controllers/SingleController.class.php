<?php
namespace SmallTeam\Admin;

use Illuminate\Database\Eloquent\Model as Eloquent,
    Illuminate\Support\Facades\DB,
    Illuminate\Support\Facades\Input,
    Illuminate\Support\Facades\Redirect;

/**
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @copyright SmallTeam (c) 2014
 */
 
class SingleController extends BaseController {

    public function anyIndex() {
        $this->view->setTemplate('admin::list/_info');
        /* @var Eloquent $object */
        $model = $this->_module['model'];
        $object = new $model();
        $object = $object->findOrNew((isset($this->_module['key']) ? $this->_module['key'] : 1));

        if ($data = Input::get('data')) {
            $this->beforeSaveProcessData($data);
            $this->requireAction('edit');
            $this->mergeData($object, $data);
            $object->save();

            $this->view->setMessage(array('type'=>'success','text'=>'Изменения сохранены!'));
            $this->afterSuccessfulSave($data, $object, false);
            return Redirect::to('admin/' . $this->_module_name . '/');
        }
        $object = $object->toArray();
        $this->view->object = $object;
        return $this->view->make($this);
    }

}
