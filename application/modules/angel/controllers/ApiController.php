<?php

class Angel_ApiController extends Angel_Controller_Action {
    protected $login_not_required = array(
       'customer-list',
        'get-teacher',
        'get-teachername',
        'sms-valid',
        'add-order',
        'confirm-order',
        'set-value',
        'remove-order',
        'get-order',
        'set-day',
        'get-busy',
        'is-busy',
        'join-lesson',
        'rating-order',
        'teacher-apply',
        'set-range'
    );
    protected $SEPARATOR = ';';

    public function init() {
        parent::init();

        $this->_helper->layout->setLayout('manage');
    }

    public function getTeachernameAction() {
        $teacherModel = $this->getModel('teacher');

        $search = $this->getParam("search");

//        $this->_helper->json(array('data' => $search, 'code' => 0)); exit;
        $condition = false;

        if (!$search) {
            $this->_helper->json(array('data' => "没有得到老师名字条件!", 'code' => 0)); exit;
        }

        $param = new MongoRegex("/" . $search . "/i");

        $condition[] = array('usertype' => '2', 'delete' => 0, "name"=>$param);

        $paginator = $teacherModel->getBy(false, $condition);

        if ($paginator) {
            $teacherList = array();

            foreach ($paginator as $p) {
                $path = "";
                $category_text = "";

                if ($p->photo && count($p->photo)) {
                    try {
                        if ($p->photo[0]->name) {
                            $path = $this->bootstrap_options['image.photo_path'];

                            $path = $this->view->photoImage($p->photo[0]->name . $p->photo[0]->type, 'main');
                        }
                    } catch (Doctrine\ODM\MongoDB\DocumentNotFoundException $e) {
                        // 图片被删除的情况
                    }
                }
//                $this->_helper->json(array('data' => count($p->category), 'code' => 0));
                if (!$p->category && count($p->category)) {
                    foreach ($p->category as $category) {
                        try {
                            if ($category_text != "") {
                                $category_text = $category_text . " / ";
                            }

                            $category_text = $category_text . $category->name;
                        }
                        catch (Doctrine\ODM\MongoDB\DocumentNotFoundException $e) {

                        }
                    }
                }

                $teacherList[] = array("id"=>$p->id, "openid"=>$p->openid, "nickname"=>$p->nickname, "sex"=>$p->sex, "head_pic"=>$p->head_pic, "name"=>$p->name, "score"=>$p->teacher_score, "photo"=>$path, "price"=>$p->price, "category"=>$category_text, "range"=>$range, "tmp_range"=>$tmp_range);
            }

            $this->_helper->json(array('data' => $teacherList, "current_page_no"=>1, "page_count"=>1, 'code' => 200));
        }
        else {
            $this->_helper->json(array('data' => "读取失败!", 'code' => 0));
        }
    }

