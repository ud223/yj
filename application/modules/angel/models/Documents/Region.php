<?php

namespace Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class Region extends AbstractDocument {
    /** @ODM\String */
    protected $name;

    /** @ODM\String */
    protected $coordinate;
}