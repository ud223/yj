<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/8/10
 * Time: 14:02
 */

class Angel_Model_Teacher extends Angel_Model_AbstractModel {
    protected $_document_class = '\Documents\UserInfo';

    public function addTeacher($name, $birthday, $place, $educational, $certificate, $phone, $code, $email, $qq, $wechat, $location, $lessons, $bank, $bank_code, $description, $skills, $photo, $categorys, $regions) {
        $data = array('usertype' => 2,
            'name'=>$name,
            'birthday'=>$birthday,
            'place'=>$place,
            'educational'=>$educational,
            'certificate'=>$certificate,
            'phone'=>$phone,
            'code'=>$code,
            'email'=>$email,
            'qq'=>$qq,
            'wechat'=>$wechat,
            'location'=>$location,
            'region'=>$regions,
            'lesson'=>$lessons,
            'bank'=>$bank,
            'bank_code'=>$bank_code,
            'description'=>$description,
            'skill'=>$skills,
            'photo'=>$photo,
            'region'=>$regions,
            'category'=>$categorys);

        $result = $this->add($data);

        return $result;
    }

    public function ModifyTeacher($id, $name, $birthday, $place, $educational, $certificate, $phone, $code, $email, $qq, $wechat, $location, $lessons, $bank, $bank_code, $description, $skills, $photo, $frozen, $delete, $categorys, $regions) {
        $data = array('usertype' => 2,
            'name'=>$name,
            'birthday'=>$birthday,
            'place'=>$place,
            'educational'=>$educational,
            'certificate'=>$certificate,
            'phone'=>$phone,
            'code'=>$code,
            'email'=>$email,
            'qq'=>$qq,
            'wechat'=>$wechat,
            'location'=>$location,
            'region'=>$regions,
            'lesson'=>$lessons,
            'bank'=>$bank,
            'bank_code'=>$bank_code,
            'description'=>$description,
            'skill'=>$skills,
            'photo'=>$photo,
            'frozen'=>$frozen,
            'delete'=>$delete,
            'region'=>$regions,
            'category'=>$categorys);

        $result = $this->save($id, $data);

        return $result;
    }

    public function unDeleteTeacher($id) {
        $data = array('delete'=>0);

        $result = $this->save($id, $data);

        return $result;
    }

    public function deleteTeacher($id) {
        $data = array('delete'=>1);

        $result = $this->save($id, $data);

        return $result;
    }

    public function unFrozenTeachar($id) {
        $data = array('frozen'=>0);

        $result = $this->save($id, $data);

        return $result;
    }

    public function frozenTeachar($id) {
        $data = array('frozen'=>1);

        $result = $this->save($id, $data);

        return $result;
    }

    public function getTeacher() {

    }

    public function getTeacherApplication($id) {
        $data = array('usertype'=>2);

        $result = $this->save($id, $data);

        return $result;
    }

    public function applyTeacher($id) {
        $data = array('usertype'=>2);

        $result = $this->save($id, $data);

        return $result;
    }
} 