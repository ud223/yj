<?php

class Angel_ManageController extends Angel_Controller_Action {
    protected $login_not_required = array(
        'login',
        'register',
        'logout'
    );
    protected $SEPARATOR = ';';

    public function init() {
        parent::init();

        $this->_helper->layout->setLayout('manage');
    }

    public function indexAction() {
        
    }

    /*******************************************
     * 用户处理部分
     *
     * ****************************************/
    public function registerAction() {
        $this->userRegister('manage-login', "注册成为管理员", "admin");
        
        $this->view->ismanage = true;
    }

    public function logoutAction() {
        $this->userLogout('manage-login');
    }

    public function loginAction() {
        $this->userLogin('manage-index', "管理员登录");
    }

    /*******************************************************
     * 教师action
     *
     * *****************************************************/
    public function teacherCreateAction() {
        $teacherModel = $this->getModel('teacher');
        $lessonModel = $this->getModel('lesson');
        $skillModel = $this->getModel('skill');
        $categoryModel = $this->getModel('category');
        $regionModel = $this->getModel('region');

        if ($this->request->isPost()) {
            $headPic = "";
//            var_dump($_FILES['upload-head-pic']); exit;
            if(is_uploaded_file($_FILES['upload-head-pic']['tmp_name'])) {

                $tmp_headPic_filename = '/tmp/'. $_FILES['upload-head-pic']['name'];
                $tmp_headPic_path = $_FILES['upload-head-pic']['tmp_name'];

                move_uploaded_file($tmp_headPic_path, $tmp_headPic_filename);

                $img_head_pic = file_get_contents($tmp_headPic_filename);
                $enHeadPic = base64_encode($img_head_pic);
//                exit($enHeadPic);
                $headPic = $this->saveFile($enHeadPic);

                if ($headPic === 0) {
                    $this->_redirect($this->view->url(array(), 'manage-result') . '?error=头像上传失败!'); exit;
                }
            }

            $certificate = "";
//            var_dump($_FILES['upload-certificate-pic']); exit;
            if(is_uploaded_file($_FILES['upload-certificate-pic']['tmp_name'])) {

                $tmp_certificatePic_filename = '/tmp/'. $_FILES['upload-certificate-pic']['name'];
                $tmp_certificatePic_path = $_FILES['upload-certificate-pic']['tmp_name'];

                move_uploaded_file($tmp_certificatePic_path, $tmp_certificatePic_filename);

                $img_certificate_pic = file_get_contents($tmp_certificatePic_filename);
                $enCertificatePic = base64_encode($img_certificate_pic);
//                exit($enHeadPic);
                $certificate = $this->saveFile($enCertificatePic);

                if ($certificate === 0) {
                    $this->_redirect($this->view->url(array(), 'manage-result') . '?error=证书上传失败!'); exit;
                }
            }
            else {
                $certificate = $this->getParam('tmp_certificate_pic');
            }

            if (!$certificate) {
                $certificate = "";
            }

            $wxid = $this->getParam('wxid');
            $name = $this->getParam('name');
            $sex = $this->getParam('sex');
            $birthday = $this->getParam('birthday');
            $place = $this->getParam('place');
            $educational = $this->getParam('educational');
//            $certificate = $this->getParam('certificate');
            $phone = $this->getParam('phone');
            $code = $this->getParam('code');
            $email = $this->getParam('email');
            $qq = $this->getParam('qq');
            $years = $this->getParam('years');
            $wechat = $this->getParam('wechat');
            $location = $this->getParam('location');
            $lessons_id = $this->getParam('lesson');
            $bank = $this->getParam('bank');
            $bank_code = $this->getParam('bank_code');
            $description = $this->getParam('description');
            $skills_id = $this->getParam('skills');
            $photo = $this->decodePhoto();
            $categorys_id = $this->getParam('category');
            $regions_id = $this->getParam('region');
            $experience = $this->getParam('experience');
            $price = $this->getParam('price');

            //获取拥有课程集合ID
            $lessons = array();

            if ($lessons_id) {
                $tmp_lessons = $this->getLessonByIds($lessons_id);

                foreach ($tmp_lessons as $t) {
                    $lessons[] = $t;
                }
            }

            //获取拥有瑜伽分类ID
            $categorys = array();

            if ($categorys_id) {
                $tmp_categorys = $this->getCategoryByIds($categorys_id);

                foreach ($tmp_categorys as $c) {
                    $categorys[] = $c;
                }
            }

            //获取技能集合
            $skills = array();

            if ($skills_id) {
                $tmp_skill_node = explode(";", $skills_id);

                foreach ($tmp_skill_node as $s) {
                    $tmp_skill = explode(":", $s);

                    $skill_id = $this->skillAdd($tmp_skill[0], $tmp_skill[1], null, 1);

                    $skill = $skillModel->getById($skill_id);

                    $skills[] = $skill;
                }
            }

            //获取授权区域
            $regions = array();

            if ($regions_id) {
                $tmp_regions = $this->getRegionByIds($regions_id);

                foreach ($tmp_regions as $r) {
                    $regions[] = $r;
                }
            }

            try {
                if ($wxid) {
                    $result = $teacherModel->ModifyTeacher($wxid, $headPic, $name, $sex, $birthday, $place, $educational, $certificate, $phone, $code, $email, $qq, $years, $wechat, $location, $lessons, $bank, $bank_code, $description, $skills, $photo, 0, 0, $categorys, $regions, $experience, $price);
                }
                else {
                    $result = $teacherModel->addTeacher($headPic, $name, $sex, $birthday, $place, $educational, $certificate, $phone, $code, $email, $qq, $years, $wechat, $location, $lessons, $bank, $bank_code, $description, $skills, $photo, $categorys, $regions, $experience, $price);
                }
            }
            catch (Exception $e) {
                $error = $e->getMessage();
            }

            if ($result) {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?redirectUrl=' . $this->view->url(array(), 'manage-teacher-list-home'));
            } else {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?error=' . $error);
            }
        }
        else {
            $lessons = $lessonModel->getAll(false);
            $categorys = $categoryModel->getAll(false);
            $regions = $regionModel->getAll(false);

            $this->view->regions = $regions;
            $this->view->categorys = $categorys;
            $this->view->lessons = $lessons;
            $this->view->title = "新增老师信息";
        }
    }