    public function getTeacherAction() {
        $teacherModel = $this->getModel('teacher');

        $search = $this->getParam("search");
        $sort = $this->getParam('sort');
        $page = $this->getParam('page');
//        $this->_helper->json(array('data' => $search, 'code' => 0)); exit;
        $condition = false;

        if (!$search) {
            $this->_helper->json(array('data' => "坐标刷新失败!", 'code' => 0)); exit;
        }

        $tmp_pos = explode(";", $search);

        $lat = explode(":", $tmp_pos[0])[1];
        $lng = explode(":", $tmp_pos[1])[1];
        $lesson_id = false;

        if (count($tmp_pos) > 2) {
            $lesson_id = explode(":", $tmp_pos[2])[1];
        }

        if (!$sort) {
            $sort = false;
        }

        if ($lesson_id) {
            $condition[] = array('usertype' => '2', 'lesson.$id'=>new MongoId($lesson_id), 'delete' => 0);
        }
        else {
            $condition[] = array('usertype' => '2', 'delete' => 0);
        }

        $paginator = $teacherModel->getByAndSort(true, $condition, $sort);
        $paginator->setItemCountPerPage(150);
        $paginator->setCurrentPageNumber(1);



        if ($paginator) {
            $current_page_no = $paginator->getCurrentPageNumber();
            $page_count = $paginator->count();

            $tmp_teacherList = array();
            $teacherList = array();
//            $this->_helper->json(array('data' => count($paginator), 'code' => 0));
            foreach ($paginator as $p) {
//                $this->_helper->json(array('data' => $p->name, 'code' => 0));


                if (!$p->lat) {
                    $range = 0;
                    $tmp_range = 0;
                }
                else {
                    $range = $this->getDistance($lat, $lng, $p->lat, $p->lng) * 1000;
                    $tmp_range = $p->range;
                }


//                if ($range > $tmp_range) {
//                    continue;
//                }

                $path = "";
                $category_text = "";

                if ($p->photo && count($p->photo)) {
                    try {
                        if ($p->photo[0]->name) {
                            $path = $this->bootstrap_options['image.photo_path'];

                            $path = $this->view->photoImage($p->photo[0]->name . $p->photo[0]->type, 'main');
                        }
                    } catch (Doctrine\ODM\MongoDB\DocumentNotFoundException $e) {
                        // 图片被删除的情况
                    }
                }
//                $this->_helper->json(array('data' => count($p->category), 'code' => 0));
                if (!$p->category && count($p->category)) {
                    foreach ($p->category as $category) {
                        try {
                            if ($category_text != "") {
                                $category_text = $category_text . " / ";
                            }

                            $category_text = $category_text . $category->name;
                        }
                        catch (Doctrine\ODM\MongoDB\DocumentNotFoundException $e) {

                        }
                    }
                }

                if (!$p->lat) {
                    $tmp_teacherList[] = array("id"=>$p->id, "openid"=>$p->openid, "nickname"=>$p->nickname, "sex"=>$p->sex, "head_pic"=>$p->head_pic, "name"=>$p->name, "score"=>$p->teacher_score, "photo"=>$path, "price"=>$p->price, "category"=>$category_text, "range"=>$range, "tmp_range"=>$tmp_range);
                }
                else {
                    $teacherList[] = array("id"=>$p->id, "openid"=>$p->openid, "nickname"=>$p->nickname, "sex"=>$p->sex, "head_pic"=>$p->head_pic, "name"=>$p->name, "score"=>$p->teacher_score, "photo"=>$path, "price"=>$p->price, "category"=>$category_text, "range"=>$range, "tmp_range"=>$tmp_range);
                }

            }

            $len = count($teacherList);

            for($i = 1; $i < $len; $i++) {//最多做n-1趟排序
                $flag = false;    //本趟排序开始前，交换标志应为假

                for ($j = $len - 1; $j >= $i; $j--) {
                    if($teacherList[$j]['range'] < $teacherList[$j - 1]['range']) {//交换记录
                        //如果是从大到小的话，只要在这里的判断改成if($arr[$j]>$arr[$j-1])就可以了
                        $x = $teacherList[$j];
                        $teacherList[$j] = $teacherList[$j - 1];
                        $teacherList[$j - 1] = $x;
                        $flag = true;//发生了交换，故将交换标志置为真
                    }
                }

                if(!$flag)//本趟排序未发生交换，提前终止算法
                    break;
            }

            //将没有服务坐标的老师放到最后
            foreach ($tmp_teacherList as $tmp_t) {
                $teacherList[] = $tmp_t;
            }

            $this->_helper->json(array('data' => $teacherList, "current_page_no"=>$current_page_no, "page_count"=>$page_count, 'code' => 200));
        }
        else {
            $this->_helper->json(array('data' => "读取失败!", 'code' => 0));
        }
    }

