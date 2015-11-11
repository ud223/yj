<?php

class Angel_Model_Company extends Angel_Model_AbstractModel{

    protected $_document_class = '\Documents\Company';

    //
    //
    const FILETYPE_FUND_SPEC = 'ffs';

    //
    const FILETYPE_BUSINESS_LICENCE = 'fbl';

    //
    const FILETYPE_FUNDER_SPEC = 'ffus';

    //
    const FILETYPE_FUNDER_DECISION = 'ffd';

    //
    const FILETYPE_CREDIT_REPORTS = 'fcr';

    //
    const FILETYPE_PERSONAL_CREDIT_REPORTS = 'fpcr';

    //
    const FILETYPE_FINANCIAL_REPORT = 'ffr';

    //
    const FILETYPE_SUPPORT_FILES = 'fsf';

    // 公司LOGO
    const IMAGETYPE_LOGO = 'logo';

    // 公司图片
    const IMAGETYPE_IMAGE = 'image';

    /**
     * 根据id，获取company model
     * @param string $company_id
     * @return \Documents\Company
     */
    public function getCompanyById($company_id){
        $company = $this->_dm->createQueryBuilder($this->_document_class)
            ->field('id')->equals($company_id)
            ->getQuery()
            ->getSingleResult();

        return $company;
    }

    /**
     * 获取用户的创建的公司
     * @param string $user_id
     * @return Company document
     * @throws Angel_Exception_Company
     */
    public function getCompanyByUser($user_id){
        $company = $this->_dm->createQueryBuilder($this->_document_class)
            ->field('owner.$id')->equals(new MongoId($user_id))
            ->field('active_bln')->equals(true)
            ->getQuery()
            ->execute();

        return $company;
    }

    /**
     * 创建公司
     * @param \Documents\User $user 公司的创建者
     * @return \Documents\Company － 返回的是新创建的公司的对象
     * @throws \Angel_Exception_Company
     */
    public function createCompany(\Documents\User $user){
        $result = null;

        if($user->isStartup()){
            $company = new $this->_document_class();
            $company->owner = $user;
            $this->_dm->persist($company);
            $this->_dm->flush();

            $result = $company;
        }
        else{
            // 只有创业者才能创建公司
            throw new \Angel_Exception_Company(Angel_Exception_Company::ONLY_STARTUP_CAN_CREATE_COMPANY);
        }

        return $result;
    }

    /**
     * 上传了公司的logo，从tmp处copy到company logo目录，生成其resized version供将来裁剪使用，并修改company的logo field
     * @param type $company
     * @param type $image
     * @return boolean - when it is false, add profile image fails, when the image type is not correct, throw the exception. when it is ture, means success
     */
    public function addCompanyLogo(\Documents\Company $company, $image){
        $result = false;

        $imageService = $this->_container->get('image');
        if(!$imageService->isAcceptedImage($image)){
            throw new Angel_Exception_Common(Angel_Exception_Common::IMAGE_NOT_ACCEPTED);
        }
        else{
            $extension = $imageService->getImageTypeExtension($image);
            $utilService = $this->_container->get('util');
            $filename = $utilService->generateFilename($extension);
            $destination = $this->getImagePath(self::IMAGETYPE_LOGO, $filename);
            if(copy($image, $destination)){
                if($imageService->resizeImage($destination)){
                    $company->logo = $filename;
                    $this->_dm->persist($company);
                    $this->_dm->flush();
                    $result = true;
                }
            }
        }

        return $result;
    }

    /**
     * 裁剪用户上传的公司logo
     * @param string $orig_image - 被裁图片的路径
     * @param array $coord - array(x, y, w, h)
     * @return mixed
     */
    public function generateCompanyLogo($orig_image, $coord){
        $imageService = $this->_container->get('image');
        return $imageService->generateThumbnail($orig_image, $this->_bootstrap_options['size']['logo'], $coord);
    }

    /**
     * 获取某种size的company logo
     * @param string $image － 基本文件名称
     * @param int $version - 文件size
     * @return string
     */
    public function getCompanyLogo($image, $version){
        return $this->getImageByVersion(self::IMAGETYPE_LOGO, $image, $version);
    }