    public function teacherSaveAction() {
        $teacherModel = $this->getModel('teacher');
        $lessonModel = $this->getModel('lesson');
        $skillModel = $this->getModel('skill');
        $categoryModel = $this->getModel('category');
        $regionModel = $this->getModel('region');

        if ($this->request->isPost()) {
            $result = 0;

            $headPic = "";
//            var_dump($_FILES['upload-head-pic']); exit;
            if(is_uploaded_file($_FILES['upload-head-pic']['tmp_name'])) {

                $tmp_headPic_filename = '/tmp/'. $_FILES['upload-head-pic']['name'];
                $tmp_headPic_path = $_FILES['upload-head-pic']['tmp_name'];

                move_uploaded_file($tmp_headPic_path, $tmp_headPic_filename);

                $img_head_pic = file_get_contents($tmp_headPic_filename);
                $enHeadPic = base64_encode($img_head_pic);
//                exit($enHeadPic);
                $headPic = $this->saveFile($enHeadPic);

                if ($headPic === 0) {
                    $this->_redirect($this->view->url(array(), 'manage-result') . '?error=头像上传失败!'); exit;
                }
            }
            else {
                $headPic = $this->getParam('tmp_head_pic');
            }

            if (!$headPic) {
                $headPic = "";
            }

            $certificate = "";
//            var_dump($_FILES['upload-certificate-pic']); exit;
            if(is_uploaded_file($_FILES['upload-certificate-pic']['tmp_name'])) {

                $tmp_certificatePic_filename = '/tmp/'. $_FILES['upload-certificate-pic']['name'];
                $tmp_certificatePic_path = $_FILES['upload-certificate-pic']['tmp_name'];

                move_uploaded_file($tmp_certificatePic_path, $tmp_certificatePic_filename);

                $img_certificate_pic = file_get_contents($tmp_certificatePic_filename);
                $enCertificatePic = base64_encode($img_certificate_pic);
//                exit($enHeadPic);
                $certificate = $this->saveFile($enCertificatePic);

                if ($certificate === 0) {
                    $this->_redirect($this->view->url(array(), 'manage-result') . '?error=证书上传失败!'); exit;
                }
            }
            else {
                $certificate = $this->getParam('tmp_certificate_pic');
            }

            if (!$certificate) {
                $certificate = "";
            }

            $wxid = $this->getParam('wxid');

            $id = $this->getParam('id');
            // POST METHOD
            $name = $this->getParam('name');
            $sex = $this->getParam('sex');
            $birthday = $this->getParam('birthday');
            $place = $this->getParam('place');
            $educational = $this->getParam('educational');
//            $certificate = $this->getParam('certificate');
            $phone = $this->getParam('phone');
            $code = $this->getParam('code');
            $email = $this->getParam('email');
            $qq = $this->getParam('qq');
            $years = $this->getParam('years');
            $wechat = $this->getParam('wechat');
            $location = $this->getParam('location');
            $lessons_id = $this->getParam('lesson');
            $bank = $this->getParam('bank');
            $bank_code = $this->getParam('bank_code');
            $description = $this->getParam('description');
            $skills_id = $this->getParam('skills');
            $photo = $this->decodePhoto();
            $categorys_id = $this->getParam('category');
            $regions_id = $this->getParam('region');
            $experience = $this->getParam('experience');
            $price = $this->getParam('price');

            //获取拥有课程集合ID
            $lessons = array();

            if ($lessons_id) {
                $tmp_lessons = $this->getLessonByIds($lessons_id);

                if ($tmp_lessons) {

                    foreach ($tmp_lessons as $t) {
                        $lessons[] = $t;
                    }
                }
            }

            $categorys = array();

            if ($categorys_id) {
                //获取拥有瑜伽分类ID
                $tmp_categorys = $this->getCategoryByIds($categorys_id);

                foreach ($tmp_categorys as $c) {
                    $categorys[] = $c;
                }
            }

            //获取技能集合
            $skills = array();

            if ($skills_id) {
                $tmp_skill_node = explode(";", $skills_id);

                foreach ($tmp_skill_node as $s) {
                    $tmp_skill = explode(":", $s);

                    $skill_id = $this->skillAdd($tmp_skill[0], $tmp_skill[1], null, 1);

                    $skill = $skillModel->getById($skill_id);

                    $skills[] = $skill;
                }
            }

            $regions = array();

            if ($regions_id) {
                //获取授权区域
                $tmp_regions = $this->getRegionByIds($regions_id);

                foreach ($tmp_regions as $r) {
                    $regions[] = $r;
                }
            }
            //获取之前输入的老师数据
            $result = $teacherModel->getById($id);

            try {
                if ($wxid) {
                    if ($result->openid) {
                        //将之前的老师数据迁移到微信用户号的数据中
                        $result = $teacherModel->ModifyTeacher($wxid, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, $result->frozen, $result->delete, null, null, null, null);

                        $result = $teacherModel->returnToCustomer($result->id);
                    }
                    else {
                        //将之前的老师数据迁移到微信用户号的数据中
                        $result = $teacherModel->ModifyTeacher($wxid, $headPic, $name, $sex, $birthday, $place, $educational, $certificate, $phone, $code, $email, $qq, $years, $wechat, $location, $lessons, $bank, $bank_code, $description, $skills, $photo, $result->frozen, $result->delete, $categorys, $regions, $experience, $price);
                    }

                    //--------------------这里涉及数据迁移的问题-----------------------------------
                    $teacherModel->deleteTeacher($id);
                }
                else {
                    $result = $teacherModel->ModifyTeacher($id, $headPic, $name, $sex, $birthday, $place, $educational, $certificate, $phone, $code, $email, $qq, $years, $wechat, $location, $lessons, $bank, $bank_code, $description, $skills, $photo, $result->frozen, $result->delete, $categorys, $regions, $experience, $price);
                }
            } catch (Exception $e) {
                $result = false;
                $error = $e->getMessage();
            }
            if ($result) {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?redirectUrl=' . $this->view->url(array(), 'manage-teacher-list-home'));
            } else {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?error=' . $error);
            }
        } else {
            $photoModel = $this->getModel('photo');

            $id = $this->getParam('id');

            if ($id) {
                $result = $teacherModel->getById($id);

                if ($result) {
                    $photo = $result->photo;

                    if ($photo) {
                        $saveObj = array();
                        foreach ($photo as $p) {
                            try {
                                $name = $p->name;
                            } catch (Doctrine\ODM\MongoDB\DocumentNotFoundException $e) {
                                $this->view->imageBroken = true;
                                continue;
                            }
                            $saveObj[$name] = $this->view->photoImage($p->name . $p->type, 'small');
                            if (!$p->thumbnail) {
                                $saveObj[$name] = $this->view->photoImage($p->name . $p->type);
                            }
                        }
                        if (!count($saveObj))
                            $saveObj = false;
                        $this->view->photo = $saveObj;
                    }
                }

                $this->view->model = $result;

//                echo($result->category[0]->name); exit;
            }

            $lessons = $lessonModel->getAll(false);
            $categorys = $categoryModel->getAll(false);
            $regions = $regionModel->getAll(false);

            $this->view->regions = $regions;
            $this->view->categorys = $categorys;
            $this->view->lessons = $lessons;
            $this->view->title = "编辑老师信息";
        }
    }

