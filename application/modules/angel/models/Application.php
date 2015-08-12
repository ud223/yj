<?php

class Angel_Model_Application extends Angel_Model_AbstractModel {
    protected $_document_class = '\Documents\Application';

    //新增课程信息
    public function addApplication($teacher) {
        $data = array('teacher' => $teacher);

        $result = $this->add($data);

        return $result;
    }

    //保存课程信息
    public function saveApplication($id, $teacher, $state) {
        $data = array('teacher' => $teacher, 'state'=>$state);

        $result = $this->save($id, $data);

        return $result;
    }

    public  function getByIds($id) {
        $result = $this->_dm->createQueryBuilder($this->_document_class)
            ->field('id')->in($id)->getQuery();

        return $result;
    }

    public function applyApplication($id) {
        $data = array( 'state'=>2);

        $result = $this->save($id, $data);

        return $result;
    }

    public function rejectApplication($id) {
        $data = array( 'state'=>3);

        $result = $this->save($id, $data);

        return $result;
    }
}
