<?php

class Angel_Model_Message extends Angel_Model_AbstractModel {
    protected $_document_class = '\Documents\Message';

    //新增消息信息
    public function addMessage($name, $content, $url, $toUser, $fromUser, $msg_type) {
        $data = array('name' => $name,
            'content'=> $content,
            'url' => $url,
            'toUser' => $toUser,
            'fromUser'=> $fromUser,
            'msg_type' => $msg_type);

        $result = $this->add($data);

        return $result;
    }

    //保存消息信息
    public function saveMessage($id, $name, $content, $url, $toUser, $fromUser, $msg_type, $is_look) {
        $data = array('name' => $name,
            'content'=> $content,
            'url' => $url,
            'toUser' => $toUser,
            'fromUser' => $fromUser,
            'msg_type' => $msg_type,
            'is_look' => $is_look);

        $result = $this->save($id, $data);

        return $result;
    }
}
