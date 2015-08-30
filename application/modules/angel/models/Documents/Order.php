<?php

namespace Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class Order extends AbstractDocument {
    /** @ODM\String */
    protected $rundate;

    /** @ODM\String */
    protected $time;

    /** @ODM\Int */
    protected $hour;

    /** @ODM\String */
    protected $customer_name;

    /** @ODM\String */
    protected $address;

    /** @ODM\String */
    protected $phone;

    /** @ODM\ReferenceOne(targetDocument="\Documents\UserInfo") */
    protected $customer;

    /** @ODM\ReferenceOne(targetDocument="\Documents\UserInfo") */
    protected $teacher;

    //0：创建订单 10：下单(最终修改日期，时间段，等待支付) 20： 已接单（已支付） 30：授课中(老师点击开始授课) 40：评分(授课结束等待评分) 50：完成（评分完成，结束）
    /** @ODM\Int */
    protected $state = 0;

    /** @ODM\Int */
    protected $user_score;

    //用户评价
    /** @ODM\String */
    protected $user_appraise;

    /** @ODM\Int */
    protected $teacher_score;

    //老师评价
    /** @ODM\String */
    protected $teacher_appraise;

    //订单金额
    /** @ODM\String */
    protected $price;

    //订单金额
    /** @ODM\String */
    protected $amount;

    //实付金额
    /** @ODM\String */
    protected $pay_amount;

    /** @ODM\Int */
    protected $delete = 0;
}