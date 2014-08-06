<?php

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


/**
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @copyright SmallTeam (c) 2014
 */

class BaseController extends Controller {

    protected $_module  = null;

    protected $_ms          = null;

    protected $_module_name = null;

    public $_key         = 'id';
    /** @var ViewHelper $view */
    protected $view         = null;

    protected static $available_types = array('List','Inline','Single');

    public function __construct() {
        $this->_module_name = StringTools::directorize(substr(get_class($this), 0, -10));
        $this->view = ViewHelper::getInstance();

        setcookie('admin_module_name',$this->_module_name);

        $this->beforeFilter(function() {
            if(!Admin::isLoggedIn() && strpos($_SERVER['REQUEST_URI'], 'admin/login') === false) {
                return Redirect::to('admin/login');
            }
            $this->preAction();
        });

        $this->afterFilter(function() {

        });
    }

    /**
     * @description Set module session param
     * */
    protected function setModuleSessionParam($what, $value) {
        if (empty($_SESSION['admin_modules'][$this->_module_name])) $_SESSION['admin_modules'][$this->_module_name] = array();
        if ($value === null) {
            unset($_SESSION['admin_modules'][$this->_module_name][$what]);
        } else {
            $_SESSION['admin_modules'][$this->_module_name][$what] = $value;
        }
    }

    /**
     * @description Get module session param
     * */
    protected function getModuleSessionParam($what, $default = null) {
        return isset($_SESSION['admin_modules'][$this->_module_name][$what]) ? $_SESSION['admin_modules'][$this->_module_name][$what] : $default;
    }

    /**
     * @description Get module param
     * */
    protected function getModuleParam($what, $default = null) {
        $value = ArrayTools::getDeepArrayValue($this->_module,$what);
        return ($value) ? $value : $default;
    }

    /**
     * @description Set module param
     * */
    protected function setModuleParam($what, $value) {
        ArrayTools::setDeepArrayValue($this->_module, $value, $what);
    }

    /**
     * @description Unset module param
     * */
    protected function unsetModuleParam($what) {
        ArrayTools::unsetDeepArrayValue($this->_module, $what);
    }

    /**
     * @description Pre action
     * */
    public function preAction() {
        $structure_path = dirname(__FILE__).'/modules/'.$this->_module_name.'/' . $this->_module_name . '.yml';
        $this->_module          = is_file($structure_path) ? sfYaml::load($structure_path) : array();
        $this->view->app_name = 'admin';
        $this->view->module_name = $this->_module;
        $this->performMenu();
        if (!$this->_module) {
            return true;
        }

        foreach(self::$available_types as $type) {
            if (@is_a($this, $type.'Controller')) $this->setModuleParam('parent', $type);
        }

        /* Build model structure info */
        $this->_ms = ModelStructure::getStructure($this->_module['model']);

        $this->setModuleParam('name', $this->_module_name);

        $this->_key = isset($this->_ms['primary_key']) && !empty($this->_ms['primary_key']) ? $this->_ms['primary_key'] : $this->getModuleParam('key_field', $this->_key);
        $this->view->key_field = $this->_key;
        $action = Route::currentRouteAction();
        
        if(strpos($action, '@')!==false) {
            $tmp_arr = explode('@', $action);
            $action = isset($tmp_arr[1]) ? $tmp_arr[1] : $action;
            if(strpos($action, 'post')!==false) {
                $action = substr($action, 4);
            } else if(strpos($action, 'any')!==false || strpos($action, 'get')!==false) {
                $action = substr($action, 3);
            }
        }

        $action = strtolower($action);
        $this->setModuleParam('action_name', $action == 'index' ? 'list' : $action);
        $this->performFields();
        $this->performTabs();
        $this->performFilters();
    }

    /**
     * @description Post action
     * */
    public function postAction() {
        $this->view->module = $this->_module;
        $this->view->ms = $this->_ms;
        $this->view->fields = isset($this->_module['fields']) ? $this->_module['fields'] : null;
        $this->view->filter_values = $this->getModuleSessionParam('filters');
        $this->view->admin_menu = $this->buildAdminMenu();

        $this->view->user_info = Session::get('admin-info');
    }

