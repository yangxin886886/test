<?php
namespace app\api\controller;
use think\Controller;
use think\Request;
use think\Db;

class Base extends Controller {
    public function __construct()
    {
       parent::__construct();
    }

    /**
     * 增加或更新
     * $code 错误码
     */
    public function saveAjaxReturn($res,$code = 401){
        return $res > 0 ? $this->ajaxReturn() : $this->ajaxReturn([],$code,'失败',false);
    }

    public function ajaxReturn($data = [],$code = 200,  $msg = '成功', $success = true){
       exit(json_encode(['code'=>$code,'data'=>$data,'msg'=>$msg,'success'=>$success]));
    }
}