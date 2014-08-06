<?php

class CitiesController extends ListController{
    public function loadIdCountryItems() {
        $countries = Q::create('countries')->select('title, id')->useValue('title')->indexBy('id')->exec();
        $res = array(0=>'');
        $res += (is_array($countries)) ? $countries : array();
        return $res;
    }
    public function loadIdRegionItems() {
        $items = Q::create('regions')->select('title, id')->useValue('title')->indexBy('id')->exec();
        $res = array(0=>'');
        $res += (is_array($items)) ? $items : array();
        return $res;
    }
}
