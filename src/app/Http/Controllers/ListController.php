<?php
namespace SmallTeam\Dashboard\App\Http\Controllers;

use \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ListController extends Controller {

    public function anyIndex() {
        return get_class($this).'::anyIndex';
    }

    public function anyAdd() {
        return get_class($this).'::anyAdd';
    }

    public function anyEdit($id = null) {
        $id = intval($id);
        if($id <= 0) {
            abort(404);
        }

        return get_class($this).'::anyEdit';
    }

    public function anyDelete($id = null) {
        return get_class($this).'::anyDelete';
    }

}