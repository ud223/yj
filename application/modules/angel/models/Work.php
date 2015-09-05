<?php

class Angel_Model_Work extends Angel_Model_AbstractModel {
    protected $_document_class = '\Documents\Work';

    public function addWork($hour) {
        $result = false;
        $work = new $this->_document_class();

        $work->hour = $hour;


        try {
            $this->_dm->persist($work);
            $this->_dm->flush();

            $result = $work->id;
        } catch (Exception $e) {
            $this->_logger->info(__CLASS__, __FUNCTION__, $e->getMessage() . "\n" . $e->getTraceAsString());
        }

        return $result;
    }

    //保存最大工时信息
    public function saveWork($id, $hour) {
        $data = array('hour' => $hour);

        $result = $this->save($id, $data);

        return $result;
    }
}