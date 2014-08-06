<?php
class CalendarController extends ListController {
    public function actionDefault(){
        $this->view->setTemplate('calendar/default.tpl');
        $this->view->events = Q::create('events')->select('')->orderBy('start DESC')->exec();
    }

    public function actionGetEvents() {
        $events = Q::create('events')->select('')->orderBy('start DESC')->exec();
        echo json_encode(array('list' => $events));
        die();
    }

    public function actionAdd() {
        $data = $this->route->getVar('data');
        $event = new Event();
        $event->mergeData($data);
        $event->save();

        if($event->id){
            echo json_encode(array('error' => false));
        }
        else{
            echo json_encode(array('error' => true));
        }
        die();
    }

    public function actionUpdate() {
        $data = $this->route->getVar('data');
        $event_id = $this->route->getVar('id');
        $event = Event::loadOne($event_id);

        if(is_object($event)) {
            $event->mergeData($data);
            $event->save();
            echo json_encode(array('error' => false));
        }
        else{
            echo json_encode(array('error' => true));
        }
        die();
    }

    public function actionRemove() {
        $event_id = $this->route->getVar('id');
        $event = Event::loadOne($event_id);

        if(is_object($event)) {
            $event->delete();
            echo json_encode(array('error' => false));
        }
        else{
            echo json_encode(array('error' => true));
        }
        die();
    }
}