    /**
     * @description Perform fields
     * */
    protected function performFields() {
        $action = $this->getModuleParam('action_name');
        if ($action == 'default') $action = 'list';
        $this->setModuleParam('initial_fields', $this->getModuleParam('fields'));
        if ($action_fields = $this->getModuleParam('actions/'.$action.'/fields')) {
            $fields = array();
            foreach ($action_fields as $field_name) {
                $fields[$field_name] = $this->getModuleParam('fields/'.$field_name);
            }
            $this->setModuleParam('fields',$fields);
        }

        if ($hide_fields = $this->getModuleParam('actions/'.$action.'/hide')) {
            foreach ($hide_fields as $field) $this->unsetModuleParam('fields/'.$field);
        }
        if ($show_fields = $this->getModuleParam('actions/'.$action.'/show')) {
            foreach ($this->getModuleParam('fields') as $field => $value) {
                if (!in_array($field, $show_fields)) $this->unsetModuleParam('fields/'.$field);
            }
        }

        if ($group_actions = $this->getModuleParam('group_actions')) {
            foreach ($group_actions as $group_action => $params) {
                if (!is_array($params)) {
                    $params = array(
                        'action' => $group_action,
                        'title' => ''
                    );
                } else {
                    if (!isset($params['action'])) $params['action'] = $group_action;
                    if (!isset($params['title'])) $params['title'] = '';
                }
                $this->setModuleParam('group_actions/'.$group_action,$params);
            }
        }

        if ($object_actions = $this->getModuleParam('object_actions')) {
            foreach ($object_actions as $object_action => $params) {
                if (!is_array($params)) {
                    $params = array(
                        'action' => $object_action,
                        'title' => ''
                    );
                } else {
                    if (!isset($params['action'])) $params['action'] = $object_action;
                    if (!isset($params['title'])) $params['title'] = '';
                }
                $this->setModuleParam('object_actions/'.$object_action, $params);
            }
        }

        foreach($this->getModuleParam('fields') as $name => $info) {
            $info = $this->performField($name, $info);
            if ($info) {
                $this->setModuleParam('fields/'.$name,array_merge(is_array($this->getModuleParam('fields/'.$name))? $this->getModuleParam('fields/'.$name): array(),(is_array($info)? $info: array())));
            } else {
                $this->unsetModuleParam('fields/'.$name);
            }
        }
    }

    /**
     * @description Perform field
     * */
    protected function performField($name, $info) {
        $method = 'perform'.StringTools::functionalize($name).'Field';
        if (method_exists($this,$method)) {
            $info = $this->$method($name, $info);
        } else {
            $method = 'perform'.StringTools::functionalize(isset($info['type']) ? $info['type'] : 'unknown').'FieldType';
            if (method_exists($this,$method)) {
                $info = $this->$method($name, $info);
            }
        }
        return $info;
    }

    /**
     * @description Perform unknown field type
     * */
    protected function performUnknownFieldType($name, $info) {
        if (mb_strtolower($name) == 'password'){
            $info['type'] = 'password';
        } elseif (isset($this->_ms['columns'][$name])) {
            $si = $this->_ms['columns'][$name];
            if(strpos($si['type'], 'enum') !== false) {
                $info = $this->performSelectFieldType($name,$info,'enum');
            } elseif (strpos($si['type'], 'text') !== false) {
                $info['type'] = 'area';
            }
        } elseif (isset($this->_ms['relations'][$name])) {
            $info = $this->performSelectFieldType($name, $info, 'relation');
        } elseif (isset($this->_ms['abilities']['files'][$name])) {
            if (isset($this->_ms['abilities']['files'][$name]['sizes'])){
                $info['type'] = 'image';
            } else {
                $info['type'] = 'file';
            }

            if (isset($this->_ms['abilities']['files'][$name]['multiple'])){
                $info['type'] .= 'list';
            }
        }
        if (!isset($info['type'])){
            $info['type'] = 'text';
        }
        return $info;
    }

