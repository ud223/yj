<?php

class Angel_Model_Order extends Angel_Model_AbstractModel {
    protected $_document_class = '\Documents\Order';

    //新增课程信息
    public function addOrder($rundate, $hour, $customer, $teacher, $amount) {
        $data = array('rundate' => $rundate,
            'hour'=>$hour,
            'customer' => $customer,
            'teacher'=>$teacher,
            'amount'=>$amount,
            'state'=>1);

        $result = $this->add($data);

        return $result;
    }

    //保存课程信息
    public function saveOrder($id, $rundate, $hour, $customer, $teacher, $state, $user_score, $user_appraise, $teacher_score, $teacher_appraise, $amount) {
        $data = array('rundate' => $rundate,
            'hour'=>$hour,
            'customer' => $customer,
            'teacher'=>$teacher,
            'state'=>$state,
            'amount'=>$amount,
            'user_score'=>$user_score,
            'user_appraise'=>$user_appraise,
            'teacher_score'=>$teacher_score,
            'teacher_appraise'=>$teacher_appraise);

        $result = $this->save($id, $data);

        return $result;
    }
}
