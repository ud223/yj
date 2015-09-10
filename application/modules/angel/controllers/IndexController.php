<?php

class Angel_IndexController extends Angel_Controller_Action {
    private $app_id = 'wx4f812fb76adfa3ff';
    private $app_secret = '4450180e6fd9b8a88b79a2261a1da6ae';
    private $access_token = '';

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
        'lesson-success',
        'my-calendar',
        'my-class',
        'rating',
        'rating-success',
        'about',
        'reg',
        'reg-user',
        'clear',
        'menu-create',
        'menu-delete'
    );

    public function init() {
        $this->_helper->layout->setLayout('main');
        parent::init();
    }

    public function aboutAction() {

    }

    public function clearAction() {

    }

    public function indexAction() {
//        exit("xixi");
        $regionModel = $this->getModel('region');

        $region = $regionModel->getAll(false);

        $this->view->region = $region;
    }

    public function teacherDetailAction() {
        $teacherModel = $this->getModel('teacher');
        $orderModel = $this->getModel('order');
        $workModel = $this->getModel('work');

        $id = $this->getParam('id');

        $result = $teacherModel->getById($id);

        $conditions = array('teacher.$id'=>new MongoId($id), 'state'=>50);

        $orders = $orderModel->getBy(false, $conditions);

        $works = $workModel->getAll(false);

        foreach ($works as $w) {
            $work = $w;
        }

        $this->view->max_hours = $work->hour;
        $this->view->model = $result;
        $this->view->orders = $orders;
    }

    public function confirmationOrderAction() {
        $orderModel = $this->getModel('order');
        $workModel = $this->getModel('work');

        $id = $this->getParam('id');

        $order = $orderModel->getById($id);

        $works = $workModel->getAll(false);

        foreach ($works as $w) {
            $work = $w;
        }

        $this->view->max_hours = $work->hour;
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

    public function getOpenId($code) {
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=". $this->app_id ."&secret=". $this->app_secret ."&code=". $code ."&grant_type=authorization_code";

        $weixin = file_get_contents($url);
        $jsondecode = json_decode($weixin);
        $array = get_object_vars($jsondecode);

        $open_id = $array['openid'];
        $this->access_token = $array['access_token'];

        return $open_id;
    }

    public function getUserInfo($open_id) {
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=". $this->access_token ."&openid=". $open_id ."&lang=zh_CN";

        $weixin = file_get_contents($url);

        $jsondecode = json_decode($weixin);
        $array = get_object_vars($jsondecode);

        return $array;
    }

    public function addUser($data) {
        $customerModel = $this->getModel('customer');

        $openid = $data['openid'];
        $nickname = $data['nickname'];
        $sex = $data['sex'];
//        $language = $data['language'];
        $city = $data['city'];
        $province = $data['province'];
        $country = $data['country'];
        $headimgurl = $data['headimgurl'];

        $result = $customerModel->getUserByOpenId($openid);

        //如果该openid用户已经添加
        if (count($result) == 1) {
            foreach ($result as $r) {
                $customer = $r;

                break;
            }

            $id = $customer->id;

            $customerModel->saveWinXinUser($id, $openid, $nickname, $sex, $headimgurl);

            return $customer;
        }

        $result = $customerModel->addCustomer($nickname, $sex, $openid, $headimgurl);

        return $result;
    }

    public function  regAction() {
//        exit("xixi");
        $code = $_GET['code'];
        $id = $this->getParam('id');

        $tmp_web_url = $this->getParam('web_url');
        $web_url = urldecode($tmp_web_url);
//        exit($web_url);
        if ($web_url) {
            if ($web_url == "http://www.yujiaqu.com/") {
                $web_url = "/";
            }
            else {
                $web_url = str_replace("http://www.yujiaqu.com/", "/", $web_url);
            }
        }
        else {
            $web_url = "/";
        }

        $open_id = $this->getOpenId($code);
        $userInfo = $this->getUserInfo($open_id);

        $result = $this->addUser($userInfo);

        if ($web_url == "/") {
            $web_url = $web_url;
        }
        else {
            if (substr($web_url, strlen($web_url) - 1, 1) != "/") {
                $web_url = $web_url;
            }
            else {
                $web_url = $web_url;
            }
        }

        if ($result) {
            if (!$result->is_reg) {
                header("location: /reg/user/". $result->id); exit;
            }

            $this->view->url = $web_url;
            $this->view->user_id = $result->id;
        }
        else {
            exit("注册或登陆失败,请重试!");
        }
    }

    public function regUserAction() {
        $customerModel = $this->getModel('customer');

        $id = $this->getParam('id');

        $customer = $customerModel->getById($id);

        if ($customer->is_reg) {
            header("location: /"); exit;
        }

        $this->view->model = $customer;
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

        $paginator = $orderModel->getBy(false, array('delete'=>0, 'customer.$id'=>new MongoId($id)));

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

    public function myCalendarAction() {
        $teacher_id = $this->getParam('id');

        $this->view->teacher_id = $teacher_id;
    }

    public function myClassAction() {
        $teacherModel = $this->getModel('teacher');
        $lessonModel = $this->getModel('lesson');

        $id = $this->getParam('id');

        $lessons = $lessonModel->getAll(false);
        $teacher = $teacherModel->getById($id);
        $count = 0;

        foreach ($teacher->lesson as $p) {
            $count++;
        }

        $this->view->count = $count;
        $this->view->model = $teacher;
        $this->view->lessons = $lessons;
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

    public function ratingAction() {
        $orderModel = $this->getModel('order');

        $id = $this->getParam('id');

        $order = $orderModel->getById($id);

        if ($order->state != 40) {
            header("location:/me/". $order->customer->id);
        }

        $this->view->model = $order;
    }

    public function ratingSuccessAction() {
        $orderModel = $this->getModel('order');
        $teacherModel = $this->getModel('teacher');

        $id = $this->getParam('id');

        $orderModel->updateState($id, 50);

        $order = $orderModel->getById($id);

        $teacher_id = $order->teacher->id;

        $teacher = $teacherModel->getById($teacher_id);
//        exit($order->pay_amount);
        $amount = floatval($teacher->amount) + floatval($order->pay_amount);
        $use_amount = floatval($teacher->use_amount) + floatval($order->pay_amount);
        $teacher_count = intval($teacher->teacher_count) + 1;

        $result = $teacherModel->updateMoney($teacher_id, $amount, $use_amount, $teacher_count);
        //失败没有页面。。。
    }

    public function  applyAction() {
        $categoryModel = $this->getModel('category');
        $regionModel = $this->getModel('region');
        $customerModel = $this->getModel('customer');

        $id = $this->getParam('id');

        $customer = $customerModel->getById($id);

        $regions = $regionModel->getAll(false);
        $categorys = $categoryModel->getAll(false);

        $this->view->model = $customer;
        $this->view->region = $regions;
        $this->view->category = $categorys;
    }

    public function applyHistoryAction() {
        $applicaitonModel = $this->getModel('application');

        $id = $this->getParam('id');

        $applicaitons = $applicaitonModel->getBy(false, array('customer.$id'=>new MongoId($id)));

        $this->view->application = $applicaitons;
        $this->view->user_id = $id;
    }

    public function applySuccessAction() {
        $customerModel = $this->getModel('customer');
        $applicaitonModel = $this->getModel('application');

        $id = $this->getParam('id');

        $customer = $customerModel->getById($id);

        $result = $applicaitonModel->addApplication($customer);

        $this->view->user_id = $id;
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
            $this->userLogin('show-play', "登录瑜伽去");
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
            $this->userRegister('login', "注册瑜伽去", "user");
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

    public function menuCreateAction() {
        $this->createMenu();
    }

    public function getAccessToken() {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->app_id."&secret=".$this->app_secret;
        $data = $this->getCurl($url);//通过自定义函数getCurl得到https的内容

        $resultArr = json_decode($data, true);//转为数组
        return $resultArr["access_token"];//获取access_token
    }

    public function menuDeleteAction() {
        echo $this->deleteMenu();
    }

    public function deleteMenu() {
        $accessToken = $this->getAccessToken();//获取access_token

        $url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".$accessToken;
        $data = $this->getCurl($url);//通过自定义函数getCurl得到https的内容

        $resultArr = json_decode($data, true);//转为数组
        return $resultArr["errmsg"];//获取access_token
    }

    public function createMenu() {
        $accessToken = $this->getAccessToken();//获取access_token
        $menuPostString = '{ "button":[{ "type":"view", "name":"进入天使圈云步客",  "url":"http://cbook.test.angelhere.cn" }] }';

        $menuPostUrl = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$accessToken;//POST的url
        $menu = $this->dataPost($menuPostString, $menuPostUrl);//将菜单结构体POST给微信服务器
        var_dump($menu);
    }

    public function getCurl($url) {//get https的内容
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//不输出内容
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result =  curl_exec($ch);
        curl_close ($ch);
        return $result;
    }

    public function dataPost($post_string, $url) {//POST方式提交数据
        $context = array('http' => array('method' => "POST", 'header' => "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US) \r\n Accept: */*", 'content' => $post_string));
        $stream_context = stream_context_create($context);
        $data = file_get_contents($url, FALSE, $stream_context);
        return $data;
    }
}
