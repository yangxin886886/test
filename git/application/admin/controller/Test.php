<?php
namespace app\admin\controller;
use think\Validate;
use think\Controller;
class Test extends Controller {
    public function index(){
        return $this->fetch();
    }
    public function test(){
        new  \app\admin\logic\Code(5,100,[['code'=>'ASF18']],'code');
    }
}