    /**
     * @description Perform group field type
     * */
    protected function performGroupFieldType($name, $info) {
        $info['all_fields'] = array();
        foreach ($info['columns'] as $key => $column) {
            if (is_array($column) && isset($column['fields'])) {
                foreach ($column['fields'] as $i => $field) {
                    if (!isset($this->_module['fields'][$field])) {
                        unset($info['columns'][$key]['fields'][$i]);
                    } else {
                        $info['columns'][$key]['fields'][$i] =& $this->_module['fields'][$field];//$fields[$field];
                        $this->setModuleParam('fields/'.$field.'/_in_group',true);
                        $this->setModuleParam('fields/'.$field.'/field_name',$field);
                        $info['all_fields'][] = $field;
                    }
                }
            } else {
                if (!isset($this->_module['fields'][$column])) {
                    unset($info['columns'][$key]);
                } else {
                    $info['columns'][$key] =& $this->_module['fields'][$column];
                    $this->setModuleParam('fields/'.$column.'/_in_group',true);
                    $this->setModuleParam('fields/'.$column.'/field_name',$column);
                    $info['all_fields'][] = $column;
                }
            }
        }
        return $info;
    }

    /**
     * @description Perform select field type
     * */
    protected function performSelectFieldType($name, $info, $type = null, $type_params = null) {
        if ($type === null) {
            if (isset($this->_ms['columns'][$name]['type']) && strpos($this->_ms['columns'][$name]['type'],'enum') !== false) {
                $type = 'enum';
            } elseif (isset($this->_ms['relations'][$name])) {
                $type = 'relation';
            } else {
                $type = 'default';
            }
        }

        if (!isset($info['items'])) {
            $method = 'load'.StringTools::functionalize($name).'Items';
            if (method_exists($this,$method)) {
                $info['items'] = $this->$method(); //@todo define params to pass to the function
            }
        }

        switch ($type) {
            case 'enum':
                if (!isset($info['type'])) $info['type'] = 'select';
                if (!isset($info['local_field'])) $info['local_field'] = $name;
                if (!isset($info['items'])) {
                    $select_items = array();
                    $matches = array();
                    preg_match_all('#\'(.+)\'#isU', str_replace('"',"'",$this->_ms['columns'][$name]['type']), $matches);
                    foreach($matches[1] as $item) $select_items[$item] = $item;
                    $info['items'] = $select_items;
                }
                break;
            case 'relation':
                $vars = ffDBOperator::calculateRelationVariables(new $this->_module['model'], $this->_ms['relations'][$name], $name);
                $relation_type = isset($this->_ms['relations'][$name]['type']) ? $this->_ms['relations'][$name]['type'] : 'many_to_one';
                $info['foreign_title'] = isset($info['foreign_title']) ? $info['foreign_title'] : 'title';
                if (!isset($info['local_field'])) $info['local_field'] = $vars['local_field'];
                if ($relation_type == 'many_to_one') {
                    if (!isset($info['type'])) $info['type'] = 'select';
                    if (!isset($info['include_empty'])) {
                        $info['include_empty'] = true;
                    }
                } elseif ($relation_type == 'many_to_many') {
                    if (!isset($info['type'])) $info['type'] = 'multiselect';
                    $info['include_empty'] = false;
                }

                if (!isset($info['items'])) {
                    $q = Q::create($vars['foreign_table'])->select(array($vars['foreign_key'], $info['foreign_title']))->useValue($info['foreign_title'])->indexBy($vars['foreign_key']);
                    if (isset($info['sort_by'])) {
                        $q->orderBy($info['sort_by']);
                    }
                    $info['items'] = $q->exec();
                    if (isset($info['include_empty']) && $info['include_empty']) {
                        $info['items'][0] = 'нет';
                    }
                }
            case 'default':
                if (!isset($info['local_field'])) $info['local_field'] = $name;
        }

        return $info;
    }

    /**
     * @description Perform radioselect field type
     * */
    protected function performRadioselectFieldType($name, $info) {
        return $this->performSelectFieldType($name, $info);
    }

    /**
     * @description Perform multiselect field type
     * */
    protected function performMultiselectFieldType($name, $info) {
        return $this->performSelectFieldType($name, $info);
    }

