<?php

class Angel_Model_Coupon extends Angel_Model_AbstractModel
{
    protected $_document_class = '\Documents\Coupon';

    //新增课程信息
    public function addCoupon($amount) {
        $result = false;
        $coupon = new $this->_document_class();

        $class = 1;

        if ($amount > 50) {
            $class = 2;
        }

        $coupon->amount = $amount;
        $coupon->is_user = $class;

        try {
            $this->_dm->persist($coupon);
            $this->_dm->flush();

            $result = $coupon->id;
        } catch (Exception $e) {
            $this->_logger->info(__CLASS__, __FUNCTION__, $e->getMessage() . "\n" . $e->getTraceAsString());
        }

        return $result;
    }

    //保存
//    public function saveCoupon($id, $amount) {
//        $data = array('amount' => $amount, 'is_user'=>$class);
//
//        $result = $this->save($id, $data);
//
//        return $result;
//    }

    public function usedCoupon($id, $use_date) {
        $data = array('is_user'=>3, 'use_date'=>$use_date);

        $result = $this->save($id, $data);

        return $result;
    }
}
