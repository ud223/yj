<?php

class Angel_AdminController extends Angel_Controller_Action
{
    public function init()
    {
        parent::init();
        
        $this->_helper->layout->setLayout('admin');
    }
}