    public function consumeListAction() {
        $customerModel = $this->getModel('customer');
        $orderModel = $this->getModel('order');
        $couponModel = $this->getModel('coupon');

        $page = $this->getParam('page');
        $nickname = $this->getParam('nickname');

        if (!$page) {
            $page = 1;
        }

        if ($nickname) {
            $param = new MongoRegex("/" . $nickname . "/i");

            $paginator = $customerModel->getBy(true, array("nickname"=>$param));

        }
        else {
            $paginator = $customerModel->getAll(true);
        }

        $paginator->setItemCountPerPage($this->bootstrap_options['default_page_size']);//
        $paginator->setCurrentPageNumber($page);

        if ($paginator) {
            $current_page_no = $paginator->getCurrentPageNumber();
            $page_count = $paginator->count();

            $customerList = array();

            foreach ($paginator as $p) {
                $tmp_order = $orderModel->getBy(false, array('customer.id'=>new MongoId($p->id)));

                $order_count = count($tmp_order);
                $tmp_amount = 0;

                foreach ($tmp_order as $tmp_o) {
                    if ($tmp_o->state < 20)
                        continue;

                    $tmp_amount = $tmp_o->pay_amount + $tmp_amount;
                }

                $customerList[] = array("id"=>$p->id, "nickname"=>$p->nickname, "name"=>$p->name, "order_count"=>$order_count, "amount"=>$tmp_amount);
            }

            $len = count($customerList);

            for($i = 1; $i < $len; $i++) {//最多做n-1趟排序
                $flag = false;    //本趟排序开始前，交换标志应为假

                for ($j = $len - 1; $j >= $i; $j--) {
                    if($customerList[$j]['amount'] > $customerList[$j - 1]['amount']) {//交换记录
                        //如果是从大到小的话，只要在这里的判断改成if($arr[$j]>$arr[$j-1])就可以了
                        $x = $customerList[$j];
                        $customerList[$j] = $customerList[$j - 1];
                        $customerList[$j - 1] = $x;
                        $flag = true;//发生了交换，故将交换标志置为真
                    }
                }

                if(!$flag)//本趟排序未发生交换，提前终止算法
                    break;
            }

            $this->_helper->json(array('data' => $customerList, "current_page_no"=>$current_page_no, "page_count"=>$page_count, 'code' => 200));
        }
        else {
            $this->_helper->json(array('data' => "读取失败!", 'code' => 0));
        }
    }

    public function getLessonAction() {

    }

    public function customerListAction() {
        $customerModel = $this->getModel('customer');

        $page = $this->getParam('page');
        $nickname = $this->getParam('nickname');

        if (!$page) {
            $page = 1;
        }

        if ($nickname) {
            $param = new MongoRegex("/" . $nickname . "/i");

            $paginator = $customerModel->getBy(true, array("usertype"=> "1", "nickname"=>$param));

        }
        else {
            $paginator = $customerModel->getBy(true, array("usertype"=> "1"));
        }

        $paginator->setItemCountPerPage($this->bootstrap_options['default_page_size']);//
        $paginator->setCurrentPageNumber($page);

        if ($paginator) {
            $current_page_no = $paginator->getCurrentPageNumber();
            $page_count = $paginator->count();

            $customerList = array();

            foreach ($paginator as $p) {
                $customerList[] = array("id"=>$p->id, "openid"=>$p->openid, "nickname"=>$p->nickname, "sex"=>$p->sex, "city"=>$p->city, "headimgurl"=>$p->headimgurl, "user_score"=>$p->user_score);
            }

            $this->_helper->json(array('data' => $customerList, "current_page_no"=>$current_page_no, "page_count"=>$page_count, 'code' => 200));
        }
        else {
            $this->_helper->json(array('data' => "读取失败!", 'code' => 0));
        }
    }