    /**
     * @description Perform multicheckbox field type
     * */
    protected function performMulticheckboxFieldType($name, $info) {
        return $this->performSelectFieldType($name, $info);
    }

    /**
     * @description Perform tabs
     * */
    protected function performTabs() {
        $this->setModuleParam('tabs', array_merge(array('default'=>array('title'=>'Свойства','fields'=>array())), $this->getModuleParam('tabs',array())));

        foreach($this->getModuleParam('tabs') as $key=>$info) {
            if (isset($info['fields'])) {
                $fields = array();
                foreach($info['fields'] as $field_name) {
                    if (($field_info = $this->getModuleParam('fields/'.$field_name)) && !isset($field_info['_in_group'])) {
                        $fields[$field_name] = $field_info;
                        $this->setModuleParam('fields/'.$field_name.'/_in_tab', true);
                    }
                }
                $this->setModuleParam('tabs/'.$key.'/fields', $fields);
            }
        }

        foreach($this->getModuleParam('fields') as $field_name=>$info) {
            if (!isset($info['_in_tab']) && !isset($info['_in_group'])) {
                $this->setModuleParam('tabs/default/fields/'.$field_name, $info);
            }
        }
    }

    /**
     * @description Perform filters fields
     * */
    protected function performFilters() {
        if (!isset($this->_module['filters'])) return;

        foreach ($this->getModuleParam('filters') as $field => $params) {
            $params = $this->performFilterField($field, $params);

            if ($params !== false) {
                $this->setModuleParam('filters/'.$field, $params);
            } else {
                $this->unsetModuleParam('fitlers/'.$field);
            }
        }
    }

    /**
     * @description Perform filter field
     * */
    protected function performFilterField($field, $params) {
        $method = 'perform'.StringTools::functionalize($field).'FilterField';
        if (method_exists($this,$method)) {
            $params = $this->$method($field, $params, array());
        } else {
            $field_info = $this->getModuleParam('fields/'.$field);
            if (!$field_info) {
                $field_info = $this->getModuleParam('initial_fields/'.$field);
                if (!$field_info) return false;
                $field_info = $this->performField($field, $field_info);
            }
            if (!is_array($params)) $params = array();

            if (!isset($params['title'])) $params['title'] = $field_info['title'];

            $method = 'perform'.(isset($params['type']) ? $params['type'] : 'Unknown').'FilterType';
            if (method_exists($this,$method)) {
                $params = $this->$method($field, $params, $field_info);
            }
        }
        return $params;
    }

    /**
     * @description Perform unknown filter type
     * */
    protected function performUnknownFilterType($field, $params, $field_info) {
        switch ($field_info['type']) {
            case 'datepicker':
                $params['type'] = 'datepicker';
                break;
            case 'area':
            case 'text':
            case 'rich':
                if (isset($this->_ms['columns'][$field]) && strpos($this->_ms['columns'][$field]['type'],'int') !== false){
                    $params['exact'] = true;
                }
                $params['type'] = 'text';
                break;
            case 'select':
            case 'radioselect':
            case 'multiselect':
            case 'multicheckbox':
                $params = $this->performSelectFilterType($field, $params, $field_info);
                break;
            case 'checkbox':
                $params['type'] = 'select';
                $params['local_field'] = $field;
                $params['items'] = array('0'=>'Нет',1=>'Да');
                break;

        }
        return $params;
    }

    /**
     * @description Perform select filter type
     * */
    protected function performSelectFilterType($field, $params, $field_info) {
        if (!isset($params['type'])) {
            $params['type'] = (strpos($field_info['type'],'multi') !== false) ? 'multiselect' : 'select';
        }
        if (!isset($params['items'])) {
            if ($field_info['type'] == 'checkbox') {
                $params['items'] = array('0'=>'Нет',1=>'Да');
            } else {
                $params['items'] = $field_info['items'];
            }
        }

        $params['local_field'] = isset($params['local_field']) ? $params['local_field'] : $field_info['local_field'];
        return $params;
    }

