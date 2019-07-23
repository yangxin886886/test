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
   public function ajaxReturn($data = [],$code = 200,  $msg = '成功', $success = true){
       exit(json_encode(['code'=>$code,'data'=>$data,'msg'=>$msg,'success'=>$success]));
   }
}