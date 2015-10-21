<?php

class Angel_IndexController extends Angel_Controller_Action {
    private $app_id = 'wx4f812fb76adfa3ff';
    private $app_secret = '4450180e6fd9b8a88b79a2261a1da6ae';
    private $access_token = '';

    protected $login_not_required = array(
        'index',
        'teacher-detail',
        'course',
        'course-detail',
        'my-index',
        'my-teach',
        'apply',
        'apply-history',
        'apply-success',
        'confirmation-order',
        'my-order',
        'order-detail',
        'my-lesson',
        'start-lesson',
        'end-lesson',
        'lesson-success',
        'pay-success',
        'pay-fail',
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
        'menu-delete',
        'order-pay',
        'order-notify',
        'change-photo'
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

    public function payFailAction() {
        $orderModel = $this->getModel('order');

        $id = $this->getParam('id');

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

            $customerModel->saveWinXinUser($id, $openid, $nickname, $headimgurl);

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
            $this->view->usertype = $result->usertype;
        }
        else {
            exit("注册或登陆失败,请重试!");
        }
    }

    public function regUserAction() {
        $customerModel = $this->getModel('customer');

        $id = $this->getParam('id');

        $customer = $customerModel->getById($id);
//        echo ($customer->is_reg); exit;
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

    public function myTeachAction() {
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

        $today = date("Y-m-d");

        $paginator = $orderModel->getBy(false, array('delete'=>0, 'customer.$id'=>new MongoId($id)));//, 'rundate'=>$today

        $this->view->count = count($paginator);
        $this->view->order_list = $paginator;
        $this->view->user_id = $id;
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

    public function orderPayAction() {
        $orderModel = $this->getModel('order');

        $id = $this->getParam('id');

        if ($id) {
            $order = $orderModel->getById($id);

            $this->view->model = $order;
        }
    }

    public function orderNotifyAction() {
        $order_id = $this->getParam('id');

        $this->view->order_id = $order_id;
    }

    /***************************************************************
     * 用户处理
     *
     * *************************************************************/

    public function changePhotoAction() {
        $customerModel = $this->getModel('customer');

        $id = $this->getParam('id');

        if ($this->request->isPost()) {
            $headPic = "";

            if(is_uploaded_file($_FILES['upload-head-pic']['tmp_name'])) {
                $tmp_headPic_filename = '/tmp/'. $_FILES['upload-head-pic']['name'];
                $tmp_headPic_path = $_FILES['upload-head-pic']['tmp_name'];

                move_uploaded_file($tmp_headPic_path, $tmp_headPic_filename);

                $img_head_pic = file_get_contents($tmp_headPic_filename);
                $enHeadPic = base64_encode($img_head_pic);

                $headPic = $this->saveHeadPic($enHeadPic);

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

            $result = $customerModel->saveHeadPic($id, $headPic);

            if (!$result) {
                $this->_redirect($this->view->url(array(), 'manage-result') . '?error=头像上传失败!'); exit;
            }
            else {
                header("location:/me/". $id);
            }
        }
        else {
            $result = $customerModel->getById($id);

            $this->view->model = $result;
        }
    }

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
        $menuPostString = '{ "button":[{ "type":"view", "name":"预约老师",  "url":"http://www.yujiaqu.com" }] }';

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

    public function saveHeadPic($file) {
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
            return $result_name;
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

        $s = imagerotate($s,90,0);                  //图片旋转90度

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
