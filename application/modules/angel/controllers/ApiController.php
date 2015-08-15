<?php

class Angel_ApiController extends Angel_Controller_Action
{
    protected $login_not_required = array(
       'customer-list'
    );
    protected $SEPARATOR = ';';

    public function init()
    {
        parent::init();

        $this->_helper->layout->setLayout('manage');
    }

    public function customerListAction() {
        $customerModel = $this->getModel('customer');

        $page = $this->getParam('page');
        $nickname = $this->getParam('nickname');

        if (!$page) {
            $page = 1;
        }

        if ($nickname) {
//            $this->_helper->json(array('data' => $nickname, 'code' => 0));
            $param = new MongoRegex("/" . $nickname . "/i");

            $paginator = $customerModel->getBy(true, array("usertype"=> "1", "nickname"=>$param));
            $paginator->setItemCountPerPage($this->bootstrap_options['default_page_size']);
            $paginator->setCurrentPageNumber($page);
        }
        else {
            $paginator = $customerModel->getBy(true, array("usertype"=> "1"));
            $paginator->setItemCountPerPage($this->bootstrap_options['default_page_size']);
            $paginator->setCurrentPageNumber($page);
        }

        if ($paginator) {
            $current_page_no = $paginator->getCurrentPageNumber();
            $page_count = $paginator->count();
//            $this->_helper->json(array('data' => $page_count, 'code' => 0)); exit;
            $customerList = array();

            foreach ($paginator as $p) {
                $customerList[] = array("id"=>$p->id, "openid"=>$p->openid, "nickname"=>$p->nickname, "sex"=>$p->sex, "city"=>$p->city, "user_score"=>$p->user_score);
            }

            $this->_helper->json(array('data' => $customerList, "current_page_no"=>$current_page_no, "page_count"=>$page_count, 'code' => 200));
        }
        else {
            $this->_helper->json(array('data' => "读取失败!", 'code' => 0));
        }
    }
}