    /**
     * @description Perform multiselect filter type
     * */
    protected function performMultiselectFilterType($field, $params, $field_info){
        return $this->performSelectFilterType($field, $params, $field_info);
    }

    /**
     * @description Perform radioselect filter type
     * */
    protected function performRadioselectFilterType($field, $params, $field_info){
        return $this->performSelectFilterType($field, $params, $field_info);
    }

    /**
     * @description Perform multicheckbox filter type
     * */
    protected function performMulticheckboxFilterType($field, $params, $field_info){
        return $this->performSelectFilterType($field, $params, $field_info);
    }

    /**
     * @description Set sort criteria
     * */
    protected function setSortCriteria($criteria) {
        $this->setModuleSessionParam('sort',$criteria);
    }

    /**
     * @description Load sort criteria
     * @return \Illuminate\Database\Query\Builder
     * */
    protected function getSortCriteria() {
        if ($sort_field = isset($_GET['sort']) ? $_GET['sort'] : null) {
            $sort = null;
            if (isset($this->_ms['columns'][$sort_field])) {
                $sort = $sort_field;
            } elseif (isset($this->_ms['relations'][$sort_field])) {
                $vars = ffDBOperator::calculateRelationVariables(new $this->_module['model'], $this->_ms['relations'][$sort_field], $sort_field);
                $sort = $vars['local_field'];
            }

            if ($sort) {
                if ($sort_param = $this->getModuleSessionParam('sort')) {
                    $this->setModuleSessionParam('sort', strpos($sort_param, 'DESC') !== false ? $sort : $sort.' DESC');
                } else {
                    $this->setModuleSessionParam('sort',$sort);
                }
            }

            return Redirect::to('admin/' . $this->_module_name . '/');
        }

        if ($sort_param = $this->getModuleSessionParam('sort')) {
            $sort = $sort_param;
        } elseif ($sort_param = $this->getModuleParam('sort')) {
            $sort = $sort_param;
        } else {
            $sort = array_shift(array_keys($this->getModuleParam('fields')));
        }
        if (strpos(strtolower($sort), 'desc') === false) {
            $sort_dir   = 'asc';
            $sort_field = trim(substr(trim($sort), 0, -3));
        } else {
            $sort_dir   = 'desc';
            $sort_field = substr($sort, 0, -5);
        }

        $this->view->sort = $sort = array(
            'field' => $sort_field,
            'dir'   => strtolower($sort_dir)
        );
        return $sort;
    }

    /**
     * @description Load filter criteria
     * @return \Illuminate\Database\Query\Builder
     * */
    protected function getFilterCriteria() {
        if (!isset($this->_module['filters'])) return null;

        if (Input::get('filter_reset') || Input::get('filters')) {
            $reset = Input::get('filter_reset');
            $data  = Input::get('filters', array());
            $filtered_data = ($reset) ? array() : $this->getModuleSessionParam('filters');
            foreach ($data as $field => $value) {
                if ($param = $this->getModuleParam('filters/'.$field)) {
                    if (is_array($value)) {
                        if (trim(implode('',array_values($value))) != '') {
                            $filtered_data[$field] = $value;
                        } else {
                            if (isset($filtered_data[$field])) unset($filtered_data[$field]);
                        }
                    } elseif (trim($value) != '') {
                        $filtered_data[$field] = $value;
                    } else {
                        if (isset($filtered_data[$field])) unset($filtered_data[$field]);
                    }
                }
            }
            $this->setModuleSessionParam('filters', $filtered_data);
            $this->setModuleSessionParam('page',null);
            return Redirect::to('admin/' . $this->_module_name . '/');
        }

        if (($filters = $this->getModuleSessionParam('filters')) && count($filters)) {
            $res = new C();
            foreach ($filters as $field => $value) {
                if ($params = $this->getModuleParam('filters/'.$field)) {
                    $method = 'process'.StringTools::functionalize($field).'FilterField';
                    if (method_exists($this,$method)) {
                        $this->$method($res, $value, $params);
                    } else {
                        $method = 'process'.(isset($params['type']) ? StringTools::functionalize($params['type']) : 'Unknown').'FilterType';
                        if (method_exists($this,$method)) {
                            $this->$method($res, $field, $value, $params);
                        }
                    }
                }
            }
            return $res->isEmpty() ? null : $res;
        } else {
            return null;
        }

    }

