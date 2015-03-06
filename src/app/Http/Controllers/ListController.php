<?php
namespace SmallTeam\Dashboard\App\Http\Controllers;

class ListController extends Controller {

    public function anyIndex() {
        return get_class($this).'::anyIndex';
    }

    public function anyAdd() {
        return get_class($this).'::anyAdd';
    }

    public function anyEdit($id = null) {
        return get_class($this).'::anyEdit';
    }

    public function anyDelete($id = null) {
        return get_class($this).'::anyDelete';
    }

}