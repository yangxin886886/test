<?php
namespace app\admin\controller;
use think\Validate;
use think\Controller;
class Test extends Controller {
    public function index(){
      echo  $_SERVER['HTTP_HOST'];
    }


}