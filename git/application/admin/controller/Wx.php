<?php
namespace app\admin\controller;
class Wx extends Base{

    public function index(){
        $data = db('wx_public')->order('id','desc')->find();
        $this->assign('data',$data);
        return $this->fetch();
    }

    /**
     * 设置公众号信息
    */
    public function setPublicNumber(){
        $save['name'] = input('name');
        $save['keys'] = input('keys');
        $save['qrcode'] = input('qrcode');
        $save['user_id'] = $this->userInfo['id'];
        $save['add_time'] = time();

        $res = db('wx_public')->insert($save);
        $this->saveAjaxReturn($res);
    }
}