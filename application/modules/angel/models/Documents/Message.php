<?php

namespace Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class Message extends AbstractDocument {
    /** @ODM\String */
    protected $name;

    /** @ODM\String */
    protected $content;

    /** @ODM\ReferenceOne(targetDocument="\Documents\UserInfo") */
    protected $toUser;

    /** @ODM\ReferenceOne(targetDocument="\Documents\UserInfo") */
    protected $fromUser;

    /** @ODM\String */
    protected $url;

    /** @ODM\Int */
    protected $msg_type;

    /** @ODM\Int */
    protected $is_look = 0;
}
