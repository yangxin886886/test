<?php
namespace app\admin\controller;
use think\Validate;
use think\Controller;
class Test extends Controller {
    public function index(){
        return $this->fetch();
    }
    public function test(){
        $s = "[\"2\",\"1\"]";
        $s = json_decode($s);
        dump($s);

        $a = require(ADMIN_MODULE . '/area/area.php');
        dump($a);

        unset($a[0]);unset($a[1]);
        dump($a);

//        foreach ($s as $k=>$v){
//            $v = intval($v);
//            foreach ($v ){
//
//            }
//        }

    }
}