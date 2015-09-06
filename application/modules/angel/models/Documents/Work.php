<?php
namespace Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class Work extends AbstractDocument {
    /** @ODM\Int */
    protected $hour;
}