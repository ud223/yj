<?php
namespace Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class Coupon extends AbstractDocument {
    /** @ODM\Int */
    protected $amount;

    /** @ODM\Int */
    protected $is_user = 0;

    /** @ODM\String */
    protected $use_date;
}