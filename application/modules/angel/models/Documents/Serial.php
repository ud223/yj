<?php
namespace Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class Serial extends AbstractDocument {
    /** @ODM\Int */
    protected $max_num;

    /** @ODM\String */
    protected $prefix;
} 