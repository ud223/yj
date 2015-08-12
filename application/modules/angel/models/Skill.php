<?php

class Angel_Model_Skill extends Angel_Model_AbstractModel {
    protected $_document_class = '\Documents\Skill';

    public function addSkill($name, $photo, $value, $type) {
//        $data = array('name' => $name,
//            'value'=>$value,
//            'photo' => $photo,
//            'type'=>$type);
//
//        $result = $this->add($data);
//
//        return $result;
        $result = false;
        $skill = new $this->_document_class();

        $skill->name = $name;
        $skill->value = $value;
        $skill->photo = $photo;
        $skill->type = $type;

        try {
            $this->_dm->persist($skill);
            $this->_dm->flush();

            $result = $skill->id;
        } catch (Exception $e) {
            $this->_logger->info(__CLASS__, __FUNCTION__, $e->getMessage() . "\n" . $e->getTraceAsString());
        }

        return $result;
    }

    //保存课程信息
    public function saveSkill($id, $name, $photo, $description) {
        $data = array('name' => $name,
            'description'=>$description,
            'photo' => $photo);

        $result = $this->save($id, $data);

        return $result;
    }

    public  function getByIds($name) {
        $result = $this->_dm->createQueryBuilder($this->_document_class)
            ->field(name)->equals($name)->getQuery()->sort('created_at', -1)->limit(1)->skip(0);

        return $result;
    }
}