    public function teacherListAction() {
        $teacherModel = $this->getModel('teacher');

        $page = $this->getParam('page');
        $name = $this->getParam('name');

        if (!$page) {
            $page = 1;
        }

        if ($name) {
            $param = new MongoRegex("/" . $name . "/i");

            $paginator = $teacherModel->getBy(true, array("usertype"=> "2", "delete"=>"0", "name"=>$param));
        }
        else {
            $paginator = $teacherModel->getBy(true, array("usertype"=> "2", "delete"=>0));
        }

        $paginator->setItemCountPerPage($this->bootstrap_options['default_page_size']);
        $paginator->setCurrentPageNumber($page);

        $this->view->name = $name;
        $this->view->title = "老师列表";
        $this->view->paginator = $paginator;
    }

    public function teacherRemoveAction() {
        if ($this->request->isPost()) {
            $result = 0;
            // POST METHOD
            $id = $this->getParam('id');
            if ($id) {
                $teacherModel = $this->getModel('teacher');

                $result = $teacherModel->getById($id);

                if ($result) {
                    if ($result->delete == 0) {
                        $result = $teacherModel->deleteTeacher($id);
                    }
                    else {
                        $result = $teacherModel->unDeleteTeacher($id);
                    }
                }
            }
            echo $result;
            exit;
        }
    }

    public function teacherApplicationAction() {
        $applicationModel = $this->getModel('application');

        $page = $this->request->getParam('page');

        if (!$page) {
            $page = 1;
        }

        $paginator = $applicationModel->getBy(true, array('state' => 1));
        $paginator->setItemCountPerPage($this->bootstrap_options['default_page_size']);
        $paginator->setCurrentPageNumber($page);

        $this->view->title = "老师申请列表";
        $this->view->paginator = $paginator;
    }
    //老师申请审核通过
    public function applicationApplyAction() {
        if ($this->request->isPost()) {
            $result = 0;
            // POST METHOD
            $id = $this->getParam('id');
            if ($id) {
                $applicationModel = $this->getModel('application');
                $teacherModel = $this->getModel('teacher');

                $result = $applicationModel->getById($id);

                if ($id) {
                    //更新申请状态
                    $applicationModel->applyApplication($id);

                    if ($result) {
                        //更新用户身份为授课老师
                        $result = $teacherModel->applyTeacher($result->customer->id);
                    }
                }
            }
            echo $result;
            exit;
        }
    }
    //老师申请拒绝
    public function applicationRejectAction() {
        if ($this->request->isPost()) {
            $result = 0;
            // POST METHOD
            $id = $this->getParam('id');
            if ($id) {
                $applicationModel = $this->getModel('application');
                //拒绝申请
                $result = $applicationModel->rejectApplication($id);
            }
            echo $result;
            exit;
        }
    }

    public function teacherScoreAction() {
        $orderModel = $this->getModel('order');

        $id = $this->request->getParam('id');
        $page = $this->request->getParam('page');

        if (!$page) {
            $page = 1;
        }

        $paginator = $orderModel->getBy(true, array('teacher.$id'=>new MongoId($id)));
        $paginator->setItemCountPerPage($this->bootstrap_options['default_page_size']);
        $paginator->setCurrentPageNumber($page);

        $this->view->teacher_id = $id;
        $this->view->title = "老师授课历史";
        $this->view->paginator = $paginator;
    }



    /*************************************************************
     * 普通用户action
     *
     * ************************************************************/
    public function customerListAction() {
        $customerModel = $this->getModel('customer');

        $page = $this->request->getParam('page');

        if (!$page) {
            $page = 1;
        }

        $paginator = $customerModel->getBy(true, array("usertype"=> "1"));
        $paginator->setItemCountPerPage($this->bootstrap_options['default_page_size']);
        $paginator->setCurrentPageNumber($page);

        $this->view->title = "用户列表";
        $this->view->paginator = $paginator;
    }

