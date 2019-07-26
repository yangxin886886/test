<?php
namespace app\admin\controller;
class Shape extends Base{
    public function index(){
        return $this->fetch();
    }

    public function getShapeList(){
        $data = db('shape')->select();
        $this->ajaxReturn($data);
    }
}