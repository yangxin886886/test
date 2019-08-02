<?php
namespace app\admin\controller;
use think\Validate;
use think\Controller;
class Test extends Controller {
    public function index(){
        return $this->fetch();
    }
    public function test(){
        $a = json_decode('["",""]',true);
        dump($a);
        if(!$a){
            echo 123;
        }else{
            echo 321;
        }

    }
}