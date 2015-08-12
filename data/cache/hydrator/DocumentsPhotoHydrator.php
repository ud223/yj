<?php

namespace Angel\Document\Hydrator;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use Doctrine\ODM\MongoDB\Hydrator\HydratorInterface;
use Doctrine\ODM\MongoDB\UnitOfWork;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ODM. DO NOT EDIT THIS FILE.
 */
class DocumentsPhotoHydrator implements HydratorInterface
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
        if (isset($data['type'])) {
            $value = $data['type'];
            $return = (string) $value;
            $this->class->reflFields['type']->setValue($document, $return);
            $hydratedData['type'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['title'])) {
            $value = $data['title'];
            $return = (string) $value;
            $this->class->reflFields['title']->setValue($document, $return);
            $hydratedData['title'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['description'])) {
            $value = $data['description'];
            $return = (string) $value;
            $this->class->reflFields['description']->setValue($document, $return);
            $hydratedData['description'] = $return;
        }

        /** @ReferenceOne */
        if (isset($data['phototype'])) {
            $reference = $data['phototype'];
            if (isset($this->class->fieldMappings['phototype']['simple']) && $this->class->fieldMappings['phototype']['simple']) {
                $className = $this->class->fieldMappings['phototype']['targetDocument'];
                $mongoId = $reference;
            } else {
                $className = $this->dm->getClassNameFromDiscriminatorValue($this->class->fieldMappings['phototype'], $reference);
                $mongoId = $reference['$id'];
            }
            $targetMetadata = $this->dm->getClassMetadata($className);
            $id = $targetMetadata->getPHPIdentifierValue($mongoId);
            $return = $this->dm->getReference($className, $id);
            $this->class->reflFields['phototype']->setValue($document, $return);
            $hydratedData['phototype'] = $return;
        }

        /** @Field(type="boolean") */
        if (isset($data['thumbnail'])) {
            $value = $data['thumbnail'];
            $return = (bool) $value;
            $this->class->reflFields['thumbnail']->setValue($document, $return);
            $hydratedData['thumbnail'] = $return;
        }

        /** @ReferenceOne */
        if (isset($data['owner'])) {
            $reference = $data['owner'];
            if (isset($this->class->fieldMappings['owner']['simple']) && $this->class->fieldMappings['owner']['simple']) {
                $className = $this->class->fieldMappings['owner']['targetDocument'];
                $mongoId = $reference;
            } else {
                $className = $this->dm->getClassNameFromDiscriminatorValue($this->class->fieldMappings['owner'], $reference);
                $mongoId = $reference['$id'];
            }
            $targetMetadata = $this->dm->getClassMetadata($className);
            $id = $targetMetadata->getPHPIdentifierValue($mongoId);
            $return = $this->dm->getReference($className, $id);
            $this->class->reflFields['owner']->setValue($document, $return);
            $hydratedData['owner'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['status'])) {
            $value = $data['status'];
            $return = (string) $value;
            $this->class->reflFields['status']->setValue($document, $return);
            $hydratedData['status'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['scale'])) {
            $value = $data['scale'];
            $return = (string) $value;
            $this->class->reflFields['scale']->setValue($document, $return);
            $hydratedData['scale'] = $return;
        }

        /** @Field(type="int") */
        if (isset($data['photoclass'])) {
            $value = $data['photoclass'];
            $return = (int) $value;
            $this->class->reflFields['photoclass']->setValue($document, $return);
            $hydratedData['photoclass'] = $return;
        }

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