    public function customerFrozenAction() {
        if ($this->request->isPost()) {
            $result = 0;
            // POST METHOD
            $id = $this->getParam('id');
            if ($id) {
                $customerModel = $this->getModel('customer');

                $result = $customerModel->getById($id);

                if ($result) {
                    if ($result->frozen == 0) {
                        $result = $customerModel->frozenCustomer($id);
                    }
                    else {
                        $result = $customerModel->unfrozenCustomer($id);
                    }
                }
            }
            echo $result;
            exit;
        }
    }

    public function customerfrozenListAction() {
        $customerModel = $this->getModel('customer');

        $page = $this->request->getParam('page');

        if (!$page) {
            $page = 1;
        }

        $paginator = $customerModel->getBy(true, array("usertype"=> "1", "frozen"=> 1));
        $paginator->setItemCountPerPage($this->bootstrap_options['default_page_size']);
        $paginator->setCurrentPageNumber($page);

        $this->view->title = "冻结用户列表";
        $this->view->paginator = $paginator;
    }

    public function customerScoreAction() {
        $orderModel = $this->getModel('order');

        $id = $this->request->getParam('id');
        $page = $this->request->getParam('page');

        if (!$page) {
            $page = 1;
        }

        $paginator = $orderModel->getBy(true, array('customer.$id'=>new MongoId($id)));
        $paginator->setItemCountPerPage($this->bootstrap_options['default_page_size']);
        $paginator->setCurrentPageNumber($page);

        $this->view->customer_id = $id;
        $this->view->title = "用户订单历史";
        $this->view->paginator = $paginator;
    }

    public function customerCreateAction() {
        $customerModel = $this->getModel('customer');

        if ($this->request->isPost()) {
            $nickname = $this->getParam('nickname');
            $sex = $this->getParam('sex');
            $openid = $this->getParam('openid');

            try {
                $result = $customerModel->addCustomer($nickname, $sex, $openid);
            }
            catch (Exception $e) {
                $error = $e->getMessage();
            }

            if ($result) {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?redirectUrl=' . $this->view->url(array(), 'manage-customer-list-home'));
            } else {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?error=' . $error);
            }
        }
        else {
            $this->view->title = "新增普通用户(测试)";
        }
    }

    /**********************************************************
     * 技能action部分
     *
     * ********************************************************/
    public function skillAdd($name, $value, $photo, $type) {
        $skillModel = $this->getModel('skill');

        return $skillModel->addSkill($name, $photo, $value, $type);
    }

    /**********************************************************
     * 图片处理action部分
     *
     * ********************************************************/
    protected function decodePhoto($paramName = 'photo') {
        $paramPhoto = $this->request->getParam($paramName);
        if ($paramPhoto) {
            $paramPhoto = json_decode($paramPhoto);
            $photoModel = $this->getModel('photo');
            $photoArray = array();
            foreach ($paramPhoto as $name => $path) {
                $photoObj = $photoModel->getPhotoByName($name);
                if ($photoObj) {
                    $photoArray[] = $photoObj;
                }
            }
            return $photoArray;
        } else {
            return null;
        }
    }

    public function photoCreateAction() {
        $phototypeModel = $this->getModel('phototype');

        if ($this->request->isPost()) {
            $result = 0;
            // POST METHOD
            $tmp = $this->getParam('tmp');
            $title = $this->getParam('title');
            $description = $this->getParam('description');
            $phototypeId = $this->getParam('phototype');
            $thumbnail = $this->getParam('thumbnail') == "1" ? true : false;
            $scale = $this->getParam('scale');
//            $photoclass = $this->getParam('photoclass');

            $phototype = null;
            if ($phototypeId) {
                $phototype = $phototypeModel->getById($phototypeId);
                if (!$phototype) {
                    $this->_redirect($this->view->url(array(), 'manage-result') . '?error="notfound"');
                }
            }
            $owner = $this->me->getUser();
            $photoModel = $this->getModel('photo');
            try {
                $destination = $this->getTmpFile($tmp);
                $result = $photoModel->addPhoto($destination, $title, $description, $phototype, $thumbnail, $owner, $scale);//$photoclass
                if ($result) {
                    $result = 1;
                }
            } catch (Exception $e) {
                // image is not accepted
                $result = 2;
            }
            echo $result;
            exit;
        } else {
            // GET METHOD
            $fs = $this->getParam('fs');

            if ($fs) {
                $this->view->fileList = array();
                $f = explode("|", $fs);
                foreach ($f as $k => $v) {
                    $this->view->fileList[] = array('v' => $v, 'p' => $this->getTmpFile($v));
                }
            }
            $this->view->title = "确认保存图片";
            $this->view->phototype = $phototypeModel->getAll(false);
        }
    }

    public function photoUploadAction() {
        if ($this->request->isPost()) {
            // POST METHOD
            $result = 0;
            $upload = new Zend_File_Transfer();

            $upload->addValidator('Size', false, 5120000); //5M

            $uid = uniqid();
            $destination = $this->getTmpFile($uid);

            $upload->addFilter('Rename', $destination);

            if ($upload->isValid()) {
                if ($upload->receive()) {
                    $result = $uid;
                }
            }
            echo $result;
            exit;
        } else {
            // GET METHOD
            $this->view->title = "上传图片";
        }
    }

    public function photoClearcacheAction() {
        if ($this->request->isPost()) {
            // POST METHOD
            $result = 0;
            $utilService = $this->_container->get('util');
            $tmp = $utilService->getTmpDirectory();

            try {
                if ($od = opendir($tmp)) {
                    while ($file = readdir($od)) {
                        unlink($tmp . DIRECTORY_SEPARATOR . $file);
                    }
                }
                $result = 1;
            } catch (Exception $e) {
                $result = 0;
            }
            echo $result;
            exit;
        }
    }

