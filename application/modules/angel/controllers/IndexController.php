<?php

class Angel_IndexController extends Angel_Controller_Action {

    protected $login_not_required = array(
        'index',
        'teacher-detail',
        'course',
        'my-index',
        'apply',
        'apply-history',
        'apply-success',
        'course-detail',
        'confirmation-order',
        'my-order',
        'order-detail',
        'my-lesson',
        'start-lesson',
        'end-lesson',
        'lesson-success',
        'pay-success',
        'start-lesson',
        'end-lesson',
        'lesson-success'
        );

    public function init() {
        $this->_helper->layout->setLayout('main');
        parent::init();
    }

    public function indexAction() {
        $regionModel = $this->getModel('region');

        $region = $regionModel->getAll(false);

        $this->view->region = $region;
    }

    public function teacherDetailAction() {
        $teacherModel = $this->getModel('teacher');

        $id = $this->getParam('id');

        $result = $teacherModel->getById($id);

        $this->view->model = $result;
    }

    public function confirmationOrderAction() {
        $orderModel = $this->getModel('order');

        $id = $this->getParam('id');

        $order = $orderModel->getById($id);

        $this->view->model = $order;
    }

    public function paySuccessAction() {
        $orderModel = $this->getModel('order');

        $id = $this->getParam('id');

        $orderModel->updateState($id, 20);

        $order = $orderModel->getById($id);

        $this->view->model = $order;
    }

    public function initCountAction() {
        $teacherModel = $this->getModel('teacher');

        $teachers = $teacherModel->getAll(false);

        foreach ($teachers as $t) {
            $teacherModel->initTeacherCount($t->id);
        }
    }

    public function courseAction() {
        $lessonModel = $this->getModel('lesson');

        $lessons = $lessonModel->getAll(false);

        $this->view->lessons = $lessons;
    }

    public function courseDetailAction() {
        $lessonModel = $this->getModel('lesson');
        $regionModel = $this->getModel('region');

        $id = $this->getParam('id');

        $lesson = $lessonModel->getById($id);
        $region = $regionModel->getAll(false);

        $this->view->region = $region;
        $this->view->model = $lesson;
    }

    public function myIndexAction() {
        $teacherModel = $this->getModel('teacher');

        $id = $this->getParam('id');

        $user = $teacherModel->getById($id);

        if ($user) {
            $this->view->model = $user;
        }
        else {
            exit("用户信息无效，请重新登录!");
        }
    }

    public function myOrderAction() {
        $orderModel = $this->getModel('order');

        $id = $this->getParam('id');

        $paginator = $orderModel->getBy(false, array('delete'=>0,'custmoer.$id'=>new MongoId($id)));

        $this->view->count = count($paginator);
        $this->view->order_list = $paginator;
    }

    public function orderDetailAction() {
        $orderModel = $this->getModel('order');

        $id = $this->getParam('id');

        $order = $orderModel->getById($id);

        $this->view->model = $order;
    }

    public function myLessonAction() {
        $orderModel = $this->getModel('order');

        $id = $this->getParam('id');

        $paginator = $orderModel->getBy(false, array('delete'=>0,'teacher.$id'=>new MongoId($id)));

        $this->view->user_id = $id;
        $this->view->count = count($paginator);
        $this->view->order_list = $paginator;
    }

    public function startLessonAction() {
        $orderModel = $this->getModel('order');

        $id = $this->getParam('id');

        $order = $orderModel->getById($id);

        $this->view->model = $order;
    }

    public function endLessonAction() {
        $orderModel = $this->getModel('order');

        $id = $this->getParam('id');

        $orderModel->updateState($id, 30);

        $order = $orderModel->getById($id);

        $this->view->model = $order;
    }

    public function lessonSuccessAction() {
        $orderModel = $this->getModel('order');

        $id = $this->getParam('id');

        $orderModel->updateState($id, 40);

        $order = $orderModel->getById($id);

        $this->view->model = $order;
    }

    public function  applyAction() {

    }

    public function applyHistoryAction() {

    }

    public function applySuccessAction() {

    }

    /***************************************************************
     * 用户处理
     *
     * *************************************************************/
    public function upgradeAction() {
        $this->_helper->layout->setLayout('upgrade');
    }
    
    public function subscribeAction() {
        if ($this->request->isXmlHttpRequest() && $this->request->isPost()) {
            try {
                $email = $this->request->getParam("email");
                $subscribeModel = $this->getModel('subscribe');
                $subscribeModel->addSubscribe($email);
                echo 1;
                exit;
            } catch (Angel_Exception_User $e) {
                echo 0;
                exit;
            }
        } else {
            
        }
    }

    /**
     * 登录
     */
    public function loginAction() {
        if ($this->request->isPost()) {
            $this->userLogin('show-play', "登录芝士电视");
        }
        else {
            //第一次请求先判断是否移动端浏览器,如果是移动端浏览器就跳转到移动端注册页面
            if ($this->isMobile()) {
                $loginPath = $this->view->url(array(), 'phone-login') ;

                $this->_redirect($loginPath);
            }
        }
    }

    /**
     * 注册
     */
    public function registerAction() {
        if ($this->request->isPost()) {
            $this->userRegister('login', "注册芝士电视", "user");
        }
        else {
            //第一次请求先判断是否移动端浏览器,如果是移动端浏览器就跳转到移动端注册页面
            if ($this->isMobile()) {
                $registerPath = $this->view->url(array(), 'phone-register') ;

                $this->_redirect($registerPath);
            }
        }
    }

    public function isEmailCanBeUsedAction() {
        if ($this->request->isXmlHttpRequest() && $this->request->isPost()) {

            $email = $this->request->getParam('email');
            $result = false;
            try {
                $userModel = $this->getModel('user');
                $result = $userModel->isEmailExist($email);
            } catch (Angel_Exception_User $e) {
                $this->_helper->json(0);
            }
            // email已经存在返回false，不存在返回true
            $this->_helper->json($result ? false : true);
        }
    }

    public function forgotPasswordAction() {
        if ($this->request->isPost()) {
            $email = $this->request->getParam('email');
            $result = false;
            try {
                $userModel = $this->getModel('user');
                $result = $userModel->forgotPassword($email);
            } catch (Angel_Exception_User $e) {
                $this->view->error = $e->getDetail();
                $this->view->re_email = $email;
                $result = false;
            }
            if ($result) {
                $this->view->send = "success";
            }
        }
        $this->view->title = "找回密码";
    }

    public function logoutAction() {
        $this->userLogout('login');
    }

    /**************************************************************
     * action
     *
     * ***********************************************************/


    /***********************************************
     * action
     *
     * *********************************************/


    /************************************************
     * action
     *
     * *********************************************/


    /************************************************
     * action
     *
     * **********************************************/


    /*******************************************************
     * 其他action
     *
     * *****************************************************/

    /*******************************************************
     * tools方法
     *
     * *****************************************************/
}
