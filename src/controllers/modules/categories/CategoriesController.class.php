<?php

class CategoriesController extends ListController{

    public function actionDefault() {
        $tree = '';
        self::buildTree($tree);
        $this->view->tree = $tree;
        $this->view->setTemplate('tree/default.tpl');
    }

    public function loadIdParentItems() {
        $tree = array();
        $this->buildTreeArray($tree);
        $tree = is_array($tree) ? array(0=>'нет')+$tree : array(0=>'нет');
        return $tree;
    }

    public function buildTreeArray(&$result, $nodes = null, $level = 0, $space = '&mdash;') {
        $skip = $this->route->getVar('id');
        if(is_null($nodes)) {
            $nodes = call_user_func(array($this->_module['model'], 'loadList'), C::create(array('id_parent'=>0))->orderBy('_position'));
            if(is_object($nodes)) {
                $nodes = $nodes->toArray(true);
            }
        }

        if(is_array($nodes) && !empty($nodes)) {
            foreach ($nodes as $node) {
                if($skip == $node[$this->_key])
                    continue;
                $result[$node[$this->_key]] = str_repeat($space, $level) . $node['title'];

                $children = call_user_func(array($this->_module['model'], 'loadList'), C::create(array('id_parent'=>$node[$this->_key]))->orderBy('_position'));
                $children = is_object($children) ? $children->toArray(true) : null;

                if(is_array($children) && !empty($children)) {
                    $this->buildTreeArray($result, $children, $level+1, $space);
                }
            }
        }
        return;
    }

    public function buildTree(&$result, $nodes = null) {
        if(is_null($nodes)) {
            $nodes = call_user_func(array($this->_module['model'], 'loadList'), C::create(array('id_parent'=>0))->orderBy('_position'));
            if(is_object($nodes)) {
                $nodes = $nodes->toArray(true);
            }
        }

        if(is_array($nodes) && !empty($nodes)) {
            $result .= '<ol class="dd-list">';
            foreach ($nodes as $node) {
                $result .= '
                <li class="dd-item dd3-item" data-id="'.$node[$this->_key].'">
                    <div class="dd-handle dd3-handle">
                        <div class="">&nbsp;</div>
                    </div>
                    <div class="dd3-content"><div class="dd3-content-title">'.$node['title'].'</div>
                        <span class="pull-right">
                            <a title="редактировать" href="/admin/'.$this->_module_name.'/edit/'.$node[$this->_key].'/" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></a>
                            <a onclick="if(!confirm(\'Удалить выбранный элемент?\')) return false;" class="edit_object btn btn-xs btn-danger" title="удалить" href="/admin/'.$this->_module_name.'/delete_item/'.$node[$this->_key].'/"><i class="fa fa-times"></i></a>
                        </span>
                    </div>
                ';

                $children = call_user_func(array($this->_module['model'], 'loadList'), C::create(array('id_parent'=>$node[$this->_key]))->orderBy('_position'));
                $children = is_object($children) ? $children->toArray(true) : null;

                if(is_array($children) && !empty($children)) {
                    self::buildTree($result, $children);
                }
                $result .= '</li>';
            }
            $result .= '</ol>';
        }
        return;
    }

    public function actionUpdateTree() {
        $tree = $this->route->getVar('tree');
        $this->updateTreeNodes($tree);
        die();
    }

    public function updateTreeNodes($nodes, $id_parent = 0) {
        if(is_array($nodes) && !empty($nodes)) {
            $pos = 1;
            foreach ($nodes as $item) {
                Q::create($this->_ms->get('table'))->update(array('id_parent' => $id_parent, '_position' => $pos))->where(array('id' => $item['id']))->exec();
                $pos++;
                if(isset($item['children']) && !empty($item['children'])) {
                    $this->updateTreeNodes($item['children'], $item['id']);
                }
            }
        }
    }
}