    /**
     * @description Load menu items
     * @return void
     * */
    protected function performMenu() {
        $file = dirname(__FILE__).'/../config/menu.yml';

        $menu_data = (is_file($file) ? sfYaml::load($file) : array());

        $this->view->menu_data = $menu_data;
        if ($this->_module) {
            $this->setModuleParam('menu_data',$menu_data);
        }
    }

    /**
     * @description Process Text filter type
     * @param \Illuminate\Database\Query\Builder $criteria
     * @param string $field
     * @param array $value
     * @param array $params
     * @return void
     * */
    protected function processTextFilterType( $criteria, $field, $value, $params) {
        if (isset($params['process_type'])) {
            switch($params['process_type']) {
                case 'comma_separated':
                    $value = explode(',',$value);
                    if (!is_array($value)) $value = array($value);
                    $value = array_map('trim',$value);
                    $criteria->where(array($field=>$value));
                    break;
                case 'exact':
                    $criteria->where(array($field=>$value));
                    break;
                default:
                    break;
            }
        } else {
            $criteria->where($field.' LIKE '.DB::connection()->getPdo()->quote('%'.$value.'%'));
        }
    }

    /**
     * @description Process Select filter type
     * @param \Illuminate\Database\Query\Builder $criteria
     * @param string $field
     * @param array $value
     * @param array $params
     * @return void
     * */
    protected function processSelectFilterType( $criteria, $field, $value, $params) {
        $criteria->where(array($params['local_field']=>$value));
    }

    /**
     * @description Process Datepicker filter type
     * @param \Illuminate\Database\Query\Builder $criteria
     * @param string $field
     * @param array $value
     * @param array $params
     * @return void
     * */
    protected function processDatepickerFilterType( $criteria, $field, $value, $params) {
        $criteria->where('DATE('.$field.') = DATE('.DB::connection()->getPdo()->quote($value).')');
    }

    /**
     * @description Process Datepicker Range filter type
     * @param \Illuminate\Database\Query\Builder $criteria
     * @param string $field
     * @param array $value
     * @param array $params
     * @return void
     * */
    protected function processDatepickerRangeFilterType( $criteria, $field, $value, $params) {
        if (is_array($value))
        {
            if (isset($value['from']) && !empty($value['from'])) {
                $criteria->where('DATE('.$field.') >= DATE('.DB::connection()->getPdo()->quote($value['from']).')');
            }
            if (isset($value['to'])   && !empty($value['to'])) {
                $criteria->where('DATE('.$field.') <= DATE('.DB::connection()->getPdo()->quote( $value['to'] ).')');
            }
        }
    }

    /**
     * @description Process number range filter type
     * @param \Illuminate\Database\Query\Builder $criteria
     * @param string $field
     * @param array $value
     * @param array $params
     * @return void
     * */
    protected function processNumberRangeFilterType($criteria, $field, $value, $params) {
        if (is_array($value))
        {
            if (isset($value['from']) && !empty($value['from'])) {
                $criteria->where($field.' > '.DB::connection()->getPdo()->quote($value['from']).'');
            }
            if (isset($value['to'])   && !empty($value['to'])) {
                $criteria->where($field.' < '.DB::connection()->getPdo()->quote( $value['to'] ).'');
            }
        }
    }

    /**
     * @description Check this action is available. Return bool or redirect if $redirect is true
     * @param string $action_name
     * @param bool $redirect
     * @return bool
     * */
    protected function requireAction($action_name, $redirect = true) {
        if ($this->getModuleParam('actions/'.$action_name)) {
            if (!$redirect) return true;
        } else {
            if ($redirect) {
                return Redirect::to('admin/' . $this->_module_name . '/');
            } else {
                return false;
            }
        }
    }

    /**
     * @description Do something before save object
     * @param array $data
     * */
    public function beforeSaveProcessData(&$data) {

    }

