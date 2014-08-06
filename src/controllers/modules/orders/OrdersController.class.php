<?php

class OrdersController extends ListController {
    public function loadIdOrderStatusItems() {
        $items = DB::table('orders_statuses')->select(array('title', 'id'))->orderBy('id')->get();
        $items = $this->buildSelectList($items, 'id', 'title');
        $res = array(0=>'');
        $res += (is_array($items) ? $items : array());

        return $res;
    }

    public function loadIdDeliveryItems() {
        $items = DB::table('deliveries')->select(array('title', 'id'))->orderBy('id')->get();
        $items = $this->buildSelectList($items, 'id', 'title');
        $res = array(0=>'');
        $res += (is_array($items) ? $items : array());

        return $res;
    }

    public function loadIdPaymentTypeItems() {
        $items = DB::table('payment_types')->select(array('title', 'id'))->orderBy('id')->get();
        $items = $this->buildSelectList($items, 'id', 'title');
        $res = array(0=>'');
        $res += (is_array($items) ? $items : array());

        return $res;
    }

    public function loadIdUserItems() {
        $items = DB::table('users')->select(array(DB::raw('CONCAT("#",id," - ", name, " ", surname) as title'), 'id'))->get();
        $items = $this->buildSelectList($items, 'id', 'title');
        $res = array(0=>'');
        $res += (is_array($items) ? $items : array());

        return $res;
    }
}
