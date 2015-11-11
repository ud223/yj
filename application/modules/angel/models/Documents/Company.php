<?php
namespace Documents;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
/** @ODM\Document */
class Company extends AbstractDocument{

    const FUNDING_STATUS_READY = 'ready';   //
    const FUNDING_STATUS_ING = 'ing';       //
    const FUNDING_STATUS_END = 'end';       //

    /** @ODM\ReferenceOne(targetDocument="\Documents\User") */
    protected $owner;
    /** @ODM\String */
    protected $name;    // 公司名称

    /** @ODM\Boolean */
    protected $active_bln = true;

    /** @ODM\String */
    protected $logo;    // 公司logo

    /** @ODM\EmbedMany(targetDocument="\Documents\CompanyDoc") */
    protected $images = array();    // 公司图片

    /** @ODM\String */
    protected $company_video; //
    /** @ODM\String */
    protected $additional_rights; //

    /** @ODM\String */
    protected $brief_descr; //

    /** @ODM\String */
    protected $highlight; //

    /** @ODM\String */
    protected $profit_model; //

    /** @ODM\String */
    protected $advantage; //

    /** @ODM\String */
    protected $descr; //

    /** @ODM\String */
    protected $history; //

    /** @ODM\String */
    protected $representative;  //

    /** @ODM\String */
    protected $founded_date;    //

    /** @ODM\Int */
    protected $size;   //

    /** @ODM\String */
    protected $website;     //

    /** @ODM\String */
    protected $phone;   //

    /** @ODM\String */
    protected $fax;   //

    /** @ODM\String */
    protected $address;     //
    /** @ODM\Int */
    protected $expected_funding_amt;    //
    /** @ODM\Int */
    protected $funded_amt;    //

    /** @ODM\Int */
    protected $funding_period; //

    /** @ODM\Int */
    protected $funding_stock_percent; //
    /** @ODM\Int */
    protected $funding_upper_limit; //

    /** @ODM\Int */
    protected $funding_mini_unit; //

    /** @ODM\EmbedMany(targetDocument="\Documents\CompanyDoc") */
    protected $funding_specification = array(); //

    /** @ODM\EmbedOne(targetDocument="\Documents\CompanyDoc") */
    protected $business_licence; // 营业执照
    /** @ODM\EmbedOne(targetDocument="\Documents\CompanyDoc") */
    protected $funder_specification; //

    /** @ODM\EmbedOne(targetDocument="\Documents\CompanyDoc") */
    protected $funder_decision; //

    /** @ODM\EmbedMany(targetDocument="\Documents\CompanyDoc") */
    protected $credit_reports = array(); //

    /** @ODM\EmbedMany(targetDocument="\Documents\CompanyDoc") */
    protected $personal_credit_reports = array(); //

    /** @ODM\EmbedMany(targetDocument="\Documents\CompanyDoc") */
    protected $financial_reports = array(); //

    /** @ODM\EmbedMany(targetDocument="\Documents\CompanyDoc") */
    protected $support_files = array(); //

    /** @ODM\String */
    protected $startup_introduction_video; //

    /** @ODM\String */
    protected $startup_introduction;   //

    /** @ODM\EmbedMany(targetDocument="\Documents\Candidate") */
    protected $guarantor_candidate = array();

    /** @ODM\EmbedMany(targetDocument="\Documents\Candidate") */
    protected $refused_guarantor_candidate = array();

    /** @ODM\Boolean */
    protected $wait_tobe_validate;  // 是否在等待信息被验证
    /** @ODM\EmbedMany(targetDocument="\Documents\Reason") */
    protected $validation_refused_reason = array(); //

    /** @ODM\Boolean */
    protected $validated_bln;   //

    /** @ODM\Date */
    protected $validated_date;  //
    /** @ODM\String */
    protected $funding_status;  //

    /** @ODM\Date */
    protected $funding_startdate; //
    /** @ODM\Date */
    protected $funding_enddate; //

    /** @ODM\EmbedMany(targetDocument="\Documents\CompanyInvestor") */
    protected $company_investors = array(); //

    public function getRequiredFields(){
        return array('name'=>'公司名称', 'logo'=>'公司LOGO', 'images'=>'公司图片');
    }

    /**
     * 添加公司图片
     */
    public function addCompanyImage($image_filename){
        $doc = new \Documents\CompanyDoc();
        $doc->angelname = $image_filename;

        $this->images[] = $doc;

        return $doc;
    }

    /**
     * 删除公司图片
     * @param string $image_id
     * @return boolean
     */
    public function removeCompanyImage($image_id){
        return $this->removeCompanyDoc($this->images, $image_id);
    }

    /**
     * 添加营业执照
     * @param string $filename
     * @param string $angelname
     * @return \Documents\CompanyDoc
     */
    public function addBusinessLicenceDoc($filename, $angelname){
        $document = new \Documents\CompanyDoc();

        $document->filename = $filename;
        $document->angelname = $angelname;

        $this->business_licence = $document;

        return $document;
    }

    /**
     * 移除营业执照
     * @param type $document_id
     */
    public function removeBusinessLicenceDoc($document_id){
        return $this->removeCompanyDoc($this->business_licence, $document_id);
    }

    /**
     * 添加信用报告
     * @param string $filename
     * @param string $angelname
     * @return \Documents\CompanyDoc
     */
    public function addCreditReportsDoc($filename, $angelname){
        $document = new \Documents\CompanyDoc();

        $document->filename = $filename;
        $document->angelname = $angelname;

        $this->credit_reports[] = $document;

        return $document;
    }

    /**
     * 移除信用报告
     * @param string $document_id
     * @return boolean
     */
    public function removeCreditReportsDoc($document_id){
        return $this->removeCompanyDoc($this->credit_reports, $document_id);
    }

    /**
     * 获得图片，需要过滤已经删除的文档
     * @return array
     */
    public function getImages(){
        return $this->getCompanyDoc($this->images);
    }

    /**
     * 获得投资需求，需要过滤已经删除的文档
     * @return array
     */
    public function getFunding_specification(){
        return $this->getCompanyDoc($this->funding_specification);
    }


    /**
     * 内部公共方法，过滤删除的文档
     * @param array $docs
     * @return array
     */
    private function getCompanyDoc($docs){
        $arr = array();

        foreach($docs as $doc){
            if($doc->active_bln){
                $arr[] = $doc;
            }
        }
        return $arr;
    }

}