    /**
     * @description Do something after save object
     * @param array $data
     * @param Eloquent $object|null
     * @param bool $was_new
     * */
    public function afterSuccessfulSave($data, $object = null, $was_new = false){

    }

    /**
     * @description add error message
     * @param string $text
     * */
    public function addErrorMessage($text) {
        $this->view->setMessage(array('type'=>'error','text'=>$text));
    }

    /**
     * @description add success message
     * @param string $text
     * */
    public function addSuccessMessage($text) {
        $this->view->setMessage(array('type'=>'success','text'=>$text));
    }

    /**
     * @description move up model element action
     * */
    public function anyMoveUp() {
        /** @var Eloquent $object  */
        $object = call_user_func(array($this->_module['model'], 'find'), Input::get('id'));
        if ($object) $object->moveBack();
        return Redirect::to('admin/' . $this->_module_name . '/');
    }

    /**
     * @description move down model element action
     * */
    public function anyMoveDown() {
        /** @var Eloquent $object  */
        $object = call_user_func(array($this->_module['model'], 'find'), Input::get('id'));
        if ($object) $object->moveForward();
        return Redirect::to('admin/' . $this->_module_name . '/');
    }

    /**
     * @description move to top model element action
     * */
    public function anyMoveTop() {
        /** @var Eloquent $object  */
        $object = call_user_func(array($this->_module['model'], 'find'), Input::get('id'));
        if ($object) $object->moveFirst();
        return Redirect::to('admin/' . $this->_module_name . '/');
    }

    /**
     * @description move to bottom model element action
     * */
    public function anyMoveBottom() {
        /** @var Eloquent $object  */
        $object = call_user_func(array($this->_module['model'], 'find'), Input::get('id'));
        if ($object) $object->moveLast();
        return Redirect::to('admin/' . $this->_module_name . '/');
    }

    /**
     * @description save order model elements action
     * */
    public function anySaveOrderElements() {
        if(!Request::ajax() || !($data = Input::get('data')))
            die();
        $model = Input::get('model');
        foreach($data as $el) {
            /** @var Eloquent $model  */
            $object = $model::find($el['el_id']);
            if($object) {
                $object->_position = $el['el_pos'];
                $object->save();
            }
        }
        die();
    }

    /**
     * @description save order model elements for gallery action
     * */
    public function anySaveOrderGalleryElements() {
        if(!Request::ajax() || !($data = Input::get('data')))
            die();
        $model = Input::get('model');
        foreach($data as $el) {
            /** @var Eloquent $model  */
            $object = $model::find($el['el_id']);
            if($object) {
                $object->_position = $el['el_pos'];
                $object->save();
            }
        }
        die();
    }

    /**
     * @description upload file action
     * */
    public function anyUploadFile() {
        if(!Request::ajax() || !($model = Input::get('model')) || !($id = Input::get('id')))
            die();
        /** @var Eloquent $model  */
        $object = $model::find($id);
        if(is_object($object) && !empty($_FILES) && count($_FILES)>0){
            FilesHelper::create($object)->saveFiles();
            $object = $object->toArray();
            echo json_encode(array('preview'=>$object['image']['sizes']['show_gallery']['link'],'original'=>$object['image']['link']));
        }
        die();
    }

    /**
     * @description upload files action
     * */
    public function anyUploadFiles() {
        if(!Request::ajax() || !($model = Input::get('model')) || !($id = Input::get('id')))
            die();
        /** @var Eloquent $model  */
        $object = $model::find($id);
        if($object && !empty($_FILES) && count($_FILES)>0){
            FilesHelper::create($object)->saveFiles();
            $object = $object->toArray();
            echo json_encode(array('object'=>$object));
        }
        die();
    }

    /**
     * @description delete file action
     * */
    public function anyDeleteFile($id) {
        if (!$this->requireAction('edit',false)) die('false no action edit');
        $model = $this->_module['model'];
        if ($id && ($name = Input::get('name')) && ($rel = Input::get('rel')) && $object = $model::find($id)) {
            FilesHelper::create($object)->removeFile($rel, $name);
            echo json_encode(array('error' => false));
        } else {
            echo json_encode(array('error' => true));
        }
        die();
    }