    public function photoListAction() {
        $page = $this->request->getParam('page');
        $phototype = $this->request->getParam('phototype');
        if (!$page) {
            $page = 1;
        }
        $photoModel = $this->getModel('photo');

        $paginator = null;
        if (!$phototype) {
            $paginator = $photoModel->getAll();
        } else {
            $paginator = $photoModel->getPhotoByPhototype($phototype);
        }
        $paginator->setItemCountPerPage($this->bootstrap_options['default_page_size']);
        $paginator->setCurrentPageNumber($page);
        $resource = array();
        foreach ($paginator as $r) {
            $resource[] = array('path' => array('orig' => $this->view->photoImage($r->name . $r->type), 'main' => $this->view->photoImage($r->name . $r->type, 'main'), 'small' => $this->view->photoImage($r->name . $r->type, 'small'), 'large' => $this->view->photoImage($r->name . $r->type, 'large')),
                'name' => $r->name,
                'id' => $r->id,
                'type' => $r->type,
                'thumbnail' => $r->thumbnail,
                'owner' => $r->owner);
        }
        // JSON FORMAT
        if ($this->getParam('format') == 'json') {
            $this->_helper->json(array('data' => $resource,
                'code' => 200,
                'page' => $paginator->getCurrentPageNumber(),
                'count' => $paginator->count()));
        } else {
            $this->view->paginator = $paginator;
            $this->view->resource = $resource;
            $this->view->title = "图片列表";
        }
    }

