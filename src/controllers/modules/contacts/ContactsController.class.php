<?php

class ContactsController extends SingleController{

    public function beforeSaveProcessData(&$data) {
        $data['id'] = 1;
        return true;
    }

    public function actionDefault() {
        $this->view->setTemplate('list/_info.tpl');
        $object = call_user_func(array($this->_module['model'], 'loadOne'), array($this->_key=>(isset($this->_module['key'])?$this->_module['key']:1)));
        if (!$object) $object = new $this->_module['model']() ;
        if ($data = $this->route->getPost('data')) {
            $this->beforeSaveProcessData($data);
            $this->requireAction('edit');
            $was_new = $object->isNew();
            $object->mergeData($data);
            if ($object->save()) {
                $this->view->setMessage(array('type'=>'success','text'=>'Изменения сохранены!'));
                $this->afterSuccessfulSave($data, $object, $was_new);
                $this->route->redirect('admin/' . $this->_module_name . '/');
            } else {
                $this->view->errors = $object->getErrors();
                $this->view->object = $object;
                $this->view->setMessage(array('type'=>'error','text'=>'При сохранении возникли ошибки'));
            }
        }
        $this->view->object = $object;
    }
}