	/**
	 * @description Setup the layout used by the controller.
	 * @return void
	 */
	public function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

    /**
     * @description Build admin menu
     * @return string
     * */
    private function buildAdminMenu() {
        $module = $this->_module_name;
        $menu_data = $this->view->getVar('menu_data');
        $html = $this->parseMenuItems($menu_data, $module);
        return $html;
    }

    /**
     * @description Prepare menu html
     * @param array $data Menu items
     * @param string $module Current module name
     * @return string
     * */
    private function parseMenuItems($data, $module) {
        if (is_array($data) && count($data)) {
            $html = '';
            foreach ($data as $key => $item){
                $class_active = ($key === $module ? ' active ' : '');
                $icon = isset($item['icon']) && !empty($item['icon']) ? $item['icon'] : 'fa-angle-double-right';

                $has_sub = false;

                if(!is_array($item) || !array_key_exists('sub', $item) || empty($item['sub'])){
                    $html .= '<li class="'.($has_sub ? '': '').' '.$class_active.'" title="'.$item['title'].'"><a href="/admin/'.$key.'/"> <i class=" fa-lg fa  fa-fw '.$icon.'"></i> <span class="menu-item-parent">'.self::prepareMenuTitle($item['title']).'</span></a></li>';
                }else if(is_array($item)) {
                    $open = array_key_exists($module, $item['sub']) && !empty($module) ? 'block': '';

                    $html .= '<li class="'. ($open == '' ? '' : 'open') .'"  title="'.$item['title'].'">
                            <a href="#"> <i class=" fa-lg fa  fa-fw '.$icon.'"></i> <span class="menu-item-parent">'.self::prepareMenuTitle($item['title']).'</span> </a>
                            <ul style="display: '. $open .';">';
                    foreach($item['sub'] as $sub_key=>$sub_item){
                        $sub_icon = isset($sub_item['icon']) && !empty($sub_item['icon']) ? $sub_item['icon'] : 'fa-angle-double-right';
                        $active_sub = $sub_key === $module ? ' active ' : '';
                        $html .= '<li class="'.$active_sub.'" title="'.$sub_item['title'].'"><a href="/admin/'.$sub_key.'/"> <i class=" fa-lg fa  fa-fw '.$sub_icon.'"></i> <span class="menu-item-parent">'.self::prepareMenuTitle($sub_item['title'], true).'</span></a></li>';
                    }
                    $html .= '</ul></li>';
                }
            }
            return $html;
        } else {
            return '';
        }
    }

    /**
     * @description Substr long menu item name
     * @return string
     * @param string $title
     * @param bool $sub Its sub menu item or not
     * */
    private static function prepareMenuTitle($title, $sub = false) {
        $len = $sub ? 15 : 30;
        if(mb_strlen($title, 'UTF-8') > $len) {
            $title = mb_substr($title, 0, $len, 'UTF-8').'..';
        }
        return $title;
    }

    /**
     * @description Merge object with data
     * @param Eloquent $object
     * @param array $data
     * */
    public function mergeData(&$object, $data) {
        if(is_array($data) && !empty($data)) {
            foreach ($data as $field_name => $field) {
                if(!isset($this->_ms['columns'][$field_name]))
                    continue;
                $object->{$field_name} = $field;
            }
        }
    }

    /**
     * @description Build array for select
     * @param array $list
     * @param string $key_field
     * @param string $value_field
     * @return array
     * */
    public function buildSelectList($list, $key_field, $value_field) {
        if(!is_array($list) || empty($list))
            return array();
        $result = array();
        foreach ($list as $item) {
            if(is_object($item)) {
                if(!isset($item->{$key_field}) || !isset($item->{$value_field})) {
                    continue;
                }
                $result[$item->{$key_field}] = $item->{$value_field};
            } else if(is_array($item)) {
                if(!isset($item[$key_field]) || !isset($item[$value_field])) {
                    continue;
                }
                $result[$item[$key_field]] = $item[$value_field];
            }
        }

        return $result;
    }

}
