<?php
namespace SmallTeam\Admin;

use Illuminate\Database\Eloquent\Model as Eloquent,
    Illuminate\Support\Facades\DB,
    Illuminate\Support\Facades\Input,
    Illuminate\Support\Facades\Redirect,
    Illuminate\Support\Facades\Paginator,
    Illuminate\Support\Facades\Session,
    Illuminate\Support\Facades\File;

/**
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @copyright SmallTeam (c) 2014
 */

class ListController extends BaseController {

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
            /* @var Eloquent $obj */
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
                    if(isset($item->files)) {
                        FilesHelper::create($item)->loadFiles();
                    }
                    $item = is_object($item) ? $item->toArray() : array();
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
                    /* @var Eloquent $object */
                    $object = $model::find($id);
                    if(isset($object->files)) {
                        FilesHelper::create($object)->loadFiles();
                    }
                    $data[$k] = $object->toArray();
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
        /* @var Eloquent $object */
        $object = $model::find($id);
        if (!$object) return Redirect::to('admin/' . $this->_module_name . '/');

        if ($data = Input::get('data')) {
            $this->beforeSaveProcessData($data);
            $this->mergeData($object, $data);
            $object->save();

            $this->view->setMessage(array('type'=>'success','text'=>'Изменения сохранены!'));

            $this->afterSuccessfulSave($data, $object);
            $redirect_url = 'admin/' . $this->_module_name . (Input::get('back_to_list') ? ' ' : ('/edit/'.$object->{$this->_key}.'/'));
            return Redirect::to($redirect_url);
        }
        if(isset($object->files)) {
            FilesHelper::create($object)->loadFiles();
        }
        $this->view->object = $object->toArray();

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
            /* @var Eloquent $object */
            $object = new $model();
            $this->mergeData($object, $data);
            $object->save();
            $this->view->setMessage(array('type'=>'success','text'=>'Обьект успешно добавлен!'));
            $this->afterSuccessfulSave($data, $object, true);
            $redirect_url = 'admin/' . $this->_module_name . (Input::get('back_to_list') ? ' ' : ('/edit/'.$object->{$this->_key}.'/'));
            return Redirect::to($redirect_url);
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
                File::deleteDirectory(FilesHelper::create($object)->getFilesFolder());
                /* @var Eloquent $object */
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
            File::deleteDirectory(FilesHelper::create($object)->getFilesFolder());
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