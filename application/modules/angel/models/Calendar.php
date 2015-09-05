<?php

class Angel_Model_Calendar extends Angel_Model_AbstractModel {
    protected $_document_class = '\Documents\Calendar';

    public function addCalendar($busy_date, $teacher) {
        $result = false;

        $data = array('busy_date'=>$busy_date, 'teacher'=>$teacher);

        $result = $this->add($data);

        return $result;
    }

    public function saveCalendar($id, $busy_date) {
        $data = array('busy_date'=>$busy_date);

        $result = $this->save($id, $data);

        return $result;
    }
}