    /**
     * 上传了公司的图片，从tmp处copy到company logo目录，生成各种size的缩略图
     * @param \Documents\Company $company
     * @param String $image
     * @return \Documents\CompanyDoc - when it is false, add profile image fails, when the image type is not correct, throw the exception. when it is \CompanyDoc, means success
     */
    public function addCompanyImage(\Documents\Company $company, $image){
        $result = false;

        $imageService = $this->_container->get('image');
        if(!$imageService->isAcceptedImage($image)){
            throw new Angel_Exception_Common(Angel_Exception_Common::IMAGE_NOT_ACCEPTED);
        }
        else{
            $extension = $imageService->getImageTypeExtension($image);
            $utilService = $this->_container->get('util');
            $filename = $utilService->generateFilename($extension);
            $destination = $this->getImagePath(self::IMAGETYPE_IMAGE, $filename);
            if(copy($image, $destination)){
                if($imageService->resizeImage($destination)){
                    if($imageService->generateThumbnail($destination, $this->_bootstrap_options['size']['company_image'])){
                        $image_document = $company->addCompanyImage($destination);

                        $this->_dm->persist($company);
                        $this->_dm->flush();
                        $result = $image_document;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * 检测上传的文件类型是不是指定的
     */
    public function isValidDoctype($doctype){
        $result = false;
        $doctype = strtolower($doctype);

        if(in_array($doctype, array(self::FILETYPE_BUSINESS_LICENCE, self::FILETYPE_CREDIT_REPORTS, self::FILETYPE_PERSONAL_CREDIT_REPORTS, self::FILETYPE_FINANCIAL_REPORT, self::FILETYPE_FUNDER_DECISION, self::FILETYPE_FUNDER_SPEC, self::FILETYPE_FUND_SPEC, self::FILETYPE_SUPPORT_FILES))){
            $result = true;
        }

        return $result;
    }

    /**
     * 移除公司的一些图片
     * @param \Documents\Company $company
     * @param string $image_id
     */
    public function removeCompanyImage(\Documents\Company $company, $image_id){
        $result = $company->removeCompanyImage($image_id);
        $this->_dm->persist($company);
        $this->_dm->flush();
        return $result;
    }

    /**
     * 获取某size图片名字
     * @param string $name - image type, could be company logo or company image
     * @param string $image － 基本文件名称
     * @param int $version - 文件size
     * @return string
     */
    public function getImageByVersion($image_type, $image, $version){
        $imageService = $this->_container->get('image');
        return $imageService->generateImageFilename($this->getImagePath($image_type, $image), $version, false);
    }

    /**
     * 获取image的位置 (＊这个方法还需要根据environment不同做修改)
     * @param string $imagename
     * @return string
     */
    public function getImagePath($image_type, $imagename){
        $dir = ($image_type == self::IMAGETYPE_LOGO) ? $this->_bootstrap_options['image']['company_logo'] : $this->_bootstrap_options['image']['company_image'];
        return APPLICATION_PATH.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'public'.$dir.DIRECTORY_SEPARATOR.$imagename;
    }


    /**
     * 验证公司ID是否有效，这个方法算很多方法的 preValidation
     * @param string $company_id
     * @return company model
     * @throws Angel_Exception_Company
     */
    public function validateCompanyId($company_id){
        $company = $this->getCompanyById($company_id);
        if(!$company){
            throw new Angel_Exception_User(Angel_Exception_Company::COMPANY_NOT_FOUND);
        }

        return $company;
    }

    /**
     * 返回等待信息需验证的公司
     * @return zend paginator or query dataset
     */
    public function getAllCompanyInWaitTobeValidatedList($return_as_paginator = true){
        $query = $this->_dm->createQueryBuilder($this->_document_class)
            ->field('wait_tobe_validate')->equals(true)
            ->field('active_bln')->equals(true)
            ->sort('createdAt', 'asc');

        $result = null;
        if($return_as_paginator){
            $result = $this->paginator($query);
        }
        else{
            $result = $query->getQuery()->execute();
        }

        return $result;
    }

    /**
     * 审核拒绝公司信息认证
     * @param string $company_id
     * @param string $reason － 拒绝的原因
     * @return boolean - actually if no exception was thrown, it always return true
     * @throws Angel_Exception_Company
     * @throws Angel_Exception_Admin
     */
    public function refuseCompanyInfo($company_id, $reason){
        $company = $this->validateCompanyId($company_id);

        // 必须提供拒绝的原因
        if(empty($reason)){
            throw new Angel_Exception_Admin(Angel_Exception_Admin::REFUSE_COMPANY_INFO_REASON_REQUIRED);
        }

        $company->wait_tobe_validate = false;
        $company->addCompanyRefusedReason($reason);

        $this->_dm->persist($company);
        $this->_dm->flush();

        $params = array(
            'username' => $company->owner->username,
            'name' => $company->name,
            'reason' => $reason
        );

        Angel_Model_Email::sendEmail($this->_container->get('email'), Angel_Model_Email::EMAIL_COMPANY_INFO_REFUSED, $company->owner->email, $params);

        return true;
    }

    /**
     * 审核通过公司信息认证
     * @param string $company_id
     * @return boolean - actually if no exception was thrown, it always return true
     */
    public function acceptCompanyInfo($company_id){
        $company = $this->validateCompanyId($company_id);
        $company->validated_bln = true;
        $company->wait_tobe_validate = false;

        foreach($company->guarantor_candidate as $candidate) {
            $this->emailGuarantorCandidate($company, $candidate);
        }

        $this->_dm->persist($company);
        $this->_dm->flush();
        $params = array(
            'name' => $company->name,
            'owner' => $company->owner->username
        );
        Angel_Model_Email::sendEmail($this->_container->get('email'), Angel_Model_Email::EMAIL_COMPANY_INFO_ACCEPTED, $company->owner->email, $params);


        return true;
    }


    /**
     * 获得所有就绪的公司
     */
    public function getCompanyInReady($return_as_paginator = false){
        return $this->getCompanyInStatus($return_as_paginator, \Documents\Company::FUNDING_STATUS_READY);
    }

    private function getCompanyInStatus($return_as_paginator = false, $status) {
        $query = $this->_dm->createQueryBuilder($this->_document_class)
            ->field('funding_status')->equals($status)
            ->sort('funding_enddate', 'asc');

        $result = null;
        if($return_as_paginator){
            $result = $this->paginator($query);
        }
        else{
            $result = $query->getQuery()->execute();
        }

        return $result;
    }
}