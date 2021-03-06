<?php

namespace Angel\Document\Hydrator;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use Doctrine\ODM\MongoDB\Hydrator\HydratorInterface;
use Doctrine\ODM\MongoDB\UnitOfWork;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ODM. DO NOT EDIT THIS FILE.
 */
class DocumentsLessonHydrator implements HydratorInterface
{
    private $dm;
    private $unitOfWork;
    private $class;

    public function __construct(DocumentManager $dm, UnitOfWork $uow, ClassMetadata $class)
    {
        $this->dm = $dm;
        $this->unitOfWork = $uow;
        $this->class = $class;
    }

    public function hydrate($document, $data, array $hints = array())
    {
        $hydratedData = array();

        /** @Field(type="string") */
        if (isset($data['name'])) {
            $value = $data['name'];
            $return = (string) $value;
            $this->class->reflFields['name']->setValue($document, $return);
            $hydratedData['name'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['description'])) {
            $value = $data['description'];
            $return = (string) $value;
            $this->class->reflFields['description']->setValue($document, $return);
            $hydratedData['description'] = $return;
        }

        /** @Many */
        $mongoData = isset($data['photo']) ? $data['photo'] : null;
        $return = new \Doctrine\ODM\MongoDB\PersistentCollection(new \Doctrine\Common\Collections\ArrayCollection(), $this->dm, $this->unitOfWork, '$');
        $return->setHints($hints);
        $return->setOwner($document, $this->class->fieldMappings['photo']);
        $return->setInitialized(false);
        if ($mongoData) {
            $return->setMongoData($mongoData);
        }
        $this->class->reflFields['photo']->setValue($document, $return);
        $hydratedData['photo'] = $return;

        /** @Field(type="id") */
        if (isset($data['_id'])) {
            $value = $data['_id'];
            $return = (string) $value;
            $this->class->reflFields['id']->setValue($document, $return);
            $hydratedData['id'] = $return;
        }

        /** @Field(type="date") */
        if (isset($data['created_at'])) {
            $value = $data['created_at'];
            if ($value instanceof \MongoDate) { $date = new \DateTime(); $date->setTimestamp($value->sec); $return = $date; } else { $return = new \DateTime($value); }
            $this->class->reflFields['created_at']->setValue($document, clone $return);
            $hydratedData['created_at'] = $return;
        }

        /** @Field(type="date") */
        if (isset($data['updated_at'])) {
            $value = $data['updated_at'];
            if ($value instanceof \MongoDate) { $date = new \DateTime(); $date->setTimestamp($value->sec); $return = $date; } else { $return = new \DateTime($value); }
            $this->class->reflFields['updated_at']->setValue($document, clone $return);
            $hydratedData['updated_at'] = $return;
        }
        return $hydratedData;
    }
}