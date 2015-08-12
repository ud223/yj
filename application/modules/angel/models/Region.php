<?php

class Angel_Model_Region extends Angel_Model_AbstractModel {
    protected $_document_class = '\Documents\Region';

    //新增课程信息
    public function addRegion($name, $coordinate) {
        $data = array('name' => $name,
            'coordinate' => $coordinate);

        $result = $this->add($data);

        return $result;
    }

    //保存课程信息
    public function saveRegion($id, $name, $coordinate) {
        $data = array('name' => $name,
            'coordinate' => $coordinate);

        $result = $this->save($id, $data);

        return $result;
    }

    public function getByIds($id) {
        $result = $this->_dm->createQueryBuilder($this->_document_class)
            ->field('id')->in($id)->getQuery();

        return $result;
    }
}
