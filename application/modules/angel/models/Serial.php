<?php

class Angel_Model_Serial extends Angel_Model_AbstractModel {
    protected $_document_class = '\Documents\Serial';

    public function addSerial($num, $prefix) {
        $result = false;
        $serial = new $this->_document_class();

        $serial->max_num = $num;
        $serial->prefix = $prefix;

        try {
            $this->_dm->persist($serial);
            $this->_dm->flush();

            $result = $serial->id;
        } catch (Exception $e) {
            $this->_logger->info(__CLASS__, __FUNCTION__, $e->getMessage() . "\n" . $e->getTraceAsString());
        }

        return $result;
    }

    //保存流水号信息
    public function saveSerial($id, $num, $prefix) {
        $data = array('num' => $num,
            'prefix' => $prefix);

        $result = $this->save($id, $data);

        return $result;
    }

    public function getLastSerial() {
        $result = $this->_dm->createQueryBuilder($this->_document_class)->getQuery()->sort('created_at', -1)->limit(1)->skip(0);

        return $result;
    }
}