    public function photoSaveAction() {
        $notFoundMsg = '未找到目标图片';
        $photoModel = $this->getModel('photo');
        $phototypeModel = $this->getModel('phototype');
        $id = $this->request->getParam('id');

        if ($this->request->isPost()) {
            $result = 0;
            // POST METHOD
            $title = $this->request->getParam('title');
            $description = $this->request->getParam('description');
            $phototypeId = $this->request->getParam('phototype');
//            $photoclass = $this->getParam('photoclass');
            $phototype = null;
            if ($phototypeId) {
                $phototype = $phototypeModel->getById($phototypeId);
                if (!$phototype) {
                    $this->_redirect($this->view->url(array(), 'manage-result') . '?error="notfound"');
                }
            }
            try {
                $result = $photoModel->savePhoto($id, $title, $description, $phototype);//, $photoclass
            } catch (Angel_Exception_Photo $e) {
                $error = $e->getDetail();
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
            if ($result) {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?redirectUrl=' . $this->view->url(array(), 'manage-photo-list-home'));
            } else {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?error=' . $error);
            }
        } else {
            // GET METHOD
            $this->view->title = "编辑图片";

            if ($id) {
                $target = $photoModel->getById($id);
                $phototype = $phototypeModel->getAll(false);
                if (!$target) {
                    $this->_redirect($this->view->url(array(), 'manage-result') . '?error=' . $notFoundMsg);
                }
                $this->view->model = $target;
                $this->view->phototype = $phototype;
            } else {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?error=' . $notFoundMsg);
            }
        }
    }

    public function photoRemoveAction() {
        if ($this->request->isPost()) {
            $result = 0;
            // POST METHOD
            $id = $this->getParam('id');
            if ($id) {
                $photoModel = $this->getModel('photo');
                $result = $photoModel->removePhoto($id);
            }
            echo $result;
            exit;
        }
    }

    /***************************************************
     * 图片类型acton部分
     *
     * ************************************************/
    public function phototypeListAction() {
        $page = $this->request->getParam('page');
        if (!$page) {
            $page = 1;
        }
        $phototypeModel = $this->getModel('phototype');
        $photoModel = $this->getModel('photo');
        $paginator = $phototypeModel->getAll();
        $paginator->setItemCountPerPage($this->bootstrap_options['default_page_size']);
        $paginator->setCurrentPageNumber($page);
        $resource = array();
        foreach ($paginator as $r) {
            $resource[] = array('id' => $r->id,
                'name' => $r->name,
                'description' => $r->description,
                'owner' => $r->owner);
        }
        // JSON FORMAT
        if ($this->getParam('format') == 'json') {
            $this->_helper->json(array('data' => $resource,
                'code' => 200,
                'page' => $paginator->getCurrentPageNumber(),
                'count' => $paginator->count()));
        } else {
            $this->view->paginator = $paginator;
            $this->view->resource = $resource;
            $this->view->title = "图片分类列表";
            $this->view->photoModel = $photoModel;
        }
    }

    public function phototypeCreateAction() {
        if ($this->request->isPost()) {
            $result = 0;
            // POST METHOD
            $name = $this->request->getParam('name');
            $description = $this->request->getParam('description');
            $owner = $this->me->getUser();
            $phototypeModel = $this->getModel('phototype');
            try {
                $result = $phototypeModel->addPhototype($name, $description, $owner);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
            if ($result) {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?redirectUrl=' . $this->view->url(array(), 'manage-phototype-list-home'));
            } else {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?error=' . $error);
            }
        } else {
            // GET METHOD
            $this->view->title = "创建图片分类";
        }
    }

    public function phototypeSaveAction() {
        $notFoundMsg = '未找到目标图片分类';

        if ($this->request->isPost()) {
            $result = 0;
            // POST METHOD
            $id = $this->request->getParam('id');
            $name = $this->request->getParam('name');
            $description = $this->request->getParam('description');
            $phototypeModel = $this->getModel('phototype');
            try {
                $result = $phototypeModel->savePhototype($id, $name, $description);
            } catch (Angel_Exception_Phototype $e) {
                $error = $e->getDetail();
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
            if ($result) {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?redirectUrl=' . $this->view->url(array(), 'manage-phototype-list-home'));
            } else {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?error=' . $error);
            }
        } else {
            // GET METHOD
            $this->view->title = "编辑图片分类";

            $id = $this->request->getParam("id");
            if ($id) {
                $phototypeModel = $this->getModel('phototype');
                $target = $phototypeModel->getById($id);
                if (!$target) {
                    $this->_redirect($this->view->url(array(), 'manage-result') . '?error=' . $notFoundMsg);
                }
                $this->view->model = $target;
            } else {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?error=' . $notFoundMsg);
            }
        }
    }

    public function phototypeRemoveAction() {
        if ($this->request->isPost()) {
            $result = 0;
            // POST METHOD
            $id = $this->getParam('id');
            if ($id) {
                $phototypeModel = $this->getModel('phototype');
                $result = $phototypeModel->remove($id);
            }
            echo $result;
            exit;
        }
    }


    /****************************************************
     * 分类action部分
     *
     * *************************************************/
    public function categoryCreateAction() {
        $categoryModel = $this->getModel('category');

        if ($this->request->isPost()) {
            $result = 0;
            // POST METHOD
            $name = $this->request->getParam('name');
            $description = $this->request->getParam('description');

            try {
                $result = $categoryModel->addCategory($name, $description);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
            if ($result) {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?redirectUrl=' . $this->view->url(array(), 'manage-category-list-home'));
            } else {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?error=' . $error);
            }
        } else {
            // GET METHOD
            $this->view->title = "创建瑜伽分类";
        }
    }

    public function categoryListAction() {
        $categoryModel = $this->getModel('category');

        $page = $this->request->getParam('page');

        if (!$page) {
            $page = 1;
        }

        $paginator = $categoryModel->getAll();
        $paginator->setItemCountPerPage($this->bootstrap_options['default_page_size']);
        $paginator->setCurrentPageNumber($page);

        $this->view->title = "瑜伽分类列表";
        $this->view->paginator = $paginator;
    }

    public function categoryRemoveAction() {
        if ($this->request->isPost()) {
            $result = 0;
            // POST METHOD
            $id = $this->getParam('id');

            if ($id) {
                $categoryModel = $this->getModel('category');
                $result = $categoryModel->remove($id);
            }
            echo $result;
            exit;
        }
    }

    public function categorySaveAction() {
        $notFoundMsg = '未找到目标分类';
        $categoryModel = $this->getModel('category');

        if ($this->request->isPost()) {
            $result = 0;
            // POST METHOD
            $id = $this->request->getParam('id');
            $name = $this->request->getParam('name');
            $description = $this->request->getParam('description');
            
            try {
                $result = $categoryModel->saveCategory($id, $name, $description);
            } catch (Angel_Exception_Category $e) {
                $error = $e->getDetail();
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
            if ($result) {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?redirectUrl=' . $this->view->url(array(), 'manage-category-list-home'));
            } else {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?error=' . $error);
            }
        } else {
            // GET METHOD
            $this->view->title = "编辑分类";

            $id = $this->request->getParam("id");

            if ($id) {
                $target = $categoryModel->getById($id);

                if (!$target) {
                    $this->_redirect($this->view->url(array(), 'manage-result') . '?error=' . $notFoundMsg);
                }
                $this->view->model = $target;
            } else {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?error=' . $notFoundMsg);
            }
        }
    }

    public function getCategoryByIds($ids) {
        $categoryModel = $this->getModel('category');

        $result = $categoryModel->getByIds($ids);

        return $result;
    }

    /*********************************************************************************
     * 最大工时
     *
     * *******************************************************************************/
    public function workCreateAction() {
        $workModel = $this->getModel('work');

        if ($this->request->isPost()) {
            $result = 0;
            // POST METHOD
            $hour = $this->request->getParam('hour');

            try {
                $result = $workModel->addWork($hour);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
            if ($result) {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?redirectUrl=' . $this->view->url(array(), 'manage-work-list-home'));
            } else {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?error=' . $error);
            }
        } else {
            // GET METHOD
            $this->view->title = "创建最大工时";
        }
    }

    public function workListAction() {
        $workModel = $this->getModel('work');

        $paginator = $workModel->getAll(false);

        $this->view->title = "最大工时";
        $this->view->resource = $paginator;
    }

    public function workSaveAction() {
        $notFoundMsg = '未找到目标分类';
        $workModel = $this->getModel('work');

        if ($this->request->isPost()) {
            $result = 0;
            // POST METHOD
            $id = $this->request->getParam('id');
            $hour = $this->request->getParam('hour');

            try {
                $result = $workModel->saveWork($id,$hour);
            } catch (Angel_Exception_Category $e) {
                $error = $e->getDetail();
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
            if ($result) {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?redirectUrl=' . $this->view->url(array(), 'manage-work-list-home'));
            } else {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?error=' . $error);
            }
        } else {
            // GET METHOD
            $this->view->title = "编辑最大工时";

            $id = $this->request->getParam("id");

            if ($id) {
                $target = $workModel->getById($id);

                if (!$target) {
                    $this->_redirect($this->view->url(array(), 'manage-result') . '?error=' . $notFoundMsg);
                }
                $this->view->model = $target;
            } else {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?error=' . $notFoundMsg);
            }
        }
    }


    /********************************************************
     * 其他代码action部分
     *
     * *******************************************************/
    public function resultAction() {
        $this->view->error = $this->request->getParam('error');
        $this->view->redirectUrl = $this->request->getParam('redirectUrl');
    }

    protected function getTmpFile($uid) {
        $utilService = $this->_container->get('util');
        $result = $utilService->getTmpDirectory() . '/' . $uid;
        return $result;
    }

    /**************************************
     * 测试 api action
     *
     * ************************************/
    public function apiTestAction() {

    }

    /********************************************************
     * 区域action部分代码
     *
     * ******************************************************/
    public  function regionCreateAction() {
        $regionModel = $this->getModel('region');

        if ($this->request->isPost()) {
            $result = 0;
            // POST METHOD
            $name = $this->request->getParam('name');
            $coordinate = $this->getParam('coordinate');

            try {
                $result = $regionModel->addRegion($name, $coordinate);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
            if ($result) {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?redirectUrl=' . $this->view->url(array(), 'manage-region-list-home'));
            } else {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?error=' . $error);
            }
        } else {
            $this->view->title = "创建区域";
        }
    }

    public function regionSaveAction() {
        $regionModel = $this->getModel('region');

        if ($this->request->isPost()) {
            $result = 0;
            $id = $this->getParam('id');
            // POST METHOD
            $name = $this->getParam('name');
            $coordinate = $this->getParam('coordinate');

            try {
                $result = $regionModel->saveRegion($id, $name, $coordinate);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
            if ($result) {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?redirectUrl=' . $this->view->url(array(), 'manage-region-list-home'));
            } else {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?error=' . $error);
            }
        } else {
            $id = $this->getParam('id');

            if ($id) {
                $result = $regionModel->getById($id);

                $this->view->model = $result;
            }

            $this->view->title = "编辑区域";
        }
    }

    public function regionListAction() {
        $regionModel = $this->getModel('region');

        $page = $this->request->getParam('page');

        if (!$page) {
            $page = 1;
        }

        $paginator = $regionModel->getAll();
        $paginator->setItemCountPerPage($this->bootstrap_options['default_page_size']);
        $paginator->setCurrentPageNumber($page);

        $this->view->title = "区域列表";
        $this->view->paginator = $paginator;
    }

    public function regionRemoveAction() {
        if ($this->request->isPost()) {
            $result = 0;
            // POST METHOD
            $id = $this->getParam('id');
            if ($id) {
                $regionnModel = $this->getModel('region');
                $result = $regionnModel->remove($id);
            }
            echo $result;
            exit;
        }
    }

    public function getRegionByIds($ids) {
        $regionModel = $this->getModel('region');

        $result = $regionModel->getByIds($ids);

        return $result;
    }

    /********************************************************
     * 课程aciton部分
     *
     * *****************************************************/
    public function lessonCreateAction() {
        $lessonModel = $this->getModel('lesson');

        if ($this->request->isPost()) {
            $result = 0;
            // POST METHOD
            $name = $this->request->getParam('name');
            $photo = $this->decodePhoto();
            $description = $this->getParam('description');

            try {
                $result = $lessonModel->addLesson($name, $photo, $description);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
            if ($result) {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?redirectUrl=' . $this->view->url(array(), 'manage-lesson-list-home'));
            } else {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?error=' . $error);
            }
        } else {
            $this->view->title = "创建课程";
        }
    }

    public function lessonListAction() {
        $lessonModel = $this->getModel('lesson');

        $page = $this->request->getParam('page');

        if (!$page) {
            $page = 1;
        }

        $paginator = $lessonModel->getAll();
        $paginator->setItemCountPerPage($this->bootstrap_options['default_page_size']);
        $paginator->setCurrentPageNumber($page);

        $this->view->title = "课程列表";
        $this->view->paginator = $paginator;
    }

    public function lessonSaveAction() {
        $lessonModel = $this->getModel('lesson');

        if ($this->request->isPost()) {
            $result = 0;
            $id = $this->getParam('id');
            // POST METHOD
            $name = $this->getParam('name');
            $photo = $this->decodePhoto();
            $description = $this->getParam('description');

            try {
                $result = $lessonModel->saveLesson($id, $name, $photo, $description);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
            if ($result) {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?redirectUrl=' . $this->view->url(array(), 'manage-lesson-list-home'));
            } else {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?error=' . $error);
            }
        } else {
            $photoModel = $this->getModel('photo');

            $id = $this->getParam('id');

            if ($id) {
                $result = $lessonModel->getById($id);

                if ($result) {
                    $photo = $result->photo;

                    if ($photo) {
                        $saveObj = array();
                        foreach ($photo as $p) {
                            try {
                                $name = $p->name;
                            } catch (Doctrine\ODM\MongoDB\DocumentNotFoundException $e) {
                                $this->view->imageBroken = true;
                                continue;
                            }
                            $saveObj[$name] = $this->view->photoImage($p->name . $p->type, 'small');
                            if (!$p->thumbnail) {
                                $saveObj[$name] = $this->view->photoImage($p->name . $p->type);
                            }
                        }
                        if (!count($saveObj))
                            $saveObj = false;
                        $this->view->photo = $saveObj;
                    }
                }

                $this->view->model = $result;
            }

            $this->view->title = "编辑课程";
        }
    }

    public function lessonRemoveAction() {
        if ($this->request->isPost()) {
            $result = 0;
            // POST METHOD
            $id = $this->getParam('id');
            if ($id) {
                $lessonModel = $this->getModel('lesson');
                $result = $lessonModel->remove($id);
            }
            echo $result;
            exit;
        }
    }

    public function getLessonByIds($ids) {
        $lessonModel = $this->getModel('lesson');

        $result = $lessonModel->getByIds($ids);

        return $result;
    }

    /*********************************************************************
     * 订单列表
     *
     * ********************************************************************/
    public function orderListAction() {
        $orderModel = $this->getModel('order');

        $page = $this->request->getParam('page');

        if (!$page) {
            $page = 1;
        }

        $paginator = $orderModel->getAll();
        $paginator->setItemCountPerPage($this->bootstrap_options['default_page_size']);
        $paginator->setCurrentPageNumber($page);

        $this->view->title = "授课列表";
        $this->view->paginator = $paginator;
    }
    /**
    +------------------------------------------------------------------------------
     *                等比例压缩图片
    +------------------------------------------------------------------------------
     * @param String $src_imagename 源文件名        比如 “source.jpg”
     * @param int    $maxwidth      压缩后最大宽度
     * @param int    $maxheight     压缩后最大高度
     * @param String $savename      保存的文件名    “d:save”
     * @param String $filetype      保存文件的格式 比如 ”.jpg“
    +------------------------------------------------------------------------------
     */
    function resizeImage($src_imagename,$maxwidth,$maxheight,$savename,$filetype) {
        $im=imagecreatefromjpeg($src_imagename);
        $current_width = imagesx($im);
        $current_height = imagesy($im);

        if(($maxwidth && $current_width > $maxwidth) || ($maxheight && $current_height > $maxheight)) {
            if($maxwidth && $current_width>$maxwidth) {
                $widthratio = $maxwidth/$current_width;
                $resizewidth_tag = true;
            }

            if($maxheight && $current_height>$maxheight) {
                $heightratio = $maxheight/$current_height;
                $resizeheight_tag = true;
            }

            if($resizewidth_tag && $resizeheight_tag) {
                if($widthratio<$heightratio)
                    $ratio = $widthratio;
                else
                    $ratio = $heightratio;
            }

            if($resizewidth_tag && !$resizeheight_tag)
                $ratio = $widthratio;
            if($resizeheight_tag && !$resizewidth_tag)
                $ratio = $heightratio;

            $newwidth = $current_width * $ratio;
            $newheight = $current_height * $ratio;

            if(function_exists("imagecopyresampled")) {
                $newim = imagecreatetruecolor($newwidth,$newheight);
                imagecopyresampled($newim,$im,0,0,0,0,$newwidth,$newheight,$current_width,$current_height);
            }
            else {
                $newim = imagecreate($newwidth,$newheight);
                imagecopyresized($newim,$im,0,0,0,0,$newwidth,$newheight,$current_width,$current_height);
            }

            $savename = $savename.$filetype;
            imagejpeg($newim,$savename);
            imagedestroy($newim);
        }
        else {
            $savename = $savename.$filetype;
            imagejpeg($im,$savename);
        }
    }

    public function saveFile($file) {
        $base64 = $file;
        $IMG = base64_decode( $base64 );

        $filename = strtolower($this->create_guid());

        $full_name = APPLICATION_PATH . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'public/photo/image/'. $filename . '.jpg';

        file_put_contents($full_name, $IMG);
        $type = '.jpg';
        $return_file_name = "";

        $return_file_name = $filename . $type;

        $tmp_name = APPLICATION_PATH . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'public/photo/image/tmp_'. $filename;
        $result_name = $filename .'_120'. $type;//jpg';//
        $small_name = APPLICATION_PATH . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'public/photo/image/'. $result_name;

        $code = 200;

        try {
            $this->resizeImage($full_name, 200, 200, $tmp_name, $type);

            $this->cutImg($tmp_name . $type, $small_name, 120, 120);

            unlink($tmp_name . $type) ;
        }
        catch (Exception $e) {
            $code = 0;
            $result_name = $e->getMessage();
        }

        if ($code == 0) {
            return $code;
        }
        else {
            return $return_file_name;
        }
    }

    function cutImg($img, $new_path, $w,$h){        //要裁减的图片，宽度，高度
        $s = imagecreatefromjpeg($img);            //这里以jpg图片为例，其他图片要修改这个方法名称，可以上网参考（就是后面那个后缀名不一样)

        $w = imagesx($s)<$w?imagesx($s):$w;        //如果图片的宽比要求的小，则以原图宽为准
        $h = imagesy($s)<$w?imagesy($s):$h;

        $bg = imagecreatetruecolor($w,$h);        //创建$w*$h的空白图像

        $top = 0;
        $left = 0;
        $right = 0;
        $bottom = 0;
        $p = imagesx($s);
        //获取从中间往左上偏移坐标
        if (imagesx($s)> $w) {
            $left = (imagesx($s) / 2) - ($w / 2);
        }

        if (imagesy($s)> $h) {
            $top = (imagesy($s) / 2) - ($h / 2);
        }

        if(imagecopy($bg, $s, 0, 0, $left, $top, $w, $h)){
            if(imagejpeg($bg, $new_path)){            //将生成的图片保存到img/new_img.jpg
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
        /*
        *imagecopy ($dst_im,$src_im,$dst_x,$dst_y,$src_x,$src_y,$src_w,$src_h)
        将 src_im 图像中坐标从 src_x，src_y 开始，宽度为 src_w，高度为 src_h 的一部分拷贝到 dst_im 图像中坐标为 dst_x 和 dst_y 的位置上。
        */
        imagedestroy($s);                //关闭图片
        imagedestroy($bg);
        //这里只写了几个主要操作，你可以再加上开始裁减的坐标，也就是imagecopy中的第5，第6两个参数，那么在判断$w和$h的地方也要相应的剪掉开始没算进去的部分，
        //然后保存路径是否存在的判断等
    }

    public function create_guid($namespace = '') {
        static $guid = '';
        $uid = uniqid("", true);
        $data = $namespace;
        $data .= $_SERVER['REQUEST_TIME'];
        $data .= $_SERVER['HTTP_USER_AGENT'];
        $data .= $_SERVER['LOCAL_ADDR'];
        $data .= $_SERVER['LOCAL_PORT'];
        $data .= $_SERVER['REMOTE_ADDR'];
        $data .= $_SERVER['REMOTE_PORT'];
        $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
        $guid = substr($hash, 0, 8) .
            '-' .
            substr($hash, 8, 4) .
            '-' .
            substr($hash, 12, 4) .
            '-' .
            substr($hash, 16, 4) .
            '-' .
            substr($hash, 20, 12);

        return $guid;
    }
}