    public function teacherApplyAction() {
        $regionModel = $this->getModel('region');
        $categoryModel = $this->getModel('category');
        $customerModel = $this->getModel('customer');

        $id = $this->getParam('teacher_id');
        $sex = $this->getParam('sex');
        $birthday = $this->getParam('birthday');
        $code = $this->getParam('code');
        $email = $this->getParam('email');
        $wechat = $this->getParam('wechat');
        $region_id = $this->getParam('region_id');
        $category_id = $this->getParam('category_id');
        $bank = $this->getParam('bank');
        $bank_code = $this->getParam('bank_code');
        $description = $this->getParam('description');
        $location = $this->getParam('location');

        $cer = $this->getParam('cer');
        $show = $this->getParam('show');

        $region = array();

        if ($region_id) {
            $tmp_region_id = explode(",", $region_id);

            $tmp_region = $regionModel->getByIds($tmp_region_id);

            foreach ($tmp_region as $r) {
                $region[] = $r;
            }
        }
//        $this->_helper->json(array('data' => "保存失败!", 'code' => 0));
        $category = array();

        if ($category_id) {
            $tmp_category_id = explode(",", $category_id);

            $tmp_category = $categoryModel->getByIds($tmp_category_id);

            foreach ($tmp_category as $c) {
                $category[] = $c;
            }
        }

        $customer = $customerModel->getById($id);

        if ($cer) {
//            $this->_helper->json(array('data' => $cer, 'code' => 200)); exit;
            $certificate_index = explode(',', $cer);
            $certificate = array();

            foreach ($certificate_index as $c_id) {
                foreach ($customer->certificate as $c) {
                    if ($c->id == $c_id) {
                        $certificate[] = $c;

                        break;
                    }
                }
            }
        }

        if ($show) {
            $show_index = explode(',', $show);
            $show_photo = array();

            foreach ($show_index as $p_id) {
                foreach ($customer->photo as $p) {
                    if ($p->id == $p_id) {
                        $show_photo[] = $p;

                        break;
                    }
                }
            }
        }

        $result = $customerModel->saveApplyUser($id, $sex, $birthday, $code, $email,  $wechat, $region, $category, $bank, $bank_code, $description, $location, $certificate, $show_photo);

        if ($result) {
            $this->_helper->json(array('data' => "保存成功!", 'code' => 200));
        }
        else {
            $this->_helper->json(array('data' => "保存失败!", 'code' => 0));
        }
    }

    /********************************************************************
     * 设置老师服务范围
     *
     * *************************************************************/
    public function setRangeAction() {
        $teacherModel = $this->getModel('teacher');

        $id = $this->getParam('teacher_id');
        $range = $this->getParam('range');
        $cell = $this->getParam('cell');
        $lat = $this->getParam('lat');
        $lng = $this->getParam('lng');

        $result = $teacherModel->setTeacherRanage($id, $cell, $range, $lat, $lng);

        if ($result) {
            $this->_helper->json(array('data' => "保存成功!!", 'code' => 200));
        }
        else {
            $this->_helper->json(array('data' => "保存失败!", 'code' => 0));
        }
    }

    /***************************************************************************************************
     * 订单处理
     *
     * *************************************************************************************************/
    public function checkOrder($teacher_id, $rundate, $hour) {
        $orderModel = $this->getModel('order');
        $workModel = $this->getModel('work');
        $result = "sucess";

        if ($hour > 3) {
            $result = "单次预约不能超过3小时,选少点试试";

            return $result;
        }

        $work_hour = 0;

        $work = $workModel->getAll(false);

        foreach ($work as $w) {
            $work_hour  = $work_hour + $w->hour;
        }

        $condition[] = array('teacher.id' => new MongoId($teacher_id), 'rundate'=>$rundate);
//        $this->_helper->json(array('data' => $condition, 'code' => 0)); exit;
        $orders = $orderModel->getBy(false, $condition);

        $all_hour = 0;

        foreach ($orders as $o) {
            if ($o->state > 10) {
                $all_hour = $all_hour + $o->hour;
            }
        }

        if ($all_hour >= $work_hour) {
            $result = $rundate ."预约已满, 换一天试试";

            return $result;
        }

        return $result;
    }

