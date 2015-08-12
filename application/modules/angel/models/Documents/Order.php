<?php

namespace Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class Order extends AbstractDocument {
    /** @ODM\String */
    protected $rundate;

    /** @ODM\Int */
    protected $hour;

    /** @ODM\ReferenceOne(targetDocument="\Documents\UserInfo") */
    protected $customer;

    /** @ODM\ReferenceOne(targetDocument="\Documents\UserInfo") */
    protected $teacher;

    //1：下单 2： 已接单 3：授课中 4：评分 5：完成
    /** @ODM\Int */
    protected $state;

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
    protected $amount;
}