<?php

class CommentsController extends ListController{
    public function loadIdUserItems() {
        $items = Q::create('users')->select('CONCAT("#",id," - ", name, " ", surname) as title, id')->useValue('title')->indexBy('id')->exec();
        $res = array(0=>'');
        $res += (is_array($items) ? $items : array());

        return $res;
    }
    public function loadIdProductItems() {
        $items = Q::create('products')->select('CONCAT(id," - ", title) as title, id')
            ->useValue('title')->indexBy('id')->orderBy('id_category, id_section')->exec();
        $res = array(0=>'');
        $res += (is_array($items) ? $items : array());

        return $res;
    }
}
