<?php

namespace Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class Lesson extends AbstractDocument {
    /** @ODM\String */
    protected $name;

    /** @ODM\String */
    protected $description;

    /** @ODM\ReferenceMany(targetDocument="\Documents\Photo") */
    protected $photo = array();
}