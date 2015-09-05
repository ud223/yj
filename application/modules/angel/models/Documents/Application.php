<?php

namespace Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class Application extends AbstractDocument {
    /** @ODM\ReferenceOne(targetDocument="\Documents\UserInfo") */
    protected $customer;
    //状态 1：申请 2：通过 3：拒绝
    /** @ODM\Int */
    protected $state = 1;
}