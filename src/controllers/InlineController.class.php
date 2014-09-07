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
 
class InlineController extends AdminBaseController{

    public function anyIndex() {
        $this->view->_pk = $this->_key;
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

        $table_data = array();

        if ($per_page = $this->getModuleParam('per_page')) {
            $page = Input::get('page_number', $this->getModuleSessionParam('page', 1));
            $ids = ffPaginator::getFromQuery(Q::create($this->_ms->get('table'))->where($c),$page, $per_page,'id');
            $objects = call_user_func(array($this->_module['model'], 'loadList'), C::create(array('id'=>$ids))->orderBy($sort));
            $this->view->pager = ffPaginator::getInfo();
            $this->view->link = 'admin/'.$this->_module_name.'/';
            $this->view->pre_page_link = 'page/';
            $this->setModuleSessionParam('page',$this->view->pager['current_page']);
        } else {
            $table_data = $query->get();
            if(is_array($table_data)) {
                $data = array();
                foreach ($table_data as $k => $row) {
                    foreach ($row as $key => $item) {
                        $data[$k][$key] = $item;
                    }
                }
                $table_data = $data;
            }
        }

        $table_data = is_array($table_data) && !empty($table_data) ? $table_data : array();

        if ($data_array = Input::get('data')) {
            $affected_rows = 0;
            foreach($data_array as $id => $data) {
                /* @var Eloquent $object */
                $object = new $this->_module['model']();
                $object = $object::findOrNew($id);
                if (!$object) {
                    if (!$this->requireAction('add', false)) continue;
                } else {
                    if (!$this->requireAction('edit', false)) continue;
                }
                if (!$object) {
                    continue;
                }
                $this->mergeData($object, $data);
                $object->save();
                $table_data[] = $object->toArray();
                $affected_rows++;
            }

            $this->view->setMessage(array('type'=>'success','text'=>'Изменения сохранены!'));
            return Redirect::refresh();
        }
        $this->view->table_data = $table_data;

        return $this->view->make($this);
    }

    public function anyGetBlankRow() {
        if (!$this->requireAction('add',false)) die('false');
        $this->view->setTemplate('admin::list._inline');
        $this->view->setRenderType($this->view->setRenderType(ViewHelper::RENDER_STANDALONE));
        $this->view->row = new $this->_module['model']();
        $this->view->row->id = md5(time().rand());
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

}
