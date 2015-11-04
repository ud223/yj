<?php

class Angel_Model_Customer extends Angel_Model_AbstractModel
{
    protected $_document_class = '\Documents\UserInfo';

    public function addCustomer($nickname, $sex, $openid, $headimgurl)
    {
//        $data = array('usertype' => 1,
//            'nickname'=>$nickname,
//            'sex'=>$sex,
//            'openid'=>$openid,
//            'headimgurl' => $headimgurl);
//
//        $result = $this->add($data);
//
//        return $result;
        $result = false;
        $customer = new $this->_document_class();

        $customer->nickname = $nickname;
        $customer->sex = $sex;
        $customer->openid = $openid;
        $customer->headimgurl = $headimgurl;

        try {
            $this->_dm->persist($customer);
            $this->_dm->flush();

            $result = $customer;
        } catch (Exception $e) {
            $this->_logger->info(__CLASS__, __FUNCTION__, $e->getMessage() . "\n" . $e->getTraceAsString());
        }

        return $result;
    }


    public function saveWinXinUser($id, $openid, $nickname, $headimgurl)
    {
        $data = array('openid' => $openid,
            'nickname' => $nickname,
//            'sex' => $sex,
            'headimgurl' => $headimgurl);

        $result = $this->save($id, $data);

        return $result;
    }

    public function saveHeadPic($id, $head_pic)
    {
        $data = array('head_pic' => $head_pic);

        $result = $this->save($id, $data);

        return $result;
    }

    public function saveApplyUser($id, $sex, $birthday, $code, $email, $wechat, $region, $category, $bank, $bank_code, $description, $location, $certificate, $photo)
    {
        $data = array('sex' => $sex,
            'birthday' => $birthday,
            'code' => $code,
            'email' => $email,
            'wechat' => $wechat,
            'region' => $region,
            'category' => $category,
            'bank' => $bank,
            'bank_code' => $bank_code,
            'location' => $location,
            'certificate' => $certificate,
            'photo' => $photo,
            'description' => $description);

        $result = $this->save($id, $data);

        return $result;
    }

    public function ModifyCustomer($id, $name, $birthday, $place, $educational, $certificate, $phone, $code, $email, $qq, $wechat, $location, $lessons, $bank, $bank_code, $description, $skills, $photo, $frozen, $delete, $categorys, $regions)
    {
        $data = array('usertype' => 2,
            'name' => $name,
            'birthday' => $birthday,
            'place' => $place,
            'educational' => $educational,
            'certificate' => $certificate,
            'phone' => $phone,
            'code' => $code,
            'email' => $email,
            'qq' => $qq,
            'wechat' => $wechat,
            'location' => $location,
            'region' => $regions,
            'lesson' => $lessons,
            'bank' => $bank,
            'bank_code' => $bank_code,
            'description' => $description,
            'skill' => $skills,
            'photo' => $photo,
            'frozen' => $frozen,
            'delete' => $delete,
            'region' => $regions,
            'category' => $categorys);

        $result = $this->save($id, $data);

        return $result;
    }

    public function applyTeacher($id, $name, $sex, $birthday, $place, $educational, $phone, $code, $email, $qq, $wechat, $location, $lessons, $bank, $bank_code, $description, $regions)
    {
        $data = array(
            'name' => $name,
            'sex' => $sex,
            'birthday' => $birthday,
            'place' => $place,
            'educational' => $educational,
            'phone' => $phone,
            'code' => $code,
            'email' => $email,
            'qq' => $qq,
            'wechat' => $wechat,
            'location' => $location,
            'region' => $regions,
            'lesson' => $lessons,
            'bank' => $bank,
            'bank_code' => $bank_code,
            'description' => $description);

        $result = $this->save($id, $data);

        return $result;
    }

    public function unDeleteCustomer($id)
    {
        $data = array('delete' => 0);

        $result = $this->save($id, $data);

        return $result;
    }

    public function deleteCustomer($id)
    {
        $data = array('delete' => 1);

        $result = $this->save($id, $data);

        return $result;
    }

    public function unFrozenCustomer($id)
    {
        $data = array('frozen' => 0);

        $result = $this->save($id, $data);

        return $result;
    }

    public function frozenCustomer($id)
    {
        $data = array('frozen' => 1);

        $result = $this->save($id, $data);

        return $result;
    }

    public function getUserByOpenId($openid)
    {
        $query = $this->_dm->createQueryBuilder($this->_document_class)->field('openid')->equals($openid)->sort("created_at", -1);

        $result = $query->getQuery();

        return $result;
    }

    public function saveCertificate($id, $certificate)
    {
        $data = array('certificate' => $certificate);

        $result = $this->save($id, $data);

        return $result;
    }

    public function savePhoto($id, $photo)
    {
        $data = array('photo' => $photo);

        $result = $this->save($id, $data);

        return $result;
    }


    public function saveCoupon($id, $coupons)
    {
        $data = array('coupon' => $coupons);

        $result = $this->save($id, $data);

        return $result;
    }
}