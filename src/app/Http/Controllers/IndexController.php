<?php
namespace SmallTeam\Dashboard\App\Http\Controllers;

class IndexController extends Controller {

	public function anyIndex()
	{
		abort(404);
		return get_class($this).'::index';
	}

}