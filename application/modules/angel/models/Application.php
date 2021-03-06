<?php

class Angel_Model_Application extends Angel_Model_AbstractModel {
    protected $_document_class = '\Documents\Application';

    //新增课程信息
    public function addApplication($customer) {
        $data = array('customer'=>$customer);

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

    public function getApps($conditions) {
        $query = $this->_dm->createQueryBuilder($this->_document_class);

        $query = $query->field('customer.$id')->in($conditions)->field('state')->equals(1);

        $query = $query->sort('created_at', -1);
        $result = null;

        $result = $this->paginator($query);

        return $result;
    }
}
