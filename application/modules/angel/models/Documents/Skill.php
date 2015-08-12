<?php
namespace Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class Skill extends AbstractDocument {
    /** @ODM\String */
    protected $name;

    /** @ODM\ReferenceMany(targetDocument="\Documents\Photo") */
    protected $photo = array();

    /** @ODM\String */
    protected $value;

    //如果1位文本属性2为图片属性
    /** @ODM\Int */
    protected $type;
} 