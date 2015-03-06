<?php
namespace SmallTeam\Dashboard\App\Http\Controllers;

class IndexController extends Controller {

	public function anyIndex()
	{
		return get_class($this).'::index';
	}

}