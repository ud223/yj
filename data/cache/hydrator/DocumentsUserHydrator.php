<?php

namespace Angel\Document\Hydrator;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use Doctrine\ODM\MongoDB\Hydrator\HydratorInterface;
use Doctrine\ODM\MongoDB\UnitOfWork;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ODM. DO NOT EDIT THIS FILE.
 */
class DocumentsUserHydrator implements HydratorInterface
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
        if (isset($data['email'])) {
            $value = $data['email'];
            $return = (string) $value;
            $this->class->reflFields['email']->setValue($document, $return);
            $hydratedData['email'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['user_type'])) {
            $value = $data['user_type'];
            $return = (string) $value;
            $this->class->reflFields['user_type']->setValue($document, $return);
            $hydratedData['user_type'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['username'])) {
            $value = $data['username'];
            $return = (string) $value;
            $this->class->reflFields['username']->setValue($document, $return);
            $hydratedData['username'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['name'])) {
            $value = $data['name'];
            $return = (string) $value;
            $this->class->reflFields['name']->setValue($document, $return);
            $hydratedData['name'] = $return;
        }

        /** @Field(type="int") */
        if (isset($data['author'])) {
            $value = $data['author'];
            $return = (int) $value;
            $this->class->reflFields['author']->setValue($document, $return);
            $hydratedData['author'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['identity_type'])) {
            $value = $data['identity_type'];
            $return = (string) $value;
            $this->class->reflFields['identity_type']->setValue($document, $return);
            $hydratedData['identity_type'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['identity_id'])) {
            $value = $data['identity_id'];
            $return = (string) $value;
            $this->class->reflFields['identity_id']->setValue($document, $return);
            $hydratedData['identity_id'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['password'])) {
            $value = $data['password'];
            $return = (string) $value;
            $this->class->reflFields['password']->setValue($document, $return);
            $hydratedData['password'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['password_src'])) {
            $value = $data['password_src'];
            $return = (string) $value;
            $this->class->reflFields['password_src']->setValue($document, $return);
            $hydratedData['password_src'] = $return;
        }

        /** @Field(type="int") */
        if (isset($data['age'])) {
            $value = $data['age'];
            $return = (int) $value;
            $this->class->reflFields['age']->setValue($document, $return);
            $hydratedData['age'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['gender'])) {
            $value = $data['gender'];
            $return = (string) $value;
            $this->class->reflFields['gender']->setValue($document, $return);
            $hydratedData['gender'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['salt'])) {
            $value = $data['salt'];
            $return = (string) $value;
            $this->class->reflFields['salt']->setValue($document, $return);
            $hydratedData['salt'] = $return;
        }

        /** @Field(type="boolean") */
        if (isset($data['active_bln'])) {
            $value = $data['active_bln'];
            $return = (bool) $value;
            $this->class->reflFields['active_bln']->setValue($document, $return);
            $hydratedData['active_bln'] = $return;
        }

        /** @Field(type="boolean") */
        if (isset($data['email_validated_bln'])) {
            $value = $data['email_validated_bln'];
            $return = (bool) $value;
            $this->class->reflFields['email_validated_bln']->setValue($document, $return);
            $hydratedData['email_validated_bln'] = $return;
        }

        /** @Field(type="boolean") */
        if (isset($data['validated_bln'])) {
            $value = $data['validated_bln'];
            $return = (bool) $value;
            $this->class->reflFields['validated_bln']->setValue($document, $return);
            $hydratedData['validated_bln'] = $return;
        }

        /** @Field(type="boolean") */
        if (isset($data['admin_bln'])) {
            $value = $data['admin_bln'];
            $return = (bool) $value;
            $this->class->reflFields['admin_bln']->setValue($document, $return);
            $hydratedData['admin_bln'] = $return;
        }

        /** @Field(type="boolean") */
        if (isset($data['wait_tobe_validate'])) {
            $value = $data['wait_tobe_validate'];
            $return = (bool) $value;
            $this->class->reflFields['wait_tobe_validate']->setValue($document, $return);
            $hydratedData['wait_tobe_validate'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['profile_image'])) {
            $value = $data['profile_image'];
            $return = (string) $value;
            $this->class->reflFields['profile_image']->setValue($document, $return);
            $hydratedData['profile_image'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['phone'])) {
            $value = $data['phone'];
            $return = (string) $value;
            $this->class->reflFields['phone']->setValue($document, $return);
            $hydratedData['phone'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['address'])) {
            $value = $data['address'];
            $return = (string) $value;
            $this->class->reflFields['address']->setValue($document, $return);
            $hydratedData['address'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['ip'])) {
            $value = $data['ip'];
            $return = (string) $value;
            $this->class->reflFields['ip']->setValue($document, $return);
            $hydratedData['ip'] = $return;
        }

        /** @Field(type="date") */
        if (isset($data['last_login'])) {
            $value = $data['last_login'];
            if ($value instanceof \MongoDate) { $date = new \DateTime(); $date->setTimestamp($value->sec); $return = $date; } else { $return = new \DateTime($value); }
            $this->class->reflFields['last_login']->setValue($document, clone $return);
            $hydratedData['last_login'] = $return;
        }

        /** @EmbedOne */
        if (isset($data['identity_front_doc'])) {
            $embeddedDocument = $data['identity_front_doc'];
            $className = $this->dm->getClassNameFromDiscriminatorValue($this->class->fieldMappings['identity_front_doc'], $embeddedDocument);
            $embeddedMetadata = $this->dm->getClassMetadata($className);
            $return = $embeddedMetadata->newInstance();

            $embeddedData = $this->dm->getHydratorFactory()->hydrate($return, $embeddedDocument, $hints);
            $this->unitOfWork->registerManaged($return, null, $embeddedData);
            $this->unitOfWork->setParentAssociation($return, $this->class->fieldMappings['identity_front_doc'], $document, 'identity_front_doc');

            $this->class->reflFields['identity_front_doc']->setValue($document, $return);
            $hydratedData['identity_front_doc'] = $return;
        }

        /** @EmbedOne */
        if (isset($data['identity_back_doc'])) {
            $embeddedDocument = $data['identity_back_doc'];
            $className = $this->dm->getClassNameFromDiscriminatorValue($this->class->fieldMappings['identity_back_doc'], $embeddedDocument);
            $embeddedMetadata = $this->dm->getClassMetadata($className);
            $return = $embeddedMetadata->newInstance();

            $embeddedData = $this->dm->getHydratorFactory()->hydrate($return, $embeddedDocument, $hints);
            $this->unitOfWork->registerManaged($return, null, $embeddedData);
            $this->unitOfWork->setParentAssociation($return, $this->class->fieldMappings['identity_back_doc'], $document, 'identity_back_doc');

            $this->class->reflFields['identity_back_doc']->setValue($document, $return);
            $hydratedData['identity_back_doc'] = $return;
        }

        /** @Many */
        $mongoData = isset($data['identity_refused_reason']) ? $data['identity_refused_reason'] : null;
        $return = new \Doctrine\ODM\MongoDB\PersistentCollection(new \Doctrine\Common\Collections\ArrayCollection(), $this->dm, $this->unitOfWork, '$');
        $return->setHints($hints);
        $return->setOwner($document, $this->class->fieldMappings['identity_refused_reason']);
        $return->setInitialized(false);
        if ($mongoData) {
            $return->setMongoData($mongoData);
        }
        $this->class->reflFields['identity_refused_reason']->setValue($document, $return);
        $hydratedData['identity_refused_reason'] = $return;

        /** @Many */
        $mongoData = isset($data['invested_companies']) ? $data['invested_companies'] : null;
        $return = new \Doctrine\ODM\MongoDB\PersistentCollection(new \Doctrine\Common\Collections\ArrayCollection(), $this->dm, $this->unitOfWork, '$');
        $return->setHints($hints);
        $return->setOwner($document, $this->class->fieldMappings['invested_companies']);
        $return->setInitialized(false);
        if ($mongoData) {
            $return->setMongoData($mongoData);
        }
        $this->class->reflFields['invested_companies']->setValue($document, $return);
        $hydratedData['invested_companies'] = $return;

        /** @Many */
        $mongoData = isset($data['category']) ? $data['category'] : null;
        $return = new \Doctrine\ODM\MongoDB\PersistentCollection(new \Doctrine\Common\Collections\ArrayCollection(), $this->dm, $this->unitOfWork, '$');
        $return->setHints($hints);
        $return->setOwner($document, $this->class->fieldMappings['category']);
        $return->setInitialized(false);
        if ($mongoData) {
            $return->setMongoData($mongoData);
        }
        $this->class->reflFields['category']->setValue($document, $return);
        $hydratedData['category'] = $return;

        /** @Field(type="int") */
        if (isset($data['count'])) {
            $value = $data['count'];
            $return = (int) $value;
            $this->class->reflFields['count']->setValue($document, $return);
            $hydratedData['count'] = $return;
        }

        /** @Field(type="int") */
        if (isset($data['like'])) {
            $value = $data['like'];
            $return = (int) $value;
            $this->class->reflFields['like']->setValue($document, $return);
            $hydratedData['like'] = $return;
        }

        /** @Field(type="hash") */
        if (isset($data['attribute'])) {
            $value = $data['attribute'];
            $return = $value;
            $this->class->reflFields['attribute']->setValue($document, $return);
            $hydratedData['attribute'] = $return;
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