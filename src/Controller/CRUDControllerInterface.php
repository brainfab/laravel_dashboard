<?php namespace SmallTeam\Dashboard\Controller;

use Illuminate\Http\Request;

/**
 * CRUDControllerInterface.
 * */
interface CRUDControllerInterface
{
    public function index();

    public function create();

    public function store(Request $request);

    public function show($id);

    public function edit($id);

    public function update(Request $request, $id);

    public function destroy($id);
}