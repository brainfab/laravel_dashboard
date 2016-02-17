<?php namespace SmallTeam\Dashboard\Controller;
use Illuminate\Http\Request;

/**
 * SingleFormControllerInterface.
 * */
interface SingleFormControllerInterface
{

    public function edit();

    public function update(Request $request);

}