    public function addOrderAction() {
        $teacherModel = $this->getModel('teacher');
        $customerModel = $this->getModel('customer');
        $orderModel = $this->getModel('order');

        $teacher_id = $this->getParam('teacher_id');
        $customer_id = $this->getParam('customer_id');
        $rundate = $this->getParam('rundate');
        $time = $this->getParam('time');
        $hour = $this->getParam('hour');
        $price = $this->getParam('price');
        $amount = $this->getParam('amount');

        $msg = $this->checkOrder($teacher_id, $rundate, $hour);

        if ($msg != "sucess") {
            $this->_helper->json(array('data' => $msg, 'code' => 0)); exit;
        }

        $teacher = $teacherModel->getById($teacher_id);

        if (!$teacher) {
            $this->_helper->json(array('data' => "导师信息读取错误!", 'code' => 0)); exit;
        }

        $customer = $customerModel->getById($customer_id);

        if (!$customer) {
            $this->_helper->json(array('data' => "学员信息读取错误!", 'code' => 0)); exit;
        }

        $result = $orderModel->addOrder($rundate, $time, $hour, $customer, $teacher, $price, $amount);

        if (!$result) {
            $this->_helper->json(array('data' => "订单信息保存错误!", 'code' => 0)); exit;
        }

        $this->_helper->json(array('data' => $result, 'code' => 200));
    }

    public function confirmOrderAction() {
        $orderModel = $this->getModel('order');
        $couponModel = $this->getModel('coupon');

        $id = $this->getParam('id');
        $rundate = $this->getParam('rundate');
        $time = $this->getParam('time');
        $hour = $this->getParam('hour');
        $price = $this->getParam('price');
        $amount = $this->getParam('amount');
        $pay_amount = $this->getParam('pay_amount');
        $customer_name = $this->getParam('customer_name');
        $phone = $this->getParam('phone');
        $address = $this->getParam('address');
        $address_detail = $this->getParam('address_detail');
        $lat = $this->getParam('lat');
        $lng = $this->getParam('lng');
        $coupon_id = $this->getParam('coupon_id');

        $order = $orderModel->getById($id);

        $msg = $this->checkOrder($order->teacher->id, $rundate, $hour);

        if ($msg != "sucess") {
            $this->_helper->json(array('data' => $msg, 'code' => 0)); exit;
        }

        $range = $this->getDistance($lat, $lng, $order->teacher->lat, $order->teacher->lng) * 1000;
        $tmp_range = $order->teacher->range;

        if ($range > $tmp_range) {
            $this->_helper->json(array('data' => "授课超出老师服务范围,请检查后重新选择!", 'code' => 0)); exit;;
        }

        if ($order) {
            $result = $orderModel->saveOrder($id, $rundate, $time, $hour, $order->customer, $order->teacher, 10, $order->user_score, $order->user_appraise, $order->teacher_score, $order->teacher_appraise, $price, $amount, $pay_amount, $customer_name, $phone, $address, $address_detail);

            $result = $orderModel->uploadPos($id, $lat, $lng);

            if ($coupon_id) {
                $coupon = $couponModel->getById($coupon_id);

                $orderModel->saveCoupon($id, $coupon);
            }

            if ($result) {
                $this->_helper->json(array('data' => "订单保存成功!", 'code' => 200));
            }
            else {
                $this->_helper->json(array('data' => "订单保存失败!!", 'code' => 0)); exit;
            }
        }
        else {
            $this->_helper->json(array('data' => "订单信息没有找到!", 'code' => 0)); exit;
        }
    }

    public function removeOrderAction() {
        $orderModel = $this->getModel('order');

        $id = $this->getParam('id');

        $order = $orderModel->getById($id);

        try {
            $orderModel->removeOrder($id);

            $this->_helper->json(array('data' => $order->customer->id, 'code' => 200));
        } catch (Exception $e) {
            $this->_helper->json(array('data' => $e->getMessage(), 'code' => 0));
        }
    }

