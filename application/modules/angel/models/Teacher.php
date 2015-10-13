<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/8/10
 * Time: 14:02
 */

class Angel_Model_Teacher extends Angel_Model_AbstractModel {
    protected $_document_class = '\Documents\UserInfo';

    public function addTeacher($headPic, $name, $sex, $birthday, $place, $educational, $certificate, $phone, $code, $email, $qq, $years, $wechat, $location, $lessons, $bank, $bank_code, $description, $skills, $photo, $categorys, $regions, $experience, $price, $serial_number) {
        $data = array('usertype' => 2,
            'name'=>$name,
            'head_pic'=>$headPic,
            'sex'=>$sex,
            'birthday'=>$birthday,
            'place'=>$place,
            'educational'=>$educational,
            'certificate'=>$certificate,
            'phone'=>$phone,
            'code'=>$code,
            'email'=>$email,
            'qq'=>$qq,
            'years'=>$years,
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
            'experience'=>$experience,
            'price'=>$price,
            'serial_number'=>$serial_number,
            'category'=>$categorys);

        $result = $this->add($data);

        return $result;
    }

    public function ModifyTeacher($id, $headPic, $name, $sex, $birthday, $place, $educational, $certificate, $phone, $code, $email, $qq, $years, $wechat, $location, $lessons, $bank, $bank_code, $description, $skills, $photo, $frozen, $delete, $categorys, $regions, $experience, $price, $serial_number) {
        $data = array('usertype' => 2,
            'name'=>$name,
            'head_pic'=>$headPic,
            'sex'=>$sex,
            'birthday'=>$birthday,
            'place'=>$place,
            'educational'=>$educational,
            'certificate'=>$certificate,
            'phone'=>$phone,
            'code'=>$code,
            'email'=>$email,
            'qq'=>$qq,
            'years'=>$years,
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
            'experience'=>$experience,
            'price'=>$price,
            'serial_number'=>$serial_number,
            'category'=>$categorys);

        $result = $this->save($id, $data);

        return $result;
    }

    public function returnToCustomer($id) {
        $data = array('usertype' => 1);

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

    public  function initTeacherCount($id) {
        $data = array("teacher_count"=>0);

        $result = $this->save($id, $data);

        return $result;
    }

    public function getTeacher() {

    }

    public function setTeacherRanage($id, $cell, $range, $lat, $lng) {
        $data = array("cell"=>$cell, "range"=>$range, "lat"=>$lat, "lng"=>$lng);

        $result = $this->save($id, $data);

        return $result;
    }

    public function getTeacherApplication($id) {
        $data = array('usertype'=>2);

        $result = $this->save($id, $data);

        return $result;
    }

    public function modifyLesson($id, $lesson) {
        $data = array('lesson'=>$lesson);

        $result = $this->save($id, $data);

        return $result;
    }

    public function submitRating($id, $teacher_score) {
        $data = array('teacher_score'=>$teacher_score);

        $result = $this->save($id, $data);

        return $result;
    }

    public function applyTeacher($id) {
        $data = array('usertype'=>2);

        $result = $this->save($id, $data);

        return $result;
    }

    public function updateMoney($id, $amount, $use_amount, $teacher_count) {
        $data = array('amount'=>$amount, 'use_amount'=>$use_amount, 'teacher_count'=>$teacher_count);

        $result = $this->save($id, $data);

        return $result;
    }
} 