<?php
namespace app\admin\controller;
class Seat extends Base{

    //编辑座位页面
    public function editSeatView(){
        $activity = db('activity')->select();
        $this->assign('activity',$activity);
        return $this->fetch();
    }
}