    public  function getOrderAction() {
        $orderModel = $this->getModel('order');
        $workModel = $this->getModel('work');

        $teacher_id = $this->getParam('teacher_id');
        $rundate = $this->getParam('rundate');

        $tmp_work_time = $workModel->getAll(false);

        $work_time = 0;

        foreach ($tmp_work_time as $t) {
            $work_time = $t;

            break;
        }

        if (!$teacher_id) {
            $this->_helper->json(array('data' => "老师信息获取错误!", 'code' => 0)); exit;
        }

        if (!$rundate) {
            $this->_helper->json(array('data' => "日期获取错误!!", 'code' => 0)); exit;
        }

        $condition[] = array('teacher.id' => new MongoId($teacher_id), 'rundate'=>$rundate);

        $tmp_orders = $orderModel->getBy(false, $condition);

        $orders = array();
        $tmp1 = 0;
        $tmp2 = 0;

        foreach ($tmp_orders as $o) {
            $tmp_time = explode('|', $o->time);

            $tmp1 = intval(explode('-', $tmp_time[1])[1]);
            $tmp2 = intval(explode('-', $tmp_time[1])[0]);

            if ($tmp1) {
                $time = $tmp1 - $tmp2 + 1;
            }
            else {
                $time = 1;
            }

            $orders[] = array("id"=>$o->id, "rundate"=>$o->rundate, "time"=>$o->time, "user_time"=>$time, "state"=>$o->state, "customer_id"=> $o->customer->id, "teacher_id"=> $o->teacher->id, "created_date"=>date_format($o->created_at, 'Y-m-d H:i:s'), "update_at"=>date_format($o->updated_at, 'Y-m-d H:i:s'));
        }

        $this->_helper->json(array('data' => $orders, 'hour'=>$work_time->hour, 'time1'=>$tmp1, 'time2'=>$tmp2, 'code' => 200));
    }

    public function ratingOrderAction() {
        $orderModel = $this->getModel('order');
        $teacherModel = $this->getModel('teacher');

        $id = $this->getParam('id');
        $time_score = $this->getParam('time_score');
        $content_score = $this->getParam('content_score');
        $way_score = $this->getParam('way_score');
        $teacher_appraise = $this->getParam('teacher_appraise');

        $tmp_score = (floatval($time_score) + floatval($content_score) + floatval($way_score)) / 3.0;

        $tmp_score = number_format($tmp_score, 1);

        $result = $orderModel->submitRating($id, $time_score, $content_score, $way_score, $tmp_score, $teacher_appraise);

        if ($result) {
            $order = $orderModel->getById($id);

            $teacher_id = $order->teacher->id;

            $teacher = $teacherModel->getById($teacher_id);

            $teacher_score = $teacher->teacher_score;

            if (!$teacher_score) {
                $teacher_score = $tmp_score;
            }
            else {
                $teacher_score = (floatval($teacher_score) + floatval($tmp_score)) / 2.0;

                $teacher_score = number_format($teacher_score, 1);
            }

            $result = $teacherModel->submitRating($teacher_id, $teacher_score);

            if ($result) {
                $this->_helper->json(array('data' => "评分成功!", 'code' => 200));
            }
            else {
                $this->_helper->json(array('data' => "老师评分更新失败!", 'code' => 0));
            }
        }
        else {
            $this->_helper->json(array('data' => "订单评分更新失败!", 'code' => 0));
        }
    }

    /********************************************************************************
     * 短信处理部分
     *
     * ******************************************************************************/
    public function smsValidAction() {
        $target = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";

        $phone = $this->getParam('phone');

        if (!$phone) {
            $this->_helper->json(array('data' => "没有获取到手机号码!", 'code' => 0)); exit;
        }

        $mobile_code = $this->random(4,1);

        $post_data = "account=cf_yujiaqu&password=yujiaqu.com&mobile=". $phone ."&content=".rawurlencode("您的验证码是：".$mobile_code."。请不要把验证码泄露给其他人。");
        header("Content-type:text/html; charset=UTF-8");
        //密码可以使用明文密码或使用32位MD5加密
        $gets =  $this->Post($post_data, $target);//$this->xml_to_array();

        $this->_helper->json(array('data' => $mobile_code, 'code' => 200));
    }

    /******************************************************************************
     * 工具方法
     *
     * *****************************************************************************/

