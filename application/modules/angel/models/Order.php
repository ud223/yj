<?php

class Angel_Model_Order extends Angel_Model_AbstractModel
{
    protected $_document_class = '\Documents\Order';

    //新增课程信息
    public function addOrder($rundate, $time, $hour, $customer, $teacher, $price, $amount) {
        $result = false;
        $order = new $this->_document_class();

        $order->rundate = $rundate;
        $order->time = $time;
        $order->hour = $hour;
        $order->customer = $customer;
        $order->teacher = $teacher;
        $order->price = $price;
        $order->amount = $amount;

        try {
            $this->_dm->persist($order);
            $this->_dm->flush();

            $result = $order->id;
        } catch (Exception $e) {
            $this->_logger->info(__CLASS__, __FUNCTION__, $e->getMessage() . "\n" . $e->getTraceAsString());
        }

        return $result;
    }

    //保存课程信息
    public function saveOrder($id, $rundate, $time, $hour, $customer, $teacher, $state, $user_score, $user_appraise, $teacher_score, $teacher_appraise, $price, $amount, $pay_amount, $customer_name, $phone, $address, $address_detail) {
        $data = array('rundate' => $rundate,
            'time' => $time,
            'hour' => $hour,
            'customer' => $customer,
            'customer_name' => $customer_name,
            'phone' => $phone,
            'address' => $address,
            'address_detail' => $address_detail,
            'teacher' => $teacher,
            'state' => $state,
            'price' => $price,
            'amount' => $amount,
            'pay_amount' => $pay_amount,
            'user_score' => $user_score,
            'user_appraise' => $user_appraise,
            'teacher_score' => $teacher_score,
            'teacher_appraise' => $teacher_appraise);

        $result = $this->save($id, $data);

        return $result;
    }

    public function uploadPos($id, $lat, $lng) {
        $data = array('lat' => $lat,
            'lng' => $lng);

        $result = $this->save($id, $data);

        return $result;
    }

    public function updateState($id, $state) {
        $data = array('state' => $state);

        $result = $this->save($id, $data);

        return $result;
    }

    public function saveCoupon($id, $coupon) {
        $data = array('coupon' => $coupon);

        $result = $this->save($id, $data);

        return $result;
    }

    public function submitRating($id, $time_score, $content_score, $way_score, $teacher_score, $teacher_appraise) {
        $data = array('time_score'=>$time_score, 'content_score'=>$content_score, 'way_score'=>$way_score, 'teacher_score'=>$teacher_score, 'teacher_appraise'=>$teacher_appraise);

        $result = $this->save($id, $data);

        return $result;
    }

    public function removeOrder($id) {
        $data = array('delete' => 1);

        $result = $this->save($id, $data);

        return $result;
    }

//    public function getAvailabilityOrder($rundate, $customer_id) {
//        $query = $this->_dm->createQueryBuilder($this->_document_class);
//
//        $result = null;
//        $result = $query->getQuery()->;
//
//        return $result;
//    }
}
