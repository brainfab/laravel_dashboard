<?php
namespace SmallTeam\Admin;

use Illuminate\Database\Eloquent\Model as Eloquent,
    Illuminate\Support\Facades\DB,
    Illuminate\Support\Facades\Input,
    Illuminate\Support\Facades\Redirect,
    Illuminate\Support\Facades\Session,
    Illuminate\Support\Facades\Paginator,
    Illuminate\Support\Facades\File;

/**
 * Admin
 *
 */
class Admin extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'st_admins';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password',);

    public static function login($login, $password) {
        $login = trim(strip_tags($login));
        $password = md5($password);

        $adminModel = new Admin;
        $admin_user = $adminModel->where('login', '=', $login)->where('password', '=', $password)->first();
        if(is_null($admin_user) || empty($admin_user)) {
            return false;
        }
        Session::set('admin-info', $admin_user->toArray());
        return $admin_user;
    }

    public static function logout() {
        Session::forget('admin-info');
    }

    public static function isLoggedIn() {
        $info = Session::get('admin-info');
        $res = is_array($info) && !empty($info);
        return $res;
    }
}