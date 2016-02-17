<?php namespace SmallTeam\Dashboard\Controller;

use Illuminate\Http\Request;
use SmallTeam\Dashboard\Routing\Router;

/**
 * CRUDController
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 09.05.2015
 * */
class CRUDController extends Controller implements CRUDControllerInterface
{

    public function index()
    {
        return __METHOD__;
    }

    public function create()
    {
        return __METHOD__;
    }

    public function store(Request $request)
    {
        return __METHOD__;
    }

    public function show($id = null)
    {
        $id = intval($id);
        if ($id <= 0) {
            abort(404);
        }

        return __METHOD__;
    }

    public function edit($id = null)
    {
        $id = intval($id);
        if ($id <= 0) {
            abort(404);
        }

        return __METHOD__;
    }

    public function update(Request $request, $id = null)
    {
        $id = intval($id);
        if ($id <= 0) {
            abort(404);
        }

        return __METHOD__;
    }

    public function destroy($id = null)
    {
        return __METHOD__;
    }

}