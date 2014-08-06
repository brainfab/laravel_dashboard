<?php

class PropertiesController extends ListController{

    public function loadIdCategoryItems(){
        return Q::create('categories')->select('id, title')->useValue('title')
            ->indexBy('id')->exec();
    }

    public function actionDefault() {
        $this->view->setTemplate('list/_elements/cats_props.tpl');
        $this->view->categories = $cats = Q::create('categories')->select('id, title')
            ->useValue('title')
            ->indexBy('id')
            ->exec();
        $this->view->props_list = Q::create('properties')->select()->where(array('id_category'=>array_keys($cats)))
            ->foldBy('id_category')->exec();
    }

    public function actionCategoriesProperties() {
        $this->view->setTemplate('list/default.tpl');
        $id_category = $this->route->getVar('id_category');
        $check = Q::create('categories')->select('id')->useValue('id')->where(array('id'=>$id_category))->one()->exec();
        if(!$id_category || !$check){
            $this->route->redirect('admin/properties/');
        }
        $c = new C();
        $c->where(array('id_category'=>$check));
//        $this->_module_name = 'properties/'.$check;
        $sort = $this->getSortCriteria();
        $c->orderBy($sort);
        if ($per_page = $this->getModuleParam('per_page')) {
            $page = $this->route->getVar('page_number', $this->getModuleSessionParam('page', 1));
            $ids = ffPaginator::getFromQuery(Q::create($this->_ms->get('table'))->where($c),$page, $per_page,'id');
            $this->view->table_data = call_user_func(array($this->_module['model'], 'loadList'), C::create(array('id'=>$ids))->orderBy($sort));
            $this->view->pager = ffPaginator::getInfo();
            $this->view->link = 'admin/'.$this->_module_name.'/';
            $this->view->pre_page_link = 'page/';
            $this->setModuleSessionParam('page',$this->view->pager['current_page']);
        } else {
            $this->view->table_data = call_user_func(array($this->_module['model'], 'loadList'), $c);
            if ($this->_ms->get('abilities/translate')) {
                $this->view->table_data->loadTranslate();
            }
        }
        if (!$this->view->table_data) $this->view->table_data = array();
    }

    public function actionAdd__() {
        $this->requireAction('add');
        $this->view->setTemplate('list/_info.tpl');
        if ($data = $this->route->getVar('data')) {
            $this->beforeSaveProcessData($data);
            $ids_categories = isset($data['id_category']) && is_array($data['id_category']) && !empty($data['id_category']) ? $data['id_category'] : false;
//            $post = $data;
            if($ids_categories){
                foreach($ids_categories as $id_category) {
                    if(empty($id_category) || $id_category<=0)
                        continue;
                    $data['id_category'] = $id_category;
                    $object = new $this->_module['model'];
                    $object->mergeData($data);

                    if ($object->save()) {
                        $this->afterSuccessfulSave($data, $object, true);
                    }
                }
                $this->view->setMessage(array('type'=>'success','text'=>'Обьект успешно добавлен!'));
            } else {
                $this->view->setMessage(array('type'=>'error','text'=>'При сохранении возникли ошибки'));
            }
            $redirect_url = 'admin/' . $this->_module_name.'/' ;
            $this->route->redirect($redirect_url);
        }
    }
}
