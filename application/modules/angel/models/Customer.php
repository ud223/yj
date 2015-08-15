<?php

class Angel_Model_Customer extends Angel_Model_AbstractModel {
    protected $_document_class = '\Documents\UserInfo';

    public function addCustomer($nickname, $sex, $openid) {
        $data = array('usertype' => 1,
            'nickname'=>$nickname,
            'sex'=>$sex,
            'openid'=>$openid);

        $result = $this->add($data);

        return $result;
    }

    public function ModifyCustomer($id, $name, $birthday, $place, $educational, $certificate, $phone, $code, $email, $qq, $wechat, $location, $lessons, $bank, $bank_code, $description, $skills, $photo, $frozen, $delete, $categorys, $regions) {
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

    public function unDeleteCustomer($id) {
        $data = array('delete'=>0);

        $result = $this->save($id, $data);

        return $result;
    }

    public function deleteCustomer($id) {
        $data = array('delete'=>1);

        $result = $this->save($id, $data);

        return $result;
    }

    public function unFrozenCustomer($id) {
        $data = array('frozen'=>0);

        $result = $this->save($id, $data);

        return $result;
    }

    public function frozenCustomer($id) {
        $data = array('frozen'=>1);

        $result = $this->save($id, $data);

        return $result;
    }
} 