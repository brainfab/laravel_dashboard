<?php

/**
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @copyright SmallTeam (c) 2014
 */

class IndexController extends SmallTeam\Admin\BaseController {
    public function getIndex() {
        $this->view->setTemplate('admin::index');
        return $this->view->make($this);
    }

    public function anyLogin() {
        if(Admin::isLoggedIn()) {
            return Redirect::to('admin/');
        }
        $this->view->setLayoutTemplate('admin::default_login');
        $this->view->setTemplate('admin::login');

        $login = isset($_POST['login']) ? trim(strip_tags($_POST['login'])) : false;
        $pass = isset($_POST['password']) ? $_POST['password'] : false;
        if($login && $pass) {
            if(Admin::login($login, $pass)) {
                return Redirect::to('admin/');
            } else {
                $this->view->error = 'Логин или пароль введены не верно';
            }
        }

        return $this->view->make($this);
    }

    public function anyLogout() {
        Admin::logout();
        return Redirect::to('admin/login');
    }
}