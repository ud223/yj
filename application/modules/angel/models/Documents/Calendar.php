<?php
namespace Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class Calendar extends AbstractDocument {
    /** @ODM\String */
    protected $busy_date;

    /** @ODM\ReferenceOne(targetDocument="\Documents\UserInfo") */
    protected $teacher;
} 