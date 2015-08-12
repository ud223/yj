<?php

class Angel_Model_Lesson extends Angel_Model_AbstractModel {
    protected $_document_class = '\Documents\Lesson';

    //新增课程信息
    public function addLesson($name, $photo, $description) {
        $data = array('name' => $name,
            'description'=>$description,
            'photo' => $photo);

        $result = $this->add($data);

        return $result;
    }

    //保存课程信息
    public function saveLesson($id, $name, $photo, $description) {
        $data = array('name' => $name,
            'description'=>$description,
            'photo' => $photo);

        $result = $this->save($id, $data);

        return $result;
    }

    public  function getByIds($id) {
        $result = $this->_dm->createQueryBuilder($this->_document_class)
            ->field('id')->in($id)->getQuery();

        return $result;
    }
}
