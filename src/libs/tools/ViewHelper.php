<?php

class ViewHelper {

    const
        RENDER_LAYOUTED     = 'view_render_layouted',
        RENDER_STANDALONE   = 'view_render_standalone';

    protected static $_instance = null;
    protected $_vars = null,
              $_render_mode = 'view_render_layouted',
              $_template = '',
              $_messages = array(),
              $_messages_by_key = array(),
              $layout = '';

    public function __set($name, $value) {
        $this->_vars[$name] = $value;
    }

    public function __get($name) {
        $res = isset($this->_vars[$name]) ? $this->_vars[$name] : null;
        return $res;
    }
    /**
     * @return ViewHelper instance singleton
     */
    public static function getInstance() {
        if(is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public static function getVars() {
        return self::getInstance()->_vars;
    }

    private function __construct() {
        $this->_messages = Session::get('__view.messages', array());
        $this->_messages_by_key = Session::get('__view.messages_by_key', array());
    }

    public function setTemplate($template) {
        $this->_template = $template;
    }

    public function getTemplate() {
        return $this->_template;
    }

    /**
     * @param BaseController $controller
     * @param string|null $template
     * @return \Illuminate\View\View
     * */
    public function make($controller, $template = null) {
        $template = is_null($template) ? $this->getTemplate() : $template;
        $controller->postAction();

        $tpl_vars = ViewHelper::getVars();

        $tpl_vars['_ftl'] = array(
            'base'     => $_SERVER['HTTP_HOST'],
            'session'   => Session::all(),
            'get'       => &$_GET,
            'post'      => &$_POST,
            'request'   => &$_REQUEST,
            'cookie'    => &$_COOKIE,
            'server'    => &$_SERVER
        );

        if(is_array($tpl_vars) && !empty($tpl_vars)) {
            foreach ($tpl_vars as $k => $var) {
                View::share($k, $var);
            }
        }

        if($this->getRenderMode() == ViewHelper::RENDER_LAYOUTED) {
            $this->layout = empty($this->layout) ? 'admin:default' : $this->layout;
            $controller->setupLayout();
        }

        return View::make($template);
    }

    public function setLayoutTemplate($template) {
        $this->layout = $template;
    }

    public function setRenderType($render_type) {
        $this->_render_mode = $render_type;
        return $this;
    }

    public function getRenderMode() {
        return $this->_render_mode;
    }

    public function getVar($key) {
        $var = is_array($this->_vars) && array_key_exists($key, $this->_vars) ? $this->_vars[$key] : null;
        return $var;
    }

    public function setMessage($message, $session = true) {
        if ($session) {
            $messages = Session::get('__view.messages', array());
            $messages[] = $message;
            Session::set('__view.messages', $messages);
        }
        $this->_messages[] = $message;
    }

    public function setMessageByKey($key, $message, $session = true) {
        if ($session) {
            $messages = Session::get('__view.messages_by_key', array());
            $messages[$key][] = $message;
            Session::set('__view.messages_by_key', $messages);
        }
        $this->_messages_by_key[$key][] = $message;
    }

    public function hasMessages() {
        $messages = Session::get('__view.messages', false);
        $has = is_array($messages) && !empty($messages);
        return $has;
    }
    public function hasMessagesByKey($key) {
        $messages = Session::get('__view.messages_by_key.'.$key, false);
        $has = $messages!==false;
        return $has;
    }

    public function getMessages($clear = true) {
        $res = $this->_messages;
        if ($clear) {
            $this->_messages = array();
            Session::forget('__view.messages');
        }
        return $res;
    }

    public function getMessagesByKey($key, $clear = true) {
        if (!$this->hasMessagesByKey($key)) return array();
        $res = $this->_messages_by_key[$key];
        if ($clear) {
            $this->_messages_by_key[$key] = array();
            Session::forget('__view.messages_by_key.'.$key);
        }
        return $res;
    }
}