    public function joinLessonAction() {
        $teacherModel = $this->getModel('teacher');
        $lessonModel = $this->getModel('lesson');

        $teacher_id = $this->getParam('teacher_id');
        $lesson_id = $this->getParam('lesson_id');
        $opt = $this->getParam('opt');

        $teacher = $teacherModel->getById($teacher_id);
        $lessons = array();

        if ($opt == 1) {
            $lesson = $lessonModel->getById($lesson_id);

            foreach ($teacher->lesson as $l) {
                $lessons[] = $l;
            }

            $lessons[] = $lesson;
        }
        else {
            foreach ($teacher->lesson as $l) {
                if ($l->id == $lesson_id) {
                    continue;
                }

                $lessons[] = $l;
            }
        }

        $result = $teacherModel->modifyLesson($teacher_id, $lessons);

        if ($result) {
            if ($opt == 1) {
                $this->_helper->json(array('data' => "加入课程成功!", 'code' => 200));
            }
           else {
               $this->_helper->json(array('data' => "退出课程成功!", 'code' => 200));
           }
        }
        else {
            if ($opt == 1) {
                $this->_helper->json(array('data' => "加入课程失败!", 'code' => 0));
            }
            else {
                $this->_helper->json(array('data' => "退出课程失败!", 'code' => 0));
            }
        }
    }

    public function setDayAction() {
        $calendarModel = $this->getModel('calendar');
        $teacherModel = $this->getModel('teacher');

        $teacher_id = $this->getParam('teacher_id');
        $tmp_date = $this->getParam('date');
        $opt = $this->getParam('opt');
        $result = true;

        $dates = explode(",", $tmp_date);
//        $this->_helper->json(array('data' => $opt, 'code' => 0)); exit;
        if ($opt == "0") {
//            $this->_helper->json(array('data' => $dates, 'code' => 0)); exit;
            foreach ($dates as $d) {
                $conditions = array('teacher.$id'=>new MongoId($teacher_id), 'busy_date'=>$d);
//                $this->_helper->json(array('data' => $teacher_id .'|'. $d, 'code' => 0)); exit;
                $busy_date = $calendarModel->getOneBy($conditions);

                $result = $calendarModel->remove($busy_date->id);

                if (!$result) {
                    break;
                }
            }
        }
        else {
//            $this->_helper->json(array('data' => "2", 'code' => 0)); exit;
            foreach ($dates as $d) {
                $teacher = $teacherModel->getById($teacher_id);

                $result = $calendarModel->addCalendar($d, $teacher);

                if (!$result) {
                    break;
                }
            }
        }

        if ($result) {
            $this->_helper->json(array('data' => "设置成功!", 'code' => 200)); exit;
        }
        else {
            $this->_helper->json(array('data' => "设置失败!", 'code' => 0)); exit;
        }
    }

    public function getBusyAction() {
        $calendarModel = $this->getModel('calendar');

        $teacher_id = $this->getParam('teacher_id');

        if (!$teacher_id) {
            $this->_helper->json(array('data' => "没有获取到老师信息!", 'code' => 0)); exit;
        }

        $conditions = array('teacher.$id'=>new MongoId($teacher_id));

        $result = $calendarModel->getBy(false, $conditions);

        if ($result) {
            $calendar = array();

            foreach ($result as $r) {
                $calendar[] = array("busy_date"=>$r->busy_date);
            }

            $this->_helper->json(array('data' => $calendar, 'code' => 200));
        }
        else {
            $this->_helper->json(array('data' => "获取失败!", 'code' => 0));
        }
    }

    public function isBusyAction() {
        $calendarModel = $this->getModel('calendar');

        $teacher_id = $this->getParam('teacher_id');
        $date = $this->getParam('date');

        if (!$teacher_id) {
            $this->_helper->json(array('data' => "没有获取到老师信息!", 'code' => 0)); exit;
        }

        if (!$date) {
            $this->_helper->json(array('data' => "没有获取判断的日期!", 'code' => 0)); exit;
        }

        $conditions = array('teacher.$id'=>new MongoId($teacher_id), 'busy_date'=>$date);

        $result = $calendarModel->getOneBy($conditions);

        if ($result) {
            $this->_helper->json(array('data' => "老师那天很忙!", 'code' => 0));
        }
        else {
            $this->_helper->json(array('data' => "可以预约!", 'code' => 200));
        }
    }

