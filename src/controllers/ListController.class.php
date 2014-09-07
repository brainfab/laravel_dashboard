<?php
namespace SmallTeam\Admin;

use Illuminate\Database\Eloquent\Model as Eloquent,
    Illuminate\Support\Facades\DB,
    Illuminate\Support\Facades\Input,
    Illuminate\Support\Facades\Redirect,
    Illuminate\Support\Facades\Paginator,
    Illuminate\Support\Facades\Session,
    SmallTeam\SmartModel\SmartModel as SmartModel,
    Illuminate\Support\Facades\File;

/**
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @copyright SmallTeam (c) 2014
 */

class ListController extends AdminBaseController {

    /**
     * @description List of items action
     * */
    public function anyIndex($page_number = 1) {
        $this->view->setTemplate('admin::list.default');

        $sort = $this->getSortCriteria();
        if(is_object($sort)) {
            return Redirect::to('admin/' . $this->_module_name . '/');
        }
        $query = $this->getFilterCriteria();
        if (!$query) {
            /* @var SmartModel $obj */
            $obj = new $this->_module['model']();
            $table = $obj->getTable();
            $query = DB::table($table);
        }
        if(isset($sort['field']) && !empty($sort['field'])) {
            $sort['dir'] = $sort['dir'] && in_array($sort['dir'], array('asc', 'desc')) ? $sort['dir'] : 'asc';
            $query->orderBy($sort['field'], $sort['dir']);
        }
        $query->select($this->_key);
        if ($per_page = $this->getModuleParam('per_page')) {
            Paginator::setCurrentPage($page_number);
            $table_data = $query->paginate($per_page);

            $this->view->pager = array(
                'current_page' => $table_data->getCurrentPage(),
                'on_page' => $table_data->getPerPage(),
                'pages_count' => $table_data->getLastPage(),
                'results_count' => $table_data->getTotal(),
            );
            $table_data = $table_data->getItems();
            if(is_array($table_data)) {
                $model = $this->_module['model'];
                foreach ($table_data as &$item) {
                    $item = $model::find($item->{$this->_key});
                    $item = is_object($item) ? $item->loadFiles()->toArray() : array();
                }
            }
            $this->view->link = 'admin/'.$this->_module_name.'/';
            $this->view->pre_page_link = 'page/';
            $this->setModuleSessionParam('page',$this->view->pager['current_page']);
        } else {
            $table_data = $query->get();
            $table_data = ArrayTools::useValue($table_data, $this->_key);
            if(is_array($table_data)) {
                $data = array();
                $model = $this->_module['model'];
                foreach ($table_data as $k => $id) {
                    /* @var SmartModel $object */
                    $object = $model::find($id);
                    $data[$k] = $object->loadFiles()->toArray();
                }
                $table_data = $data;
            }
        }
        if (!$table_data) $this->view->table_data = array();
        $this->view->table_data = $table_data;
        return $this->view->make($this);
    }

    /**
     * @description Edit item action
     * */
    public function anyEdit($id) {
        $this->requireAction('edit');
        if($update_field = Input::get('update_field')){
            $this->view->setTemplate('admin::list._info_update_field');
            $this->view->update_field = $update_field;
            $this->view->setRenderType(ViewHelper::RENDER_STANDALONE);
        }else{
            $this->view->setTemplate('admin::list._info');
        }
        $model = $this->_module['model'];
        /* @var SmartModel $object */
        $object = $model::find($id);
        if (!$object) return Redirect::to('admin/' . $this->_module_name . '/');

        if ($data = Input::get('data')) {
            $this->beforeSaveProcessData($data);
            $this->mergeData($object, $data);
            $redirect_url = 'admin/' . $this->_module_name . (Input::get('back_to_list') ? ' ' : ('/edit/'.$object->{$this->_key}.'/'));

            if(!$object->updateUniques()) {
                $this->view->_errors = $object->errors();
                $this->view->setMessage(array('type'=>'error','text'=>'Во время сохранения произошли ошибки'));
            } else {
                $this->view->setMessage(array('type'=>'success','text'=>'Изменения сохранены!'));

                $this->afterSuccessfulSave($data, $object);
                return Redirect::to($redirect_url);
            }
        }

        $this->view->object = $object->loadFiles()->toArray();
        return $this->view->make($this);
    }

    /**
     * @description Add item action
     * */
    public function anyAdd() {
        $this->requireAction('add');
        $this->view->setTemplate('admin::list._info');
        $model = $this->_module['model'];
        if ($data = Input::get('data')) {
            $this->beforeSaveProcessData($data);
            /* @var SmartModel $object */
            $object = new $model();
            $this->mergeData($object, $data);

            if(!$object->save()) {
                $this->view->object = $object;
                $this->view->_errors = $object->errors();
                $this->view->setMessage(array('type'=>'error','text'=>'Во время сохранения произошли ошибки'));
            } else {
                $redirect_url = 'admin/' . $this->_module_name . (Input::get('back_to_list') ? ' ' : ('/edit/'.$object->{$this->_key}.'/'));
                $this->view->setMessage(array('type'=>'success','text'=>'Обьект успешно добавлен!'));
                $object->loadFiles();
                $this->afterSuccessfulSave($data, $object);
                return Redirect::to($redirect_url);
            }
        }
        return $this->view->make($this);
    }

    /**
     * @description Delete items action
     * */
    public function anyDelete() {
        $this->requireAction('delete');
        $ids = Input::get('items');
        if ($ids && ($objects = call_user_func(array($this->_module['model'], 'find'), array_keys($ids)))) {
            $deleted_count = 0;
            foreach ($objects as $object) {
                /* @var SmartModel $object */
                File::deleteDirectory($object->getFilesFolder());
                if ($object->delete() !== false) {
                    $deleted_count++;
                } else {
                    $this->view->setMessage(array('type'=>'error','text'=>'Объект с ID '.$object->id.' не был удален.'));
                }
            }
            if ($deleted_count > 0) {
                $this->view->setMessage(array('type'=>'success','text'=> $deleted_count.' объект'.StringTools::morph($deleted_count,'','а','ов').' успешно удален'.StringTools::morph($deleted_count,'','ы','ы')));
            } else {
                $this->view->setMessage(array('type'=>'error','text'=>'Ни один объект не был удален'));
            }
        }
        return Redirect::to('admin/' . $this->_module_name . '/');
    }

    /**
     * @description Delete item action
     * */
    public function anyDeleteItem($id) {
        $this->requireAction('delete');
        if ($id && ($object = call_user_func(array($this->_module['model'], 'find'), $id))) {
            $deleted_count = 0;
            File::deleteDirectory($object->getFilesFolder());
            if ($object->delete() !== false) {
                $deleted_count++;
            } else {
                $this->view->setMessage(array('type'=>'error','text'=>'Объект с ID '.$object->id.' не был удален.'.($object->getDeleteError() ? ' Ошибка: '.$object->getDeleteError() : '')));
            }
            if ($deleted_count > 0) {
                $this->view->setMessage(array('type'=>'success','text'=> $deleted_count.' объект'.StringTools::morph($deleted_count,'','а','ов').' успешно удален'.StringTools::morph($deleted_count,'','ы','ы')));
            } else {
                $this->view->setMessage(array('type'=>'error','text'=>'Ни один объект не был удален'));
            }
        }
        return Redirect::to('admin/' . $this->_module_name . '/');
    }

}