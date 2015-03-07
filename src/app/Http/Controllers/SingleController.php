<?php
namespace SmallTeam\Dashboard\App\Http\Controllers;

class SingleController extends Controller {

    function anyIndex() {
        return get_class($this).'::index';
    }

}