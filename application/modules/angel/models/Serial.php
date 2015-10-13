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
        $data = array('max_num' => $num,
            'prefix' => $prefix);

        $result = $this->save($id, $data);

        return $result;
    }

    public function getLastSerial() {
        $query = $this->_dm->createQueryBuilder($this->_document_class);

        $result = null;
        $result = $query->getQuery();

        if (count($result) > 0) {
            foreach ($result as $r) {
                return $r;
            }
        }

        return false;
    }
}