    public function setValueAction() {
        $regionModel = $this->getModel('region');
        $categoryModel = $this->getModel('category');

        $id = $this->getParam('id');
        $model_name = $this->getParam('model');
        $key = $this->getParam('key');
        $value = $this->getParam('value');

        if (!$model_name) {
            $this->_helper->json(array('data' => "model类没有找到", 'code' => 0)); exit;
        }

        $model = $this->getModel($model_name);

        if (!$model) {
            $this->_helper->json(array('data' => "model类没有找到", 'code' => 0)); exit;
        }

        if ($key == "region") {
            $return_msg = "";
            $regions = array();

            if ($value) {
                $regions_id = explode(",", $value);

                $tmp_regions = $regionModel->getByIds($regions_id);

                foreach ($tmp_regions as $r) {
                    $regions[] = $r;

                    if ($return_msg != "") {
                        $return_msg = $return_msg . " / ";
                    }

                    $return_msg = $return_msg . $r->name;
                }
            }

            $data = array($key=>$regions);

            $model->save($id, $data, $model_name, $model_name ."异常: 没有找到保存的数据!");

            $this->_helper->json(array('data' => $return_msg, 'code' => 200)); exit;
        }

        if ($key == "category") {
            $return_msg = "";
            $categorys = array();

            if ($value) {
                $categorys_id = explode(",", $value);

                $tmp_category = $categoryModel->getByIds($categorys_id);

                foreach ($tmp_category as $r) {
                    $categorys[] = $r;

                    if ($return_msg != "") {
                        $return_msg = $return_msg . " / ";
                    }

                    $return_msg = $return_msg . $r->name;
                }
            }


            $data = array($key=>$categorys);

            $model->save($id, $data, $model_name, $model_name ."异常: 没有找到保存的数据!");

            $this->_helper->json(array('data' => $return_msg, 'code' => 200)); exit;
        }

        $data = array($key=>$value);

        $model->save($id, $data, $model_name, $model_name ."异常: 没有找到保存的数据!");

        $this->_helper->json(array('data' => $value, 'code' => 200));
    }

    public function Post($curlPost,$url) {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        $return_str = curl_exec($curl);
        curl_close($curl);

        return $return_str;
    }

    public function random($length = 6 , $numeric = 0) {
        PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
        if($numeric) {
            $hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
        } else {
            $hash = '';
            $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghjkmnpqrstuvwxyz';
            $max = strlen($chars) - 1;
            for($i = 0; $i < $length; $i++) {
                $hash .= $chars[mt_rand(0, $max)];
            }
        }
        return $hash;
    }

    private function rad($d)  {
        return $d * 3.1415926535898 / 180.0;
    }

    private function getDistance($lat1, $lng1, $lat2, $lng2) {
        $EARTH_RADIUS = 6378.137;
        $radLat1 = $this->rad($lat1);
        //echo $radLat1;
        $radLat2 = $this->rad($lat2);
        $a = $radLat1 - $radLat2;
        $b = $this->rad($lng1) - $this->rad($lng2);
        $s = 2 * asin(sqrt(pow(sin($a/2),2) +
                cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)));
        $s = $s *$EARTH_RADIUS;
        $s = round($s * 10000) / 10000;
        return $s;
    }

    public function savePic($file) {
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
            return $tmp_name;
        }
    }

    function cutImg($img, $new_path, $w,$h){        //要裁减的图片，宽度，高度
        $s = imagecreatefromjpeg($img);            //这里以jpg图片为例，其他图片要修改这个方法名称，可以上网参考（就是后面那个后缀名不一样)

        $s = imagerotate($s,-90,0);                  //图片旋转90度

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